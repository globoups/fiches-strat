<?php
require_once(dirname(__FILE__) . "/../data/ModelDataManager.php");
require_once("Page.php");

class CardPage extends Page
{
    private $card = null;
    
    public function __construct($bossKey, $difficultyKey, $roleKey)
    {
		$this->key = "card";
        parent::__construct();
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
        <div class="clearfix"></div>
        <?php
            foreach ($this->card->blocs as $bloc) {
                $this->renderBloc($bloc);
            }
    }
    
    private function getRolesTooltip($roles)
    {
        $result = "";
        
        foreach ($roles as $role) {
            $result .= "<span class='icon role-".$role->key."-32'></span>";
        }
        
        return $result;
    }
    
    private function renderBloc($bloc)
    {
        switch($bloc->type)
        {
            // Main bloc
            case 1:
                $this->renderWrapperBloc($bloc);
                break;
            // Sub bloc
            case 2:
                $this->renderInfoBloc($bloc);
                break;
            // Sub bloc line
            case 3:
                $this->renderInfoLine($bloc);
                break;
            // Modal bloc
            case 4:
                $this->renderModalBloc($bloc);
                break;
            default:
                ?>
                    Unknown bloc type: <?= $bloc->type ?>
                <?php
                break;
        }
    }
    
    private function renderWrapperBloc($bloc)
    {
        ?>
        <div class="panel panel-default">
            <div class="panel-heading" data-toggle="collapse" data-target="#<?= $bloc->key ?>-body">
                <h4><?= $bloc->content ?></h4>
            </div>
            <div id="<?= $bloc->key ?>-body" class="collapse in">
                <div class="panel-body">
                    <?php
                        if (!is_null($bloc->children)) {
                            foreach ($bloc->children as $bloc) {
                                $this->renderBloc($bloc);
                            }
                        }
                    ?>
                </div>
            </div>
        </div>
        <?php
    }
    
    private function renderModalBloc($bloc)
    {
        ?>
            
        <?php
    }
    
    private function renderInfoBloc($bloc)
    {
        ?>
        <h4><?= $bloc->content ?></h4>
        <ul class="list-group">
            <?php
                if (!is_null($bloc->children)) {
                    foreach ($bloc->children as $bloc) {
                        $this->renderBloc($bloc);
                    }
                }
            ?>
        </ul>
        <?php
    }
    
    private function renderInfoLine($bloc)
    {
        if (!is_null($bloc->roles) && !empty($bloc->roles)) {
            ?>
        <li class="list-group-item role-item" data-toggle="tooltip" title="<?= $this->getRolesTooltip($bloc->roles) ?>">
            <?php
        }
        else {
            ?>
        <li class="list-group-item">
            <?php
        }
        
        ?>
            <?= $this->buildContent($bloc->content) ?>
        </li>
        <?php
    }
}
?>