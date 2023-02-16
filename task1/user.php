<?php
// Параметры для подключения к базе данных
$servername = "localhost";
$username = "user";
$password = "pass";
$dbname = "db";

// Создаем подключение к базе данных
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Проверяем соединение
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Получаем всех пользователей из базы данных
function getUsers($conn) {
    $sql = "SELECT * FROM users";
    $result = mysqli_query($conn, $sql);
    $users = array();
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $users[] = $row;
        }
    }
    return json_encode($users);
}

// Создаем нового пользователя
function createUser($conn, $name, $surname, $position) {
    $sql = "INSERT INTO users (name, surname, position) VALUES ('$name', '$surname', '$position')";
    mysqli_query($conn, $sql);
    return json_encode(array('name' => $name, 'surname' => $surname, 'position' => $position));
}

// Получаем пользователя по ID
function getUser($conn, $id) {
    $sql = "SELECT * FROM users WHERE id=$id";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return json_encode($row);
    } else {
        return false;
    }
}

// Обновляем пользователя по ID
function updateUser($conn, $id, $name, $surname, $position) {
    $sql = "UPDATE users SET name='$name', surname='$surname', position='$position' WHERE id=$id";
    mysqli_query($conn, $sql);
    return json_encode(array('id' => $id, 'name' => $name, 'surname' => $surname, 'position' => $position));
}

// Удаляем пользователя по ID
function deleteUser($conn, $id) {
    $sql = "DELETE FROM users WHERE id=$id";
    mysqli_query($conn, $sql);
    return json_encode(array('id' => $id));
}

// Обработка запросов
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        echo getUser($conn, $id);
    } else {
        echo getUsers($conn);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $position = $_POST['position'];
    echo createUser($conn, $name, $surname, $position);
} elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    parse_str(file_get_contents("php://input"), $put_vars);
    $id = $put_vars['id'];
    $name = $put_vars['name'];
    $surname = $put_vars['surname'];
    $position = $put_vars['position'];
    echo updateUser($conn, $id, $name, $surname, $position);
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    parse_str(file_get_contents("php://input"), $put_vars);
    $id = $put_vars['id'];
    echo deleteUser($conn, $id);
}
