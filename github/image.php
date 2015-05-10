<?php
/**
 * Created by PhpStorm.
 * User: leocardz
 * Date: 05/05/15
 * Time: 18:21
 */

date_default_timezone_set("UTC");

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
$textDrawn = new Box($im);
$textDrawn->setFontSize(20);
$textDrawn->setFontFace($font);
$textDrawn->setFontColor($gdBlack);
$textDrawn->setBox(15, 5, 105, 100);
$textDrawn->setTextAlign('right', 'top');
$textDrawn->draw("Contributions");

$textDrawn->setBox($width - 120, 5, 105, 100);
$textDrawn->draw("gitcase.leocardz.com");

$textDrawn->setTextAlign('left', 'top');
// summary text
$textDrawn->setFontSize(17);
$textDrawn->setBox(10, $divisor_height_offset - 30, 400, 0);
$textDrawn->draw("Summary of Pull Requests, Issues opened, and Commits.");

// graph subtitle
$textDrawn->setBox($width - 220, $divisor_height_offset - 30, 400, 0);
$textDrawn->draw("Less");

$textDrawn->setBox($width - 50, $divisor_height_offset - 30, 400, 0);
$textDrawn->draw("More");

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

$textDrawn->setFontColor($gdLighterGrey);

$maxCommitAmmount = $_POST["maxCommitAmmount"];
$scale1Range = 10;
$scale2Range = 15;
$scale3Range = 20;

$textDrawn->setFontSize(12);
$textDrawn->setBox($stepback - 164, $divisor_height_offset - 45, 400, 0);
$textDrawn->draw("0");
$textDrawn->setBox($stepback - 145, $divisor_height_offset - 45, 400, 0);
$textDrawn->draw("<" . $scale1Range);
$textDrawn->setBox($stepback - 120, $divisor_height_offset - 45, 400, 0);
$textDrawn->draw("<" . $scale2Range);
$textDrawn->setBox($stepback - 97, $divisor_height_offset - 45, 400, 0);
$textDrawn->draw("<" . $scale3Range);
$textDrawn->setBox($stepback - 71, $divisor_height_offset - 45, 400, 0);
$textDrawn->draw("≥" . $scale3Range);

// We build backwards because we count from now to one year before
$datesArray = $_POST['datesArray'];
$datesArray['2015-05-10'] = 1;
for ($i = 52; $i >= 0; $i--) {
    for ($j = 6; $j >= 0; $j--) {

        // months
        $analyzedDate = strtotime(date("Y-m-d", $dateOneYearAgo) . ' +' . $days . ' days');
        if ($j == 0 && date("d", $analyzedDate) < 8) {
            $textDrawn->setBox(
                $initial_square_x + ($fixed_dimensions + $fixed_offset) * $i,
                $initial_square_y - 22,
                400,
                0
            );
            $textDrawn->draw(date("M", $analyzedDate));
        }

        $color = 0;
        $analyzedDateString = date("Y-m-d", $analyzedDate);
        if (array_key_exists($analyzedDateString, $datesArray)) {
            $currentDayCommitsAmount = $datesArray[$analyzedDateString];
            if ($currentDayCommitsAmount > 0 && $currentDayCommitsAmount < $scale1Range) {
                $color = 1;
            } else if ($currentDayCommitsAmount >= $scale1Range && $currentDayCommitsAmount < $scale2Range) {
                $color = 2;
            } else if ($currentDayCommitsAmount >= $scale2Range && $currentDayCommitsAmount < $scale3Range) {
                $color = 3;
            } else if ($currentDayCommitsAmount >= $scale3Range) {
                $color = 4;
            }
        }

        // squares
        if (($i < 52 || $j <= $dayOfWeek) && $days >= 0) {
            imagefilledrectangle(
                $im,
                $initial_square_x + ($fixed_dimensions + $fixed_offset) * $i,
                $initial_square_y + ($fixed_dimensions + $fixed_offset) * $j,
                $initial_square_x + ($fixed_dimensions + $fixed_offset) * $i + $fixed_dimensions,
                $initial_square_y + ($fixed_dimensions + $fixed_offset) * $j + $fixed_dimensions,
                $colors[$color]
            );
            $days--;
        }
    }
}

// weekdays on graph
$textDrawn->setFontColor($gdDarkerGrey);
$offset = 1;
$textDrawn->setBox(22, $initial_square_y + ($fixed_dimensions + $fixed_offset) * 1 - $offset, 400, 0);
$textDrawn->draw("M");
$textDrawn->setBox(22, $initial_square_y + ($fixed_dimensions + $fixed_offset) * 3 - $offset, 400, 0);
$textDrawn->draw("W");
$textDrawn->setBox(22, $initial_square_y + ($fixed_dimensions + $fixed_offset) * 5 - $offset, 400, 0);
$textDrawn->draw("F");
$textDrawn->setBox($width - 44, $initial_square_y + ($fixed_dimensions + $fixed_offset) * 1 - $offset, 400, 0);
$textDrawn->draw("M");
$textDrawn->setBox($width - 44, $initial_square_y + ($fixed_dimensions + $fixed_offset) * 3 - $offset, 400, 0);
$textDrawn->draw("W");
$textDrawn->setBox($width - 44, $initial_square_y + ($fixed_dimensions + $fixed_offset) * 5 - $offset, 400, 0);
$textDrawn->draw("F");


