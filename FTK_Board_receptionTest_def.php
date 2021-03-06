<?php
  //ini_set('display_errors', 'On');  
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
  <title>Module Reception Test</title>
  <link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
  <h3>IBL Production Database Interface - Pixel Modules Data Insertion</h3>

<?php
					       //ini_set('display_errors', 'On');
  require_once('appvars.php');
  require_once('connectvars.php');

  // Make sure the user is logged in before going any further.
  if (!isset($_SESSION['user_id'])) {
    echo '<p class="login">Please <a href="login.php">log in</a> to access this page.</p>';
    exit();
  }
  else {
    echo('<p class="login">You are logged in as ' . $_SESSION['username'] . '. <a href="logout.php">Log out</a>.<br /> Go back to the <a href="index.php">Index</a>.</p>');
  }

  // Connect to the database
  $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

  if (isset($_POST['submit'])) {
    // Grab the profile data from the POST
    $first_name = mysqli_real_escape_string($dbc, trim($_POST['name_user']));
    $surname_user = mysqli_real_escape_string($dbc, trim($_POST['surname_user']));
    $email_user = mysqli_real_escape_string($dbc, trim($_POST['email_user']));

   

    $location = mysqli_real_escape_string($dbc, trim($_POST['location']));
    
    $id_module_A=mysqli_real_escape_string($dbc, trim($_POST['id_module_A']));
    $id_module_B=mysqli_real_escape_string($dbc, trim($_POST['id_module_B']));
    $id_module_C=mysqli_real_escape_string($dbc, trim($_POST['id_module_C']));

    $module_type = mysqli_real_escape_string($dbc, trim($_POST['module_type']));
    $board_type  = mysqli_real_escape_string($dbc, trim($_POST['board_type']));
    
    $b_a_TH = mysqli_real_escape_string($dbc, trim($_POST['b_a_TH']));
    
    //$VDDA_7= mysqli_real_escape_string($dbc, trim($_POST['VDDA_7']));
    //$VDDA_6= mysqli_real_escape_string($dbc, trim($_POST['VDDA_6']));
    //$VDDD_7= mysqli_real_escape_string($dbc, trim($_POST['VDDD_7']));
    //$VDDD_6= mysqli_real_escape_string($dbc, trim($_POST['VDDD_6']));
    
    $leakage_current_at_op_voltage= mysqli_real_escape_string($dbc, trim($_POST['leakage_current_at_op_voltage']));
    $break_down_voltage= mysqli_real_escape_string($dbc, trim($_POST['break_down_voltage']));

    $optical_inspection= mysqli_real_escape_string($dbc, trim($_POST['optical_inspection']));
    $electrical_test= mysqli_real_escape_string($dbc, trim($_POST['electrical_test']));
    $IV_test= mysqli_real_escape_string($dbc, trim($_POST['IV_test']));
    $digital_test= mysqli_real_escape_string($dbc, trim($_POST['digital_test']));
    $analog_test= mysqli_real_escape_string($dbc, trim($_POST['analog_test']));
    $threshold_scan= mysqli_real_escape_string($dbc, trim($_POST['threshold_scan_button']));
    
    $mean_threshold_scan= mysqli_real_escape_string($dbc, trim($_POST['mean_threshold_scan']));
    $sigma_threshold_scan= mysqli_real_escape_string($dbc, trim($_POST['sigma_threshold_scan']));
    $sigma_noise_thr_scan= mysqli_real_escape_string($dbc, trim($_POST['sigma_noise_thr_scan']));


    $x_talk= mysqli_real_escape_string($dbc, trim($_POST['x_talk']));
    //$amount_of_disc_ch_after_xtalk= mysqli_real_escape_string($dbc, trim($_POST['amount_of_disc_ch_after_xtalk']));

    //$rework= mysqli_real_escape_string($dbc, trim($_POST['rework']));
    //$shipped_back= mysqli_real_escape_string($dbc, trim($_POST['shipped_back']));
    //$reworked= mysqli_real_escape_string($dbc, trim($_POST['reworked']));

    $notes_on_the_test= mysqli_real_escape_string($dbc, trim($_POST['notes_on_the_test']));

    $optical_inspection_picture_a_name = mysqli_real_escape_string($dbc, trim($_FILES['optical_inspection_picture_a_new']['name']));
    $optical_inspection_picture_a_type = $_FILES['optical_inspection_picture_a_new']['type'];
    $optical_inspection_picture_a_size = $_FILES['optical_inspection_picture_a_new']['size']; 
    list($optical_inspection_picture_a_width, $optical_inspection_picture_a_height) = getimagesize($_FILES['optical_inspection_picture_a_new']['tmp_name']);
    
    $optical_inspection_picture_b_name = mysqli_real_escape_string($dbc, trim($_FILES['optical_inspection_picture_b_new']['name']));
    $optical_inspection_picture_b_type = $_FILES['optical_inspection_picture_b_new']['type'];
    $optical_inspection_picture_b_size = $_FILES['optical_inspection_picture_b_new']['size']; 
    list($optical_inspection_picture_b_width, $optical_inspection_picture_b_height) = getimagesize($_FILES['optical_inspection_picture_b_new']['tmp_name']);

    $optical_inspection_picture_c_name = mysqli_real_escape_string($dbc, trim($_FILES['optical_inspection_picture_c_new']['name']));    
    $optical_inspection_picture_c_type = $_FILES['optical_inspection_picture_c_new']['type'];
    $optical_inspection_picture_c_size = $_FILES['optical_inspection_picture_c_new']['size'];
    list($optical_inspection_picture_c_width, $optical_inspection_picture_c_height) = getimagesize($_FILES['optical_inspection_picture_c_new']['tmp_name']);

    $optical_inspection_picture_d_name = mysqli_real_escape_string($dbc, trim($_FILES['optical_inspection_picture_d_new']['name']));
    $optical_inspection_picture_d_type = $_FILES['optical_inspection_picture_d_new']['type'];
    $optical_inspection_picture_d_size = $_FILES['optical_inspection_picture_d_new']['size'];
    list($optical_inspection_picture_d_width, $optical_inspection_picture_d_height) = getimagesize($_FILES['optical_inspection_picture_d_new']['tmp_name']);

    $optical_inspection_picture_e_name = mysqli_real_escape_string($dbc, trim($_FILES['optical_inspection_picture_e_new']['name']));
    $optical_inspection_picture_e_type = $_FILES['optical_inspection_picture_e_new']['type'];
    $optical_inspection_picture_e_size = $_FILES['optical_inspection_picture_e_new']['size'];
    list($optical_inspection_picture_e_width, $optical_inspection_picture_e_height) = getimagesize($_FILES['optical_inspection_picture_e_new']['tmp_name']);

    $root_file_test_old = mysqli_real_escape_string($dbc, trim($_POST['root_file_test_old']));

    $root_file_test_name = mysqli_real_escape_string($dbc, trim($_FILES['root_file_test_new']['name']));
    $root_file_test_type = $_FILES['root_file_test_new']['type'];
    //echo $root_file_test_type;
    $root_file_test_size = $_FILES['root_file_test_new']['size']; 
    list($root_file_test_width, $root_file_test_height) = getimagesize($_FILES['root_file_test_new']['tmp_name']);

    $optical_inspection_picture_a_old = mysqli_real_escape_string($dbc, trim($_POST['optical_inspection_picture_a_old']));
    $optical_inspection_picture_b_old = mysqli_real_escape_string($dbc, trim($_POST['optical_inspection_picture_b_old']));
    $optical_inspection_picture_c_old = mysqli_real_escape_string($dbc, trim($_POST['optical_inspection_picture_c_old']));
    $optical_inspection_picture_d_old = mysqli_real_escape_string($dbc, trim($_POST['optical_inspection_picture_d_old']));
    $optical_inspection_picture_e_old = mysqli_real_escape_string($dbc, trim($_POST['optical_inspection_picture_e_old']));
    $root_file_test_old = mysqli_real_escape_string($dbc, trim($_POST['root_file_test_old']));


    $module_installed=$_POST['module_installed'];
    if($module_installed =='2')
      {
	$stave_number = mysqli_real_escape_string($dbc, trim($_POST['stave_number']));
	$stave_side = mysqli_real_escape_string($dbc, trim($_POST['stave_side']));    
	$module_position = mysqli_real_escape_string($dbc, trim($_POST['module_position']));}
    //$status = mysqli_real_escape_string($dbc, trim($_POST['status']));
    else {
      $stave_number    = '';
      $stave_side      = '';
      $module_position = '';
    }

    $error = true;

    $today = getdate(time());
        
    $sec = $today["seconds"];
    $min = $today["minutes"];
    $hour = $today["hours"];
    $mday = $today["mday"];
    $mon = $today["mon"];
    $year = $today["year"];
    
    $today_new = mktime($hour, $min, $sec, $mon, $mday, $year);

    $date_today=date('h-i-s_d-m-Y_',$today_new);

    $pictureA='PictureA_';
    $pictureB='PictureB_';
    $pictureC='PictureC_';
    $pictureD='PictureD_';
    $pictureE='PictureE_';
    $root_file='Rootfile_';
   

    //Grab the user data from the DB	
    
    $query = "SELECT first_name,last_name,email FROM mismatch_user WHERE user_id = '" . $_SESSION['user_id'] . "'";
    $data = mysqli_query($dbc, $query);
    $row = mysqli_fetch_array($data);

    if ($row != NULL) {
      $name_user = $row['first_name'];
      $surname_user = $row['last_name'];
      $email_user = $row['email'];
     }

    //module id check

    $is_int_moduleID= false;
    
    if( is_numeric($id_module_A) && is_numeric($id_module_B) && is_numeric($id_module_C)) 
      {
	if($id_module_A<100 && $id_module_B<100 && $id_module_C<100 && $id_module_A>=0 && $id_module_B>=0 && $id_module_C>=0){ $is_int_moduleID=true;}
      }
    

    //is numeric variables
    $is_numeric_variables=false;

    /*
    if(// is_numeric($VDDA_7) && !empty($VDDA_7)  
       //&& is_numeric($VDDA_6) && !empty($VDDA_6)
       //&& is_numeric($VDDD_7) && !empty($VDDD_7)
       //&& is_numeric($VDDD_6) && !empty($VDDD_6) 
        is_numeric($leakage_current_at_op_voltage) && !empty($leakage_current_at_op_voltage) 
	&& is_numeric($break_down_voltage) && !empty($break_down_voltage) 
	//&& is_numeric($amount_of_disc_ch_after_xtalk) && !empty($amount_of_disc_ch_after_xtalk) 
	&& is_numeric($mean_threshold_scan) && !empty($mean_threshold_scan) 
	&& is_numeric($sigma_threshold_scan) && !empty($sigma_threshold_scan)
	&& is_numeric($sigma_noise_thr_scan) && !empty($sigma_noise_thr_scan)) { $is_numeric_variables=true;} 
    */

    $bool_antiHaking=true;

    if ($error) {
        echo $error ;
     
      if($is_int_moduleID && $is_numeric_variables){  
	$bool_antiHaking=true;
      } else { 
	echo '<p class="error">Variable Type and Size not regular or fields not filled up!</p>';
      } 
      
      //echo $bool_antiHaking;
      //sanity checks
      if (!empty($name_user) && !empty($surname_user) && !empty($email_user) /*&& !empty($stave_number) && !empty($stave_side)*/ && !empty($module_type) && $bool_antiHaking/* && !empty($module_id) && !empty($status)*/) {
        
	$loaded_check=true;

	if($module_installed==2){
	  if($stave_side=='A'){
	    if(($module_type=='Planar' && $module_position>6) || ($module_type=='3D' && $module_position<7)){
	      
	      echo '<p class="error">Incompatible module technology and position pippo1!</p>';
	      //$loaded_check=false;
	    }
	  }
	  elseif ($stave_side=='C'){
	    if(($module_type=='Planar' && $module_position<5) || ($module_type=='3D' && $module_position>4)){
	      
	      echo '<p class="error">Incompatible module technology and position pippo!</p>';
	      //$loaded_check=false;
	    }
	  }

	    
	}


	if($loaded_check){
	  
	  //This is just an example...
	  if($module_type=='Planar') $ATLAS_id=20216259700000+$id_module_B*100+$id_module_C;
	  if($module_type=='3D') $ATLAS_id=20216258300000+$id_module_B*100+$id_module_C;
	  //method Get give the old ATLAS_id

	  $space='_';

	  if(!empty($optical_inspection_picture_a_name) && ((($optical_inspection_picture_a_type == 'application/pdf') || ($optical_inspection_picture_a_type == 'image/jpeg') || ($optical_inspection_picture_a_type == 'image/gif') ||
							     ($optical_inspection_picture_a_type == 'image/png')) && ($optical_inspection_picture_a_size > 0) && ($optical_inspection_picture_a_size <= MM_MAXFILESIZE_IMAGES))){  
	    $PictureA="$pictureA$ATLAS_id$space$optical_inspection_picture_a_name";
	  } else $PictureA='';

	  echo "$optical_inspection_picture_a_old";
	  if(!empty($optical_inspection_picture_a_old) && empty($optical_inspection_picture_a_name)) $PictureA="$optical_inspection_picture_a_old"; 

	  if(!empty($optical_inspection_picture_b_name) && ((($optical_inspection_picture_b_type == 'application/pdf') || ($optical_inspection_picture_b_type == 'image/jpeg') || ($optical_inspection_picture_b_type == 'image/gif') ||
                   ($optical_inspection_picture_b_type == 'image/png')) && ($optical_inspection_picture_b_size > 0) && ($optical_inspection_picture_b_size <= MM_MAXFILESIZE_IMAGES)))  $PictureB="$pictureB$ATLAS_id$space$optical_inspection_picture_b_name";
	  else $PictureB='';

	  if(!empty($optical_inspection_picture_b_old) && empty($optical_inspection_picture_b_name)) $PictureB="$optical_inspection_picture_b_old";

	  if(!empty($optical_inspection_picture_c_name) && ((($optical_inspection_picture_c_type == 'application/pdf') || ($optical_inspection_picture_c_type == 'image/jpeg') || ($optical_inspection_picture_c_type == 'image/gif') ||
                   ($optical_inspection_picture_c_type == 'image/png')) && ($optical_inspection_picture_c_size > 0) && ($optical_inspection_picture_c_size <= MM_MAXFILESIZE_IMAGES)))  $PictureC="$pictureC$ATLAS_id$space$optical_inspection_picture_c_name";
	  else $PictureC='';

	  if(!empty($optical_inspection_picture_c_old) && empty($optical_inspection_picture_c_name)) $PictureC=$optical_inspection_picture_c_old;

          if(!empty($optical_inspection_picture_d_name) && ((($optical_inspection_picture_d_type == 'application/pdf') || ($optical_inspection_picture_d_type == 'image/jpeg') || ($optical_inspection_picture_d_type == 'image/gif') ||
                   ($optical_inspection_picture_d_type == 'image/png')) && ($optical_inspection_picture_d_size > 0) && ($optical_inspection_picture_d_size <= MM_MAXFILESIZE_IMAGES)))  $PictureD="$pictureD$ATLAS_id$space$optical_inspection_picture_d_name";
          else $PictureD='';
 
	  if(!empty($optical_inspection_picture_d_old) && empty($optical_inspection_picture_d_name)) $PictureD=$optical_inspection_picture_d_old;


          if(!empty($optical_inspection_picture_e_name) && ((($optical_inspection_picture_e_type == 'application/pdf') || ($optical_inspection_picture_e_type == 'image/jpeg') || ($optical_inspection_picture_e_type == 'image/gif') ||
                   ($optical_inspection_picture_e_type == 'image/png')) && ($optical_inspection_picture_e_size > 0) && ($optical_inspection_picture_e_size <= MM_MAXFILESIZE_IMAGES)))  $PictureE="$pictureE$ATLAS_id$space$optical_inspection_picture_e_name";
          else $PictureE='';

	  if(!empty($optical_inspection_picture_e_old) && empty($optical_inspection_picture_e_name)) $PictureE=$optical_inspection_picture_e_old;

	  if(!empty($root_file_test_name) && ($root_file_test_size > 0) && ($root_file_test_size <= MM_MAXFILESIZE_ROOT))  $RootFile="$root_file$ATLAS_id$space$root_file_test_name";
	  else $RootFile='';
	  
	  if(!empty($root_file_test_old) && empty($root_file_test_name)) $RootFile=$root_file_test_old;
	  
	  

	  $queryMain = "INSERT INTO Module_Reception_Test_Geneva (id_module_A,id_module_B,id_module_C,name_user,surname_user,email_user,date,location,b_a_TH,module_type,stave_number,stave_side,module_position,leakage_current_at_op_voltage,break_down_voltage,mean_threshold_scan,sigma_threshold_scan,sigma_noise_thr_scan,optical_inspection,electrical_test,IV_test,digital_test, analog_test,threshold_scan,x_talk,notes_on_the_test,optical_inspection_picture_a,optical_inspection_picture_b,optical_inspection_picture_c,optical_inspection_picture_d,optical_inspection_picture_e,root_file_test,ATLAS_id, board_type)  VALUE  ('$id_module_A','$id_module_B','$id_module_C','$name_user','$surname_user','$email_user',NOW(),'$location','$b_a_TH','$module_type','$stave_number','$stave_side','$module_position','$leakage_current_at_op_voltage','$break_down_voltage','$mean_threshold_scan','$sigma_threshold_scan','$sigma_noise_thr_scan','$optical_inspection','$electrical_test','$IV_test','$digital_test','$analog_test','$threshold_scan','$x_talk','$notes_on_the_test','$PictureA','$PictureB','$PictureC','$PictureD','$PictureE','$RootFile','$ATLAS_id','$board_type')";

	  //echo $queryMain;	  
	 

	$result=mysqli_query($dbc, $queryMain);

        // Confirm success with the user
        if($result){

	  ////files upload
	  if (!empty($optical_inspection_picture_a_name)) 
	    { echo $optical_inspection_picture_a_type;
	      if ((($optical_inspection_picture_a_type == 'application/pdf') || ($optical_inspection_picture_a_type == 'image/jpeg') || ($optical_inspection_picture_a_type == 'image/gif') ||
		   ($optical_inspection_picture_a_type == 'image/png')) && ($optical_inspection_picture_a_size > 0) && ($optical_inspection_picture_a_size <= MM_MAXFILESIZE_IMAGES) /*&&
																						       ($optical_inspection_picture_a_width <= MM_MAXIMGWIDTH) && ($optical_inspection_picture_a_height <= MM_MAXIMGHEIGHT)*/) {
		if ($_FILES['file']['error'] == 0) {
		  // Move the file to the target upload folder
		  $NewFileName_pictureA="$pictureA$ATLAS_id$space$optical_inspection_picture_a_name";
		  $target = MM_UPLOADPATH_IMAGES . basename($NewFileName_pictureA);
		  if (move_uploaded_file($_FILES['optical_inspection_picture_a_new']['tmp_name'], $target)) {
		    // The new DS file move was successful, now make sure any old DS is deleted
		    if (!empty($old_DS) && ($old_DS != $optical_inspection_picture_a_name)) {
		      @unlink(MM_UPLOADPATH_IMAGES . $old_DS);
		    }
		  }
		  else {
		    // The new DS file move failed, so delete the temporary file and set the error flag
		    @unlink($_FILES['optical_inspection_picture_a_new']['tmp_name']);
		    $error = true;
		    echo '<p class="error">Sorry, there was a problem uploading your DS.</p>';
		  }
		}
	      }
	      else {
		// The new DS file is not valid, so delete the temporary file and set the error flag
		@unlink($_FILES['optical_inspection_picture_a_new']['tmp_name']);
		$error = true;
		echo '<p class="error">Your DS must be a PDF, GIF, JPEG, or PNG image file no greater than ' . (MM_MAXFILESIZE_IMAGES / 1024) .
		  ' KB and '.$optical_inspection_picture_a_type.'.</p>';
	      }
	    }
	  
	  // picture b
	  
	  if (!empty($optical_inspection_picture_b_name)) 
	    {
	      if ((($optical_inspection_picture_b_type == 'application/pdf') || ($optical_inspection_picture_b_type == 'image/jpeg') || ($optical_inspection_picture_b_type == 'image/gif') ||
		   ($optical_inspection_picture_b_type == 'image/png')) && ($optical_inspection_picture_b_size > 0) && ($optical_inspection_picture_b_size <= MM_MAXFILESIZE_IMAGES) /*&&
																						       ($optical_inspection_picture_b_width <= MM_MAXIMGWIDTH) && ($optical_inspection_picture_b_height <= MM_MAXIMGHEIGHT)*/) {
		if ($_FILES['file']['error'] == 0) {
		  // Move the file to the target upload folder
		  $NewFileName_pictureB="$pictureB$ATLAS_id$space$optical_inspection_picture_b_name";
		  $target = MM_UPLOADPATH_IMAGES . basename($NewFileName_pictureB);
		  if (move_uploaded_file($_FILES['optical_inspection_picture_b_new']['tmp_name'], $target)) {
		    // The new DS file move was successful, now make sure any old DS is deleted
		    if (!empty($old_DS) && ($old_DS != $optical_inspection_picture_b_name)) {
		      @unlink(MM_UPLOADPATH_IMAGES . $old_DS);
		    }
		  }
		  else {
		    // The new DS file move failed, so delete the temporary file and set the error flag
		    @unlink($_FILES['optical_inspection_picture_b_new']['tmp_name']);
		    $error = true;
		    echo '<p class="error">Sorry, there was a problem uploading your DS.</p>';
		  }
		}
	      }
	      else {
		// The new DS file is not valid, so delete the temporary file and set the error flag
		@unlink($_FILES['optical_inspection_picture_b_new']['tmp_name']);
		$error = true;
		echo '<p class="error">Your DS must be a PDF, GIF, JPEG, or PNG image file no greater than ' . (MM_MAXFILESIZE_IMAGES / 1024) .
		  ' KB.</p>';
	      }
	    }
	  
	  //picture c
	  
	  if (!empty($optical_inspection_picture_c_name)) 
	    {
	      if ((($optical_inspection_picture_c_type == 'application/pdf') || ($optical_inspection_picture_c_type == 'image/jpeg') || ($optical_inspection_picture_c_type == 'image/gif') ||
		   ($optical_inspection_picture_c_type == 'image/png')) && ($optical_inspection_picture_c_size > 0) && ($optical_inspection_picture_c_size <= MM_MAXFILESIZE_IMAGES) /*&&
																						       ($optical_inspection_picture_c_width <= MM_MAXIMGWIDTH) && ($optical_inspection_picture_c_height <= MM_MAXIMGHEIGHT)*/) {
		if ($_FILES['file']['error'] == 0) {
		  // Move the file to the target upload folder
		  $NewFileName_pictureC="$pictureC$ATLAS_id$space$optical_inspection_picture_c_name";
		  $target = MM_UPLOADPATH_IMAGES . basename($NewFileName_pictureC);
		  if (move_uploaded_file($_FILES['optical_inspection_picture_c_new']['tmp_name'], $target)) {
		    // The new DS file move was successful, now make sure any old DS is deleted
		    if (!empty($old_DS) && ($old_DS != $optical_inspection_picture_c_name)) {
		      @unlink(MM_UPLOADPATH_IMAGES . $old_DS);
		    }
		  }
		  else {
		    // The new DS file move failed, so delete the temporary file and set the error flag
		    @unlink($_FILES['optical_inspection_picture_c_new']['tmp_name']);
		    $error = true;
		    echo '<p class="error">Sorry, there was a problem uploading your DS.</p>';
		  }
		}
	      }
	      else {
		// The new DS file is not valid, so delete the temporary file and set the error flag
		@unlink($_FILES['optical_inspection_picture_c_new']['tmp_name']);
		$error = true;
		echo '<p class="error">Your DS must be a PDF, GIF, JPEG, or PNG image file no greater than ' . (MM_MAXFILESIZE_IMAGES / 1024) .
		  ' KB.</p>';
	      }
	    }
	  
          //picture d                                                                                                                                                                            

          if (!empty($optical_inspection_picture_d_name))
            {
              if ((($optical_inspection_picture_d_type == 'application/pdf') || ($optical_inspection_picture_d_type == 'image/jpeg') || ($optical_inspection_picture_d_type == 'image/gif') ||
                   ($optical_inspection_picture_d_type == 'image/png')) && ($optical_inspection_picture_d_size > 0) && ($optical_inspection_picture_d_size <= MM_MAXFILESIZE_IMAGES) /*&&        
                                                                                                                                                                                       ($optical\
																						       _inspection_picture_d_width <= MM_MAXIMGWIDTH) && ($optical_inspection_picture_d_height <= MM_MAXIMGHEIGHT)*/) {
                if ($_FILES['file']['error'] == 0) {
                  // Move the file to the target upload folder                                                                                                                                   
                  $NewFileName_pictureD="$pictureD$ATLAS_id$space$optical_inspection_picture_d_name";
                  $target = MM_UPLOADPATH_IMAGES . basename($NewFileName_pictureD);
                  if (move_uploaded_file($_FILES['optical_inspection_picture_d_new']['tmp_name'], $target)) {
                    // The new DS file move was successful, now make sure any old DS is deleted                                                                                                  
                    if (!empty($old_DS) && ($old_DS != $optical_inspection_picture_d_name)) {
                      @unlink(MM_UPLOADPATH_IMAGES . $old_DS);
                    }
                  }
                  else {
                    // The new DS file move failed, so delete the temporary file and set the error flag                                                                                          
                    @unlink($_FILES['optical_inspection_picture_d_new']['tmp_name']);
                    $error = true;
                    echo '<p class="error">Sorry, there was a problem uploading your DS.</p>';
                  }
                }
              }
              else {
                // The new DS file is not valid, so delete the temporary file and set the error flag                                                                                             
                @unlink($_FILES['optical_inspection_picture_d_new']['tmp_name']);
                $error = true;
                echo '<p class="error">Your DS must be a PDF, GIF, JPEG, or PNG image file no greater than ' . (MM_MAXFILESIZE_IMAGES / 1024) .
                  ' KB.</p>';
              }
            }



          //picture e                                                                                                                                                                            

          if (!empty($optical_inspection_picture_e_name))
            {
              if ((($optical_inspection_picture_e_type == 'application/pdf') || ($optical_inspection_picture_e_type == 'image/jpeg') || ($optical_inspection_picture_e_type == 'image/gif') ||
                   ($optical_inspection_picture_e_type == 'image/png')) && ($optical_inspection_picture_e_size > 0) && ($optical_inspection_picture_e_size <= MM_MAXFILESIZE_IMAGES)) 
		{
                if ($_FILES['file']['error'] == 0) {
                  // Move the file to the target upload folder                                                                                                                                   
                  $NewFileName_pictureE="$pictureE$ATLAS_id$space$optical_inspection_picture_e_name";
                  $target = MM_UPLOADPATH_IMAGES . basename($NewFileName_pictureE);
                  if (move_uploaded_file($_FILES['optical_inspection_picture_e_new']['tmp_name'], $target)) {
                    // The new DS file move was successful, now make sure any old DS is deleted                                                                                                  
                    if (!empty($old_DS) && ($old_DS != $optical_inspection_picture_e_name)) {
                      @unlink(MM_UPLOADPATH_IMAGES . $old_DS);
                    }
                  }
                  else {
                    // The new DS file move failed, so delete the temporary file and set the error flag                                                                                          
                    @unlink($_FILES['optical_inspection_picture_e_new']['tmp_name']);
                    $error = true;
                    echo '<p class="error">Sorry, there was a problem uploading your DS.</p>';
                  }
                }
              }
              else {
                // The new DS file is not valid, so delete the temporary file and set the error flag                                                                                             
                @unlink($_FILES['optical_inspection_picture_e_new']['tmp_name']);
                $error = true;
                echo '<p class="error">Your DS must be a PDF, GIF, JPEG, or PNG image file no greater than ' . (MM_MAXFILESIZE_IMAGES / 1024) .
                  ' KB.</p>';
              }
            }


	  //root file test
	  
	  if (!empty($root_file_test_name)) 
	    {
	      if (($root_file_test_type == 'application/octet-stream')  && ($root_file_test_size > 0) && ($root_file_test_size <= MM_MAXFILESIZE_ROOT) /*&&
																			 ($root_file_test_width <= MM_MAXIMGWIDTH) && ($root_file_test_height <= MM_MAXIMGHEIGHT)*/) {
		if ($_FILES['file']['error'] == 0) {
		  // Move the file to the target upload folder
		  $NewFileName_root="$root_file$ATLAS_id$space$root_file_test_name";
		  $target = MM_UPLOADPATH_ROOT . basename($NewFileName_root);
		  if (move_uploaded_file($_FILES['root_file_test_new']['tmp_name'], $target)) {
		    // The new DS file move was successful, now make sure any old DS is deleted
		    if (!empty($old_DS) && ($old_DS != $root_file_test_name)) {
		      @unlink(MM_UPLOADPATH_ROOT . $old_DS);
		    }
		  }
		  else {
		    // The new DS file move failed, so delete the temporary file and set the error flag
		    @unlink($_FILES['root_file_test_new']['tmp_name']);
		    $error = true;
		    echo '<p class="error">Sorry, there was a problem uploading your DS.</p>';
		  }
		}
	      }
	      else {
		// The new DS file is not valid, so delete the temporary file and set the error flag
		@unlink($_FILES['root_file_test_new']['tmp_name']);
		$error = true;
		echo '<p class="error">Your DS must be a ROOTFILE file no greater than ' . (MM_MAXFILESIZE_ROOT / 1024) .
		  ' KB.</p>';
	      }
	    }
	  
	  
	  
	  
	  echo '<p>This module has been successfully updated. Would you like to <a href="viewTable_Geneva_Module_Reception_Test.php">view the data</a>?</p>';
	  echo '<p>Or would you like to <a href="Geneva_Module_ReceptionTest_Def.php">insert a new module</a>?</p>';
	}
	else{
	  echo 'DB Error';
 	}

        mysqli_close($dbc);
        //exit();
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
      $name_user = $row['first_name'];
      $surname_user = $row['last_name'];
      $email_user = $row['email'];
     }
    else {
      echo '<p class="error">There was a problem accessing your profile.</p>';
    }

    //echo " . $_GET['ATLAS_id'] . ";

    if(!empty($_GET['ATLAS_id'])) 
    {
	$query_old = "SELECT * FROM Module_Reception_Test_Geneva WHERE ATLAS_id = '" . $_GET['ATLAS_id'] . "' AND id= '" . $_GET['id'] . "'";
	$data_old = mysqli_query($dbc, $query_old);
	$row_old = mysqli_fetch_array($data_old);
      
      if ($row_old != NULL) {
	$id_module_A=$row_old['id_module_A'];
	$id_module_B=$row_old['id_module_B'];
	$id_module_C=$row_old['id_module_C'];
	$location=$row_old['location'];       
	$b_a_TH=$row_old['b_a_TH'];         
	$module_type=$row_old['module_type'];    
	$stave_number=$row_old['stave_number'];   
	$stave_side=$row_old['stave_side'];     
	$module_position=$row_old['module_position'];  
	//$VDDA_7=$row_old['VDDA_7'];         
	//$VDDA_6=$row_old['VDDA_6'];         
	//$VDDD_7=$row_old['VDDD_7'];         
	//$VDDD_6=$row_old['VDDD_6'];         
	$leakage_current_at_op_voltage=$row_old['leakage_current_at_op_voltage'];   
	$break_down_voltage=$row_old['break_down_voltage'];              
	$mean_threshold_scan=$row_old['mean_threshold_scan'];             
	$sigma_threshold_scan=$row_old['sigma_threshold_scan'];            
	$sigma_noise_thr_scan=$row_old['sigma_noise_thr_scan'];            
	$optical_inspection=$row_old['optical_inspection'];              
	$electrical_test=$row_old['electrical_test'];                 
	$IV_test=$row_old['IV_test'];                         
	$digital_test=$row_old['digital_test'];                    
	$analog_test=$row_old['analog_test'];                     
	$threshold_scan=$row_old['threshold_scan'];                  
	$x_talk=$row_old['x_talk'];                          
	//$amount_of_disc_ch_after_xtalk=$row_old['amount_of_disc_ch_after_xtalk'];   
	//$rework=$row_old['rework'];                       
	//$shipped_back=$row_old['shipped_back'];                 
	//$reworked=$row_old['reworked'];                     
	$notes_on_the_test=$row_old['notes_on_the_test'];            
	$optical_inspection_picture_a_old=$row_old['optical_inspection_picture_a']; 
	$optical_inspection_picture_b_old=$row_old['optical_inspection_picture_b']; 
	$optical_inspection_picture_c_old=$row_old['optical_inspection_picture_c']; 
	$optical_inspection_picture_d_old=$row_old['optical_inspection_picture_d'];
        $optical_inspection_picture_e_old=$row_old['optical_inspection_picture_e'];
	$root_file_test_old=$row_old['root_file_test'];
          $board_type=$row_old['board_type'];
	
      }
      else {
	echo '<p class="error">There was a problem accessing your profile.</p>';
      }
  }


    
  }

mysqli_close($dbc);
?>

<form enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MM_MAXFILESIZE; ?>" />

//STARTING FTK MESS

    <fieldset><legend>Module Informations </legend>
      <fieldset><legend>Information of the test</legend>
     
      <label for="name_user">First name:</label>
      <?php  if (!empty($name_user)) echo $name_user; ?>
      <input type="hidden" id="name_user" name="name_user" value="<?php if (!empty($name_user)) echo $name_user; ?>" /><br />
      <label for="surname_user">Last name:</label>
      <?php if (!empty($surname_user)) echo $surname_user; ?>
      <input type="hidden" id="surname_user" name="surname_user" value="<?php if (!empty($surname_user)) echo $surname_user; ?>" /><br />
      <label for="email_user">E-mail:</label>
      <?php if (!empty($email_user)) echo $email_user; ?>
      <input type="hidden" id="email_user" name="email_user" value="<?php if (!empty($email_user)) echo $email_user; ?>" /><br />
      <label for="Module_ID">Module ID:</label>
      <input type="text" name="id_module_A" maxlenght="2" size="2" value="<?php if (!empty($id_module_A)) echo $id_module_A; ?>"/> - <input type="text" name="id_module_B" maxlenght="2" size="2" value="<?php if (!empty($id_module_B)) echo $id_module_B; ?>" /> - <input type="text" name="id_module_C"   size="2" maxlenght="2" value="<?php if (!empty($id_module_C)) echo $id_module_C; ?>" />
      <br />
      <label for="module_type">Module Technology:</label>
      <input type="radio" name="module_type" value="Planar" <?php if (!empty($module_type) && $module_type == 'Planar') echo 'checked="checked"'; ?> /> Planar 
      <input type="radio" name="module_type" value="3D" <?php if (!empty($module_type) && $module_type == '3D') echo 'checked="checked"'; ?>/> 3D <br />
      <label for="b_a_TH">Thermal Test:</label>
      <input type="radio" name="b_a_TH" value="2" <?php if (!empty($b_a_TH) && $b_a_TH == '2') echo 'checked="checked"'; ?>/> Yes 
      <input type="radio" name="b_a_TH" value="1" <?php if (!empty($b_a_TH) && $b_a_TH == '1') echo 'checked="checked"'; ?>/> No
      <br />

      </fieldset>

    <fieldset><legend> FTK Stuff </legend>
    <label for="board_type">Board type:</label>
    <input type="text" maxlenght="20"  name="board_type" value="<?php if (!empty($board_type)) echo $board_type; ?>" /><br />
    </fieldset>
    </fieldset>

      <!--
      <fieldset><legend>Elettrical Info</legend>
      <label for="VDDA_7">VDDA_7:</label>
      <input type="text" name="VDDA_7" size="5" value="<?php if (!empty($VDDA_7)) echo $VDDA_7; ?>"/> <br /> 
      <label for="VDDA_6">VDDA_6:</label>
      <input type="text" name="VDDA_6" size="5" value="<?php if (!empty($VDDA_6)) echo $VDDA_6; ?>"/> <br />
      <label for="VDDD_7">VDDD_7:</label>
      <input type="text" name="VDDD_7" size="5" value="<?php if (!empty($VDDD_7)) echo $VDDD_7; ?>"/> <br /> 
      <label for="VDDD_6">VDDD_6:</label>
      <input type="text" name="VDDD_6" size="5" value="<?php if (!empty($VDDD_6)) echo $VDDD_6; ?>"/> <br />
      </fieldset>
      -->

      <fieldset><legend>IV Test</legend>
      <label for="leakage_current_at_op_voltage">Leakage current at operation voltage:</label>
      <input type="text" name="leakage_current_at_op_voltage" size="5" value="<?php if (!empty($leakage_current_at_op_voltage)) echo $leakage_current_at_op_voltage; ?>"/> <br /> 
      <label for="break_down_voltage">Break down voltage:</label>
      <input type="text" name="break_down_voltage" size="5" value="<?php if (!empty($break_down_voltage)) echo $break_down_voltage; ?>"/> <br />
      </fieldset>
      
      <fieldset><legend>Threshold Scan</legend>
      <label for="threshold_scan_form">Threshold Scan:</label>
      <input type="text" name="mean_threshold_scan" size="5" value="<?php if (!empty($mean_threshold_scan)) echo $mean_threshold_scan; ?>"/> Mean    
      <input type="text" name="sigma_threshold_scan" size="5" value="<?php if (!empty($sigma_threshold_scan)) echo $sigma_threshold_scan; ?>" /> Dispersion <br />
      <label for="sigma_noise_thr_scan">Sigma noise threshold scan:</label>
      <input type="text" name="sigma_noise_thr_scan" size="5" value="<?php if (!empty($sigma_noise_thr_scan)) echo $sigma_noise_thr_scan; ?>"/> <br />
      </fieldset>
      
      <fieldset><legend>Summary of the test</legend>
      <label for="optical_inspection">Optical Inspection:</label>
      <input type="radio" name="optical_inspection" value="2" <?php if (!empty($optical_inspection) && $optical_inspection == '2') echo 'checked="checked"'; ?>/> Passed 
      <input type="radio" name="optical_inspection" value="1" <?php if (!empty($optical_inspection) && $optical_inspection == '1') echo 'checked="checked"'; ?>/> Failed  <br /> <br />
      <label for="electrical_test">Electrical Test:</label>
      <input type="radio" name="electrical_test" value="2" <?php if (!empty($electrical_test) && $electrical_test == '2') echo 'checked="checked"'; ?>/> Passed 
      <input type="radio" name="electrical_test" value="1" <?php if (!empty($electrical_test) && $electrical_test == '1') echo 'checked="checked"'; ?>/> Failed  <br /> <br />
      <label for="IV_test">IV Test:</label>
      <input type="radio" name="IV_test" value="2" <?php if (!empty($IV_test) && $IV_test == '2') echo 'checked="checked"'; ?>/> Passed 
      <input type="radio" name="IV_test" value="1" <?php if (!empty($IV_test) && $IV_test == '1') echo 'checked="checked"'; ?>/> Failed  <br /> <br />
      <label for="digital_test">Digital Test:</label>
      <input type="radio" name="digital_test" value="2" <?php if (!empty($digital_test) && $digital_test == '2') echo 'checked="checked"'; ?>/> Passed 
      <input type="radio" name="digital_test" value="1" <?php if (!empty($digital_test) && $digital_test == '1') echo 'checked="checked"'; ?>/> Failed  <br /> <br />
      <label for="analog_test">Analog Test:</label>
      <input type="radio" name="analog_test" value="2" <?php if (!empty($analog_test) && $analog_test == '2') echo 'checked="checked"'; ?>/> Passed 
      <input type="radio" name="analog_test" value="1" <?php if (!empty($analog_test) && $analog_test == '1') echo 'checked="checked"'; ?>/> Failed  <br /> <br />
      <label for="threshold_scan_button">Threshold Scan:</label>
      <input type="radio" name="threshold_scan_button" value="2" <?php if (!empty($threshold_scan) && $threshold_scan == '2') echo 'checked="checked"'; ?>/> Passed 
      <input type="radio" name="threshold_scan_button" value="1" <?php if (!empty($threshold_scan) && $threshold_scan == '1') echo 'checked="checked"'; ?>/> Failed  <br /> <br />
      <fieldset>
      <label for="x_talk">X-Talk:</label>
      <input type="radio" name="x_talk" value="2" <?php if (!empty($x_talk) && $x_talk == '2') echo 'checked="checked"'; ?>/> Passed 
      <input type="radio" name="x_talk" value="1" <?php if (!empty($x_talk) && $x_talk == '1') echo 'checked="checked"'; ?>/> Failed  <br />
      <!--<label for="amount_of_disc_ch_after_xtalk">Discounted channels after th X-Talk:</label>
      <input type="text" name="amount_of_disc_ch_after_xtalk" size="5" value="<?php if (!empty($amount_of_disc_ch_after_xtalk)) echo $amount_of_disc_ch_after_xtalk; ?>"/>  <br /> --> 
      </fieldset>
      <!--
      <fieldset><legend>If module reception is failed</legend>
      <label for="rework">Rework Notes:</label>
      <input type="text" name="rework" size="100" value="<?php if (!empty($rework)) echo $rework; ?>"/>  <br />  
      <label for="shipped_back">Shipped Back:</label>
      <input type="radio" name="shipped_back" value="2" <?php if (!empty($shipped_back) && $shipped_back == '2') echo 'checked="checked"'; ?>/> Yes 
      <input type="radio" name="shipped_back" value="1" <?php if (!empty($shipped_back) && $shipped_back == '1') echo 'checked="checked"'; ?>/> No  <br />
      <label for="reworked">Reworked:</label>
      <input type="radio" name="reworked" value="2"  <?php if (!empty($reworked) && $reworked == '2') echo 'checked="checked"'; ?>/> Yes 
      <input type="radio" name="reworked" value="1"  <?php if (!empty($reworked) && $reworked == '1') echo 'checked="checked"'; ?>/> No  <br />
      </fieldset>-->
      <br />
      <label for="notes_on_the_test">Notes:</label>
      <input type="text" name="notes_on_the_test" size="100" value="<?php if (!empty($notes_on_the_test)) echo $notes_on_the_test; ?>"/>  <br />

 

      </fieldset>

      <fieldset><legend>Files</legend>
      <fieldset><legend>For the Optical Inspection only *.png, *.gif, *.pdf or *.jpg files are allowed with max size 3 MB (Don't use too many digts for your image name<!--and don't insert "_" caracter-->)</legend>
      <label for="optical_inspection_picture_a">Optical Inspection Picture A:</label>
      <input type="file" id="optical_inspection_picture_a_new" name="optical_inspection_picture_a_new" value="<?php if (!empty($optical_inspection_picture_a_old)) echo $optical_inspection_picture_a_old; ?>"/> Previous Picture: <?php if (!empty($optical_inspection_picture_a_old)) echo "<A HREF=".MM_SERVERPATH_IMAGES."".$optical_inspection_picture_a_old.">" . $optical_inspection_picture_a_old."</A>" ?> <br />
      <input type="hidden" id="optical_inspection_picture_a_old" name="optical_inspection_picture_a_old" value="<?php if (!empty($optical_inspection_picture_a_old)) echo $optical_inspection_picture_a_old; ?>" />
      <label for="optical_inspection_picture_b">Optical Inspection Picture B:</label>
      <input type="file" id="optical_inspection_picture_b_new" name="optical_inspection_picture_b_new" value="<?php if (!empty($optical_inspection_picture_b_old)) echo $optical_inspection_picture_b_old; ?>"/> Previous Picture: <?php if (!empty($optical_inspection_picture_b_old)) echo "<A HREF=".MM_SERVERPATH_IMAGES."".$optical_inspection_picture_b_old.">" . $optical_inspection_picture_b_old."</A>" ?>  <br />
       <input type="hidden" id="optical_inspection_picture_b_old" name="optical_inspection_picture_b_old" value="<?php if (!empty($optical_inspection_picture_b_old)) echo $optical_inspection_picture_b_old; ?>" />
      <label for="optical_inspection_picture_c">Optical Inspection Picture C:</label>
      <input type="file" id="optical_inspection_picture_c_new" name="optical_inspection_picture_c_new" value="<?php if (!empty($optical_inspection_picture_c_old)) echo $optical_inspection_picture_c_old; ?>"/> Previous Picture: <?php if (!empty($optical_inspection_picture_c_old)) echo "<A HREF=".MM_SERVERPATH_IMAGES."".$optical_inspection_picture_c_old.">" . $optical_inspection_picture_c_old."</A>" ?>  <br />
      <input type="hidden" id="optical_inspection_picture_c_old" name="optical_inspection_picture_c_old" value="<?php if (!empty($optical_inspection_picture_c_old)) echo $optical_inspection_picture_c_old; ?>" />
      <label for="optical_inspection_picture_d">Optical Inspection Picture D:</label>   
      <input type="file" id="optical_inspection_picture_d_new" name="optical_inspection_picture_d_new" value="<?php if (!empty($optical_inspection_picture_d_old)) echo $optical_inspection_picture_d_old; ?>"/> Previous Picture: <?php if (!empty($optical_inspection_picture_d_old)) echo "<A HREF=".MM_SERVERPATH_IMAGES."".$optical_inspection_picture_d_old.">" . $optical_inspection_picture_d_old."</A>" ?>  <br />                                                                                                                                                             <input type="hidden" id="optical_inspection_picture_d_old" name="optical_inspection_picture_d_old" value="<?php if (!empty($optical_inspection_picture_d_old)) echo $optical_inspection_picture_d_old; ?>" />                   
      <label for="optical_inspection_picture_e">Optical Inspection Picture E:</label>      
      <input type="file" id="optical_inspection_picture_e_new" name="optical_inspection_picture_e_new" value="<?php if (!empty($optical_inspection_picture_e_old)) echo $optical_inspection_picture_e_old; ?>" /> Previous Picture: <?php if (!empty($optical_inspection_picture_e_old)) echo "<A HREF=".MM_SERVERPATH_IMAGES."".$optical_inspection_picture_e_old.">" . $optical_inspection_picture_e_old."</A>"  ?>  <br />          
      <input type="hidden" id="optical_inspection_picture_e_old" name="optical_inspection_picture_e_old" value="<?php if (!empty($optical_inspection_picture_e_old)) echo $optical_inspection_picture_e_old; ?>" />
      </fieldset>
      <fieldset><legend> For the Root File the max size is 5 MB <!--(Don't insert "_" caracter)--></legend>
      <label for="root_file_test">Root File:</label>
      <input type="file" id="root_file_test_new" name="root_file_test_new" value="<?php if (!empty($root_file_test_old)) echo $root_file_test_old; ?>"/> Previous RootFile: <?php if (!empty($root_file_test_old)) echo "<A HREF=".MM_SERVERPATH_ROOT."".$root_file_test_old.">" . $root_file_test_old."</A>" ?>  <br />
      <input type="hidden" id="root_file_test_old" name="root_file_test_old" value="<?php if (!empty($root_file_test_old)) echo $root_file_test_old; ?>" />
      </fieldset>
      </fieldset>

      <br />
      
      <fieldset><legend>Module Position (Optional Field)</legend>
      <label for="module_installed">Module Installed:</label>
      <input type="radio" name="module_installed" value="2" <?php if (!empty($stave_number)) echo 'checked="checked"'; ?>/> Yes 
      <input type="radio" name="module_installed" value="1" <?php if (empty($stave_number)) echo 'checked="checked"'; ?>/> No  <br />
      <label for="stave_number">Stave Number:</label>
      <select name="stave_number" id="stave_number">

           <option value="1"<?php if (!empty($stave_number) && $stave_number == '1') echo 'selected = "selected"'; ?>>0</option>
	   <option value="2"<?php if (!empty($stave_number) && $stave_number == '2') echo 'selected = "selected"'; ?>>1</option> 
	   <option value="3"<?php if (!empty($stave_number) && $stave_number == '3') echo 'selected = "selected"'; ?>>2</option>
	   <option value="4"<?php if (!empty($stave_number) && $stave_number == '4') echo 'selected = "selected"'; ?>>3</option>
	   <option value="5"<?php if (!empty($stave_number) && $stave_number == '5') echo 'selected = "selected"'; ?>>4</option>
	   <option value="6"<?php if (!empty($stave_number) && $stave_number == '6') echo 'selected = "selected"'; ?>>5</option>
	   <option value="7"<?php if (!empty($stave_number) && $stave_number == '7') echo 'selected = "selected"'; ?>>6</option>
	   <option value="8"<?php if (!empty($stave_number) && $stave_number == '8') echo 'selected = "selected"'; ?>>7</option>
	   <option value="9"<?php if (!empty($stave_number) && $stave_number == '9') echo 'selected = "selected"'; ?>>8</option>
	   <option value="10"<?php if (!empty($stave_number) && $stave_number == '10') echo 'selected = "selected"'; ?>>9</option>
	   <option value="11"<?php if (!empty($stave_number) && $stave_number == '11') echo 'selected = "selected"'; ?>>10</option>
	   <option value="12"<?php if (!empty($stave_number) && $stave_number == '12') echo 'selected = "selected"'; ?>>11</option>
	   <option value="13"<?php if (!empty($stave_number) && $stave_number == '13') echo 'selected = "selected"'; ?>>12</option>
	   <option value="14"<?php if (!empty($stave_number) && $stave_number == '14') echo 'selected = "selected"'; ?>>13</option>


      </select>
	 <br />
      
      <label for="stave_side">Stave Side:</label>
      <select name="stave_side"  id="stave_side">

        <option value="A"<?php if (!empty($stave_side) && $stave_side == 'A') echo 'selected = "selected"'; ?>>A</option>
        <option value="C"<?php if (!empty($stave_side) && $stave_side == 'C') echo 'selected = "selected"'; ?>>C</option>

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

      </fieldset>
      

      
      

<br />

     <!-- 
      <label for="module_position">Module Status:</label>
      <select name="status" id="status"  multiple="multiple" size="3">
      <option value="ACCEPTED"<?php if (!empty($status) && $status == 'ACCEPTED') echo 'selected = "selected"'; ?>>ACCEPTED</option>
      <option value="REJECTED"<?php if (!empty($status) && $status == 'REJECTED') echo 'selected = "selected"'; ?>>REJECTED</option>
      <option value="PENDING"<?php if (!empty($status) && $status == 'PENDING') echo 'selected = "selected"'; ?>>PENDING</option> 
      </select> <br />



      

      <label for="new_DS">Datasheet:</label>
         <input type="file" id="new_DS" name="new_DS" />
        

-->


      
    </fieldset>
    <input type="submit" value="Save Module" name="submit" />
  </form>
</body> 
</html>
