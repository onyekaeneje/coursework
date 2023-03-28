<?php
include_once $_SERVER['DOCUMENT_ROOT'] . "/storyapp/backend/connection.php";
include_once "story.php";


class Location
{
    public $id, $country, $coordinate;

    function __construct($item)
    {
        $this->id = !empty($item['id']) ? $item['id'] : null;
        $this->country = !empty($item['country']) ? $item['country'] : null;
        $this->coordinate = !empty($item['coordinate']) ? $item['coordinate'] : null;
    }

    static function all()
    {
        connect();
        $sql =  "SELECT * FROM locations";
        global $db;
        $result = $db->query($sql);
        $locations = [];
        if ($result->num_rows > 0) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                $location = new Location($row);
                array_push($locations, $location);
            }
            return $locations;
        } else {
            close();
            return false;
        }
    }

    static function get($id)
    {
        connect();
        $sql =  "SELECT * FROM locations where id = " . $id;
        global $db;
        $result = $db->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $location = new Location($row);
                break;
            }
            return $location;
        } else {
            close();
            return false;
        }
    }
    public function delete()
    {

        connect();
        global $db;
        $stmt = $db->prepare("DELETE FROM locations where id = ?");
        $stmt->bind_param("i", $this->id);

        try {
            if ($stmt->execute() === TRUE) {
                close();
                return true;
            } else {
                close();
                return "Error deleting record: " . $db->error;
            }
        } catch (mysqli_sql_exception $e) {
            close();
            return "An error Occured: " . $e->getMessage();
        } 
    }
    static function create($location)
    {
        connect();
        global $db;
        $stmt = $db->prepare("INSERT INTO locations (country, coordinate) VALUES (?, ?)");
        $stmt->bind_param("ss", $location['name'], $location['coordinate']);
        try {
            if ($stmt->execute() === TRUE) {
                return Location::get($db->insert_id);
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
        $stmt = $db->prepare("INSERT INTO locations (country, coordinate) VALUES (?, ?)");
        $stmt->bind_param("ss", $this->country, $this->coordinate);
        try {
            if ($stmt->execute() === TRUE) {
                return Location::get($db->insert_id);
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
        $stmt = $db->prepare("UPDATE locations SET country=?, coordinate=? WHERE id=?");
        $stmt->bind_param("ssi", $this->country, $this->coordinate, $this->id);
        try {
            if ($stmt->execute() === TRUE) {
                close();
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

    public function stories()
    {
        connect();
        $sql =  "SELECT * FROM stories where location_id = " . $this->id;
        global $db;
        $result = $db->query($sql);
        $stories = [];
        if ($result->num_rows > 0) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                $story = new Story($row);
                array_push($stories, $story);
            }
            close();
            return $stories;
        } else {
            close();
            return false;
        }
    }
}

