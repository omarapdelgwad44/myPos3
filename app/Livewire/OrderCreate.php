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
        return Product::where('category_id', $this->selectedCategory)->get();
    }

    public function addProduct($productId)
    {
        $product = Product::find($productId);
        if (!$product) return;

        foreach ($this->orderItems as $item) {
            if ($item['id'] == $product->id) {
                if ($item['quantity'] == $product->stock) return;
                $this->orderItems[$item['this_id']]['quantity'] += 1;
                return;
            }
        }
        $this->orderItems[] = [
            'this_id' => count($this->orderItems),
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->purchase_price,
            'quantity' => 1,
            'stock' => $product->stock,
            'tax' => ($this->taxRate/100)*$product->purchase_price,
        ];
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
