<?php
session_start();
$cart = $_SESSION['cart'] ?? [];

// Handle item removal
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_item'])) {
    $itemToRemove = $_POST['remove_item'];
    unset($_SESSION['cart'][$itemToRemove]);
    header('Location: cart.php');
    exit;
}

// Handle quantity update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_quantity'], $_POST['item_name'])) {
    $itemName = $_POST['item_name'];
    $newQuantity = max(1, (int)$_POST['update_quantity']); // minimum quantity is 1

    if (isset($_SESSION['cart'][$itemName])) {
        if (is_array($_SESSION['cart'][$itemName])) {
            // Custom order
            $_SESSION['cart'][$itemName]['quantity'] = $newQuantity;
        } else {
            // Standard item
            $_SESSION['cart'][$itemName] = $newQuantity;
        }
    }
    header('Location: cart.php');
    exit;
}

$cart = $_SESSION['cart'] ?? [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Cart - SweetChilly</title>
    <link rel="stylesheet" href="Styles.css">
</head>
<body>
    <div class="navbar">
        <a href="Index.html">Home</a>
        <a href="Classic.php">Shop</a>
        <a href="About.html">About</a>
        <a href="About.html">Contact</a>
        <a href="cart.php">View Cart</a>
    </div>
    <h1 style="text-align:center;">Your Shopping Cart</h1>

    <?php if (empty($cart)): ?>
        <p style="text-align:center;">Your cart is empty 😢</p>
    <?php else: ?>
        <table>
            <tr>
                <th>Item</th>
                <th>Details</th>
                <th>Quantity</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($cart as $item => $details): ?>
                <tr>
                    <td><?php echo htmlspecialchars($item); ?></td>
                    <td>
                        <?php if (is_array($details)): ?>
                            Name: <?php echo htmlspecialchars($details['name']); ?><br>
                            Text: <?php echo htmlspecialchars($details['custom_text']); ?><br>
                            Emoji: <?php echo htmlspecialchars($details['emoji']); ?><br>
                            Description: <?php echo htmlspecialchars($details['description']); ?><br>
                        <?php else: ?>
                            Standard Shirt
                        <?php endif; ?>
                    </td>
                    <td>
                        <form method="POST" style="display:inline-block;">
                            <input type="hidden" name="item_name" value="<?php echo htmlspecialchars($item); ?>">
                            <input type="number" name="update_quantity" value="<?php echo is_array($details) ? htmlspecialchars($details['quantity']) : htmlspecialchars($details); ?>" min="1" style="width:60px;">
                            <button type="submit">Update</button>
                        </form>
                    </td>
                    <td>
                        <form method="POST" style="display:inline-block;">
                            <input type="hidden" name="remove_item" value="<?php echo htmlspecialchars($item); ?>">
                            <button type="submit">Remove</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</body>
</html>
