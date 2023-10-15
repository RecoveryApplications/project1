<?php

namespace App\View\Components\Products;

use Closure;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class ProductCard extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public $isInHomeView = false, public $product = null, public $status = null, public $isInFavourite = false)
    {
        $this->isInHomeView = request()->routeIs('welcome');

        if (auth()->guard('customer')->check()) {
            $this->isInFavourite = auth()->guard('customer')->user()->wishlist->contains('product_id', $product->id);
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.products.product-card');
    }
}
