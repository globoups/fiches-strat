<?php
require_once(dirname(__FILE__) . "/../config.php");
require_once(dirname(__FILE__) . "/../model/models.php");

class DatabaseManager
{
    private $mysqli = NULL;
    
    public function __construct()
    {
        $this->mysqli = new mysqli($GLOBALS["dbHost"], $GLOBALS["dbUser"], $GLOBALS["dbPassword"], $GLOBALS["dbName"]);
        $this->mysqli->set_charset($GLOBALS["dbCharset"]);
    }

    public function createCard($card, $user)
    {
        $boss = $this->getBoss($card->boss_key);
        $difficulty = $this->getDifficulty($card->difficulty_key);
        $role = $this->getRole($card->role_key);
        $nextVersion = $this->getCardNextVersion($card->boss_key, $card->difficulty_key, $card->role_key);
        $user = $this->getUser($user->name);
        
        $cardId = null;

        if (!is_null($boss) && !is_null($difficulty) && !is_null($role) && !is_null($user)) {
            $query = "
                INSERT INTO fs_card (boss_id, difficulty_id, role_id, version, user_id)
                VALUES (?, ?, ?, ?, ?)";
        
            if ($stmt = $this->mysqli->prepare($query)) {
                $stmt->bind_param("iiiii", $boss->id, $difficulty->id, $role->id, $nextVersion, $user->id);

                if ($stmt->execute()) {
                    $cardId = $stmt->insert_id;
                }

                $stmt->close();
            }
        }

        return $cardId;
    }

    public function createChildBloc($bloc, $parentId)
    {
        $query = "
            INSERT INTO fs_bloc (type, content, `order`, parent_id)
            VALUE (?, ?, ?, ?)";
        $blocId = null;
        
        if ($stmt = $this->mysqli->prepare($query)) {
            $stmt->bind_param("ssii", $bloc->type, $bloc->content, $bloc->order, $parentId);

            if ($stmt->execute()) {
                $blocId = $stmt->insert_id;
            }

            $stmt->close();
        }

        return $blocId;
    }

    public function createRootBloc($bloc, $cardId)
    {
        $query = "
            INSERT INTO fs_bloc (type, content, `order`, card_id)
            VALUE (?, ?, ?, ?)";
        $blocId = null;
        
        if ($stmt = $this->mysqli->prepare($query)) {
            $stmt->bind_param("ssii", $bloc->type, $bloc->content, $bloc->order, $cardId);

            if ($stmt->execute()) {
                $blocId = $stmt->insert_id;
            }

            $stmt->close();
        }

        return $blocId;
    }
    
    public function getBlocRoles($blocId)
    {
        $query = "
            SELECT r.*
            FROM fs_role r
            INNER JOIN fs_bloc_role br ON r.id = br.role_id
            WHERE br.bloc_id = ?
            ORDER BY r.order";
        $res = $this->mysqli->query($query);
        $roles = array();
        
        if ($stmt = $this->mysqli->prepare($query)) {
            $stmt->bind_param("i", $blocId);
            $stmt->execute();
            $res = $stmt->get_result();
            
            while ($row = $res->fetch_assoc()) {
                $role = new Role();
                $role->key = $row["key"];
                $role->name = $row["name"];
                $role->order = $row["order"];
                $roles[] = $role;
            }
            
            $stmt->close();
        }
        
        return $roles;
    }
    
    public function getBlocsByCardId($cardId)
    {
        $query = "
            SELECT *
            FROM fs_bloc
            WHERE card_id = ?
            ORDER BY `order`";
        $blocs = array();
        
        if ($stmt = $this->mysqli->prepare($query)) {
            $stmt->bind_param("i", $cardId);
            $stmt->execute();
            $res = $stmt->get_result();
            
            while ($row = $res->fetch_assoc()) {
                $bloc = new Bloc();
                $bloc->id = $row["id"];
                $bloc->type = $row["type"];
                $bloc->key = $row["key"];
                $bloc->content = $row["content"];
                $bloc->order = $row["order"];
                $blocs[] = $bloc;
            }
            
            $stmt->close();
        }
        
        return $blocs;
    }
    
    public function getBlocsByParentId($parentId)
    {
        $query = "
            SELECT *
            FROM fs_bloc
            WHERE parent_id = ?
            ORDER BY `order`";
        $blocs = array();
        
        if ($stmt = $this->mysqli->prepare($query)) {
            $stmt->bind_param("i", $parentId);
            $stmt->execute();
            $res = $stmt->get_result();
            
            while ($row = $res->fetch_assoc()) {
                $bloc = new Bloc();
                $bloc->id = $row["id"];
                $bloc->type = $row["type"];
                $bloc->key = $row["key"];
                $bloc->content = $row["content"];
                $bloc->order = $row["order"];
                $blocs[] = $bloc;
            }
            
            $stmt->close();
        }
        
        return $blocs;
    }
    
