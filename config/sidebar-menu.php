<?php

return [
    [
        'name'      => 'MANAGE',
        'isHeader'  => true,
        'route'     => null,
        'children'  => [],
    ],
    [
        'name'      => '<i class="nav-icon fa fa-users"></i><p>Users</p>',
        'isHeader'  => false,
        'route'     => 'admin.users.index',
        'children'  => [],
    ],
];
