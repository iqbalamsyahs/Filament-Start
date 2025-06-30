<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'nisn',
        'nis',
        'gender',
        'place_of_birth',
        'date_of_birth',
        'address',
        'status',
        'photo',
    ];

    /**
     * RELASI: Seorang Siswa bisa berada di banyak Rombongan Belajar seiring waktu (Many-to-Many).
     */
    public function classSections(): BelongsToMany
    {
        return $this->belongsToMany(ClassSection::class, 'enrollments')->withTimestamps();
    }

    /**
     * RELASI: Seorang Siswa memiliki banyak catatan penyelesaian buku.
     */
    // public function bookCompletions(): HasMany
    // {
    //     return $this->hasMany(BookCompletion::class);
    // }

    /**
     * RELASI: Seorang Siswa memiliki beberapa data asesmen K-Means (awal, tengah, akhir tahun).
     */
    // public function kMeansAssessments(): HasMany
    // {
    //     return $this->hasMany(KMeansAssessment::class);
    // }

    /**
     * RELASI: Seorang Siswa bisa memiliki banyak hasil karya literasi.
     */
    // public function literacyProjects(): HasMany
    // {
    //     return $this->hasMany(LiteracyProject::class);
    // }

    /**
     * HELPER METHOD: Untuk mendapatkan kelas aktif siswa saat ini dengan mudah.
     */
    public function currentClassSection()
    {
        $activeAcademicYear = AcademicYear::active()->first();

        if (!$activeAcademicYear) {
            return null;
        }

        return $this->classSections()
            ->where('academic_year_id', $activeAcademicYear->id)
            ->first();
    }

    protected function photoUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                // Cek apakah kolom 'photo' di database memiliki nilai
                if ($this->photo) {
                    // Jika ada, kembalikan URL ke file yang tersimpan di storage
                    // Pastikan disk 'public' Anda sudah di-link (php artisan storage:link)
                    return Storage::disk('public')->url($this->photo);
                }

                // Jika tidak ada foto, kembalikan path ke gambar default di folder public
                return asset('images/default-avatar.svg');
            }
        );
    }
}
