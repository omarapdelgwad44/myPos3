<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;
use App\Models\Product;
use App\Models\Clint;
use App\Models\Order;

class OrderCreate extends Component
{
    public $selectedCategory = null;
    public $orderItems = [];
    public $clint;
    public $categories = [];
    public $hasTax = false;
    public $hasDiscount = false;
    public $taxRate = 0;
    public $totalTax = 0;
    public $tax = 0;
    public $discountRate = 0;
    public $totalDiscount = 0;

    public function mount(Clint $clint)
    {
        $this->clint = $clint;
        $this->categories = Category::with('products')->get();
    }

    public function getProductsProperty()
    {
        if (!$this->selectedCategory) return [];
        return Product::where('category_id', $this->selectedCategory)->where('stock', '>', 0)->get();
    }

    public function addProduct($productId)
    {
        $product = Product::find($productId);
        if($product->on_sale){
            $price = $product->sale_price;
        }else{
            $price = $product->purchase_price;
        }
        if (!$product) return;


        $existingItem = collect($this->orderItems)->first(fn($item) => $item['id'] == $productId);
        if($existingItem){
            if($existingItem['quantity'] < $product->stock){
                $this->orderItems[$existingItem['this_id']]['quantity'] += 1;
                // dd($this->orderItems);
            } 
        }else{
            $this->orderItems[] = [
                'this_id' => count($this->orderItems),
                'id' => $product->id,
                'name' => $product->name,
                'price' => $price,
                'quantity' => 1,
                'stock' => $product->stock,
                'tax' => ($this->taxRate/100)*$price,
            ];
        }
        $this->updatedTaxRate();
        $this->updatedDiscountRate();
    }

    public function removeProduct($productId)
    {
        $this->orderItems = array_filter($this->orderItems, fn($item) => $item['id'] !== $productId);
        $this->updatedTaxRate();
        $this->updatedDiscountRate();

    }

    public function updateQuantity($index, $quantity)
    {
        $this->orderItems[$index]['quantity'] = (int) $quantity;
        
    }
    public function updatedHasTax()
    {
        if (!$this->hasTax) {
            $this->taxRate = 0;
            $this->totalTax = 0;
        }
    }
    public function updatedHasDiscount()
    {
        if (!$this->hasDiscount) {
            $this->discountRate = 0;
            $this->totalDiscount = 0;
        }
    }

    public function getTotalProperty()
    {
        return collect($this->orderItems)->sum(fn($item) => $item['price'] * $item['quantity']);
    }

    public function save()
    {
        $order = Order::create([
            'clint_id' => $this->clint->id,
            'total' => $this->total,
            'discount' => $this->totalDiscount,
            'tax' => $this->totalTax,
        ]);

        foreach ($this->orderItems as $item) {
            $order->products()->attach($item['id'], [
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'total' => $item['price'] * $item['quantity'],
            ]);
            $product = Product::find($item['id']);
            $product->stock -= $item['quantity'];
            $product->save();
        }

        $this->orderItems = [];
        $this->selectedCategory = null;
        $this->total=null;
        session()->flash('message', 'Order created successfully.');
        return redirect()->route('dashboard.orders.index');        

    }

    public function render()
    {
        return view('livewire.order-create')->extends('adminlte::page')->section('content');
    }


    public function updatedTaxRate()
    {
        $this->totalTax = 0;
        if($this->taxRate != ''){
            foreach ($this->orderItems as $item) {
                $this->totalTax += ($this->taxRate/100)*$item['quantity']*$item['price'];
            }
        }
    }

    public function updateCounter()
    {
        $this->updatedTaxRate();
        $this->updatedDiscountRate();
    }

    public function updatedDiscountRate()
    {
        if($this->discountRate != ''){
            $this->totalDiscount = ($this->discountRate/100)*$this->total;
        }
    }

}
