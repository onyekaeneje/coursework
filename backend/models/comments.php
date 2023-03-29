<?php
include_once dirname(__DIR__) . "/connection.php";
include_once "story.php";
include_once "user.php";


class Comment
{
    public $id, $story_id, $timestamp, $content, $likes, $user_id, $created_at;

    function __construct($item)
    {
        $this->id = !empty($item['id']) ? $item['id'] : null;
        $this->story_id = !empty($item['story_id']) ? $item['story_id'] : null;
        $this->content = !empty($item['content']) ? $item['content'] : null;
        $this->likes = !empty($item['likes']) ? $item['likes'] : 0;
        $this->user_id = !empty($item['user_id']) ? $item['user_id'] : null;
        $this->created_at = !empty($item['created_at']) ? $item['created_at'] : null;
        $this->timestamp = date("Y/m/d h:i:sa");
    }

    static function all()
    {
        connect();
        $sql =  "SELECT * FROM comments";
        global $db;
        $result = $db->query($sql);
        $comments = [];
        if ($result->num_rows > 0) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                $row = new Comment($row);
                array_push($comments, $row);
            }
            return $comments;
        } else {
            close();
            return false;
        }
    }

    static function get($id)
    {
        connect();
        $sql =  "SELECT * FROM comments where id = " . $id;
        global $db;
        $result = $db->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $row = new Comment($row);
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
        $stmt = $db->prepare("DELETE FROM comments where id = ?");
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
    static function create($row)
    {
        connect();
        $date = date("Y/m/d h:i:sa");
        $likes = 0;
        global $db;
        $stmt = $db->prepare(
            "INSERT INTO comments (story_id, content, likes, user_id, created_at) VALUES (?,?,?,?,?)"
        );
        $stmt->bind_param("isiis", $row['story_id'], $row['content'], $likes, $row['user_id'], $date);
        try {
            if ($stmt->execute() === TRUE) {
                $stmt->close();
                return Comment::get($db->insert_id);
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
        $stmt = $db->prepare("INSERT INTO comments (story_id, content, likes, user_id, created_at) VALUES (?,?,?,?,?)");
        $stmt->bind_param("isiis", $this->story_id, $this->content, $this->likes, $this->user_id, $this->timestamp);
        try {
            if ($stmt->execute() === TRUE) {
                $stmt->close();
                return Comment::get($db->insert_id);
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
        $stmt = $db->prepare("UPDATE comments SET story_id=?, content=?, likes=?, user_id=? WHERE id=?");
        $stmt->bind_param("isiii", $this->story_id, $this->content, $this->likes, $this->user_id, $this->id);
        try {
            if ($stmt->execute() === TRUE) {
                $stmt->close();
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

    public function story()
    {
        connect();
        $sql =  "SELECT * FROM stories where id = " . $this->story_id;
        global $db;
        $result = $db->query($sql);
        if ($result->num_rows > 0) {
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
    public function user()
    {
        connect();
        $sql =  "SELECT * FROM users where id = " . $this->user_id;
        global $db;
        $result = $db->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $user = new User($row);
                break;
            }
            return $user;
        } else {
            close();
            return false;
        }
    }
}

?>