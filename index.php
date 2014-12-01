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
<!-- <script type="text/javascript" src="drop_down.js"></script> -->

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title> FTK Production Database Interface</title>
  <link rel="stylesheet" type="text/css" href="style.css" />
</head>


<!-- <body> -->
  
<!--<body onload="onload()"><h1><img src="ATLAS_NoText_t.png" height="75px"> FTK Production Database Interface</h1><p>This web user interface allows you to interact with the <b>MySQL production database</b> in a pratical and easy way.
</p>-->

<body><h1><img src="ATLAS_NoText_t.png" height="75px"> FTK Production Database Interface</h1><p>This web user interface allows you to interact with the <b>MySQL production database</b> in a pratical and easy way.
</p>

<div style="border-width: 2px; border-style:solid"><h4 align="center">Short Introduction</h4>

<p>THIS WEBPAGE IS FOR ENGINEERS AND TECHNICIANS WORKING ON THE <b>ATLAS Fast TracKer</b>.</p>

<p>THIS WEBPAGE IS FOR EXPERT ONLY. DON'T USE IT IMPROPERLY!</p>


<p>Problems? Contact <a href="mailto:lucian@cern.ch">Lucian Ancu</a> or <a href="mailto:attilio.picazio@cern.ch">Attilio Picazio</a>.</p>
</div>
<!-- <ul id="nav"> --> 
<?php
  require_once('appvars.php');
  require_once('connectvars.php');
  
  if (isset($_SESSION['username'])) {
?>

<ul class="mainlist"> <!--id="nav">--> 
    <br />
    <li class="high">Tutorial Obsolete 
     <ul class="underlist"> 
      	<!-- <li class="low"><a href="#">Database Query</a></li> 
      	 <li class="low"><a href="#">Data Insertion</a></li> -->
     </ul> 
    </li> 
    <li class="high">Services 
        <!-- Commented out to release first web version -->
   <li class="low"><a href="table1.php">Table of all modules</a></li>
    <!--<li class="low"><a href="editprofile.php">Insert Module Data</a></li>-->
    <li class="low"><a href="FTK_viewTable2.php">FTK view Table</a></li>
    <!--<li class="low"><a href="FTK_viewTable.php">FTK view Table</a></li>-->
    <li class="low"><a href="FTK_Board_reception2_def.php">FTK reception</a></li></li>
    
    <!-- Commented out to release first web version -->
   <!-- <li class="high">Services 
    <ul class="underlist"> 
      	 <li class="low"><a href="table1.php">Ordered table</a></li> 
      	 <li class="low"><a href="editprofile.php">Insert Module Data</a></li>
        <li class="low"><a href="FTK_viewTable2.php">Table with links </a></li>
         <li class="low"><a href="FTK_viewTable.php">FTK view Table</a></li>
        <li class="low"><a href="FTK_Board_reception2_def.php">FTK board reception</a></li> -->
         
        
     </ul> 
    </li> 
    
   <br />
   <li> <a href="logout.php">Log Out (<?php echo  $_SESSION['username'] ?>)</a></li>
</ul> 

<?php
  }
  else {?>
    <ul class="mainlist">
     <br />
     <li class="low"><a href="#">Registration Procedure</a><br /></li>
     <li class="high"><a href="login.php">Log In</a></li>
     <li class="high"><a href="signup.php">Sign Up</a></li>
    </ul>
 <?php }
  
?>


</body> 
</html>
