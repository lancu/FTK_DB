<?php function a(){

$table_name = "ftk_parts";
$column_name = "board_type";

echo "<select name=\"$column_name\"><option>Select one</option>";
$q = "SELECT COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_NAME = '$table_name' AND COLUMN_NAME = '$column_name'";
$r = mysqli_query($dbc, $q);

$row = mysqli_fetch_array($r);

$enumList = explode(",", str_replace("'", "", substr($row['COLUMN_TYPE'], 5, (strlen($row['COLUMN_TYPE'])-6))));

foreach($enumList as $value)
    echo "<option value=\"$value\">$value</option>";
echo "<option value=\" $board_type\"> $board_type</option>";

echo "</select>";
}

?>

<?php function get_board_types ($dbc){
    $table_name = "ftk_parts";
$column_name = "board_type";

$q = "SELECT COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_NAME = '$table_name' AND COLUMN_NAME = '$column_name'";
$r = mysqli_query($dbc, $q);
    

$row = mysqli_fetch_array($r);

$enumList = explode(",", str_replace("'", "", substr($row['COLUMN_TYPE'], 5, (strlen($row['COLUMN_TYPE'])-6))));   


    $array = array(
        "foo" => "bar",
        "bar" => "foo");
   // return $array;   
    return $enumList;
    
    
} ?>


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
  <h3>FTK Reception Test - Board Data Insertion</h3>

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
     
    
     
     //ftk added 
    $board_type = mysqli_real_escape_string($dbc, trim($_POST['board_type']));
    
    $board_id=mysqli_real_escape_string($dbc, trim($_POST['board_id']));
    $location=mysqli_real_escape_string($dbc, trim($_POST['location']));
    $inst_status=mysqli_real_escape_string($dbc, trim($_POST['inst_status']));
    $cern_receival_date = mysqli_real_escape_string($dbc, trim($_POST['cern_receival_date']));
    $test_date = mysqli_real_escape_string($dbc, trim($_POST['test_date']));
    $prod_date = mysqli_real_escape_string($dbc, trim($_POST['prod_date']));
    $rack = mysqli_real_escape_string($dbc, trim($_POST['rack']));
    $crate = mysqli_real_escape_string($dbc, trim($_POST['crate']));
    $slot = mysqli_real_escape_string($dbc, trim($_POST['slot']));
    $owner = mysqli_real_escape_string($dbc, trim($_POST['owner']));
    $last_user = mysqli_real_escape_string($dbc, trim($_POST['last_user']));
    $MB_SN = mysqli_real_escape_string($dbc, trim($_POST['MB_SN']));
    $MB_Pos = mysqli_real_escape_string($dbc, trim($_POST['MB_Pos']));
    $notes = mysqli_real_escape_string($dbc, trim($_POST['notes']));
    $FPGA = mysqli_real_escape_string($dbc, trim($_POST['FPGA']));
    $firmware_version = mysqli_real_escape_string($dbc, trim($_POST['firmware_version']));
     $status = mysqli_real_escape_string($dbc, trim($_POST['status']));
    
 

 
      if ($error) {
        echo $error ;
      }
     
    
    //Grab the user data from the DB	
    
    $query = "SELECT first_name,last_name,email FROM mismatch_user WHERE user_id = '" . $_SESSION['user_id'] . "'";
    $data = mysqli_query($dbc, $query);
    $row = mysqli_fetch_array($data);

    if ($row != NULL) {
      $name_user = $row['first_name'];
      $surname_user = $row['last_name'];
      $email_user = $row['email'];
     }


   

 

//getting the data into the DB 
     //here I need to add all values

 $queryMain = "INSERT INTO ftk_parts (board_type, board_id, location, inst_status, cern_receival_date,test_date,prod_date,rack,crate,slot,owner,last_user,MB_SN,MB_Pos,notes,FPGA,firmware_version,status) VALUE 
 ('$board_type ', '$board_id', '$location', '$inst_status', '$cern_receival_date','$test_date','$prod_date','$rack','$crate','$slot','$owner','$email_user','$MB_SN','$MB_Pos','$notes','$FPGA','$firmware_version','$status') ON DUPLICATE KEY UPDATE location='$location', inst_status='$inst_status', cern_receival_date='$cern_receival_date',  test_date='$test_date', prod_date='$prod_date', rack='$rack', crate='$crate', slot='$slot', owner='$owner', last_user='$email_user', MB_SN='$MB_SN', MB_Pos='$MB_Pos', notes='$notes', FPGA='$FPGA', firmware_version='$firmware_version' , status = '$status' "; 
   
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
$query_old = "SELECT * FROM ftk_parts WHERE id= '" . $_GET['id'] . "'";
    //$query_old = "SELECT * FROM Module_Reception_Test_Geneva WHERE ATLAS_id = '" . $_GET['ATLAS_id'] . "' AND id= '" . $_GET['id'] . "'";
