<?php
require_once("data/ModelDataManager.php");
require_once("Page.php");

class CardPage extends Page
{
	private $card = NULL;
	
	public function __construct($bossKey, $difficultyKey, $roleKey)
	{
		$data = new ModelDataManager();
		$this->card = $data->getCard($bossKey, $difficultyKey, $roleKey);
		
		if(is_null($this->card)) {
			header("Location: .");
			die();
		}
		
		$this->title = $this->card->getTitle();
	}
	
	protected function renderBody()
	{
		?>
		<h1><?= $this->card->boss->instance->name ?> (<?= $this->card->difficulty->name ?>)</h1>
		<h2><?= $this->card->boss->name ?> - Fiche <?= $this->card->role->name ?> <span class="icon role-<?= $this->card->role->key ?>-32"></span></h2>
		<?php
	}
	
	public function renderBloc($bloc)
	{
		switch($bloc->type)
		{
			case "main":
				break;
			case "sub":
				break;
			case "line":
				break;
			case "modal":
				break;
			default:
				?>
					Unknown bloc type: <?= $bloc->type ?>
				<?php
				break;
		}
	}
}
?>