// bottom box texts
$textDrawn = new Box($im);
$textDrawn->setFontSize(20);
$textDrawn->setFontFace($font);
$textDrawn->setFontColor($gdDarkerGrey);
$textDrawn->setTextAlign('center', 'top');

$textDrawn->setBox($divisor_width_offset, $divisor_height_texts_offset, $divisor_width_offset, 0);
$textDrawn->draw("In the last year");

$textDrawn->setBox($divisor_width_offset * 4, $divisor_height_texts_offset, $divisor_width_offset, 0);
$textDrawn->draw("Longest streak");

$textDrawn->setBox($divisor_width_offset * 7, $divisor_height_texts_offset, $divisor_width_offset, 0);
$textDrawn->draw("Current streak");


// streaks
$textDrawn->setFontSize(15);
$textDrawn->setBox(0, $divisor_height_texts_offset + 100, $divisor_width_offset * 3, 0);
$textDrawn->draw(date("M d, Y") . " - " . date("M d, Y", $dateOneYearAgo));

$longestStreakStart = "";
$longestStreakEnd = "";
$currentStreakStart = "";
$currentStreakEnd = "";
$longestStreakAmount = 0;
$currentStreakAmount = 0;
ksort($datesArray);
foreach ($datesArray as $day => $commits) {

    if ($longestStreakStart === "") $longestStreakStart = $day;
    if ($longestStreakEnd === "") $longestStreakEnd = $day;

    if ($currentStreakStart === "") $currentStreakStart = $day;
    if ($currentStreakEnd === "") $currentStreakEnd = $day;

    if ($commits != 0) {

        $currentStreakEnd = $day;

        $currentDiff = floor(abs(strtotime($currentStreakEnd) - strtotime($currentStreakStart)) / (60 * 60 * 24));
        $longestDiff = floor(abs(strtotime($longestStreakEnd) - strtotime($longestStreakStart)) / (60 * 60 * 24));
        if ($currentDiff > $longestDiff) {
            $longestStreakStart = $currentStreakStart;
            $longestStreakEnd = $currentStreakEnd;
            $longestStreakAmount = $currentDiff;
        }

        $currentStreakAmount = $currentDiff;

    } else {

        $currentStreakStart = $day;
        $currentStreakEnd = $day;
        $currentStreakAmount = 0;

    }

}

$textDrawn->setBox($divisor_width_offset * 3, $divisor_height_texts_offset + 100, $divisor_width_offset * 3, 0);
// if are in the same year then do not show the year
$textDrawn->draw(date("M d, Y", strtotime($longestStreakStart)) . " - " . date("M d, Y", strtotime($longestStreakEnd)));

$textDrawn->setBox($divisor_width_offset * 6, $divisor_height_texts_offset + 100, $divisor_width_offset * 3, 0);
// if are in the same year then do not show the year
$textDrawn->draw(date("M d, Y", strtotime($currentStreakStart)) . " - " . date("M d, Y", strtotime($currentStreakEnd)));

$textDrawn = new Box($im);
$textDrawn->setFontSize(50);
$textDrawn->setFontFace($font);
$textDrawn->setFontColor($gdBlack);
$textDrawn->setTextAlign('center', 'center');

$number = $_POST["total"];
$textDrawn->setBox($divisor_width_offset, $divisor_height_texts_offset + 50, $divisor_width_offset, 0);
$textDrawn->draw(number_format($number));

$textDrawn->setBox($divisor_width_offset * 4, $divisor_height_texts_offset + 50, $divisor_width_offset, 0);
$textDrawn->draw($longestStreakAmount);

$textDrawn->setBox($divisor_width_offset * 7, $divisor_height_texts_offset + 50, $divisor_width_offset, 0);
$textDrawn->draw($currentStreakAmount);

$textDrawn->setFontSize(20);
$textDrawn->setBox($divisor_width_offset, $divisor_height_texts_offset + 85, $divisor_width_offset, 0);
$textDrawn->draw("total");

$textDrawn->setBox($divisor_width_offset * 4, $divisor_height_texts_offset + 85, $divisor_width_offset, 0);
$textDrawn->draw("days");

$textDrawn->setBox($divisor_width_offset * 7, $divisor_height_texts_offset + 85, $divisor_width_offset, 0);
$textDrawn->draw("days");


ob_start();
imagepng($im);
$contents = ob_get_contents();
ob_end_clean();

echo "data:image/png;base64," . base64_encode($contents);

imagedestroy($im);