<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manajemen Berita') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div x-data="rolesApp()">

                <!-- Tombol tambah role -->
                <button @click="openModal()" class="bg-blue-600 text-white px-4 py-2 rounded mb-4">Tambah Role</button>

                <!-- Alert -->
                @if (session('success'))
                    <div class="bg-green-100 text-green-800 px-3 py-2 rounded mb-3">{{ session('success') }}</div>
                @endif
                <!-- Desktop & mobile unified -->
                <div class="space-y-4">
                    <template x-for="role in roles" :key="role.id">
                        <div
                            class="border rounded-lg shadow p-4 flex flex-col md:flex-row md:items-center md:justify-between">
                            <div class="flex flex-col md:flex-row md:items-center md:space-x-4">
                                <span class="font-semibold text-gray-800">ID: <span x-text="role.id"></span></span>
                                <span class="text-gray-700">Nama Role: <span x-text="role.name"></span></span>
                            </div>
                            <div class="flex space-x-2 mt-2 md:mt-0">
                                <button @click="editRole(role)"
                                    class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 transition">
                                    Edit
                                </button>
                                <form :action="`/admin/roles/${role.id}`" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition"
                                        onclick="return confirm('Yakin mau hapus role ini?')">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- Modal -->
                <div x-show="modalOpen"
                    class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                    <div class="bg-white rounded shadow-lg w-full max-w-lg p-4 max-h-[90vh] overflow-y-auto">
                        <h2 class="text-lg font-semibold mb-3" x-text="modalTitle"></h2>
                        <form @submit.prevent="submitRole">
                            <input type="text" x-model="roleName" placeholder="Nama Role"
                                class="border rounded px-3 py-2 w-full mb-3" required>

                            <!-- Permissions -->
                            <div class="mb-3">
                                <label class="font-medium mb-1 block">Permissions</label>
                                <div class="max-h-64 overflow-y-auto border rounded p-2">
                                    <template x-for="perm in permissionsList" :key="perm.id">
                                        <div class="flex items-center mb-1">
                                            <input type="checkbox" :value="perm.id" x-model="rolePermissions"
                                                class="mr-2">
                                            <label x-text="perm.label" class="text-gray-700"></label>
                                        </div>
                                    </template>
                                </div>
                            </div>

                            <!-- Tambah permission baru -->
                            <div class="mt-3 flex space-x-2">
                                <input type="text" x-model="newPermission" placeholder="Tambah permission baru"
                                    class="border rounded px-3 py-2 flex-1">
                                <button type="button" @click="addPermission()"
                                    class="bg-green-600 text-white px-3 py-2 rounded">Tambah</button>
                            </div>

                            <!-- Footer modal -->
                            <div class="mt-4 flex justify-end space-x-2">
                                <button type="button" @click="closeModal()"
                                    class="bg-gray-400 px-3 py-2 rounded">Batal</button>
                                <button type="submit" class="bg-blue-600 text-white px-3 py-2 rounded">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        function rolesApp() {
            return {
                roles: @json($roles),
                permissionsList: @json($permissions),
                roleName: '',
                rolePermissions: [],
                newPermission: '',
                roleId: null,
                modalOpen: false,
                modalTitle: 'Tambah Role',

                openModal() {
                    this.modalOpen = true;
                    this.modalTitle = 'Tambah Role';
                    this.roleName = '';
                    this.rolePermissions = [];
                    this.roleId = null;
                },
                closeModal() {
                    this.modalOpen = false;
                },

                editRole(role) {
                    this.roleId = role.id;
                    this.roleName = role.name;
                    this.rolePermissions = role.permissions.map(p => p.id);
                    this.modalTitle = 'Edit Role';
                    this.modalOpen = true;
                },

                submitRole() {
                    let url = this.roleId ? `/admin/roles/${this.roleId}` : '/admin/roles';
                    let method = this.roleId ? 'put' : 'post';

                    axios({
                        method: method,
                        url: url,
                        data: {
                            name: this.roleName,
                            permissions: this.rolePermissions,
                            _token: '{{ csrf_token() }}'
                        }
                    }).then(res => {
                        location.reload(); // bisa diganti push ke array untuk update live
                    }).catch(err => {
                        console.error(err);
                        alert('Gagal menyimpan role');
                    });
                },

                addPermission() {
                    if (!this.newPermission.trim()) return;

                    axios.post('/admin/permissions', {
                        name: this.newPermission,
                        _token: '{{ csrf_token() }}'
                    }).then(res => {
                        this.permissionsList.push(res.data.permission);
                        this.rolePermissions.push(res.data.permission.id);
                        this.newPermission = '';
                    }).catch(err => {
                        console.error(err);
                        alert('Gagal tambah permission');
                    });
                }
            }
        }
    </script>
</x-app-layout>
