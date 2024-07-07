<?php
// ../src/model/model_json.php

class DatasJson {
    private $jsonDirectory;
    private $jsonData;

    public function __construct($repjson) {
        $this->jsonDirectory = $repjson;
        $this->jsonData = [];
        $this->loadJsonFiles();
    }

    private function loadJsonFiles() {
        // Récupérer tous les fichiers JSON dans le répertoire
        $jsonFiles = glob($this->jsonDirectory . '*.json');

        // Parcourir chaque fichier JSON et ajouter son contenu au tableau
        foreach ($jsonFiles as $file) {
            $fileName = basename($file);
            $dateTime = $this->extractDateTimeFromFileName($fileName);
            $content = file_get_contents($file);
            $data = json_decode($content, true);
            if ($data !== null) {
                $data['dateTime'] = $dateTime; // Ajouter la date et l'heure extraites
                $this->jsonData[] = $this->normalizeData($data);
            } else {
                echo "Erreur de décodage JSON dans le fichier: $file\n";
            }
        }
    }

    private function extractDateTimeFromFileName($fileName) {
        // Extraire la date et l'heure du nom du fichier
        $pattern = '/(\d{4}-\d{2}-\d{2}_\d{2}-\d{2}-\d{2})/';
        if (preg_match($pattern, $fileName, $matches)) {
            return $matches[1];
        }
        return null;
    }

    private function normalizeData($data) {
        // Normaliser les données selon le format attendu
        return [
            'address' => [
                'adresse' => $data['address']['adresse'] ?? '',
                'numero' => $data['address']['numero'] ?? '',
                'postCode' => $data['address']['postCode'] ?? '',
                'municipality' => $data['address']['municipality'] ?? '',
                'adnc' => $data['address']['adnc'] ?? ''
            ],
            'typeEncombrement' => $data['typeEncombrement'] ?? [],
            'contactInformation' => [
                'name' => $data['contactInformation']['name'] ?? '',
                'first-name' => $data['contactInformation']['first-name'] ?? '',
                'email' => $data['contactInformation']['email'] ?? ''
            ],
            'autorisationContact' => $data['autorisationContact'] ?? false,
            'autorisationNewsletter' => $data['autorisationNewsletter'] ?? false,
            'dateTime' => $data['dateTime'] ?? ''
        ];
    }

    public function getJsonData() {
        return $this->jsonData;
    }
}
?>
