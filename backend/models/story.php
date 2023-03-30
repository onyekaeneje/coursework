<?php
include_once dirname(__DIR__) . "/connection.php";
include_once "category.php";
include_once "location.php";
include_once "user.php";

class Story
{
    public $id, $user_id, $timestamp, $title, $published, $created_at, $updated_at, $views, $likes, $location_id, $description, $category_id, $content, $image;

    function __construct($item)
    {
        $this->id = !empty($item['id']) ? $item['id'] : null;
        $this->user_id = !empty($item['user_id']) ? $item['user_id'] : null;
        $this->title = !empty($item['title']) ? $item['title'] : null;
        $this->description =
            !empty($item['description']) ? $item['description'] : null;
        $this->category_id =
            !empty($item['category_id']) ? $item['category_id'] : null;
        $this->content =
            !empty($item['content']) ? $item['content'] : null;
        $this->image =
            !empty($item['image']) ? $item['image'] : null;
        $this->location_id =
            !empty($item['location_id']) ? $item['location_id'] : null;
        $this->published =
            !empty($item['published']) ? $item['published'] : 0;
        $this->views =
            !empty($item['views']) ? $item['views'] : null;
        $this->likes =
            !empty($item['likes']) ? $item['likes'] : null;
        $this->created_at =
            !empty($item['created_at']) ? $item['created_at'] : null;
        $this->updated_at =
            !empty($item['updated_at']) ? $item['updated_at'] : null;
        $this->timestamp = date("Y/m/d h:i:sa");
    }

    static function all($limit = 10, $published = false, $offset = 0, $order = "DESC")
    {
        connect();
        $publish_query = $published ? " where published = 1 " : " ";
        $sql =  "SELECT * FROM stories" . $publish_query . " ORDER BY created_at $order LIMIT $limit OFFSET $offset" ;
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

    static function get($id)
    {
        connect();
        $sql =  "SELECT * FROM stories where id = " . $id;
        global $db;
        $result = $db->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                $story = new Story($row);
                break;
            }
            return $story;
        } else {
            close();
            return false;
        }
    }
    public function delete()
    {

        connect();
        global $db;
        $stmt = $db->prepare("DELETE FROM stories where id = ?");
        $stmt->bind_param("i", $this->id);

        try {
            if ($stmt->execute() === TRUE) {
                $stmt->close();
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
    static function create($story)
    {
        connect();
        global $db;
        $date = date("Y/m/d h:i:sa");
        $stmt = $db->prepare("INSERT INTO stories (user_id, title, description, category_id, content, image, location_id, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ississis", $story['user_id'], $story['title'], $story['description'], $story['category_id'], $story['content'], $story['image'], $story['location_id'], $date);
        try {
            if ($stmt->execute() === TRUE) {
                $stmt->close();
                return Story::get($db->insert_id);
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
        $stmt = $db->prepare("INSERT INTO stories (user_id, title, description, category_id, content, image, location_id, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ississis", $this->user_id, $this->title, $this->description, $this->category_id, $this->content, $this->image, $this->location_id, $this->timestamp);
        try {
            if ($stmt->execute() === TRUE) {
                $stmt->close();
                return Story::get($db->insert_id);
            } else {
                close();
                return "Error creating record: " . $db->error;
            }
        } catch (mysqli_sql_exception $e) {
            close();
            return "An error Occured: " . $e->getMessage();
        }
    }

    public function update()
    {
        connect();
        global $db;
        $stmt = $db->prepare("UPDATE stories SET user_id=?, title=?, description=?, category_id=?, content=?, image=?, location_id=?, published=?, updated_at=? WHERE id=?");
        $stmt->bind_param("ississiisi", $this->user_id, $this->title, $this->description, $this->category_id, $this->content, $this->image, $this->location_id, $this->published, $this->timestamp, $this->id);
        try {
            if ($stmt->execute() === TRUE) {
                $stmt->close();
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

    public function category()
    {
        connect();
        $sql =  "SELECT * FROM categories where id = " . $this->category_id;
        global $db;
        $result = $db->query($sql);
        if ($result->num_rows > 0) {
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

    public function location()
    {
        connect();
        $sql =  "SELECT * FROM locations where id = " . $this->location_id;
        global $db;
        $result = $db->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $result = new Location($row);
                break;
            }
            return $result;
        } else {
            close();
            return false;
        }
    }

    public function user()
    {
        connect();
        $sql =  "SELECT * FROM users where id = " . $this->user_id;
        global $db;
        $result = $db->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $result = new User($row);
                break;
            }
            return $result;
        } else {
            close();
            return false;
        }
    }
    public function author()
    {
        $user = $this->user();
       $name  = $user->last_name . " " . $user->first_name;
       return $name;
    }
    public function date()
    {
        
        return
        date("F jS, Y h:i", strtotime($this->created_at));
    }

    public function comments()
    {
        connect();
        $sql =  "SELECT * FROM comments where story_id = " . $this->id;
        global $db;
        $result = $db->query($sql);
        $comments = [];
        if ($result->num_rows > 0) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                $comment =  Comment::get($row['id']);
                array_push($comments, $comment);
            }
            return $comments;
        } else {
            close();
            return false;
        }
    }
    static function num_rows()
    {
        connect();
        $sql =  "SELECT COUNT(id) as count FROM stories ";
        global $db;
        $result = $db->query($sql);
        if ($result->num_rows > 0) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                $comment = $row['count'];
            }
            return $comment;
        } else {
            close();
            return 0;
        }
    }
}

?>