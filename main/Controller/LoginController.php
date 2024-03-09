<?php
include_once("./Entity/UserEntity.php");

class LoginController {
    # Test function for PHP Unit tests
    function loginTest($username, $password) {
        $user = new User();
        $bool = $user->get_user($username, $password);

        if ($bool) {
            return true;
        }
        return false;
    }

    # If database contains such a user, redirect to appropriate page based on user profile
    function Login($username, $password) {
        $user = new User();

        $bool = $user->get_user($username, $password);

        if ($bool) {
            $_SESSION["user"] = $user;
            $_SESSION["username"] = $user->get_user_ID();
            $_SESSION["FName"] = $user->get_user_FName();
            $profile = $user->get_user_Profile();

            if ($profile == "System Admin") {
                header("Location:Admin.php");
            }
            else if ($profile == "Conference Chair") {
                header("Location:ConferenceChair.php");
            }
            else if ($profile == "Reviewer") {
                header("Location:Reviewer.php");
            }
            else if ($profile == "Author") {
                header("Location:Author.php");
            }
        }
        else {
            return false;
        }

        return true;
    }
}
?>
