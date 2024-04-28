<?php

use plugin\admin\app\middleware\AccessControl;

return [
    '' => [

    ],
    'admin' => [
        AccessControl::class
    ]
];