    public function getBoss($key)
    {
        $query = "
            SELECT b.*, i.key AS instance_key
            FROM fs_boss b
            INNER JOIN fs_instance i ON i.id = b.instance_id
            WHERE b.key = ?";
        $boss = null;
        
        if ($stmt = $this->mysqli->prepare($query)) {
            $stmt->bind_param("s", $key);
            $stmt->execute();
            $res = $stmt->get_result();
            
            if ($row = $res->fetch_assoc()) {
                $boss = new Boss();
                $boss->id = $row["id"];
                $boss->key = $row["key"];
                $boss->name = $row["name"];
                $boss->order = $row["order"];
                $boss->instanceKey = $row["instance_key"];
            }
            
            $stmt->close();
        }
        
        return $boss;
    }
    
    public function getBosses()
    {
        $query = "
            SELECT b.*, i.key AS instance_key
            FROM fs_boss b
            INNER JOIN fs_instance i ON i.id = b.instance_id
            ORDER BY b.order";
        $res = $this->mysqli->query($query);
        $bosses = array();
        
        while ($row = $res->fetch_assoc()) {
            $boss = new Boss();
            $boss->key = $row["key"];
            $boss->name = $row["name"];
            $boss->order = $row["order"];
            $boss->instanceKey = $row["instance_key"];
            $bosses[] = $boss;
        }
        
        return $bosses;
    }
    
    public function getCard($bossKey, $difficultyKey, $roleKey)
    {
        $query = "
            SELECT c.*, b.key AS boss_key, d.key AS difficulty_key, r.key as role_key
            FROM fs_card c
            INNER JOIN fs_boss b ON b.id = c.boss_id
            INNER JOIN fs_difficulty d ON d.id = c.difficulty_id
            INNER JOIN fs_role r ON r.id = c.role_id
            WHERE b.key = ? AND d.key = ? AND r.key = ? AND c.deleted = 0
            ORDER BY c.version DESC
            LIMIT 0, 1";
        $card = null;
        
        if ($stmt = $this->mysqli->prepare($query)) {
            $stmt->bind_param("sss", $bossKey, $difficultyKey, $roleKey);
            $stmt->execute();
            $res = $stmt->get_result();
            
            if ($row = $res->fetch_assoc()) {
                $card = new Card();
                $card->id = $row["id"];
                $card->bossKey = $row["boss_key"];
                $card->difficultyKey = $row["difficulty_key"];
                $card->roleKey = $row["role_key"];
            }
            
            $stmt->close();
        }
        
        return $card;
    }
    
    public function getCardNextVersion($bossKey, $difficultyKey, $roleKey)
    {
        $query = "
            SELECT MAX(c.version) AS last_version
            FROM fs_card c
            INNER JOIN fs_boss b ON b.id = c.boss_id
            INNER JOIN fs_difficulty d ON d.id = c.difficulty_id
            INNER JOIN fs_role r ON r.id = c.role_id
            WHERE b.key = ? AND d.key = ? AND r.key = ?";
        $nextVersion = 1;
        
        if ($stmt = $this->mysqli->prepare($query)) {
            $stmt->bind_param("sss", $bossKey, $difficultyKey, $roleKey);
            $stmt->execute();
            $res = $stmt->get_result();
            
            if ($row = $res->fetch_assoc()) {
                $nextVersion = $row["last_version"] + 1;
            }
            
            $stmt->close();
        }
        
        return $nextVersion;
    }
    
    public function getCards()
    {
        $query = "
            SELECT c.*, b.key AS boss_key, d.key AS difficulty_key, r.key as role_key
            FROM fs_card c
            INNER JOIN fs_boss b ON b.id = c.boss_id
            INNER JOIN fs_difficulty d ON d.id = c.difficulty_id
            INNER JOIN fs_role r ON r.id = c.role_id
            WHERE c.deleted = 0
            GROUP BY c.boss_id, c.difficulty_id, c.role_id";
        $res = $this->mysqli->query($query);
        $cards = array();
        
        while ($row = $res->fetch_assoc()) {
            $card = new Card();
            $card->id = $row["id"];
            $card->bossKey = $row["boss_key"];
            $card->difficultyKey = $row["difficulty_key"];
            $card->roleKey = $row["role_key"];
            $cards[] = $card;
        }
        
        return $cards;
    }
    
    public function getDifficulties()
    {
        $query = "
            SELECT *
            FROM fs_difficulty
            ORDER BY `order`";
        $res = $this->mysqli->query($query);
        $difficulties = array();
        
        while ($row = $res->fetch_assoc()) {
            $difficulty = new Difficulty();
            $difficulty->key = $row["key"];
            $difficulty->name = $row["name"];
            $difficulty->order = $row["order"];
            $difficulties[] = $difficulty;
        }
        
        return $difficulties;
    }
    
