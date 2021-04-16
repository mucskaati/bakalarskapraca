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
        'title' => 'Graph layouts',

        'actions' => [
            'index' => 'Graph layouts',
            'create' => 'New layout',
            'edit' => 'Edit layout - :name',
        ],

        'columns' => [
            'id' => 'ID',
            'columns' => 'Columns number',
            'height' => 'Height',
            'margin' => 'Margin',
            'name' => 'Title',
            'rows' => 'Rows number',
            'type' => 'Layout type',
            'width' => 'Width',
            'xaxis' => 'Xaxis',
            'yaxis' => 'Yaxis',
            'type_fo' => 'Single',
            'type_comparison' => 'Comparison',
            'type_path' => 'Path based',

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
            'title' => 'Parameter title',
            'depended_slider_id' => 'Set the slider value',
            'same_as_added_slider' => 'The same as the added slider',
            'value_function' => 'Or the function value written below',
            'add_dependency' => 'Add another dependency',
            'delete' => 'Remove dependency',
            'visible' => 'Visible',
            'label' => 'Slider label',
            'columns' => 'How many columns should the slide occupy',
            'columns_desc' => 'The number of columns should be displayed, in the case of the whole row enter 12',
            'sorting' => 'Sliders order',
            'sorting_desc' => 'The order in which the slides should be displayed. If you want the slider to be displayed first, enter the number 1',
            'comparison_experiment_id' => 'Slider to the scheme',
            'type' => 'Slider connected to',
            'experiment_fo' => 'Experiment',
            'scheme' => 'Scheme (comparison experiment)',
            'dependencies' => 'Sliders dependencies on this slider'
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
            'title' => 'Checkbox title',
            'add_dependency' => 'Add another dependency',
            'slider_id' => 'Set the slider value',
            'value_function' => 'To the value or function below',
            'delete' => 'Delete dependency',
            'slider_dependency_change' => 'Update dependency values ​​after slider change',
            'type' => 'Checkbox connected to',
            'experiment_fo' => 'Experiment',
            'scheme' => 'Scheme (comparison experiment)',
            'dependencies' => 'Sliders dependencies on this slider',
            'checkbox_checked' => 'If the checkbox is checked'

        ],
    ],

    'experiment' => [
        'title' => 'Single exp.',

        'actions' => [
            'index' => 'Single experiments',
            'create' => 'New single experiment',
            'edit' => 'Edit single experiment - :name',
        ],

        'columns' => [
            'id' => 'ID',
            'ajax_url' => 'Ajax URL',
            'description' => 'Description',
            'export' => 'Enable export to PDF',
            'layout_id' => 'Graph layout',
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
        'title' => 'Schemes (comp.)',

        'actions' => [
            'index' => 'Schemes (comparisons)',
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
            'schema' => 'Scheme image',
            'shortcut' => 'Shortcut'
        ],
    ],

    'comparison' => [
        'title' => 'Comparison exp.',

        'actions' => [
            'index' => 'Comparison exp.',
            'create' => 'New comparison experiment',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'ajax_url' => 'Ajax URL',
            'description' => 'Description',
            'export' => 'Enable export to PDF',
            'layout_id' => 'Graph layout',
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
        'title' => 'Demos (comp.)',

        'actions' => [
            'index' => 'Examples',
            'create' => 'New example',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'experiment_id' => 'Comparison experiment',
            'title' => 'Example title',
            'sliders' => 'Set the slider',
            'checkboxes' => 'Checkbox',
            'add_slider' => 'Add slider settings',
            'add_checkbox' => 'Add another checkbox',
            'delete' => 'Delete',
            'value' => 'Set value to',
            'schemes' => 'Scheme',
            'add_scheme' => 'Add schema visibility settings',
            'checked' => 'Check in the example',
            'set_slider_in_example' => 'Set sliders in example',
            'set_checkbox_in_example' => 'Set checkboxes in example',
            'set_scheme_visibility_in_example' => 'Set scheme visibility in example'
        ],
    ],

    'nyquist_experiment' => [
        'title' => 'Path based exp.',

        'actions' => [
            'index' => 'Path based experiments',
            'create' => 'New path based experiment',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'ajax_url' => 'Ajax URL',
            'description' => 'Description',
            'export' => 'Enable export to PDF',
            'layout_id' => 'Graph layout',
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
            'show_legend' => 'Show legend',
            'custom_js' => 'Custom Javascript code',
            'slug' => 'Link',
            'run_button' => 'Update the graph on the run button click',
            'template' => 'Template',
            'add_path' => 'Add path to experiment',
            'delete_path' => 'Delete path',
            'add_schemes' => 'ADD SCHEMES',
            'sliders_to_scheme' => 'ADD SLIDERS TO SCHEME',
            'checkboxes_to_scheme' => 'ADD CHECKBOXES TO SCHEME',
            'paths' => 'Set paths to experiment',
            'path1' => 'Get path 1. trace',
            'path2' => 'Get path 2. trace',
            'path1_name' => '1. trace name',
            'path2_name' => '2. trace name',
            'legend_color' => 'Legend color',
            'add_experiment' => 'ADD EXPERIMENT',
            'edit_experiment' => 'EDIT EXPERIMENT'

        ],
    ],

    // Do not delete me :) I'm used for auto-generation
];
