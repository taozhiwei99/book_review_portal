<?php
  session_start();

  function createUser() {
    include_once('Controller/AdminCreateUserController.php');
    $createUser = new AdminController();
    $bool = $createUser->create_user();

    if ($bool) {
      echo "<script> alert('User created successfully.');</script>";
    }
    else {
      echo "<script> alert('Failed to create user.');</script>";
    }
  }

  function editUser() {
    include_once('Controller/AdminListUserController.php');
    $editUser = new ViewAndEditUserController();
    $editUser->editUsers($_POST["username"], $_POST["password"], $_POST["fname"], $_POST["lname"], $_POST["contactnumber"], $_POST["email"]);

    if ($bool) {
      echo "<script>alert('Successfully updated ";
      echo $_POST["username"];
      echo "'s information.')</script>";
    }
    else {
      echo "<script>alert('Failed to update ";
      echo $_POST["username"];
      echo "'s information.')</script>";
    }
  }

  function updateInfo() {
    include_once('Controller/ManageController.php');
    $manage = new ManageController();
    $bool = $manage->update($_SESSION["username"], $_POST["fname"], $_POST["lname"], $_POST["contactnumber"], $_POST["email"]);

    if ($bool) {
      echo "<script>alert('Successfully updated user information.')</script>";
    }
    else {
      echo "<script> alert('Failed to update user information.');</script>";
    }
  }

  function changePassword() {
    include_once('Controller/ManageController.php');
    $manage = new ManageController();
    $bool = $manage->change_password($_SESSION["username"], $_POST["old_confirmpassword"], $_POST["new_confirmpassword"]);

    if ($bool) {
      echo ("<script>alert('Successfully changed password.')</script>");
    }
    else {
      echo ("<script> alert('Failed to change password.');</script>");
    }
  }

  function showEditForm() {
    echo '
    <div id="editUserForm" class="modal">
      <div class="popupformcontainer">
        <span onclick="closeForm()" class="close" title="Close Modal">&times;</span>
        <br><br>
        <form action="" method="post">
          <div class="formcontainerrows">
            <div class="div25">
              <label id="usernamelabel">Editing user: </label>
            </div>
            <div class="div75">
              <p style="padding: 7px"> ';
      echo $_POST['edit'];
      echo'</p>
            <input type="hidden" name="username" value='; echo $_POST['edit']; echo '>
            </div>
          </div>

          <div class="formcontainerrows">
            <div class="div25">
              <label id="passwordlabel">Password : </label>
            </div>
            <div class="div75">
              <input type="password" id="edit_password1" class="createuserinput" name="password" onchange="EditCheckPassword()" required><br><br>
            </div>
          </div>

          <div class="formcontainerrows">
            <div class="div25">
              <label id="confirmpasswordlabel">Confirm Password : </label>
            </div>
            <div class="div75">
              <input type="password" id="edit_password2" class="createuserinput" name="confirmpassword" onkeyup="EditCheckPassword()" required><br><br>
            </div>
          </div>

          <div class="formcontainerrows">
            <div class="div25">
              <label id="namelabel">First Name : </label>
            </div>
            <div class="div75">
              <input type="text" class="edituserinput" name="fname" required><br><br>
            </div>
          </div>

          <div class="formcontainerrows">
            <div class="div25">
              <label id="namelabel">Last Name : </label>
            </div>
            <div class="div75">
              <input type="text" class="edituserinput" name="lname" required><br><br>
            </div>
          </div>

          <div class="formcontainerrows">
            <div class="div25">
              <label id="contactnumberlabel">Contact Number : </label>
            </div>
            <div class="div75">
              <input type="text" class="edituserinput" name="contactnumber" required><br><br>
            </div>
          </div>

          <div class="formcontainerrows">
            <div class="div25">
              <label id="emaillabel">Email : </label>
            </div>
            <div class="div75">
              <input type="email" class="edituserinput" name="email" required><br><br>
            </div>
          </div>

          <div class="formcontainerrows">
            <input type="submit" name="editUser_submit" value="Submit">
          </div>

        </form>
      </div>
    </div>

    <script type=text/javascript>
      document.getElementById("editUserForm").style.display="block";

      function closeForm() {
        document.getElementById("editUserForm").style.display="none";
      }
    </script>
    ';
  }

  if (isset($_POST['edit'])) {
    showEditForm();
  }

  if (isset($_POST["CreateUser_submit"])) {
    createUser();
  }

  if (isset($_POST['editUser_submit'])) {
    editUser();
  }

  if (isset($_POST['changeDetails_submit'])) {
    updateInfo();
  }

  if (isset($_POST['updatePassword_submit'])) {
    changePassword();
  }
?>

<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">
<title>System Admin</title>

<head>
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.2/css/all.css'>
  <link rel="stylesheet" href="style/general.css">
</head>

