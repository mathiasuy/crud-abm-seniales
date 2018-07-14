
<?php
$target_dir = "img/logo";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "Imagen: " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "Error, el archivo no es una imágen.";
        $uploadOk = 0;
    }
}
?>
