<?php

return [
    'adminPermission' => [
        'type' => 2,
        'description' => 'Admin Permission',
    ],
    'adminRole' => [
        'type' => 1,
        'children' => [
            'adminPermission',
        ],
    ],
];
