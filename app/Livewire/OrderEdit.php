<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;

class OrderEdit extends Component
{
    public $order;
    public $orderItems = [];
    public $selectedCategory = null;
    public $categories = [];

    public function mount($order)
    {
        $this->order = Order::with('products')->find($order);
        $this->categories = Category::with('products')->get();

        $this->orderItems = $this->order->products->map(function ($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->pivot->price,
                'quantity' => $product->pivot->quantity,
                'stock' => $product->stock,
            ];
        })->toArray();
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

        foreach ($this->orderItems as $index => $item) {
            if ($item['id'] == $product->id) {
                $this->orderItems[$index]['quantity'] += 1;
                return;
            }
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

    public function updateOrder()
    {
        // Detach old products and restock
        foreach ($this->order->products as $product) {
            $product->stock += $product->pivot->quantity;
            $product->save();
        }

        $this->order->products()->detach();

        // Attach new items
        foreach ($this->orderItems as $item) {
            $this->order->products()->attach($item['id'], [
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'total' => $item['price'] * $item['quantity'],
            ]);

            $product = Product::find($item['id']);
            $product->stock -= $item['quantity'];
            $product->save();
        }

        $this->order->update([
            'total' => $this->total,
        ]);

        session()->flash('message', 'تم تحديث الطلب بنجاح');
    }

    public function render()
    {
        return view('livewire.order-edit')->extends('adminlte::page')->section('content');
    }
}
