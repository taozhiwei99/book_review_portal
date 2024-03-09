<?php 

include_once("./Entity/reviewEntity.php");

class ReviewerReviewPaperController {
    # Creates a new review if reviewer hasn't made a review on a specific paper yet
    # If reviewer has already made a review on a specific paper, update that existing review instead
    function create_review($rating, $commentValue, $paperID, $reviewerID) {
        $review = new Review();
        if (self::checkExistingReviews($paperID, $reviewerID)) {
            $bool = $review->update_review($rating, $commentValue, $paperID, $reviewerID);
            if ($bool != null) {
                return "updateSuccess";
            }
            else {
                return "updateFail";
            }
        }
        else {
            $bool = $review->create_review($rating, $commentValue, $paperID, $reviewerID);
            if ($bool != null) {
                return "createSuccess";
            }
            else {
                return "createFail";
            }
        }
    }

    # Gets and then checks the count of reviews made by a specific reviewer for a specific paper
    function checkExistingReviews($paperID, $reviewerID) {
        $review = new Review();
        $bool = $review->checkExistingReviews($paperID, $reviewerID);
    
        if ($bool == '1') {
            return true;
        }

        return false;
    }

    # Gets a list of existing reviews for a specific paper
    function getCurrentReview($paperID) {
        $review = new Review();
        $result = $review->getCurrentReview($paperID);

        if ($result == "") {
            return false;
        }
        else {
            return $result;
        }
    }

    # Creating a new comment for a specific review on a specific paper
    function createComment($commentValue, $reviewID) {
        $review = new Review();
        $bool = $review->createComment($commentValue, $reviewID);

        if ($bool != null) {
            return true;
        }
        return false;
    }
}


?>