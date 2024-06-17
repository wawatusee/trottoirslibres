<?php 
class LexiqueView {
    private $data;
    public function __construct($data) {
        $this->data = $data;

    }
    public function getSectionLexique($section) {
        if (isset($this->data['refs'][$section])) {
            return (object) $this->data['refs'][$section];
        }
        return null;
    }
    /*public function getObstaclesView($obstacles_arr) {
        $htmlObstacleContent = "";
        foreach($obstacles_arr as $obstacle) {
            $encombrement_index=array_search($obstacle , $obstacles_arr);
            $en_obstacle=$this->data['refs']["encombrements"]["en"]["values-labels"][$encombrement_index];
            var_dump($en_obstacle);
            $htmlObstacleContent .= <<<OBSTACLE
            <span>
            <input type="checkbox" id="$en_obstacle" name="type-encombrement[]" value="$obstacle">
            <label for="$obstacle">$obstacle</label>
            </span>
OBSTACLE;
        }
        return $htmlObstacleContent;
    }*/
    public function getObstaclesView($obstacles_arr) {
        $htmlObstacleContent = "";
        foreach($obstacles_arr as $obstacle) {
            $encombrement_index = array_search($obstacle, $obstacles_arr);
            $en_obstacle = $this->data['refs']["encombrements"]["en"]["values-labels"][$encombrement_index];
            $svg_url = "img/deco/obstacles/{$en_obstacle}.svg"; // Construire dynamiquement l'URL du SVG
            $htmlObstacleContent .= <<<OBSTACLE
            <label class="checkbox-container" style="background: url('$svg_url') no-repeat center center; background-size: contain;">
                <input type="checkbox" id="$en_obstacle" name="type-encombrement[]" value="$obstacle">
                <span class="checkmark"></span>
                <span class="indicator"></span>
                
            </label>
    OBSTACLE;
        }
        return $htmlObstacleContent;
    }
    


}
