<?php 

include_once("./Entity/PaperEntity.php");
include_once("./Entity/authorEntity.php");

class conferencePendingPaperController {
    # Gets a list of of all existing papers
    function getPapers() {
        $data = new Paper();
        $row = $data->getPapers();

        return $row;
    }

    # Gets a list of papers that have bids on them, but not allocated to a reviewer yet
    function cc_get_pending_paper() {
        $data = new Paper();
        $row = $data->get_pending_paper_with_reviewer_bids();

        return $row;
    }

    # Gets a list of papers that have already been allocated, and reviewed by reviewers
    function getARpapers() {
        $paper = new Paper();
        $row = $paper->get_acceptedOrRejectedPaper();

        return $row;
    }

    # Accept or Reject a specific paper logic handler
    function acceptRejectPaper($paperID, $decision, $conferenceChairID) {
        $paper = new Paper();
        $bool = $paper->acceptRejectPaper($paperID, $decision, $conferenceChairID);

        if ($bool) {
            self::notifyAuthor($paperID);
            return true;
        }

        return false;
    }

    # Creates a new notification when CC accepts/rejects the author's paper
    function notifyAuthor($paperID) {
        $author = new Author();
        $bool = $author->notifyAuthor($paperID);

        if ($bool) {
            echo ("<script> console.log('Author notified.');</script>");
            return true;
        }
        else {
            echo ("<script> console.log('Failed to notify author.');</script>");
            return false;
        }
    }
}


?>