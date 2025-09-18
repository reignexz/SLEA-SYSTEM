<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'submission_id',
        'original_filename',
        'stored_filename',
        'file_path',
        'file_type',
        'file_size',
        'mime_type',
    ];

    /**
     * Get the submission that owns the document.
     */
    public function submission()
    {
        return $this->belongsTo(Submission::class);
    }

    /**
     * Get the full URL for the document.
     */
    public function getUrlAttribute()
    {
        return Storage::url($this->file_path);
    }

    /**
     * Check if the document is an image.
     */
    public function isImage()
    {
        return in_array($this->file_type, ['jpg', 'jpeg', 'png', 'gif']);
    }

    /**
     * Check if the document is a PDF.
     */
    public function isPdf()
    {
        return $this->file_type === 'pdf';
    }

    /**
     * Get formatted file size.
     */
    public function getFormattedSizeAttribute()
    {
        $bytes = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }
}
