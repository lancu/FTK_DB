


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



<!-- connection to DB till here* -->

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>FTK Reception Test WORKING PROJECT </title>
  <link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
  <h3>FTK Reception Test - General Devices Data Insertion</h3>

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

//Getting user 
  
    $query = "SELECT first_name,last_name,email FROM mismatch_user WHERE user_id = '" . $_SESSION['user_id'] . "'";
    $data = mysqli_query($dbc, $query);
    $row = mysqli_fetch_array($data);

    if ($row != NULL) {
      $name_user = $row['first_name'];
      $surname_user = $row['last_name'];
      $email_user = $row['email'];
     }
//user getting done 


if (isset($_POST['submit_other'])) {
     
    // Grab the profile data from the POST
    $first_name = mysqli_real_escape_string($dbc, trim($_POST['name_user']));
    $surname_user = mysqli_real_escape_string($dbc, trim($_POST['surname_user']));
    $email_user = mysqli_real_escape_string($dbc, trim($_POST['email_user']));
     
    
     
     //ftk added 
    $com_type = mysqli_real_escape_string($dbc, trim($_POST['com_type']));
    
    $com_id=mysqli_real_escape_string($dbc, trim($_POST['com_id']));
    $location=mysqli_real_escape_string($dbc, trim($_POST['location']));
    $inst_status=mysqli_real_escape_string($dbc, trim($_POST['inst_status']));
    $cern_receival_date = mysqli_real_escape_string($dbc, trim($_POST['cern_receival_date']));
   
    $prod_date = mysqli_real_escape_string($dbc, trim($_POST['prod_date']));
    $rack = mysqli_real_escape_string($dbc, trim($_POST['rack']));
    $crate = mysqli_real_escape_string($dbc, trim($_POST['crate']));
    $slot = mysqli_real_escape_string($dbc, trim($_POST['slot']));
    $owner = mysqli_real_escape_string($dbc, trim($_POST['owner']));
    $last_user = mysqli_real_escape_string($dbc, trim($_POST['last_user']));

    $notes = mysqli_real_escape_string($dbc, trim($_POST['notes']));
   
   
     $status = mysqli_real_escape_string($dbc, trim($_POST['status']));
     $type_device = mysqli_real_escape_string($dbc, trim($_POST['type_device']));
    $firmware_version  = mysqli_real_escape_string($dbc, trim($_POST['firmware_version']));
    $serial_number = mysqli_real_escape_string($dbc, trim($_POST['serial_number']));
    
 

 
      if ($error) {
        echo $error ;
      }
     
    
    
     //here I need to add all values

 $queryMain = "INSERT INTO ftk_other (com_type, com_id, location, inst_status, cern_receival_date,prod_date,rack,crate,slot,owner,last_user,notes,status,type_device, firmware_version, serial_number) VALUE 
 ('$com_type ', '$com_id', '$location', '$inst_status', '$cern_receival_date','$prod_date','$rack','$crate','$slot','$owner','$email_user','$notes','$status', '$type_device', '$firmware_version','$serial_number') ON DUPLICATE KEY UPDATE location='$location', inst_status='$inst_status', cern_receival_date='$cern_receival_date',   prod_date='$prod_date', rack='$rack', crate='$crate', slot='$slot', owner='$owner', last_user='$email_user',  notes='$notes',   status = '$status', type_device='$type_device', firmware_version='$firmware_version', serial_number='$serial_number' "; 

$result = mysqli_query($dbc, $queryMain) ;//or trigger_error("Query Failed! SQL: $queryMain - Error: " . mysqli_error($dbc));
if (!$result) {
    die('Invalid query: ' . mysqli_error($dbc));
    //echo '<p>QUERY Invalid, board already  exists in DB, please update existing board or create a new  ENTRY </p>';
    /*print <?php . ' mysqli_error($dbc);' ?>;
    echo '<p> More detailed:' . mysqli_error($dbc)  '</p>';*/
 }
 
 } // end of if_POST

    
//Grab data from the DB 
//here I grab the data in order to print it on the screen. I need another area for filling the data back into the DB. 
// This will only retrieve the data from DB. 
if(!empty($_GET['id'])){ 
    
    //notempty L544 for GetID 
//id='5'; //comment this out
$query_old = "SELECT * FROM ftk_other WHERE id= '" . $_GET['id'] . "'";
    //$query_old = "SELECT * FROM Module_Reception_Test_Geneva WHERE ATLAS_id = '" . $_GET['ATLAS_id'] . "' AND id= '" . $_GET['id'] . "'";
//$query_old = "SELECT * FROM ftk_other WHERE id=  18";
$data_old = mysqli_query($dbc, $query_old);
$row_old = mysqli_fetch_array($data_old);


//echo $row_old;

  if ($row_old != NULL) {
	 $com_type = $row_old['com_type'];
     $com_id  = $row_old['com_id'];
     $location =  $row_old['location'];
      $inst_status =  $row_old['inst_status'];
      $cern_receival_date =  $row_old['cern_receival_date'];
     
      $prod_date =  $row_old['prod_date'];
      
       $rack = $row_old['rack'];
      $crate = $row_old['crate']; 
      $slot = $row_old['slot'];
       $owner = $row_old['owner'];
      $last_user = $row_old['last_user'];
      $notes = $row_old['notes'];
    
     
      $status   = $row_old['status'];
      $type_device   = $row_old['type_device'];
      $firmware_version   = $row_old['firmware_version'];
      $serial_number   = $row_old['serial_number'];
      
      
      
      }
      else {
	echo '<p class="error">There was a problem accessing your profile.</p>';
      }
}




