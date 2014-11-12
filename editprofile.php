<?php
  session_start();

  // If the session vars aren't set, try to set them with a cookie
  if (!isset($_SESSION['user_id'])) {
    if (isset($_COOKIE['user_id']) && isset($_COOKIE['username'])) {
      $_SESSION['user_id'] = $_COOKIE['user_id'];
      $_SESSION['username'] = $_COOKIE['username'];
    }
  }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Module Data Insertion</title>
  <link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
  <h3>IBL Production Database Interface - Pixel Modules Data Insertion</h3>

<?php
  require_once('appvars.php');
  require_once('connectvars.php');

  // Make sure the user is logged in before going any further.
  if (!isset($_SESSION['user_id'])) {
    echo '<p class="login">Please <a href="login.php">log in</a> to access this page.</p>';
    exit();
  }
  else {
    echo('<p class="login">You are logged in as ' . $_SESSION['username'] . '. <a href="logout.php">Log out</a>.</p>');
  }

  // Connect to the database
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  if (isset($_POST['submit'])) {
    // Grab the profile data from the POST
    $first_name = mysqli_real_escape_string($dbc, trim($_POST['firstname']));
    $last_name = mysqli_real_escape_string($dbc, trim($_POST['lastname']));
    $email = mysqli_real_escape_string($dbc, trim($_POST['email']));
    $stave_number = mysqli_real_escape_string($dbc, trim($_POST['stave_number']));
    $stave_side = mysqli_real_escape_string($dbc, trim($_POST['stave_side']));
    $module_type = mysqli_real_escape_string($dbc, trim($_POST['module_type']));
    //$module_id = mysqli_real_escape_string($dbc, trim($_POST['module_id']));
    $module_position = mysqli_real_escape_string($dbc, trim($_POST['module_position']));
    $status = mysqli_real_escape_string($dbc, trim($_POST['status']));
    $new_DS = mysqli_real_escape_string($dbc, trim($_FILES['new_DS']['name']));
    $new_DS_type = $_FILES['new_DS']['type'];
    $new_DS_size = $_FILES['new_DS']['size']; 
    list($new_DS_width, $new_DS_height) = getimagesize($_FILES['new_DS']['tmp_name']);
    
    $error = true;


     if (!empty($new_DS)) 
       {
	 if ((($new_DS_type == 'image/gif') || ($new_DS_type == 'image/jpeg') || ($new_DS_type == 'image/pjpeg') ||
	      ($new_DS_type == 'image/png')) && ($new_DS_size > 0) /*&& ($new_DS_size <= MM_MAXFILESIZE) &&
												       ($new_DS_width <= MM_MAXIMGWIDTH) && ($new_DS_height <= MM_MAXIMGHEIGHT)*/) {
	   if ($_FILES['file']['error'] == 0) {
	     // Move the file to the target upload folder
	     $target = MM_UPLOADPATH . basename($new_DS);
	     if (move_uploaded_file($_FILES['new_DS']['tmp_name'], $target)) {
	       // The new DS file move was successful, now make sure any old DS is deleted
	       if (!empty($old_DS) && ($old_DS != $new_DS)) {
		 @unlink(MM_UPLOADPATH . $old_DS);
	       }
	     }
	     else {
	       // The new DS file move failed, so delete the temporary file and set the error flag
	       @unlink($_FILES['new_DS']['tmp_name']);
	       $error = true;
	       echo '<p class="error">Sorry, there was a problem uploading your DS.</p>';
	     }
	   }
	 }
	 else {
	   // The new DS file is not valid, so delete the temporary file and set the error flag
	   @unlink($_FILES['new_DS']['tmp_name']);
	   $error = true;
	   echo '<p class="error">Your DS must be a GIF, JPEG, or PNG image file no greater than ' . (MM_MAXFILESIZE / 1024) .
	     ' KB and ' . MM_MAXIMGWIDTH . 'x' . MM_MAXIMGHEIGHT . ' pixels in size.</p>';
	 }
       }
     



    //Grab the user data from the DB	
    
    $query = "SELECT first_name,last_name,email FROM mismatch_user WHERE user_id = '" . $_SESSION['user_id'] . "'";
    $data = mysqli_query($dbc, $query);
    $row = mysqli_fetch_array($data);

    if ($row != NULL) {
      $first_name = $row['first_name'];
      $last_name = $row['last_name'];
      $email = $row['email'];
     }

    if ($error) {
      if (!empty($first_name) && !empty($last_name) && !empty($email) && !empty($stave_number) && !empty($stave_side) && !empty($module_type) && /*!empty($module_id) &&*/ !empty($status)) {
        
	if(($module_type=='Planar' && $module_position>6) || ($module_type=='3D' && $module_position<7)){

	    echo '<p class="error">Incompatible module technology and position!</p>';

	}
        else{
        $query = "INSERT INTO Modules (user_id,name_user,surname_user,email_user,module_id,stave_number,stave_side,module_type,module_position,reception_test_status, time) VALUES (" . $_SESSION['user_id'] . ",'$first_name','$last_name','$email','$module_id','$stave_number','$stave_side','$module_type','$module_position','$status', NOW())"; 

	$result=mysqli_query($dbc, $query);

        // Confirm success with the user
        if($result){
   		echo '<p>This module has been successfully updated. Would you like to <a href="viewprofile.php">view the data</a>?</p>';
		echo '<p>Or would you like to <a href="editprofile.php">insert a new module</a>?</p>';
	}
	else{
		echo 'DB Error';
 	}

        mysqli_close($dbc);
        exit();
        }
      }
      else {
        echo '<p class="error">You must enter all of the module data.</p>';
      }
    }
  } // End of check for form submission
  else {
    // Grab the profile data from the database
    
    $query = "SELECT first_name,last_name,email FROM mismatch_user WHERE user_id = '" . $_SESSION['user_id'] . "'";
    $data = mysqli_query($dbc, $query);
    $row = mysqli_fetch_array($data);

    if ($row != NULL) {
      $first_name = $row['first_name'];
      $last_name = $row['last_name'];
      $email = $row['email'];
     }
    else {
      echo '<p class="error">There was a problem accessing your profile.</p>';
    }
  }

  mysqli_close($dbc);
