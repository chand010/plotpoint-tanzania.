@extends('layouts.app')
@section('title', 'Review queue')
@section('content')
<section class="hero"><div class="eyebrow">Restricted workspace</div><h1>Property review queue</h1><p class="muted">Check seller authority and property evidence as separate steps.</p></section>
@if($properties->isEmpty())
<div class="empty"><h2>Queue is clear</h2><p class="muted">No listings currently need review.</p></div>
@else
<div class="cards">
@foreach($properties as $property)
<article class="card"><div class="card-body"><span class="pill">{{ ucfirst($property->status) }}</span><h2><a href="{{ route('admin.properties.show',$property) }}">{{ $property->title }}</a></h2><p class="muted">{{ collect([$property->neighbourhood,$property->district,$property->region])->filter()->join(', ') }}</p><p>Seller: {{ $property->seller?->name ?? 'Unknown' }}</p><p class="muted">Seller check: {{ $property->seller_verified ? 'verified' : 'pending' }} · Property check: {{ $property->property_reviewed ? 'reviewed' : 'pending' }}</p><a class="btn" href="{{ route('admin.properties.show',$property) }}">Review listing</a></div></article>
@endforeach
</div>
<div class="pagination">{{ $properties->links() }}</div>
@endif
@endsection
