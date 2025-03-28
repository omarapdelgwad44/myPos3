<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Permission;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:users-read')->only('index');
        $this->middleware('permission:users-create')->only(['create', 'store']);
        $this->middleware('permission:users-update')->only(['edit', 'update']);
        $this->middleware('permission:users-delete')->only('destroy');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::with('roles')->whereDoesntHave('roles', function ($query) {
            $query->where('name', 'super_admin');
        });
    
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
    
        $users = $query->paginate(10);
    
        return view('users', compact('users'));
    
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:8|confirmed',
        'image' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
    ]);  

    $data = $request->except('image'); 
    if ($request->hasFile('image')) {
        $image = $request->file('image');
        $imageName = time() . '.' . $image->extension();
        $manager = ImageManager::gd();
        $manager->read($image)
            ->resize(300, 300) 
            ->save(public_path('images/' . $imageName));
            // dd(public_path('images/' . $imageName));
        $data['image'] = $imageName; 
    }
    $user = User::create($data); 
    $user->addRole('admin');

    if ($request->permissions) {
        $user->syncPermissions($request->permissions);
    }
    return redirect()->route('dashboard.users.index')->with('success', 'User created successfully.');
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $permissions = Permission::all();
        // DD($permissions);
        return view('users.edit', compact('user', 'permissions'));
    }
    
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
    
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8|confirmed',
        ]);
    
        $user->name = $request->name;
        $user->email = $request->email;
    
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }
        
    if ($request->permissions) {
        $user->syncPermissions($request->permissions);
    } else {
        $user->permissions()->detach();
    }
    
        $user->save();
    
        return redirect()->route('dashboard.users.index')->with('success', 'User updated successfully.');
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->permissions()->detach();
        User :: destroy($id);
        return redirect()->route('dashboard.users.index');
    }
}
