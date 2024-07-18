<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryWebsite extends Model
{
    use HasFactory;
    protected $table = 'category_website';
    protected $fillable = ['website_id', 'category_id'];
}