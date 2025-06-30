<?php

// lang/en/models/student.php

return [
    // Basic Info
    'label' => 'Student',
    'plural_label' => 'Students',
    'navigation_group' => 'Academic Management',

    // Labels for each column/attribute
    'attributes' => [
      'photo' => 'Photo',
      'nisn' => 'NISN',
      'nis' => 'NIS (School Number)',
      'gender' => 'Gender',
      'place_of_birth' => 'Place of Birth',
      'date_of_birth' => 'Date of Birth',
    ],

    'sections' => [
      'personal_information' => 'Personal Information',
      'academic_information' => 'Academic & Contact Information',
    ],

    'values' => [
        'gender' => [
            'L' => 'Male',
            'P' => 'Female',
        ],
        'status' => [
            'aktif' => 'Active',
            'pindah' => 'Transferred',
            'lulus' => 'Graduated',
        ],
    ],
];