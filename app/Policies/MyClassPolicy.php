<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MyClassPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the page.
     *
     * Method ini akan dipanggil oleh Filament Shield untuk menentukan
     * apakah menu "Daftar Siswa" (dari halaman MyClass) boleh ditampilkan.
     */
    public function view(User $user): bool
    {
        // Izinnya akan bergantung pada permission 'page_MyClass'
        return $user->can('page_MyClass');
    }
}