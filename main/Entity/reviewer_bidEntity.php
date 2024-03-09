<?php
include_once("./Connection.php");

class Reviewer_bid {
    private $reviewer_ID;
    private $paper_ID;
    private $bid_Status;

    # Retrieve a list of bids belonging to the specific reviewer
    function get_bids($reviewerID) {
        $connConfig = new Connection();
        $conn = new mysqli($connConfig->get_servername(), $connConfig->get_username(), $connConfig->get_password(), $connConfig->get_dbname());

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $query = "SELECT * FROM paper INNER JOIN reviewer_bid ON paper.paper_ID = reviewer_bid.paper_ID WHERE reviewer_bid.reviewer_ID = '$reviewerID'";
        
        $result = $conn->query($query);
        $conn->close();

        if ($result->num_rows > 0) {
            $row= mysqli_fetch_all($result, MYSQLI_ASSOC);
			return $row;
        }
        else {
            $row = "";
        }

        return false;
    }

    # Creates a new bid when the reviewer bids on a piece of paper he/she wants to give reviewes for
    function create_bid($reviewerID, $paperID) {
        $connConfig = new Connection();
        $conn = new mysqli($connConfig->get_servername(), $connConfig->get_username(), $connConfig->get_password(), $connConfig->get_dbname());

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $query = "INSERT INTO reviewer_bid (reviewer_ID, paper_ID) VALUES ('$reviewerID', '$paperID')";
        
        $bool = $conn->query($query);
        $conn->close();

        if (!$bool) {
            echo "<script> console.log('Failed to create bid.');</script>";
            return false;
        }
        return true;
    }

    # Allocates a paper to a reviewer by updating his/her bid's status in the reviewer_bid table to success
    function manualAllocation($paperID, $reviewerID) {
        $connConfig = new Connection();
        $conn = new mysqli($connConfig->get_servername(), $connConfig->get_username(), $connConfig->get_password(), $connConfig->get_dbname());

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $query = "UPDATE reviewer_bid SET bid_Status = 'success' WHERE paper_ID = '$paperID' AND reviewer_ID = '$reviewerID'";
        
        $bool = $conn->query($query);
        $conn->close();

        if (!$bool) {
            echo "<script> console.log('Failed to allocate paper ";
            echo $paperID;
            echo " to reviewer ";
            echo $reviewerID;
            echo ".');</script>";
            return false;
        }
        return true;
    }

    # Rejects a reviewer's bid by updating his/her bid's status in the reviewer_bid table to fail
    function rejectAllocate($paperID, $reviewerID) {
        $connConfig = new Connection();
        $conn = new mysqli($connConfig->get_servername(), $connConfig->get_username(), $connConfig->get_password(), $connConfig->get_dbname());

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $query = "UPDATE reviewer_bid SET bid_Status = 'fail' WHERE paper_ID = '$paperID' AND reviewer_ID = '$reviewerID'";
        
        $bool = $conn->query($query);
        $conn->close();
        
        if (!$bool) {
            echo "<script> console.log('Failed to reject bid.');</script>";
            return false;
        }
        return true;
    }
}

?>