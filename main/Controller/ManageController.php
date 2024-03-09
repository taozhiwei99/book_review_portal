<?php 
include_once("./Entity/UserEntity.php");

class ManageController {
    # Update existing user's details logic handler
    function update($username, $fname, $lname, $contact_number, $email) {
        $info = new User();
        $bool = $info->update($username, $fname, $lname, $contact_number, $email);

        if ($bool) {
            return true;
        }
        
        return false;
    }
    
    # Update existing user's password logic handler
    function change_password($username, $oldPassword, $newPassword) {
        $info = new User();
        $bool = $info->change_password($username, $oldPassword, $newPassword);

        if ($bool) {
            return true;
        }
        
        return false;
    }

}


?>