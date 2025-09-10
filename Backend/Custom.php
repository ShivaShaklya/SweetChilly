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

if (isset($_POST['design_name'])) {
    $designName = $_POST['design_name'];
    $customOrderDetails = [
        'name' => $_POST['name'],
        'email' => $_POST['email'],
        'custom_text' => $_POST['custom_text'],
        'emoji' => $_POST['emoji'],
        'description' => $_POST['description']
    ];

    $_SESSION['cart'][$designName] = $customOrderDetails;

    echo "<script>showToast('Your custom order has been accepted!');</script>";
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
    <form action="" method="post">
        Customer Name: <input type="text" name="name" placeholder="John Doe" required><br>
        Email: <input type="email" name="email" placeholder="johndoe@gmail.com" required><br>
        Custom Text: <input type="text" name="custom_text" placeholder="Space Rangers" required><br>
        Symbol: <input type="text" name="emoji" placeholder="😊👍🔥" required><br>
        Description: <textarea name="description" required>Add detailed description here...</textarea><br>
        Design Name: <input type="text" name="design_name" placeholder="RockStar Chic" required><br>
        <input type="submit" value="Submit">
    </form>
    <div id="toast" class="toast">Your custom order has been accepted!</div>
    <script>
        function tshirt_type(type, event) {
            window.location.href = type + ".php?selected=" + type;
        }
        
        function showToast(message) {
            const toast = document.getElementById("toast");
            toast.textContent = message;
            toast.className = "toast show";
            setTimeout(() => {
                toast.className = toast.className.replace("show", "");
            }, 3000);
        }
    </script>
</body>
</html>
