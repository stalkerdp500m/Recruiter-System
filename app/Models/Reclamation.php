<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reclamation extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'reclamations';
    protected $guarded = [];
    protected $casts = [
        'comments' => 'array',
    ];

    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where($field ?? 'id', $value)->with('client:id,pasport,name', 'recruiter:id,name', 'status', 'user:id,name')->withTrashed()->firstOrFail();
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }

    public function recruiter()
    {
        return $this->belongsTo(Recruiter::class, 'recruiter_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function status()
    {
        return $this->belongsTo(ReclamationStatus::class, 'status_id', 'id');
    }

    public function scopeTrashedFilter($query, array $filters)
    {
        $query->when($filters['trashed'] ?? null, function ($query, $trashed) {
            if ($trashed == 'only') {
                $query->onlyTrashed();
            }
        });
    }
}
