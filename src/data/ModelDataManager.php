<?php
require_once("DatabaseManager.php");

class ModelDataManager
{
    private $bosses = null;
    private $cards = null;
    private $database = null;
    private $difficulties = null;
    private $instances = null;
    private $instanceTypes = null;
    private $roles = null;
    
    public function __construct()
    {
        $this->database = new DatabaseManager();
    }

    public function createCard($card, $user)
    {
        $this->database->createCard($card, $user);
    }
    
    public function getBlocsByCardId($cardId)
    {
        $blocs = $this->database->getBlocsByCardId($cardId);
        
        foreach ($blocs as $bloc) {
            $bloc->children = $this->getBlocsByParentId($bloc->id);
            $bloc->roles = $this->database->getBlocRoles($bloc->id);
        }
        
        return $blocs;
    }
    
    public function getBlocsByParentId($parentId)
    {
        $blocs = $this->database->getBlocsByParentId($parentId);
        
        foreach ($blocs as $bloc) {
            $bloc->children = $this->getBlocsByParentId($bloc->id);
            $bloc->roles = $this->database->getBlocRoles($bloc->id);
        }
        
        return $blocs;
    }
    
    public function getBoss($key)
    {
        $result = null;
        
        if (!is_null($this->bosses)) {
            foreach ($this->bosses as $boss) {
                if ($boss->key == $key) {
                    $result = $boss;
                }
            }
        }
        else {
            $result = $this->database->getBoss($key);
        }
        
        $result->instance = $this->getInstance($result->instanceKey);
        
        return $result;
    }
    
    public function getBosses()
    {
        if(is_null($this->bosses)) {
            $this->bosses = $this->database->getBosses();
        
            foreach ($this->bosses as $boss) {
                $boss->instance = $this->getInstance($boss->instanceKey);
            }
        }
        
        return $this->bosses;
    }
    
    public function getCard($bossKey, $difficultyKey, $roleKey)
    {
        $result = null;
        
        if (!is_null($this->cards)) {
            foreach ($this->cards as $card) {
                if ($card->bossKey == $bossKey && $card->difficultyKey == $difficultyKey &&$card->roleKey == $roleKey) {
                    $result = $card;
                }
            }
        }
        else {
            $result = $this->database->getCard($bossKey, $difficultyKey, $roleKey);
        }
        
        $result->boss = $this->getBoss($result->bossKey);
        $result->difficulty = $this->getDifficulty($result->difficultyKey);
        $result->role = $this->getRole($result->roleKey);
        $result->blocs = $this->getBlocsByCardId($result->id);
        
        return $result;
    }
    
    public function getCards()
    {
        if(is_null($this->cards)) {
            $this->cards = $this->database->getCards();
        
            foreach ($this->cards as $card) {
                $card->boss = $this->getBoss($card->bossKey);
                $card->difficulty = $this->getDifficulty($card->difficultyKey);
                $card->role = $this->getRole($card->roleKey);
            }
        }
        
        return $this->cards;
    }
    
    public function getDifficulties()
    {
        if(is_null($this->difficulties)) {
            $this->difficulties = $this->database->getDifficulties();
        }
        
        return $this->difficulties;
    }
    
    public function getDifficulty($key)
    {
        if (!is_null($this->difficulties)) {
            foreach ($this->difficulties as $difficulty) {
                if ($difficulty->key == $key) {
                    return $difficulty;
                }
            }
        }
        
        return $this->database->getDifficulty($key);
    }
    
    public function getInstance($key)
    {
        if (!is_null($this->instances)) {
            foreach ($this->instances as $instance) {
                if ($instance->key == $key) {
                    return $instance;
                }
            }
        }
        
        return $this->database->getInstance($key);
    }
    
    public function getInstances()
    {
        if(is_null($this->instances)) {
            $this->instances = $this->database->getInstances();
        
            foreach ($this->instances as $instance) {
                $instance->type = $this->getInstanceType($instance->typeKey);
            }
        }
        
        return $this->instances;
    }
    
    public function getInstanceType($key)
    {
        if(is_null($this->instanceTypes)) {
            $this->getInstanceTypes();
        }
        
        foreach ($this->instanceTypes as $instanceType) {
            if ($instanceType->key == $key) {
                return $instanceType;
            }
        }
        
        return NULL;
    }
    
    public function getInstanceTypes()
    {
        if(is_null($this->instanceTypes)) {
            $this->instanceTypes = $this->database->getInstanceTypes();
        }
        
        return $this->instanceTypes;
    }
    
    public function getRole($key)
    {
        if (!is_null($this->roles)) {
            foreach ($this->roles as $role) {
                if ($role->key == $key) {
                    return $role;
                }
            }
        }
        
        return $this->database->getRole($key);
    }
    
    public function getRoles()
    {
        if(is_null($this->roles)) {
            $this->roles = $this->database->getRoles();
        }
        
        return $this->roles;
    }

    public function updateCard($card, $user)
    {
        $this->createCard($card, $user);
        //echo '{"test":"'.$card->id.'"}';
    }

    public function validateCredentials($login, $password)
    {
        $hash = hash("sha256", $password);
        $result = $this->database->validateCredentials($login, $hash);
        
        return $result;
    }
}
?>