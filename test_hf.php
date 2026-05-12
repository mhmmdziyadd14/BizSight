<?php
$envPath = __DIR__ . '/.env';
$env = parse_ini_file($envPath);
$key = $env['HUGGINGFACE_API_KEY'] ?? '';

$model = 'meta-llama/Llama-3.2-11B-Vision-Instruct';
$ch = curl_init("https://api-inference.huggingface.co/models/$model");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Authorization: Bearer ' . $key,
    'Content-Type: application/json'
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
    'inputs' => 'Hello'
]));
$out = curl_exec($ch);
echo "Result: $out\n";
