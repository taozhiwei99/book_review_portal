<?php 
  function getInfo() {
    include_once("Controller/AuthorController.php");
    $cont = new AuthorController();
    $bool = $cont->get_ID($_SESSION["username"]);

    if ($bool) {
      echo "<script> console.log('Author_ID gotten successfully.');</script>";
    }
    else {
      echo "<script> console.log('Failed to get Author_ID.');</script>";
    }
  }

  getInfo();

  function notification($authorID) {
    include_once("Controller/AuthorController.php");
    $cont = new AuthorController();
    $data = $cont->notifications($authorID);
    if (is_array($data)) {
      foreach ($data as $row) {
        echo "<div class='alert'>
          <form action='' method='post'>
            <p>
              Paper ";
              echo $row["paper_ID"];
              echo " has been ";
              echo $row["paper_Status"];
              echo ".
            </p>
            <button type='submit' name='notifRead' value='";
              echo $row['paper_ID'];
              echo "' >&times;
            </button>
          </form>
        </div>";
      }
    }
  }

  function notificationRead($paperID) {
    include_once("Controller/AuthorController.php");
    $cont = new AuthorController();
    $bool = $cont->notificationRead($paperID);

    if ($bool != null) {
      echo "<script>console.log('Alert for paper ";
      echo $paperID;
      echo " acknowledged.')</script>";
    }
    else {
      echo "<script>console.log('Failed to acknowledege alert for paper ";
      echo $paperID;
      echo ".')</script>";
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

  function submitPaper($paperName, $paperContent, $authorID, $co_Author) {
    include_once('Controller/AuthorSubmitPaperController.php'); 
    $submitPaper = new AuthorSubmitPaperController();
    $bool = $submitPaper ->create_paper($paperName, $paperContent, $authorID, $co_Author);
    if ($bool != null) {
      echo "<script>alert('Paper submit successfully.')</script>";
    }
    else {
      echo "<script>alert('Failed to submit paper.')</script>";
    }
  }

  function author_updatePaperDetails($paperID, $paperName, $paperContent) {
    include_once('Controller/AuthorViewPaperListController.php');
    $paper = new authorPaperList();
    $bool = $paper->author_updatePaperDetails($paperID, $paperName, $paperContent);

    if ($bool) {
      echo "<script> alert('Paper ";
      echo $paperID;
      echo " updated successfully.');</script>";
    }
    else {
      echo "<script> alert('Failed to update paper  ";
      echo $paperID;
      echo ".');</script>";
    }
  }

  function updateRating($reviewID, $rating) {
    include_once('Controller/AuthorViewPaperListController.php');
    $review = new authorPaperList();
    $bool = $review->updateRating($reviewID, $rating);

    if ($bool) {
      echo "<script> alert('Rating updated successfully.');</script>";
    }
    else {
      echo "<script> alert('Failed to update rating.');</script>";
    }
  }

  function getCurrentReview($paperID) {
    include_once('Controller/ReviewerReviewPaperController.php');
    $review = new ReviewerReviewPaperController();
    
    return $review->getCurrentReview($paperID);
  }

  function viewReviewForm($paperID) {
    $data = getCurrentReview($paperID);
    echo '
      <div id="rateForm" class="modal">
      <div class="popupformcontainer">
        <span onclick="closeForm()" class="close" title="Close Modal">&times;</span>
        <br><br>
          <div class="formcontainerrows">
            <div class="div25">
              <label id="paperIDLabel" >Paper being rated: </label>
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
            <th width="10%">Review ID</th>
            <th width="10%">Reviewer ID</th>
            <th width="10%">Rating</th>
            <th width="20%">Reviewer Comment</th>
            <th width="10%">Rate Review</th>
            <th width="10%">Function</th>
          </thead>
          <tbody>
        ';
        foreach ($data as $row) {
          if ($row['reviewer_Rating'] != "") {
            echo '
            <form action="" method="post">
              <tr>
                <td>'; echo $row['review_ID']; echo ' </td>
                <td>'; echo $row['reviewer_ID']; echo ' </td>
                <td>'; echo $row['reviewer_Rating']; echo ' </td>
                <td>'; echo $row['reviewer_Comment']; echo ' </td>
                <td>
                  <select id="rateValue" name="rateValue" >
                    <option value="-3">-3</option>
                    <option value="-2">-2</option>
                    <option value="-1">-1</option>
                    <option value="0" selected>0</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                  </select>
                </td>
                <td><button type="submit" name="rateReviews" style="float:right;" class="sampleButton" value='; echo $row['review_ID']; echo '>Submit</button></td>
              </tr>
            </form>
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
          <br>
          <div class="formcontainerrows">
          </div>
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

  function editPaperForm($paperID) {
    echo '
    <div id="editPaperForm" class="modal">
    <div class="popupformcontainer">
      <span onclick="closeForm()" class="close" title="Close Modal">&times;</span>
      <br><br>
      <form action="" method="post">
        <div class="formcontainerrows">
          <div class="div25">
            <label id="paperIDLabel" >Paper ID: </label>
          </div>
          <div class="div75">
          <input type="text" class="edituserinput" id="paperID" name="paperID" value='; echo $paperID; echo ' disabled><br><br>
          </div>
          <br><br>
        </div>
        <div class="formcontainerrows">
          <div class="div25">
            <label id="paperNameLabel" >Paper Name: </label>
          </div>
          <div class="div75">
          <input type="text" class="edituserinput" id="paperName" name="paperName" required><br><br>
          </div>
          <br><br>
        </div>
        <div class="formcontainerrows">
          <div class="div25">
            <label id="paperContentLabel" >Paper Content: </label>
          </div>
          <div class="div75">
          <input type="text" class="edituserinput" id="paperContent" name="paperContent" required><br><br>
          </div>
          <br><br>
        </div>
    ';
    echo ' 
        <div class="formcontainerrows">
          <button type="submit" name="updatePaper" value='; echo $paperID; echo '>Submit</button>
        </div>
      </form>
      </div>
    </div>

    <script type=text/javascript>
      document.getElementById("editPaperForm").style.display="block";

      function closeForm() {
        document.getElementById("editPaperForm").style.display="none";
      }
    </script>
    ';
  }
  
  if (isset($_POST['changeDetails_submit'])) {
    updateInfo();
  }
  
  if (isset($_POST['updatePassword_submit'])) {
    changePassword();
  }

  if (isset($_POST['submitPaper'])) {
    submitPaper($_POST["paper_Name"], $_POST["paper_Content"], $_SESSION["author_ID"], $_POST["co_Author"]);
  }

  if (isset($_POST['editPaperButton'])) {
    editPaperForm($_POST["editPaperButton"]);
  }

  if (isset($_POST['updatePaper'])) {
    author_updatePaperDetails($_POST["updatePaper"], $_POST["paperName"], $_POST["paperContent"]);
  }

  if (isset($_POST['viewReviewButton'])) {
    viewReviewForm($_POST["viewReviewButton"]);
  }

  if (isset($_POST['rateReviews'])) {
    updateRating($_POST['rateReviews'], $_POST['rateValue']);
  }

  if (isset($_POST['notifRead'])) {
    notificationRead($_POST['notifRead']);
  }
?>
<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">
<title>Author</title>

<head>
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.2/css/all.css'>
<link rel="stylesheet" href="style/general.css">
</head>

<body>
<!-- Navigation bar -->
<div id="navbar-animmenu">
    <ul class="show-dropdown main-navbar">
        <div class="hori-selector"><div class="left"></div><div class="right"></div></div>
        <li id="papersTab" class ="active">
            <a href="javascript:openSegment('papers');"><i class="fas fa-scroll"></i>Papers</a>
        </li>        

        <li id="submitPaperTab">
          <a href="javascript:openSegment('submitPaper');"><i class="fas fa-book"></i>Submit Paper</a>
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

<br><br>

<div id="papers" class="tabcontent" style="display:block">
  <br><br><br><br>
      
    <?php notification($_SESSION["author_ID"]); ?>
    <input type="text" id="searchPaperList" onkeyup="searchPaperList()" class="searchbar" placeholder="Search...">

    <br><br>
    <form class="" method="post">
      <table id="authorViewPaperList">
        <thead>
          <th>Paper ID</th>
          <th>Paper Name</th>
          <th>Paper Content</th>
          <th>Paper Status</th>
          <th>Function</th>
        </thead>
        <tbody>
          <?php
          function author_getListPaper() {
            include_once("Controller/AuthorViewPaperListController.php");
          }
          author_getListPaper();
          $paper_list = new authorPaperList();

          $fetchData = $paper_list->author_getListPaper($_SESSION["username"]);

          if (is_array($fetchData)) {
            foreach ($fetchData as $row) {
          ?>
              <tr>
              <td><?php echo $row['paper_ID']; ?> </td>
                <td><?php echo $row['paper_Name']; ?> </td>
                <td><?php echo substr($row['paper_Content'],0,20); ?> </td>
                <td><?php echo $row['paper_Status']; ?> </td>
                <td>
                  <?php
                  if ($row['paper_Status'] == "pending") { ?>
                  <button name="editPaperButton" type="submit" value=<?php echo $row['paper_ID']; ?> >Edit Paper</button>
                  <?php } ?>
                  <?php
                  if ($row['paper_Status'] != "pending") { ?>
                  <button name="viewReviewButton" type="submit" value=<?php echo $row['paper_ID']; ?> >View Review</button>
                  <?php } ?>
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


<div id= "submitPaper" class="tabcontent">
  <br><br><br>
  <div class ="formcontainer">
    <form action = "" method = "post">
      <div class = "formcontainerrows">
        <div class ="div25">
          <label>Paper Name : </label>
        </div>
        <div class ="div75">
          <input type ="text" class = "createuserinput" name = "paper_Name"><br><br>
        </div>
      </div>

      <div class = "formcontainerrows">
        <div class ="div25">
          <label>Co-Author : </label>
        </div>
        <div class ="div75">
          <input type ="text" class = "createuserinput" name = "co_Author"><br><br>
        </div>
      </div>
      <div class ="formcontainerrows">
        <div class = "div25">
          <label>Paper Content : </label>
        </div>
        <div class = "div75">
          <input type = "textarea" class = "createuserinput" name = "paper_Content"><br><br>
        </div>
      </div>

      <div class = "formcontainerrows">
        <button type="submit" name = "submitPaper" value = "Submit"> Submit </button>
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
  function searchPaperList() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("searchPaperList");
    filter = input.value.toUpperCase();
    table = document.getElementById("authorViewPaperList");
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