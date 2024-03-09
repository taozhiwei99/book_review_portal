<?php 
  function getInfo() {
    include_once('Controller/ConferenceController.php');
    $cont = new ConferenceController();
    $bool = $cont->get_ID($_SESSION["username"]);

    if ($bool) {
      echo "<script> console.log('conference_chair_ID gotten successfully.');</script>";
    }
    else {
      echo "<script> console.log('Failed to get conference_chair_ID.');</script>";
    }
  }

  getInfo();

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
      echo "<script>alert('Successfully changed password.')</script>";
    }
    else {
      echo "<script> alert('Failed to change password.');</script>";
    }
  }

  function acceptRejectPaper($paperID, $decision, $conferenceChairID) {
    include_once('Controller/ConferenceChairPendingPaperController.php');
    $cont = new conferencePendingPaperController();
    $bool = $cont->acceptRejectPaper($paperID, $decision, $conferenceChairID);
    if ($bool) {
      echo "<script>alert('Paper ";
      echo $decision;
      echo " successfully.')</script>";
    }
    else {
      echo "<script>alert('Failed to ";
      echo $decision;
      echo " paper.')</script>";
    }
  }

  function manualAllocation($paperID, $reviewerID) {
    include_once('Controller/ConferenceChairAllocatePaperController.php');
    $cont = new conferenceAllocatePaperController();
    $bool = $cont->manualAllocation($paperID, $reviewerID);
    if ($bool) {
      echo "<script>alert('Allocated successfully.')</script>";
    }
    else {
      echo "<script> alert('Reviewer cannot be allocated more work.');</script>";
    }
  }

  function rejectAllocate($paperID, $reviewerID){
    include_once('Controller/ConferenceChairAllocatePaperController.php');
    $cont = new conferenceAllocatePaperController();
    $bool = $cont->rejectAllocate($paperID, $reviewerID);
    if ($bool) {
      echo "<script>alert('Rejected successfully.')</script>";
    }
    else {
      echo "<script> alert('Failed to reject.');</script>";
    }
  }

  function automaticAllocation() {
    include_once("Controller/ConferenceChairPendingPaperController.php");
    $pending_papers = new conferencePendingPaperController();
    $fetchData = $pending_papers->cc_get_pending_paper();

    if (is_array($fetchData)) {
      $final = NULL;
      foreach ($fetchData as $row) {
        include_once('Controller/ConferenceChairAllocatePaperController.php');
        $cont = new conferenceAllocatePaperController();
        $bool = $cont->manualAllocation($row['paper_ID'], $row['reviewer_ID']);
      }
      if ($final != NULL) {
        echo "<script>alert('Allocated successfully.')</script>";
      }
      else {
        echo "<script> alert('Remaining reviewers cannot be allocated more work.');</script>";
      }
    }
  }

  if (isset($_POST['changeDetails_submit'])) {
    updateInfo();
  }
  
  if (isset($_POST['updatePassword_submit'])) {
    changePassword();
  }

  if (isset($_POST['acceptPaper'])) {
    acceptRejectPaper($_POST['acceptPaper'], "accepted", $_SESSION["userID"]);
  }

  if (isset($_POST['rejectPaper'])) {
    acceptRejectPaper($_POST['rejectPaper'], "rejected", $_SESSION["userID"]);
  }

  if (isset($_POST['Allocate'])) {
    manualAllocation($_POST['Allocate'], $_POST['reviewerID']);
  }

  if (isset($_POST['rejectAllocate'])) {
    rejectAllocate($_POST['rejectAllocate'], $_POST['reviewerID']);
  }

  if (isset($_POST['automaticAllocate'])) {
    automaticAllocation();
  }
?>

<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">
<title>Conference Chair</title>

<head>
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.2/css/all.css'>
  <link rel="stylesheet" href="style/general.css">
</head>

<body>
<!-- Navigation bar -->
<div id="navbar-animmenu">
    <ul class="show-dropdown main-navbar">
        <div class="hori-selector"><div class="left"></div><div class="right"></div></div>
        <li id="papersTab" class="active">
            <a href="javascript:openSegment('papers');"><i class="far fa-address-book"></i>Papers</a>
        </li>
        <li id="allocatePapersTab">
            <a href="javascript:openSegment('allocatePapers');"><i class="fas fa-scroll"></i>Allocate papers</a>
        </li>
        <li id="accept_reject_paperTab">
            <a href="javascript:openSegment('accept_reject_paper');"><i class="far fa-address-book"></i>Accept/Reject Paper</a>
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

