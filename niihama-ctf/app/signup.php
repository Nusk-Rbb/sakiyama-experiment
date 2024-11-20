<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // ... (retrieve form data as in previous examples)
    $username = $_POST['new_username'];
    $email = $_POST['new_email'];
    $password = $_POST['new_password'];

    try {
        $pdo = new PDO("pgsql:host=postgres;dbname=www", "apache", "passwordp");  // PostgreSQL connection
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Check if username or email already exists (important!)
        $stmt = $pdo->prepare('SELECT * FROM users WHERE email = :email OR username = :username');
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->fetch()) {
            echo 'Username or email already exists.';
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashedPassword);

            if ($stmt->execute()) {
                echo "Signup successful!"; // Redirect or display message
            } else {
                echo "Error during signup.";  // Provide more specific error messages
            }
        }

    } catch(PDOException $e) {
        echo "Database Error: " . $e->getMessage(); // Handle database errors
    }
}
?>