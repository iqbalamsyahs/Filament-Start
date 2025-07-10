<?php

namespace App\Filament\Resources\TeacherResource\Pages;

use App\Filament\Resources\TeacherResource;
use App\Models\Teacher;
use App\Models\User;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CreateTeacher extends CreateRecord
{
    protected static string $resource = TeacherResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        // Gunakan transaction untuk memastikan kedua data berhasil dibuat
        return DB::transaction(function () use ($data) {
            // 1. Buat User terlebih dahulu
            $user = User::create([
                'name' => $data['full_name'], // Ambil nama dari profil
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);

            // 2. Berikan peran 'Guru'
            $user->assignRole('guru');

            // 3. Buat Teacher dan hubungkan dengan user_id yang baru dibuat
            $teacher = Teacher::create([
                'user_id' => $user->id,
                'full_name' => $data['full_name'],
                'nip' => $data['nip'],
                'phone_number' => $data['phone_number'],
            ]);

            return $teacher;
        });
    }
}