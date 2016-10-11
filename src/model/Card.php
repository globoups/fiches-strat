<?php
class Card
{
    public $blocs = null;
    public $boss = null;
    public $bossKey = null;
    public $difficulty = null;
    public $difficultyKey = null;
    public $id = null;
    public $role = null;
    public $roleKey = null;
	
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