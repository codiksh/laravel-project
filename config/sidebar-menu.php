<?php

return [
    [
        'name'      => 'Users',
        'icon'      => '<i class="nav-icon fa-duotone fa-users"></i>',
        'isHeader'  => false,
        'route'     => 'admin.users.index',
        'children'  => [],
    ],
    [
        'name'      => 'Roles',
        'icon'      => '<i class="nav-icon fa fa-user-lock"></i>',
        'isHeader'  => false,
        'route'     => 'admin.roles.index',
        'children'  => [],
    ],
];
