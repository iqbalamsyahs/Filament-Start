<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ClassSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'grade_level_id',
        'academic_year_id',
        'teacher_id',
        'section_name',
    ];

    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn () => ($this->gradeLevel?->name ?? '') . ' - ' . $this->section_name,
        );
    }

    public function gradeLevel(): BelongsTo
    {
        return $this->belongsTo(GradeLevel::class);
    }

    /**
     * RELASI: Satu Rombongan Belajar ini milik satu Tahun Ajaran.
     */
    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class);
    }

    /**
     * RELASI: Satu Rombongan Belajar ini memiliki satu Wali Kelas (Teacher).
     */
    public function homeroomTeacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

    /**
     * RELASI: Satu Rombongan Belajar memiliki banyak Siswa (Many-to-Many).
     */
    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'enrollments')->withTimestamps();
    }
}
