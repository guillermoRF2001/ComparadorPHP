<?php 
// Include the database configuration file  
require_once './BDconfig.php'; 
 
// If file upload form is submitted 
$status = $statusMsg = ''; 
if(isset($_POST["submit"])){ 
    $status = 'error'; 
    if(!empty($_FILES["image"]["name"])) { 
        // Get file info 
        $fileName = basename($_FILES["image"]["name"]); 
        $fileType = $_FILES["image"]["type"];
         
        // Allow certain file formats 
        $allowTypes = array('image/jpeg', 'image/png', 'image/gif'); 
        if(in_array($fileType, $allowTypes)){ 
            $image = $_FILES['image']['tmp_name']; 
            
            // Read image content and escape it
            $imgContent = mysqli_real_escape_string($conn, file_get_contents($image)); 
         
            // Update image content into database 
            $result = mysqli_query($conn, "UPDATE portatil SET imagen = '$imgContent' WHERE id = 60");
             
            if($result){ 
                $status = 'success'; 
                $statusMsg = "File uploaded successfully."; 
            }else{ 
                $statusMsg = "File upload failed, please try again."; 
            }  
        }else{ 
            $statusMsg = 'Sorry, only JPG, JPEG, PNG, & GIF files are allowed to upload.'; 
        } 
    }else{ 
        $statusMsg = 'Please select an image file to upload.'; 
    } 
} 
 
// Display status message 
echo $statusMsg; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compu</title>
    <link rel="icon" href="/ComparadorPHP/img/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="/ComparadorPHP/styles/style.css">
</head>
<body>
    <!-- Header -->
    <?php include '../components/header.php'?>

    <form method="post" enctype="multipart/form-data">
        <label>Select Image File:</label>
        <input type="file" name="image">
        <input type="submit" name="submit" value="Upload">
    </form>
</body>
</html>