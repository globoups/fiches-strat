<?php
require_once(dirname(__FILE__) . "/../data/ModelDataManager.php");
require_once("Page.php");

class EditionPage extends Page
{
    private $card = null;
    private $roles = null;
    
    public function __construct($bossKey, $difficultyKey, $roleKey)
    {
        $this->key = "edit";
        parent::__construct();

        if (!$this->user->isAuthenticated) {
	        header("Location: ./authenticate.php");
	        die();
        }

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
        <input name="boss" type="hidden" value="<?= $this->card->boss->key ?>" />
        <input name="difficulty" type="hidden" value="<?= $this->card->difficulty->key ?>" />
        <input name="role" type="hidden" value="<?= $this->card->role->key ?>" />
        <div id="card-content">
            <?php
                foreach ($this->card->blocs as $bloc) {
                    $this->renderBloc($bloc);
                }
            ?>
            <div class="btn-group">
                <?php
                    $this->renderButtonAddWrapperBloc();
                    $this->renderButtonAddInfoBloc();
                    $this->renderButtonAddSchemaBloc();
                ?>
            </div>
        </div>
        <div class="clearfix">
            <?php
                $this->renderButtonSave();
            ?>
        </div>
        <div class="empty-blocs" style="display:none">
            <?php
                $this->renderEmptyBlocs($bloc);
            ?>
        </div>
        <?php
            $this->renderModalSaveFail();
            $this->renderModalSaveFailNotAuthenticated();
            $this->renderModalSaveSuccess();
            $this->renderModalSaving();
    }

    private function renderButtonAddInfoBloc()
    {
        ?>
            <a class="btn btn-info add-info-bloc"><span class="glyphicon glyphicon-plus"></span> Infos</a>
        <?php
    }

    private function renderButtonAddInfoItem()
    {
        ?>
            <a class="btn btn-info add-info-item"><span class="glyphicon glyphicon-plus"></span> Info</a>
        <?php
    }

    private function renderButtonAddSchemaBloc()
    {
        ?>
            <a class="btn btn-info add-schema-bloc"><span class="glyphicon glyphicon-plus"></span> Sch&eacute;mas</a>
        <?php
    }

    private function renderButtonAddSchemaItem()
    {
        ?>
            <a class="btn btn-info add-schema-item"><span class="glyphicon glyphicon-plus"></span> Sch&eacute;ma</a>
        <?php
    }

    private function renderButtonAddWrapperBloc()
    {
        ?>
            <a class="btn btn-info add-wrapper-bloc"><span class="glyphicon glyphicon-plus"></span> Conteneur</a>
        <?php
    }

    private function renderButtonSave()
    {
        ?>
            <a class="btn btn-success pull-right save"><span class="glyphicon glyphicon-save"></span> Enregistrer</a>
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
                $result .= '<span class="toggle-role '.$role->key.' enabled icon role-'.$role->key.'-32"></span> ';
            }
            else {
                $result .= '<span class="toggle-role '.$role->key.' disabled icon role-'.$role->key.'-disabled-32"></span> ';
            }
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

    private function renderEmptyBlocs()
    {
        ?>
        <!-- Wrapper bloc -->
        <div class="panel panel-default wrapper-bloc">
            <div class="panel-heading clearfix">
                <div class="pull-left">
                    <h4>
                        <input type="text" placeholder="Titre" value="">
                    </h4>
                </div>
                <?php
                    $this->renderBlocButtonsGroup();
                ?>
            </div>
            <div>
                <div class="panel-body">
                    <div class="btn-group btn-grp">
                        <?php
                            $this->renderButtonAddInfoBloc();
                            $this->renderButtonAddSchemaBloc();
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <!-- Info bloc -->
        <div class="info-bloc">
            <div class="clearfix">
                <div class="pull-left">
                    <h4>
                        <input type="text" placeholder="Titre" value="">
                    </h4>
                </div>
                <?php
                    $this->renderBlocButtonsGroup();
                ?>
            </div>
            <ul class="list-group">
                <li class="list-group-item">
                    <?php
                        $this->renderButtonAddInfoItem();
                    ?>
                </li>
            </ul>
        </div>
        <!-- Info item -->
        <li class="list-group-item info-item">
            <div class="pull-left">
                <?php
                    foreach ($this->roles as $role) {
                        ?>
                        <span class="toggle-role <?= $role->key ?> disabled icon role-<?= $role->key ?>-disabled-32"></span>
                        <?php
                    }
                ?>
            </div>
            <?php
                $this->renderBlocButtonsGroup();
            ?>
            <textarea rows="1" placeholder="Contenu"></textarea>
        </li>
        <!-- Schema bloc -->
        <div class="schema-bloc">
            <div class="clearfix">
                <div class="pull-left">
                    <h4>
                        <input type="text" placeholder="Titre" value="">
                    </h4>
                </div>
                <?php
                    $this->renderBlocButtonsGroup();
                ?>
            </div>
            <ul class="list-group">
                <li class="list-group-item">
                    <?php
                        $this->renderButtonAddSchemaItem();
                    ?>
                </li>
            </ul>
        </div>
        <!-- Schema item -->
        <li class="list-group-item schema-item">
            <?php
                $this->renderBlocButtonsGroup();
            ?>
            <input type="text" placeholder="Titre" value="" />
            <input type="text" placeholder="Url" value="" />
        </li>
        <?php
    }
    
