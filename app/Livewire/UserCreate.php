<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Livewire\WithFileUploads;

class UserCreate extends Component
{
    use WithFileUploads;

    public $name, $email, $password, $password_confirmation, $role = 'writer';
    public $profile_photo_path;
    public $type = 'password';

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,writer',
            'profile_photo_path' => 'nullable|image|max:2048',
        ];
    }

    public function togglePassword()
    {
        if ($this->type == 'password') {
            $this->type = 'text';
        } else {
            $this->type = 'password';
        }
    }

    public function submit()
    {
        $this->validate();

        $path = null;
        if ($this->profile_photo_path) {
            $path = $this->profile_photo_path->store('profile-photos', 'public');
        }

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'role' => $this->role,
            'profile_photo_path' => $path,
        ]);
        session()->flash('success', 'Pengguna berhasil ditambahkan. ✅');
        return redirect()->route('admin.users.index');
    }

    public function render()
    {
        return view('livewire.user-create');
    }
}
