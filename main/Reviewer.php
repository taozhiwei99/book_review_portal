<?php

  function getInfo() {
    include_once('Controller/ReviewerController.php');
    $reviewer = new ReviewerController();
    $bool = $reviewer->get_ID($_SESSION["username"]);
    $bool2 = $reviewer->getReviewerWorkload($_SESSION["userID"]);

    if ($bool) {
      echo "<script> console.log('reviewer_ID gotten successfully.');</script>";
    }
    else {
      echo "<script> console.log('Failed to get reviewer_ID.');</script>";
    }

    if ($bool2) {
      echo "<script> console.log('Reviewer max workload gotten successfully.');</script>";
    }
    else {
      echo "<script> console.log('Failed to get reviewer max workload.');</script>";
    }
  }
  
  getInfo();

  function updateWorkload() {
    include_once('Controller/ReviewerController.php');
    $reviewer = new ReviewerController();
    $bool = $reviewer->updateWorkload($_SESSION["userID"], $_POST["workload"]);
    if ($bool) {
      echo "<script> alert('Preferred maximum workload updated successfully.');</script>";
    }
    else {
      echo "<script> alert('Cannot set lower than current workload.');</script>";
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
      echo "<script>alert('Successfully changed password.')</script>";
    }
    else {
      echo "<script> alert('Failed to change password.');</script>";
    }
  }

  function createBid($reviewerID, $paperID) {
    include_once('Controller/ReviewerBidController.php');
    $bid = new ReviewerBidController();
    $bool = $bid->createBid($_SESSION["userID"], $_POST["bid"]);

    if ($bool) {
      echo "<script> alert('Bid successfully.');</script>";
    }
    else {
      echo "<script> alert('Failed to bid.');</script>";
    }
  }

  function getCurrentReview($paperID) {
    include_once('Controller/ReviewerReviewPaperController.php');
    $review = new ReviewerReviewPaperController();

    return $review->getCurrentReview($paperID);
  }

  function createReview($rating, $commentValue, $paperID, $reviewerID) {
    include_once('Controller/ReviewerReviewPaperController.php');
    $review = new ReviewerReviewPaperController();
    $status = $review->create_review($rating, $commentValue, $paperID, $reviewerID);
    if ($status == "updateSuccess") {
      echo "<script> alert('Review updated successfully');</script>";
    }
    else if ($status == "updateFail") {
      echo "<script> alert('Failed to updated review.');</script>";
    }
    else if ($status == "createSuccess") {
      echo "<script> alert('Review created successfully');</script>";
    }
    else if ($status == "createFail") {
      echo "<script> alert('Failed to create review.');</script>";
    }
  }

  function createComment($commentValue, $reviewID) {
    include_once('Controller/ReviewerReviewPaperController.php');
    $review = new ReviewerReviewPaperController();
    $bool = $review->createComment($commentValue, $reviewID);

    if ($bool) {
      echo "<script> alert('Comment added successfully.');</script>";
    }
    else {
      echo "<script> alert('Failed to add comment.');</script>";
    }
  }

  function showRateForm($paperID) {
    $data = getCurrentReview($paperID);
    echo '
    <div id="rateForm" class="modal">
    <div class="popupformcontainer">
      <span onclick="closeForm()" class="close" title="Close Modal">&times;</span>
      <br><br>
        <div class="formcontainerrows">
          <div class="div25">
            <label id="paperIDLabel"> Paper being rated: </label>
          </div>
          <div class="div75">
            <p style="padding: 7px">';
    echo $paperID;
    echo '
        </p>
          </div>
          <br><br>
        </div>
    ';
    if (is_array($data)) {
      echo'
      <table id="bidpaperlist">
        <thead>
          <th width="15%">Reviewer ID</th>
          <th width="10%">Rating</th>
          <th width="30%">Comment</th>
          <th width="30%">Additional comment</th>
          <th width="15%">Add comment</th>
        </thead>
        <tbody>
      ';
      foreach ($data as $row) {
        if ($row['reviewer_Rating'] != "") {
          echo '
            <tr>
              <form action="" method="post">
                <td> <input type="hidden" name="reviewID" value='; echo $row['review_ID'];
                echo '>'; echo $row['reviewer_ID']; echo ' </td>
                <td>'; echo $row['reviewer_Rating']; echo ' </td>
                <td>'; echo $row['reviewer_Comment']; echo ' </td>
                <td>'; echo $row['comment_Content']; echo ' </td>
                <td>
                  <button class="bidbutton" type="submit" name="comment" value=';
                  echo $row['review_ID'];
                echo '> Comment </button>
                </td>
              </form>
            </tr>
          ';
        };
      }
      echo '
        </tbody>
      </table>
      ';
    }
    echo'
    <br>
      <hr style="width:50%">
          <form action="" method="post">
            <label for="rateValue">Select rating:</label>
            <select id="rateValue" name="rateValue">
              <option value="-3"> -3 </option>
              <option value="-2"> -2 </option>
              <option value="-1"> -1 </option>
              <option selected="selected" value="0"> 0 </option>
              <option value="1"> 1 </option>
              <option value="2"> 2 </option>
              <option value="3"> 3 </option>
            </select>
            <div class="div25">
              <label id="commentValue">Comment: </label>
            </div>
            <div class="div75">
              <input type="text" class="edituserinput" id="commentValue" name="commentValue">
            </div>
            <input type="hidden" name="reviewerID" value=';
            echo $_SESSION['userID'];
            echo '>
            <br> <br>
            <div class="formcontainerrows">
            <button class="bidbutton" type="submit" name="createRating" style="float:right" value=';
              echo $paperID;
            echo ' >Submit</button>
            </div>
          </form>
        </div>
    </div>

    <script type=text/javascript>
      document.getElementById("rateForm").style.display="block";

      function closeForm() {
        document.getElementById("rateForm").style.display="none";
      }
    </script>
    ';
  }

  function showCommentForm($reviewID) {
    echo '
    <div id="commentForm" class="modal">
    <div class="popupformcontainer">
      <span onclick="closeForm()" class="close" title="Close Modal">&times;</span>
      <br><br>
        <div class="formcontainerrows">
          <div class="div25">
            <label id="reviewIDlabel"> Adding comment to review </label>
          </div>
          <div class="div75">
            <p style="padding: 7px">';
            echo $reviewID;
            echo '
            </p>
          </div>
        </div>
        
    <br><br>
    ';
    echo'
    <br>
      <hr style="width:50%">
          <form action="" method="post">
            <div class="div25">
              <label id="commentValue">Comment: </label>
            </div>
            <div class="div75">
              <input type="text" class="edituserinput" id="commentValue" name="commentValue">
            </div>
            <br> <br>
            <div class="formcontainerrows">
            <button class="bidbutton" type="submit" name="createComment" style="float:right" value=';
            echo $reviewID;
            echo ' >Submit</button>
            </div>
          </form>
        </div>
    </div>

    <script type=text/javascript>
      document.getElementById("commentForm").style.display="block";

      function closeForm() {
        document.getElementById("commentForm").style.display="none";
      }
    </script>
    ';
  }

  if (isset($_POST["updateWorkload_submit"])) {
    updateWorkload();
  }

  if (isset($_POST['changeDetails_submit'])) {
    updateInfo();
  }
  
  if (isset($_POST['updatePassword_submit'])) {
    changePassword();
  }

  if (isset($_POST['bid'])) {
    createBid($_SESSION["userID"], $_POST["bid"]);
  }

  if (isset($_POST['rate'])) {
    showRateForm($_POST["rate"]);
  }

  if (isset($_POST['createRating'])) {
    createReview($_POST['rateValue'], $_POST['commentValue'], $_POST['createRating'], $_SESSION["userID"]);
  }

  if (isset($_POST['comment'])) {
    showCommentForm($_POST['reviewID']);
  }

  if (isset($_POST['createComment'])) {
    createComment($_POST['commentValue'], $_POST['createComment']);
  }
