<?php

namespace App\Models;

use App\Models\Scopes\ActiveAcademicYearScope;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ReadingLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'academic_year_id',
        'book_title',
        'status',
        'date_reported',
        'last_page_read', 
        'total_pages',
    ];

    protected static function booted()
    {
        static::addGlobalScope(new ActiveAcademicYearScope);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class);
    }

    // Relasi ke review tetap ada, tapi hanya relevan jika statusnya 'Selesai'
    public function bookReview(): HasOne
    {
        return $this->hasOne(BookReview::class, 'reading_log_id');
    }

    protected function progressPercentage(): Attribute
    {
        return Attribute::make(
            get: function () {
                // Jika statusnya sudah selesai, progresnya 100%
                if ($this->status === 'Selesai') {
                    return 100;
                }
                
                // Jika total halaman atau halaman terakhir belum diisi, progresnya 0%
                if (!$this->total_pages || !$this->last_page_read || $this->total_pages == 0) {
                    return 0;
                }
                
                // Hitung persentase
                $percentage = ($this->last_page_read / $this->total_pages) * 100;
                
                // Kembalikan maksimal 100
                return min($percentage, 100);
            }
        );
    }
}
