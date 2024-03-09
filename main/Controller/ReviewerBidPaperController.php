<?php 

include_once("./Entity/PaperEntity.php");

class reviewerBidPaperPaperController {
    # For reviewer to see a list of papers 
    # not yet accepted/rejected, has not failed a bid on that paper before, and not already allocated to him/her
    function get_pending_paper($reviewerID) {
        $papers = new Paper();
        $row = $papers->get_pending_paper($reviewerID);

        return $row;
    }

    # Creating a new bid logic handler
    function createBid($reviewerID, $paperID) {
        $bids = new Paper();
        $bool = $bids->create_bid($reviewerID, $paperID);

        if ($bool) {
            echo ("<script> console.log('Updated succesfully');</script>");
        }
    }

    # Gets a list of all bids that belongs to a specific reviewer
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