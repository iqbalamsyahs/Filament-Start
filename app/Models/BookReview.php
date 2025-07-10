<?php

namespace App\Models;

use App\Models\Scopes\ActiveAcademicYearScope;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookReview extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * Ini adalah daftar kolom yang boleh diisi secara massal dari form.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'reading_log_id',
        'student_id',
        'academic_year_id',
        'review_content',
        'review_grade',
        'teacher_comments',
    ];

    /**
     * The "booted" method of the model.
     * Menerapkan Global Scope agar query untuk model ini selalu
     * terfilter berdasarkan tahun ajaran yang aktif.
     *
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope(new ActiveAcademicYearScope);
    }

    /**
     * ACCESSOR untuk mendapatkan judul buku dari relasi readingLog.
     */
    protected function bookTitle(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->readingLog?->book_title ?? ''
        );
    }

    /**
     * ACCESSOR untuk mendapatkan nama siswa dari relasi student.
     */
    protected function studentFullName(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->student?->full_name ?? ''
        );
    }

    /**
     * RELASI: Satu review ini milik satu catatan penyelesaian buku (ReadingLog).
     */
    public function readingLog(): BelongsTo
    {
        return $this->belongsTo(ReadingLog::class, 'reading_log_id');
    }

    /**
     * RELASI: Satu review ini milik satu Siswa.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * RELASI: Satu review ini dibuat dalam satu Tahun Ajaran.
     */
    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class);
    }
}
