<?php
// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve username and password
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Database connection (PostgreSQL)
    try {
        $pdo = new PDO("pgsql:host=postgres;dbname=www", "apache", "passworda");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            // Login successful (set session variables, redirect, etc.)
            session_start();
            $_SESSION['username'] = $username;
            header("Location: index.html"); // Redirect to protected page
            exit;
        } else {
            echo "Invalid username or password.";
        }
    } catch (PDOException $e) {
        echo "Database Error: " . $e->getMessage();
    }
}
?>