<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-300">Edit Pengguna</h2>
    </x-slot>

    <div class="py-8">
        <livewire:user-edit :user="$user" />
    </div>
</x-app-layout>
