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
  <title>IBL Production Database Interface - View Boad Data</title>
  <link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
  <h3>IBL Production Database Interface - View Board Data</h3>
  <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
<?php
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

  // Grab the profile data from the database
  if (!isset($_GET['user_id'])) {
    $query = "SELECT * FROM FTK_parts WHERE 1";//user_id = '" . $_SESSION['user_id'] . "'";
  }
  else {
    $query = "SELECT * FROM FTK_parts WHERE 1";//user_id = '" . $_GET['user_id'] . "'";
  }
  $data = mysqli_query($dbc, $query);

  //if (mysqli_num_rows($data) > 0) {
    // The user row was found so display the user data
    
    if (isset($_POST['submit'])) {
    foreach ($_POST['todelete'] as $delete_id) {
      $query = "DELETE FROM FTK_parts WHERE id = $delete_id";
      //echo $query;
      //echo '<br />';
      
      mysqli_query($dbc, $query)
        or die('Error querying database.');
    } 
    
    echo 'Module(s) removed.<br />';
    }

echo '<table width="100%" border="1" valign="top"
   cellspacing="0">';
if($_SESSION['username']==ADMIN || $_SESSION['username']==ADMIN2)
  { 
    echo 'strange mode';
    
  }
 else
   {
     
//echo '<tr><td><input type="checkbox" value="' . $row['id'] . '" name="todelete[]" /></td>';
    //echo '<td> ' . $row['id_module_A']."</td>";
     //echo '<tr><td><A HREF="FTK_Board_reception2_def.php?id='. $row['id']. ' "> '. $row['id']."</A></td>";
   // echo '<tr><td><A HREF="FTK_Board_reception2_def.php?id='.$row['id']'</A></td>";
    // echo '<tr><td><A HREF="FTK_Board_receptionTest_def.php?ATLAS_id='. $row['ATLAS_id'].'&id='. $row['id'] . '">'. $row['ATLAS_id']."</A></td>";
    
    
     echo '<td> General ID </td>';
     echo '<td> Board Type</td>';
     echo '<td> Board ID </td>';
     echo '<td> Location </td>';
     echo '<td> Instalation status </td>';
     echo '<td> Time update </td></tr>';
    
     
     
   }