    public function getDifficulty($key)
    {
        $query = "
            SELECT *
            FROM fs_difficulty
            WHERE `key` = ?";
        $difficulty = null;
        
        if ($stmt = $this->mysqli->prepare($query)) {
            $stmt->bind_param("s", $key);
            $stmt->execute();
            $res = $stmt->get_result();
            
            if ($row = $res->fetch_assoc()) {
                $difficulty = new Difficulty();
                $difficulty->id = $row["id"];
                $difficulty->key = $row["key"];
                $difficulty->name = $row["name"];
                $difficulty->order = $row["order"];
            }
            
            $stmt->close();
        }
        
        return $difficulty;
    }
    
    public function getInstance($key)
    {
        $query = "
            SELECT i.*, it.key AS instance_type_key
            FROM fs_instance i
            INNER JOIN fs_instance_type it ON it.id = i.instance_type_id
            WHERE i.key = ?";
        $instance = null;
        
        if ($stmt = $this->mysqli->prepare($query)) {
            $stmt->bind_param("s", $key);
            $stmt->execute();
            $res = $stmt->get_result();
            
            if ($row = $res->fetch_assoc()) {
                $instance = new Instance();
                $instance->isExpanded = $row["expanded"];
                $instance->key = $row["key"];
                $instance->name = $row["name"];
                $instance->order = $row["order"];
                $instance->typeKey = $row["instance_type_key"];
            }
            
            $stmt->close();
        }
        
        return $instance;
    }
    
    public function getInstances()
    {
        $query = "
            SELECT i.*, it.key AS instance_type_key
            FROM fs_instance i
            INNER JOIN fs_instance_type it ON it.id = i.instance_type_id
            ORDER BY i.order";
        $res = $this->mysqli->query($query);
        $instances = array();
        
        while ($row = $res->fetch_assoc()) {
            $instance = new Instance();
            $instance->isExpanded = $row["expanded"];
            $instance->key = $row["key"];
            $instance->name = $row["name"];
            $instance->order = $row["order"];
            $instance->typeKey = $row["instance_type_key"];
            $instances[] = $instance;
        }
        
        return $instances;
    }
    
    public function getInstanceTypes()
    {
        $query = "
            SELECT *
            FROM fs_instance_type
            ORDER BY `order`";
        $res = $this->mysqli->query($query);
        $instanceTypes = array();
        
        while ($row = $res->fetch_assoc()) {
            $instanceType = new InstanceType();
            $instanceType->key = $row["key"];
            $instanceType->name = $row["name"];
            $instanceType->order = $row["order"];
            $instanceTypes[] = $instanceType;
        }
        
        return $instanceTypes;
    }
    
    public function getRole($key)
    {
        $query = "
            SELECT *
            FROM fs_role
            WHERE `key` = ?";
        $role = null;
        
        if ($stmt = $this->mysqli->prepare($query)) {
            $stmt->bind_param("s", $key);
            $stmt->execute();
            $res = $stmt->get_result();
            
            if ($row = $res->fetch_assoc()) {
                $role = new Role();
                $role->id = $row["id"];
                $role->key = $row["key"];
                $role->name = $row["name"];
                $role->order = $row["order"];
            }
            
            $stmt->close();
        }
        
        return $role;
    }
    
    public function getUser($name)
    {
        $query = "
            SELECT *
            FROM fs_user
            WHERE `name` = ?";
        $user = null;
        
        if ($stmt = $this->mysqli->prepare($query)) {
            $stmt->bind_param("s", $name);
            $stmt->execute();
            $res = $stmt->get_result();
            
            if ($row = $res->fetch_assoc()) {
                $user = new User();
                $user->id = $row["id"];
                $user->name = $row["name"];
            }
            
            $stmt->close();
        }
        
        return $user;
    }
    
    public function getRoles()
    {
        $query = "
            SELECT *
            FROM fs_role
            ORDER BY `order`";
        $res = $this->mysqli->query($query);
        $roles = array();
        
        while ($row = $res->fetch_assoc()) {
            $role = new Role();
            $role->key = $row["key"];
            $role->name = $row["name"];
            $role->order = $row["order"];
            $roles[] = $role;
        }
        
        return $roles;
    }

    public function log($level, $message)
    {
        $query = "
            INSERT INTO fs_log (date, level, message)
            VALUE (NOW(), ?, ?)";
        $logId = null;
        
        if ($stmt = $this->mysqli->prepare($query)) {
            $stmt->bind_param("is", $level, $message);

            if ($stmt->execute()) {
                $logId = $stmt->insert_id;
            }

            $stmt->close();
        }

        return $logId;
    }

    public function validateCredentials($login, $pwdHash)
    {
        $query = "
            SELECT COUNT(*) AS results
            FROM fs_user
            WHERE name = ? AND password = ?";
        $result = false;
        
        if ($stmt = $this->mysqli->prepare($query)) {
            $stmt->bind_param("ss", $login, $pwdHash);
            $stmt->execute();
            $res = $stmt->get_result();
            
            if ($row = $res->fetch_assoc()) {
                $result = $row["results"] == 1;
            }
            
            $stmt->close();
        }
        
        return $result;
    }
}
?>