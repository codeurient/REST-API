<?php
// JSON header göndərək
header('Content-Type: application/json');

// Sadələşdirilmiş user array
$users = [
    1 => ['id' => 1, 'name' => 'Ali', 'email' => 'ali@example.com'],
    2 => ['id' => 2, 'name' => 'Vəli', 'email' => 'veli@example.com']
];

// İstək parametrlərini oxu
$method = $_SERVER['REQUEST_METHOD']; // GET, POST, PUT, DELETE
$id = $_GET['id'] ?? null;

// Sadə ROUTER
switch ($method) {
    case 'GET':
        if ($id && isset($users[$id])) {
            echo json_encode($users[$id]);
        } else {
            echo json_encode(array_values($users)); // bütün user-lər
        }
        break;

    case 'POST':
        // Sadə test üçün POST datanı götürək
        $input = json_decode(file_get_contents("php://input"), true);
        if ($input && isset($input['name']) && isset($input['email'])) {
            $newId = max(array_keys($users)) + 1;
            $users[$newId] = [
                'id' => $newId,
                'name' => $input['name'],
                'email' => $input['email']
            ];
            echo json_encode(['status' => 'created', 'user' => $users[$newId]]);
        } else {
            echo json_encode(['error' => 'Invalid data']);
        }
        break;

    default:
        echo json_encode(['error' => 'Unsupported request']);
        break;
}
