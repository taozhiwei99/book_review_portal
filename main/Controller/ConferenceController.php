<?php 
    include_once("./Entity/ccEntity.php");
    session_start();
    
class ConferenceController {
    # Gets reviewer_ID from reviewer table using username in user_info table
    function get_ID($username) {
        $CC = new ConferenceChair();
        $bool = $CC->get_ID($username);

        if ($bool) {
            $_SESSION["userID"] = $CC->get_userID();
            return true;
        }
        
        return false;
    }

}
?>

