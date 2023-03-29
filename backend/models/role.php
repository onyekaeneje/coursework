<?php
include_once dirname(__DIR__) . "/connection.php";
include_once "privilege.php";
include_once "user.php";


class Role
{
    public $id, $name;

    function __construct($item)
    {
        $this->id = !empty($item['id']) ? $item['id'] : null;
        $this->name = !empty($item['name']) ? $item['name'] : null;
    }

    static function all()
    {
        connect();
        $sql =  "SELECT * FROM roles";
        global $db;
        $result = $db->query($sql);
        $roles = [];
        if ($result->num_rows > 0) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                $row = new Role($row);
                array_push($roles, $row);
            }
            return $roles;
        } else {
            close();
            return false;
        }
    }

    static function get($id)
    {
        connect();
        $sql =  "SELECT * FROM roles where id = " . $id;
        global $db;
        $result = $db->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $row = new Role($row);
                break;
            }
            return $row;
        } else {
            close();
            return false;
        }
    }
    public function delete()
    {

        connect();
        global $db;
        $stmt = $db->prepare("DELETE FROM role_privileges where role_id = ?");
        $stmt->bind_param("i", $this->id);

        try {
            if ($stmt->execute() === TRUE) {
                $stmt = $db->prepare("DELETE FROM roles where id = ?");
                $stmt->bind_param("i", $this->id);
                if ($stmt->execute() === TRUE) {
                    close();
                    return true;
                }
                else{
                    close();
                    return "Error deleting record: " . $db->error;  
                }
            } else {
                close();
                return "Error deleting record: " . $db->error;
            }
        } catch (mysqli_sql_exception $e) {
            close();
            return "An error Occured: " . $e->getMessage();
        } 
    }
    static function create($row)
    {
        connect();
        global $db;
        $stmt = $db->prepare("INSERT INTO roles (name) VALUES (?)");
        $stmt->bind_param("s", $row['name']);
        try {
            if ($stmt->execute() === TRUE) {
                return Role::get($db->insert_id);
            } else {
                close();
                return "Error creating record: " . $db->error;
            }
        } catch (mysqli_sql_exception $e) {
            close();
            return "An error Occured: " . $e->getMessage();
        } 
    }

    public function save()
    {
        connect();
        global $db;
        $stmt = $db->prepare("INSERT INTO roles (name) VALUES (?)");
        $stmt->bind_param("s", $this->name);
        try {
            if ($stmt->execute() === TRUE) {
                return Role::get($db->insert_id);
            } else {
                close();
                return "Error creating record: " . $db->error;
            }
        } catch (mysqli_sql_exception $e) {
            return "An error Occured: " . $e->getMessage();
        }
    }

    public function update()
    {
        connect();
        global $db;
        $stmt = $db->prepare("UPDATE roles SET name=? WHERE id=?");
        $stmt->bind_param("si", $this->name, $this->id);
        try {
            if ($stmt->execute() === TRUE) {
                return true;
            } else {
                close();
                return "Error updating record: " . $db->error;
            }
        } catch (mysqli_sql_exception $e) {
            close();
            return "An error Occured: " . $e->getMessage();
        } 
    }

    public function privileges()
    {
        connect();
        $sql =  "SELECT * FROM role_privileges where role_id = " . $this->id;
        global $db;
        $result = $db->query($sql);
        $privileges = [];
        if ($result->num_rows > 0) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                $privilege =  Privilege::get($row['privilege_id']);
                array_push($privileges, $privilege);
            }
            return $privileges;
        } else {
            close();
            return false;
        }
    }
    public function add_privilege(Privilege $privilege)
    {
        connect();
        global $db;
        $stmt = $db->prepare("INSERT INTO role_privileges (role_id, privilege_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $this->id, $privilege->id);

        try {
            if ($stmt->execute() === TRUE) {
                return $this;
            } else {
                close();
                return "Error adding privilege: " . $db->error;
            }
        } catch (mysqli_sql_exception $e) {
            close();
            return "An error Occured: " . $e->getMessage();
        } 
    }
}


?>