mysqli_close($dbc);
?>
 
    
<!-- Printing the table 
 //STARTING FTK MESS
  --> 

<form enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
  <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MM_MAXFILESIZE; ?>"   


         <fieldset><legend><b>FTK entry Information</b> </legend><br />
    <fieldset><legend><b>Information on the user</b></legend>
     
      <label for="name_user">First name:</label>
      <?php  if (!empty($name_user)) echo $name_user; ?>
      <input type="hidden" id="name_user" name="name_user" value="<?php if (!empty($name_user)) echo $name_user; ?>" /><br />
      <label for="surname_user">Last name:</label>
      <?php if (!empty($surname_user)) echo $surname_user; ?>
      <input type="hidden" id="surname_user" name="surname_user" value="<?php if (!empty($surname_user)) echo $surname_user; ?>" /><br />
      <label for="email_user">E-mail:</label>
      <?php if (!empty($email_user)) echo $email_user; ?>
      <input type="hidden" id="email_user" name="email_user" value="<?php if (!empty($email_user)) echo $email_user; ?>" /><br />
          </fieldset>
    
        <br />
     

        <fieldset><legend><b> Device information</b> </legend>
            
     <label for="type_device">Device type:</label>
                <select name="type_device"  id="type_device">
                    <option value="Select">Select</option>
                <option value="Crate"<?php if (!empty($type_device) && $type_device == 'Crate') echo 'selected = "selected"'; ?>>Crate</option>
             <option value="PS"<?php if (!empty($type_device) && $type_device == 'PS') echo 'selected = "selected"'; ?>>PS</option>
             <option value="PC"<?php if (!empty($type_device) && $type_device == 'PC') echo 'selected = "selected"'; ?>>PC</option> 
            <option value="SBC"<?php if (!empty($type_device) && $type_device == 'SBC') echo 'selected = "selected"'; ?>>SBC</option>
             <option value="Switch"<?php if (!empty($type_device) && $type_device == 'Switch') echo 'selected = "selected"'; ?>>Switch</option> 
             <option value="Other"<?php if (!empty($type_device) && $type_device == 'Other') echo 'selected = "selected"'; ?>>Other</option>
                    
                    
            </select><br />
            
    <label for="com_type">Device:</label>
    <!--<input type="enum" size="10" maxlength="20"  name="com_type" value="<?php if (!empty($com_type)) echo $com_type; ?>" /><br />-->
         
      
            
  <!--     <select name="selType">
        <?php   foreach( $enumList2 as $value)
            echo "<option value=\"$value\" <?php if ($com_type==$value) {echo 'selected';}    ?>$value</option>"; ?>
           <option value="<?php if (!empty($com_type)) echo $com_type ; ?>"> <?php echo $com_type?> </option>
        </select> --> 
            
            
      <!--<input type="option"  name="com_type" value="<?php if (!empty($com_type)) echo $com_type ; ?>" /> :: [IM, DF, AUX, AMB, LAMB, SSB, SSB_RTM, DF_RTM, FLIC, FLIC_RTM]  <br \> -->   
            
            
            
             
     <select name="com_type"  id="com_type">
            <option value="Select">Select</option>
             <option value="VP717"<?php if (!empty($com_type) && $com_type == 'VP717') echo 'selected = "selected"'; ?>>VP717</option>
             <option value="ATCA-F125"<?php if (!empty($com_type) && $com_type == 'ATCA-F125') echo 'selected = "selected"'; ?>>ATCA-F125</option>
             <option value="ATCA-SM"<?php if (!empty($com_type) && $com_type == 'ATCA-SM') echo 'selected = "selected"'; ?>>ATCA-SM</option>
             <option value="IPMC"<?php if (!empty($com_type) && $com_type == 'IPMC') echo 'selected = "selected"'; ?>>IPMC</option>
             <option value="Xilinx-progr"<?php if (!empty($com_type) && $com_type == 'Xilinx-progr') echo 'selected = "selected"'; ?>>Xilinx-progr</option>
             <option value="Altera-progr"<?php if (!empty($com_type) && $com_type == 'Altera-progr') echo 'selected = "selected"'; ?>>Altera-progr</option>
             <option value="SFP+"<?php if (!empty($com_type) && $com_type == 'SFP+') echo 'selected = "selected"'; ?>>SFP+</option>
             <option value="QSFP"<?php if (!empty($com_type) && $com_type == 'QSFP') echo 'selected = "selected"'; ?>>QSFP</option>
             <option value="SFP"<?php if (!empty($com_type) && $com_type == 'SFP') echo 'selected = "selected"'; ?>>SFP</option>
             <option value="SFP-RJ45"<?php if (!empty($com_type) && $com_type == 'SFP-RJ45') echo 'selected = "selected"'; ?>>SFP-RJ45</option>
          <option value="PC"<?php if (!empty($com_type) && $com_type == 'PC') echo 'selected = "selected"'; ?>>PC</option>
         <option value="NIC10GBS"<?php if (!empty($com_type) && $com_type == 'NIC10GBS') echo 'selected = "selected"'; ?>>NIC10GBS</option>
         


