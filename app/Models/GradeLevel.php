<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GradeLevel extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    /**
     * RELASI: Satu Tingkat Kelas memiliki banyak Rombongan Belajar (ClassSection).
     * Contoh: "Kelas 1" bisa memiliki rombel "1A", "1B", dst.
     */
    public function classSections(): HasMany
    {
        return $this->hasMany(ClassSection::class);
    }
}
