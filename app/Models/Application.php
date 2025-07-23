<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{

    use HasFactory;
    protected $fillable = [
        'user_id',
        'company',
        'position',
        'status',
        'applied_on',
        'deadline',
        'location',
        'notes',
        'job_link',
        'resume_used',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
