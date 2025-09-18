<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'name',
        'email',
        'program',
        'year_level',
        'contact_number',
    ];

    /**
     * Get the submissions for the student.
     */
    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }
}