</select>
    <br />
            
    <label for="com_id">    ID:</label>
    <input type="int" maxlenght="4" size="4"  name="com_id" value="<?php if (!empty($com_id)) echo $com_id; ?>" required /><br />
            
            
               <label for="serial_number">Serial Number:</label>
    <input type="serial_number" size="20" maxlength="30"  name="serial_number" value="<?php if (!empty($serial_number)) echo $serial_number; ?>" /><br />
            <label for="owner">Owner:</label>
    <input type="varchar" size="10" maxlength="20"  name="owner" value="<?php if (!empty($owner)) echo $owner; ?>" /><br /><br />
            
            
        <label for="prod_date">Production date:</label>
    <input type="date" size="10" maxlength="20"  name="prod_date" value="<?php if (!empty($prod_date)) echo $prod_date; ?>" /><br />    
         <label for="cern_receival_date">CERN receival date:</label>
    <input type="date" size="10" maxlength="20"  name="cern_receival_date" value="<?php if (!empty($cern_receival_date)) echo $cern_receival_date; ?>" /><br />
    
   
    <br />   
            
              <label for="status">Status:</label>
                <select name="status"  id="status">
                <option value="Select">Select</option>
                <option value="Unknown"<?php if (!empty($status) && $status == 'Unknown') echo 'selected = "selected"'; ?>>Unknown</option>
             <option value="Good"<?php if (!empty($status) && $status == 'Good') echo 'selected = "selected"'; ?>>Good</option>
             <option value="Bad"<?php if (!empty($status) && $status == 'Bad') echo 'selected = "selected"'; ?>>Bad</option> 
            </select><br />
    
    
            
            
    
            
       </fieldset>
        <br />
        <fieldset><legend><b> Details </b> </legend>
            
               
            
            
            
   
            
             <label for="location">Location:</label>
            
    <select name="location"  id="location">
            <option value="Select">Select</option>
             <option value="USA15"<?php if (!empty($location) && $location == 'USA15') echo 'selected = "selected"'; ?>>USA15</option>
             <option value="Lab4"<?php if (!empty($location) && $location == 'Lab4') echo 'selected = "selected"'; ?>>Lab4</option>
             <option value="Other"<?php if (!empty($location) && $location == 'Other') echo 'selected = "selected"'; ?>>Other</option>
             
</select>
    <br />    
            
             <label for="inst_status">Instalation status:</label>
    <!--<input type="enum" size="10" maxlength="20"  name="inst_status" value="<?php if (!empty($inst_status)) echo $inst_status; ?>" />::[Installed, Spare]<br />-->
    
    <select name="inst_status"  id="inst_status">
            <option value="Select">Select</option>
             <option value="Installed"<?php if (!empty($inst_status) && $inst_status == 'Installed') echo 'selected = "selected"'; ?>>Installed</option>
             <option value="Spare"<?php if (!empty($inst_status) && $inst_status == 'Spare') echo 'selected = "selected"'; ?>>Spare</option>
            
             
</select>
    <br />   
            
            <label for="rack">Rack:</label>
    <input type="varchar" size="10" maxlength="20"  name="rack" value="<?php if (!empty($rack)) echo $rack; ?>" /><br />
          
            <label for="crate">Crate:</label>
    <input type="varchar" size="10" maxlength="20"  name="crate" value="<?php if (!empty($crate)) echo $crate; ?>" /><br />
            
            <label for="slot">Slot:</label>
    <input type="varchar" size="10" maxlength="20"  name="slot" value="<?php if (!empty($slot)) echo $slot; ?>" /><br />
            
            
           
            
               <label for="firmware_version">Firmware version:</label>
    <input type="firmware_version" size="10" maxlength="10"  name="firmware_version" value="<?php if (!empty($firmware_version)) echo $firmware_version; ?>" /><br /><br />
            
           
            
       
          
            
            
            <label for="notes">Notes:</label>
    <input type="text" size="150" maxlength="150"  name="notes" value="<?php if (!empty($notes)) echo $notes; ?>" /><br />
             
            <label for="last_user">Last change:</label>
    <input type="last_user" size="20" maxlength="30"  name="last_user" value="<?php if (!empty($last_user)) echo $last_user; ?>" /><br />
            
            
           
            
            
            
    
            
    
        
    </fieldset>
    </fieldset>
    
    <input type="submit" value="Save Module" name="submit_other" />
  </form>
</body> 
</html>
