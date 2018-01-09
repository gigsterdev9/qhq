<?php
/* Cross check entries in Non Voters to Registered Voters. */
echo 'Cross check entries in Non Voters to Registered Voters.';
echo '<br /><br />';

//$dbcon = mysqli_connect("localhost","infragre_qhq_cdb","A9Sfmu8UDjsp2wdM", "infragre_qhq_cdb") or die(mysqli_connect_error());
$dbcon = mysqli_connect("localhost","qhq_cdb","A9Sfmu8UDjsp2wdM", "qhq_cdb") or die(mysqli_connect_error());


$query = "SELECT * FROM non_voters WHERE 1";
$results = mysqli_query($dbcon, $query) or die(mysqli_error($dbcon));
$result_count = mysqli_num_rows($results);
$counter = 1;

foreach ($results as $row) {
    //echo '<pre>'; print_r($row); echo '</pre>';
    echo $counter .'. '; 
    $fname = $row['fname'];
    $lname = $row['lname'];
    $dob = $row['dob'];

    $query1 = "SELECT * FROM rvoters WHERE fname = '$fname' && lname = '$lname' && dob = '$dob' ";
    //echo $query1;
    $results1 = mysqli_query($dbcon, $query1) or die(mysqli_error($dbcon));
    $result_count1 = mysqli_num_rows($results1);

    //echo '<br />';
    echo $result_count1; 
    if ($result_count1 > 0) echo 'MATCH';
    echo '<br />';
    
    $counter++;
    //if ($counter == 10) die();
}
