<?php
// JSON header
header('Content-Type: application/json');

// Sadələşdirilmiş user array
$users = [
    1 => ['id' => 1, 'name' => 'Ali', 'email' => 'ali@example.com'],
    2 => ['id' => 2, 'name' => 'Vəli', 'email' => 'veli@example.com']
];

// Request məlumatlarını oxu
$method = $_SERVER['REQUEST_METHOD']; // GET, POST, PUT, DELETE
$id = $_GET['id'] ?? null;

// Input-u oxumaq üçün funksiya (POST/PUT üçün)
function getInputData() {
    return json_decode(file_get_contents("php://input"), true);
}

// ROUTER
switch ($method) {
    case 'GET':
        if ($id && isset($users[$id])) {
            echo json_encode($users[$id]);
        } else {
            echo json_encode(array_values($users)); // bütün user-lər
        }
        break;

    case 'POST':
        $input = getInputData();
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

    case 'PUT':
        if ($id && isset($users[$id])) {
            $input = getInputData();
            if ($input) {
                $users[$id]['name'] = $input['name'] ?? $users[$id]['name'];
                $users[$id]['email'] = $input['email'] ?? $users[$id]['email'];
                echo json_encode(['status' => 'updated', 'user' => $users[$id]]);
            } else {
                echo json_encode(['error' => 'Invalid data']);
            }
        } else {
            echo json_encode(['error' => 'User not found']);
        }
        break;

    case 'DELETE':
        if ($id && isset($users[$id])) {
            unset($users[$id]);
            echo json_encode(['status' => 'deleted', 'id' => $id]);
        } else {
            echo json_encode(['error' => 'User not found']);
        }
        break;

    default:
        echo json_encode(['error' => 'Unsupported request']);
        break;
}
