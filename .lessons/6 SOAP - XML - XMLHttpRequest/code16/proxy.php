<?php

$url = 'https://www.tcmb.gov.tr/kurlar/today.xml';


$ch = curl_init($url);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

curl_close($ch);

if ($response === false || $httpCode !== 200) {
    http_response_code(502);
    header('Content-Type: text/plain; charset=UTF-8');
    echo "Xəta: TCMB-dən məlumat alınmadı (kod: $httpCode)";
    exit;
}
header('Content-Type: application/xml; charset=UTF-8');
echo $response;