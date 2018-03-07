<?php
//march 7 issue: extracts mname but is not yet updating the fname minus the subtracted mname.
//march 7 issue: assumes 1 word mnames and does not consider multi-word mnames
//disabling sql call
echo 'util desc: extract mname from fname if mname is null.<br />';
echo 'begin &raquo;';

$update_limit = (isset($_GET['limit'])) ? $_GET['limit'] : 1000;

//$dbcon = mysqli_connect("localhost","infragre_qhq_cdb","A9Sfmu8UDjsp2wdM", "infragre_qhq_cdb") or die(mysqli_connect_error());
$dbcon = mysqli_connect("localhost","qhq_cdb","A9Sfmu8UDjsp2wdM", "qhq_cdb") or die(mysqli_connect_error());

$data = array();
$counter = 0;
//$counter1 = 0;
$query2 = '';

$query = "SELECT * FROM rvoters WHERE mname = '' OR mname IS NULL";
//$query = "SELECT * FROM rvoters";
$results = mysqli_query($dbcon, $query) or die(mysqli_error($dbcon));
$result_count = mysqli_num_rows($results);

if ( $result_count > 0) {
    //echo mysqli_num_rows($results);
    echo '<table>';

    foreach ($results as $row) {
        echo '<tr><td>';
        $id = $row['id']; 
        echo $id; 
        echo '</td><td>';
        echo $row['fname']; 
        echo '</td><td>';
        echo $row['mname']; 
        echo '</td><td>';
        
        //extract mname
        if ($row['mname'] == '' && $row['mname'] == NULL) {
            
            $pcs = split(' ',$row['fname']);
            $last_pc = count($pcs) - 1;
            $new_mname =  $pcs[$last_pc];
            echo $new_mname; // <---- issue right here
        
            //update barangay field
            if ($new_mname != '') {
                $query2 = "UPDATE rvoters SET mname = '$new_mname' WHERE id = $id";
            }
            if ($query2 != '') {
                echo '*';
                //$result2 = mysqli_query($dbcon, $query2) or die(mysqli_error($dbcon));
            }
            $counter++;
        }
        echo '</td>';
        echo '<td>'.$query2.'</td>';
        echo '</tr>';
       
        $query2 = ''; //reset query2
        //$counter1++;
        if ($counter == $update_limit) break; //set limit to updated records

    }
    echo '</table>';
    echo '<br /><br />';
    echo 'Update complete.';
    echo '<br />';
    echo $counter . ' records updated.';
    echo '<br />';
    echo $result_count . ' records scanned.';
    echo '<br /><br />';
    echo '<input type="button" value="Reload" onClick="window.location.reload()">';
}
else{
    echo 'No match.';
}
