@foreach(['danger', 'warning', 'success', 'info'] as $msgKey)
    @if(session()->has($msgKey))
        <div class="flash-message">
            <p class="alert alert-{{ $msgKey }}">
                {{ session()->get($msgKey) }}
            </p>
        </div>
    @endif
@endforeach