<?php
require_once(dirname(__FILE__) . "/../session.php");
require_once(dirname(__FILE__) . "/../model/User.php");

class Page
{
	private $navLinks = array();
	private $navOptions = array();
    private $wowheadUrl = "http://fr.wowhead.com/";
    
    protected $cssPaths = array();
    protected $jsPaths = array();
    protected $key = null;
    protected $title = null;
    protected $user = null;
    
    public function __construct()
    {
        $this->cssPaths[] = "https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css";
        // Default theme
        $this->cssPaths[] = "https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css";
        // Slate theme
        //$this->cssPaths[] = "https://maxcdn.bootstrapcdn.com/bootswatch/3.3.7/slate/bootstrap.min.css";
        $this->cssPaths[] = "css/main.css";
        $this->cssPaths[] = "css/icon.css";
        $this->jsPaths[] = "https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js";
        $this->jsPaths[] = "https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js";
        $this->jsPaths[] = "http://wow.zamimg.com/widgets/power.js";
        $this->jsPaths[] = "js/main.js";

        $this->initializeUser();
        $this->initializeNavigation();
    }
    
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
            <?php
                $this->renderNav();
            ?>
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
    
    protected function buildContent($text)
    {
        $result = $text;
        
        // Transform wowhead tags
        $wowheadTagPattern = '/\[wh:([^\|]*)\|([^\]]*)\]/';
        $wowheadLinkReplacement = '<a href="'.$this->wowheadUrl.'${1}">[${2}]</a>';
        $result = preg_replace($wowheadTagPattern, $wowheadLinkReplacement, $result);
        
        // Transform image tags
        $wowheadTagPattern = '/\[img:([^\|]*)\|([^\]]*)\]/';
        $wowheadLinkReplacement = '<img src="${1}">[${2}]</a>';
        $result = preg_replace($wowheadTagPattern, $wowheadLinkReplacement, $result);
        
        // Transform carriage returns
        $carriageReturnPattern = '/\n/';
        $carriageReturnReplacement = '<br />';
        $result = preg_replace($carriageReturnPattern, $carriageReturnReplacement, $result);
        
        return $result;
    }

    private function initializeNavigation()
    {
        $navFileContent = file_get_contents(dirname(__FILE__) . "/navigation.json");
        $navItems = json_decode($navFileContent);

        foreach ($navItems as $navItem) {
            if ((!$navItem->isAuthRequired || $this->user->isAuthenticated) && (is_null($navItem->visibleOn) || in_array($this->key, $navItem->visibleOn))) {
                if ($navItem->position == "left") {
                    $this->navLinks[] = $navItem;
                }
                else if ($navItem->position == "right") {
                    $this->navOptions[] = $navItem;
                }
            }
        }
    }

    private function initializeUser()
    {
        $this->user = new User();

        if (isset($_SESSION["isUserAuthenticated"])) {
            $this->user->isAuthenticated = $_SESSION["isUserAuthenticated"];
        }

        if (isset($_SESSION["username"])) {
            $this->user->name = $_SESSION["username"];
        }
    }
    
    private function renderHead()
    {
        ?>
        <meta charset="utf-8" />
        <title><?= $this->title ?></title>
        <link rel="icon" type="image/png" href="img/favicon.png">
        <?php
            foreach ($this->cssPaths as $cssPath) {
                ?>
                    <link href="<?= $cssPath ?>" rel="stylesheet" />
                <?php
            }
        ?>
        <?php
            foreach ($this->jsPaths as $jsPath) {
                ?>
                    <script src="<?= $jsPath ?>"></script>
                <?php
            }
    }

    private function renderNav()
    {
        ?>
		<nav class="navbar navbar-inverse">
			<div class="container-fluid">
				<div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navContent">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>                        
                    </button>
					<span class="navbar-brand">Fiches strat</span>
				</div>
                <div id="navContent" class="collapse navbar-collapse">
				    <ul class="nav navbar-nav">
					    <?php
		                    foreach ($this->navLinks as $navLink) {
						        $this->renderNavItem($navLink);
		                    }
					    ?>
				    </ul>
				    <ul class="nav navbar-nav navbar-right">
					    <?php
		                    foreach ($this->navOptions as $navOption) {
						        $this->renderNavItem($navOption);
		                    }
                        
                            if ($this->user->isAuthenticated) {
					            ?>
					            <li>
						            <a class="pull-right auth-light-on" href="./deauthenticate.php"><span class="glyphicon glyphicon-off"></span></a>
					            </li>
                                <?php
                            }
                            else {
					            ?>
					            <li>
						            <a class="pull-right" href="./authenticate.php"><span class="glyphicon glyphicon-off"></span></a>
					            </li>
                                <?php
                            }
					    ?>
				    </ul>
                </div>
			</div>
		</nav>
        <?php
    }
	

    private function renderNavItem($item)
    {
        $icon = "";
        $url = $item->url;
        $wrapperCssClass = "";

        if (!is_null($item->icon)) {
            $icon = '<span class="glyphicon glyphicon-'.$item->icon.'"></span> ';
        }

        if (substr($item->url, -1) == "?") {
            $url .= $_SERVER['QUERY_STRING'];
        }

        if ($item->key == $this->key) {
            $wrapperCssClass = "active";
        }

		?>
			<li class="<?= $wrapperCssClass ?>">
				<a href="<?= $url ?>"><?= $icon ?><?= $item->text ?></a>
			</li>
		<?php
    }
}
?>