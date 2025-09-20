@props([
    'media' => null,
    'alt' => 'Image',
    'sizes' => '(max-width: 640px) 100vw, (max-width: 1024px) 80vw, 1200px',
])

<div class="w-full overflow-hidden rounded-lg aspect-[4/3] sm:aspect-[16/9] bg-gray-200 dark:bg-gray-700 relative">
    @if ($media)
        <picture>
            {{-- WebP --}}
            <source
                srcset="
                    {{ $media->getUrl('400', 'webp') }} 400w,
                    {{ $media->getUrl('800', 'webp') }} 800w,
                    {{ $media->getUrl('1200', 'webp') }} 1200w
                "
                type="image/webp">
            {{-- Fallback --}}
            <img srcset="
                    {{ $media->getUrl('400') }} 400w,
                    {{ $media->getUrl('800') }} 800w,
                    {{ $media->getUrl('1200') }} 1200w
                "
                src="{{ $media->getUrl('800') }}" alt="{{ $alt }}" sizes="{{ $sizes }}" loading="lazy"
                width="1200" height="675"
                class="w-full h-full object-cover object-center transition-opacity duration-500 ease-in-out opacity-0"
                onload="this.style.opacity='1'">
        </picture>
    @else
        <img src="https://via.placeholder.com/1200x675?text=No+Image" alt="No image"
            class="w-full h-full object-cover object-center">
    @endif
</div>
