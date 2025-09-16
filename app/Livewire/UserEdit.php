<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;

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
            'role' => 'required|in:admin,writer,editor',
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
        $this->role = $user->role;
        $this->bio = $user->bio;
        $this->social_links = $user->social_links;
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
        $validated = $this->validate();

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
            'bio' => $this->bio,
            'social_links' => $this->social_links,
        ];

        if ($this->password) {
            $data['password'] = Hash::make($this->password);
        }

        if ($this->profile_photo_path) {
            $path = $this->profile_photo_path->store('profile-photos', 'public');
            $data['profile_photo_path'] = $path;
        }

        $this->user->update($data);

        session()->flash('success', 'Pengguna berhasil diperbarui. ✅');
        return redirect()->route('admin.users.index');
    }

    public function render()
    {
        return view('livewire.user-edit');
    }
}