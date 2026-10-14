@extends('layouts.app')
@section('title', 'Sign in')
@section('content')
<section class="hero"><div class="eyebrow">Welcome back</div><h1>Sign in to PlotPoint</h1></section>
<form class="detail-panel" method="POST" action="{{ route('login.store') }}" style="max-width:560px">
    @csrf
    @if($errors->any())<div class="notice" role="alert">@foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach</div>@endif
    <label for="email">Email address</label><input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" required>
    <label for="password" style="margin-top:14px">Password</label><input id="password" name="password" type="password" autocomplete="current-password" required>
    <label style="display:flex;align-items:center;gap:8px;margin-top:14px"><input type="checkbox" name="remember" value="1" style="width:auto;min-height:auto"> Remember me</label>
    <button type="submit" style="margin-top:18px">Sign in</button>
    <p class="muted">Need an account? <a href="{{ route('register') }}">Register</a>.</p>
</form>
@endsection
