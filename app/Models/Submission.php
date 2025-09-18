<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'assigned_assessor_id',
        'document_title',
        'slea_section',
        'subsection',
        'role_in_activity',
        'activity_date',
        'organizing_body',
        'description',
        'status',
        'auto_generated_score',
        'assessor_score',
        'assessor_remarks',
        'rejection_reason',
        'return_reason',
        'flag_reason',
        'submitted_at',
        'reviewed_at',
    ];

    protected $casts = [
        'activity_date' => 'date',
        'submitted_at' => 'datetime',
        'reviewed_at' => 'datetime',
        'auto_generated_score' => 'decimal:2',
        'assessor_score' => 'decimal:2',
    ];

    /**
     * Get the student that owns the submission.
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get the assessor assigned to this submission.
     */
    public function assessor()
    {
        return $this->belongsTo(User::class, 'assigned_assessor_id');
    }

    /**
     * Get the documents for the submission.
     */
    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    /**
     * Get the final score (assessor override or auto-generated).
     */
    public function getFinalScoreAttribute()
    {
        return $this->assessor_score ?? $this->auto_generated_score;
    }

    /**
     * Scope a query to only include pending submissions.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope a query to only include submissions assigned to a specific assessor.
     */
    public function scopeAssignedTo($query, $assessorId)
    {
        return $query->where('assigned_assessor_id', $assessorId);
    }
}
