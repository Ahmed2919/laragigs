<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    use HasFactory;

    protected $fillable = ['title' , 'user_id','logo', 'tags', 'company', 'location', 'email', 'website', 'description' ];

    public function scopeFilter($query , array $filters){
        if($filters['tag'] ?? false){
            $query->where('tags' , 'like' , '%' . request('tag') . '%');
        }
        if($filters['search'] ?? false){
            $query->where('tags' , 'like' , '%' . request('search') . '%')
            ->orwhere('title' , 'like' , '%' . request('search') . '%')
            ->orwhere('description' , 'like' , '%' . request('search') . '%')
            ;
        }
    }

    // Relationship To User
    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
