<?php function get_board_types ($dbc){
    $table_name = "FTK_parts";
$column_name = "board_type";

$q = "SELECT COLUMN_TYPE FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_NAME = '$table_name' AND COLUMN_NAME = '$column_name'";
$r = mysqli_query($dbc, $q);
    

$row = mysqli_fetch_array($r);

$enumList = explode(",", str_replace("'", "", substr($row['COLUMN_TYPE'], 5, (strlen($row['COLUMN_TYPE'])-6))));   

    //print(count($enumList));
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

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Module Reception Test</title>
  <link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
  <h3>FTK Reception Test - Query FTK Item</h3>
    
    
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
$enumList2=get_board_types($dbc);   


mysqli_close($dbc);

//if (isset($_POST['submit'])) {
  //      echo $searchphrase;
    //                         }

?>
    
    
<!--<form enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">-->
<form enctype="multipart/form-data" method="post" action="search_action.php">
    <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MM_MAXFILESIZE; ?>" />
    
    
       <fieldset><legend><b> FTK Stuff</b> </legend>
    
           
           
    <!--<label for="board_type">Board type:</label>
    <input type="enum" size="10" maxlength="20"  name="board_type" value="<?php if (!empty($board_type)) echo $board_type; ?>" /><br />-->
         
      
            
<!--<select name="selType">
<?php   foreach( $enumList2 as $value)
            echo "<option value=\"$value\" <?php if ($board_type==$value) {echo 'selected';}    ?>$value</option>"; ?>
           <option value="<?php if (!empty($board_type)) echo $board_type ; ?>"> <?php echo $board_type?> </option>
        </select>-->
    
           <!--  <input type="option"  name="board_type" value="<?php if (!empty($board_type)) echo $board_type ; ?>" />   <br \> -->    
             
     <label for="item_type">    Type:</label>
     <select name="item_type" id="item_type">
  
         <!--<option value = ""<?php if(!empty($item_type) && $item_type == '') echo 'selected = "selected"'; ?>></option>-->
         <option value = "bd"<?php if(!empty($item_type) && $item_type == 'bd') echo 'selected = "selected"'; ?>>Board</option>
         <option value = "cb"<?php if(!empty($item_type) && $item_type == 'cb') echo 'selected = "selected"'; ?>>Cable</option>
         <option value = "ot"<?php if(!empty($item_type) && $item_type == 'ot') echo 'selected = "selected"'; ?>>Other</option>
  
</select>
      
           
           
<!--    <input type="int" maxlenght="4" size="4"  name="board_id" value="<?php if (!empty($item_type)) echo $item_type; ?>" /> --> <br />
           
           
    <label for="board_id">    ID:</label>
    <input type="int" maxlenght="4" size="4"  name="board_id" value="<?php if (!empty($board_id)) echo $board_id; ?>" /> <br />
  
           <label for="searchphrase">Searchphrase:</label>
    <input type="text" size="20" maxlength="20"  name="searchphrase" value="<?php if (!empty($searchphrase)) echo $searchphrase; ?>" /><br />
              
                    
    </fieldset>
    
     <input type="submit" value="Search" name="submit" />
  </form>
</body> 
</html>

    
    
    
    