<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Tire;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Felhasználók (5 db)
        $users = User::factory(5)->create();

        // 2. Kategóriák
        $categories = collect([
            ['name' => 'Személyautó gumi', 'slug' => 'szemelyauto-gumi'],
            ['name' => 'SUV / 4x4 gumi', 'slug' => 'suv-4x4-gumi'],
            ['name' => 'Kistehergumi', 'slug' => 'kistehergumi'],
        ])->map(fn ($cat) => Category::create($cat));

        // 3. Márkák
        $brands = collect([
            ['name' => 'Michelin', 'logo_url' => 'https://via.placeholder.com/150?text=Michelin'],
            ['name' => 'Continental', 'logo_url' => 'https://via.placeholder.com/150?text=Continental'],
            ['name' => 'Bridgestone', 'logo_url' => 'https://via.placeholder.com/150?text=Bridgestone'],
            ['name' => 'Pirelli', 'logo_url' => 'https://via.placeholder.com/150?text=Pirelli'],
            ['name' => 'Hankook', 'logo_url' => 'https://via.placeholder.com/150?text=Hankook'],
        ])->map(fn ($brand) => Brand::create($brand));

        // 4. Gumik generálása (15 db random variáció)
        $widths = [185, 195, 205, 225, 245];
        $profiles = [55, 60, 65, 45, 50];
        $diameters = [15, 16, 17, 18, 19];
        $seasons = ['nyári', 'téli', 'négyévszakos'];
        $speedIndexes = ['T', 'H', 'V', 'W', 'Y'];
        $loadIndexes = [88, 91, 94, 98, 102];
        $patterns = ['Pilot Sport 5', 'WinterContact TS870', 'Turanza T005', 'Cinturato P7', 'Ventus Prime 4'];

        $tires = collect();

        for ($i = 0; $i < 15; $i++) {
            $brand = $brands->random();
            $category = $categories->random();
            $width = $widths[array_rand($widths)];
            $profile = $profiles[array_rand($profiles)];
            $diameter = $diameters[array_rand($diameters)];
            $season = $seasons[array_rand($seasons)];
            $pattern = $patterns[array_rand($patterns)];

            $fullName = "{$brand->name} {$pattern} {$width}/{$profile} R{$diameter}";
            $slug = Str::slug($fullName) . '-' . Str::random(4);

            $tire = Tire::create([
                'brand_id' => $brand->id,
                'category_id' => $category->id,
                'pattern' => $pattern,
                'slug' => $slug,
                'width' => $width,
                'profile' => $profile,
                'diameter' => $diameter,
                'season' => $season,
                'speed_index' => $speedIndexes[array_rand($speedIndexes)],
                'load_index' => $loadIndexes[array_rand($loadIndexes)],
                'price' => rand(18000, 65000),
                'stock' => rand(0, 40),
                'image' => 'https://via.placeholder.com/300x300?text=' . urlencode($brand->name),
                'is_active' => true,
            ]);

            $tires->push($tire);
        }

        // 5. Néhány teszt rendelés és rendelési tétel
        foreach ($users as $user) {
            $order = Order::create([
                'user_id' => $user->id,
                'order_number' => 'ORD-' . strtoupper(Str::random(8)),
                'total_price' => 0,
                'status' => 'pending',
                'payment_status' => 'paid',
                'customer_name' => $user->name,
                'customer_email' => $user->email,
                'customer_phone' => '+36301234567',
                'shipping_address' => 'Fő utca ' . rand(1, 100),
                'shipping_city' => 'Budapest',
                'shipping_postal_code' => '1011',
            ]);

            $totalPrice = 0;
            $randomTires = $tires->random(rand(1, 3));

            foreach ($randomTires as $tire) {
                $quantity = rand(2, 4);
                $unitPrice = $tire->price;
                $totalPrice += $quantity * $unitPrice;

                OrderItem::create([
                    'order_id' => $order->id,
                    'tire_id' => $tire->id,
                    'quantity' => $quantity,
                    'unit_price' => $unitPrice,
                ]);
            }

            $order->update(['total_price' => $totalPrice]);
        }
    }
}