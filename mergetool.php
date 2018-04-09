<?php
session_start();
require_once('./models/PICmodel.php');
require_once('./controllers/services/inputFilters.php');

if (isset($_POST['raw'], $_POST['f']) && !empty($_POST['raw']) && !empty($_POST['f'])) {
    if (isset($_POST['src'])) {
        merge($_POST['raw'], $_POST['f'], $_POST['src']);
    } else {
        merge($_POST['raw'], $_POST['f']);
    }
} else {
    echo "Error ...";
}

function merge($raw, $filter, $src=null)
{
    $raw = check_input($raw);
    $filter = check_input($filter);

    date_default_timezone_set('Europe/Paris');
    $timestamp = date("YmdHis");
    $picture = new PICmodel();

    if (!file_exists('./masterpiece')) {
        mkdir('./masterpiece', 0755, true);
    }

    if ($raw && ($filter > 0) || ($filter < 5)) {
        $tmp_raw = $raw;
        $tmp_raw = str_replace('data:image/png;base64,', '', $tmp_raw);
        $tmp_raw = str_replace(' ', '+', $tmp_raw);
        $raw = $tmp_raw;

        file_put_contents('./masterpiece/IMG_' . $timestamp . '.png', base64_decode($raw));
        $photo = imagecreatefrompng('./masterpiece/IMG_' . $timestamp . '.png');

        switch ($filter) {
            case 1:
                $filter = imagecreatefrompng('./views/filters/bulbizard.png');
                break;
            case 2:
                $filter = imagecreatefrompng('./views/filters/salameche.png');
                break;
            case 3:
                $filter = imagecreatefrompng('./views/filters/carapuce.png');
                break;
            case 4:
                $filter = imagecreatefrompng('./views/filters/pikachu.png');
                break;
            default:
                echo "An error occured, please select a starter";
        }

        imagealphablending($filter, true);
        imagesavealpha($filter, true);

        imagecopy($photo, $filter, 100,120,0,0,200,200);

        imagepng($photo, './masterpiece/IMG_' . $timestamp . '.png');
        $path = './masterpiece/IMG_' . $timestamp . '.png';

        imagedestroy($photo);
        imagedestroy($filter);

        $id = $picture->getUserID($_SESSION['username']);
        $picture->saveMerging($id['ID'], $path, $timestamp);
        echo './masterpiece/IMG_' . $timestamp . '.png';

        if ($src !== null) {
            $src = explode("/uploads/", $src);
            unlink("./uploads/".$src[1]);
        }
    }
}