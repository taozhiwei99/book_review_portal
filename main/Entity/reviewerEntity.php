<?php
include_once("./Connection.php");
include_once("./Entity/UserEntity.php");

class Reviewer extends User {
    private $reviewer_ID;
    private $workload;
    private $currentWorkload;
    
    # Gets the ID of a reviewer from reviewer table using username taken from user_info table
    # and saves it to the object
    function get_ID($user_ID) {
        $connConfig = new Connection();
        $conn = new mysqli($connConfig->get_servername(), $connConfig->get_username(), $connConfig->get_password(), $connConfig->get_dbname());

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $query = "SELECT reviewer_ID FROM reviewer WHERE user_ID = '$user_ID'";
        
        $result = $conn->query($query);
        $conn->close();

        if ($result->num_rows == 0) {
            return false;
        }
        else if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();

            $this->reviewer_ID = $row["reviewer_ID"];
        }
        return true;
    }

    # Gets a reviewer's current workload which is determined by,
    # a count of papers allocated to him that has yet to be accepted/rejected by a CC
    function getCurrentWorkload($reviewerID) {
        $connConfig = new Connection();
        $conn = new mysqli($connConfig->get_servername(), $connConfig->get_username(), $connConfig->get_password(), $connConfig->get_dbname());

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $query = "SELECT COUNT(*) as CurrentWorkload FROM paper INNER JOIN reviewer_bid ON paper.paper_ID = reviewer_bid.paper_ID WHERE reviewer_bid.reviewer_ID = '$reviewerID' AND paper.paper_Status = 'pending' AND reviewer_bid.bid_Status = 'success'";
        
        $result = $conn->query($query);
        $conn->close();

        if ($result->num_rows == 0) {
            return false;
        }
        else {
            $row = $result->fetch_assoc();

            $this->currentWorkload = $row["CurrentWorkload"];
        }
        return true;
    }

    # Gets a reviewer's maximum preferred workload and saves it to the object
    function get_maxWorkload($reviewerID) {
        $connConfig = new Connection();
        $conn = new mysqli($connConfig->get_servername(), $connConfig->get_username(), $connConfig->get_password(), $connConfig->get_dbname());

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $query = "SELECT workload FROM reviewer WHERE reviewer_ID = '$reviewerID'";
        
        $result = $conn->query($query);
        $conn->close();

        if ($result->num_rows == 0) {
            return false;
        }
        else if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();

            $this->workload = $row["workload"];
        }
        return true;
    }
    
    # Gets the object's saved userID
    function get_userID() {
        return $this->reviewer_ID;
    }

    # Gets the object's saved userID
    function get_userCurrentWorkload() {
        return $this->currentWorkload;
    }
    
    # Gets the object's saved maximum preferred workload
    function get_workload() {
        return $this->workload;
    }

    # Update reviewer's maximum preferred workload logic handler
    function set_workload($reviewerID, $workload) {
        $connConfig = new Connection();
        $conn = new mysqli($connConfig->get_servername(), $connConfig->get_username(), $connConfig->get_password(), $connConfig->get_dbname());

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $query = "UPDATE reviewer SET workload = '$workload' WHERE reviewer_ID = '$reviewerID'";
        
        $result = $conn->query($query);
        $conn->close();

        if (!$result) {
            echo ("<script> console.log('Failed to update');</script>");
            return false;
        }

        $this->workload = $workload;
        return true;
    }
}

?>