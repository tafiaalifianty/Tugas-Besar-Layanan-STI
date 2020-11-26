<?php
    //Penggunaan library PhpSpreadsheet untuk ekspor data
    require 'lib/vendor/autoload.php';

    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


    $arrayData = array();
    $arrayData[0] = array();
    $arrayData[0][0] = 'Customer Name';
    $arrayData[0][1] = 'Customer Phone';

    $cnn = array();
    $cnp = array();
    
    include_once 'lib/db_conf.php';

    //Menyalin seluruh data di database ke dalam array
    $sql = "SELECT `cust_name`,`cust_phone` FROM `order`;";
    $data = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($data)):
        if(!in_array($row['cust_phone'], $cnp)){
            array_push($cnn, $row['cust_name']);
            array_push($cnp, $row['cust_phone']);
        }
    endwhile;

    $arrlen = count($cnn);

    //Mengubah bentuk susunan array 1 dimensi ke 2 dimensi
    //agar dapat dilakukan secara instan penulisan ke excel
    for($i=0;$i<$arrlen;$i++){
        $arrayData[$i+1][0] = $cnn[$i];
        $arrayData[$i+1][1] = $cnp[$i];
    }

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->fromArray(
        $arrayData,  
        NULL,        
        'A1'         
    );

    $writer = new Xlsx($spreadsheet);
    $writer->save(BASE_URL.'ekspor/data_customer.xlsx');

    echo '<script>window.location.href = \''.BASE_URL.'ekspor/data_customer.xlsx\';
        setTimeout(function() {
            window.location = "'.BASE_URL.'";
        }, 100);
    </script>';

    exit;
?>