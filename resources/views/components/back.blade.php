<div class="@if($attributes->has('class')) {{ $attributes->get('class') }} @endif">
    <a href="{{ $backUrl ?? url()->previous() }}" 
        class="inline-flex items-center px-4 py-2 bg-blue-500 text-white text-sm font-medium rounded-lg shadow hover:bg-blue-600 transition">
        ← Back
    </a>
</div>