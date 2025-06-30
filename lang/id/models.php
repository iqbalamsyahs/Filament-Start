<?php

// lang/id/models.php

return [
    'user' => [
        // Nama model dalam bentuk tunggal dan jamak
        'label' => 'Pengguna',
        'plural_label' => 'Pengguna',

        // Atribut atau kolom tabel
        'attributes' => [
            'id' => 'ID',
            'name' => 'Nama',
            'email' => 'Email',
            'email_verified_at' => 'Email Terverifikasi Pada',
            'password' => 'Kata Sandi',
            'roles' => 'Peran',
            'created_at' => 'Dibuat Pada',
            'updated_at' => 'Diperbarui Pada',
            'deleted_at' => 'Dihapus Pada',
        ],
    ],

    // Anda bisa menambahkan model lain di sini nanti
    // 'product' => [
    //     'label' => 'Produk',
    //     ...
    // ],
];