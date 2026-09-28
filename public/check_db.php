<?php
header('Content-Type: application/json');

$configs = [
    ['user' => 'root', 'pass' => ''],
    ['user' => 'root', 'pass' => 'root'],
    ['user' => 'root', 'pass' => 'admin'],
];

$results = [];

foreach ($configs as $config) {
    try {
        $conn = @new mysqli('127.0.0.1', $config['user'], $config['pass']);
        if ($conn->connect_error) {
            $results[] = "Fallo con usuario: {$config['user']} y password: '{$config['pass']}' - Error: " . $conn->connect_error;
        } else {
            $results[] = "¡ÉXITO! con usuario: {$config['user']} y password: '{$config['pass']}'";
            $conn->close();
            break;
        }
    } catch (Exception $e) {
        $results[] = "Error con {$config['user']}: " . $e->getMessage();
    }
}

echo json_encode($results, JSON_PRETTY_PRINT);
?>
