<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\Permission\Models\Role;

class UserEdit extends Component
{
    use WithFileUploads;

    public User $user;
    public $name, $email, $password, $password_confirmation, $role;
    public $profile_photo_path;
    public $bio;
    public $social_links = [];
    public string $type = 'password';

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($this->user->id),
            ],
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|exists:roles,name',
            'profile_photo_path' => 'nullable|image|max:2048',
            'bio' => 'nullable|string|max:1000',
            'social_links.*' => 'nullable|url',
        ];
    }

    public function mount(User $user)
    {
        $this->user = $user;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->roles->first()?->name ?? null; // Ambil role Spatie
        $this->bio = $user->bio;
        $this->social_links = $user->social_links ?? [];
    }

    public function togglePassword()
    {
        $this->type = $this->type === 'password' ? 'text' : 'password';
    }

    public function submit()
    {
        $validated = $this->validate();

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'bio' => $this->bio,
            'social_links' => $this->social_links ?? [],
        ];

        if ($this->password) {
            $data['password'] = Hash::make($this->password);
        }

        if ($this->profile_photo_path) {
            // Hapus foto lama jika ada
            if ($this->user->profile_photo_path) {
                Storage::disk('public')->delete($this->user->profile_photo_path);
            }
            $data['profile_photo_path'] = $this->profile_photo_path->store('profile-photos', 'public');
        }

        $this->user->update($data);

        // Sync role Spatie
        $this->user->syncRoles([$this->role]);

        session()->flash('success', 'Pengguna berhasil diperbarui ✅');
        return redirect()->route('admin.users.index');
    }

    public function render()
    {
        $roles = Role::all();
        return view('livewire.user-create', compact('roles'));
    }
}
