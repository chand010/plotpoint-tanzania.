@extends('layouts.app')
@section('title', 'Create account')
@section('content')
<section class="hero"><div class="eyebrow">Join PlotPoint</div><h1>Create your account</h1><p class="muted">Create an account to prepare property listings. Submitting a listing does not publish it.</p></section>
<form class="detail-panel" method="POST" action="{{ route('register.store') }}" style="max-width:560px">
    @csrf
    @if($errors->any())<div class="notice" role="alert">@foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach</div>@endif
    <label for="name">Full name</label><input id="name" name="name" value="{{ old('name') }}" autocomplete="name" required maxlength="120">
    <label for="email" style="margin-top:14px">Email address</label><input id="email" name="email" type="email" value="{{ old('email') }}" autocomplete="email" required maxlength="255">
    <label for="password" style="margin-top:14px">Password (at least 10 characters)</label><input id="password" name="password" type="password" autocomplete="new-password" required minlength="10">
    <label for="password_confirmation" style="margin-top:14px">Confirm password</label><input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required minlength="10">
    <button type="submit" style="margin-top:18px">Create account</button>
    <p class="muted">Already registered? <a href="{{ route('login') }}">Sign in</a>.</p>
</form>
@endsection
