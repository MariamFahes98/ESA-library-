<!-- <?php
 

try {
    include 'includes/conn.php';
  
    // Connect to MySQL database
    // $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

    // Query to fetch data
    $query = "SELECT BookID, COUNT(*) AS purchase_count FROM buying GROUP BY BookID ORDER BY purchase_count DESC LIMIT 5";
    $stmt = $pdo->prepare($query);
    $stmt->execute();

    // Fetch all rows as associative array
    $salesData = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Format data for Chart.js
    $labels = [];
    $data = [];

    foreach ($salesData as $row) {
        $labels[] = $row['BookID'];
        $data[] = $row['purchase_count'];
    }

    // Prepare data in JSON format
    $response = [
        'labels' => $labels,
        'data' => $data
    ];

    // Send JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
} catch (PDOException $e) {
    die("Error: " . $e->getMessage());
}
?> 
 -->
