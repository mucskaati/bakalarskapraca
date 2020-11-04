<?php

return [
    'admin-user' => [
        'title' => 'Administrátori',

        'actions' => [
            'index' => 'Administrátori',
            'create' => 'Nový administrátor',
            'edit' => 'Upraviť :name',
            'edit_profile' => 'Upraviť profil',
            'edit_password' => 'Zmeniť heslo',
        ],

        'columns' => [
            'id' => 'ID',
            'last_login_at' => 'Posledné prihlásenie',
            'activated' => 'Aktivovaný účet',
            'email' => 'Email',
            'first_name' => 'Meno',
            'forbidden' => 'Zamietnutý prístup',
            'language' => 'Jazyk',
            'last_name' => 'Priezvisko',
            'password' => 'Heslo',
            'password_repeat' => 'Potvrdenie hesla',

            //Belongs to many relations
            'roles' => 'Role',

        ],
    ],

    // Do not delete me :) I'm used for auto-generation
];
