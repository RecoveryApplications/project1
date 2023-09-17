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
    public function __construct(public $isInHomeView = false, public $product = null)
    {
        $this->isInHomeView = request()->routeIs('welcome');
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.products.product-card');
    }
}
