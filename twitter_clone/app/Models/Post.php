<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Post extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable=['title','body','user_id'];
    //create a relation
    public function userRel(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