<body>
  <!-- Navigation bar -->
  <div id="navbar-animmenu">
    <ul class="show-dropdown main-navbar">
      <div class="hori-selector">
        <div class="left"></div>
        <div class="right"></div>
      </div>
      <li id="userTab" class="active">
        <a href="javascript:openSegment('user');"><i class="fas fa-users"></i>Users</a>
      </li>
      <li id="createuserTab">
        <a href="javascript:openSegment('createuser');"><i class="fas fa-user-plus"></i>Create User</a>
      </li>
      <li id="manageTab">
        <a href="javascript:openSegment('manage');"><i class="fas fa-sliders-h"></i>Manage</a>
      </li>
      <div class="welcome">Welcome, <?php echo $_SESSION["FName"]; ?>!</div>
    </ul>
  </div>
 
  <a href="LogOut.php">
    <button class="logoutbutton" id="logoutbutton1">Log out</button>
  </a>
  <br> <br>
  <!-- VIEW USER -->
  <div id="user" class="tabcontent" style="display:block">
    <br><br><br>

    <input type="text" id="searchUserList" onkeyup="searchUserList()" class="searchbar" placeholder="Search...">

    <br><br>
    <form class="" method="post">
      <table id="userlist">
        <thead>
          <th>Username</th>
          <th>User Profile</th>
          <th>Name</th>
          <th>Email</th>
          <th>Contact Number</th>
          <th>Function</th>
        </thead>
        <tbody>
          <?php
          function viewUser() {
            include_once("Controller/AdminListUserController.php");
          }
          viewUser();
          $listUser = new ViewAndEditUserController();
          
          $fetchData = $listUser->list_users();

          if (is_array($fetchData)) {
            foreach ($fetchData as $row) {
          ?>
              <tr>
                <td><?php echo $row['user_ID']; ?> </td>
                <td><?php echo $row['user_Profile']; ?> </td>
                <td><?php echo $row['user_FName']; ?> <?php echo $row['user_LName']; ?></td>
                <td><?php echo $row['user_Email']; ?> </td>
                <td><?php echo $row['user_Mobile']; ?> </td>
                <td>
                  <button type="submit" name="edit" value=<?php echo $row['user_ID']; ?> >Edit</button>
                </td>
              <tr>

              <?php
            }
          } else {
              ?>
              <tr>
                <td colspan="5">
                  <?php echo $fetchData; ?>
                </td>
              </tr>
            <?php } ?>
        </tbody>
      </table>
    </form>

  </div>

  <!-- CREATE USER -->
  <div id="createuser" class="tabcontent">
    <br><br><br>
    <div class="formcontainer">
      <form action="" method="post">
        <div class="formcontainerrows">
          <div class="div25">
            <label>User Profile Type : </label>
          </div>
          <div class="div75" style="margin-bottom: 13px;">
            <select name="userprofile" id="userprofile">
              <option value="Author"> Author </option>
              <option value="Reviewer"> Reviewer </option>
              <option value="Conference Chair"> Conference Chair </option>
            </select>
          </div>
        </div>

        <div class="formcontainerrows">
          <div class="div25">
            <label id="usernamelabel">Username : </label>
          </div>
          <div class="div75">
            <input type="text" class="createuserinput" name="username" required><br><br>
          </div>
        </div>

        <div class="formcontainerrows">
          <div class="div25">
            <label id="passwordlabel">Password : </label>
          </div>
          <div class="div75">
            <input type="password" id="create_password1" class="createuserinput" name="password" onchange="checkPassword()" required><br><br>
          </div>
        </div>

        <div class="formcontainerrows">
          <div class="div25">
            <label id="confirmpasswordlabel">Confirm Password : </label>
          </div>
          <div class="div75">
            <input type="password" id="create_password2" class="createuserinput" name="confirmpassword" onkeyup="checkPassword()" required><br><br>
          </div>
        </div>

        <div class="formcontainerrows">
          <div class="div25">
            <label id="namelabel">First Name : </label>
          </div>
          <div class="div75">
            <input type="text" class="createuserinput" name="fname" required><br><br>
          </div>
        </div>

        <div class="formcontainerrows">
          <div class="div25">
            <label id="namelabel">Last Name : </label>
          </div>
          <div class="div75">
            <input type="text" class="createuserinput" name="lname" required><br><br>
          </div>
        </div>

        <div class="formcontainerrows">
          <div class="div25">
            <label id="contactnumberlabel">Contact Number : </label>
          </div>
          <div class="div75">
            <input type="text" class="createuserinput" name="contactnumber" required><br><br>
          </div>
        </div>

        <div class="formcontainerrows">
          <div class="div25">
            <label id="emaillabel">Email : </label>
          </div>
          <div class="div75">
            <input type="email" class="createuserinput" name="email" required><br><br>
          </div>
        </div>

        <div class="formcontainerrows">
          <button type="submit" name="CreateUser_submit" value="Submit"> Submit </button>
        </div>

      </form>
    </div>
  </div>

  <!-- Manage Info -->
  <div id="manage" class="tabcontent">
    <!--update password -->
    <h3>Change password</h3>
    <button class="editbutton" onclick="document.getElementById('updateUserPassword').style.display='block'">Change Password</button>

    <div id="updateUserPassword" class="modal">
      <div class="popupformcontainer">
        <span onclick="document.getElementById('updateUserPassword').style.display='none'" class="close" title="Close Modal">&times;</span>
        <br><br>
        <form action="" method="post">
          <div class="formcontainerrows">
            <div class="div25">
              <label id="usernamelabel">Username : </label>
            </div>
            <div class="div75">
              <input type='text' class='edituserinput' name='username' value='<?php echo $_SESSION["username"]; ?>' disabled><br><br>
            </div>
          </div>

          <div class="formcontainerrows">
            <div class="div25">
              <label id="oldpasswordlabel">Old Password : </label>
            </div>
            <div class="div75">
              <input type="password" id="update_password1" class="createuserinput" name="old_password" onchange="UpdateCheckOldPassword()" required><br><br>
            </div>
          </div>

          <div class="formcontainerrows">
            <div class="div25">
              <label id="confirmoldpasswordlabel">Confirm Old Password : </label>
            </div>
            <div class="div75">
              <input type="password" id="update_password2" class="createuserinput" name="old_confirmpassword" onkeyup="UpdateCheckOldPassword()" required><br><br>
            </div>
          </div>

          <div class="formcontainerrows">
            <div class="div25">
              <label id="newpasswordlabel">New Password : </label>
            </div>
            <div class="div75">
              <input type="password" id="update_password3" class="createuserinput" name="new_password" onkeyup="UpdateCheckNewPassword()" required><br><br>
            </div>
          </div>

          <div class="formcontainerrows">
            <div class="div25">
              <label id="confirmnewpasswordlabel">Confirm New Password : </label>
            </div>
            <div class="div75">
              <input type="password" id="update_password4" class="createuserinput" name="new_confirmpassword" onkeyup="UpdateCheckNewPassword()" required><br><br>
            </div>
          </div>

          <div class="formcontainerrows">
            <input type="submit" name="updatePassword_submit" value="Submit">
          </div>

        </form>
      </div>
    </div>
    
    <br><br>

    <!-- Update User Info -->
    <h3>Edit user info</h3>
    <button class="editbutton" onclick="document.getElementById('updateUserInfo').style.display='block'">Change Details</button>
    <div id="updateUserInfo" class="modal">
      <div class="popupformcontainer">
        <span onclick="document.getElementById('updateUserInfo').style.display='none'" class="close" title="Close Modal">&times;</span>
        <br><br>
        <form action="" method="post">
          <div class="formcontainerrows">
            <div class="div25">
              <label id="usernamelabel">Username : </label>
            </div>
            <div class="div75">
              <input type='text' class='edituserinput' name='username' value='<?php echo $_SESSION["username"]; ?>' disabled><br><br>
            </div>
          </div>

          <div class="formcontainerrows">
            <div class="div25">
              <label id="namelabel">First Name : </label>
            </div>
            <div class="div75">
              <input type="text" class="edituserinput" name="fname" required><br><br>
            </div>
          </div>

          <div class="formcontainerrows">
            <div class="div25">
              <label id="namelabel">Last Name : </label>
            </div>
            <div class="div75">
              <input type="text" class="edituserinput" name="lname" required><br><br>
            </div>
          </div>

          <div class="formcontainerrows">
            <div class="div25">
              <label id="contactnumberlabel">Contact Number : </label>
            </div>
            <div class="div75">
              <input type="text" class="edituserinput" name="contactnumber" required><br><br>
            </div>
          </div>

          <div class="formcontainerrows">
            <div class="div25">
              <label id="emaillabel">Email : </label>
            </div>
            <div class="div75">
              <input type="email" class="edituserinput" name="email" required><br><br>
            </div>
          </div>

          <div class="formcontainerrows">
            <input type="submit" name="changeDetails_submit" value="Submit">
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src='https://code.jquery.com/jquery-3.4.1.min.js'></script>
  <script src="js/general.js"></script>
  <script src="js/confirmPassword.js"></script>
  <script>
    function searchUserList() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("searchUserList");
    filter = input.value.toUpperCase();
    table = document.getElementById("userlist");
    tr = table.getElementsByTagName("tr");
    for (i = 1; i < tr.length; i++) {
      td = tr[i];
      if (td) {
        txtValue = td.textContent || td.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
          tr[i].style.display = "";
        } else {
          tr[i].style.display = "none";
        }
      }      
    }
  }
  </script>
</body>

</html>