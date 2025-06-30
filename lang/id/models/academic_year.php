<?php

// lang/id/models/academic_year.php

return [
    'label' => 'Tahun Ajaran',
    'plural_label' => 'Tahun Ajaran',
    'navigation_group' => 'Manajemen Akademik',

    'attributes' => [
        'academic_year_name' => 'Nama Tahun Ajaran',
        'start_date' => 'Tanggal Mulai',
        'end_date' => 'Tanggal Selesai',
    ],

    'values' => [
        'status' => [
            'upcoming' => 'Akan Datang',
            'active' => 'Aktif',
            'completed' => 'Selesai',
        ],
    ],
];