?>

<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">
<title>Reviewer</title>

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
            <a href="javascript:openSegment('papers');"><i class="fas fa-scroll"></i>My Papers</a>
        </li>
        <li id="bidPapersTab"> 
            <a href="javascript:openSegment('bidPapers');"><i class="fas fa-sliders-h"></i>Bid Paper</a>
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

  <form class="" method="post">
    <table id="paperTable">
      <thead>
        <th width="15%">Paper Name</th>
        <th width="50%">Paper Content</th>
        <th width="10%">Paper Status</th>
        <th width="15%">Bid Status</th>
        <th width="10%">Rate paper</th>
      </thead>
      <tbody>
        <?php
          function getBids() {
            include_once("Controller/ReviewerBidController.php");
          }

          getBids();

          $bids = new ReviewerBidController();
          $fetchData = $bids->getBids($_SESSION["userID"]);
          
          if (is_array($fetchData)) {
            foreach ($fetchData as $row) {
        ?>
        <tr height="150px">
          <td><?php echo $row['paper_Name']; ?> </td>
          <td><?php echo substr($row['paper_Content'],0,400); ?> </td>
          <td><?php echo $row['paper_Status']; ?> </td>
          <td><?php echo $row['bid_Status']; ?> </td>
          <?php 
          if ($row['bid_Status'] == "success" && $row['paper_Status'] == "pending") { ?>
            <td>
              <button type="submit" name="rate" value=<?php echo $row['paper_ID']; ?> >Rate</button>
            </td>
          <?php 
          } ?>
        <tr>

        <?php
          }
        } else {
        ?>
          <tr>
            <td colspan="3">
              <?php echo $fetchData; ?>
            </td>
          </tr>
        <?php } ?>
      </tbody>
      </table>
    </form>
