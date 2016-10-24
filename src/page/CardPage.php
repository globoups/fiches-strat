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
            // Wrapper bloc
            case 1:
                $this->renderWrapperBloc($bloc);
                break;
            // Info bloc
            case 2:
                $this->renderInfoBloc($bloc);
                break;
            // Info item
            case 3:
                $this->renderInfoItem($bloc);
                break;
            // Schema bloc
            case 4:
                $this->renderSchemaBloc($bloc);
                break;
            // Schema item
            case 5:
                $this->renderSchemaItem($bloc);
                break;
            default:
                ?>
                    Unknown bloc type: <?= $bloc->type ?>
                <?php
                break;
        }
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
    
    private function renderInfoItem($bloc)
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
    
    private function renderSchemaBloc($bloc)
    {
        ?>
        <h4><?= $bloc->content ?></h4>
        <?php
            if (!is_null($bloc->children)) {
                foreach ($bloc->children as $bloc) {
                    $this->renderBloc($bloc);
                }
            }
    }
    
    private function renderSchemaItem($bloc)
    {
        $schemaTagPattern = '/\[schema:([^\|]*)\|([^\]]*)\]/';
        preg_match($schemaTagPattern, $bloc->content, $matches);
        $url = $matches[1];
        $title = $matches[2];

        ?>
        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-<?= $bloc->id ?>"><?= $title ?></button>
        <div class="modal" id="modal-<?= $bloc->id ?>" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"><?= $title ?></h4>
                    </div>
                    <div class="modal-body">
                        <img src="<?= $url ?>" />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    
    private function renderWrapperBloc($bloc)
    {
        ?>
        <div class="panel panel-default">
            <div class="panel-heading" data-toggle="collapse" data-target="#body-<?= $bloc->id ?>">
                <h4><?= $bloc->content ?></h4>
            </div>
            <div id="body-<?= $bloc->id ?>" class="collapse in">
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
}
?>