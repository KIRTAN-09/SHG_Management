<?php
// ...existing code...

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle POST request
    // Add your POST handling logic here
    // For example, you can access POST data using $_POST['key']
    $data = $_POST['data'];
    // Process the data
    // ...
    echo "POST request processed successfully.";
} else {
    // Handle other request methods (GET, HEAD, PUT, PATCH, DELETE)
    // ...existing code...
}

// ...existing code...
?>
