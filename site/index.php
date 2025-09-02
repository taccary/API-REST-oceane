<?php
header("Content-Type: application/json");

// require 'vendor/autoload.php';
include 'configBdd.php';
// require_once 'src/utils/jwtUtils.php';

$method = $_SERVER['REQUEST_METHOD'];
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Ajuster le chemin pour gérer les sous-répertoires
$basePath = '/API';
$relativePath = str_replace($basePath, '', $path);

try {
    $pdo = new PDO($_ENV['DSN'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD'], $_ENV['OPTIONS']);

    switch ($relativePath) {
        // case '/login':
        //     require 'src/handlers/login.php';
        //     handleLogin($pdo);
        //     break;

        // case '/userInfo':
        //     require 'src/handlers/userInfo.php';
        //     handleUserInfo($pdo);
        //     break;

        case '/bateaux':
            require '/API/bateau.php';
            handleBateaux($pdo, $method);
            break;

        default:
            echo json_encode(["status" => "error", "message" => "Route non trouvée"]);
            break;
    }
} catch (PDOException $e) {
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
}
