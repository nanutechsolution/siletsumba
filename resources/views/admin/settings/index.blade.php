<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Pengaturan Website') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    @if (session('success'))
                        <div class="bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-300 px-4 py-3 rounded relative mb-4"
                            role="alert">
                            {{ session('success') }}
                        </div>
                    @endif


                    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data"
                        id="settings-form">
                        @csrf

                        <div class="space-y-8">
                            <div class="border-b border-gray-200 dark:border-gray-700 pb-6">
                                <h4 class="text-xl font-bold text-gray-800 dark:text-white mb-4">
                                    {{ __('Informasi Dasar') }}</h4>

                                <div>
                                    <label for="site_name"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Nama Situs') }}</label>
                                    <input type="text" name="site_name" id="site_name"
                                        value="{{ $settings['site_name']->value ?? '' }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                                </div>
                                <div class="mt-4">
                                    <label for="site_description"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Deskripsi Situs') }}</label>
                                    <textarea name="site_description" id="site_description" rows="3"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">{{ $settings['site_description']->value ?? '' }}</textarea>
                                </div>
                                <div>
                                    <label for="contact_address"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">Alamat
                                        Redaksi</label>
                                    <textarea name="contact_address" id="contact_address" rows="3"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">{{ $settings['contact_address']->value ?? '' }}</textarea>
                                </div>
                                <div x-data="{
                                    photoPreview: '{{ $settings['site_logo_url']->getFirstMediaUrl('site_logo_url') ?? '' }}'
                                }">
                                    <label for="site_logo_url"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Logo Situs') }}</label>
                                    <input type="file" name="site_logo_url" id="site_logo_url"
                                        class="mt-2 block w-full text-sm text-gray-900 dark:text-gray-100"
                                        x-ref="logoInput"
                                        @change="
            const file = $refs.logoInput.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = e => photoPreview = e.target.result;
                reader.readAsDataURL(file);
            } else {
                photoPreview = '{{ $settings['site_logo_url']->getFirstMediaUrl('site_logo_url') ?? '' }}';
            }
        ">

                                    <div class="mt-4" x-show="photoPreview">
                                        <h5 class="text-sm font-semibold mb-2">Pratinjau:</h5>
                                        <img :src="photoPreview" alt="Logo Preview"
                                            class="h-20 max-w-full object-contain">
                                    </div>
                                </div>

                            </div>

                            <div class="border-b border-gray-200 dark:border-gray-700 pb-6">
                                <h4 class="text-xl font-bold text-gray-800 dark:text-white mb-4">
                                    {{ __('Informasi Kontak & Sosial Media') }}</h4>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label for="contact_email"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Email Kontak') }}</label>
                                        <input type="email" name="contact_email" id="contact_email"
                                            value="{{ $settings['contact_email']->value ?? '' }}"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                                    </div>
                                    <div>
                                        <label for="contact_phone"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Nomor Telepon') }}</label>
                                        <input type="text" name="contact_phone" id="contact_phone"
                                            value="{{ $settings['contact_phone']->value ?? '' }}"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                                    </div>
                                    <div>
                                        <label for="social_facebook_url"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Facebook
                                            URL</label>
                                        <input type="text" name="social_facebook_url" id="social_facebook_url"
                                            value="{{ $settings['social_facebook_url']->value ?? '' }}"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                                    </div>
                                    <div>
                                        <label for="social_twitter_url"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Twitter
                                            (X) URL</label>
                                        <input type="text" name="social_twitter_url" id="social_twitter_url"
                                            value="{{ $settings['social_twitter_url']->value ?? '' }}"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                                    </div>
                                    <div>
                                        <label for="social_instagram_url"
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Instagram
                                            URL</label>
                                        <input type="text" name="social_instagram_url" id="social_instagram_url"
                                            value="{{ $settings['social_instagram_url']->value ?? '' }}"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm dark:bg-gray-700 dark:border-gray-600 dark:text-gray-200">
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center justify-end">
                                <button type="submit"
                                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md transition">{{ __('Simpan Pengaturan') }}</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
