<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Products</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Product List</h2>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Description</th>
                    <th>Image</th>
                    <th>Category</th>
                    <th>Stock Quantity</th>
                    <th>Actions</th> <!-- Added actions column for buttons -->
                </tr>
            </thead>
            <tbody>
                <?php
                include 'dbconf.php';
                $sql = "SELECT * FROM product_db";
                $result = $conn->query($sql);
                
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . $row['id'] . "</td>
                                <td>" . $row['product_name'] . "</td>
                                <td>" . $row['price'] . "</td>
                                <td>" . $row['description'] . "</td>
                                <td><img src='uploads/" . $row['image'] . "' alt='" . $row['product_name'] . "' width='100'></td>
                                <td>" . $row['category'] . "</td>
                                <td>" . $row['stock_quantity'] . "</td>
                                <td>
                                    <div class='btn-group'>
                                        <a href='updateproduct.php?id=" . $row['id'] . "' class='btn btn-warning me-2'>Edit</a>
                                        <a href='deleteproduct.php?id=" . $row['id'] . "' class='btn btn-danger'>Delete</a>
                                    </div>
                                </td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>No products found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>