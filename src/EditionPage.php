<?php
require_once("data/ModelDataManager.php");
require_once("Page.php");

class EditionPage extends Page
{
    private $card = null;
    
    public function __construct($bossKey, $difficultyKey, $roleKey)
    {
        $data = new ModelDataManager();
        $this->card = $data->getCard($bossKey, $difficultyKey, $roleKey);
        
        if (is_null($this->card)) {
            $boss = $data->getBoss($bossKey);
            $difficulty = $data->getDifficulty($difficultyKey);
            $role = $data->getRole($roleKey);

            if (is_null($boss) || is_null($difficulty) || is_null($role)) {
                header("Location: .");
                die();
            }

            $this->card = new Card();
            $this->card->blocs = array();
            $this->card->boss = $boss;
            $this->card->difficulty = $difficulty;
            $this->card->role = $role;
        }
        
        $this->title = "Edition - ".$this->card->getTitle();
    }
    
    protected function renderBody()
    {
        ?>
        <h1><?= $this->card->boss->instance->name ?> (<?= $this->card->difficulty->name ?>)</h1>
        <h2><?= $this->card->boss->name ?> - Fiche <?= $this->card->role->name ?> <span class="icon role-<?= $this->card->role->key ?>-32"></span> - Mode &eacute;dition</h2>
        <div class="clearfix"></div>
        <form id="edit-card-form">
            <button class="btn btn-success">Save</button><br />
            <br />
            <a class="btn btn-success">Add wrapper bloc</a>
            <a class="btn btn-success">Add info bloc</a>
            <?php
                foreach ($this->card->blocs as $bloc) {
                    $this->renderBloc($bloc);
                }
            ?>
            <button class="btn btn-success">Save</button>
        </form>
        <?php
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
            <div class="panel-heading">
                <h4>
                    <input type="text" value="<?= $bloc->content ?>" />
                </h4>
            </div>
            <div>
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
        <a class="btn btn-success">Add wrapper bloc</a>
        <a class="btn btn-success">Add info bloc</a>
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
        <h4>
            <input type="text" value="<?= $bloc->content ?>" />
        </h4>
        <ul class="list-group">
            <?php
                if (!is_null($bloc->children)) {
                    foreach ($bloc->children as $bloc) {
                        $this->renderBloc($bloc);
                    }
                }
            ?>
        </ul>
        <a class="btn btn-success">Add wrapper bloc</a>
        <a class="btn btn-success">Add info bloc</a>
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
            <textarea rows="1"><?= $bloc->content ?></textarea>
        </li>
        <li class="list-group-item">
            <a class="btn btn-success">Add info line</a>
        </li>
        <?php
    }
}
?>