<?php
header("Content-Type: application/json");
include 'configBdd.php';
require __DIR__ . '/API/bateau.php';


$method = $_SERVER['REQUEST_METHOD'];
$path = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$segments = explode('/', $path);

$pdo = getPDO();
$resultat = null;

if ($segments[0] === 'bateaux') {
    switch ($method) {
        case 'GET':
            $resultat = getBateaux($pdo);
            break;
        default:
            $resultat = json_encode(["status" => "error", "message" => "Méthode non autorisée"]);
    }
}


echo $resultat;