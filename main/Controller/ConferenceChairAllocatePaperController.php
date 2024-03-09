<?php 

include_once("./Entity/reviewer_bidEntity.php");
include_once("./Entity/reviewerEntity.php");

class conferenceAllocatePaperController {
    # Check if reviewer can be allocated more work
    function validateWorkload($reviewerID) {
        $currentWorkload = self::getCurrentWorkload($reviewerID);
        $maximumWorkload = self::getMaximumWorkload($reviewerID);

        echo ("<script> console.log('Current workload: $currentWorkload');</script>");
        echo ("<script> console.log('Maximum workload: $maximumWorkload');</script>");
        if ((((int)$maximumWorkload - (int)$currentWorkload) > 0)) {
            return true;
        }
        else {
            return false;
        }
    }

    # Getting the reviewer's current workload
    function getCurrentWorkload($reviewerID) {
        $reviewer = new Reviewer();
        $reviewer->getCurrentWorkload($reviewerID);
        $currentWorkload = $reviewer->get_userCurrentWorkload();

        return $currentWorkload;
    }

    # Getting the reviewer's maximum workload
    function getMaximumWorkload($reviewerID) {
        $reviewer = new Reviewer();
        $reviewer->get_maxWorkload($reviewerID);
        $maximumWorkload = $reviewer->get_workload();

        return $maximumWorkload;
    }

    # Manually allocate the paper to the specific reviewer individually
    function manualAllocation($paperID, $reviewerID) {
        if (self::validateWorkload($reviewerID)) {
            $review = new Reviewer_bid();
            $bool = $review->manualAllocation($paperID, $reviewerID);
            if ($bool) {
                return true;
            }
            echo ("<script> console.log('Failed to allocate.');</script>");
            return false;
        }
        return false;
    }

    # Manually reject the bid of a reviewer on a specific paper
    function rejectAllocate($paperID, $reviewerID) {
        $review = new Reviewer_bid();
        $bool = $review->rejectAllocate($paperID, $reviewerID);

        if ($bool) {
            return true;
        }
        else {
            echo ("<script> console.log('Failed to reject.');</script>");
            return false;
        }
    }
}


?>