<?php
// API endpoint
$url = "http://localhost:8888/api.php";

// --- GET request ---
$ch = curl_init("$url?id=1");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);
echo "GET User 1: $response\n";

// --- POST request ---
$ch = curl_init($url);
$data = json_encode(['name' => 'Nigar', 'email' => 'nigar@example.com']);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
$response = curl_exec($ch);
curl_close($ch);
echo "POST new User: $response\n";
