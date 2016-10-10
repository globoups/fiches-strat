<?php
class Page
{
	protected $title = NULL;
	
	public function render()
	{
		?>
		<!DOCTYPE html>
		<html lang="fr" xmlns="http://www.w3.org/1999/xhtml">
		<head>
			<?php
				$this->renderHead();
			?>
		</head>
		<body>
			<div class="container">
				<?php
					$this->renderBody();
				?>
			</div>
		</body>
		</html>
		<?php
	}
	
	protected function getCssClassCollapse($isExpanded)
	{
		if ($isExpanded) {
			return "collapse in";
		}
		else {
			return "collapse out";
		}
	}
	
	protected function renderBody()
	{
	}
	
	private function renderHead()
	{
		?>
		<meta charset="utf-8" />
		<title><?= $this->title ?></title>
		<link rel="icon" type="image/png" href="img/favicon.png">
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" />
		<!-- Default theme -->
		<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" rel="stylesheet" />
		<!-- Slate theme
		<link href="https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/slate/bootstrap.min.css" rel="stylesheet" /> -->
		<link href="css/main.css" rel="stylesheet" />
		<link href="css/icon.css" rel="stylesheet" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<script src="http://wow.zamimg.com/widgets/power.js"></script>
		<script src="js/main.js"></script>
		<?php
	}
}
?>