<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "library";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die(json_encode(['success' => false, 'message' => 'Connection failed: ' . mysqli_connect_error()]));
}

header('Content-Type: application/json');

$response = ['success' => false, 'message' => 'Unknown error'];

try {
    if (isset($_GET['roomId'])) {
        $roomId = intval($_GET['roomId']);

        // Fetch room details
        $sql_room = "SELECT roomId, location, capacity, price FROM room WHERE roomId = ?";
        $stmt_room = $conn->prepare($sql_room);
        $stmt_room->bind_param("i", $roomId);
        $stmt_room->execute();
        $result_room = $stmt_room->get_result();

        if ($result_room->num_rows > 0) {
            $room = $result_room->fetch_assoc();

            // Initialize arrays to store reserved and available times
            $days = [];
            for ($i = 0; $i <= 5; $i++) { // Adjusted to fetch data for 10 days
                $date = date('Y-m-d', strtotime("+$i days"));
                $days[$date] = [
                    'reserved_times' => [],
                    'available_times' => []
                ];
            }

            // Fetch reserved times for the room over the next 10 days
            $sql_reserved_times = "SELECT Date, time FROM reservation WHERE roomId = ? AND Date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 10 DAY)";
            $stmt_reserved_times = $conn->prepare($sql_reserved_times);
            $stmt_reserved_times->bind_param("i", $roomId);
            $stmt_reserved_times->execute();
            $result_reserved_times = $stmt_reserved_times->get_result();

            while ($row_reserved = $result_reserved_times->fetch_assoc()) {
                $days[$row_reserved['Date']]['reserved_times'][] = $row_reserved['time'];
            }

            $stmt_reserved_times->close();

            // Generate available times from 9am to 4pm (assuming 24-hour format) for each day
            $start_time = 9; // Start from 9am (9:00)
            $end_time = 16;  // End at 4pm (16:00)
            foreach ($days as $date => &$day) {
                for ($i = $start_time; $i < $end_time; $i++) {
                    $time_slot = sprintf('%02d:00', $i); // Format as HH:00
                    // Check if the time slot is not in the reserved times for the same date
                    if (!in_array($time_slot, $day['reserved_times'])) {
                        $day['available_times'][] = [
                            'time' => $time_slot,
                            'date' => $date
                        ];
                    }
                }
            }

            // Prepare success response
            $response = [
                'success' => true,
                'room' => $room,
                'days' => $days
            ];
        } else {
            $response = ['success' => false, 'message' => 'Room not found'];
        }

        $stmt_room->close();
    } else {
        $response = ['success' => false, 'message' => 'Incomplete parameters'];
    }
} catch (Exception $e) {
    $response = ['success' => false, 'message' => $e->getMessage()];
}

echo json_encode($response);

$conn->close();
?>
