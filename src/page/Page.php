<?php
require_once(dirname(__FILE__) . "/../session.php");
require_once(dirname(__FILE__) . "/../model/User.php");

class Page
{
    private $wowheadUrl = "http://fr.wowhead.com/";
    
    protected $cssPaths = array();
    protected $jsPaths = array();
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
        $wowheadTagPattern = '/\[wh:(.*)\|(.*)\]/';
        $wowheadLinkReplacement = '<a href="'.$this->wowheadUrl.'${1}">[${2}]</a>';
        $result = preg_replace($wowheadTagPattern, $wowheadLinkReplacement, $result);
        
        // Transform image tags
        $wowheadTagPattern = '/\[img:(.*)\|(.*)\]/';
        $wowheadLinkReplacement = '<img src="${1}">[${2}]</a>';
        $result = preg_replace($wowheadTagPattern, $wowheadLinkReplacement, $result);
        
        // Transform carriage returns
        $carriageReturnPattern = '/\n/';
        $carriageReturnReplacement = '<br />';
        $result = preg_replace($carriageReturnPattern, $carriageReturnReplacement, $result);
        
        return $result;
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
}
?>