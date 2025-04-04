<?php

namespace App\Http\Controllers;

use App\Models\Clint;
use Illuminate\Http\Request;

class ClintController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:clints-read')->only('index');
        $this->middleware('permission:clints-create')->only(['create', 'store']);
        $this->middleware('permission:clints-update')->only(['edit', 'update']);
        $this->middleware('permission:clints-delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Clint::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%{$search}%");
        }
        
        $clints = $query->paginate(10);
        
        return view('clints', compact('clints'));
        
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
        
        Clint::create($request->all());     
        return redirect()->route('dashboard.clints.index')->with('success', @trans('adminlte::adminlte.added_successfully'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Clint $clint)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Clint $clint)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $clint = Clint::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'address' => 'required|string|max:255',
        ]);
        $clint->update($request->all());    
        return redirect()->route('dashboard.clints.index')->with('success', @trans('adminlte::adminlte.edited_successfully'));

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $clint = Clint::findOrFail($id);
        Clint :: destroy($id);
        return redirect()->route('dashboard.clints.index')->with('success', @trans('adminlte::adminlte.deleted_successfully'));

    }}
