<?php
require_once("DatabaseManager.php");

class ModelDataManager
{
	private $bosses = NULL;
	private $difficulties = NULL;
	private $instances = NULL;
	private $instanceTypes = NULL;
	private $database = NULL;
	
	public function __construct()
	{
		$this->database = new DatabaseManager();
	}
	
    public function getDifficulties()
	{
		if(is_null($this->difficulties)) {
			$this->difficulties = $this->database->getDifficulties();
		}
		
		return $this->difficulties;
	}
	
    public function getInstances()
	{
		if(is_null($this->instances)) {
			$this->instances = $this->database->getInstances();
		
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
		}
		
		return $this->instanceTypes;
	}
}
?>