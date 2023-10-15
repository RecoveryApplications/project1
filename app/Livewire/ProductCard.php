<?php

namespace App\Livewire;

use Livewire\Component;

class ProductCard extends Component
{
    public $product;
    public $isInHomeView = false;
    public $status = null;


    public function addToCart()
    {
        dd($this->product->id);
    }




    public function mount($product)
    {
        $this->product = $product;
        $this->isInHomeView = request()->routeIs('welcome');
    }
    public function render()
    {
        return view('livewire.product-card');
    }
}
