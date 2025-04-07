<?php
namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Permission;
use Intervention\Image\ImageManager;

class UserFormWizard extends Component
{
    use WithFileUploads;

    public $step = 1;
    public $totalSteps = 4;

    
    public $name, $email, $password, $password_confirmation, $image, $imagePreview;
    public $permissions = [];
    public $allPermissions = [];

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:8|same:password_confirmation',
        'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ];

    public function mount()
    {
        $this->allPermissions = Permission::all();
    }

    public function updated($property)
    {
        $this->validateOnly($property);

        if ($property === 'image' && $this->image) {
            $this->imagePreview = $this->image->temporaryUrl();
        }
    }

    public function nextStep()
    {
        if ($this->step == 1) {
            $this->validateOnly('name');
            $this->validateOnly('email');
        } elseif ($this->step == 2) {
            $this->validateOnly('image');
        } elseif ($this->step == 3) {
            $this->validateOnly('password');
            // dd($this);
        }

        $this->step++;
    }

    public function previousStep()
    {
        $this->step--;
    }

    public function store()
    {
        $this->validate();

        $imageName = null;

        if ($this->image) {
            $imageName = time() . '.' . $this->image->getClientOriginalExtension();
            $manager = ImageManager::gd();
            $manager->read($this->image->getRealPath())
                ->resize(300, 300)
                ->save(public_path('images/users/' . $imageName));
        }
// dd($this);
        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'image' => $imageName,
        ]);

        $user->addRole('admin');

        if (!empty($this->permissions)) {
            $user->syncPermissions($this->permissions);
        }

        return redirect()->route('dashboard.users.index')->with('success', @trans('adminlte::adminlte.added_successfully'));

    }

    public function render()
    {
        return view('livewire.user-form-wizard')->extends('adminlte::page')->section('content');
    }
}
