<?php
require_once("data/ModelDataManager.php");
require_once("Page.php");

class IndexPage extends Page
{
	private $data = NULL;
	private $difficulties = NULL;
	private $instances = NULL;
	private $instanceTypes = NULL;
	
	public function __construct()
	{
		$this->data = new ModelDataManager();
		$this->difficulties = $this->data->getDifficulties();
		$this->instances = $this->data->getInstances();
		$this->instanceTypes = $this->data->getInstanceTypes();
	}
	
	protected function renderBody()
	{
		?>
		<div class="container">
			<h1>Fiches strat</h1>
			<?php
				foreach($this->instanceTypes as $instanceType) {
					$this->renderInstancesByType($instanceType, $this->instances);
				}
			?>
		</div>
		<?php
	}
	
	private function renderCardLinks()
	{
		?>
		<table class="table table-condensed table-responsive zone-table">
			<thead>
				<tr>
					<th></th>
					<?php
						foreach($this->difficulties as $difficulty) {
							?>
							<th><?= $difficulty->name ?></th>
							<?php
						}
					?>
				</tr>
			</thead>
		</table>
		<?php
	}
	
	private function renderInstance($instance)
	{
		?>
		<div class="list-group-item">
			<div class="list-group-item-heading" data-toggle="collapse" data-target="#<?= $instance->type->key ?>-<?= $instance->key ?>-table">
				<h4><?= $instance->name ?></h4>
			</div>
			<div id="<?= $instance->type->key ?>-<?= $instance->key ?>-table" class="collapse in">
				<?php
					$this->renderCardLinks();
				?>
			</div>
		</div>
		<?php
	}
	
	private function renderInstancesByType($instanceType, $instances)
	{
		?>
		<div class="panel panel-default">
			<div class="panel-heading" data-toggle="collapse" data-target="#<?= $instanceType->key ?>-body">
				<h4><?= $instanceType->name ?></h4>
			</div>
			<div id="<?= $instanceType->key ?>-body" class="collapse in">
				<div class="panel-body">
					<div class="list-group">
						<?php
							foreach($instances as $instance) {
								if($instance->type->key == $instanceType->key) {
									$this->renderInstance($instance);
								}
							}
						?>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
}
?>