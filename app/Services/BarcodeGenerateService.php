<?php


namespace App\Services;


use Milon\Barcode\DNS1D;

class BarcodeGenerateService
{

    public function generateBarCode(){
        $d = new DNS1D();
        $img='<img src="data:image/png;base64,' . $d->getBarcodePNG('4', 'C39+') . '" alt="barcode"   />';
        $folderPath = "D:/";

        $image_parts = explode(";base64,", $img);

        $image_type_aux = explode("image/", $image_parts[0]);

        $image_type = $image_type_aux[1];

        $image_base64 = base64_decode($image_parts[1]);

        $fullFilePath = $folderPath.'/barcode.png';
//        fwrite("D:/receipt.txt",$image_base64);

        file_put_contents($fullFilePath, $image_base64);

//        WRITE TO txt FILE

//        $base64_code=$image_parts[1];
//         create an image file
//        $fp = fopen("D:/receipt.txt", "w+");

// write the data in image file
//        fwrite($fp, base64_decode($base64_code));

// close an open file pointer
//        fclose($fp);

    }
}
