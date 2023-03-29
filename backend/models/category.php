<?php
include_once dirname(__DIR__) . "/connection.php";
include_once "story.php";


class Category
{
    public $id, $name, $description, $thumbnail, $cta, $image;

    function __construct($item)
    {
        $this->id = $item['id'];
        $this->name = $item['name'];
        $this->description = $item['description'];
        $this->thumbnail = $item['thumbnail'];
        $this->cta = $item['cta'];
        $this->image = $item['image'];
    }

    static function all()
    {
        connect();
        $sql =  "SELECT * FROM categories";
        global $db;
        $result = $db->query($sql);
        $categories = [];
        if ($result->num_rows > 0) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                $category = new Category($row);
                array_push($categories, $category);
            }
            return $categories;
        } else {
            close();
            return false;
        }
    }

    static function get($id)
    {
        connect();
        $sql =  "SELECT * FROM categories where id = " . $id;
        global $db;
        $result = $db->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                $category = new Category($row);
                break;
            }
            return $category;
        } else {
            close();
            return false;
        }
    }
    public function delete()
    {

        connect();
        global $db;
        $stmt = $db->prepare("DELETE FROM categories where id = ?");
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
    static function create($category)
    {
        connect();
        global $db;
        $stmt = $db->prepare("INSERT INTO categories (name, thumbnail, description, cta, image) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $category['name'], $category['thumbnail'], $category['description'], $category['cta'], $category['image']);
        try {
            if ($stmt->execute() === TRUE) {
                return Category::get($db->insert_id);
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
        $stmt = $db->prepare("INSERT INTO categories (name, thumbnail, description, cta, image) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $this->name, $this->thumbnail, $this->description, $this->cta, $this->image);
        try {
            if ($stmt->execute() === TRUE) {
                return Category::get($db->insert_id);
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
        $stmt = $db->prepare("UPDATE categories SET name=?, thumbnail=?, description=?, cta=?, image=? WHERE id=?");
        $stmt->bind_param("sssssi", $this->name, $this->thumbnail, $this->description, $this->cta, $this->image, $this->id);
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
        $sql =  "SELECT * FROM stories where category_id = " . $this->id;
        global $db;
        $result = $db->query($sql);
        $stories = [];
        if ($result->num_rows > 0) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                $story = new Story($row);
                array_push($stories, $story);
            }
            return $stories;
        } else {
            close();
            return false;
        }
    }
}

?>