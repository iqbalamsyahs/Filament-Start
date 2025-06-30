<?php

// lang/en/models/academic_year.php

return [
    'label' => 'Academic Year',
    'plural_label' => 'Academic Year',
    'navigation_group' => 'Academic Management',

    'attributes' => [
        'academic_year_name' => 'Academic Year Name',
        'start_date' => 'Start Date',
        'end_date' => 'End Date',
    ],

    'values' => [
        'status' => [
            'upcoming' => 'Upcoming',
            'active' => 'Active',
            'completed' => 'Completed',
        ],
    ],
];