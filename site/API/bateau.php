<?php
function getBateaux(PDO $pdo) : string {
    $stmt = $pdo->query("SELECT * FROM bateau");
    return json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}
