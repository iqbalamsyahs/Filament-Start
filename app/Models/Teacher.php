<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nip',
        'full_name',
        'phone_number',
    ];

    /**
     * RELASI: Satu profil Guru ini milik satu akun User.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * RELASI: Satu Guru bisa menjadi Wali Kelas untuk banyak Rombongan Belajar.
     */
    public function homeroomClasses(): HasMany
    {
        return $this->hasMany(ClassSection::class, 'teacher_id');
    }
}
