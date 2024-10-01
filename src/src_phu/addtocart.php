<?php
session_start();

// Kiểm tra nếu người dùng đã đăng nhập
if (!isset($_SESSION['username'])) {
    die("Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng.");
}

$username = $_SESSION['username'];

try {
    // Kết nối tới cơ sở dữ liệu
    $conn = new PDO("mysql:host=localhost;dbname=cuoiky", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Kết nối thất bại: " . $e->getMessage());
}

// Xử lý thêm sản phẩm vào giỏ hàng
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = (int)$_POST['product_id'];
    $size = htmlspecialchars($_POST['size']);
    $color = htmlspecialchars($_POST['color']);
    $quantity = (int)$_POST['quantity'];

    // Lấy color_id từ bảng colors dựa trên tên màu
    $stmt = $conn->prepare("SELECT color_id FROM colors WHERE color = :color");
    $stmt->execute(['color' => $color]);
    $colorData = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$colorData) {
        die("Màu không hợp lệ.");
    }
    $color_id = $colorData['color_id'];

    // Kiểm tra xem sản phẩm đã có trong giỏ hàng chưa
    $stmt = $conn->prepare("SELECT cart_id, quantity FROM carts WHERE product_id = :product_id AND size_id = :size_id AND color_id = :color_id AND username = :username");
    $stmt->execute([
        'product_id' => $product_id,
        'size_id' => $size,
        'color_id' => $color_id,
        'username' => $username
    ]);
    $existing_cart = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existing_cart) {
        // Nếu sản phẩm đã có trong giỏ hàng, cập nhật số lượng
        $new_quantity = $existing_cart['quantity'] + $quantity; // Cộng số lượng mới vào số lượng cũ
        
        // Cập nhật lại giá trị tổng tiền trong giỏ hàng
        $stmt = $conn->prepare("SELECT price FROM product WHERE product_id = :product_id");
        $stmt->execute(['product_id' => $product_id]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$product) {
            die("Sản phẩm không hợp lệ.");
        }
        
        // Tính tổng giá mới
        $total_price = $new_quantity * (float)$product['price'];

        // Cập nhật số lượng và tổng giá
        $stmt = $conn->prepare("UPDATE carts SET quantity = :quantity, price = :price WHERE cart_id = :cart_id");
        $stmt->execute([
            'quantity' => $new_quantity,
            'price' => $total_price,
            'cart_id' => $existing_cart['cart_id']
        ]);
        echo "Số lượng sản phẩm đã được cập nhật trong giỏ hàng.";
    } else {
        // Lấy giá sản phẩm
        $stmt = $conn->prepare("SELECT price FROM product WHERE product_id = :product_id");
        $stmt->execute(['product_id' => $product_id]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$product) {
            die("Sản phẩm không hợp lệ.");
        }

        // Tìm cart_id lớn nhất và cộng thêm 1
        $stmt = $conn->query("SELECT MAX(cart_id) as max_cart_id FROM carts");
        $max_cart_id = $stmt->fetchColumn();
        $new_cart_id = $max_cart_id !== null ? (int)$max_cart_id + 1 : 1; // Nếu không có cart_id nào thì bắt đầu từ 1

        // Thêm mới sản phẩm vào giỏ hàng
        $total_price = $quantity * (float)$product['price']; // Tính tổng giá

        $stmt = $conn->prepare("INSERT INTO carts (cart_id, product_id, size_id, color_id, quantity, username, price) 
                                VALUES (:cart_id, :product_id, :size_id, :color_id, :quantity, :username, :price)");
        $stmt->execute([
            'cart_id' => $new_cart_id,
            'product_id' => $product_id,
            'size_id' => $size,
            'color_id' => $color_id,
            'quantity' => $quantity, // Lưu số lượng chọn từ form
            'username' => $username,
            'price' => $total_price // Lưu giá tổng cho số lượng sản phẩm
        ]);
        echo "Sản phẩm đã được thêm vào giỏ hàng.";
    }

    // Chuyển hướng về trang giỏ hàng sau khi thêm sản phẩm
    header("Location: cart.php");
    exit;
}
?>
