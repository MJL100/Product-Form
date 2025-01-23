<?php
include 'dbconf.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate and sanitize inputs
    $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $stock_quantity = mysqli_real_escape_string($conn, $_POST['stock_quantity']);
    $image = $_FILES['image']['name'];

    // Image upload path
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($image);
    $uploadOk = true;

    // Check if uploads folder exists, if not, create it
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    // Validate file type
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $allowed_file_types = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array($imageFileType, $allowed_file_types)) {
        echo "Only JPG, JPEG, PNG, and GIF files are allowed.";
        $uploadOk = false;
    }

    // Check file size (limit: 2MB)
    if ($_FILES['image']['size'] > 2 * 1024 * 1024) {
        echo "File size exceeds 2MB.";
        $uploadOk = false;
    }

    // Check if the file is an actual image
    if ($uploadOk && !getimagesize($_FILES['image']['tmp_name'])) {
        echo "File is not a valid image.";
        $uploadOk = false;
    }

    // Attempt to upload the file and insert the data into the database
    if ($uploadOk) {
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            // Use prepared statement to insert data into the database
            $stmt = $conn->prepare("INSERT INTO product_db (product_name, price, description, image, category, stock_quantity) 
                                    VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sdsssi", $product_name, $price, $description, $image, $category, $stock_quantity);

            if ($stmt->execute()) {
                header("Location: viewproduct.php");  // Redirect to the product view page
                exit();
            } else {
                echo "Error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

// Close database connection
mysqli_close($conn);
?>
