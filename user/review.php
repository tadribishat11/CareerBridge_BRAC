<?php
session_start();
require '../DBconnect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$message = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $review_text = $_POST['review_text'];
    $rating = $_POST['rating'];

    $stmt = $conn->prepare("INSERT INTO review (ID, REVIEW_TEXT, RATING) VALUES (?, ?, ?)");
    $stmt->bind_param("isi", $user_id, $review_text, $rating);

    if ($stmt->execute()) {
        $message = "Thank you for your review!";
    } else {
        $message = "Error submitting review: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Submit Review</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<div class="form-box">
    <h2>Submit a Review for the Website</h2>

    <?php if($message) echo "<p style='color:green;'>$message</p>"; ?>

    <form method="POST">
        <label>Rating (1-5):</label>
        <input type="number" name="rating" min="1" max="5" required>

        <label>Review:</label>
        <textarea name="review_text" placeholder="Write your review..." required></textarea>

        <button type="submit">Submit Review</button>
    </form>

    <br>
    <a href="dashboard.php">Back to Dashboard</a>
</div>
</body>
</html>