</div>

<div id="bidPapers" class="tabcontent">
    <br><br><br><br>

    <input type="text" id="bidPaperTableSearch" onkeyup="bidPaperTableSearch()" class="searchbar" placeholder="Search...">

    <br><br>
    <form class="" method="post">
      <table id="bidPaperTable">
        <thead>
          <th width="15%">Paper Name</th>
          <th width="70%">Paper Content</th>
          <th width="15%">Bid</th>
        </thead>
        <tbody>
          <?php
          function get_pending_paper() {
            include_once("Controller/ReviewerBidPaperController.php");
          }
          get_pending_paper();
          $pending_papers = new reviewerBidPaperPaperController();
          
          $fetchData = $pending_papers->get_pending_paper($_SESSION["userID"]);

          if (is_array($fetchData)) {
            foreach ($fetchData as $row) {
          ?>
              <tr height="150px">
                <td><?php echo $row['paper_Name']; ?> </td>
                <td><?php echo substr($row['paper_Content'],0,400); ?> </td>
                <td>
                  <button type="submit" name="bid" value=<?php echo $row['paper_ID']; ?> >Bid Paper</button>
                </td>
              <tr>

              <?php
            }
          } else {
              ?>
              <tr>
                <td colspan="3">
                  <?php echo $fetchData; ?>
                </td>
              </tr>
            <?php } ?>
        </tbody>
      </table>
    </form>
</div>

  <!-- Manage Info -->
<div id="manage" class="tabcontent">
  <br><br><br><br><br><br>
  <div class="formcontainer">
    <form action="" method="post">
      <div class="formcontainerrows">
          <div class="div25">
              <label id="namelabel">Maximum preferred workload: </label>
          </div>
          <div class="div75">
              <input type="text" class="createuserinput" id="workload" name="workload" value=<?php echo $_SESSION["workload"]; ?>><br><br>
          </div>
          <p> Current workload: <?php echo $_SESSION["currentWorkload"];?> </p>
      </div>
      <div class="formcontainerrows">
          <button type="submit" name="updateWorkload_submit" value="Submit"> Submit </button>
      </div>
    </form>
  </div>
  
  <br><br>
  <div>
  <!--update password -->
    <h3>Change password</h3>
    <button onclick="document.getElementById('updateUserPassword').style.display='block'">Change Password</button>

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
    <button onclick="document.getElementById('updateUserInfo').style.display='block'">Change Details</button>
    
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

  function bidPaperTableSearch() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("bidPaperTableSearch");
    filter = input.value.toUpperCase();
    table = document.getElementById("bidPaperTable");
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