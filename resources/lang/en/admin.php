<?php

return [
    'admin-user' => [
        'title' => 'Administrators',

        'actions' => [
            'index' => 'Administrators',
            'create' => 'New Administrator',
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
        'title' => 'Layout of graphs',

        'actions' => [
            'index' => 'Layout of graphs',
            'create' => 'New layout',
            'edit' => 'Edit layout - :name',
        ],

        'columns' => [
            'id' => 'ID',
            'columns' => 'Number of columns',
            'height' => 'Height',
            'margin' => 'Margin',
            'name' => 'Title',
            'rows' => 'Number of rows',
            'type' => 'Type of layout',
            'width' => 'Width',
            'xaxis' => 'Xaxis',
            'yaxis' => 'Yaxis',
            'type_fo' => 'FO type experiment',
            'type_comparison' => 'FO type experiment',

        ],
    ],

    'slider' => [
        'title' => 'Sliders',

        'actions' => [
            'index' => 'Sliders',
            'create' => 'New slider',
            'edit' => 'Edit slider :name',
        ],

        'columns' => [
            'id' => 'ID',
            'default' => 'Default',
            'default_function' => 'Optional default function',
            'layout_id' => 'Layout / Scheme',
            'max' => 'Maximum',
            'min' => 'Minimum',
            'step' => 'Step',
            'title' => 'Title of parameter',
            'depended_slider_id' => 'Set the value of the slider',
            'same_as_added_slider' => 'The same as the added slider',
            'value_function' => 'Or the value of the function written below',
            'add_dependency' => 'Add another dependency',
            'delete' => 'Remove dependency',
            'visible' => 'Visible',
            'label' => 'Label of slider',
            'columns' => 'How many columns should the slide occupy',
            'columns_desc' => 'The number of columns should be displayed, in the case of the whole row enter 12',
            'sorting' => 'Order of sliders',
            'sorting_desc' => 'The order in which the slides should be displayed. If you want the slider to be displayed first, enter the number 1',
            'comparison_experiment_id' => 'Slider to the scheme',
            'type' => 'Slider connected to',
            'experiment_fo' => 'Experiment',
            'scheme' => 'Scheme (comparison experiment)',
            'dependencies' => 'Dependencies of sliders on this slider'
        ],
        'filters' => [
            'layout' => 'Filter by layout',
            'comparison' => 'Filter by scheme'
        ]
    ],

    'checkbox' => [
        'title' => 'Checkboxes',

        'actions' => [
            'index' => 'Checkboxes',
            'create' => 'New checkbox',
            'edit' => 'Edit checkbox :name',
        ],

        'columns' => [
            'id' => 'ID',
            'attribute_name' => 'Attribute name',
            'layout_id' => 'Layout',
            'title' => 'Title of checkbox',
            'add_dependency' => 'Add another dependency',
            'slider_id' => 'Set the value of the slider',
            'value_function' => 'To the value or function below',
            'delete' => 'Delete dependency',
            'slider_dependency_change' => 'Update dependency values ​​after slider change',
            'type' => 'Checkbox connected to',
            'experiment_fo' => 'Experiment',
            'scheme' => 'Scheme (comparison experiment)',
            'dependencies' => 'Dependencies of sliders on this slider',
            'checkbox_checked' => 'If the checkbox is checked'

        ],
    ],

    'experiment' => [
        'title' => 'FO type experiments',

        'actions' => [
            'index' => 'FO type experiments',
            'create' => 'New FO type experiment',
            'edit' => 'Edit FO type experiment - :name',
        ],

        'columns' => [
            'id' => 'ID',
            'ajax_url' => 'Ajax URL',
            'description' => 'Description',
            'export' => 'Enable export to PDF',
            'layout_id' => 'Layout of graph',
            'title' => 'Title',
            'annotation_title' => 'Graph annotation',
            'annotation_angle' => 'Annotation angle',
            'xaxis' => 'Annotation position on the X axis',
            'yaxis' => 'Annotation position on the Y axis',
            'align' => 'Annotation alignment',
            'traces_title' => 'Trace name',
            'response_xaxis' => 'X axis (response from server)',
            'response_yaxis' => 'Y axis (response from server)',
            'color' => 'Trace color (hex)',
            'legendgroup' => 'Legendgroup',
            'showlegend' => 'Show legend',
            'custom_js' => 'Custom Javascript code',
            'slug' => 'Link',
            'run_button' => 'Update the graph on the run button click',
            'template' => 'Template',
            'add_slider' => 'ADD SLIDERS',
            'add_checkbox' => 'ADD CHECKBOXES',
            'add_trace' => 'Add another trace',
            'delete_trace' => 'Delete trace',
            'left' => 'Left',
            'center' => 'Center',
            'right' => 'Right',
            'graph' => 'Graph',
            'trace' => 'Trace'

        ],
        'steps' => [
            'first' => '1. STEP',
            'second' => '2. STEP',
            'third' => '3. STEP',
            'fourth' => '4. STEP',
            'fifth' => '5. STEP',
            'go_to_third' => 'GO TO 3. STEP',
            'go_to_fourth' => 'GO TO 4. STEP',
            'go_to_fifth' => 'GO TO 5. STEP'
        ],
        'experiments' => 'Experiments',
        'components' => 'Components',
        'comparisons' => 'Comparisons',
        'settings' => 'Graph settings',
        'admin' => 'Administrator settings',
        'add_experiment' => 'ADD EXPERIMENT',
        'edit_experiment' => 'EDIT EXPERIMENT'
    ],

    'comparison-experiment' => [
        'title' => 'Schemes for comparisons',

        'actions' => [
            'index' => 'Schemes for comparisons',
            'create' => 'New scheme',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'prefix' => 'Server response prefix',
            'trace_color' => 'Trace color',
            'legendgroup' => 'Legendgroup',
            'schema' => 'Image of scheme'
        ],
    ],

    'comparison' => [
        'title' => 'Comparison type experiments',

        'actions' => [
            'index' => 'Comparison type experiments',
            'create' => 'New comparison type experiment',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'ajax_url' => 'Ajax URL',
            'description' => 'Description',
            'export' => 'Enable export to PDF',
            'layout_id' => 'Layout of graph',
            'title' => 'Title',
            'annotation_title' => 'Graph annotation',
            'annotation_angle' => 'Annotation angle',
            'xaxis' => 'Annotation position on the X axis',
            'yaxis' => 'Annotation position on the Y axis',
            'align' => 'Annotation alignment',
            'traces_title' => 'Trace name',
            'response_xaxis' => 'X axis (response from server)',
            'response_yaxis' => 'Y axis (response from server)',
            'color' => 'Trace color (hex)',
            'legendgroup' => 'Legendgroup',
            'showlegend' => 'Show legend',
            'custom_js' => 'Custom Javascript code',
            'slug' => 'Link',
            'run_button' => 'Update the graph on the run button click',
            'template' => 'Template',
            'add_scheme' => 'Add scheme to comparison',
            'scheme' => 'Experiment scheme',
            'delete_scheme' => 'Delete experiment scheme',
            'add_schemes' => 'ADD SCHEMES',
            'sliders_to_scheme' => 'ADD SLIDERS TO SCHEME',
            'checkboxes_to_scheme' => 'ADD CHECKBOXES TO SCHEME',
            'experiment_schemes' => 'Experiment schemes for comparison'

        ],
    ],

    'example' => [
        'title' => 'Examples in comparisons',

        'actions' => [
            'index' => 'Examples',
            'create' => 'New experiment',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'experiment_id' => 'Comparison type experiment',
            'title' => 'Title of example',
            'sliders' => 'Set the slider',
            'checkboxes' => 'Checkbox',
            'add_slider' => 'Add slider settings',
            'add_checkbox' => 'Add another checkbox',
            'delete' => 'Delete',
            'value' => 'Set value to',
            'schemes' => 'Scheme',
            'add_scheme' => 'Add schema visibility settings',
            'checked' => 'Check in the example'
        ],
    ],

    // Do not delete me :) I'm used for auto-generation
];
