<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    /**
     * Mass assignable attributes for the contact form
     *
     * @var array<int,string>
     */
    protected $fillable = [
        'name',
        'email',
        'subject',
        'message',
        'status',
    ];
}
