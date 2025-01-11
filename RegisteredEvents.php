<?php
require_once 'utils/header.php';
require_once 'utils/styles.php';


session_start();
if (isset($_SESSION['usn'])) {
    $usn = $_SESSION['usn'];
    echo "Rollno retrieved from session: $usn<br>";

    // Database connection
    $conn = new mysqli("localhost", "root", "", "cems",3308);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Query to fetch registered events
    $sqlRegistered = "SELECT r.event_id, e.Date, e.time, e.location 
                       FROM registered r 
                       JOIN event_info e ON r.event_id = e.event_id 
                       WHERE r.usn = '$usn'";
    $resultRegistered = $conn->query($sqlRegistered);

    // Query to fetch not registered events
    $sqlNotRegistered = "SELECT e.event_id, e.Date, e.time, e.location 
                          FROM event_info e 
                          WHERE e.event_id NOT IN (
                              SELECT event_id FROM registered WHERE usn = '$usn')";
    $resultNotRegistered = $conn->query($sqlNotRegistered);
} else {
    echo "USN not provided.<br>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registered Events</title>
    <style>
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #f4f4f4;
        }
        h2 {
            text-align: center;
        }
    </style>
</head>
<body>
    <h2>Registered Events</h2>
    <table>
        <tr>
            <th>Event ID</th>
            <th>Date</th>
            <th>Time</th>
            <th>Location</th>
        </tr>
        <?php
        if ($resultRegistered->num_rows > 0) {
            while ($row = $resultRegistered->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['event_id']}</td>
                        <td>{$row['Date']}</td>
                        <td>{$row['time']}</td>
                        <td>{$row['location']}</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No registered events found.</td></tr>";
        }
        ?>
    </table>

    <h2>Not Registered Events</h2>
    <table>
        <tr>
            <th>Event ID</th>
            <th>Date</th>
            <th>Time</th>
            <th>Location</th>
        </tr>
        <?php
        if ($resultNotRegistered->num_rows > 0) {
            while ($row = $resultNotRegistered->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['event_id']}</td>
                        <td>{$row['Date']}</td>
                        <td>{$row['time']}</td>
                        <td>{$row['location']}</td>
                      </tr>";
            }
        } else {
            echo "<tr><td colspan='4'>All events are registered.</td></tr>";
        }
        ?>
    </table>
</body>
</html>

<?php include 'utils/footer.php'; ?>