<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class UserPropertySubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'address',
        'city',
        'state',
        'postal_code',
        'type',
        'price',
        'status',
        'square_footage',
        'bedrooms',
        'bathrooms',
        'parking_spaces',
        'year_built',
        'features',
        'images',
        'submission_status',
        'admin_notes',
        'property_id',
        'reviewed_at',
        'reviewed_by',
        'contact_name',
        'contact_email',
        'contact_phone',
    ];

    protected $casts = [
        'features' => 'array',
        'images' => 'array',
        'price' => 'decimal:2',
        'reviewed_at' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    // Scopes
    public function scopePending(Builder $query)
    {
        return $query->where('submission_status', 'pending');
    }

    public function scopeApproved(Builder $query)
    {
        return $query->where('submission_status', 'approved');
    }

    public function scopeRejected(Builder $query)
    {
        return $query->where('submission_status', 'rejected');
    }

    public function scopeNeedsRevision(Builder $query)
    {
        return $query->where('submission_status', 'needs_revision');
    }

    // Accessors
    public function getFormattedPriceAttribute()
    {
        return '$' . number_format($this->price, 0);
    }

    public function getFullAddressAttribute()
    {
        return $this->address . ', ' . $this->city . ', ' . $this->state . ' ' . $this->postal_code;
    }

    public function getPropertyTypeLabel()
    {
        return ucfirst(str_replace('_', ' ', $this->type));
    }

    public function getStatusLabel()
    {
        return match($this->status) {
            'for_sale' => 'For Sale',
            'for_lease' => 'For Lease',
            default => ucfirst($this->status)
        };
    }

    public function getSubmissionStatusLabel()
    {
        return match($this->submission_status) {
            'pending' => 'Pending Review',
            'approved' => 'Approved',
            'rejected' => 'Rejected',
            'needs_revision' => 'Needs Revision',
            default => ucfirst(str_replace('_', ' ', $this->submission_status))
        };
    }

    public function getSubmissionStatusBadgeClass()
    {
        return match($this->submission_status) {
            'pending' => 'bg-yellow-100 text-yellow-800',
            'approved' => 'bg-green-100 text-green-800',
            'rejected' => 'bg-red-100 text-red-800',
            'needs_revision' => 'bg-blue-100 text-blue-800',
            default => 'bg-gray-100 text-gray-800'
        };
    }

    // Methods
    public function approve($adminUserId, $notes = null)
    {
        $this->update([
            'submission_status' => 'approved',
            'reviewed_at' => now(),
            'reviewed_by' => $adminUserId,
            'admin_notes' => $notes,
        ]);
    }

    public function reject($adminUserId, $notes)
    {
        $this->update([
            'submission_status' => 'rejected',
            'reviewed_at' => now(),
            'reviewed_by' => $adminUserId,
            'admin_notes' => $notes,
        ]);
    }

    public function requestRevision($adminUserId, $notes)
    {
        $this->update([
            'submission_status' => 'needs_revision',
            'reviewed_at' => now(),
            'reviewed_by' => $adminUserId,
            'admin_notes' => $notes,
        ]);
    }

    public function canBeEdited()
    {
        return in_array($this->submission_status, ['pending', 'needs_revision']);
    }

    public function hasBeenReviewed()
    {
        return !is_null($this->reviewed_at);
    }
}