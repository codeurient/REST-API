<?php
header('Content-type: json/application');
require 'connect.php';
require 'function.php';

$method = $_SERVER['REQUEST_METHOD'];

$q = $_GET['q'];
$params = explode('/', $q);

$type = $params[0] ?? null;
$id   = $params[1] ?? null;

if($method === 'GET') {
    if($type === 'posts') {
        if (isset($id)) {
            getPost($connect, $id);
        } else {
            getPosts($connect);
        }
    }
} elseif ($method === 'PATCH') {
    if ($type === 'posts') {
        if(isset($id)) {
            $data = file_get_contents("php://input");
            $data = json_decode($data, true);
            updatePost($connect, $id, $data);
        }
    } 
}  elseif ($method === 'DELETE') {
    if ($type === 'posts') {
        if(isset($id)) {
            deletePost($connect, $id);
        }
    } 
}