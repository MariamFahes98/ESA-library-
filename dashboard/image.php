<?php
// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Check if all required fields are set and not empty
    // $requiredFields = ['title', 'author', 'price', 'code', 'qty', 'category'];
    // foreach ($requiredFields as $field) {
    //     if (!isset($_POST[$field]) || empty(trim($_POST[$field]))) {
    //         die("Error: All fields are required.");
    //     }
    // }
    
    // Check if file was uploaded without errors
    if (isset($_FILES["filea"]) && $_FILES["filea"]["error"] == UPLOAD_ERR_OK) {
        
        // Define allowed file types
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        
        // Validate file type
        $fileType = $_FILES["filea"]["type"];
        if (!in_array($fileType, $allowedTypes)) {
            die("Error: Only JPG, PNG, and GIF files are allowed.");
        }
        
        // Generate a unique public_id for Cloudinary (using 'code' from form)
        $public_id = $_POST['code'];
        
        // Upload image to Cloudinary
        require 'Cloudinary.php';
        require 'Uploader.php';
        require 'Api.php';
        
        $cloudName = 'your_cloud_name';
        $apiKey = 'your_api_key';
        $apiSecret = 'your_api_secret';
        
        \Cloudinary::config(array(
            "cloud_name" => $cloudName,
            "api_key" => $apiKey,
            "api_secret" => $apiSecret
        ));
        
        try {
            $uploadResult = \Cloudinary\Uploader::upload($_FILES["filea"]["tmp_name"], [
                'folder' => 'your_folder_name', // Replace with your folder name on Cloudinary
                'public_id' => $public_id,
                'format' => "jpg", // Specify desired image format
                'transformation' => array(
                    array("width" => 500, "height" => 500, "crop" => "scale")
                )
            ]);
            
            if ($uploadResult && isset($uploadResult["secure_url"])) {
                $image_url = $uploadResult["secure_url"];
                echo "Image uploaded successfully to Cloudinary. URL: " . $image_url;
                
                // Now insert other form data into database (example)
                $title = $_POST['title'];
                $author = $_POST['author'];
                $price = $_POST['price'];
                $code = $_POST['code'];
                $qty = $_POST['qty'];
                $category = $_POST['category'];
                
                // Perform your database insert here
                // Example assuming $conn is your database connection
                $sql = "INSERT INTO book (title, author, price, code, quantity, CategoryID, image_url) 
                        VALUES ('$title','$author','$price','$code','$qty','$category','$image_url')";
                
                $result = mysqli_query($conn, $sql);
                
                if ($result) {
                    // Redirect after successful insertion
                    header("Location: book.php");
                    exit();
                } else {
                    echo "Error: " . mysqli_error($conn);
                }
            } else {
                echo "Failed to upload image to Cloudinary.";
            }
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
        
    } else {
        echo "Error: No file uploaded or upload error occurred.";
    }
}
?>
