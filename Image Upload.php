<?php

$server = "localhost";
$username = "root";
$pass = "";
$database = "Image_Upload";
$con = mysqli_connect($server, $username, $pass, $database);

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_FILES["image"]["name"];
    $tmpname = $_FILES["image"]["tmp_name"];
    $type = $_FILES["image"]["type"];

    $file_extension = pathinfo($name, PATHINFO_EXTENSION);

    if ($type === 'image/png' && $file_extension === 'png') {
        $upload = move_uploaded_file($tmpname, "upload-images/" . $name);

        if ($upload) {
            $fullpath = "upload-images/" . $name;
            $sqlinsert = "INSERT INTO images (file_name, file_type) VALUES ('$name', '$type')";
            $res = mysqli_query($con, $sqlinsert);

            if ($res) {
                echo "File inserted";
            }
        } else {
            echo "Failed to upload the file.";
        }
    } else {
        echo "Only PNG files are allowed.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="Image Upload.php" method="post" enctype="multipart/form-data">

        <input type="file" name="image" id="">
        <input type="submit" value="Submit">

    </form>
</body>
</html>
