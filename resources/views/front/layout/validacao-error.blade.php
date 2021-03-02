<br>
<div class="container">
    <div class="col-md-12">
        <div class="alert alert-danger" id="error" style="display: none;" role="alert">
            @if ($error != null)
                {{ $error }}
            @endif
        </div>
    </div>
</div>

{{-- validação de backend --}}
@if ($error)
    <div class="container">
        <div class="col-md-12">
            <div class="alert alert-danger" id="error" role="alert">
                {{ $error }}
            </div>
        </div>
    </div>
@endif