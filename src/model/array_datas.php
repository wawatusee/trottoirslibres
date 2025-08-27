<?php class ArrayDatas {
    private $filePath;
    private $data;

    public function __construct($filePath) {
        $this->filePath = $filePath;
        $this->loadData();
    }

    private function loadData() {
        if (file_exists($this->filePath)) {
            $json = file_get_contents($this->filePath);
            $this->data = json_decode($json, true);
        } else {
            $this->data = [];
        }
    }

    public function get_arrayDatas() {
        return $this->data;
    }
}