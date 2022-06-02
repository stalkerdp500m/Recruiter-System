<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class RecruiterUser extends Pivot
{
    use HasFactory;

    public function recruiters()
    {
        return $this->belongsTo(Recruiter::class);
    }
    public function users()
    {
        return $this->belongsTo(User::class);
    }
}
