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
        $searchphrase = "Installed";
        $table = "ftk_parts";
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
        
        while ($results = mysql_fetch_array($rs2)){
           
            print $results[0]."<br />";
            
             echo'<td>'.$results['board_type'].'</td>
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
        ?>
    </body>
</html>