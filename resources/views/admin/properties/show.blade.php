@extends('layouts.app')
@section('title', 'Review '.$property->title)
@section('content')
<section class="hero"><div class="eyebrow">Restricted administration</div><h1>{{ $property->title }}</h1><p class="muted">{{ collect([$property->neighbourhood,$property->ward,$property->district,$property->region])->filter()->join(', ') }}</p></section>
@if(session('status'))<div class="notice" role="status">{{ session('status') }}</div>@endif
<div class="detail-grid">
<section class="detail-panel"><h2>Submitted details</h2><div class="facts"><div class="fact"><small>Seller</small>{{ $property->seller?->name ?? 'Unknown' }}</div><div class="fact"><small>Seller email</small>{{ $property->seller?->email ?? 'Unavailable' }}</div><div class="fact"><small>Type</small>{{ ucfirst($property->property_type) }}</div><div class="fact"><small>Asking price</small>{{ $property->price_tzs ? 'TSh '.number_format($property->price_tzs) : 'Not provided' }}</div><div class="fact"><small>Area</small>{{ $property->area_square_meters ? number_format((float)$property->area_square_meters,2).' m²' : 'Not provided' }}</div><div class="fact"><small>Map pin</small>{{ $property->latitude && $property->longitude ? $property->latitude.', '.$property->longitude : 'Not provided' }}</div></div>
<h3>Description</h3><p>{{ $property->description }}</p><div class="notice">Do not treat a map pin, seller declaration, or uploaded image as conclusive proof of title. Verify documents against authoritative records and your documented review process. This scaffold does not yet upload or display private evidence.</div>
<h3>Review history</h3>
@if($audits->isEmpty())<p class="muted">No review actions recorded.</p>@else
@foreach($audits as $audit)<div class="fact" style="margin-bottom:8px"><strong>{{ str_replace('_',' ',ucfirst($audit->action)) }}</strong><small>{{ $audit->created_at->toDayDateTimeString() }} · {{ $audit->admin?->name ?? 'Admin account' }}</small><p>{{ $audit->notes }}</p>@if($audit->evidence_reference)<small>Evidence reference: {{ $audit->evidence_reference }}</small>@endif</div>@endforeach
@endif
</section>
<aside>
<div class="detail-panel"><h2>1. Seller verification</h2><p class="muted">Current status: {{ $property->seller_verified ? 'Verified' : 'Pending' }}</p>
<form method="POST" action="{{ route('admin.properties.verify-seller',$property) }}">@csrf
<label for="seller_evidence">Evidence reference (not a file upload)</label><input id="seller_evidence" name="evidence_reference" required minlength="4" maxlength="255" placeholder="Internal case/reference ID">
<label for="seller_notes" style="margin-top:12px">Verification notes</label><textarea id="seller_notes" name="notes" required minlength="10" maxlength="2000" rows="4" style="width:100%;background:#071426;color:white;border:1px solid #3b526e;border-radius:9px;padding:10px;font:inherit"></textarea>
<button type="submit" style="margin-top:12px">Record seller verification</button></form></div>
<div class="detail-panel" style="margin-top:16px"><h2>2. Property review</h2><p class="muted">Current status: {{ $property->property_reviewed ? 'Reviewed' : 'Pending' }}</p>
<form method="POST" action="{{ route('admin.properties.review-property',$property) }}">@csrf
<label for="decision">Decision</label><select id="decision" name="decision" required><option value="approve">Approve property review</option><option value="reject">Reject property</option></select>
<label for="property_evidence" style="margin-top:12px">Evidence reference</label><input id="property_evidence" name="evidence_reference" required minlength="4" maxlength="255" placeholder="Survey/title/authority case reference">
<label for="property_notes" style="margin-top:12px">Review notes</label><textarea id="property_notes" name="notes" required minlength="10" maxlength="2000" rows="4" style="width:100%;background:#071426;color:white;border:1px solid #3b526e;border-radius:9px;padding:10px;font:inherit"></textarea>
<button type="submit" style="margin-top:12px">Save property decision</button></form></div>
</aside></div>
@endsection
