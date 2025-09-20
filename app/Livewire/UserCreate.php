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
    public $bio;
    public $social_links = [];
    public $type = 'password';

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,editor,writer',
            'profile_photo_path' => 'nullable|image|max:2048',
            'bio' => 'nullable|string|max:1000',
            'social_links.*' => 'nullable|url',
        ];
    }

    public function togglePassword()
    {
        $this->type = $this->type === 'password' ? 'text' : 'password';
    }

    public function submit()
    {
        $this->validate();

        // Upload foto profil
        $path = $this->profile_photo_path ? $this->profile_photo_path->store('profile-photos', 'public') : null;

        // Buat user baru
        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'profile_photo_path' => $path,
            'bio' => $this->bio,
            'social_links' => $this->social_links,
        ]);

        // Assign role pakai Spatie
        $user->assignRole($this->role);

        session()->flash('success', 'Pengguna berhasil ditambahkan. ✅');
        return redirect()->route('admin.users.index');
    }

    public function render()
    {
        return view('livewire.user-create');
    }
}
