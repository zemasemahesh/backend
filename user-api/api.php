<?php
require_once 'User.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// your logic here

header("Content-Type: application/json");
$method = $_SERVER['REQUEST_METHOD'];
$user = new User($pdo);

switch ($method) {
    case 'GET':
        if (!empty($_GET['id'])) {
            $data = $user->get($_GET['id']);
        } else {
            $data = $user->getAll();
        }
        echo json_encode($data);
        break;

    case 'POST':
        $input = json_decode(file_get_contents("php://input"), true);
        if ($user->create($input)) {
            echo json_encode(['message' => 'User created successfully']);
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'Failed to create user']);
        }
        break;

    case 'PUT':
        $input = json_decode(file_get_contents("php://input"), true);
        $id = $_GET['id'] ?? null;

        try {
            if ($id && $user->update($id, $input)) {
                echo json_encode(['message' => 'User updated successfully']);
            } else {
                http_response_code(400);
                echo json_encode(['message' => 'Failed to update user']);
            }
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(['error' => $e->getMessage()]);
        }
        break;


    case 'DELETE':
        $id = $_GET['id'] ?? null;

        try {
            if ($id && $user->delete($id)) {
                echo json_encode(['message' => 'User deleted successfully']);
            } else {
                http_response_code(400);
                echo json_encode(['message' => 'Failed to delete user']);
            }
        } catch (Exception $e) {
            http_response_code(404);
            echo json_encode(['error' => $e->getMessage()]);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(['message' => 'Method not allowed']);
        break;
}
