<?php
// set up array of points for polygon

function makeColorRGB($im,$color){
$im = imagecreatetruecolor($_REQUEST[width], $_REQUEST[height]);
//$color = 'FF9900';
$colorRGB = imagecolorallocate($im, hexdec('0x' . $color{0} . $color{1}), hexdec('0x' . $color{2} . $color{3}), hexdec('0x' . $color{4} . $color{5}));
return $colorRGB;

}

$values = array(
            0,  0,  // Point 1 (x, y)
            $_REQUEST[width],  0, // Point 2 (x, y)
            0,  $_REQUEST[height]  // Point 3 (x, y)
            //240, 20,  // Point 4 (x, y)
           // 50,  40,  // Point 5 (x, y)
           // 10,  10   // Point 6 (x, y)
            );

// create image
$image = imagecreatetruecolor($_REQUEST[width], $_REQUEST[height]);

// allocate colors

$bg   = makeColorRGB($image,$_REQUEST[color2]);
// fill the background
imagefilledrectangle($image, 0, 0, 249, 249, $bg);
 //imagecolorallocate($image, 200, 200, 200);
if($_REQUEST[color1] != ""){
$blue   = makeColorRGB($image,$_REQUEST[color1]);

// draw a polygon
imagefilledpolygon($image, $values, 3, $blue);
}

// flush image
header('Content-type: image/png');
imagepng($image);
imagedestroy($image);
?>
