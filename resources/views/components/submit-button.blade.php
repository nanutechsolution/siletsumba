@props([
    'text' => 'Simpan',
    'color' => 'blue',
])

@php
    $colors = [
        'blue' => 'bg-blue-500 hover:bg-blue-600',
        'green' => 'bg-green-500 hover:bg-green-600',
        'red' => 'bg-red-500 hover:bg-red-600',
    ];
    $btnColor = $colors[$color] ?? $colors['blue'];
@endphp

<button id="submitBtn" type="submit"
    class="relative flex items-center justify-center {{ $btnColor }} text-white font-bold py-2 px-6 rounded shadow hover:shadow-lg transition disabled:opacity-70 disabled:cursor-not-allowed overflow-hidden">

    {{-- Teks --}}
    <span id="btnText">{{ $text }}</span>

    {{-- Spinner di tengah tombol --}}
    <svg id="btnSpinner" class="hidden absolute w-5 h-5 text-white animate-spin" xmlns="http://www.w3.org/2000/svg"
        fill="none" viewBox="0 0 24 24">
        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
    </svg>
</button>

@once
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            document.querySelectorAll("form").forEach(form => {
                form.addEventListener("submit", () => {
                    const btn = form.querySelector("#submitBtn");
                    if (btn) {
                        const btnText = btn.querySelector("#btnText");
                        const btnSpinner = btn.querySelector("#btnSpinner");

                        btn.disabled = true;
                        btnText.classList.add("invisible");
                        btnSpinner.classList.remove("hidden");
                    }
                });
            });
        });
    </script>
@endonce