?>

  <form enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MM_MAXFILESIZE; ?>" />
    <fieldset>
      <legend>Module Information</legend>
      <label for="firstname">First name:</label>
      <?php if (!empty($first_name)) echo $first_name; ?>
      <input type="hidden" id="firstname" name="firstname" value="<?php if (!empty($first_name)) echo $first_name; ?>" /><br />
      <label for="lastname">Last name:</label>
      <?php if (!empty($last_name)) echo $last_name; ?>
      <input type="hidden" id="lastname" name="lastname" value="<?php if (!empty($last_name)) echo $last_name; ?>" /><br />
      <label for="email">E-mail:</label>
      <?php if (!empty($email)) echo $email; ?>
      <input type="hidden" id="email" name="email" value="<?php if (!empty($email)) echo $email; ?>" /><br />
      <!--<select id="email" name="email">
        <option value="M" <?php if (!empty($email) && $email == 'M') echo 'selected = "selected"'; ?>>Male</option>
        <option value="F" <?php if (!empty($email) && $email == 'F') echo 'selected = "selected"'; ?>>Female</option>
      <br />
       <label for="module_id">Module Id:</label>
       <input type="text" id="module_id" name="module_id" value="<?php if (!empty($module_id)) echo $module_id; ?>" /><br />-->
      <label for="stave_number">Stave Number:</label>
      <select name="stave_number" id="stave_number">

<option value="0"<?php if (!empty($stave_number) && $stave_number == '0') echo 'selected = "selected"'; ?>>0</option>
<option value="1"<?php if (!empty($stave_number) && $stave_number == '1') echo 'selected = "selected"'; ?>>1</option>
<option value="2"<?php if (!empty($stave_number) && $stave_number == '2') echo 'selected = "selected"'; ?>>2</option>
<option value="3"<?php if (!empty($stave_number) && $stave_number == '3') echo 'selected = "selected"'; ?>>3</option>
<option value="4"<?php if (!empty($stave_number) && $stave_number == '4') echo 'selected = "selected"'; ?>>4</option>
<option value="5"<?php if (!empty($stave_number) && $stave_number == '5') echo 'selected = "selected"'; ?>>5</option>
<option value="6"<?php if (!empty($stave_number) && $stave_number == '6') echo 'selected = "selected"'; ?>>6</option>
<option value="7"<?php if (!empty($stave_number) && $stave_number == '7') echo 'selected = "selected"'; ?>>7</option>
<option value="8"<?php if (!empty($stave_number) && $stave_number == '8') echo 'selected = "selected"'; ?>>8</option>
<option value="9"<?php if (!empty($stave_number) && $stave_number == '9') echo 'selected = "selected"'; ?>>9</option>
<option value="10"<?php if (!empty($stave_number) && $stave_number == '10') echo 'selected = "selected"'; ?>>10</option>
<option value="11"<?php if (!empty($stave_number) && $stave_number == '11') echo 'selected = "selected"'; ?>>11</option>
<option value="12"<?php if (!empty($stave_number) && $stave_number == '12') echo 'selected = "selected"'; ?>>12</option>
<option value="13"<?php if (!empty($stave_number) && $stave_number == '13') echo 'selected = "selected"'; ?>>13</option>


