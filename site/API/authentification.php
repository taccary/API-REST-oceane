<?php
require_once __DIR__ . '/lib/JWT.php';
require_once __DIR__ . '/lib/Key.php';

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

function login($pdo, $data) {
    if (!isset($data['username']) || !isset($data['password'])) {
        return json_encode(["error" => "Champs manquants"]);
    }
    $stmt = $pdo->prepare("SELECT * FROM utilisateur WHERE mailU = :username");
    $stmt->execute(['username' => $data['username']]);
    $user = $stmt->fetch();
    if (!$user || !password_verify($data['password'], $user['mdpU'])) {
        return json_encode(["error" => "Identifiants invalides"]);
    } else {
        // Générer un JWT
        $payload = [
            "user_id" => $user['id'],
            "exp" => time() + 3600
        ];
        $jwt = JWT::encode($payload, 'votre_cle_secrete', 'HS256');
        return json_encode(["token" => $jwt]);
    }
}

function checkJWT() {
    $headers = getallheaders();
    $authHeader = $headers['Authorization'] ?? $headers['authorization'] ?? null;
    if (!$authHeader) {
        http_response_code(401);
        echo json_encode(["error" => "Token manquant"]);
        exit;
    }
    $token = str_replace('Bearer ', '', $authHeader);
    try {
        $decoded = JWT::decode($token, new Key('votre_cle_secrete', 'HS256'));
        return $decoded;
    } catch (Exception $e) {
        http_response_code(401);
        echo json_encode(["error" => "Token invalide"]);
        exit;
    }
}