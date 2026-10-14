@extends('layouts.app')
@section('title', 'Submit a property')
@section('content')
<section class="hero"><div class="eyebrow">Seller workspace</div><h1>Submit a property</h1><p class="muted">Listings start as private drafts. They remain hidden until the seller and property are reviewed.</p></section>
<form class="detail-panel" method="POST" action="{{ route('seller.properties.store') }}" style="max-width:900px">
    @csrf
    @if($errors->any())<div class="notice" role="alert">@foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach</div>@endif
    <div class="facts">
        <div><label for="title">Listing title</label><input id="title" name="title" value="{{ old('title') }}" maxlength="160" required placeholder="e.g. Residential plot in Kigamboni"></div>
        <div><label for="property_type">Property type</label><select id="property_type" name="property_type" required>@foreach(['plot'=>'Plot','land'=>'Land','house'=>'House','commercial'=>'Commercial'] as $value=>$label)<option value="{{ $value }}" @selected(old('property_type','plot')===$value)>{{ $label }}</option>@endforeach</select></div>
        <div><label for="region">Region</label><input id="region" name="region" value="{{ old('region','Dar es Salaam') }}" maxlength="100" required></div>
        <div><label for="district">District</label><input id="district" name="district" value="{{ old('district') }}" maxlength="100" required placeholder="e.g. Kigamboni"></div>
        <div><label for="ward">Ward (optional)</label><input id="ward" name="ward" value="{{ old('ward') }}" maxlength="100"></div>
        <div><label for="neighbourhood">Neighbourhood / area (optional)</label><input id="neighbourhood" name="neighbourhood" value="{{ old('neighbourhood') }}" maxlength="120"></div>
        <div><label for="latitude">Latitude (optional)</label><input id="latitude" name="latitude" type="number" step="any" min="-11.8" max="-0.9" value="{{ old('latitude') }}" placeholder="-6.8"></div>
        <div><label for="longitude">Longitude (optional)</label><input id="longitude" name="longitude" type="number" step="any" min="29.2" max="40.5" value="{{ old('longitude') }}" placeholder="39.3"></div>
        <div><label for="area_square_meters">Area (m², optional)</label><input id="area_square_meters" name="area_square_meters" type="number" step="0.01" min="0.01" value="{{ old('area_square_meters') }}"></div>
        <div><label for="price_tzs">Asking price (TSh, optional)</label><input id="price_tzs" name="price_tzs" type="number" step="1" min="0" value="{{ old('price_tzs') }}"></div>
    </div>
    <label for="description" style="margin-top:16px">Description</label><textarea id="description" name="description" rows="6" maxlength="5000" required style="width:100%;background:#071426;color:white;border:1px solid #3b526e;border-radius:9px;padding:10px;font:inherit">{{ old('description') }}</textarea>
    <div class="notice"><strong>Before submitting:</strong> PlotPoint has not verified ownership, title, boundaries, or your authority to advertise this land. Do not upload or share sensitive identity documents through this form.</div>
    <label style="display:flex;gap:10px;align-items:flex-start"><input type="checkbox" name="authority_to_advertise" value="1" required style="width:auto;min-height:auto;margin-top:5px"><span>I confirm I am the owner or have authority to advertise this property, and I understand PlotPoint must review the listing before publication.</span></label>
    <button type="submit" style="margin-top:18px">Save private draft</button>
    <a class="btn btn-outline" href="{{ route('seller.properties.index') }}" style="margin-left:8px">Cancel</a>
</form>
@endsection
