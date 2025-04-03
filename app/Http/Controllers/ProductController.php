<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use CodeZero\UniqueTranslation\UniqueTranslationRule;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:products-read')->only('index');
        $this->middleware('permission:products-create')->only(['create', 'store']);
        $this->middleware('permission:products-update')->only(['edit', 'update']);
        $this->middleware('permission:products-delete')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
    //    dd($request->all());
        $query = Product::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%{$search}%");
        }
        if ($request->has('category_id')) {
            $categoryId = $request->input('category_id');
            $query->where('category_id', $categoryId);
        }
        $products = $query->paginate(10);
        $categories = Category::all();
        return view('products', compact('products', 'categories'));
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories=Category::all();
        return view('products.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|array', 
            'name.*' => 'string|max:255|unique_translation:products', 
            'description' => 'required|array',
            'description.*' => 'string|max:255|unique_translation:products',
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);  
        
        $data = $request->except('image'); 

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('images/products'), $imageName);
            $data['image'] = $imageName;
        }

        Product::create($data);
        return redirect()->route('dashboard.products.index')->with('success', @trans('adminlte::adminlte.added_successfully'));

    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        // DD($permissions);
        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required|array', 
            'name.*' => 'string|max:255|unique_translation:products,name,' . $product->id, 
            'description' => 'required|array',
            'description.*' => 'string|max:255|unique_translation:products,description,' . $product->id,
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);  

        $data = $request->except('image'); 

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('images/products'), $imageName);

            // Delete the old image if it exists
            if ($product->image && file_exists(public_path('images/products/' . $product->image))) {
            unlink(public_path('images/products/' . $product->image));
            }

            $data['image'] = $imageName;
        }

        $product->update($data);

        return redirect()->route('dashboard.products.index')->with('success', @trans('adminlte::adminlte.edited_successfully'));
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        if ($product->image && file_exists(public_path('images/products/' . $product->image))) {
            unlink(public_path('images/products/' . $product->image));
        }
        Product :: destroy($id);
        return redirect()->route('dashboard.products.index')->with('success', @trans('adminlte::adminlte.deleted_successfully'));
    }
}
