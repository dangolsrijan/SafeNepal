@props(['items' => []])

<nav class="sn-breadcrumbs" aria-label="Breadcrumb">
    <a href="{{ route('home') }}">Home</a>
    @foreach($items as $label => $url)
        <span aria-hidden="true">/</span>
        @if($url)
            <a href="{{ $url }}">{{ $label }}</a>
        @else
            <span aria-current="page" style="color:var(--sn-ink);font-weight:600;">{{ $label }}</span>
        @endif
    @endforeach
</nav>
