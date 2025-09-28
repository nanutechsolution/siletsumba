@props(['status', 'scheduledAt' => null])

@if ($status === 'published')
    <span class="inline-block mt-1 px-2 py-0.5 text-xs font-semibold rounded-full bg-green-100 text-green-800">
        Dipublikasikan
    </span>
@elseif ($status === 'draft')
    <span class="inline-block mt-1 px-2 py-0.5 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
        Draft
    </span>
@elseif ($status === 'scheduled')
    <span class="inline-block mt-1 px-2 py-0.5 text-xs font-semibold rounded-full bg-gray-100 text-gray-800">
        Dijadwalkan
        @if ($scheduledAt)
            ({{ \Carbon\Carbon::parse($scheduledAt)->translatedFormat('d M Y, H:i') }})
        @endif
    </span>
@endif
