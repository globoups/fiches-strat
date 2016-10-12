<?php
require_once("data/ModelDataManager.php");
require_once("Page.php");

class EditionPage extends Page
{
    private $card = null;
    private $roles = null;
    
    public function __construct($bossKey, $difficultyKey, $roleKey)
    {
        parent::__construct();
        $this->cssPaths[] = "css/edit.css";
        $this->jsPaths[] = "js/edit.js";

        $data = new ModelDataManager();
        $this->card = $data->getCard($bossKey, $difficultyKey, $roleKey);
        $this->roles = $data->getRoles();
        
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
            <?php
                foreach ($this->card->blocs as $bloc) {
                    $this->renderBloc($bloc);
                }
            ?>
            <a class="btn btn-info">Add wrapper bloc</a>
            <a class="btn btn-info">Add info bloc</a>
            <div class="clearfix">
                <a class="btn btn-success pull-right">Save</a>
            </div>
        </form>
        <?php
    }
    
    private function getRoleButtons($blocRoles)
    {
        $result = "";

        foreach ($this->roles as $role) {
            $isRoleActive = false;

            foreach ($blocRoles as $blocRole) {
                if ($role->key == $blocRole->key) {
                    $isRoleActive = true;
                }
            }

            if ($isRoleActive) {
                $result .= '<span class="bloc-btn icon role-'.$role->key.'-32"></span>';
            }
            else {
                $result .= '<span class="bloc-btn icon role-'.$role->key.'-disabled-32"></span>';
            }
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

    private function renderBlocButtonsGroup()
    {
        ?>
            <div class="bloc-btn-grp pull-right">
                <span class="bloc-btn move-up glyphicon glyphicon-arrow-up"></span>
                <span class="bloc-btn move-down glyphicon glyphicon-arrow-down"></span>
                <span class="bloc-btn delete glyphicon glyphicon-trash"></span>
            </div>
        <?php
    }
    
    private function renderWrapperBloc($bloc)
    {
        ?>
        <div class="panel panel-default">
            <div class="panel-heading clearfix">
                <div class="pull-left">
                    <h4>
                        <input type="text" value="<?= $bloc->content ?>" />
                    </h4>
                </div>
                <?php
                    $this->renderBlocButtonsGroup();
                ?>
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
                    <ul class="list-group"></ul>
                    <a class="btn btn-info">Add info bloc</a>
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
        <div class="info-bloc">
            <div class="clearfix">
                <div class="pull-left">
                    <h4>
                        <input type="text" value="<?= $bloc->content ?>" />
                    </h4>
                </div>
                <?php
                    $this->renderBlocButtonsGroup();
                ?>
            </div>
            <ul class="list-group">
                <?php
                    if (!is_null($bloc->children)) {
                        foreach ($bloc->children as $bloc) {
                            $this->renderBloc($bloc);
                        }
                    }
                ?>
                <li class="list-group-item">
                    <a class="btn btn-info">Add info line</a>
                </li>
            </ul>
        </div>
        <?php
    }
    
    private function renderInfoLine($bloc)
    {
        ?>
        <li class="list-group-item">
            <div class="pull-left">
                <?php
                    if (!is_null($this->roles)) {
                        echo $this->getRoleButtons($bloc->roles);
                    }
                ?>
            </div>
            <?php
                $this->renderBlocButtonsGroup();
            ?>
            <textarea rows="1"><?= $bloc->content ?></textarea>
        </li>
        <?php
    }
}
?>