//$query_old = "SELECT * FROM ftk_parts WHERE id=  18";
$data_old = mysqli_query($dbc, $query_old);
$row_old = mysqli_fetch_array($data_old);


//echo $row_old;

  if ($row_old != NULL) {
	 $board_type = $row_old['board_type'];
     $board_id  = $row_old['board_id'];
     $location =  $row_old['location'];
      $inst_status =  $row_old['inst_status'];
      $cern_receival_date =  $row_old['cern_receival_date'];
      $test_date =  $row_old['test_date'];
      $prod_date =  $row_old['prod_date'];
      
       $rack = $row_old['rack'];
      $crate = $row_old['crate']; 
      $slot = $row_old['slot'];
       $owner = $row_old['owner'];
      $last_user = $row_old['last_user'];
      $MB_SN = $row_old['MB_SN'];
      $MB_Pos = $row_old['MB_Pos'];
      $notes = $row_old['notes'];
      $FPGA = $row_old['FPGA'];
      $firmware_version = $row_old['firmware_version'];
      $status   = $row_old['status'];
      
      
      
      }
      else {
	echo '<p class="error">There was a problem accessing your profile.</p>';
      }
}


//delete this selection example box     

//getting the boards names 

/*$table_name = "ftk_parts";
$column_name = "board_type";

//echo "<select name=\"$column_name\"><option>Select one</option>";
$q = "SELECT COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_NAME = '$table_name' AND COLUMN_NAME = '$column_name'";
$r = mysqli_query($dbc, $q);

$row = mysqli_fetch_array($r);

$enumList = explode(",", str_replace("'", "", substr($row['COLUMN_TYPE'], 5, (strlen($row['COLUMN_TYPE'])-6))));
$enumList2 = get_board_types();*/
//foreach($enumList as $value)
//    echo "<option value=\"$value\">$value</option>";
//echo "<option value=\" $board_type\"> $board_type</option>";

//echo "</select>";
//delete this selection example box. 

//echo $enumList;



//Print Table 



$enumList2=get_board_types($dbc);

mysqli_close($dbc);
?>
 
    
<!-- Printing the table 
 //STARTING FTK MESS
  --> 

<form enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
  <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MM_MAXFILESIZE; ?>"   


    <fieldset><legend>FTK entry Information </legend>
      <fieldset><legend>Information on the user</legend>
     
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
        
       <!-- <fieldset><legend> Board Information</legend>
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

      </fieldset> -->
        
     

        <fieldset><legend><b> FTK Stuff</b> </legend>
    <label for="board_type">Board type:</label>
    <!--<input type="enum" size="10" maxlength="20"  name="board_type" value="<?php if (!empty($board_type)) echo $board_type; ?>" /><br />-->
         
      
            
  <!--     <select name="selType">
        <?php   foreach( $enumList2 as $value)
            echo "<option value=\"$value\" <?php if ($board_type==$value) {echo 'selected';}    ?>$value</option>"; ?>
           <option value="<?php if (!empty($board_type)) echo $board_type ; ?>"> <?php echo $board_type?> </option>
        </select> --> 
            
            
      <!--<input type="option"  name="board_type" value="<?php if (!empty($board_type)) echo $board_type ; ?>" /> :: [IM, DF, AUX, AMB, LAMB, SSB, SSB_RTM, DF_RTM, FLIC, FLIC_RTM]  <br \> -->   
             
     <select name="board_type"  id="board_type">

             <option value="IM"<?php if (!empty($board_type) && $board_type == 'IM') echo 'selected = "selected"'; ?>>IM</option>
             <option value="DF"<?php if (!empty($board_type) && $board_type == 'DF') echo 'selected = "selected"'; ?>>DF</option>
             <option value="AUX"<?php if (!empty($board_type) && $board_type == 'AUX') echo 'selected = "selected"'; ?>>AUX</option>
             <option value="AMB"<?php if (!empty($board_type) && $board_type == 'AMB') echo 'selected = "selected"'; ?>>AMB</option>
             <option value="LAMB"<?php if (!empty($board_type) && $board_type == 'LAMB') echo 'selected = "selected"'; ?>>LAMB</option>
             <option value="SSB"<?php if (!empty($board_type) && $board_type == 'SSB') echo 'selected = "selected"'; ?>>SSB</option>
             <option value="SSB_RTM"<?php if (!empty($board_type) && $board_type == 'SSB_RTM') echo 'selected = "selected"'; ?>>SSB_RTM</option>
             <option value="DF_RTM"<?php if (!empty($board_type) && $board_type == 'DF_RTM') echo 'selected = "selected"'; ?>>DF_RTM</option>
             <option value="FLIC"<?php if (!empty($board_type) && $board_type == 'FLIC') echo 'selected = "selected"'; ?>>FLIC</option>
             <option value="FLIC_RTM"<?php if (!empty($board_type) && $board_type == 'FLIC_RTM') echo 'selected = "selected"'; ?>>FLIC_RTM</option>


