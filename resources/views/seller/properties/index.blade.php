@extends('layouts.app')
@section('title', 'My listings')
@section('content')
<section class="hero"><div class="eyebrow">Seller workspace</div><h1>My property listings</h1><p class="muted">Your drafts and review status are private to your account.</p><p><a class="btn" href="{{ route('seller.properties.create') }}">+ Submit a property</a></p></section>
@if(session('status'))<div class="notice" role="status">{{ session('status') }}</div>@endif
@if($properties->isEmpty())
    <div class="empty"><h2>No listings submitted yet</h2><p class="muted">When you submit a property, it will appear here as a private draft.</p><a class="btn" href="{{ route('seller.properties.create') }}">Submit your first listing</a></div>
@else
    <div class="cards">@foreach($properties as $property)
        <article class="card"><div class="card-body"><span class="pill">{{ ucfirst($property->status) }}</span><h2>{{ $property->title }}</h2><p class="muted">{{ collect([$property->neighbourhood,$property->district,$property->region])->filter()->join(', ') }}</p><p>{{ $property->price_tzs ? 'TSh '.number_format($property->price_tzs) : 'Price on enquiry' }}</p><p class="muted">Seller verification: {{ $property->seller_verified ? 'verified' : 'pending' }} · Property review: {{ $property->property_reviewed ? 'reviewed' : 'pending' }}</p><p class="muted">Only listings that pass all publication checks can appear publicly.</p></div></article>
    @endforeach</div>
    <div class="pagination">{{ $properties->links() }}</div>
@endif
@endsection
