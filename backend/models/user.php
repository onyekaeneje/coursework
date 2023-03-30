<?php
include_once dirname(__DIR__). "/connection.php";
include_once "role.php";
include_once "location.php";
include_once "comments.php";
include_once "story.php";


class User
{
    public $id, $last_name, $timestamp, $first_name, $gender, $created_at, $email_verified_at, $dob, $email, $location_id, $role_id, $telephone, $bio, $followers, $image, $password;

    function __construct($item)
    {
        $this->id = !empty($item['id']) ? $item['id'] : null;
        $this->last_name = !empty($item['last_name']) ? $item['last_name'] : null;
        $this->first_name = !empty($item['first_name']) ? $item['first_name'] : null;
        $this->role_id =
            !empty($item['role_id']) ? $item['role_id'] : null;
        $this->telephone =
            !empty($item['telephone']) ? $item['telephone'] : null;
        $this->bio =
            !empty($item['bio']) ? $item['bio'] : null;
        $this->image =
            !empty($item['image']) ? $item['image'] : "author.png";
        $this->location_id =
            !empty($item['location_id']) ? $item['location_id'] : null;
        $this->gender =
            !empty($item['gender']) ? $item['gender'] : null;
        $this->dob =
            !empty($item['dob']) ? $item['dob'] : null;
        $this->email =
            !empty($item['email']) ? $item['email'] : null;
        $this->created_at =
            !empty($item['created_at']) ? $item['created_at'] : null;
        $this->email_verified_at =
            !empty($item['email_verified_at']) ? $item['email_verified_at'] : null;
        $this->followers =
        !empty($item['followers']) ? $item['followers'] : 0;
        $this->password =
        !empty($item['password']) ? $item['password'] : null;
        $this->timestamp = date("Y/m/d h:i:sa");
    }

    static function all()
    {
        connect();
        $sql =  "SELECT * FROM users";
        global $db;
        $result = $db->query($sql);
        $users = [];
        if ($result->num_rows > 0) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                $user = new User($row);
                array_push($users, $user);
            }
            return $users;
        } else {
            close();
            return false;
        }
    }

    static function get($id)
    {
        connect();
        $sql =  "SELECT * FROM users where id = " . $id;
        global $db;
        $result = $db->query($sql);

        if ($result->num_rows > 0) {
            // output data of each row
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
    public function delete()
    {

        connect();
        global $db;
        $stmt = $db->prepare("DELETE FROM users where id = ?");
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
    static function create($user)
    {
        connect();
        global $db;
        $date = date("Y/m/d h:i:sa");
        $followers = 0;
        $user['image'] = empty($user['image']) ? "author.png" :  $user['image'];
        $stmt = $db->prepare("INSERT INTO users (last_name, first_name, role_id, telephone, bio, image, location_id, created_at, followers, password, email_verified_at, gender, email, dob) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssisssisisssss", $user['last_name'], $user['first_name'], $user['role_id'], $user['telephone'], $user['bio'], $user['image'], $user['location_id'], $date, $followers, $user['password'], $user['email_verified_at'], $user['gender'], $user['email'], $user['dob']);
        try {
            if ($stmt->execute() === TRUE) {
                $stmt->close();
                return User::get($db->insert_id);
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
        $stmt = $db->prepare("INSERT INTO users (last_name, first_name, role_id, telephone, bio, image, location_id, created_at, followers, password, email_verified_at, gender, email, dob) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssisssisisssss", $this->last_name, $this->first_name, $this->role_id, $this->telephone, $this->bio, $this->image, $this->location_id, $this->timestamp, $this->followers, $this->password, $this->email_verified_at, $this->gender, $this->email, $this->dob);
       
        try {
            if ($stmt->execute() === TRUE) {
                $stmt->close();
                return User::get($db->insert_id);
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
        $stmt = $db->prepare("UPDATE users SET last_name=?, first_name=?, role_id=?, telephone=?, bio=?, image=?, location_id=?, followers=?, password=?,  email_verified_at=?, gender=?, email=?, dob=? WHERE id=?");
        $stmt->bind_param("ssisssisissssi", $this->last_name, $this->first_name, $this->role_id, $this->telephone, $this->bio, $this->image, $this->location_id, $this->timestamp, $this->followers, $this->password, $this->email_verified_at, $this->gender, $this->email, $this->dob);
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

    public function role()
    {
        connect();
        $sql =  "SELECT * FROM roles where id = " . $this->role_id;
        global $db;
        $result = $db->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $role = new Role($row);
                break;
            }
            close();
            return $role;
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
    public function name()
    {
        return  $this->last_name . " " . $this->first_name;
       
    }

    public function stories($limit = 10, $published = false)
    {
        connect();
        $publish_query = $published ? " AND published = 1 " : "";
        $sql =  "SELECT * FROM stories where user_id = " . $this->id . $publish_query .  "  ORDER BY created_at DESC LIMIT $limit";
        global $db;
        $result = $db->query($sql);
        $stories = [];
        if ($result->num_rows > 0) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                $story =  Story::get($row['id']);
                array_push($stories, $story);
            }
            return $stories;
        } else {
            close();
            return [];
        }
    }

    public function comments()
    {
        connect();
        $sql =  "SELECT * FROM comments where user_id = " . $this->id . " ORDER BY created_at ";
        global $db;
        $result = $db->query($sql);
        $comments = [];
        if ($result->num_rows > 0) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                $comment = Comment::get($row['id']);
                array_push($comments, $comment);
            }
            return $comments;
        } else {
            close();
            return false;
        }
    }
}

?>