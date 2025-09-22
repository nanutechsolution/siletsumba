<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manajemen Pengguna') }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8" x-data="usersApp()">

        <!-- Tombol Tambah User -->
        <div class="mb-4 space-y-3">
            <button @click="openAddUser()" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                Tambah User
            </button>
        </div>

        <!-- Desktop Table -->
        <div class="hidden md:block bg-white shadow rounded-lg overflow-x-auto">
            <table class="min-w-full border divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">ID</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Nama</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Email</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Roles</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Permissions</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <template x-for="user in users" :key="user.id">
                        <tr>
                            <td class="px-4 py-2 text-sm" x-text="user.id"></td>
                            <td class="px-4 py-2 text-sm" x-text="user.name"></td>
                            <td class="px-4 py-2 text-sm" x-text="user.email"></td>
                            <td class="px-4 py-2 text-sm space-x-1">
                                <template x-for="role in user.roles" :key="role.id">
                                    <span
                                        class="inline-block bg-green-100 text-green-800 text-xs px-2 py-0.5 rounded-full"
                                        x-text="role.name"></span>
                                </template>
                            </td>
                            <td class="px-4 py-2 text-sm space-x-1">
                                <template x-for="perm in user.permissions" :key="perm">
                                    <span
                                        class="inline-block bg-blue-100 text-blue-800 text-xs px-2 py-0.5 rounded-full"
                                        x-text="perm"></span>
                                </template>
                            </td>
                            <td class="px-4 py-2 text-sm">
                                <button @click="editUser(user)"
                                    class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">
                                    Edit
                                </button>
                                <button @click="deleteUser(user)"
                                    class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 ml-2">Hapus</button>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
        <!-- Mobile Cards -->
        <div class="md:hidden space-y-3 mt-3">
            <template x-for="user in users" :key="user.id">
                <div
                    class="border rounded-lg shadow p-4 bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700 transition-colors duration-200">
                    <div class="flex justify-between items-start">
                        <div>
                            <div class="font-semibold text-gray-900 dark:text-gray-100" x-text="user.name"></div>
                            <div class="text-sm text-gray-500 dark:text-gray-400" x-text="user.email"></div>

                            <div class="mt-2">
                                <div class="text-xs font-medium text-gray-600 dark:text-gray-300">Roles:</div>
                                <div class="flex flex-wrap gap-1 mt-1">
                                    <template x-for="role in user.roles" :key="role.id">
                                        <span
                                            class="bg-green-100 dark:bg-green-700 text-green-800 dark:text-green-200 px-2 py-0.5 rounded-full text-xs transition-colors duration-200"
                                            x-text="role.name"></span>
                                    </template>
                                </div>
                            </div>

                            <div class="mt-2">
                                <div class="text-xs font-medium text-gray-600 dark:text-gray-300">Permissions:</div>
                                <div class="flex flex-wrap gap-1 mt-1">
                                    <template x-for="perm in user.permissions" :key="perm">
                                        <span
                                            class="bg-blue-100 dark:bg-blue-700 text-blue-800 dark:text-blue-200 px-2 py-0.5 rounded-full text-xs transition-colors duration-200"
                                            x-text="perm"></span>
                                    </template>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col space-y-2 ml-2">
                            <button @click="editUser(user)"
                                class="bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 text-white px-3 py-1 rounded transition-colors duration-200">
                                Edit
                            </button>
                            <button @click="deleteUser(user)"
                                class="bg-red-600 hover:bg-red-700 dark:bg-red-500 dark:hover:bg-red-600 text-white px-3 py-1 rounded transition-colors duration-200">
                                Hapus
                            </button>
                        </div>
                    </div>
                </div>
            </template>
        </div>

        <!-- Modal -->
        <div x-show="modalOpen" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
            x-cloak>
            <div class="bg-white rounded shadow-lg w-full max-w-md p-4 max-h-[90vh] overflow-y-auto">
                <h2 class="text-lg font-semibold mb-3" x-text="modalTitle"></h2>

                <div class="mb-3">
                    <label class="block font-medium mb-1">Nama</label>
                    <input type="text" x-model="formData.name" class="w-full border px-2 py-1 rounded">
                </div>

                <div class="mb-3">
                    <label class="block font-medium mb-1">Email</label>
                    <input type="email" x-model="formData.email" class="w-full border px-2 py-1 rounded">
                </div>

                <div class="mb-3" x-show="isAddMode">
                    <label class="block font-medium mb-1">Password</label>
                    <input type="password" x-model="formData.password" class="w-full border px-2 py-1 rounded">
                </div>

                <div class="mb-3">
                    <label class="block font-medium mb-1">Roles</label>
                    <template x-for="role in roles" :key="role.id">
                        <div class="flex items-center mb-1">
                            <input type="checkbox" :value="role.name" x-model="formData.roles" class="mr-2">
                            <label x-text="role.name" class="text-gray-700"></label>
                        </div>
                    </template>
                </div>

                <div class="flex justify-end space-x-2 mt-4">
                    <button @click="closeModal()" class="bg-gray-400 px-3 py-2 rounded">Batal</button>
                    <button @click="saveUser()" class="bg-blue-600 text-white px-3 py-2 rounded">Simpan</button>
                </div>
            </div>
        </div>

    </div>

    <script>
        function usersApp() {
            return {
                users: @json($users),
                roles: @json($roles),
                modalOpen: false,
                modalTitle: '',
                formData: {
                    id: null,
                    name: '',
                    email: '',
                    password: '',
                    roles: []
                },
                isAddMode: true,

                openAddUser() {
                    this.modalTitle = 'Tambah User';
                    this.isAddMode = true;
                    this.formData = {
                        id: null,
                        name: '',
                        email: '',
                        password: '',
                        roles: []
                    };
                    this.modalOpen = true;
                },

                editUser(user) {
                    this.modalTitle = 'Edit User: ' + user.name;
                    this.isAddMode = false;
                    this.formData = {
                        id: user.id,
                        name: user.name,
                        email: user.email,
                        password: '',
                        roles: user.roles.map(r => r.name)
                    };
                    this.modalOpen = true;
                },

                closeModal() {
                    this.modalOpen = false;
                    this.formData = {
                        id: null,
                        name: '',
                        email: '',
                        password: '',
                        roles: []
                    };
                },
                deleteUser(user) {
                    if (!confirm(`Apakah yakin ingin menghapus user ${user.name}?`)) return;

                    axios.delete(`/admin/users/${user.id}`)
                        .then(res => {
                            this.users = this.users.filter(u => u.id !== user.id);
                        })
                        .catch(err => {
                            console.error(err);
                            alert('Gagal menghapus user');
                        });
                },

                saveUser() {
                    const url = this.isAddMode ? '/admin/users' : `/admin/users/${this.formData.id}`;
                    const method = this.isAddMode ? 'post' : 'put';

                    const payload = {
                        name: this.formData.name,
                        email: this.formData.email,
                        roles: this.formData.roles
                    };
                    if (this.isAddMode) payload.password = this.formData.password;

                    axios({
                            method: method,
                            url: url,
                            data: payload
                        })
                        .then(res => {
                            const user = res.data.user;
                            if (this.isAddMode) this.users.push(user);
                            else {
                                const index = this.users.findIndex(u => u.id === user.id);
                                this.users[index] = user;
                            }
                            this.closeModal();
                        })
                        .catch(err => {
                            console.error(err);
                            alert('Gagal menyimpan user');
                        });
                }


            }
        }
    </script>
</x-app-layout>
