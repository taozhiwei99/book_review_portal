<?php
include_once("./Connection.php");

class User {
    private $user_ID;
    private $user_Password;
    private $user_Profile;
    private $user_FName;
    private $user_LName;
    private $user_Email;
    private $user_Mobile;

    function get_user($user_ID, $user_Password) {
        $connConfig = new Connection();
        $conn = new mysqli($connConfig->get_servername(), $connConfig->get_username(), $connConfig->get_password(), $connConfig->get_dbname());

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $query = "SELECT * FROM user_info WHERE user_ID = '$user_ID' AND user_Password = '$user_Password'";
        
        $result = $conn->query($query);

        if ($result->num_rows == 0) {
            return false;
        }

        else if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();

            $this->user_ID = $row["user_ID"];
            $this->user_Password = $row["user_Password"];
            $this->user_Profile = $row["user_Profile"];
            $this->user_FName = $row["user_FName"];
            $this->user_LName = $row["user_LName"];
            $this->user_Email = $row["user_Email"];
            $this->user_Mobile = $row["user_Mobile"];

            return true;
        }
        else {
            echo ("<script> console.log('Failed to get user.');</script>");
            return false;
        }
    }

    function get_user_ID() {
        return $this->user_ID;
    }

    function get_user_Password() {
        return $this->user_Password;
    }

    function get_user_Profile() {
        return $this->user_Profile;
    }

    function get_user_FName() {
        return $this->user_FName;
    }

    function get_user_LName() {
        return $this->user_LName;
    }

    function get_user_Email() {
        return $this->user_Email;
    }

    function get_user_Mobile() {
        return $this->user_Mobile;
    }

    function create_author($user_ID, $fname, $lname, $email, $contact_number, $user_Password, $user_Profile) {
        $connConfig = new Connection();
        $conn = new mysqli($connConfig->get_servername(), $connConfig->get_username(), $connConfig->get_password(), $connConfig->get_dbname());

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $query1 = "INSERT INTO user_info (user_ID, user_FName, user_LName, user_Email, user_Mobile, user_Password, user_Profile) VALUES ('$user_ID', '$fname', '$lname', '$email', '$contact_number', '$user_Password', '$user_Profile')";
        $query2 = "INSERT INTO author (user_ID) VALUES ('$user_ID')";

        $bool1 = $conn->query($query1);
        $bool2 = $conn->query($query2);
        $conn->close();

        if (!$bool1 && !$bool2) {
            echo ("<script> console.log('Failed to create author.');</script>");
            return false;
        } ;
        
        return true;
    }

    function create_reviewer($user_ID, $fname, $lname, $email, $contact_number, $user_Password, $user_Profile) {
        $connConfig = new Connection();
        $conn = new mysqli($connConfig->get_servername(), $connConfig->get_username(), $connConfig->get_password(), $connConfig->get_dbname());

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $query1 = "INSERT INTO user_info (user_ID, user_FName, user_LName, user_Email, user_Mobile, user_Password, user_Profile) VALUES ('$user_ID', '$fname', '$lname', '$email', '$contact_number', '$user_Password', '$user_Profile')";
        $query2 = "INSERT INTO reviewer (user_ID) VALUES ('$user_ID')";

        $bool1 = $conn->query($query1);
        $bool2 = $conn->query($query2);
        $conn->close();

        if (!$bool1 && !$bool2) {
            echo ("<script> console.log('Failed to create reviewer.');</script>");
            return false;
        } ;
        
        return true;
    }

    function create_CC($user_ID, $fname, $lname, $email, $contact_number, $user_Password, $user_Profile) {
        $connConfig = new Connection();
        $conn = new mysqli($connConfig->get_servername(), $connConfig->get_username(), $connConfig->get_password(), $connConfig->get_dbname());

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $query1 = "INSERT INTO user_info (user_ID, user_FName, user_LName, user_Email, user_Mobile, user_Password, user_Profile) VALUES ('$user_ID', '$fname', '$lname', '$email', '$contact_number', '$user_Password', '$user_Profile')";
        $query2 = "INSERT INTO conference_chair (user_ID) VALUES ('$user_ID')";

        $bool1 = $conn->query($query1);
        $bool2 = $conn->query($query2);
        $conn->close();

        if (!$bool1 && !$bool2) {
            echo "<script> console.log('Failed to create conference chair.');</script>";
            return false;
        } ;
        
        return true;
        
    }    

    function list_users() {
        $connConfig = new Connection();
        $conn = new mysqli($connConfig->get_servername(), $connConfig->get_username(), $connConfig->get_password(), $connConfig->get_dbname());

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT user_ID, user_FName, user_LName, user_Email, user_Mobile, user_Password, user_Profile FROM user_info";
        $bool = $conn->query($sql);

        if ($bool->num_rows > 0) {
            $row = mysqli_fetch_all($bool, MYSQLI_ASSOC);
        }
        else {
            $row = "";
        }
        
        return $row;
    }

    function editUsers($user_ID, $user_Password, $fname, $lname, $contact_number, $email) {
        $connConfig = new Connection();
        $conn = new mysqli($connConfig->get_servername(), $connConfig->get_username(), $connConfig->get_password(), $connConfig->get_dbname());

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $query = "UPDATE user_info SET user_Password = '$user_Password', user_FName = '$fname', user_LName = '$lname', user_Mobile = '$contact_number', user_Email = '$email' WHERE user_ID = '$user_ID'";

        $bool = $conn->query($query);
        $conn->close();

        if (!$bool) {
            echo "<script> console.log('Failed to update ";
            echo $user_ID;
            echo "'s information.');</script>";
            return false;
        }
        return true;
    }

    function update($user_ID, $fname, $lname, $contact_number, $email) {
        $connConfig = new Connection();
        $conn = new mysqli($connConfig->get_servername(), $connConfig->get_username(), $connConfig->get_password(), $connConfig->get_dbname());

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $query = "UPDATE user_info SET user_FName = '$fname', user_LName = '$lname', user_Mobile = '$contact_number', user_Email = '$email' WHERE user_ID = '$user_ID'";
        
        $bool = $conn->query($query);
        $conn->close();

        if (!$bool) {
            echo "<script> console.log('Failed to update user information.');</script>";
            return false;
        }
        return true;
    }

    function change_user_Password($user_ID, $olduser_Password, $newuser_Password) {
        $connConfig = new Connection();
        $conn = new mysqli($connConfig->get_servername(), $connConfig->get_username(), $connConfig->get_password(), $connConfig->get_dbname());

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $query = "UPDATE user_info SET user_Password = '$newuser_Password' WHERE user_ID = '$user_ID'";
        
        $bool = $conn->query($query);
        $conn->close();

        if (!$bool) {
            echo "<script> console.log('Failed to change password.');</script>";
            return false;
        }
        return true;    
    }
}
?>