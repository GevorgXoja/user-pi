<?php
require 'config.php';


$method = $_SERVER['REQUEST_METHOD'];


$data = json_decode(file_get_contents('php://input'), true);


$request = explode('/', trim($_SERVER['PATH_INFO'],'/'));


switch ($method) {
    case 'POST':
        if ($request[0] === 'users') {
            createUser($data);
        } elseif ($request[0] === 'auth') {
            authenticateUser($data);
        }
        break;
    case 'PUT':
        if ($request[0] === 'users' && isset($request[1])) {
            updateUser($request[1], $data);
        }
        break;
    case 'DELETE':
        if ($request[0] === 'users' && isset($request[1])) {
            deleteUser($request[1]);
        }
        break;
    case 'GET':
        if ($request[0] === 'users' && isset($request[1])) {
            getUser($request[1]);
        }
        break;
    default:
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}


function createUser($data) {
    global $conn;

    $username = $data['username'];
    $password = password_hash($data['password'], PASSWORD_DEFAULT);
    $email = $data['email'];

    $sql = "INSERT INTO users (username, password, email) VALUES ('$username', '$password', '$email')";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["message" => "User created successfully"]);
    } else {
        echo json_encode(["error" => $conn->error]);
    }
}

function updateUser($id, $data) {
    global $conn;

    $username = $data['username'];
    $email = $data['email'];

    $sql = "UPDATE users SET username='$username', email='$email' WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["message" => "User updated successfully"]);
    } else {
        echo json_encode(["error" => $conn->error]);
    }
}

function deleteUser($id) {
    global $conn;

    $sql = "DELETE FROM users WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(["message" => "User deleted successfully"]);
    } else {
        echo json_encode(["error" => $conn->error]);
    }
}

function getUser($id) {
    global $conn;

    $sql = "SELECT * FROM users WHERE id=$id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo json_encode($result->fetch_assoc());
    } else {
        echo json_encode(["error" => "User not found"]);
    }
}

function authenticateUser($data) {
    global $conn;

    $username = $data['username'];
    $password = $data['password'];

    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            echo json_encode(["message" => "Authentication successful"]);
        } else {
            echo json_encode(["error" => "Invalid credentials"]);
        }
    } else {
        echo json_encode(["error" => "User not found"]);
    }
}
?>
