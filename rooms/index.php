<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rooms</title>
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="./rooms.css">
    <style>
        .medal {
            position: relative;
            overflow: hidden;
        }
        .medal img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>
</head>
<body>
<div class="navbar">
                     <div class="hamburger" onclick="toggleMenu()">
                       <div></div>
                       <div></div>
                       <div></div>
                    </div>
                    <div class="logo"><img src="../Index/images/logo.png" alt="logo"></div>
                    <div class="nav" >
                        <ul>
                            <li><a href="../Index/index.php">Home</a></li>
                        
                            <li><a href="../books/allavailablebook.php">Books</a></li>
                            <li><a href="#">Rooms</a></li>
                            <li><a href="../signupin/signin.php">Login</a></li>
                        </ul>
                        <div class="signup">
                            <button onclick="location.href='../signupin/signup.php'" style="margin-left: 30px;">Sign Up</button>
                        </div>
                    </div>
                </div>
    <div class="main_container">
        <div class="flex_container_nowrap between">
            <div>
                Book a meeting Room
            </div>
            <div>
                <div class="search-input">
                    <div class="flexbox">
                        <div class="search">
                            <div>
                                <input type="number" id="capacitySearch" placeholder="Enter capacity..." min="1">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="rooms centered" id="rooms">
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

            $sql = "SELECT roomId, location, capacity, price FROM room";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="room flex_container_nowrap vertical mb-3 " data-capacity="' . $row["capacity"] . '">';
                    echo '<div class="head"></div>';
                    echo '<div class="medal">';
                    $imgSrc = '../dashboard/roomimage/' . $row["roomId"] . '.jpg';
                    echo '<img src="' . $imgSrc . '" alt="Room Image" class="img">';
                    echo '</div>';
                    echo '<div class="bottom text-center">';
                    echo '<div id="name_room" class="name_room text-center">Room ' . $row["roomId"] . '</div>';
                    echo '<div class="flex_container_nowrap centered info_divs capacity_room_div">';
                    echo '<div class="title">Capacity:</div>';
                    echo '<div class="value">' . $row["capacity"] . ' people</div>';
                    echo '</div>';
                    echo '<div class="flex_container_nowrap centered">';
                    echo '<div class="title">Address:</div>';
                    echo '<div class="value">' . $row["location"] . '</div>';
                    echo '</div>';
                    echo '<button type="button" class="book_now learn_more" data-room-id="' . $row["roomId"] . '">Learn More</button><br><br>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
            
                echo "0 results";
            }

            $conn->close();
            ?>
            
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.learn_more').forEach(button => {
                button.addEventListener('click', async function() {
                    const roomId = this.getAttribute('data-room-id');
                    
                    const response = await fetch(`./getRoomDetails.php?roomId=${roomId}`);
                    const data = await response.json();

                    if (data.success) {
                        displayRoomDetails(data.room, data.days);
                    } else {
                        alert(data.message);
                    }
                });
            });

            document.getElementById('capacitySearch').addEventListener('input', function() {
                const capacity = parseInt(this.value, 10);
                if (isNaN(capacity) || capacity < 1) {
                    return; // Ignore invalid or non-positive inputs
                }

                const rooms = document.querySelectorAll('.room');
                rooms.forEach(room => {
                    const roomCapacity = parseInt(room.getAttribute('data-capacity'), 10);
                    if (roomCapacity >= capacity) {
                        room.style.display = 'block';
                    } else {
                        room.style.display = 'none';
                    }
                });
            });

            function displayRoomDetails(room, days) {
                console.log(room); // Output room details to console (for testing)
                console.log(days); // Output days with available and reserved times to console (for testing)

                let modalContent = `
                    <div class="modal-header">
                        <h5 class="modal-title">Room ${room.roomId}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Capacity:</strong> ${room.capacity} people</p>
                        <p><strong>Location:</strong> ${room.location}</p>
                        <p><strong>Price:</strong> ${room.price}</p>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Reserved Times</th>
                                    <th>Available Times</th>
                                </tr>
                            </thead>
                            <tbody>
                `;

                for (const [date, times] of Object.entries(days)) {
                    modalContent += `
                        <tr>
                            <td>${date}</td>
                            <td>
                                <ul>
                                    ${times.reserved_times.length > 0 ? times.reserved_times.map(time => `<li>${time}</li>`).join('') : '<li>No reserved times</li>'}
                                </ul>
                            </td>
                            <td>
                                <ul>
                                    ${times.available_times.length > 0 ? times.available_times.map(time => `
                                        <li style="color: ${times.reserved_times.includes(time) ? 'red' : 'inherit'}">${time.time}</li>
                                    `).join('') : '<li>No available times</li>'}
                                </ul>
                            </td>
                        </tr>
                    `;
                }

                modalContent += `
                            </tbody>
                        </table>
                    </div>
                `;

                const modal = new bootstrap.Modal(document.getElementById('roomModal'));
                document.getElementById('modalContent').innerHTML = modalContent;
                modal.show();
            }
        });
    </script>

    <div class="modal fade" id="roomModal" tabindex="-1" aria-labelledby="roomModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div id="modalContent"></div>
            </div>
        </div>
    </div>
</body>
</html>
