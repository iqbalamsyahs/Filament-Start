<?php

namespace App\Services;

use App\Models\AcademicYear;

class CurrentAcademicYearService
{
    /**
     * Mendapatkan instance model AcademicYear yang sedang aktif/dipilih.
     * Prioritas:
     * 1. Cek session key 'academicYear' yang diatur oleh komponen Livewire.
     * 2. Jika tidak ada, fallback ke tahun ajaran yang statusnya 'active' di database.
     */
    public function get(): ?AcademicYear
    {
        // 1. Cek session key yang Anda buat ('academicYear')
        if (session()->has('academicYear')) {
            $selectedYearName = session('academicYear');
            
            // Cari AcademicYear berdasarkan NAMA, bukan ID
            return AcademicYear::where('academic_year_name', $selectedYearName)->first();
        }

        // 2. Jika tidak ada di session, fallback ke yang statusnya 'active'
        return AcademicYear::where('status', 'active')->first();
    }

    /**
     * Mendapatkan ID dari AcademicYear yang sedang aktif/dipilih.
     */
    public function id(): ?int
    {
        return $this->get()?->id;
    }
}