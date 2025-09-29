<?php
// server.php

class CustomerService
{
    private $db;

    public function __construct()
    {
        $this->db = new PDO("mysql:host=localhost;dbname=soap_demo;charset=utf8", "root", "");
    }

    // 1. Yeni müştəri əlavə et
    public function AddCustomer($name, $email)
    {
        $stmt = $this->db->prepare("INSERT INTO customers (name, email) VALUES (?, ?)");
        $stmt->execute([$name, $email]);
        return "Müştəri əlavə olundu: ID " . $this->db->lastInsertId();
    }

    // 2. Müştəri gətir (ID üzrə)
    public function GetCustomer($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM customers WHERE id=?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: ["error" => "Müştəri tapılmadı"];
    }

    // 3. Müştəri məlumatını yenilə
    public function UpdateCustomer($id, $name, $email)
    {
        $stmt = $this->db->prepare("UPDATE customers SET name=?, email=? WHERE id=?");
        $stmt->execute([$name, $email, $id]);
        return "Müştəri yeniləndi (ID $id)";
    }
}

$server = new SoapServer("http://localhost/REST-API/wsdl/customer.wsdl");
$server->setClass("CustomerService");
$server->handle();