<?php

use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

new #[Layout('layouts::site'), Title('Autógumi webshop')] class extends Component
{
    //
};
?>

<main>
    <livewire:sections.header/>

    <x-sections.trust-building/>

    <livewire:sections.header-category/>

    <livewire:sections.featured-offers/>

    <x-sections.brands/>

    <x-sections.service/>

    <x-sections.knowledge-base/>
</main>
