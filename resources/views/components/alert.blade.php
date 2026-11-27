@if(session('success'))
    <div class="sn-alert sn-alert-success" role="status">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="sn-alert sn-alert-error" role="alert">{{ session('error') }}</div>
@endif
@if(session('warning'))
    <div class="sn-alert sn-alert-warning" role="alert">{{ session('warning') }}</div>
@endif
@if($errors->any())
    <div class="sn-alert sn-alert-error" role="alert">
        <strong>Please review the following:</strong>
        <ul style="margin:0.4rem 0 0 1.2rem;padding:0;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
