<?php
require_once("data/ModelDataManager.php");
require_once("Page.php");

class CardPage extends Page
{
	private $boss = NULL;
	private $difficulty = NULL;
	private $role = NULL;
	
	public function __construct($bossKey, $difficultyKey, $roleKey)
	{
		$data = new ModelDataManager();
	}
	
	protected function renderBody()
	{
		?>
		<h1>temp</h1>
		<?php
	}
}
?>