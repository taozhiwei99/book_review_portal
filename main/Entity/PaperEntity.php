<?php
    include_once("./Connection.php");

    class Paper {
        private $paper_ID;
        private $paper_Name;
        private $paper_Content;
        private $paper_Status;
        private $submitted_by_author;
        private $conference_chair_ID;
    
    # for author to submit a new piece of paper
    function create_paper($paperName, $paperContent, $authorID, $co_Author) {
        $connConfig = new Connection();
        $conn = new mysqli($connConfig->get_servername(),$connConfig->get_username(), $connConfig->get_password(), $connConfig->get_dbname());

        $query1 = "INSERT INTO paper (paper_Name, paper_Content, submitted_by_author) VALUES ('$paperName', '$paperContent', $authorID)";
        $query2 = "INSERT INTO author_has_paper (paper_ID, author_ID) SELECT paper_ID, submitted_by_author FROM paper ORDER BY paper_ID DESC LIMIT 1";
        $query3 = "";
        if ($co_Author != ''){
            $query3 = "INSERT INTO author_has_paper(paper_ID, author_ID) select paper_ID, $co_Author from paper ORDER BY paper_ID DESC LIMIT 1";
        }
        if ($conn->query($query1) === TRUE && $conn->query($query2) === TRUE) {
            if ($query3 != "") {
                if($conn->query($query3) == TRUE) {
                    return true;
                }
                return false;
            }
            return true;
        }
        return false;
    }

    # For reviewer to see a list of papers not yet accepted/rejected, has not failed a bid on, and not already allocated to him/her
    # paper_ID, paper_Name, paper_Content is returned
    function get_pending_paper($reviewerID) {
        $connConfig = new Connection();
        $conn = new mysqli($connConfig->get_servername(), $connConfig->get_username(), $connConfig->get_password(), $connConfig->get_dbname());

        $sql = "SELECT paper_ID, paper_Name, paper_Content, paper_Status FROM paper WHERE paper_ID NOT IN 
                (SELECT paper_ID FROM 
                    (SELECT paper.paper_ID, reviewer_bid.bid_Status, reviewer_bid.reviewer_ID FROM paper LEFT JOIN reviewer_bid ON paper.paper_ID = reviewer_bid.paper_ID WHERE paper.paper_Status = 'pending' OR reviewer_bid.paper_ID IS NULL) 
                    AS a 
                WHERE (a.reviewer_ID = '$reviewerID')) 
            AND paper_Status = 'pending'";

        $result = $conn->query($sql);
        $conn->close();

        if ($result->num_rows > 0) {
            $row= mysqli_fetch_all($result, MYSQLI_ASSOC);
        }
        else {
            $row = "";
        }
        
        return $row;
    }

    # to get all a list of papers where the have not been successfully allocated to a reviewer yet
    # paper_ID, paper_Name, authorID, reviewerID is returned
    function get_pending_paper_with_reviewer_bids() {
        $connConfig = new Connection();
        $conn = new mysqli($connConfig->get_servername(), $connConfig->get_username(), $connConfig->get_password(), $connConfig->get_dbname());

        
		$query = "SELECT paper.paper_ID, paper.paper_Name, paper.paper_Content, paper.paper_Status, reviewer_bid.reviewer_ID, reviewer_bid.bid_Status from paper LEFT JOIN reviewer_bid ON paper.paper_ID = reviewer_bid.paper_ID WHERE paper.paper_ID IS NULL UNION ALL SELECT paper.paper_ID, paper.paper_Name, paper.paper_Content, paper.paper_Status, reviewer_bid.reviewer_ID, reviewer_bid.bid_Status FROM paper RIGHT JOIN reviewer_bid ON paper.paper_ID = reviewer_bid.paper_ID WHERE reviewer_bid.bid_Status = 'pending' AND paper.paper_Status = 'pending'";
        $result = $conn->query($query);
        $conn->close();

        if ($result->num_rows > 0) {
            $row= mysqli_fetch_all($result, MYSQLI_ASSOC);
			return $row;
        }
    }

    # for the author to see a list of papers that have been accepted by the CC after a review
    # paper_ID, paper_Name, paper_Status, user_ID is returned
    function get_acceptedOrRejectedPaper() {
        $connConfig = new Connection();
        $conn = new mysqli($connConfig->get_servername(), $connConfig->get_username(), $connConfig->get_password(), $connConfig->get_dbname());

        
		$query = "SELECT paper.submitted_by_author, paper.paper_ID, paper.paper_Name, paper.paper_Content, review.reviewer_ID, review.reviewer_Rating, review.reviewer_Comment, comments.comment_Content from ((paper LEFT JOIN review ON paper.paper_ID = review.paper_ID) LEFT JOIN comments ON review.review_ID = comments.review_ID) WHERE review.reviewer_Rating IS NOT NULL AND paper.paper_Status = 'pending'";
        $result = $conn->query($query);
        $conn->close();

        if ($result->num_rows > 0) {
            $row= mysqli_fetch_all($result, MYSQLI_ASSOC);
			return $row;
        }
        return false;
    }

    # for the CC to see a list of all existing papers
    # paper_ID, paper_Name, paper_Status, user_ID is returned
    function getPapers() {
        $connConfig = new Connection();
        $conn = new mysqli($connConfig->get_servername(), $connConfig->get_username(), $connConfig->get_password(), $connConfig->get_dbname());

        
		$query = "SELECT submitted_by_author, paper_ID, paper_Name, paper_Content, paper_Status FROM paper";
        $result = $conn->query($query);
        $conn->close();

        if ($result->num_rows > 0) {
            $row= mysqli_fetch_all($result, MYSQLI_ASSOC);
			return $row;
        }
        return false;
    }

    # for CC to update a paper's status with his decision based on the reviews given by reviewers
    function acceptRejectPaper($paperID, $decision, $conferenceChairID) {
        $connConfig = new Connection();
        $conn = new mysqli($connConfig->get_servername(), $connConfig->get_username(), $connConfig->get_password(), $connConfig->get_dbname());

		$query = "UPDATE paper SET paper_Status = '$decision', conference_chair_ID = '$conferenceChairID' WHERE paper_ID = '$paperID'";

        $bool = $conn->query($query);
        $conn->close();

        if(!$bool) {
            return false;
        }
        return true;
    }

    # for the author to see a list of papers where he/she is the author/co-author
    # author's User_ID, paper_ID, paper_Name, paper_Content, submitted_by_author, paper_Status, conference_chair_ID is returned
    function author_getListPaper($username) {
        $connConfig = new Connection();
        $conn = new mysqli($connConfig->get_servername(), $connConfig->get_username(), $connConfig->get_password(), $connConfig->get_dbname());

        $query = "SELECT author.User_ID, paper.paper_ID, paper.paper_Name, paper.paper_Content, paper.submitted_by_author, paper.paper_Status, paper.conference_chair_ID FROM ((paper INNER JOIN author_has_paper ON paper.paper_ID = author_has_paper.paper_ID) INNER JOIN author ON author_has_paper.author_ID = author.author_ID) WHERE author.User_ID = '$username' ";
        $result = $conn->query($query);
        $conn->close();

        if ($result->num_rows > 0) {
            $row= mysqli_fetch_all($result, MYSQLI_ASSOC);
			return $row;
        }
    }
    
    # Updates details of an existing paper
    function author_updatePaperDetails($paperID, $paperName, $paperContent) {
        $connConfig = new Connection();
        $conn = new mysqli($connConfig->get_servername(), $connConfig->get_username(), $connConfig->get_password(), $connConfig->get_dbname());

        $query1 = "UPDATE paper SET paper_Name='$paperName' WHERE paper_ID='$paperID'";
        $query2 = "UPDATE paper SET paper_Content='$paperContent' WHERE paper_ID='$paperID'";


        $bool1 = $conn->query($query1);
        $bool2 = $conn->query($query2);
        $conn->close();
        
        if (!$bool1 && !$bool2) {
            echo "<script> console.log('Failed to update paper.');</script>";
            return false;
        }
        return true;
    }
}

?>