<?php
    include_once("./Entity/authorEntity.php");
    session_start();

class AuthorController {
    # Gets the ID of the author from author table using username taken from user_info table
    function get_ID($username) {
        $author = new Author();
        $bool = $author->get_ID($username);

        if ($bool) {
            $_SESSION["author_ID"] = $author->get_authorID();
            return true;
        }
        
        return false;
    }

    # Gets a list of new notifications from notification table
    function notifications($authorID) {
        $author = new Author();
        $data = $author->getNotifications($authorID);
        if ($data != null) {
            return $data;
        }
        return false;
    }

    # When author clicks on close button on a notification, it will update that notification's status to old
    function notificationRead($paperID) {
        $author = new Author();
        $bool = $author->notificationRead($paperID);

        if ($bool != null) {
            return true;
        }
        return false;
    }
}
?>