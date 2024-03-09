<?php
    include_once("./Entity/UserEntity.php");

    class ViewAndEditUserController {
        # Gets a list of all existing users
        function list_users() {
            $show_users = new User();
            $row = $show_users->list_users();

            return $row;
        }

        # Edit specific user logic handler
        function editUsers($username, $password, $fname, $lname, $contact_number, $email) {
            $info = new User();
            $bool = $info->editUsers($username, $password, $fname, $lname, $contact_number, $email);

            if ($bool) {
                return true;
            }
            
            return false;
        }
    }

    
?>