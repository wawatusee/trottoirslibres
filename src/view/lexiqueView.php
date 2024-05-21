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
    public function getObstaclesView($obstacles_arr) {
        $htmlObstacleContent = "";
        foreach($obstacles_arr as $obstacle) {
            $htmlObstacleContent .= <<<OBSTACLE
            <span>
            <input type="checkbox" id="$obstacle" name="type-encombrement[]" value="$obstacle">
            <label for="$obstacle">$obstacle</label>
            </span>
OBSTACLE;
        }
        return $htmlObstacleContent;
    }
}
