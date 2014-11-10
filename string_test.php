<!DOCTYPE  HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"  "http://www.w3.org/TR/html4/loose.dtd"> 
	<html> 
	  <head> 
	    <meta  http-equiv="Content-Type" content="text/html;  charset=iso-8859-1"> 
	    <title>Search  Contacts</title> 
	  </head> 
	      
           <body>
        <form method="post">
            Text that needs to be processed
            <input type="text" id="text" name="t">
            <input type="submit" id ="order" name="order">
            
        </form>
        <?php
            if(isset($_POST['order']))
            {
                $parts = explode ("_", $_POST['t']);
                $board_type = $parts[2];
                $board_id = $parts[3];
                //print_r($parts);
                //print_r($_POST['t']);
            }
        ?>
    
    <label for="board_id">    ID:</label>
    <input type="int" maxlenght="4" size="4"  name="board_id" value="<?php if (!empty($board_id)) echo $board_id; ?>" /><br />
    
    <label for="location">Location:</label>
    <input type="enum" size="10" maxlength="20"  name="location" value="<?php if (!empty($location)) echo $location; ?>" /><br />
    </body>
	</html> 
	</p> 