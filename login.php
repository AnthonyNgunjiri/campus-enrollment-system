<?php


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Change these values according to your database settings
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "db_admission";


    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve values from form
    $email = $_POST['email'];
    $contact = $_POST['contact'];

    // SQL query to check if the user exists
    $sql = "SELECT * FROM student WHERE email='$email' AND contact='$contact'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // User exists, set session variables
        $_SESSION['loggedin'] = true;
        $_SESSION['email'] = $email;

        // Insert login information into the 'login' table
        $insert_sql = "INSERT INTO login (email, contact) VALUES ('$email', '$contact')";
        if ($conn->query($insert_sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $insert_sql . "<br>" . $conn->error;
        }

        header("Location:course.html"); // Redirect to admission.php upon successful login
    } else {
        // User does not exist or credentials are incorrect
        echo "Invalid email or contact number. Please try again.";
    }

    $conn->close();
}
?>

