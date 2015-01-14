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
  <h3>FTK Reception Test - Query FTK Results</h3>
    
    
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

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        include('connectvars.php');
        $sql = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
        mysql_select_db(DB_NAME) or die(mysql_error());
        $searchphrase = $_POST["searchphrase"];
        if($_POST["item_type"]=='bd') {
            $table='ftk_parts';
        } elseif ($_POST["item_type"]=='cb'){
                $table='ftk_cables';
        } else {
            $table='ftk_other';
        }
        $sql_search = "select * from " . $table . " where ";
        $sql_search_fields = Array();
        $sql = "SHOW COLUMNS FROM " . $table;
        $rs = mysql_query($sql);
        
        while ($r = mysql_fetch_array($rs)) {
            $colum = $r[0];
            $sql_search_fields[] = $colum . " like('%" . $searchphrase . "%')";
        }
        $sql_search .= implode(" OR ", $sql_search_fields);
        
        $rs2 = mysql_query($sql_search);
        $out = mysql_num_rows($rs2) . "\n";
        echo "Number of search hits in $table " . $out."<br />";
        echo'<table border="1">';
        echo'<tr><td>Type</td>
        <td>Id</td>
        <td>Location</td>
        <td>Rack</td>
         <td>Crate</td>
          <td>Slot</td>
          <td>InstStatus</td>
          <td>CERN receival_date</td>
          <td>TEST date</td>
          <td>Production date</td>
          
        <td>Owner</td>
        <td>Last user</td>
        <td>MB_SN</td>
        <td>MB_Pos</td>
        <td>FPGA</td>
        <td>Firmware version</td>
        <td>Status</td>
        <td>Board type ID</td>
    
    </tr>';
        while ($results = mysql_fetch_array($rs2)){
           
            //print $results[0].
            //echo '<br />';
            
        echo'<tr><td>'.$results['board_type'].'</td>
        <td>'.$results['board_id'].'</td>
        <td>'.$results['location'].'</td>
        <td>'.$results['rack'].'</td>
         <td>'.$results['crate'].'</td>
          <td>'.$results['slot'].'</td>
          <td>'.$results['inst_status'].'</td>
          <td>'.$results['CERN_receival_date'].'</td>
          <td>'.$results['TEST_date'].'</td>
          <td>'.$results['Prod_date'].'</td>
          
        <td>'.$results['owner'].'</td>
        <td>'.$results['last_user'].'</td>
        <td>'.$results['MB_SN'].'</td>
        <td>'.$results['MB_Pos'].'</td>
        <td>'.$results['FPGA'].'</td>
        <td>'.$results['firmware_version'].'</td>
        <td>'.$results['Status'].'</td>
        <td>'.$results['board_type_ID'].'</td>
    
    </tr>';
        }
echo'</table>';





        ?>
    </body>
</html>




