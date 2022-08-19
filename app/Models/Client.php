<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $table = 'clients';
    protected $guarded = [];

    public function payments()
    {
        return $this->hasMany(Payment::class,  'client_id', 'id');
    }
    public function salaries()
    {
        return $this->hasMany(Salary::class,  'client_id', 'id');
    }
}
