<?php

$cssPath = 'http://lab-6/css/style.css';
echo "<link rel='stylesheet' href=$cssPath type='text/css'>";

$bd = null;
$host = "127.0.0.1";
$db_name = "lab6";
$username = "root";
$password = "root";
$tableName = "visitors";

function runLabScript()
{
    global $db;

    echo '<div>';
    if (!connectToDatabase($msg)) {
        echo 'Невозможно соединиться с базой данных!<br>Ошибка: ' . $msg;
        return;
    };

    echo 'Соединение с базой данных установлено.<br>';

    if (!checkDbTable()) {
        echo 'Создание таблицы пользователей.<br>';
        if (!createDbTable($msg)) {
            echo 'Невозможно создать таблицу в базе данных!<br>' . $msg;
            $db->close();
            return;
        }
    }

    if (!getUserIp($ip)) {
        echo 'Невозможно получить IP пользователя!<br>';
        $db->close();
        return;
    }

    echo 'Текущий IP: ' . $ip . '<br>';

    if (!recordVisit($ip, $msg)) {
        echo 'Невозможно записать данные в таблицу!<br>' . $msg;
        $db->close();
        return;
    }

    if (!getTable($table, $msg)) {
        echo 'Невозможно получить таблицу!<br>' . $msg;
        $db->close();
        return;
    }
    outputTable($table);
    echo '</div>';

    $table->close();
    $db->close();
}

function connectToDatabase(&$msg)
{
    global $db, $host, $username, $password, $db_name;
    $db = new mysqli($host, $username, $password);

    if ($db->connect_errno !== 0) {
        $msg = $db->connect_errno . ': ' . $db->connect_error;
        return false;
    }

    if ($db->select_db($db_name)) {
        return true;
    }

    $query = "CREATE DATABASE $db_name";
    if (!$db->query($query)) {
        $msg = $db->error;
        return false;
    }

    if (!$db->select_db($db_name)) {
        $msg = $db->error;
        return false;
    }
    return true;
}

function checkDbTable()
{
    global $db, $db_name, $tableName;
    $tableList = $db->query("SHOW TABLES FROM $db_name");

    while ($row = $tableList->fetch_row()) {
        if ($row[0] === $tableName) return true;
    }

    $tableList->close();
    return false;
}

function createDbTable(&$msg)
{
    global $db, $tableName;
    $query = "CREATE TABLE $tableName (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        ip VARCHAR(16) NOT NULL,
        visit_count INT(6) NOT NULL
        )";


    if ($db->query($query) === FALSE) {
        $msg = $msg = $db->connect_errno . ': ' . $db->connect_error;
        return false;
    }

    return true;
}

function getUserIp(&$ip_address)
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip_address = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip_address = $_SERVER['REMOTE_ADDR'];
    }

    return !$ip_address->empty;
}

function recordVisit($ip, &$msg)
{
    global $db, $tableName;
    $query = "SELECT * FROM $tableName WHERE ip='$ip'";
    $record = $db->query($query);

    if ($db->error) {
        $msg = $db->error;
        return false;
    }

    if ($record->num_rows === 0) {
        // first visit from current ip
        $query = "INSERT INTO $tableName (ip, visit_count) VALUES ('$ip', 1)";
    } else {
        $row = $record->fetch_row();
        $visitCount = $row[2] + 1;
        $query = "UPDATE $tableName SET visit_count=$visitCount WHERE ip='$ip'";
    }

    if ($db->query($query) === FALSE) {
        $msg = $db->error;
        return false;
    }
    $record->close();
    return true;
}

function getTable(&$table, &$msg)
{
    global $db, $tableName;
    $query = "SELECT * FROM $tableName";
    $table = $db->query($query);
    if ($db->error) {
        $msg = $db->error;
        return false;
    }

    return true;
}

function outputTable($table)
{
    global $tableName;
    echo "<h4>$tableName</h4>";
    echo '<table>';
    echo "<tr><th>ID</th><th>IP</th><th>Visit count</th></tr>";
    while ($row = $table->fetch_row()) {
        echo "<tr><td>";
        echo $row[0];
        echo "</td><td>";
        echo $row[1];
        echo "</td><td>";
        echo $row[2];
        echo "</td></tr>";
    }
    echo "</table>";
}
