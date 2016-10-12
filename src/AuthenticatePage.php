<?php
require_once("data/ModelDataManager.php");
require_once("Page.php");

class AuthenticatePage extends Page
{
    private $authenticationSuccess = null;
    private $username = "";

	public function __construct()
	{
        parent::__construct();
		$this->title = "Login - Fiches strat";
	}

    public function authenticate($username, $password)
    {
        $data = new ModelDataManager();
        $this->username = $username;
        $this->authenticationSuccess = $data->validateCredentials($username, $password);

        if ($this->authenticationSuccess) {
            $_SESSION["isUserAuthenticated"] = true;
            $_SESSION["username"] = $username;
        }
    }
	
	protected function renderBody()
	{
		?>
        <div class="row">
            <div class="col-xs-1 col-sm-3 col-md-4"></div>
            <div class="col-xs-10 col-sm-6 col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4>Authentification</h4>
                    </div>
                    <div class="panel-body">
                        <?php
                            if (is_null($this->authenticationSuccess)) {
                                $this->renderLoginForm(false);
                            }
                            else if ($this->authenticationSuccess) {
                                $this->renderLoginSuccess();
                            }
                            else {
                                $this->renderLoginForm(true);
                            }
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-xs-1 col-sm-3 col-md-4"></div>
        </div>
        <?php
	}

    private function renderLoginForm($hasError) {
		?>
        <form action="" method="post">
            <?php
                if (!$hasError && $this->user->isAuthenticated) {
                    ?>
                    <div class="alert alert-warning">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        D&eacute;j&agrave; connect&eacute; en tant que <strong><?= $this->user->name ?></strong>.
                    </div>
                    <?php
                }
            ?>
            <div class="form-group">
                <label for="auth-username">Nom d'utilisateur</label>
                <input id="auth-username" name="auth-username" type="text" class="form-control" placeholder="Nom d'utilisateur" value="<?= $this->username ?>">
            </div>
            <div class="form-group">
                <label for="auth-password">Mot de passe</label>
                <input id="auth-password" name="auth-password" type="password" class="form-control" placeholder="Mot de passe">
            </div>
            <?php
                if ($hasError) {
                    ?>
                    <div class="alert alert-danger">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        Nom d'utilisateur ou mot de passe incorrect.
                    </div>
                    <?php
                }
            ?>
            <button type="submit" class="btn btn-default pull-right">Envoyer</button>
        </form>
        <?php
    }

    private function renderLoginSuccess() {
		?>
        <form action="." method="post">
            <div class="alert alert-success">
                Bienvenue <strong><?= $this->user->name ?></strong>.
            </div>
            <button type="submit" class="btn btn-default pull-right">Retour</button>
        </form>
        <?php
    }
}
?>