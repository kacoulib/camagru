<?php
session_start();
if (empty($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

$up_status = true;
$response = null;
$maxsize = 1048576;
$maxwidth = 480;
$maxheight = 320;
$dir = "uploads/";
$uri = null;

$upinfo = null;

$valid_mime = array('image/jpg', 'image/jpeg', 'image/png');
$valid_ext = array('jpg', 'jpeg', 'png');

if (isset($_POST['upsubmit'], $_POST['upfilter'], $_FILES['uploadFile']['name'])) {
    if ($_POST['upfilter'] > 0 && $_POST['upfilter'] < 5) {
        $upname = $_FILES['uploadFile']['name'];
        $uptype = $_FILES['uploadFile']['type'];
        $upsize = $_FILES['uploadFile']['size'];
        $uptmp = $_FILES['uploadFile']['tmp_name'];
        $uperr = $_FILES['uploadFile']['error'];

        if ($uperr > 0) {
            $response = "UPLOAD_ERR_CODE : " . $uperr;
            $up_status = false;
        } else {

            $upinfo = getimagesize($uptmp);
            $upext = strtolower(substr(strrchr($upname, '.'), 1));

            if (!in_array($upinfo['mime'], $valid_mime)) {
                $response = "Invalid file";
                $up_status = false;
            } else if ($upsize > $maxsize) {
                $response = "File is too large";
                $up_status = false;
            } else if (!in_array($upext, $valid_ext)) {
                $response = "Invalid extension. Only JPG, JPEG, PNG are allowed";
                $up_status = false;
            } else if (($upinfo[0] > $maxwidth) || ($upinfo[1] > $maxheight)) {
                $response = "Max file width: " . $maxwidth . " height: " . $maxheight;
                $up_status = false;
            } else if ($up_status) {
                $name = md5(uniqid(rand(), true));
                $uri = $dir . $name . "." . $upext;

                if (!file_exists($dir)) {
                    mkdir($dir, 0755, true);
                }
                if (move_uploaded_file($uptmp, $uri)) {
                    $response = "OK";
                } else {
                    $response = "Error during transfer ...";
                }
            }
        }
    } else {
        $response = "Do not remove disabled tag";
    }
}
?>

<script>
    window.top.window.uploadEnd("<?php echo $response; ?>", "<?php echo $uri; ?>");
</script>