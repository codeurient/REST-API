<?php
$url = "http://localhost:8888/RestAPI/api.php";

// --- GET all users ---
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
echo "GET All: " . curl_exec($ch) . "\n";
curl_close($ch);

// --- POST new user ---
$ch = curl_init($url);
$data = json_encode(['name' => 'Nigar', 'email' => 'nigar@example.com']);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
echo "POST: " . curl_exec($ch) . "\n";
curl_close($ch);

// --- PUT update user ---
$ch = curl_init("$url?id=1");
$data = json_encode(['name' => 'Aylin']);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
echo "PUT: " . curl_exec($ch) . "\n";
curl_close($ch);

// --- DELETE user ---
$ch = curl_init("$url?id=2");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
echo "DELETE: " . curl_exec($ch) . "\n";
curl_close($ch);
