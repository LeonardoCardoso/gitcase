<?php
/**
 * Created by PhpStorm.
 * User: leocardz
 * Date: 05/05/15
 * Time: 18:21
 */

require __DIR__ . '/../vendor/autoload.php';

$fontpath = realpath('../css/fonts/');
putenv('GDFONTPATH=' . $fontpath);

use GDText\Box;
use GDText\Color;

// dimensions
$width = 1153;
$height = 430;
$divisor_height_offset = $height - 150;
$divisor_width_offset = $width / 9;
$divisor_height_texts_offset = $divisor_height_offset + 15;
$contributions_header_height = 36;


// image
$im = imagecreatetruecolor($width, $height);

// colors
$darker_grey = imagecolorallocate($im, 216, 216, 216);
$lighter_grey = imagecolorallocate($im, 240, 240, 240);
$white = imagecolorallocate($im, 255, 255, 255);
$black = imagecolorallocate($im, 0, 0, 0);
$gdBlack = new Color(0, 0, 0);
$gdDarkerGrey = new Color(90, 90, 90);
$font = 'PoiretOne-Regular';

$scale0 = imagecolorallocate($im, 238, 238, 238);
$scale1 = imagecolorallocate($im, 214, 230, 133);
$scale2 = imagecolorallocate($im, 140, 198, 101);
$scale3 = imagecolorallocate($im, 68, 163, 64);
$scale4 = imagecolorallocate($im, 30, 104, 35);

$colors = [$scale0, $scale1, $scale2, $scale3, $scale4];


// background
imagefilledrectangle($im, 0, 0, $width - 1, $height - 1, $white);
imagerectangle($im, 0, 0, $width - 1, $height - 1, $darker_grey);

// divisors
imageline($im, 0, $divisor_height_offset, $width, $divisor_height_offset, $darker_grey);
imageline($im, $width / 3, $divisor_height_offset, $width / 3, $height, $darker_grey);
imageline($im, $width / 3 * 2, $divisor_height_offset, $width / 3 * 2, $height, $darker_grey);

// header
imagefilledrectangle($im, 1, 1, $width - 2, $contributions_header_height, $lighter_grey);
imageline($im, 0, $contributions_header_height, $width, $contributions_header_height, $darker_grey);

$textbox = new Box($im);
$textbox->setFontSize(20);
$textbox->setFontFace($font);
$textbox->setFontColor($gdBlack);
$textbox->setBox(15, 5, 105, 100);
$textbox->setTextAlign('right', 'top');
$textbox->draw("Contributions");

$textbox->setBox($width - 120, 5, 105, 100);
$textbox->draw("gitcase.leocardz.com");


$textbox = new Box($im);
$textbox->setFontSize(20);
$textbox->setFontFace($font);
$textbox->setFontColor($gdDarkerGrey);
$textbox->setTextAlign('left', 'top');

$textbox->setBox($divisor_width_offset, $divisor_height_texts_offset, 200, 0);
$textbox->draw("In the last year");

$textbox->setBox($divisor_width_offset * 4, $divisor_height_texts_offset, 200, 0);
$textbox->draw("Longest streak");

$textbox->setBox($divisor_width_offset * 7, $divisor_height_texts_offset, 200, 0);
$textbox->draw("Current streak");

$textbox->setFontSize(17);
$textbox->setBox(10, $divisor_height_offset - 30, 400, 0);
$textbox->draw("Summary of Pull Requests, issues opened, and commits.");

$textbox->setBox($width - 220, $divisor_height_offset - 30, 400, 0);
$textbox->draw("Less");

$textbox->setBox($width - 50, $divisor_height_offset - 30, 400, 0);
$textbox->draw("More");

$stepback = $width - 12;
imagefilledrectangle($im, $stepback - 170, $divisor_height_offset - 30, $stepback - 150, $divisor_height_offset - 10, $scale0);
imagefilledrectangle($im, $stepback - 145, $divisor_height_offset - 30, $stepback - 125, $divisor_height_offset - 10, $scale1);
imagefilledrectangle($im, $stepback - 120, $divisor_height_offset - 30, $stepback - 100, $divisor_height_offset - 10, $scale2);
imagefilledrectangle($im, $stepback - 95, $divisor_height_offset - 30, $stepback - 75, $divisor_height_offset - 10, $scale3);
imagefilledrectangle($im, $stepback - 70, $divisor_height_offset - 30, $stepback - 50, $divisor_height_offset - 10, $scale4);


$initial_square_x = $contributions_header_height + 10;
$initial_square_y = $contributions_header_height + 40;
$fixed_dimensions = 16;
$fixed_offset = 4;
for ($i = 0; $i < 53; $i++) {
    for ($j = 0; $j < 7; $j++) {
        imagefilledrectangle(
            $im,
            $initial_square_x + ($fixed_dimensions + $fixed_offset) * $i,
            $initial_square_y + ($fixed_dimensions + $fixed_offset) * $j,
            $initial_square_x + ($fixed_dimensions + $fixed_offset) * $i + $fixed_dimensions,
            $initial_square_y + ($fixed_dimensions + $fixed_offset) * $j + $fixed_dimensions,
            $colors[rand(0, 4)]
        );
    }
}


$textbox = new Box($im);
$textbox->setFontSize(30);
$textbox->setFontFace($font);
$textbox->setFontColor($gdBlack);
$textbox->setTextAlign('left', 'top');
$textbox->setBox($width / 3 - 205, $height - 60, 200, 0);
$textbox->draw("729 total");


ob_start();
imagejpeg($im);
$contents = ob_get_contents();
ob_end_clean();

echo "data:image/jpeg;base64," . base64_encode($contents);

imagedestroy($im);