<?php
include_once dirname(__DIR__) . "/connection.php";
include_once "role.php";


class Privilege
{
    public $id, $resource, $ability;

    function __construct($item)
    {
        $this->id = !empty($item['id']) ? $item['id'] : null;
        $this->resource = !empty($item['resource']) ? $item['resource'] : null;
        $this->ability = !empty($item['ability']) ? $item['ability'] : null;
    }

    static function all()
    {
        connect();
        $sql =  "SELECT * FROM privileges";
        global $db;
        $result = $db->query($sql);
        $privileges = [];
        if ($result->num_rows > 0) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                $row = new Privilege($row);
                array_push($privileges, $row);
            }
            return $privileges;
        } else {
            close();
            return false;
        }
    }

    static function get($id)
    {
        connect();
        $sql =  "SELECT * FROM privileges where id = " . $id;
        global $db;
        $result = $db->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $row = new Privilege($row);
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
        $stmt = $db->prepare("DELETE FROM role_privileges where privilege_id = ?");
        $stmt->bind_param("i", $this->id);

        try {
            if ($stmt->execute() === TRUE) {
                $stmt = $db->prepare("DELETE FROM privileges where id = ?");
                $stmt->bind_param("i", $this->id);
                if ($stmt->execute() === TRUE) {
                    close();
                    return true;
                } else {
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
        $row = explode(':', $row);
        global $db;
        $stmt = $db->prepare("INSERT INTO privileges (resource, ability) VALUES (?, ?)");
        $stmt->bind_param("ss", $row[0], $row[1]);
        try {
            if ($stmt->execute() === TRUE) {
                return Privilege::get($db->insert_id);
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
        $stmt = $db->prepare("INSERT INTO privileges (resource, ability) VALUES (?, ?)");
        $stmt->bind_param("ss", $this->resource, $this->ability);
        try {
            if ($stmt->execute() === TRUE) {
                return Privilege::get($db->insert_id);
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
        $stmt = $db->prepare("UPDATE privileges SET resource=?, ability=? WHERE id=?");
        $stmt->bind_param("ssi", $this->resource, $this->ability, $this->id);
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

    public function roles()
    {
        connect();
        $sql =  "SELECT * FROM role_privileges where privilege_id = " . $this->id;
        global $db;
        $result = $db->query($sql);
        $roles = [];
        if ($result->num_rows > 0) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                $role =  Role::get($row['role_id']);
                array_push($roles, $role);
            }
            // close();
            return $roles;
        } else {
            close();
            return false;
        }
    }
}
?>