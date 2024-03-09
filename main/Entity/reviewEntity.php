<?php
    include_once("./Connection.php");

    class Review{
        private $review_ID;
        private $reviewer_Rating;
        private $reviewer_Comment;
        private $reviewer_ID;
        private $paper_ID;
        private $author_Rating;
        

        # Creating a new review for a piece of paper
        function create_review($rating, $commentValue, $paperID, $reviewerID) {
            $connConfig = new Connection();
            $conn = new mysqli($connConfig->get_servername(), $connConfig->get_username(), $connConfig->get_password(), $connConfig->get_dbname());

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $query = "INSERT INTO review (reviewer_Rating, reviewer_Comment, paper_ID, reviewer_ID) VALUES ('$rating', '$commentValue', '$paperID', '$reviewerID')";
            
            $result = $conn->query($query);
            $conn->close();

            if (!$result) {
                echo ("<script> console.log('Failed to create review.');</script>");
                return false;
            }
            return true;
        }
        
        # Updates an existing review instead of creating a new review
        function update_review($rating, $commentValue, $paperID, $reviewerID) {
            $connConfig = new Connection();
            $conn = new mysqli($connConfig->get_servername(), $connConfig->get_username(), $connConfig->get_password(), $connConfig->get_dbname());

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $query = "UPDATE review SET reviewer_Rating = '$rating', reviewer_Comment = '$commentValue' WHERE paper_ID = '$paperID' AND reviewer_ID = '$reviewerID'";
            
            $result = $conn->query($query);
            $conn->close();

            if (!$result) {
                echo ("<script> console.log('Failed to update review.');</script>");
                return false;
            }
            return true;
        }

        # Gets all the currently existing reviews for a specific paper
        function getCurrentReview($paperID) {
            $connConfig = new Connection();
            $conn = new mysqli($connConfig->get_servername(), $connConfig->get_username(), $connConfig->get_password(), $connConfig->get_dbname());

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $query = "SELECT review.review_ID, review.paper_ID, review.reviewer_Rating, review.reviewer_Comment, review.reviewer_ID, comments.comment_Content FROM review LEFT JOIN comments on review.review_ID = comments.review_ID where review.paper_ID = '$paperID' ";

            $result = $conn->query($query);
            $conn->close();

            if ($result->num_rows == 0) {
                echo ("<script> console.log('No reviews exists.');</script>");
                $row = "";
            }

            else {
                $row = mysqli_fetch_all($result, MYSQLI_ASSOC);
            }

            return $row;
        }

        # Counts the number of rows that exists inside review table that belongs to the reviewer for a specific paper
        # This count will allow us to check if a reviewer has already created a review for a specific paper
        function checkExistingReviews($paperID, $reviewerID) {
            $connConfig = new Connection();
            $conn = new mysqli($connConfig->get_servername(), $connConfig->get_username(), $connConfig->get_password(), $connConfig->get_dbname());

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $query = "SELECT COUNT(*) as existingReviews FROM review WHERE paper_ID = '$paperID' AND reviewer_ID = '$reviewerID'";
            
            $result = $conn->query($query);
            $conn->close();

            if ($result->num_rows == 0) {
                return false;
            }
            else {
                $row = $result->fetch_assoc();
                return $row["existingReviews"];
            }
        }

        # For the author to give a rating of a reviewer's review
        function updateRating($reviewID, $rating) {
            $connConfig = new Connection();
            $conn = new mysqli($connConfig->get_servername(), $connConfig->get_username(), $connConfig->get_password(), $connConfig->get_dbname());

            $query = "UPDATE review SET author_Rating = '$rating' WHERE review_ID = '$reviewID'";
            
            $result = $conn->query($query);
            $conn->close();

            if (!$result) {
                echo ("<script> console.log('Failed to update.');</script>");
                return false;
            }
            return true;
        }
        
        # Creating additional comments
        function createComment($commentValue, $reviewID) {
            $connConfig = new Connection();
            $conn = new mysqli($connConfig->get_servername(), $connConfig->get_username(), $connConfig->get_password(), $connConfig->get_dbname());

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $query = "INSERT INTO comments (comment_Content, review_ID) VALUES ('$commentValue', '$reviewID')";
            
            $result = $conn->query($query);
            $conn->close();

            if (!$result) {
                echo ("<script> console.log('Failed to create comment.');</script>");
                return false;
            }
            return true;
        }

    }
?>