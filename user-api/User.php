<?php
require_once 'db.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");


class User
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAll()
    {
        $stmt = $this->pdo->query("SELECT * FROM users");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get($id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $stmt = $this->pdo->prepare("INSERT INTO users (name, email, password, dob) VALUES (?, ?, ?, ?)");
        $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT);
        return $stmt->execute([$data['name'], $data['email'], $data['password'], $data['dob']]);
    }

    public function update($id, $data)
    {
        // Check if user exists
        $user = $this->get($id);
        if (!$user) {
            throw new Exception("User not found.");
        }

        // Use existing values if not provided
        $name = $data['name'] ?? $user['name'];
        $email = $data['email'] ?? $user['email'];
        $dob = $data['dob'] ?? $user['dob'];
        $password = isset($data['password']) ? password_hash($data['password'], PASSWORD_BCRYPT) : $user['password'];

        // Check if email is already used by another user
        $stmt = $this->pdo->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
        $stmt->execute([$email, $id]);
        if ($stmt->fetch()) {
            throw new Exception("Email already in use by another user.");
        }

        // Perform update
        $stmt = $this->pdo->prepare("UPDATE users SET name = ?, email = ?, password = ?, dob = ? WHERE id = ?");
        return $stmt->execute([$name, $email, $password, $dob, $id]);
    }



    public function delete($id)
    {
        // Check if user exists
        $user = $this->get($id);
        if (!$user) {
            throw new Exception("User not found.");
        }

        $stmt = $this->pdo->prepare("DELETE FROM users WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
