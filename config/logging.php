<?php
return [
    'job' => [
        'driver' => 'daily',
        'path' => storage_path('logs/job/job.log'),
        'level' => 'debug',
        'days' => 1,
        ]
];