</select>
	 <br />
      
      <label for="stave_side">Stave Side:</label>
      <select name="stave_side"  id="stave_side">

<option value="A"<?php if (!empty($stave_side) && $stave_side == 'A') echo 'selected = "selected"'; ?>>A</option>
<option value="C"<?php if (!empty($stave_side) && $stave_side == 'C') echo 'selected = "selected"'; ?>>C</option>

      </select>
	<br />
      
	<label for="module_type">Module Technology:</label>
<select name="module_type"  id="module_type">
      <option value="Planar"<?php if (!empty($module_type) && $module_type == 'Planar') echo 'selected = "selected"'; ?>>Planar</option>
      <option value="3D"<?php if (!empty($module_type) && $module_type == '3D') echo 'selected = "selected"'; ?>>3D</option>
</select>
<br />

      <label for="module_position">Module Position:</label>
<select name="module_position"  id="module_position">

<option value="1"<?php if (!empty($module_position) && $module_position == '1') echo 'selected = "selected"'; ?>>1</option>
<option value="2"<?php if (!empty($module_position) && $module_position == '2') echo 'selected = "selected"'; ?>>2</option>
<option value="3"<?php if (!empty($module_position) && $module_position == '3') echo 'selected = "selected"'; ?>>3</option>
<option value="4"<?php if (!empty($module_position) && $module_position == '4') echo 'selected = "selected"'; ?>>4</option>
<option value="5"<?php if (!empty($module_position) && $module_position == '5') echo 'selected = "selected"'; ?>>5</option>
<option value="6"<?php if (!empty($module_position) && $module_position == '6') echo 'selected = "selected"'; ?>>6</option>
<option value="7"<?php if (!empty($module_position) && $module_position == '7') echo 'selected = "selected"'; ?>>7</option>
<option value="8"<?php if (!empty($module_position) && $module_position == '8') echo 'selected = "selected"'; ?>>8</option>
<option value="9"<?php if (!empty($module_position) && $module_position == '9') echo 'selected = "selected"'; ?>>9</option>
<option value="10"<?php if (!empty($module_position) && $module_position == '10') echo 'selected = "selected"'; ?>>10</option>


</select><br />
      <label for="module_position">Module Status:</label>
      <select name="status" id="status"  multiple="multiple" size="3">
      <option value="ACCEPTED"<?php if (!empty($status) && $status == 'ACCEPTED') echo 'selected = "selected"'; ?>>ACCEPTED</option>
      <option value="REJECTED"<?php if (!empty($status) && $status == 'REJECTED') echo 'selected = "selected"'; ?>>REJECTED</option>
      <option value="PENDING"<?php if (!empty($status) && $status == 'PENDING') echo 'selected = "selected"'; ?>>PENDING</option> 
      </select> <br />



      <!--<label for="new_DS">DS:</label>
      <input type="file" id="new_DS" name="new_DS" />
      <?php if (!empty($module_position)) {
        echo '<img class="profile" src="' . MM_UPLOADPATH . $module_position . '" alt="Profile DS" />';
      } ?>-->

      <label for="new_DS">Datasheet:</label>
         <input type="file" id="new_DS" name="new_DS" />
        




      <!--<label for="new_picture">Picture:</label>
      <input type="file" id="new_picture" name="new_picture" />
      <?php if (!empty($module_position)) {
        echo '<img class="profile" src="' . MM_UPLOADPATH . $module_position . '" alt="Profile Picture" />';
      } ?>-->
    </fieldset>
    <input type="submit" value="Save Module" name="submit" />
  </form>
</body> 
</html>
