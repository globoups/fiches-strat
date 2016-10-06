<?php
require_once(dirname(__FILE__) . "/../model/models.php");

class DatabaseManager
{
	private $mysqli = NULL;
	
	public function __construct()
	{
		$this->mysqli = new mysqli("localhost:3306", "root", "", "fiches");
		$this->mysqli->set_charset("utf8");
	}
	
    public function getBosses()
	{
		$query = "SELECT b.*, i.key AS instance_key FROM fs_boss b INNER JOIN fs_instance i ON i.id = b.instance_id";
		$res = $this->mysqli->query($query);
		$bosses = array();
		
		while ($row = $res->fetch_assoc()) {
			$boss = new Boss();
			$boss->key = $row["key"];
			$boss->name = $row["name"];
			$boss->order = $row["order"];
			$boss->instanceKey = $row["instance_key"];
			$bosses[] = $boss;
		}
		
		return $bosses;
	}
	
    public function getDifficulties()
	{
		$query = "SELECT * FROM fs_difficulty";
		$res = $this->mysqli->query($query);
		$difficulties = array();
		
		while ($row = $res->fetch_assoc()) {
			$difficulty = new Difficulty();
			$difficulty->key = $row["key"];
			$difficulty->name = $row["name"];
			$difficulty->order = $row["order"];
			$difficulties[] = $difficulty;
		}
		
		return $difficulties;
	}
	
    public function getInstances()
	{
		$query = "SELECT i.*, it.key AS instance_type_key FROM fs_instance i INNER JOIN fs_instance_type it ON it.id = i.instance_type_id";
		$res = $this->mysqli->query($query);
		$instances = array();
		
		while ($row = $res->fetch_assoc()) {
			$instance = new Instance();
			$instance->key = $row["key"];
			$instance->name = $row["name"];
			$instance->order = $row["order"];
			$instance->typeKey = $row["instance_type_key"];
			$instances[] = $instance;
		}
		
		return $instances;
	}
	
    public function getInstanceTypes()
	{
		$query = "SELECT * FROM fs_instance_type";
		$res = $this->mysqli->query($query);
		$instanceTypes = array();
		
		while ($row = $res->fetch_assoc()) {
			$instanceType = new InstanceType();
			$instanceType->key = $row["key"];
			$instanceType->name = $row["name"];
			$instanceType->order = $row["order"];
			$instanceTypes[] = $instanceType;
		}
		
		return $instanceTypes;
	}
}
?>