</select>
    <br \>
            
    <label for="board_id">    ID:</label>
    <input type="int" maxlenght="4" size="4"  name="board_id" value="<?php if (!empty($board_id)) echo $board_id; ?>" /><br />
    
    <label for="location">Location:</label>
    <!---<input type="enum" size="10" maxlength="20"  name="location" value="<?php if (!empty($location)) echo $location; ?>" />::[USA15, Lab4, Other]<br /> -->
            
     
            
    <select name="location"  id="location">

             <option value="USA15"<?php if (!empty($location) && $location == 'USA15') echo 'selected = "selected"'; ?>>USA15</option>
             <option value="Lab4"<?php if (!empty($location) && $location == 'Lab4') echo 'selected = "selected"'; ?>>Lab4</option>
             <option value="Other"<?php if (!empty($location) && $location == 'Other') echo 'selected = "selected"'; ?>>Other</option>
             
</select>
    <br \>        
            
            
            
    <label for="inst_status">Instalation status:</label>
    <!--<input type="enum" size="10" maxlength="20"  name="inst_status" value="<?php if (!empty($inst_status)) echo $inst_status; ?>" />::[Installed, Spare]<br />-->
    
    <select name="inst_status"  id="inst_status">

             <option value="Installed"<?php if (!empty($inst_status) && $inst_status == 'Installed') echo 'selected = "selected"'; ?>>Installed</option>
             <option value="Spare"<?php if (!empty($inst_status) && $inst_status == 'Spare') echo 'selected = "selected"'; ?>>Spare</option>
            
             
</select>
    <br \>              
            
            
    <label for="cern_receival_date">CERN receival date:</label>
    <input type="date" size="10" maxlength="20"  name="cern_receival_date" value="<?php if (!empty($cern_receival_date)) echo $cern_receival_date; ?>" /><br />
    
    <label for="test_date">TEST date:</label>
    <input type="date" size="10" maxlength="20"  name="test_date" value="<?php if (!empty($test_date)) echo $test_date; ?>" /><br />
    
    <label for="prod_date">Production date:</label>
    <input type="date" size="10" maxlength="20"  name="prod_date" value="<?php if (!empty($prod_date)) echo $prod_date; ?>" /><br />
            
       </fieldset>
        
        <fieldset><legend><b> New Variables </b> </legend>
            
            <label for="rack">Rack:</label>
    <input type="varchar" size="10" maxlength="20"  name="rack" value="<?php if (!empty($rack)) echo $rack; ?>" /><br />
          
            <label for="crate">Crate:</label>
    <input type="varchar" size="10" maxlength="20"  name="crate" value="<?php if (!empty($crate)) echo $crate; ?>" /><br />
            
            <label for="slot">Slot:</label>
    <input type="varchar" size="10" maxlength="20"  name="slot" value="<?php if (!empty($slot)) echo $slot; ?>" /><br />
            
            <label for="owner">Owner:</label>
    <input type="varchar" size="10" maxlength="20"  name="owner" value="<?php if (!empty($owner)) echo $owner; ?>" /><br />
            
            <label for="last_user">Last change:</label>
    <input type="last_user" size="20" maxlength="30"  name="last_user" value="<?php if (!empty($last_user)) echo $last_user; ?>" /><br />
            
            <label for="MB_SN">MB_SN:</label>
    <input type="varchar" size="10" maxlength="20"  name="MB_SN" value="<?php if (!empty($MB_SN)) echo $MB_SN; ?>" /><br />
            
             <label for="MB_Pos">MB_Pos:</label>
    <input type="smallint" size="1" maxlength="20"  name="MB_Pos" value="<?php if (!empty($MB_Pos)) echo $MB_Pos; ?>" /><br />
            
            <label for="FPGA">FPGA:</label>
    <input type="varchar" size="20" maxlength="20"  name="FPGA" value="<?php if (!empty($FPGA)) echo $FPGA; ?>" /><br />
            
            <label for="firmware_version">Firmware Version:</label>
    <input type="varchar" size="4" maxlength="20"  name="firmware_version" value="<?php if (!empty($firmware_version)) echo $firmware_version; ?>" /><br />
            
             
              <label for="status">Status:</label>
                <select name="status"  id="status">
                <option value="Unknown"<?php if (!empty($status) && $status == 'Unknown') echo 'selected = "selected"'; ?>>Unknown</option>
             <option value="Good"<?php if (!empty($status) && $status == 'Good') echo 'selected = "selected"'; ?>>Good</option>
             <option value="Bad"<?php if (!empty($status) && $status == 'Bad') echo 'selected = "selected"'; ?>>Bad</option> 
            </select><br />
            
            <label for="notes">Notes:</label>
    <input type="text" size="150" maxlength="150"  name="notes" value="<?php if (!empty($notes)) echo $notes; ?>" /><br />
            
            
            
            
            
            
            
            
    
            
    
        
    </fieldset>
    </fieldset>
    
    <input type="submit" value="Save Module" name="submit" />
  </form>
</body> 
</html>
