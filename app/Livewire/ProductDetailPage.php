<?php

namespace App\Livewire;

use App\Helpers\CartManagement;
use App\Livewire\Partials\Navbar;
use App\Models\Product;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Product Detail - Savannah')]
class ProductDetailPage extends Component
{
    use LivewireAlert;
    public $product;
    public $quantity = 1;

    public function increaseQuantity(){
        $this->quantity++;
    }
    public function decreaseQuantity(){
        if ($this->quantity > 1){
            $this->quantity--;
        }
    }

    public function addToCart($product_id)
    {
        $total_count = CartManagement::addItemToCartWithQuantity($product_id, $this->quantity);
        $this->dispatch('update-cart-count', total_count: $total_count)->to(Navbar::class);
        $this->alert('success', 'Added to cart successfully!', [
            'position' =>  'bottom-end',
            'timer' => 3000,
            'toast' => 'true'
        ]);
    }
    public function mount(Product $product)
    {
        $this->product = $product;
    }

    public function render()
    {
        return view('livewire.product-detail-page', [
            'product' => $this->product
        ]);
    }
}
