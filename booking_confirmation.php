<?php
session_start();
include('includes/config.php');

// Check if the booking ID is present in the URL
if (isset($_GET['tblbooking.BookingId'])) {
    $booking_id = intval($_GET['tblbooking.BookingId']);

    // Fetch booking details based on the booking ID
    $sql =  "SELECT tblbooking.FromDate, tblbooking.ToDate, tblbooking.Comment, tbltourpackages.PackageName, tbltourpackages.PackageLocation 
    FROM tblbooking  
    JOIN tbltourpackages  ON tblbooking.PackageId = tbltourpackages.PackageId
    WHERE tblbooking.BookingId = :tblbooking";
    $query = $dbh->prepare($sql);
    $query->bindParam(':tblbooking.BookingId', $booking_id, PDO::PARAM_INT);
    $query->execute();

    $result = $query->fetch(PDO::FETCH_ASSOC);
    if (!$result) {
        $error = "Booking not found.";
    }
} else {
    $error = "Invalid booking request.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Booking Confirmation</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Roboto', sans-serif;
      background-color: #f9f9f9;
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .confirmation-container {
      max-width: 600px;
      background-color: #fff;
      padding: 20px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      text-align: center;
      border-radius: 8px;
    }
    h1 {
      color: #5cb85c;
    }
    p {
      margin: 15px 0;
      font-size: 16px;
    }
    .details {
      background-color: #f1f1f1;
      padding: 15px;
      border-radius: 5px;
      text-align: left;
      margin-bottom: 20px;
    }
    .details p {
      margin: 8px 0;
    }
    .btn {
      background-color: #5cb85c;
      color: white;
      padding: 12px 20px;
      border: none;
      border-radius: 5px;
      font-size: 16px;
      cursor: pointer;
      text-decoration: none;
    }
    .btn:hover {
      background-color: #4cae4c;
    }
  </style>
</head>
<body>

  <div class="confirmation-container">
    <?php if (isset($error)): ?>
      <h1>Booking Error</h1>
      <p><?php echo htmlentities($error); ?></p>
      <a href="index.php" class="btn">Return to Home</a>
    <?php else: ?>
      <h1>Booking Confirmed!</h1>
      <p>Thank you for booking your tour with us. Below are your booking details:</p>

      <!-- Booking Details -->
      <div class="details">
        <h3>Your Booking Details</h3>
        <p><strong>Destination:</strong> <?php echo htmlentities($result['PackageLocation']); ?></p>
        <p><strong>Travel Dates:</strong> <?php echo htmlentities($result['FromDate']) . ' - ' . htmlentities($result['ToDate']); ?></p>
        <p><strong>Comment:</strong> <?php echo htmlentities($result['Comment']); ?></p>
        <p><strong>Package:</strong> <?php echo htmlentities($result['PackageName']); ?></p>
      </div>

      <!-- Call to Action Button -->
      <a href="index.php" class="btn">Return to Home</a>
    <?php endif; ?>
  </div>

</body>
</html>