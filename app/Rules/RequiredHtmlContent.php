<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class RequiredHtmlContent implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Hapus semua tag HTML dari konten
        $strippedContent = strip_tags($value);

        // Periksa apakah konten kosong setelah tag dihapus
        if (trim($strippedContent) === '') {
            $fail('Kolom :attribute wajib diisi.');
        }
    }
}
