<?php 
    include_once("./Entity/ReviewerEntity.php");
    session_start();
    
class ReviewerController {
    # Gets user's maximum preferred workload
    function getReviewerWorkload($username) {
        $reviewer = new Reviewer();
        $bool = $reviewer->get_maxWorkload($username);

        if ($bool) {
            $_SESSION["workload"] = $reviewer->get_workload();
            $reviewer->getCurrentWorkload($_SESSION["userID"]);
            $_SESSION["currentWorkload"] = $reviewer->get_userCurrentWorkload();
            
            return true;
        }

        return false;
    }

    # Gets reviewer_ID from reviewer table using username in user_info table
    function get_ID($username) {
        $reviewer = new Reviewer();
        $bool = $reviewer->get_ID($username);

        if ($bool) {
            $_SESSION["userID"] = $reviewer->get_userID();

            return true;
        }

        return false;
    }
    
    # Update specific reviewer's workload in reviewer table
    function updateWorkload($reviewerID, $workload) {
        if (self::invalidWorkload($reviewerID, $workload)) {
            $reviewer = new Reviewer();
            $bool = $reviewer->set_workload($reviewerID, $workload);

            if ($bool) {
                $_SESSION["workload"] = $reviewer->get_workload();
                return true;
            }
            echo ("<script> console.log('Failed to update workload.');</script>");
            return false;
        }
        else {
            return false;
        }
    }

    # Checks if user is trying to change his maximum preferred workload to a value lower than his current workload
    function invalidWorkload($reviewerID, $newWorkload) {
        if ($_SESSION["currentWorkload"] <= (int)$newWorkload) {
            return true;
        }
        else {
            return false;
        }
    }

}
?>

