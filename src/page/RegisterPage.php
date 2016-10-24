<?php
require_once(dirname(__FILE__) . "/../data/ModelDataManager.php");
require_once("Page.php");

class RegisterPage extends Page
{
    private $errorMessages = array(
        "username_length" => "Le nom d'utilisateur doit faire plus de 3 caractères.",
        "username_invalid_character" => "Le nom d'utilisateur ne peut pas contenir de caractères spéciaux.",
        "password_length" => "Le mot de passe doit faire plus de 6 caractères." );
    private $errors = array();
    private $signupSuccess = null;
    private $username = "";
    
    public function __construct()
    {
        parent::__construct();
        $this->title = "Register - Fiches strat";
    }

    public function register($username, $password)
    {
        $data = new ModelDataManager();
        $this->username = $username;
        $this->checkData($username, $password);
        
        if (count($this->errors) == 0) {
            // Create user
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
                        <h4>Cr&eacute;ation de compte</h4>
                    </div>
                    <div class="panel-body">
                        <?php
                            if (is_null($this->signupSuccess)) {
                                $this->renderSignupForm(false);
                            }
                            else if ($this->signupSuccess) {
                                $this->renderSignupSuccess();
                            }
                            else {
                                $this->renderSignupForm(true);
                            }
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-xs-1 col-sm-3 col-md-4"></div>
        </div>
        <?php
    }
    
    private function checkData($username, $password)
    {
        if (strlen($username) < 4) {
            $this->errors[] = "username_length";
        }
        
        if (preg_match('/[^a-z_\-0-9]/i', $username)) {
            $this->errors[] = "username_invalid_character";
        }
        
        if (strlen($password) < 7) {
            $this->errors[] = "password_length";
        }
    }

    private function renderSignupForm($hasError) {
        ?>
        <form action="" method="post">
            <div class="form-group">
                <label for="reg-username">Nom d'utilisateur</label>
                <input id="reg-username" name="reg-username" type="text" class="form-control" placeholder="Nom d'utilisateur" value="<?= $this->username ?>">
            </div>
            <div class="form-group">
                <label for="reg-password">Mot de passe</label>
                <input id="reg-password" name="reg-password" type="password" class="form-control" placeholder="Mot de passe">
            </div>
            <?php
                if (count($this->errors) > 0) {
                    ?>
                    <div class="alert alert-danger">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <?php
                            foreach ($this->errors as $error) {
                                ?>
                                <?= $this->errorMessages[$error] ?><br />
                                <?php
                            }
                        ?>
                    </div>
                    <?php
                }
            ?>
            <button type="submit" class="btn btn-default pull-right">Envoyer</button>
        </form>
        <?php
    }

    private function renderSignupSuccess() {
        ?>
        <div class="alert alert-success">
            Le compte <strong><?= $this->username ?></strong> a été créé.<br />
            Il sera utilisable après activation par un administrateur.
        </div>
        <a href="./" class="btn btn-default pull-right">Retour</a>
        <?php
    }
}
?>