    private function renderInfoBloc($bloc)
    {
        ?>
        <div class="info-bloc">
            <div class="clearfix">
                <div class="pull-left">
                    <h4>
                        <input type="text" placeholder="Titre" value="<?= $bloc->content ?>" />
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
                    <?php
                        $this->renderButtonAddInfoItem();
                    ?>
                </li>
            </ul>
        </div>
        <?php
    }
    
    private function renderInfoItem($bloc)
    {
        ?>
        <li class="list-group-item info-item">
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
            <textarea rows="1" placeholder="Contenu"><?= $bloc->content ?></textarea>
        </li>
        <?php
    }
    
    private function renderSchemaBloc($bloc)
    {
        ?>
        <div class="schema-bloc">
            <div class="clearfix">
                <div class="pull-left">
                    <h4>
                        <input type="text" placeholder="Titre" value="<?= $bloc->content ?>" />
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
                    <?php
                        $this->renderButtonAddSchemaItem();
                    ?>
                </li>
            </ul>
        </div>
        <?php
    }
    
    private function renderSchemaItem($bloc)
    {
        $schemaTagPattern = '/\[schema:([^\|]*)\|([^\]]*)\]/';
        preg_match($schemaTagPattern, $bloc->content, $matches);
        $title = $matches[1];
        $url = $matches[2];

        ?>
        <li class="list-group-item schema-item">
            <?php
                $this->renderBlocButtonsGroup();
            ?>
            <input type="text" placeholder="Titre" value="<?= $title ?>" />
            <input type="text" placeholder="Url" value="<?= $url ?>" />
        </li>
        <?php
    }
    
    private function renderWrapperBloc($bloc)
    {
        ?>
        <div class="panel panel-default wrapper-bloc">
            <div class="panel-heading clearfix">
                <div class="pull-left">
                    <h4>
                        <input type="text" placeholder="Titre" value="<?= $bloc->content ?>" />
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
                    <div class="btn-group btn-grp">
                        <?php
                            $this->renderButtonAddInfoBloc();
                            $this->renderButtonAddSchemaBloc();
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

    private function renderModalSaveFail()
    {
        ?>
        <div id="modalSaveFail" class="modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Sauvegarde</h4>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger">Erreur pendant la sauvegarde.</div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

    private function renderModalSaveFailNotAuthenticated()
    {
        ?>
        <div id="modalSaveFailNotAuthenticated" class="modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Sauvegarde</h4>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-danger">La session a expir&eacute;.</div>
                    </div>
                    <div class="modal-footer">
                        <a target="_blank" href="./authenticate.php" class="btn btn-default">Authentification</a>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

    private function renderModalSaveSuccess()
    {
        ?>
        <div id="modalSaveSuccess" class="modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Sauvegarde</h4>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-success">Fiche sauvegard&eacute;e.</div>
                    </div>
                    <div class="modal-footer">
                        <a href="./" class="btn btn-default">Index</a>
                        <a href="<?= $this->card->getUrl() ?>" class="btn btn-default">Voir fiche</a>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Fermer</button>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

    private function renderModalSaving()
    {
        ?>
        <div id="modalSaving" class="modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Sauvegarde</h4>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-info">Sauvegarde en cours...</div>
                    </div>
                    <div class="modal-footer">
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
}
?>