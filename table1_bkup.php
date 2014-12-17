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
  <title>FTK Production Database Interface - View Boad Data</title>
  <link rel="stylesheet" type="text/css" href="style.css" />
</head>
<body>
  <h3>FTK Production Database Interface - View Board Data</h3>
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


//<?php
mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
//mysql_connect('localhost','root','root') 
    or die(mysql_error());
mysql_select_db('Test') or die(mysql_error());
$field='board_type';
$sort='ASC';
if(isset($_GET['sorting']))
{
  if($_GET['sorting']=='ASC')
  {
  $sort='DESC';
  }
  else
  {
    $sort='ASC';
  }
}
if($_GET['field']=='board_type')
{
   $field = "board_type"; 
}
elseif($_GET['field']=='board_id')
{
   $field = "board_id";
}
elseif($_GET['field']=='location')
{
   $field="location";
}
elseif($_GET['field']=='rack')
{
   $field="rack";
}
elseif($_GET['field']=='crate')
{
   $field="crate";
}
elseif($_GET['field']=='slot')
{
   $field="slot";
}
elseif($_GET['field']=='inst_status')
{
   $field="inst_status";
}
elseif($_GET['field']=='CERN_receival_date')
{
   $field="CERN_receival_date";
}
elseif($_GET['field']=='Prod_date')
{
   $field="Prod_date";
}
elseif($_GET['field']=='owner')
{
   $field="owner";
}
elseif($_GET['field']=='last_user')
{
   $field="last_user";
}
elseif($_GET['field']=='MB_SN')
{
   $field="MB_SN";
}
elseif($_GET['field']=='MB_Pos')
{
   $field="MB_Pos";
}
elseif($_GET['field']=='FPGA')
{
   $field="FPGA";
}
elseif($_GET['field']=='firmware_version')
{
   $field="firmware_version";
}
elseif($_GET['field']=='Status')
{
   $field="Status";
}




//$sql = "SELECT board_type, board_id, inst_status FROM FTK_parts ORDER BY $field $sort";
$sql = "SELECT * FROM FTK_parts ORDER BY $field $sort";
//$sql = "SELECT board_type, board_id, inst_status FROM FTK_parts ORDER BY id $sort";
$result = mysql_query($sql) or die(mysql_error());

 if (isset($_POST['submit'])) {
    foreach ($_POST['todelete'] as $delete_id) {
      $query = "DELETE FROM FTK_parts WHERE id = $delete_id";
      //echo $query;
      //echo '<br />';
      
      //mysqli_query($dbc, $query)
      mysql_query($query)
        or die('Error querying database.');
    } 
    
    echo 'Module(s) removed.<br />';
    }

echo'<table border="1">';
if($_SESSION['username']==ADMIN || $_SESSION['username']==ADMIN2)
  { 
    //echo 'strange mode';
    //echo '<tr><td> Remove</td>';
    echo'<th>Remove</th><th><a href="table1.php?sorting='.$sort.'&field=board_type">Board Type</a></th>
     <th><a href="table1.php?sorting='.$sort.'&field=board_id">Board ID</a></th>
     <th><a href="table1.php?sorting='.$sort.'&field=location">location</a></th>
     <th><a href="table1.php?sorting='.$sort.'&field=rack">rack</a></th>
     <th><a href="table1.php?sorting='.$sort.'&field=crate">crate</a></th>
     <th><a href="table1.php?sorting='.$sort.'&field=slot">slot</a></th>
<th><a href="table1.php?sorting='.$sort.'&field=inst_status">Inst Status</a></th>
<th><a href="table1.php?sorting='.$sort.'&field=CERN_receival_date">CERN_receival_date</a></th>
<th><a href="table1.php?sorting='.$sort.'&field=TEST_date">TEST_date</a></th>
<th><a href="table1.php?sorting='.$sort.'&field=Prod_date">Prod_date</a></th>
<th><a href="table1.php?sorting='.$sort.'&field=owner">owner</a></th>
<th><a href="table1.php?sorting='.$sort.'&field=last_user">last_user</a></th>
<th><a href="table1.php?sorting='.$sort.'&field=MB_SN">MB_SN</a></th>
<th><a href="table1.php?sorting='.$sort.'&field=MB_Pos">MB_Pos</a></th>
<th><a href="table1.php?sorting='.$sort.'&field=FPGA">FPGA</a></th>
<th><a href="table1.php?sorting='.$sort.'&field=firmware_version">firmware_version</a></th>
<th><a href="table1.php?sorting='.$sort.'&field=Status">Status</a></th>

<th><a href="table1.php?sorting='.$sort.'&field=board_type_ID">Board type ID</a></th>';
  }
