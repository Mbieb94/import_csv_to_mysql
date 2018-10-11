<?php

################################################################################
# HOW TO USE IT ?
# call the library : use App\Library\ImportCsv;
#Example : (copy this source at your controller)

// public function import() {
//    $db = 'Import'; -> (your name of table)
//    if (isset($_POST['Import'])) {
//         ImportCsv::import($db);
//         h('notification.info', ' Database Berhasil ditambahkan'); -> (this is alert of success, you can custom)
//     } else {
//         h('notification.error', ' Silahkan Upload File dengan Format .csv'); -> (this is alert of error, you can custom)
//     } 

// }
// 
// Note : for csv file, first csv column name must same as name of yours field in your table.
// * created by : mbiebs94@gmail.com
################################################################################

namespace App\Library;

use Bono\App;

class ImportCsv
{   
    public static function import($db)
    {
        $file = $_FILES['file']['tmp_name'];

        if ($_FILES['file']['size'] > 0) {
            $files = fopen($file, "r");
            $label = fgetcsv($files, 10000, "?");
            $name = explode(',', $label[0]);
            $total_row = count($name);

            // $count = 0;
            while (($labels = fgetcsv($files, 10000, "?")) !== FALSE) {
                // $count++;
                // if ($count > 1) {
                //     # code...
                // }
                $data = explode(',', $labels[0]);
                $coll = \Norm::factory($db)->newInstance(); // this query to your table
                for ($i=0; $i < $total_row ; $i++) { 
                    $coll->set($name[$i], $data[$i]);
                }
                $coll->save();
            }
        }
    }
}
