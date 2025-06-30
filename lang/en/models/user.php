<?php

// lang/en/models/user.php

return [
    // Basic Info
    'label' => 'User',
    'plural_label' => 'Users',
    'navigation_group' => 'User Management',

    // Labels for each column/attribute
    'attributes' => [
        'name' => 'Full Name',
        'email_verified_at' => 'Email Verified At',
        'roles' => 'Roles',
    ],

    // Helper texts for forms
    'helpers' => [
        'password' => 'Leave blank if you do not want to change the password.',
        'roles' => 'Select one or more roles for this user.',
    ],
    
    // Placeholders for forms
    'placeholders' => [
        'name' => 'Enter the user\'s full name...',
        'email' => 'example@email.com',
    ],

    // Titles for Section components
    'sections' => [
        'account_details' => 'Account Details',
        'security' => 'Security Information',
    ],
    
    // Texts for special conditions in tables
    'table_actions' => [
        'empty_state_heading' => 'No Users Yet',
        'empty_state_description' => 'Create a new user to get started.',
    ],
];