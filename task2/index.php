<?php
// Параметры для подключения к базе данных
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tests";
// устанавливаем соединение с базой данных
$mysqli = new mysqli($servername, $username, $password, $dbname);

// проверяем соединение на ошибки
if ($mysqli->connect_errno) {
die('Ошибка соединения: ' . $mysqli->connect_error);
}

// выполняем SQL-запрос
$result = $mysqli->query("SELECT g.name, JSON_OBJECTAGG(af.name, afv.value) as additional_fields
FROM goods g
JOIN additional_goods_field_values agfv ON g.id = agfv.good_id
JOIN additional_field_values afv ON agfv.additional_field_value_id = afv.id
JOIN additional_fields af ON afv.additional_field_id = af.id
GROUP BY g.id");

// проверяем результат на ошибки
if (!$result) {
die('Ошибка выполнения запроса: ' . $mysqli->error);
}

// выводим результаты запроса
while ($row = $result->fetch_assoc()) {
echo 'Имя товара: ' . $row['name'] . '<br>';
echo 'Дополнительные поля: ' . $row['additional_fields'] . '<br>';
}

// освобождаем память и закрываем соединение
$result->free();
$mysqli->close();