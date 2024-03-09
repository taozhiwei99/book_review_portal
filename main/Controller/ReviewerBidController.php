<?php 

include_once("./Entity/reviewer_bidEntity.php");

class reviewerBidController {
    # Creating a new bid logic handler
    function createBid($reviewerID, $paperID) {
        $bids = new Reviewer_bid();
        $bool = $bids->create_bid($reviewerID, $paperID);

        if ($bool) {
            return true;
        }
        
        return false;
    }

    # Gets a list of all the bids made by a specific reviewer
    function getBids($reviewerID) {
        $bids = new Reviewer_bid();
        $row = $bids->get_bids($reviewerID);

        if ($row == false) {
            return false;
        }

        return $row;
    }

}


?>