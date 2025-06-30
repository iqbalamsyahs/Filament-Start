<?php

// lang/en/models.php

return [
    'user' => [
        // Nama model dalam bentuk tunggal dan jamak
        'label' => 'User',
        'plural_label' => 'Users',

        // Atribut atau kolom tabel
        'attributes' => [
            'id' => 'ID', 
            'name' => 'Name',
            'email' => 'Email',
            'email_verified_at' => 'Email Verified At',
            'password' => 'Password',
            'roles' => 'Roles',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'deleted_at' => 'Deleted At',
        ],
    ],

    // Anda bisa menambahkan model lain di sini nanti
    // 'product' => [
    //     'label' => 'Product',
    //     ...
    // ],
];