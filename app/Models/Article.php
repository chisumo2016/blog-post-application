<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Article extends Model
{
    use HasFactory;

    protected  $fillable = [
        'name' ,
        'excerpt' ,
        'description' ,
        'status' ,
        'user_id' ,
        'category' ,
    ];


    /**Inverse of one-many- relationship**/
    public  function  user() : BelongsTo
    {
        return $this->belongsTo(User:: class); //FK user_id
    }

    /**Inverse of one-many- relationship**/
    public  function  category() : BelongsTo
    {
        return $this->belongsTo(Category:: class); //FK user_id
    }

    /**Inverse of many-many- relationship**/
    public  function  tags():BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }
}
