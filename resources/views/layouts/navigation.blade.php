@php
    $user = auth()->user();
@endphp

@if ($user)
    @if ($user->isAdmin())
        @include('layouts.admin-navigation')
    @elseif($user->isCollector())
        @include('layouts.collector-navigation')
    @else
        @include('layouts.user-navigation')
    @endif
@endif
