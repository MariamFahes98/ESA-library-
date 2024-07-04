<?php
session_start();
$dbhost = 'localhost';
$dbname = 'library';
$dbpass = '';
$dbuser = 'root';
$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
   

    if (isset($_SESSION['UserID'])) {
        $UserID = $_SESSION['UserID'];
        $bookId = $_SESSION['BookID'];

        $stmt1 = $conn->prepare("INSERT INTO buying (UserID, BookID, purchaseDate) VALUES (?, ?, NOW())");
        $stmt1->bind_param("ii", $UserID, $bookId);

        $stmt2 = $conn->prepare("UPDATE book SET sales_count = sales_count + 1 WHERE BookID = ?");
        $stmt2->bind_param("i", $bookId);
        $stmt2->execute();

        $stmt3 = $conn->prepare("UPDATE book SET quantity = quantity - 1 WHERE BookID = ?");
        $stmt3->bind_param("i", $bookId);
        $stmt3->execute();

        if ($stmt1->execute()) {
            echo "<script>  alert('May the book captivate your imagination and leave you inspired. !'); 
            window.location.href = './allavailablebook.php';
            </script>";
        } else {
            echo "Error: " . $stmt->error;
        }
        
        $stmt->close();
    } else {
        header("Location: signin.php");
        exit();
    }
}
$conn->close();
?>
