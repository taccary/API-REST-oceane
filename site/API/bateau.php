<?php
function getBateaux($pdo) {
    $stmt = $pdo->query("SELECT * FROM bateau");
    echo json_encode($stmt->fetchAll());
}
