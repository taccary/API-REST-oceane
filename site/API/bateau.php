<?php
function getBateaux($pdo) {
    $stmt = $pdo->query("SELECT * FROM bateau");
    echo json_encode($stmt->fetchAll());
}

function getBateauData($pdo, $id) {
    $stmt = $pdo->prepare("SELECT * FROM bateau WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(); // retourne le tableau, pas le JSON
}
    
function getBateau($pdo, $id) {
    $data = getBateauData($pdo, $id);
    return json_encode($data);
}

function createBateau($pdo, $data) {
    // vérifier que les champs nécessaires sont présents
    if (!isset($data['id']) || !isset($data['nom'])) {
        return json_encode(["status" => "error", "message" => "Champs manquants"]);
    }
    $stmt = $pdo->prepare("INSERT INTO bateau (id, nom) VALUES (:id, :nom)");
    $stmt->bindValue(':id', $data['id'], PDO::PARAM_INT);
    $stmt->bindValue(':nom', $data['nom'], PDO::PARAM_STR);
    $stmt->execute();
    $bateau = getBateauData($pdo, $data['id']);
    return json_encode(["status" => "success", "bateau" => $bateau]);
}

function updateBateau($pdo, $id, $data) {
    if (!isset($data['nom'])) {
        return json_encode(["status" => "error", "message" => "Champs manquants"]);
    }
    $stmt = $pdo->prepare("UPDATE bateau SET nom = :nom WHERE id = :id");
    $stmt->bindValue(':nom', $data['nom'], PDO::PARAM_STR);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $bateau = getBateauData($pdo, $id);
    return json_encode(["status" => "success", "bateau" => $bateau]);
}

function deleteBateau($pdo, $id) {
    $stmt = $pdo->prepare("DELETE FROM bateau WHERE id = :id");
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return json_encode(["status" => "success"]);
}

