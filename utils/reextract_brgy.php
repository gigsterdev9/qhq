<?php
/* re-extract barangays from district 1 constituents. */
echo 're-extract barangays from district 1 constituents.';

//$dbcon = mysqli_connect("localhost","infragre_qhq_cdb","A9Sfmu8UDjsp2wdM", "infragre_qhq_cdb") or die(mysqli_connect_error());
$dbcon = mysqli_connect("localhost","qhq_cdb","A9Sfmu8UDjsp2wdM", "qhq_cdb") or die(mysqli_connect_error());

$brgys = array('Barangka', 'Kalumpang', 'Concepcion Uno', 'Concepcion Dos', 'Fortune', 'Industrial Valley Complex', 'Jesus Dela Peña', 'JESUS DE LA PEÃ‘A',
                'Malanday', 'Marikina Heights', 'Nangka', 'Parang', 'San Roque', 'Santa Elena', 'Santo Niño', 'Tañong', 'Tumana');
$data = array();
$counter = 1;

$query = "SELECT * FROM rvoters WHERE district = 1";
$results = mysqli_query($dbcon, $query) or die(mysqli_error($dbcon));
$result_count = mysqli_num_rows($results);

if ( $result_count > 0) {
    //echo mysqli_num_rows($results);
    echo '<table>';
    foreach ($results as $row) {
        echo '<tr><td>';
        $id = $row['id']; echo $id; echo '&nbsp; ';
        echo $row['address'];
        echo '</td>';
        
        //extract barangay
        foreach ($brgys as $brgy) {
            //if (strstr($string, $url)) { // mine version
            if (stripos($row['address'], $brgy) !== FALSE) { // Yoshi version
                echo '<td>'.$brgy.'</td>';
                $barangay = $brgy;
                $counter++;
                break;
            }
            else{
                echo '<td>&nbsp;</td>';
                $barangay = '';
            }
        }
        //update barangay field
        $query2 = "UPDATE rvoters SET barangay = '$barangay' WHERE id = $id";
        $result2 = mysqli_query($dbcon, $query2) or die(mysqli_error($dbcon));
        echo '<td>'.$query2.'</td>';
        echo '</tr>';
        //die();
    }
    echo '</table>';
    echo 'Update complete.';
    echo '<br />';
    echo $counter . 'corrected records.';
}
else{
    echo 'No match.';
}

?>