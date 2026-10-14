@extends('layouts.app')
@section('title', 'Find land in Tanzania')
@section('meta_description', 'Search and explore reviewed land listings in Tanzania on a map.')
@push('head')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="">
@endpush
@section('content')
<section class="hero"><div class="eyebrow">Location-first property discovery</div><h1>Find your plot.<br><span style="color:#60a5fa">Know its location.</span></h1><p class="muted">Search land listings by area, budget, and property type. Review listing details before making an enquiry.</p></section>
<form class="search" method="GET" action="{{ route('properties.index') }}">
    <div class="wide"><label for="q">Search area or keyword</label><input id="q" name="q" value="{{ $filters['q'] ?? '' }}" placeholder="e.g. Kigamboni, Mbagala"></div>
    <div><label for="region">Region</label><select id="region" name="region"><option value="">All regions</option>@foreach(['Dar es Salaam','Pwani','Dodoma','Arusha','Mwanza','Tanga'] as $region)<option value="{{ $region }}" @selected(($filters['region'] ?? '') === $region)>{{ $region }}</option>@endforeach</select></div>
    <div><label for="district">District</label><input id="district" name="district" value="{{ $filters['district'] ?? '' }}" placeholder="Any district"></div>
    <div><label for="type">Type</label><select id="type" name="type"><option value="">All types</option>@foreach(['plot'=>'Plot','land'=>'Land','house'=>'House','commercial'=>'Commercial'] as $value=>$label)<option value="{{ $value }}" @selected(($filters['type'] ?? '') === $value)>{{ $label }}</option>@endforeach</select></div>
    <div><label for="min_price">Min TSh</label><input id="min_price" name="min_price" type="number" min="0" value="{{ $filters['min_price'] ?? '' }}" placeholder="0"></div>
    <div><label for="max_price">Max TSh</label><input id="max_price" name="max_price" type="number" min="0" value="{{ $filters['max_price'] ?? '' }}" placeholder="No limit"></div>
    <div style="display:flex;align-items:end;gap:8px"><button type="submit">Search</button><a class="btn btn-outline" href="{{ route('properties.index') }}">Reset</a></div>
</form>
<div class="section-head"><h2>Explore on the map</h2><span class="muted">{{ $properties->total() }} reviewed listing(s)</span></div>
<div class="market-grid">
    <section><div id="property-map" role="application" aria-label="Map showing published property locations"></div><p class="map-caption">Map © OpenStreetMap contributors. Pins appear only for listings that passed publication checks.</p></section>
    <section>
    @if($properties->isEmpty())
        <div class="empty"><div style="font-size:2rem">📍</div><h2>No reviewed listings yet</h2><p class="muted">There are no listings that meet the publication checks for this search. Try clearing your filters or check back later.</p></div>
    @else
        <div class="cards">@foreach($properties as $property)
            <article class="card"><div class="placeholder" aria-hidden="true">⌖</div><div class="card-body">
                <span class="pill">{{ ucfirst($property->property_type) }}</span><h3 style="margin-top:9px"><a href="{{ route('properties.show', $property) }}">{{ $property->title }}</a></h3>
                <div class="muted">{{ collect([$property->neighbourhood, $property->ward, $property->district, $property->region])->filter()->join(', ') }}</div>
                <div class="price">{{ $property->price_tzs ? 'TSh '.number_format($property->price_tzs) : 'Price on enquiry' }}</div>
                <div class="muted">{{ $property->area_square_meters ? number_format((float)$property->area_square_meters).' m²' : 'Size not provided' }}</div>
                <p><a class="btn btn-outline" style="margin-top:10px" href="{{ route('properties.show', $property) }}">View details</a></p>
            </div></article>
        @endforeach</div><div class="pagination">{{ $properties->links() }}</div>
    @endif
    </section>
</div>
<div class="notice"><strong>Land buyer reminder:</strong> Seller checks and property-document checks are separate. A map marker does not prove ownership, title status, or plot boundaries. Do not pay before independent verification.</div>
@endsection
@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
(() => {
 const el=document.getElementById('property-map'); if(!el||!window.L)return;
 const map=L.map(el,{scrollWheelZoom:false}).setView([-6.82,39.28],9);
 L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png',{maxZoom:19,attribution:'&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'}).addTo(map);
 const listings=@json($mapProperties); const markers=[];
 listings.forEach(item=>{
   const marker=L.marker([item.lat,item.lng]).addTo(map);
   const title=document.createElement('span'); title.textContent=item.title;
   const price=document.createElement('span'); price.textContent=item.price?'TSh '+Number(item.price).toLocaleString('en-TZ'):'Price on enquiry';
   const link=document.createElement('a'); link.href=item.url; link.textContent='View listing';
   const popup=document.createElement('div'); popup.append(title,document.createElement('br'),price,document.createElement('br'),link);
   marker.bindPopup(popup); markers.push(marker);
 });
 if(markers.length){const group=L.featureGroup(markers);map.fitBounds(group.getBounds().pad(.18),{maxZoom:13});}
})();
</script>
@endpush
