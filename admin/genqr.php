<?php
// Load the qrcode and the holder to combine qrcode and holder to
$qrcode = imagecreatefrompng('../image/resources_qrcode/RES-913073.png');
$holder = imagecreatefrompng('../image/QRCode_Holder.png');

// Set the margins for the qrcode 

$marge_right = 24;
$marge_bottom = 124;

//resized qrcode image
$qrcodeResized = imagescale ( $qrcode , 250 , 250 );

//get the height/width of the resized qrcode image
$sx = imagesx($qrcodeResized);
$sy = imagesy($qrcodeResized);

//$sx = 250;
//$sy = 250;

// Copy the qrcode image onto our photo using the margin offsets and the photo 
// width to calculate positioning of the qrcode. 
imagecopy($holder, $qrcodeResized, imagesx($holder) - $sx - $marge_right, imagesy($holder) - $sy - $marge_bottom, 0, 0, $sx, $sy);

// Output and free memory
header('Content-type: image/png');
imagepng($holder);
imagedestroy($holder);

?>