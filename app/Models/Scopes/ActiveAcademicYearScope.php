<?php

namespace App\Models\Scopes;

use App\Services\CurrentAcademicYearService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class ActiveAcademicYearScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        // Ambil ID tahun ajaran yang aktif/dipilih dari service
        $activeYearId = (new CurrentAcademicYearService())->id();

        // Hanya terapkan filter jika ID tahun ajaran aktif ditemukan
        if ($activeYearId) {
            // Terapkan filter where secara otomatis ke query
            // Menggunakan getTable() agar lebih dinamis jika nama tabel di model diubah
            $builder->where($model->getTable() . '.academic_year_id', $activeYearId);
        }
    }
}