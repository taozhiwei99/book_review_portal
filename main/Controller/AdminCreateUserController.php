<?php
    include_once("./Entity/UserEntity.php");
    

    class AdminController {
        # Accesses the appropriate function for each unique user based on user profile
        function create_user() {
            $useraccount = new User();
    
            if ($_POST["userprofile"] == "Author") {
                $bool = $useraccount->create_author($_POST["username"], $_POST["password"], $_POST["userprofile"], $_POST["fname"], $_POST["lname"], $_POST["contactnumber"], $_POST["email"]);
                
                if ($bool) {
                    return true;
                }
                
                return false;
            } 
            
            else if ($_POST["userprofile"] == "Reviewer") {
                $bool = $useraccount->create_reviewer($_POST["username"], $_POST["password"], $_POST["userprofile"], $_POST["fname"], $_POST["lname"], $_POST["contactnumber"], $_POST["email"]);

                if ($bool) {
                    return true;
                }
                
                return false;
            } 
            
            else if ($_POST["userprofile"] == "Conference Chair") {
                $bool = $useraccount->create_CC($_POST["username"], $_POST["password"], $_POST["userprofile"], $_POST["fname"], $_POST["lname"], $_POST["contactnumber"], $_POST["email"]);
                
                if ($bool) {
                    return true;
                }
                
                return false;
            }
        }
    }

    
?>