else 
    {
echo'<th><a href="table1.php?sorting='.$sort.'&field=board_type">Board Type</a></th>
     <th><a href="table1.php?sorting='.$sort.'&field=board_id">Board ID</a></th>
     <th><a href="table1.php?sorting='.$sort.'&field=location">location</a></th>
     <th><a href="table1.php?sorting='.$sort.'&field=rack">rack</a></th>
     <th><a href="table1.php?sorting='.$sort.'&field=crate">crate</a></th>
     <th><a href="table1.php?sorting='.$sort.'&field=slot">slot</a></th>
<th><a href="table1.php?sorting='.$sort.'&field=inst_status">Inst Status</a></th>
<th><a href="table1.php?sorting='.$sort.'&field=CERN_receival_date">CERN_receival_date</a></th>
<th><a href="table1.php?sorting='.$sort.'&field=TEST_date">TEST_date</a></th>
<th><a href="table1.php?sorting='.$sort.'&field=Prod_date">Prod_date</a></th>
<th><a href="table1.php?sorting='.$sort.'&field=owner">owner</a></th>
<th><a href="table1.php?sorting='.$sort.'&field=last_user">last_user</a></th>
<th><a href="table1.php?sorting='.$sort.'&field=MB_SN">MB_SN</a></th>
<th><a href="table1.php?sorting='.$sort.'&field=MB_Pos">MB_Pos</a></th>
<th><a href="table1.php?sorting='.$sort.'&field=FPGA">FPGA</a></th>
<th><a href="table1.php?sorting='.$sort.'&field=firmware_version">firmware_version</a></th>
<th><a href="table1.php?sorting='.$sort.'&field=Status">Status</a></th>

<th><a href="table1.php?sorting='.$sort.'&field=board_type_ID">Board type ID</a></th>';
}

while($row = mysql_fetch_array($result))
{
    
    if($_SESSION['username']==ADMIN || $_SESSION['username']==ADMIN2)
        {
            echo'<tr><td><input type="checkbox" value="' . $row['id'] . '" name="todelete[]" /></td>';                               
            echo'<td>'.$row['board_type'].'</td>';
        }
    else
        {
            echo'<tr><td>'.$row['board_type'].'</td>';
        }


    echo'<td>'.$row['board_id'].'</td>
        <td>'.$row['location'].'</td>
        <td>'.$row['rack'].'</td>
         <td>'.$row['crate'].'</td>
          <td>'.$row['slot'].'</td>
          <td>'.$row['inst_status'].'</td>
          <td>'.$row['CERN_receival_date'].'</td>
          <td>'.$row['TEST_date'].'</td>
          <td>'.$row['Prod_date'].'</td>
          
        <td>'.$row['owner'].'</td>
        <td>'.$row['last_user'].'</td>
        <td>'.$row['MB_SN'].'</td>
        <td>'.$row['MB_Pos'].'</td>
        <td>'.$row['FPGA'].'</td>
        <td>'.$row['firmware_version'].'</td>
        <td>'.$row['Status'].'</td>
        <td>'.$row['board_type_ID'].'</td>
    
    </tr>';
}

echo'</table>';


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
      
<!--// end table -->       
