<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    public $table = 'products';
    
    public $primaryKey = 'id';
    
    protected $fillable = [
        'name',
        'description',
        'price',
        'user_id'
    ];
    
    public function user(){
        return $this->BelongsTo(User::class, 'use_id', 'id');
    }

}
