<?php 
class StudentAccount{
    protected $first = "";
    protected $last;
    protected $pref;
    protected $skills;
    protected $gradMonth;
    protected $gradYear;
    protected $major;
    protected $minor;
    protected $university;
    private $filepath;
    private $username;
    private $password;

    public function setFirst($entry){
        $first = $entry;
    }
    public function setLast($entry){
        $last = $entry;
    }
     public function setPref($entry){
        $pref = $entry;
    }
    public function setSkills($entry){
        $skills = $entry;
    }
    public function setGradMonth($entry){
        $gradMonth = $entry;
    }
    public function setGradYear($entry){
        $gradYear = $entry;
    }
    public function setMajor($entry){
        $major = $entry;
    }
    public function setMinor($entry){
        $minor = $entry;
    }
    public function setUni($entry){
        $university = $entry;
    } 
    private function setFilePath($entry){
        $filepath = $entry;
    } 
    private function setUsername($entry){
        $username = $entry;
    }
    private function setPassword($entry){
        $password = $entry;
    }
    public function getFirst(){
        return $this->first; 
    }
    public function getLast(){
        return $this->last; 
    }
    public function getPref(){
        return $this->pref; 
    }
    public function getSkills(){
        return $this->skills; 
    }
    public function getGradMonth(){
        return $this->gradMonth; 
    }
    public function getGradYear(){
        return $this->gradYear; 
    }
    public function getMajor(){
        return $this->major; 
    }
    public function getMinor(){
        return $this->minor; 
    }
    public function getUni(){
        return $this->university; 
    }
    public function getFilePath(){
        return $this->filepath;
    }
    private function getUsername(){
        return $this->username;
    }
    private function getPassword(){
        return $this->username;
    }
    


}