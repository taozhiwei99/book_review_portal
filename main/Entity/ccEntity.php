<?php
include_once("./Connection.php");
include_once("./Entity/UserEntity.php");

class ConferenceChair extends User {
    private $conference_chair_ID;
    
    # Gets the ID of a conference chair from conference_chair table using username taken from user_info table
    # and saves it to the object
    function get_ID($user_ID) {
        $connConfig = new Connection();
        $conn = new mysqli($connConfig->get_servername(), $connConfig->get_username(), $connConfig->get_password(), $connConfig->get_dbname());

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $query = "SELECT conference_chair_ID FROM conference_chair WHERE user_ID = '$user_ID'";
        
        $result = $conn->query($query);
        $conn->close();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();

            $this->conference_chair_ID = $row["conference_chair_ID"];
            return true;
        }
        
        return false;
    }

    # Gets the object's saved userID
    function get_userID() {
        return $this->conference_chair_ID;
    }
}

?>