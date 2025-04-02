<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;
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
    
        $query = Product::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%{$search}%");
        }
        
        $products = $query->paginate(10);
        
        return view('products', compact('products'));
        
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
            'name' => 'required|array', // Expecting an array of translations
            'name.*' => 'string|max:255|unique_translation:products', // Ensure each language is a string
            'description' => 'required|array', // Expecting an array of translations
            'description.*' => 'string|max:255|unique_translation:products', // Ensure each language is a string
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);  
        
        $data = $request->except('image'); 
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->extension();
            $manager = ImageManager::gd();
            $manager->read($image)
                ->resize(300, 300) 
                ->save(public_path('images/products/' . $imageName));
                // dd(public_path('images/' . $imageName));
            $data['image'] = $imageName; 
        }
        $product = new Product();
        $product->setTranslations('name', $request->name); 
        $product->setTranslations('description', $request->description); 
        $product->image = $data['image'] ?? null;
        $product->category_id =$data['category_id'];
        $product->purchase_price =$data['purchase_price'];
        $product->sale_price =$data['sale_price'];
        $product->stock =$data['stock'];
        $product->save();
            
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
            'name' => 'required|array', // Expecting an array of translations
            'name.*' => 'string|max:255|unique_translation:products,name,' . $product->id, // Ensure each language is a string
            'description' => 'required|array', // Expecting an array of translations
            'description.*' => 'string|max:255|unique_translation:products,description,' . $product->id, // Ensure each language is a string
        ]);
    
        $product->setTranslations('name', $request->name);
        
        $product->name = $request->name;
        $product->description = $request->description;
        $product->category_id = $request->category_id;
        $product->purchase_price = $request->purchase_price;
        $product->sale_price = $request->sale_price;
        $product->stock = $request->stock;
        $imageName=$product->image;
    
       
    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = time() . '.' . $image->extension();
        $manager = ImageManager::gd();
        $manager->read($image)
            ->resize(300, 300, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('images/products/' . $imageName));
        
        // Delete the old image if it exists
        if ($product->image && file_exists(public_path('images/products/' . $product->image))) {
            unlink(public_path('images/products/' . $product->image));
        }
        // dd($imageName);

        $product->image = $imageName;
    }
        $data['image'] = $imageName; 
  
        $product->save();
    
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
