<?php
include 'dbconf.php';

if (isset($_GET['id'])) {
    // Validate and sanitize the input
    $id = intval($_GET['id']); // Ensure the id is an integer

    // Prepare a SQL statement to delete the record
    $stmt = $conn->prepare("DELETE FROM product_db WHERE id = ?");
    $stmt->bind_param("i", $id); // Bind the integer parameter

    if ($stmt->execute()) {
        // Redirect to the product view page after successful deletion
        header("Location: viewproduct.php");
        exit();
    } else {
        // Log the error and display a generic message to the user
        error_log("Error deleting product: " . $stmt->error);
        echo "An error occurred while deleting the product.";
    }

    $stmt->close();
} else {
    echo "Invalid request: Missing product ID.";
}

// Close the database connection
$conn->close();
?>
