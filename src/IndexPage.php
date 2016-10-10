<?php
require_once("data/ModelDataManager.php");
require_once("Page.php");

class IndexPage extends Page
{
	private $bosses = NULL;
	private $data = NULL;
	private $difficulties = NULL;
	private $instances = NULL;
	private $instanceTypes = NULL;
	private $roles = NULL;
	
	public function __construct()
	{
		$this->data = new ModelDataManager();
		$this->bosses = $this->data->getBosses();
		$this->difficulties = $this->data->getDifficulties();
		$this->instances = $this->data->getInstances();
		$this->instanceTypes = $this->data->getInstanceTypes();
		$this->roles = $this->data->getRoles();
		$this->title = "Fiches strat";
	}
	
	protected function renderBody()
	{
		?>
		<h1>Fiches strat</h1>
		<?php
			foreach($this->instanceTypes as $instanceType) {
				$this->renderInstancesByType($instanceType, $this->instances);
			}
	}
	
	private function renderCardLink($boss, $difficulty, $role)
	{
		$card = $this->data->getCard($boss->key, $difficulty->key, $role->key);
		
		if(is_null($card)) {
			?>
				<span class="icon role-<?= $role->key ?>-disabled-32"></span>
			<?php
		}
		else {
			?>
				<a class="icon role-<?= $role->key ?>-32" href="<?= $card->getUrl() ?>" data-toggle="tooltip" title="<?= $card->getTitle() ?>"></a>
			<?php
		}
	}
	
	private function renderInstance($instance)
	{
		?>
		<div class="list-group-item">
			<div class="list-group-item-heading" data-toggle="collapse" data-target="#<?= $instance->type->key ?>-<?= $instance->key ?>-table">
				<h4><?= $instance->name ?></h4>
			</div>
			<div id="<?= $instance->type->key ?>-<?= $instance->key ?>-table" class="<?= $this->getCssClassCollapse($instance->isExpanded) ?>">
				<?php
					$this->renderInstanceLinks($instance);
				?>
			</div>
		</div>
		<?php
	}
	
	private function renderInstanceLinks($instance)
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
				<?php
					foreach($this->bosses as $boss) {
						if($boss->instance->key == $instance->key) {
							?>
							<tr>
								<td><?= $boss->name ?></td>
								<?php
									foreach($this->difficulties as $difficulty) {
										?>
										<td>
											<?php
												foreach($this->roles as $role) {
													$this->renderCardLink($boss, $difficulty, $role);
												}
											?>
										</td>
										<?php
									}
								?>
							</tr>
							<?php
						}
					}
				?>
			</thead>
		</table>
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