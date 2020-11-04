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

    'layout' => [
        'title' => 'Layout grafov',

        'actions' => [
            'index' => 'Layout grafov',
            'create' => 'Nový layout grafu',
            'edit' => 'Upraviť layout grafu - :name',
        ],

        'columns' => [
            'id' => 'ID',
            'columns' => 'Počet stĺpcov',
            'height' => 'Výška',
            'margin' => 'Odsadenie',
            'name' => 'Názov layoutu grafu',
            'rows' => 'Počet riadkov',
            'type' => 'Typ layoutu',
            'width' => 'Šírka',
            'xaxis' => 'Xaxis',
            'yaxis' => 'Yaxis',

        ],
    ],

    // Do not delete me :) I'm used for auto-generation
];
