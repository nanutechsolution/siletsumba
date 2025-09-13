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
            'role' => 'required|in:admin,writer',
            'profile_photo_path' => 'nullable|image|max:2048',
        ];
    }

    public function mount(User $user)
    {
        $this->user = $user;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->role;
    }

    public function submit()
    {
        $validated = $this->validate();

        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
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
