<?php
ob_start();

print_r($_FILES);

$dbcon = mysqli_connect("localhost","qhq_cdb","A9Sfmu8UDjsp2wdM", "qhq_cdb") or die(mysql_error());

$brgys = array('Barangka', 'Calumpang', 'Concepcion Uno', 'Concepcion Dos', 'Fortune', 'Industrial Valley Complex', 'Jesus Dela Peña', 
                'Malanday', 'Marikina Heights', 'Nangka', 'Parang', 'San Roque', 'Santa Elena', 'Santo Niño', 'Tañong', 'Tumana');
$data = array();
$counter = 1;

if ($_FILES['csv']['size'] > 0) {
    
    //get the csv file
    $file = $_FILES['csv']['tmp_name'];
    $handle = fopen($file,"r");

    //loop through the csv file and insert into database
    do {

        //echo '<pre>';
        //print_r($data);
        //echo '</pre>';
        if (is_array($data) && !empty($data)) {
           
            echo '<hr />';
            echo 'COUNTER: '.$counter.'<br />';
            echo 'code: '; echo $data[0]; echo '<br />';
            $code = $data[0];
            echo 'id_no: '; echo $data[1]; echo '<br />';
            $id_no = $data[1];
            echo 'id_no_comelec: '; echo $data[2]; echo '<br />';
            $id_no_comelec = $data[2];
            
            //split fname and lname
            $data3 = explode(",", $data[3]); 
            echo 'lname: '; echo trim($data3[0]); echo '<br />';
            $lname = $data3[0];
            echo 'fname: '; echo trim($data3[1]); echo '<br />';
            $fname = $data3[1]; 

            echo $data[4]; echo '<br />';
            $address = $data[4];

                //extract barangay
                foreach ($brgys as $brgy) {
                    //if (strstr($string, $url)) { // mine version
                    if (stripos($data[4], $brgy) !== FALSE) { // Yoshi version
                        echo $brgy;
                        echo '<br />';
                        $barangay = $brgy;
                    }
                    else{
                        $barangay = '';
                    }
                }
                //convert bdate to MySQL format
                $data5 = explode("-", $data[5]); 
            //echo $data[5]; echo '<br />';
                $data5a = $data5[2].'-'.$data5[0].'-'.$data5[1];
            echo $data5a; echo '<br />';
            $dob = $data5a;
            echo $data[6]; echo '<br />';
            $sex = $data[6];
            echo $data[7]; echo '<br />';
            $district = $data[7];
            $counter++;
            echo '<hr />';
            
            /*
            if ($code != 'CODE') {
                $query = "INSERT INTO rvoters 
                            (code, id_no, id_no_comelec, fname, lname, dob, address, barangay, district, sex)
                            VALUES 
                            ('$code', '$id_no', '$id_no_comelec', '$fname', '$lname', '$dob', '$address', '$barangay', '$district', '$sex')
                            ";
                if (mysqli_query($dbcon, $query) === TRUE) {
                    printf("Entry successfully inserted.\n");
                }
            }
            */
            
        }
    } while ($data = fgetcsv($handle,1000,";",'"'));
    //

   echo "Record upload completed.";
}
else{
    echo "Empty or invalid file.";
}

?>