while ($row = mysqli_fetch_array($data)) {
  if($_SESSION['username']==ADMIN || $_SESSION['username']==ADMIN2){ 
    echo '<tr><td><input type="checkbox" value="' . $row['id'] . '" name="todelete[]" /></td>';
    //echo '<td> ' . $row['id_module_A']."</td>";
   // echo '<td><A HREF="FTK_Board_receptionTest_def.php?ATLAS_id='. $row['ATLAS_id'].'&id='. $row['id'] . '">'. $row['ATLAS_id']."</A></td>";
       echo '<tr><td><A HREF="FTK_Board_reception2_def.php?id='. $row['id']. '">'. $row['id']."</A></td>";
     }
  else{
      
    //echo $row['id'];
    
    //echo '<tr><td> ' . $row['id_module_A']."</td>";
   // echo '<tr><td><A HREF="FTK_Board_receptionTest_def.php?ATLAS_id='. $row['ATLAS_id'].'&id='. $row['id'] . '">'. $row['ATLAS_id']."</A></td>";
  }
  //echo $row['id'];
 echo '<tr><td><A HREF="FTK_Board_reception2_def.php?id='. $row['id']. '">'. $row['id']."</A></td>"; // now this is correct 
 // echo '<tr><td> ' . $row['id']."</td>";
  echo '<td> ' .$row['board_type']."</td>";
  echo '<td> ' . $row['board_id']."</td>";
  echo '<td> ' . $row['location']."</td>";
  echo '<td> ' . $row['inst_status']."</td>";
  echo '<td> ' . $row['time_update']."</td></tr>";   
  /*echo '<td> ' . $row['surname_user']."</td>";
  echo '<td> ' . $row['email_user']."</td>";  
  echo '<td> ' . $row['date']."</td>"; 
  echo '<td> ' . $row['location']."</td>";
  $def=$row['b_a_TH']-1;    
  echo '<td> ' . $def."</td>";
  echo '<td> ' . $row['module_type']."</td>";    
  $def=$row['stave_number']-1; 
  echo '<td> ' . $def."</td>";
  echo '<td> ' . $row['stave_side']."</td>";     
  $def=$row['module_position']-1; 
  echo '<td> ' . $def."</td>";
  //echo '<td> ' . $row['VDDA_7']."</td>";         
  //echo '<td> ' . $row['VDDA_6']."</td>";         
  //echo '<td> ' . $row['VDDD_7']."</td>";         
  //echo '<td> ' . $row['VDDD_6']."</td>";         
  echo '<td> ' . $row['leakage_current_at_op_voltage']."</td>";   
  echo '<td> ' . $row['break_down_voltage']."</td>";              
  echo '<td> ' . $row['mean_threshold_scan']."</td>";             
  echo '<td> ' . $row['sigma_threshold_scan']."</td>";            
  echo '<td> ' . $row['sigma_noise_thr_scan']."</td>";            
  $def=$row['optical_inspection']-1; 
  echo '<td> ' . $def."</td>";
  $def=$row['electrical_test']-1; 
  echo '<td> ' . $def."</td>";
  $def=$row['IV_test']-1; 
  echo '<td> ' . $def."</td>";
  $def=$row['digital_test']-1; 
  echo '<td> ' . $def."</td>";
  $def=$row['analog_test']-1; 
  echo '<td> ' . $def."</td>";
  $def=$row['threshold_scan']-1; 
  echo '<td> ' . $def."</td>";
  $def=$row['x_talk']-1; 
  echo '<td> ' . $def."</td>";
  //echo '<td> ' . $row['amount_of_disc_ch_after_xtalk']."</td>";   
  //echo '<td> ' . $row['rework']."</td>";                       
  //$def=$row['shipped_back']-1; 
  //echo '<td> ' . $def."</td>";
  //$def=$row['reworked']-1; 
  //echo '<td> ' . $def."</td>";
  echo '<td> ' . $row['notes_on_the_test']."</td>";    
  
  echo "<td>PicA: <A HREF=".MM_SERVERPATH_IMAGES."".$row['optical_inspection_picture_a'].">" . $row['optical_inspection_picture_a']."</A> <!--
<BR>PicB :<A HREF=".MM_SERVERPATH_IMAGES."".$row['optical_inspection_picture_b'].">" . $row['optical_inspection_picture_b']."</A>
<BR>PicC :<A HREF=".MM_SERVERPATH_IMAGES."".$row['optical_inspection_picture_c'].">" . $row['optical_inspection_picture_c']."</A>
<BR>PicD :<A HREF=".MM_SERVERPATH_IMAGES."".$row['optical_inspection_picture_d'].">" . $row['optical_inspection_picture_d']."</A>
<BR>PicE :<A HREF=".MM_SERVERPATH_IMAGES."".$row['optical_inspection_picture_e'].">" . $row['optical_inspection_picture_e']."</A>--></td>";
  echo "<td><A HREF=".MM_SERVERPATH_IMAGES."".$row['optical_inspection_picture_b'].">" . $row['optical_inspection_picture_b']."</A></td>";
  echo "<td><A HREF=".MM_SERVERPATH_IMAGES."".$row['optical_inspection_picture_c'].">" . $row['optical_inspection_picture_c']."</A></td>";
  echo "<td><A HREF=".MM_SERVERPATH_IMAGES."".$row['optical_inspection_picture_d'].">" . $row['optical_inspection_picture_d']."</A></td>";
  echo "<td><A HREF=".MM_SERVERPATH_IMAGES."".$row['optical_inspection_picture_e'].">" . $row['optical_inspection_picture_e']."</A></td>";
  echo "<td><A HREF=".MM_SERVERPATH_ROOT."".$row['root_file_test'].">" . $row['root_file_test']."</A></td></tr>";
  
  */
  //echo '<br />';
 }
echo "</table>\n";	





mysqli_close($dbc);
?>

<?php 

if($_SESSION['username']==ADMIN || $_SESSION['username']==ADMIN2){ 
  echo '<input type="submit" name="submit" value="Remove" />';
 }
 else{ 
   echo '<input type="hidden" name="submit" value="Remove" />';
     }
?>
</form> 

</body> 
</html>
