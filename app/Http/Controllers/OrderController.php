<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:orders-read')->only('index');
        $this->middleware('permission:orders-create')->only(['create', 'store']);
        $this->middleware('permission:orders-update')->only(['edit', 'update']);
        $this->middleware('permission:orders-delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Order::with('clint')->latest();
        $query->when($request->filled('clint_id'), function ($q) use ($request) {
        $q->where('clint_id', $request->input('clint_id'));
    })->when($request->filled('product_id'), function ($q) use ($request) {
        $q->whereHas('products', function ($subQuery) use ($request) {
            $subQuery->where('product_id', $request->input('product_id'));
        });
     });
             
        $orders = $query->paginate(10);
        // dd($orders);
        $clints = \App\Models\Clint::all();
        $products = \App\Models\Product::all();
        return view('orders', compact('orders', 'clints', 'products'));
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'address' => 'required|string|max:255',
        ]);  
        
        Order::create($request->all());     
        return redirect()->route('dashboard.orders.index')->with('success', @trans('adminlte::adminlte.added_successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $order = Order::with('clint', 'products')->findOrFail($id);
        $products = $order->products;
        // \dd ($products);
        
        // dd($order);
        return view('orders.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'address' => 'required|string|max:255',
        ]);
        $order->update($request->all());    
        return redirect()->route('dashboard.orders.index')->with('success', @trans('adminlte::adminlte.edited_successfully'));

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $order = Order::findOrFail($id);
        foreach ($order->products as $product) {
            $product->stock+= $product->pivot->quantity;
            $product->save();
        }
        Order :: destroy($id);
        return redirect()->route('dashboard.orders.index')->with('success', @trans('adminlte::adminlte.deleted_successfully'));

    }}
