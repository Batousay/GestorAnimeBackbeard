<?php

$folder = '../../../Banners/';

$extList = array();
//$extList['gif'] = 'image/gif';
$extList['jpg'] = 'image/jpeg';
//$extList['jpeg'] = 'image/jpeg';
$extList['png'] = 'image/png';

$img = null;

$fileList = array();
 
$handle = opendir($folder);
 
while ( false !== ( $file = readdir($handle) ) ) {
    $file_info = pathinfo($file);
    
    if (isset( $file_info['extension'] )) {
        if (isset( $extList[ strtolower( $file_info['extension'] ) ] )) {
            $fileList[] = $file;
        }
    }
}
closedir($handle);
 
$ntotal = count($fileList);
if ($ntotal > 0) {
        $imageNumber = rand(0,$ntotal-1);
        $img = $folder.$fileList[$imageNumber];
} 

if ($img!=null) {
    $imageInfo = pathinfo($img);
    $contentType = 'Content-type: '.$extList[ $imageInfo['extension'] ];
    header ("Location: http://pruebasbb.backbeard.es/Themes/Banners/".$fileList[$imageNumber]);
    //readfile($img);
}else{
    header ("Location: http://pruebasbb.backbeard.es/Backbeard/Themes/Banners/cdos.png");
}

?>
