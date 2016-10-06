<?php
class HtmlRenderer
{
	public function renderInstance($instance)
	{
		?>
		<div class="list-group-item">
			<div class="list-group-item-heading" data-toggle="collapse" data-target="#<?= $instance->type->key ?>-<?= $instance->key ?>-table">
				<h4><?= $instance->name ?></h4>
			</div>
			<div id="<?= $instance->type->key ?>-<?= $instance->key ?>-table" class="collapse in">
				<table class="table table-condensed table-responsive zone-table">
				</table>
			</div>
		</div>
		<?php
	}
	
	public function renderInstancesByType($instanceType, $instances)
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