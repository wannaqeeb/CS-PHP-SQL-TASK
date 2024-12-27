<?php
$host = 'localhost';
$dbname = 'db_feedback';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = htmlspecialchars(trim($_POST['name']));
        $email = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
        $feedback = htmlspecialchars(trim($_POST['feedback']));

        if (!$email) {
            die("Invalid email format.");
        }

        if (empty($name) || empty($feedback)) {
            die("All fields are required.");
        }

        $sql = "INSERT INTO feedback (name, email, feedback) VALUES (:name, :email, :feedback)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':feedback', $feedback);
        
        if ($stmt->execute()) {
            echo "Thank you for your feedback!";
        } else {
            echo "An error occurred. Please try again later.";
        }
    }
} catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
}
?>
