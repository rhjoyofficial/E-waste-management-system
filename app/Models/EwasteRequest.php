<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EwasteRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'collector_id',
        'category_id',
        'device_condition',
        'quantity',
        'pickup_address',
        'preferred_pickup_date',
        'status',
        'user_note',
        'admin_remark',
        'collector_remark'
    ];

    protected $casts = [
        'preferred_pickup_date' => 'date',
        'quantity' => 'integer'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function collector()
    {
        return $this->belongsTo(User::class, 'collector_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function statusLogs()
    {
        return $this->hasMany(RequestStatusLog::class);
    }

    // Status check methods
    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isApproved()
    {
        return $this->status === 'approved';
    }

    public function isAssigned()
    {
        return $this->status === 'assigned';
    }

    public function isCollected()
    {
        return $this->status === 'collected';
    }

    public function isRejected()
    {
        return $this->status === 'rejected';
    }

    // Status update with logging
    public function updateStatus($status, $changedBy = null, $remarks = null)
    {
        $this->status = $status;
        $this->save();

        // Log the status change
        RequestStatusLog::create([
            'ewaste_request_id' => $this->id,
            'status' => $status,
            'changed_by' => $changedBy,
            'remarks' => $remarks
        ]);

        return $this;
    }
}
