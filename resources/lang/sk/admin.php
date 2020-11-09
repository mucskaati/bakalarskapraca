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

    'slider' => [
        'title' => 'Slajdre',

        'actions' => [
            'index' => 'Slajdre',
            'create' => 'Nový slajder',
            'edit' => 'Upraviť slajder :name',
        ],

        'columns' => [
            'id' => 'ID',
            'default' => 'Default',
            'default_function' => 'Voľitelná default funkcia',
            'layout_id' => 'Layout grafu',
            'max' => 'Maximum',
            'min' => 'Minimum',
            'step' => 'Krok',
            'title' => 'Názov parametra',
            'depended_slider_id' => 'Nastaviť hodnotu slajdru',
            'same_as_added_slider' => 'Rovnakú akú ma pridávaný slajder',
            'value_function' => 'Alebo hodnotu nižšie napísanej funkcie',
            'add_dependency' => 'Pridať ďalšiu závislosť',
            'delete' => 'Zmazať závislosť'

        ],
    ],

    'checkbox' => [
        'title' => 'Checkboxy',

        'actions' => [
            'index' => 'Checkboxy',
            'create' => 'Nový checkbox',
            'edit' => 'Upraviť checkbox :name',
        ],

        'columns' => [
            'id' => 'ID',
            'attribute_name' => 'Atribút name',
            'layout_id' => 'Layout',
            'title' => 'Názov checkboxu',

        ],
    ],

    // Do not delete me :) I'm used for auto-generation
];
