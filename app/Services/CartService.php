<?php
namespace App\Services;

use App\Models\CartItem;
use App\Models\Tire;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;

/**
 * A kosár kezeléséhez szükséges műveleteket foglalja össze.
 *
 * A bejelentkezett felhasználók kosara adatbázisban, a vendégfelhasználóké
 * pedig sessionben kerül tárolásra.
 */
class CartService
{
    /**
     * Hozzáad egy abroncsot a kosárhoz.
     *
     * Ha az abroncs már szerepel a kosárban, csak a mennyiség növekszik.
     */
    public function add(int $tireId, int $quantity): void
    {
        if (Auth::check()) {
            // Bejelentkezett felhasználónál a kosártételt az adatbázisban keressük.
            $userId = Auth::id();

            $cartItem = CartItem::where('user_id', $userId)
                                ->where('tire_id', $tireId)
                                ->first();

            if ($cartItem) {
                // Azonos abroncs esetén új tétel helyett a meglévő mennyisége növekszik.
                $cartItem->increment('quantity', $quantity);
            } else {
                CartItem::create([
                    'user_id'   => $userId,
                    'tire_id'   => $tireId,
                    'quantity'  => $quantity,
                ]);
            }
        } else {
            // A vendégkosár adatait a sessionben tároljuk, amíg nincs felhasználóhoz kötve.
            $cart = session('cart', []);

            if (isset($cart[$tireId])) {
                $cart[$tireId] += $quantity;
            } else {
                $cart[$tireId] = $quantity;
            }

            session(['cart' => $cart]);
        }
    }

    /**
     * Lekéri az aktuális kosár tételeit a kapcsolódó abroncsokkal együtt.
     *
     * Bejelentkezett felhasználónál az adatbázisból, vendég esetén a sessionből
     * állítja elő az egységesen visszaadott kosártétel-listát.
     */
    public function getCartItems(): Collection
    {
        if (Auth::check()) {
            // A kapcsolódó abroncs adatait előre betöltjük a nézet hatékony kiszolgálásához.
            return CartItem::with('user')->with('tire')
                            ->where('user_id', Auth::user()->id)
                            ->get();
        } else {
            // A session csak az abroncsok azonosítóját és mennyiségét tárolja.
            $cart = session('cart', []);

            $tires = Tire::with('brand')
                        ->whereIn('id', array_keys($cart))
                        ->get();

            $cartItems = [];
            foreach ($tires as $tire) {
                // A nézet egységes kezelése érdekében ideiglenes CartItem készül.
                $cartItem = new CartItem();
                $cartItem->tire = $tire;
                $cartItem->quantity = $cart[$tire->id];
                $cartItems[] = $cartItem;
            }

            return collect($cartItems);
        }
    }

    /**
     * Eltávolít egy teljes kosártételt az adatbázisból vagy a sessionből.
     */
    public function removeItem(int $tireId): void
    {
        if (Auth::check()) {
            // Csak az aktuális felhasználó adott abroncshoz tartozó tétele törölhető.
            CartItem::where('user_id', Auth::id())
                    ->where('tire_id', $tireId)
                    ->delete();
        } else {
            // Vendég esetén az abroncs azonosítója a session tömbjének kulcsa.
            session()->forget("cart.{$tireId}");
        }
    }

    /**
    * Egyesével növeli vagy csökkenti egy kosártétel mennyiségét.
     *
    * Ha a mennyiség elérné a nullát, a tétel törlődik az adatbázisból vagy
    * kikerül a sessionből.
     */
    public function quantityAdjust(int $tireId, string $direction): void
    {
        if (Auth::check()) {
            // A lekérdezés az aktuális felhasználó adott abroncshoz tartozó tételét célozza.
            $cartItem = CartItem::where('user_id', Auth::id())
                        ->where('tire_id', $tireId);

            if ($direction === 'up') {
                $cartItem->increment('quantity', 1);
            } elseif ($direction === 'down') {
                // Egy darabos tétel csökkentés helyett teljesen kikerül a kosárból.
                if ($cartItem->value('quantity') <= 1) {
                    $cartItem->delete();
                }
                $cartItem->decrement('quantity', 1);
            } 
        } else {
            // Vendégkosárnál a mennyiséget közvetlenül a session tömbjében módosítjuk.
            $cart = session('cart', []);
            
            if ($direction === 'up') {
                $cart[$tireId]++;
            } elseif ($direction === 'down') {
                if ($cart[$tireId] <= 1) {
                    unset($cart[$tireId]);
                } else {
                    $cart[$tireId]--;
                }
            }

            session(['cart' => $cart]);
        }
    }

    public function mergeSessionCartDatabase(): void {
        $sessionCart = session('cart', []);

        if (empty($sessionCart)) {
            return;
        }

        $userId = Auth::id();

        foreach ($sessionCart as $tireId => $quantity) {
            $cartItem = CartItem::firstOrNew([
                'user_id'   => $userId,
                'tire_id'   => $tireId,
            ]);

            $cartItem->quantity = ($cartItem->exists ? $cartItem->quantity : 0) + $quantity;
            $cartItem->save();
        }

        session()->forget('cart');
    }
}

?>