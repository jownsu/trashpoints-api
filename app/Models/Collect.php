<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collect extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id'
    ];


    public function getSmugId()
    {
        return sprintf('CL-%04d', $this->id);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function trashes()
    {
        return $this->belongsToMany(Trash::class)->withPivot(['quantity', 'points']);
    }

    //my functions


}
