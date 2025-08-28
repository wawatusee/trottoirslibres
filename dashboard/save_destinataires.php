<?php
session_start();
if (!isset($_SESSION['user'])) {
    echo json_encode(["success" => false, "message" => "Non autorisé."]);
    exit();
}

$input = file_get_contents("php://input");
if (!$input) {
    echo json_encode(["success" => false, "message" => "Aucune donnée reçue."]);
    exit();
}

$data = json_decode($input, true);
if ($data === null) {
    echo json_encode(["success" => false, "message" => "Format JSON invalide."]);
    exit();
}

$file = "../json/destinataires.json";
if (file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE))) {
    echo json_encode(["success" => true, "message" => "Fichier sauvegardé avec succès."]);
} else {
    echo json_encode(["success" => false, "message" => "Erreur lors de l'écriture du fichier."]);
}
