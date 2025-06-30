<?php

// lang/id/models/student.php

return [
    // Info Dasar
    'label' => 'Siswa',
    'plural_label' => 'Siswa',
    'navigation_group' => 'Manajemen Akademik',

    // Label untuk setiap kolom/atribut
    'attributes' => [
        'photo' => 'Foto',
        'nisn' => 'NISN',
        'nis' => 'NIS (Nomor Induk Sekolah)',
        'gender' => 'Jenis Kelamin',
        'place_of_birth' => 'Tempat Lahir',
        'date_of_birth' => 'Tanggal Lahir',
    ],

    'sections' => [
        'personal_information' => 'Informasi Pribadi',
        'academic_information' => 'Informasi Akademik & Kontak',
    ],

    'values' => [
      'gender' => [
            'L' => 'Laki-laki',
            'P' => 'Perempuan',
        ],
        'status' => [
            'aktif' => 'Aktif',
            'pindah' => 'Pindah',
            'lulus' => 'Lulus',
        ],
    ]
];