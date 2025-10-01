<!-- filepath: /Users/albertoarau/Development/Projects/Laravel/Devs/ferzaor/resources/views/components/loading-overlay.blade.php -->
<div {{ $attributes->merge(['class' => 'position-fixed top-0 start-0 w-100 h-100']) }} 
     style="z-index: {{ $zIndex ?? 9999 }}; background: {{ $background ?? 'rgba(0,0,0,0.5)' }};">
    <div class="d-flex justify-content-center align-items-center w-100 h-100">
        @if($type === 'whirly')
            <div class="whirly-loader"></div>
        @elseif($type === 'spinner')
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        @elseif($type === 'dots')
            <div class="spinner-grow text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        @else
            <div class="whirly-loader"></div>
        @endif
        
        @if($message)
            <div class="ms-3 text-primary fw-bold">{{ $message }}</div>
        @endif
    </div>
</div>





