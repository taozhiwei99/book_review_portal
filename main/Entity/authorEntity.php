<?php 
include_once("./Connection.php");
include_once("./Entity/UserEntity.php");

class Author extends User {
    private $author_ID;
    
    # Gets ID of the author from author table using username taken from user_info table and saves to the object
    function get_ID($user_ID) {
        $connConfig = new Connection();
        $conn = new mysqli($connConfig->get_servername(), $connConfig->get_username(), $connConfig->get_password(), $connConfig->get_dbname());

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $query = "SELECT author_ID FROM author WHERE user_ID = '$user_ID'";
        
        $result = $conn ->query($query);

        if ($result->num_rows == 1) {
            $row = $result ->fetch_assoc();
            $this->author_ID = $row["author_ID"];
            return true;
        }
        
        return false;
    }

    # Returns the saved author_ID of the object
    function get_authorID() {
        return $this->author_ID;
    }

    # Creates a new notification when CC accepts/rejects the author's paper
    function notifyAuthor($paperID) {
        $connConfig = new Connection();
        $conn = new mysqli($connConfig->get_servername(), $connConfig->get_username(), $connConfig->get_password(), $connConfig->get_dbname());

        $query = "INSERT INTO notification (paper_ID, status) VALUES ('$paperID', 'new')";

        $bool = $conn->query($query);
        $conn->close();

        if (!$bool) {
            echo ("<script> console.log('Failed to update.');</script>");
            return false;
        }
        return true;
    }

    # Gets a list of new notifications from notification table
    function getNotifications($authorID) {
        $connConfig = new Connection();
        $conn = new mysqli($connConfig->get_servername(), $connConfig->get_username(), $connConfig->get_password(), $connConfig->get_dbname());

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $query = "SELECT notification.paper_ID, notification.paper_ID, notification.status, paper.paper_Status, paper.submitted_by_author FROM notification INNER JOIN paper ON notification.paper_ID = paper.paper_ID WHERE paper.submitted_by_author = '$authorID' AND notification.status = 'new'";
        
        $result = $conn ->query($query);
        $conn->close();
        
        if ($result ->num_rows > 0) {
            $row = mysqli_fetch_all($result, MYSQLI_ASSOC);
        }
        else {
            $row = "";
        }

        return $row;
    }

    # When author clicks on close button on a notification, it will update that notification's status to old
    function notificationRead($paperID) {
        $connConfig = new Connection();
        $conn = new mysqli($connConfig->get_servername(), $connConfig->get_username(), $connConfig->get_password(), $connConfig->get_dbname());

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $query = "UPDATE notification SET status = 'old' WHERE paper_ID = '$paperID'";
        
        $result = $conn->query($query);
        $conn->close();

        if (!$result) {
            return false;
        }
        return true;
    }
}


?>