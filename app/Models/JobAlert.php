<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobAlert extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'job_title',
        'job_description',
        'location',
        'salary',
        'employment_type',
        'remote',
        'company_name',
        'company_industry',
        'job_url',
        'alert_frequency',
        'created_at',
        'updated_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
