<?php

namespace App\Livewire;

use App\Helpers\CartManagement;
use App\Livewire\Partials\Navbar;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('Products - Savannah')]
class ProductsPage extends Component
{
    use LivewireAlert;

    #[Url]
    public $selectedCategories = [];
    #[Url]
    public $selectedBrands = [];
    #[Url]
    public $featured = true;
    #[Url]
    public $onSale;
    #[Url]
    public $priceRange = 90000;
    #[Url]
    public $sortSelection = 'latest';

    use WithPagination;

    public function addToCart($product_id)
    {
        $total_count = CartManagement::addItemToCart($product_id);
        $this->dispatch('update-cart-count', total_count: $total_count)->to(Navbar::class);
        $this->alert('success', 'Added to cart successfully!', [
            'position' =>  'bottom-end',
            'timer' => 3000,
            'toast' => 'true'
        ]);
    }

    public function render()
    {
        $productsQuery = Product::query()->where('is_active', 1);

        if (!empty($this->selectedCategories)) {
            $productsQuery->whereIn('category_id', $this->selectedCategories);
        }

        if (!empty($this->selectedBrands)) {
            $productsQuery->whereIn('brand_id', $this->selectedBrands);
        }

        if ($this->featured) {
            $productsQuery->where('is_featured', 1);
        }

        if ($this->onSale) {
            $productsQuery->where('on_sale', 1);
        }

        if ($this->priceRange) {
            $productsQuery->whereBetween('price', [0,$this->priceRange]);
        }

        if ($this->sortSelection=='latest') {
            $productsQuery->latest();
        } elseif ($this->sortSelection=='price') {
            $productsQuery->orderBy('price');
        }

        return view('livewire.products-page', [
            'products' => $productsQuery->paginate(9),
            'brands' => Brand::where('is_active', 1)->get(['id', 'name', 'slug']),
            'categories' => Category::where('is_active', 1)->get(['id', 'name', 'slug']),
        ]);
    }
}
