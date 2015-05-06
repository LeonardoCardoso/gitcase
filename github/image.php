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
$gdLighterGrey = new Color(130, 130, 130);
$font = 'PoiretOne-Regular';

// square colors
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

// header texts
$textbox = new Box($im);
$textbox->setFontSize(20);
$textbox->setFontFace($font);
$textbox->setFontColor($gdBlack);
$textbox->setBox(15, 5, 105, 100);
$textbox->setTextAlign('right', 'top');
$textbox->draw("Contributions");

$textbox->setBox($width - 120, 5, 105, 100);
$textbox->draw("gitcase.leocardz.com");

// bottom box texts
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

// summary text
$textbox->setFontSize(17);
$textbox->setBox(10, $divisor_height_offset - 30, 400, 0);
$textbox->draw("Summary of Pull Requests, issues opened, and commits.");

// graph subtitle
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

// squares
$initial_square_x = $contributions_header_height + 10;
$initial_square_y = $contributions_header_height + 40;
$fixed_dimensions = 16;
$fixed_offset = 4;

$dayOfWeek = date("w", time()); // Today in day of week
$dateToday = date("Y-m-d");
$dateOneYearAgo = strtotime($dateToday . ' -1 year');
$diff = abs(strtotime($dateToday) - $dateOneYearAgo);
$days = floor($diff / (60 * 60 * 24));

$textbox->setFontColor($gdLighterGrey);

// We build backwards because we count from now to one year before
for ($i = 52; $i >= 0; $i--) {
    for ($j = 6; $j >= 0; $j--) {

        // months
        $analyzedDate = strtotime(date("Y-m-d", $dateOneYearAgo) . ' +' . $days . ' days');
        if ($j == 0 && date("d", $analyzedDate) < 8) {
            $textbox->setBox(
                $initial_square_x + ($fixed_dimensions + $fixed_offset) * $i,
                $initial_square_y - 22,
                400,
                0
            );
            $textbox->draw(date("M", $analyzedDate));
        }

        // squares
        if (($i < 52 || $j <= $dayOfWeek) && $days >= 0) {
            imagefilledrectangle(
                $im,
                $initial_square_x + ($fixed_dimensions + $fixed_offset) * $i,
                $initial_square_y + ($fixed_dimensions + $fixed_offset) * $j,
                $initial_square_x + ($fixed_dimensions + $fixed_offset) * $i + $fixed_dimensions,
                $initial_square_y + ($fixed_dimensions + $fixed_offset) * $j + $fixed_dimensions,
                $colors[rand(0, 4)]
            );
            $days--;
        }
    }
}

// weekdays on graph
$textbox->setFontColor($gdDarkerGrey);
$offset = 1;
$textbox->setBox(22, $initial_square_y + ($fixed_dimensions + $fixed_offset) * 1 - $offset, 400, 0);
$textbox->draw("M");
$textbox->setBox(22, $initial_square_y + ($fixed_dimensions + $fixed_offset) * 3 - $offset, 400, 0);
$textbox->draw("W");
$textbox->setBox(22, $initial_square_y + ($fixed_dimensions + $fixed_offset) * 5 - $offset, 400, 0);
$textbox->draw("F");
$textbox->setBox($width - 44, $initial_square_y + ($fixed_dimensions + $fixed_offset) * 1 - $offset, 400, 0);
$textbox->draw("M");
$textbox->setBox($width - 44, $initial_square_y + ($fixed_dimensions + $fixed_offset) * 3 - $offset, 400, 0);
$textbox->draw("W");
$textbox->setBox($width - 44, $initial_square_y + ($fixed_dimensions + $fixed_offset) * 5 - $offset, 400, 0);
$textbox->draw("F");


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