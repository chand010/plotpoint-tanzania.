<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\PropertyReviewAudit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AdminPropertyReviewController extends Controller
{
    public function index(): View
    {
        $properties = Property::query()
            ->with('seller:id,name,email')
            ->where(function ($query): void {
                $query->where('status', 'draft')
                    ->orWhere('seller_verified', false)
                    ->orWhere('property_reviewed', false);
            })
            ->latest()
            ->paginate(20);

        return view('admin.properties.index', compact('properties'));
    }

    public function show(Property $property): View
    {
        $property->load([
            'seller:id,name,email',
            'media' => fn ($query) => $query->orderBy('sort_order'),
        ]);

        $audits = PropertyReviewAudit::query()
            ->with('admin:id,name')
            ->where('property_id', $property->id)
            ->latest()
            ->get();

        return view('admin.properties.show', compact('property', 'audits'));
    }

    public function verifySeller(Request $request, Property $property): RedirectResponse
    {
        $data = $request->validate([
            'evidence_reference' => ['required', 'string', 'min:4', 'max:255'],
            'notes' => ['required', 'string', 'min:10', 'max:2000'],
        ]);

        DB::transaction(function () use ($request, $property, $data): void {
            $property = Property::query()->lockForUpdate()->findOrFail($property->id);
            $property->forceFill([
                'seller_verified' => true,
                'seller_verified_by' => $request->user()->id,
                'seller_verified_at' => now(),
                'seller_verification_reference' => $data['evidence_reference'],
            ])->save();

            PropertyReviewAudit::query()->create([
                'property_id' => $property->id,
                'admin_id' => $request->user()->id,
                'action' => 'seller_verified',
                'notes' => $data['notes'],
                'evidence_reference' => $data['evidence_reference'],
            ]);
        });

        return back()->with('status', 'Seller verification recorded. Property review is still a separate step.');
    }

    public function reviewProperty(Request $request, Property $property): RedirectResponse
    {
        $data = $request->validate([
            'decision' => ['required', 'in:approve,reject'],
            'evidence_reference' => ['required', 'string', 'min:4', 'max:255'],
            'notes' => ['required', 'string', 'min:10', 'max:2000'],
        ]);

        DB::transaction(function () use ($request, $property, $data): void {
            $property = Property::query()->lockForUpdate()->findOrFail($property->id);
            $previousStatus = $property->status;
            $approved = $data['decision'] === 'approve';

            $property->forceFill([
                'property_reviewed' => $approved,
                'property_reviewed_by' => $request->user()->id,
                'property_reviewed_at' => now(),
                'admin_review_notes' => $data['notes'],
                'status' => $approved ? 'published' : 'rejected',
            ])->save();

            PropertyReviewAudit::query()->create([
                'property_id' => $property->id,
                'admin_id' => $request->user()->id,
                'action' => $approved ? 'property_approved' : 'property_rejected',
                'notes' => $data['notes'],
                'evidence_reference' => $data['evidence_reference'],
                'metadata' => ['previous_status' => $previousStatus, 'new_status' => $property->status],
            ]);
        });

        return redirect()->route('admin.properties.show', $property)
            ->with('status', $data['decision'] === 'approve'
                ? 'Property review approved. It appears publicly only if all publication gates are satisfied.'
                : 'Property review rejected. The listing remains hidden from public search.');
    }
}
