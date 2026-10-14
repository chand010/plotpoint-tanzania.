@extends('layouts.app')
@section('title', $property->title)
@section('meta_description', 'Property listing details for '.$property->title)
@if($property->latitude !== null && $property->longitude !== null)
@push('head')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="">
@endpush
@endif
@section('content')
<section class="hero"><div class="eyebrow"><a href="{{ route('properties.index') }}" style="text-decoration:none">← Back to search</a></div><h1>{{ $property->title }}</h1><p class="muted">{{ collect([$property->neighbourhood,$property->ward,$property->district,$property->region])->filter()->join(', ') }}</p></section>
<div class="detail-grid">
<section class="detail-panel"><span class="pill">{{ ucfirst($property->property_type) }}</span>
<div class="price" style="font-size:1.7rem;margin-top:14px">{{ $property->price_tzs ? 'TSh '.number_format($property->price_tzs) : 'Price on enquiry' }}</div>
<p class="muted">Confirm all details independently before making a decision.</p>
<div class="facts">
<div class="fact"><small>Region</small><strong>{{ $property->region }}</strong></div><div class="fact"><small>District</small><strong>{{ $property->district ?: 'Not specified' }}</strong></div>
<div class="fact"><small>Plot size</small><strong>{{ $property->area_square_meters ? number_format((float)$property->area_square_meters).' m²' : 'Not specified' }}</strong></div><div class="fact"><small>Property type</small><strong>{{ ucfirst($property->property_type) }}</strong></div>
</div>
<h2>Description</h2><p>{{ $property->description ?: 'No additional description has been provided.' }}</p>
@if($property->latitude !== null && $property->longitude !== null)<h2>Approximate map location</h2><div id="detail-map" style="height:300px;border:1px solid #29415e;border-radius:12px;overflow:hidden"></div><p class="muted" style="font-size:.8rem">The pin is for orientation only, not a surveyed boundary or proof of ownership.</p>@endif
</section>
<aside class="detail-panel"><h2>Before you proceed</h2><ul class="muted"><li>Confirm the seller's identity and authority to advertise.</li><li>Have a qualified professional verify title, survey plan, plot number, and boundaries.</li><li>Visit the land and check for restrictions or disputes.</li><li>Use written agreements and legal advice before paying.</li></ul><div class="notice">Enquiry and payment features are not available in this development build. Do not send money based on this page.</div></aside>
</div>
@endsection
@if($property->latitude !== null && $property->longitude !== null)
@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>(()=>{const lat={{ (float)$property->latitude }};const lng={{ (float)$property->longitude }};const map=L.map('detail-map').setView([lat,lng],14);L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png',{maxZoom:19,attribution:'&copy; OpenStreetMap contributors'}).addTo(map);L.marker([lat,lng]).addTo(map).bindPopup('Approximate location');})();</script>
@endpush
@endif
