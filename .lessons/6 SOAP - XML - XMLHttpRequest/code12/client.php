<?php

try {
    $client = new SoapClient("http://localhost/REST-API/calculator.wsdl");

    $result = $client->Add(["num1" => 5, "num2" => 7]);
    echo "Nəticə: " . $result . PHP_EOL;

} catch (Exception $e) {
    echo "Xəta: " . $e->getMessage();
}
