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
            'delete' => 'Zmazať závislosť',
            'visible' => 'Viditeľný',
            'label' => 'Label slajdru',
            'columns' => 'Koľko stĺpcov má zaberať slajder',
            'sorting' => 'Poradie slajdrov',
            'comparison_experiment_id' => 'Slajder ku schéme',
            'type' => 'Slajder k/ku'

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
            'layout_id' => 'Layout/Scheme',
            'title' => 'Názov checkboxu',
            'add_dependency' => 'Pridať ďalšiu závislosť',
            'slider_id' => 'Nastaviť hodnotu slajdra',
            'value_function' => 'Na nižšie uvedenú hodnotu alebo funkciu',
            'delete' => 'Zmazať závislosť',
            'slider_dependency_change' => 'Aktualizovať hodnoty zavislostí po zmene slidrov'

        ],
    ],

    'experiment' => [
        'title' => 'Experimenty typu FO',

        'actions' => [
            'index' => 'Experimenty typu FO',
            'create' => 'Nový experimenty typu FO',
            'edit' => 'Upraviť experiment typu FO - :name',
        ],

        'columns' => [
            'id' => 'ID',
            'ajax_url' => 'Ajax URL',
            'description' => 'Popis experimentu',
            'export' => 'Umožniť exportovanie do PDF',
            'layout_id' => 'Layout grafu',
            'title' => 'Nadpis experimentu',
            'annotation_title' => 'Anotácia grafu',
            'annotation_angle' => 'Uhol anotácie',
            'xaxis' => 'Pozícia anot. na X osi',
            'yaxis' => 'Pozícia anot. na Y osi',
            'align' => 'Zarovnanie anotácie',
            'traces_title' => 'Názov stopy',
            'response_xaxis' => 'X os (odpoveď zo servera)',
            'response_yaxis' => 'Y os (odpoveď zo servera)',
            'color' => 'Farba stopy (hex)',
            'legendgroup' => 'Legendgroup',
            'showlegend' => 'Ukázať legendu (showlegend)',
            'custom_js' => 'Vlastný JS kód',
            'slug' => 'Adresa (link)',
            'run_button' => 'Aktualizovanie grafu na tlačítko',
            'template' => 'Šablóna'

        ],
        'experiments' => 'Experimenty',
        'comparisons' => 'Porovnania',
        'settings' => 'Nastavenia grafov',
        'add_experiment' => 'PRIDAŤ EXPERIMENT',
        'edit_experiment' => 'UPRAVIŤ EXPERIMENT'
    ],

    'comparison-experiment' => [
        'title' => 'Schémy pre porovnanie',

        'actions' => [
            'index' => 'Porovnávacie experimenty',
            'create' => 'Nový experiment na porovnanie',
            'edit' => 'Upraviť :name',
        ],

        'columns' => [
            'id' => 'ID',
            'title' => 'Názov',
            'description' => 'Popis',
            'prefix' => 'Prefix odpovedi zo servera',
            'trace_color' => 'Farba stopy',
            'legendgroup' => 'Legendgroup',
            'schema' => 'Obrázok schémy'
        ],
    ],

    'comparison' => [
        'title' => 'Porovnávanie experimentov',

        'actions' => [
            'index' => 'Porovnávanie experimentov',
            'create' => 'Nové porovnávanie',
            'edit' => 'Upraviť :name',
        ],

        'columns' => [
            'id' => 'ID',
            'ajax_url' => 'Ajax URL',
            'description' => 'Popis experimentu',
            'export' => 'Umožniť exportovanie do PDF',
            'layout_id' => 'Layout grafu',
            'title' => 'Nadpis porovnania',
            'annotation_title' => 'Anotácia grafu',
            'annotation_angle' => 'Uhol anotácie',
            'xaxis' => 'Pozícia anot. na X osi',
            'yaxis' => 'Pozícia anot. na Y osi',
            'align' => 'Zarovnanie anotácie',
            'traces_title' => 'Názov stopy',
            'response_xaxis' => 'X os (odpoveď zo servera)',
            'response_yaxis' => 'Y os (odpoveď zo servera)',
            'color' => 'Farba stopy (hex)',
            'legendgroup' => 'Legendgroup',
            'showlegend' => 'Ukázať legendu (showlegend)',
            'custom_js' => 'Vlastný JS kód',
            'slug' => 'Adresa (link)',
            'run_button' => 'Aktualizovanie grafu na tlačítko',
            'template' => 'Šablóna',
            'add_scheme' => 'Pridať experiment na porovnanie (schéma)',
            'scheme' => 'Experiment na porovnanie (schéma)',
            'delete_scheme' => 'Zmazať experiment'

        ],
    ],

    'example' => [
        'title' => 'Príklady v porovnaniach',

        'actions' => [
            'index' => 'Príklady',
            'create' => 'Nový príklad',
            'edit' => 'Upraviť :name',
        ],

        'columns' => [
            'id' => 'ID',
            'experiment_id' => 'Porovnanie',
            'title' => 'Názov príkladu',
            'sliders' => 'Nastaviť slajder',
            'checkboxes' => 'Checkbox',
            'add_slider' => 'Pridať nastavenie slajdra',
            'add_checkbox' => 'Pridať ďalší checkbox',
            'delete' => 'Zmazať',
            'value' => 'Nastaviť na hodnotu',
            'schemes' => 'Schéma',
            'add_scheme' => 'Pridať nastavenie viditeľnosti schémy',
            'checked' => 'Zaškrtnúť v príklade'

        ],
    ],

    // Do not delete me :) I'm used for auto-generation
];
