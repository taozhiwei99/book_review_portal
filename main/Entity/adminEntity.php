<?php
include_once("./Connection.php");
include_once("./Entity/UserEntity.php");

class system_admin extends User {
	private $Admin_ID;
	
	# Gets the ID of a system admin from system_admin table using username taken from user_info table
    # and saves it to the object
	function get_ID($user_ID)
	{
		$connConfig = new Connection();
        $conn = new mysqli($connConfig->get_servername(), $connConfig->get_username(), $connConfig->get_password(), $connConfig->get_dbname());

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $query = "SELECT Admin_ID FROM system_admin WHERE user_ID = '$user_ID'";
        
        $result = $conn->query($query);
        $conn->close();

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();

            $this->Admin_ID = $row["Admin_ID"];
            return true;
        }
        
        return false;
	}

	# Gets the object's saved userID
	function getAdmin_ID()
	{
		return $this->Admin_ID;
	}
}

?>