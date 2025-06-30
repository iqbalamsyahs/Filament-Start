<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class AcademicYear extends Model
{
    use HasFactory;

    protected $fillable = [
        'academic_year_name',
        'start_date',
        'end_date',
        'status',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    /**
     * RELASI: Satu Tahun Ajaran memiliki banyak Rombongan Belajar (ClassSection).
     */
    public function classSections(): HasMany
    {
        return $this->hasMany(ClassSection::class);
    }

    /**
     * SCOPE: Helper untuk dengan mudah mencari tahun ajaran yang aktif.
     * Penggunaan: AcademicYear::active()->first();
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'Active');
    }
}
