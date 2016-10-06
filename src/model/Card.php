<?php
class Card
{
    public $boss = NULL;
    public $bossKey = NULL;
    public $difficulty = NULL;
    public $difficultyKey = NULL;
    public $role = NULL;
    public $roleKey = NULL;
	
	public function getTitle()
	{
		return $this->boss->name." ".strtoupper($this->difficulty->key)." - ".$this->role->name;
	}
	
	public function getUrl()
	{
		return "fiche.php?boss=".$this->boss->key."&difficulty=".$this->difficulty->key."&role=".$this->role->key;
	}
}
?>