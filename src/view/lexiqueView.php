<?php 
class LexiqueView {
    private $data;
    private $lang;

    public function __construct($data, $lang) {
        $this->data = $data;
        $this->lang = $lang;
    }

    public function getSectionLexique($section) {
        if (isset($this->data['refs'][$section])) {
            return (object) $this->data['refs'][$section];
        }
        return null;
    }
    public function getSectionLexiques($section) {
        if (isset($this->data->refs->$section)) {
            return $this->data->refs->$section;
        }
        return null;
    }
}
