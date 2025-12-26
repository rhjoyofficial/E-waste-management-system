<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestStatusLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'ewaste_request_id',
        'status',
        'changed_by',
        'remarks'
    ];

    public function ewasteRequest()
    {
        return $this->belongsTo(EwasteRequest::class);
    }

    public function changedBy()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
