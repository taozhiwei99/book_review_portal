<?php 

include_once("./Entity/PaperEntity.php");
include_once("./Entity/reviewEntity.php");

class authorPaperList {
    # Gets a list of papers that belongs to a specific author
    function author_getListPaper($username) {
        $data = new Paper();
        $row = $data->author_getListPaper($username);
        return $row;
    }

    # Updates an existing paper's details
    function author_updatePaperDetails($paperID, $paperName, $paperContent) {
        $data = new Paper();
        $bool = $data->author_updatePaperDetails($paperID, $paperName, $paperContent);

        if ($bool) {
            return true;
        }
        else {
            return false;
        }
    }

    # Gets a list of reviews that belongs to a paper
    function getCurrentReview($paperID) {
        $review = new Review();
        return $review->getCurrentReview($paperID);
    }

    # Lets the author give a rating for an existing review
    function updateRating($reviewID, $rating) {
        $review = new Review();
        $bool = $review->updateRating($reviewID, $rating);
        
        if ($bool) {
            return true;
        }
        else {
            return false;
        }
    }
}

?>