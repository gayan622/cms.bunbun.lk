<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Hero extends Model
{
    use HasFactory;

   protected $fillable = [
    'badge',
    'title',
    'subtitle',
    'description',
    'primary_button_text',
    'secondary_button_text',
    'layout',
    'is_active',
    'image',
];
}
