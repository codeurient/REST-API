<?php
class CustomerService
{
    private $db;

    public function __construct()
    {
        $this->db = new PDO("mysql:host=localhost;dbname=soap_demo;charset=utf8", "root", "");
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function AddCustomer($name, $email)
    {
        $stmt = $this->db->prepare("INSERT INTO customers (name, email) VALUES (?, ?)");
        $stmt->execute([$name, $email]);
        return "Müştəri əlavə olundu: ID " . $this->db->lastInsertId();
    }
    //! 1) Sadə versiya
    public function GetAllCustomer()
    {
        $stmt = $this->db->query("SELECT * FROM customers");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return  $rows;
    }
    //! 2) Dəqiqləşdirilmiş SoapVar versiyası
    // public function GetAllCustomer()
    // {
    //     $stmt = $this->db->query("SELECT * FROM customers");
    //     $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //     $customerSoapVars = [];
    //     foreach ($rows as $row) {
    //         $customerSoapVars[] = new SoapVar(
    //             (object)[
    //                 'id'    => (int)$row['id'],
    //                 'name'  => $row['name'],
    //                 'email' => $row['email']
    //             ],
    //             SOAP_ENC_OBJECT,
    //             'Customer',
    //             'http://localhost/REST-API/wsdl/customer',
    //             'customer'
    //         );
    //     }

    //     $customerList = new SoapVar(
    //         $customerSoapVars,
    //         SOAP_ENC_ARRAY,
    //         'CustomerList',
    //         'http://localhost/REST-API/wsdl/customer',
    //         'customers'
    //     );

    //     // server GetAllCustomerResponse wrapper-i özü yaradır -> biz sadəcə message part-ı qaytarırıq
    //     return $customerList;
    // }

    //! 3) İkiqat container 
    // public function GetAllCustomer()
    // {
    //     $stmt = $this->db->query("SELECT * FROM customers");
    //     $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //     $customers = [];
    //     foreach ($rows as $row) {
    //         // Hər bir customer üçün SoapVar yaradırıq, lakin burada birbaşa array istifadə edirik.
    //         $customers[] = new SoapVar(
    //             [
    //                 'id' => (int)$row['id'],
    //                 'name' => $row['name'],
    //                 'email' => $row['email']
    //             ],
    //             SOAP_ENC_OBJECT,
    //             'Customer', // WSDL-dəki complexType adı
    //             'http://localhost/REST-API/wsdl/customer' // namespace
    //         );
    //     }

    //     // CustomerList tipi üçün SoapVar yaradırıq.
    //     $customerList = new SoapVar(
    //         $customers,
    //         SOAP_ENC_OBJECT,
    //         'CustomerList',
    //         'http://localhost/REST-API/wsdl/customer'
    //     );

    //     return new SoapVar(
    //         ['customers' => $customerList],
    //         SOAP_ENC_OBJECT,
    //         'GetAllCustomerResponse',
    //         'http://localhost/REST-API/wsdl/customer'
    //     );
    // }

    public function GetCustomer($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM customers WHERE id=?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: ["id" => 0, "name" => "N/A", "email" => "N/A"];
    }

    public function UpdateCustomer($id, $name, $email)
    {
        $stmt = $this->db->prepare("UPDATE customers SET name=?, email=? WHERE id=?");
        $stmt->execute([$name, $email, $id]);
        return "Müştəri yeniləndi (ID $id)";
    }

    public function DeleteCustomer($id)
    {
        $stmt = $this->db->prepare("DELETE FROM customers WHERE id=?");
        $stmt->execute([$id]);

        if ($stmt->rowCount() > 0) {
            return "Müştəri silindi (ID $id)";
        } else {
            return "Müştəri tapılmadı (ID $id)";
        }
    }
}

$server = new SoapServer("http://localhost/REST-API/wsdl/customer.wsdl");
$server->setClass("CustomerService");
$server->handle();
