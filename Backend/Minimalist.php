<?php
session_start();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$selectedType = $_GET['selected'] ?? '';
function isActive($type, $selectedType) {
    return $type === $selectedType ? 'active-button' : '';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['shirt'])) {
    $shirt = $_POST['shirt'];

    // Check if shirt already in cart
    if (isset($_SESSION['cart'][$shirt])) {
        $_SESSION['cart'][$shirt] += 1;
    } else {
        $_SESSION['cart'][$shirt] = 1;
    }

    echo "<script>alert('$shirt added to cart!');</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SweetChilly</title>
    <link rel="stylesheet" href="Styles.css">
</head>
<body>
    <div class="navbar">
        <a href="../Frontend/Index.html">Home</a>
        <a href="Classic.php">Shop</a>
        <a href="../Frontend/About.html">About</a>
        <a href="../Frontend/About.html">Contact</a>
        <a href="cart.php">View Cart</a>
    </div>

    <h1><span id="sweet">Sweet</span><span id="chilly">Chilly</span>
        <img src="download.jpg" height="90px"/>
    </h1>
    <p id="heading">Your One Stop Shop for all custom, trendy Merch</p>
    <div class="button-container">
        <button class="design-button <?php echo isActive('Classic', $selectedType); ?>" onclick="tshirt_type('Classic', event)">Classic Tee</button>
        <button class="design-button <?php echo isActive('Vintage', $selectedType); ?>" onclick="tshirt_type('Vintage', event)">Vintage Style</button>
        <button class="design-button <?php echo isActive('Graphic', $selectedType); ?>" onclick="tshirt_type('Graphic', event)">Graphic Prints</button>
        <button class="design-button <?php echo isActive('Minimalist', $selectedType); ?>" onclick="tshirt_type('Minimalist', event)">Minimalist Design</button>
        <button class="design-button <?php echo isActive('Custom', $selectedType); ?>" onclick="tshirt_type('Custom', event)">Custom Text</button>
    </div>
    <div class="grid-container">
            <div class="grid-item">
            <a href="#"><img src="../Shirt_designs/ShirtM1.png" alt="Shirt 1"></a>
            <form method="POST">
                <input type="hidden" name="shirt" value="Minimalist Shirt 1">
                <button type="submit" class="cart-button">Add to Cart</button>
            </form>
        </div>
        <div class="grid-item">
            <a href="#"><img src="../Shirt_designs/ShirtM2.png" alt="Shirt 2"></a>
            <form method="POST">
                <input type="hidden" name="shirt" value="Minimalist Shirt 2">
                <button type="submit" class="cart-button">Add to Cart</button>
            </form>
        </div>
        <div class="grid-item">
            <a href="#"><img src="../Shirt_designs/ShirtM3.png" alt="Shirt 2"></a>
            <form method="POST">
                <input type="hidden" name="shirt" value="Minimalist Shirt 3">
                <button type="submit" class="cart-button">Add to Cart</button>
            </form>
        </div>
    </div>
    <script>
        function tshirt_type(type, event) {
            window.location.href = type + ".php?selected=" + type;
        }
    </script>
</body>
</html>
