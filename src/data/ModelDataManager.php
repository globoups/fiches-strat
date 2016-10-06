<?php
require_once(dirname(__FILE__) . "/../utils.php");
require_once("DatabaseManager.php");

class ModelDataManager
{
	private $bosses = NULL;
	private $cards = NULL;
	private $database = NULL;
	private $difficulties = NULL;
	private $instances = NULL;
	private $instanceTypes = NULL;
	private $roles = NULL;
	
	public function __construct()
	{
		$this->database = new DatabaseManager();
	}
	
    public function getBosses()
	{
		if(is_null($this->bosses)) {
			$this->bosses = $this->database->getBosses();
			usort($this->bosses, "cmp");
		
			foreach ($this->bosses as $boss) {
				$boss->instance = $this->getInstance($boss->instanceKey);
			}
		}
		
		return $this->bosses;
	}
	
    public function getBoss($key)
	{
		if(is_null($this->bosses)) {
			$this->getBosses();
		}
		
		foreach ($this->bosses as $boss) {
			if ($boss->key == $key) {
				return $boss;
			}
		}
		
		return NULL;
	}
	
    public function getCards()
	{
		if(is_null($this->cards)) {
			$this->cards = $this->database->getCards();
		
			foreach ($this->cards as $card) {
				$card->boss = $this->getBoss($card->bossKey);
				$card->difficulty = $this->getDifficulty($card->difficultyKey);
				$card->role = $this->getRole($card->roleKey);
			}
		}
		
		return $this->cards;
	}
	
	public function getCard($bossKey, $difficultyKey, $roleKey)
	{
		if(is_null($this->cards)) {
			$this->getCards();
		}
		
		foreach ($this->cards as $card) {
			if ($card->bossKey == $bossKey && $card->difficultyKey == $difficultyKey && $card->roleKey == $roleKey) {
				return $card;
			}
		}
		
		return NULL;
	}
	
    public function getDifficulties()
	{
		if(is_null($this->difficulties)) {
			$this->difficulties = $this->database->getDifficulties();
			usort($this->difficulties, "cmp");
		}
		
		return $this->difficulties;
	}
	
    public function getDifficulty($key)
	{
		if(is_null($this->difficulties)) {
			$this->getDifficulties();
		}
		
		foreach ($this->difficulties as $difficulty) {
			if ($difficulty->key == $key) {
				return $difficulty;
			}
		}
		
		return NULL;
	}
	
    public function getInstance($key)
	{
		if(is_null($this->instances)) {
			$this->getInstances();
		}
		
		foreach ($this->instances as $instance) {
			if ($instance->key == $key) {
				return $instance;
			}
		}
		
		return NULL;
	}
	
    public function getInstances()
	{
		if(is_null($this->instances)) {
			$this->instances = $this->database->getInstances();
			usort($this->instances, "cmp");
		
			foreach ($this->instances as $instance) {
				$instance->type = $this->getInstanceType($instance->typeKey);
			}
		}
		
		return $this->instances;
	}
	
    public function getInstanceType($key)
	{
		if(is_null($this->instanceTypes)) {
			$this->getInstanceTypes();
		}
		
		foreach ($this->instanceTypes as $instanceType) {
			if ($instanceType->key == $key) {
				return $instanceType;
			}
		}
		
		return NULL;
	}
	
    public function getInstanceTypes()
	{
		if(is_null($this->instanceTypes)) {
			$this->instanceTypes = $this->database->getInstanceTypes();
			usort($this->instanceTypes, "cmp");
		}
		
		return $this->instanceTypes;
	}
	
    public function getRoles()
	{
		if(is_null($this->roles)) {
			$this->roles = $this->database->getRoles();
			usort($this->roles, "cmp");
		}
		
		return $this->roles;
	}
	
    public function getRole($key)
	{
		if(is_null($this->roles)) {
			$this->getRoles();
		}
		
		foreach ($this->roles as $role) {
			if ($role->key == $key) {
				return $role;
			}
		}
		
		return NULL;
	}
}
?>