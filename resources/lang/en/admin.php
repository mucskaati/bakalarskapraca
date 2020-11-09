<?php

return [
    'admin-user' => [
        'title' => 'Users',

        'actions' => [
            'index' => 'Users',
            'create' => 'New User',
            'edit' => 'Edit :name',
            'edit_profile' => 'Edit Profile',
            'edit_password' => 'Edit Password',
        ],

        'columns' => [
            'id' => 'ID',
            'last_login_at' => 'Last login',
            'activated' => 'Activated',
            'email' => 'Email',
            'first_name' => 'First name',
            'forbidden' => 'Forbidden',
            'language' => 'Language',
            'last_name' => 'Last name',
            'password' => 'Password',
            'password_repeat' => 'Password Confirmation',
                
            //Belongs to many relations
            'roles' => 'Roles',
                
        ],
    ],

    'layout' => [
        'title' => 'Layouts',

        'actions' => [
            'index' => 'Layouts',
            'create' => 'New Layout',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'columns' => 'Columns',
            'height' => 'Height',
            'margin' => 'Margin',
            'name' => 'Name',
            'rows' => 'Rows',
            'type' => 'Type',
            'width' => 'Width',
            'xaxis' => 'Xaxis',
            'yaxis' => 'Yaxis',
            
        ],
    ],

    'slider' => [
        'title' => 'Sliders',

        'actions' => [
            'index' => 'Sliders',
            'create' => 'New Slider',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'default' => 'Default',
            'default_function' => 'Default function',
            'layout_id' => 'Layout',
            'max' => 'Max',
            'min' => 'Min',
            'step' => 'Step',
            'title' => 'Title',
            
        ],
    ],

    'checkbox' => [
        'title' => 'Checkboxes',

        'actions' => [
            'index' => 'Checkboxes',
            'create' => 'New Checkbox',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'attribute_name' => 'Attribute name',
            'layout_id' => 'Layout',
            'title' => 'Title',
            
        ],
    ],

    // Do not delete me :) I'm used for auto-generation
];