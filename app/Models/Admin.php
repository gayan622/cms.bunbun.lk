<?php

namespace App\Models; // This MUST match the file path

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Admin extends Authenticatable
{
    use HasApiTokens; // Ensure you have this trait for createToken()
    // ...
}
