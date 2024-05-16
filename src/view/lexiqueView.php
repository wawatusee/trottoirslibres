<?php Class LexiqueView{
    private $lang;
    private $lexique_array;
    public function __construct($lexique_datas, $lang)
    {
        $this->lexique_array=$lexique_datas;
        $this->lang=$lang;
    }
    public function getSectionLexique($sectionName){
        $lang=$this->lang;
        $mySectionLexique=$this->lexique_array->$sectionName;
        return $mySectionLexique;
    }
}
