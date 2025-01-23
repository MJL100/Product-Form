<?php
include 'dbconf.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM product_db WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_name = $_POST['product_name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $stock_quantity = $_POST['stock_quantity'];

    $sql = "UPDATE product_db SET product_name='$product_name', price='$price', description='$description', category='$category', stock_quantity='$stock_quantity' WHERE id = $id";

    if (mysqli_query($conn, $sql)) {
        header("Location: viewproduct.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>

<form action="updateproduct.php?id=<?php echo $id; ?>" method="POST" class="p-4 border rounded bg-light shadow-sm">
    <label for="product_name">Product Name</label>
    <input type="text" name="product_name" value="<?php echo $row['product_name']; ?>" class="form-control" required><br>

    <label for="price">Price</label>
    <input type="text" name="price" value="<?php echo $row['price']; ?>" class="form-control" required><br>

    <label for="description">Description</label>
    <textarea name="description" class="form-control" required><?php echo $row['description']; ?></textarea><br>

    <label for="category">Category</label>
    <select name="category" class="form-select" required>
        <option value="Electronics" <?php if ($row['category'] == 'Electronics') echo 'selected'; ?>>Electronics</option>
        <option value="Clothing" <?php if ($row['category'] == 'Clothing') echo 'selected'; ?>>Clothing</option>
        <option value="Home" <?php if ($row['category'] == 'Home') echo 'selected'; ?>>Home</option>
    </select><br>

    <label for="stock_quantity">Stock Quantity</label>
    <input type="number" name="stock_quantity" value="<?php echo $row['stock_quantity']; ?>" class="form-control" required><br>

    <button type="submit" class="btn btn-light text-dark">Update Product</button>
</form>