<div id="papers" class="tabcontent" style="display:block">
  <br><br><br><br>

  <input type="text" id="paperTableSearch" onkeyup="paperTableSearch()" class="searchbar" placeholder="Search...">
  
  <br><br>

  <table id="paperTable">
    <thead">
      <th>Author</th>
      <th>Paper Name</th>
      <th>Paper Content</th>
      <th>Status</th>
    </thead>
    <tbody>
      <?php
      function getPapers() {
        include_once("Controller/ConferenceChairPendingPaperController.php");
      }
      getPapers();
      $pending_papers = new conferencePendingPaperController();

      $fetchData = $pending_papers->getPapers();

      if (is_array($fetchData)) {
        foreach ($fetchData as $row) {
      ?>
          <tr>
            <td><?php echo $row['submitted_by_author']; ?> </td>
            <td><?php echo $row['paper_Name']; ?> </td>
            <td><?php echo $row['paper_Content']; ?> </td>
            <td><?php echo $row['paper_Status']; ?></td>
          </tr>

          <?php
        }
      } else {
          ?>
          <tr>
            <td colspan="4">
              <?php echo $fetchData; ?>
            </td>
          </tr>
        <?php } ?>
    </tbody>
  </table>
</div>

<div id="allocatePapers" class="tabcontent">
  <br><br><br><br>

  <input type="text" id="allocateTableSearch" onkeyup="allocateTableSearch()" class="searchbar" placeholder="Search...">

  <br><br>

  <form class="" method="post">
    <button type="submit" name="automaticAllocate" style="float:right; margin:10px">Automatic Allocation</button>
  </form>
  
  <br><br>

  <table id="allocatePaperTable">
    <thead>
      <th>Paper Name</th>
      <th>Paper Content</th>
      <th>Reviewer</th>
      <th>Bid Status</th>
      <th>Allocate</th>
    </thead>
    <tbody>
      <?php
      function cc_get_pending_paper() {
        include_once("Controller/ConferenceChairPendingPaperController.php");
      }
      cc_get_pending_paper();
      $pending_papers = new conferencePendingPaperController();

      $fetchData = $pending_papers->cc_get_pending_paper();

      if (is_array($fetchData)) {
        foreach ($fetchData as $row) {
      ?>
          <tr>
            <form class="" method="post">
              <td><?php echo $row['paper_Name']; ?> </td>
              <td><?php echo $row['paper_Content']; ?> </td>
              <td><input type="hidden" name="reviewerID" value=<?php echo $row['reviewer_ID']; ?>> <?php echo $row['reviewer_ID']; ?> </td>
              <td><?php echo $row['bid_Status']; ?></td>
              <td>
              <button type="submit" name="Allocate" value=<?php echo $row['paper_ID']; ?> >Allocate</button>
              <button type="submit" name="rejectAllocate" value=<?php echo $row['paper_ID']; ?> >Reject</button>
              </td>
            </form>
          </tr>

          <?php
        }
      } else {
          ?>
          <tr>
            <td colspan="4">
              <?php echo $fetchData; ?>
            </td>
          </tr>
        <?php } ?>
    </tbody>
  </table>
</div>

<div id="accept_reject_paper" class="tabcontent">
  <br><br><br><br>

  <input type="text" id="arTableSearch" onkeyup="arTableSearch()" class="searchbar" placeholder="Search...">

  <br><br>
  <form class="" method="post">
    <table id="acceptRejectPaperTable">
      <thead>
        <th>Author</th>
        <th>Paper Name</th>
        <th>Paper Content</th>
        <th>Reviewer ID</th>
        <th>Reviewer Rating</th>
        <th>Reviewer Comment</th>
        <th>Additional Comments</th>
        <th> Accept / Reject</th>
      </thead>
      <tbody>
        <?php
        function getARpapers() {
          include_once("Controller/ConferenceChairPendingPaperController.php");
        }
        getARpapers();
        $ar_papers = new conferencePendingPaperController();

        $fetchData = $ar_papers->getARpapers();

        if (is_array($fetchData)) {
          foreach ($fetchData as $row) {
          ?>
          <tr>
            <td><?php echo $row['submitted_by_author']; ?> </td>
            <td><?php echo $row['paper_Name']; ?> </td>
            <td><?php echo $row['paper_Content']; ?> </td>
            <td><?php echo $row['reviewer_ID']; ?> </td>
            <td><?php echo $row['reviewer_Rating']; ?> </td>
            <td><?php echo $row['reviewer_Comment']; ?></td>
            <td><?php echo $row['comment_Content']; ?></td>
            <td>
                <button type="submit" name="acceptPaper" value=<?php echo $row['paper_ID']; ?> >Accept</button>
                <button type="submit" name="rejectPaper" value=<?php echo $row['paper_ID']; ?> >Reject</button>
            </td>
          <tr>

          <?php
          }
        } else {
          ?>
          <tr>
            <td colspan="6">
              <?php echo $fetchData; ?>
            </td>
          </tr>
          <?php 
        } ?>
      </tbody>
    </table>
  </form>
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
  function paperTableSearch() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("paperTableSearch");
    filter = input.value.toUpperCase();
    table = document.getElementById("paperTable");
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

  function allocateTableSearch() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("allocateTableSearch");
    filter = input.value.toUpperCase();
    table = document.getElementById("allocatePaperTable");
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

  function arTableSearch() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("arTableSearch");
    filter = input.value.toUpperCase();
    table = document.getElementById("acceptRejectPaperTable");
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




