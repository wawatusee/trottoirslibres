<?php class LexiqueModel {
    private $scrcJson;
    private $lexique;
    public function __construct($srcJson)
    {
        $this->srcJson=$srcJson;
        $this->lexique=json_decode(file_get_contents($this->srcJson));
    }
    public function get_lexique()
    {
        $lexique_array=$this->lexique;
        return $lexique_array;
    }
    public function getActivityById($id)
    {
        $myActivities = $this->catalogue[1]->activities;
        $foundActivity = null;
    
        foreach ($myActivities as $activity) {
            if ($activity->id === $id) {
                $foundActivity = $activity;
                break;
            }
        }
    
        return $foundActivity;
    }
    
}