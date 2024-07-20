<?php
if (isset($_FILES['image'])) {
    echo '<pre>';
    print_r($_FILES);
    echo '</pre>';
    $file_name = $_FILES['image']['name'];
    $file_size = $_FILES['image']['size'];
    $file_temp = $_FILES['image']['temp_name'];
    $file_type = $_FILES['image']['type'];
    $sql = "insert into students (stud_name,stud_image)..... values(........,$file_name)";
    move_uploaded_file($file_temp, "upload/departments/" . $file_name);
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="file" name="image" id="image">
        <input type="submit" value="submit">
    </form>
</body>

</html>