<?php

// lang/id/models/user.php

return [
    // Info Dasar
    'label' => 'Pengguna',
    'plural_label' => 'Pengguna',
    'navigation_group' => 'Manajemen User',

    // Label untuk setiap kolom/atribut
    'attributes' => [
        'name' => 'Nama Lengkap',
        'email_verified_at' => 'Email Terverifikasi Pada',
        'roles' => 'Peran',
    ],

    // Teks bantuan untuk form
    'helpers' => [
        'password' => 'Kosongkan jika Anda tidak ingin mengubah kata sandi.',
        'roles' => 'Pilih satu atau lebih peran untuk pengguna ini.',
    ],
    
    // Placeholder untuk form
    'placeholders' => [
        'name' => 'Masukkan nama lengkap pengguna...',
        'email' => 'contoh@email.com',
    ],

    // Judul untuk komponen Section
    'sections' => [
        'account_details' => 'Detail Akun',
        'security' => 'Informasi Keamanan',
    ],
    
    // Teks untuk kondisi khusus di tabel
    'table_actions' => [
        'empty_state_heading' => 'Belum Ada Pengguna',
        'empty_state_description' => 'Buat pengguna baru untuk memulai.',
    ],
];