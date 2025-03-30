<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;


class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:categories-read')->only('index');
        $this->middleware('permission:categories-create')->only(['create', 'store']);
        $this->middleware('permission:categories-update')->only(['edit', 'update']);
        $this->middleware('permission:categories-delete')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Category::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%{$search}%");
        }
        
        $categories = $query->paginate(10);
        
        return view('categories', compact('categories'));
        
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
            'name' => 'required|array', // Expecting an array of translations
            'name.*' => 'string|max:255', // Ensure each language is a string
            'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);  
        
    
        $data = $request->except('image'); 
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->extension();
            $manager = ImageManager::gd();
            $manager->read($image)
                ->resize(300, 300) 
                ->save(public_path('images/categories/' . $imageName));
                // dd(public_path('images/' . $imageName));
            $data['image'] = $imageName; 
        }
        $category = new Category();
        $category->setTranslations('name', $request->name); 
        $category->image = $data['image'] ?? null;
        $category->save();
            
        return redirect()->route('dashboard.categories.index')->with('success', @trans('adminlte::adminlte.added_successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
    
        $request->validate([
            'name' => 'required|array',
            'name.*' => 'string|max:255',
        ]);
    
        $category->setTranslations('name', $request->name);
        
        $category->name = $request->name;
        $imageName=$category->image;
    
       
    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = time() . '.' . $image->extension();
        $manager = ImageManager::gd();
        $manager->read($image)
            ->resize(300, 300, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('images/categories/' . $imageName));
        
        // Delete the old image if it exists
        if ($category->image && file_exists(public_path('images/categories/' . $category->image))) {
            unlink(public_path('images/categories/' . $category->image));
        }
        // dd($imageName);

        $category->image = $imageName;
    }
        $data['image'] = $imageName; 
  
        $category->save();
    
        return redirect()->route('dashboard.categories.index')->with('success', @trans('adminlte::adminlte.edited_successfully'));

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::findOrFail($id);
        if ($category->image && file_exists(public_path('images/categories/' . $category->image))) {
            unlink(public_path('images/categories/' . $category->image));
        }
        Category :: destroy($id);
        return redirect()->route('dashboard.categories.index')->with('success', @trans('adminlte::adminlte.deleted_successfully'));

    }
}
