<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recruitment extends Model
{
    /** @use HasFactory<\Database\Factories\RecruitmentFactory> */
    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'positions_needed',
        'status',
        'start_date',
        'end_date',
    ];
}
