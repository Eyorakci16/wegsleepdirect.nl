<?php
// Database connection settings
$host = "localhost"; // Change if using a remote database
$dbname = "wegsleepdirect";
$username = "your_db_user"; // Change to your database username
$password = "your_db_password"; // Change to your database password

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Connect to MySQL database
    $conn = new mysqli($host, $username, $password, $dbname);

    // Check for connection errors
    if ($conn->connect_error) {
        die("Database connection failed: " . $conn->connect_error);
    }

    // Sanitize & Validate input function
    function clean_input($data) {
        return htmlspecialchars(trim($data));
    }

    $name = clean_input($_POST['name']);
    $email = clean_input($_POST['email']);
    $phone = clean_input($_POST['phone']);
    $subject = clean_input($_POST['subject']);
    $message = clean_input($_POST['message']);

    // Validation: Ensure required fields are filled
    $errors = [];

    if (empty($name)) {
        $errors[] = "Naam is verplicht.";
    }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Voer een geldig e-mailadres in.";
    }
    if (empty($phone) || !preg_match('/^\+?[0-9\s\-]+$/', $phone)) {
        $errors[] = "Voer een geldig telefoonnummer in.";
    }
    if (empty($subject)) {
        $errors[] = "Onderwerp is verplicht.";
    }
    if (empty($message)) {
        $errors[] = "Bericht kan niet leeg zijn.";
    }

    // Show errors and stop execution if validation fails
    if (!empty($errors)) {
        echo "<div style='color: red; font-weight: bold;'>";
        foreach ($errors as $error) {
            echo "<p>$error</p>";
        }
        echo "</div>";
        exit;
    }

    // Prevent email header injection
    if (preg_match('/[\r\n]/', $name) || preg_match('/[\r\n]/', $email)) {
        die("Ongeldige invoer gedetecteerd.");
    }

    // Store in the database using prepared statement
    $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, phone, subject, message) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $email, $phone, $subject, $message);

    if ($stmt->execute()) {
        // Send an email notification
        $to = "info@wegsleepdirect.nl"; // Your email address
        $subjectEmail = "Nieuw contactbericht van: $name - $subject";
        $messageEmail = "
        Naam: $name\n
        E-mailadres: $email\n
        Telefoonnummer: $phone\n
        Onderwerp: $subject\n
        Bericht:\n$message
        ";

        // Email headers
        $headers = "From: $email\r\n";
        $headers .= "Reply-To: $email\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

        // Send the email
        mail($to, $subjectEmail, $messageEmail, $headers);

        // Success message
        echo "<p style='color: green; font-weight: bold;'>Bedankt voor uw bericht! We nemen zo snel mogelijk contact met u op.</p>";
    } else {
        echo "<p style='color: red; font-weight: bold;'>Er is een fout opgetreden. Probeer het later opnieuw.</p>";
    }

    // Close the database connection
    $stmt->close();
    $conn->close();
}

/*
    This SQL script creates the database and table needed to store contact form submissions.
    Add it to your hosting provider.

    -- Create a new database named 'wegsleepdirect'
    CREATE DATABASE wegsleepdirect;
    USE wegsleepdirect;

    -- Create the 'contact_messages' table to store form submissions
    CREATE TABLE contact_messages (
        id INT AUTO_INCREMENT PRIMARY KEY,  -- Unique ID for each message
        name VARCHAR(255) NOT NULL,         -- User's name (Required)
        email VARCHAR(255) NOT NULL,        -- User's email (Required)
        phone VARCHAR(50) NOT NULL,         -- User's phone number (Required)
        subject VARCHAR(255) NOT NULL,      -- Subject of the message (Required)
        message TEXT NOT NULL,              -- User's message (Required)
        submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP -- Timestamp of submission
    );
*/
?>
