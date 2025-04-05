<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;
use App\Models\Product;
use App\Models\Clint;

class OrderCreate extends Component
{
    public $selectedCategory = null;
    public $orderItems = [];
    public $clint;
    public $categories = [];

    public function mount(Clint $clint)
    {
        $this->clint = $clint;
        $this->categories = Category::with('products')->get();
    }

    public function getProductsProperty()
    {
        if (!$this->selectedCategory) return [];
        return Product::where('category_id', $this->selectedCategory)->get();
    }

    public function addProduct($productId)
    {
        $product = Product::find($productId);
        if (!$product) return;

        foreach ($this->orderItems as $item) {
            if ($item['id'] == $product->id) return; // لا تضف المنتج مرتين
        }

        $this->orderItems[] = [
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->sale_price,
            'quantity' => 1,
            'stock' => $product->stock,
        ];
    }

    public function removeProduct($productId)
    {
        $this->orderItems = array_filter($this->orderItems, fn($item) => $item['id'] !== $productId);
    }

    public function updateQuantity($index, $quantity)
    {
        $this->orderItems[$index]['quantity'] = (int) $quantity;
    }

    public function getTotalProperty()
    {
        return collect($this->orderItems)->sum(fn($item) => $item['price'] * $item['quantity']);
    }

    public function save()
    {
        // هنا قم بحفظ الطلب في قاعدة البيانات
        // مثال (ستحتاج تعديل حسب بنية قاعدة بياناتك):
        /*
        $order = Order::create([
            'clint_id' => $this->clint->id,
            'total' => $this->total,
        ]);

        foreach ($this->orderItems as $item) {
            $order->products()->attach($item['id'], [
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }
        */

        session()->flash('success', 'تم حفظ الطلب بنجاح');
        $this->orderItems = [];
    }

    public function render()
    {
        return view('livewire.order-create')->extends('adminlte::page')->section('content');
    }
}
