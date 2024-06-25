<?php
require '/cloud/vendor/autoload.php';
use Cloudinary\Configuration\Configuration;
use Cloudinary\Api\Upload\UploadApi;

Configuration::instance([
    'cloud' => [
      'cloud_name' => 'kaw-ets', 
      'api_key' => '249339831696657', 
      'api_secret' => 'iCKWYDwB8HUdFPzSpYttcN6oI7E'],
    'url' => [
      'secure' => true]]);

      $folder = 'lib';
    //   $filename = 'id3';
      $conn = new mysqli('localhost', 'root', '', 'crud');

      if ($conn->connect_error) {
          die("Connection failed: " . $conn->connect_error);
      }
  
      if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["filea"])) {
        $title = $_POST['title'];
    
  
        $sql=" INSERT INTO test (title) 
        VALUES ('$title')";
$resulta=mysqli_query($conn, $sql);

if ($resulta) {
    // Get the ID of the last inserted row
    header("Location: index.php");

    // Display the ID of the last inserted row
    echo $last_insert_id;
  
} else {
    echo "Error inserting record: " . mysqli_error($conn);
}

// $row=mysqli_fetch_row($resulta);
// echo $row[0];
// if ($row) {
//     // Output the first column value (id)
//     echo "ID: " . $row[0];
// } else {
//     echo "No rows found";
// }
if ($resulta) {
    // $_SESSION['message'] = "Data Saved Successfully";
       header("Location: index.php");
    } else {
       mysqli_close($conn);
    }

        // Upload image to Cloudinary
        $file = $_FILES["filea"]["tmp_name"];
        $uploadApi = new UploadApi();

// Upload the image with the specified folder
$result = $uploadApi->upload($file, [
    'folder' => $folder,
    // 'public_id' => $filename 
]);
// echo "URL=" .$result['secure_url']. "<br/>";
// echo "public-id=" .$result['public_id']. "<br/>";

// // Print the result (optional, for debugging)
//  print_r($result);
       
// if (isset($_POST['add'])) {
	// $title = $_POST['title'];
    
  
    // $sql=" INSERT INTO test (title) 
    // VALUES ('$title')";
    // }

// $result = \Cloudinary\Uploader::upload($file);
    
//         // Check if upload was successful
print_r($result);
    }
    if ($result) {
        $image_url = $result["secure_url"];
        $image_id1 = $result["public_id"];
        echo "Image uploaded successfully. URL: " . $image_url;
        echo "Image uploaded successfully. id: " . $image_url1;
        // Here you can save $image_url to your database or use it as needed
    } else {
        echo "Failed to upload image.";
    }

    echo "URL=" .$result['secure_url']. "<br/>";
    echo "public-id=" .$result['public_id']. "<br/>";
    
    // Print the result (optional, for debugging)
     print_r($result);
    //   (new UploadApi())->upload('admin.png')


      // $folder = 'lib';
      // $filename = 'id2';

// Instantiate the UploadApi
// $uploadApi = new UploadApi();

// // Upload the image with the specified folder
// $result = $uploadApi->upload('admin.png', [
//     'folder' => $folder,
//     'public_id' => $filename 
// ]);
// echo "URL=" .$result['secure_url']. "<br/>";
// echo "public-id=" .$result['public_id']. "<br/>";

// Print the result (optional, for debugging)
//  print_r($result);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Upload Image to Cloudinary</title>
</head>
<body>
    <form action="index.php" method="post" enctype="multipart/form-data">
        <input type="file" name="filea" accept="image/*">
        <input type="text" name="title">
        <button type="submit" name="add">Upload Image</button>
    </form>

</body>
</html>