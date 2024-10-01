<?php
session_start();

// Kiểm tra nếu người dùng đã đăng nhập
if (!isset($_SESSION['username'])) {
    die("Vui lòng đăng nhập để xem giỏ hàng.");
}

$username = $_SESSION['username'];

try {
    // Kết nối tới cơ sở dữ liệu
    $conn = new PDO("mysql:host=localhost;dbname=cuoiky", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Lấy danh sách sản phẩm trong giỏ hàng của người dùng
    $stmt = $conn->prepare("SELECT * FROM carts WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Kết nối thất bại: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="styles.css"> <!-- Include your CSS styles if needed -->
</head>
<body>
    <h1>Giỏ Hàng</h1>
    <?php if (count($cartItems) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Sản phẩm</th>
                    <th>Kích thước</th>
                    <th>Màu sắc</th>
                    <th>Số lượng</th>
                    <th>Giá</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cartItems as $item): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($item['product_id']); ?></td>
                        <td><?php echo htmlspecialchars($item['size_id']); ?></td>
                        <td><?php echo htmlspecialchars($item['color_id']); ?></td>
                        <td>
                            <form method="POST" action="update_quantity.php">
                                <input type="hidden" name="cart_id" value="<?php echo $item['cart_id']; ?>">
                                <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1">
                                <button type="submit">Cập nhật</button>
                            </form>
                        </td>
                        <td><?php echo htmlspecialchars($item['price'] * $item['quantity']); ?></td>
                        <td>
                            <form method="POST" action="remove_from_cart.php">
                                <input type="hidden" name="cart_id" value="<?php echo $item['cart_id']; ?>">
                                <button type="submit">Xóa</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Giỏ hàng của bạn hiện đang trống.</p>
    <?php endif; ?>
</body>
</html>
