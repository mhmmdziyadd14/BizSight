<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$key = env('GEMINI_API_KEY');
if (!$key) {
    echo "NO KEY\n";
    exit;
}

$payload = [
    'contents' => [
        [
            'parts' => [
                ['text' => 'Hello, output a valid JSON containing { "test": "ok" }.']
            ]
        ]
    ],
    'generationConfig' => [
        'response_mime_type' => 'application/json'
    ]
];

try {
    $res = \Illuminate\Support\Facades\Http::withoutVerifying()
        ->get('https://generativelanguage.googleapis.com/v1beta/models?key=' . $key);
    
    echo "STATUS: " . $res->status() . "\n";
    echo "BODY:\n" . $res->body() . "\n";
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
