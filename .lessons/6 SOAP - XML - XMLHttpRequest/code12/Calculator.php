<?php
class Calculator {
    public function Add($request) {
        return $request->num1 + $request->num2;
    }
}

$server = new SoapServer("http://localhost/REST-API/calculator.wsdl");
$server->setClass("Calculator");
$server->handle();




