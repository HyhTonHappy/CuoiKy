<?php
// Kết nối đến cơ sở dữ liệu bằng PDO
try {
    $conn = new PDO("mysql:host=localhost;dbname=cuoiky", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Khởi tạo các biến
$product_name = "";
$size = $color = "";
$quantity = 0;
$total_price = 0.0;
$discount = 0.0;

// Kiểm tra phương thức POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ biểu mẫu và vệ sinh đầu vào
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $address = htmlspecialchars(trim($_POST['address']));
    $phone = htmlspecialchars(trim($_POST['phone']));
    $note = htmlspecialchars(trim($_POST['note']));
    $payment = htmlspecialchars(trim($_POST['payment']));
    $voucher_code = htmlspecialchars(trim($_POST['voucher_code']));

    // Chuyển đổi giá trị 'quantity' và 'price' sang kiểu số
    $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 0; // Chuyển thành số nguyên
    $price = isset($_POST['price']) ? (float)$_POST['price'] : 0.0;      // Chuyển thành số thực

    // Tính tổng tiền
    $total_price = $quantity * $price;

    // Kiểm tra và tính giảm giá từ voucher
    if (!empty($voucher_code)) {
        $sql_voucher = "SELECT vourcher_id, price, price_min FROM vourcher WHERE vourcher_code = ? AND status = 1 AND CURDATE() BETWEEN day_start AND day_end";
        $stmt_voucher = $conn->prepare($sql_voucher);
        $stmt_voucher->execute([$voucher_code]);
        $voucher = $stmt_voucher->fetch(PDO::FETCH_ASSOC);

        // Kiểm tra voucher
        if ($voucher && $total_price >= ($voucher['price_min'] ?? 0)) {
            $discount = $voucher['price']; 
            $total_price -= $discount; // Trừ giảm giá vào tổng tiền
        }
    }

    // Lấy tên sản phẩm
    $product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0; // Assuming product ID is sent in the POST request
    if ($product_id) {
        $sql_product = "SELECT name_product FROM product WHERE product_id = ?"; // Điều chỉnh tên bảng và cột ID nếu cần
        $stmt_product = $conn->prepare($sql_product);
        $stmt_product->execute([$product_id]);
        $product = $stmt_product->fetch(PDO::FETCH_ASSOC);
        $product_name = $product['name_product'] ?? "Unknown Product"; // Đảm bảo tên sản phẩm có sẵn
    }

    // Tìm order_id cao nhất và cộng thêm 1
    $sql_max_order = "SELECT MAX(order_id) as max_order_id FROM orders";
    $stmt_max = $conn->prepare($sql_max_order);
    $stmt_max->execute();
    $max_order = $stmt_max->fetch(PDO::FETCH_ASSOC);
    $new_order_id = ($max_order['max_order_id'] ?? 0) + 1; // Cộng thêm 1

    // Thêm đơn hàng vào cơ sở dữ liệu với status là "Đã đặt hàng"
    $sql = "INSERT INTO orders (order_id, username, date_create, total, note, status, name, email, phone, vourcher_code, voucher_id, payment, address, name_product, color, size, quantity)
            VALUES (?, ?, NOW(), ?, ?, 'Đã đặt hàng', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $voucher_id = $voucher['vourcher_id'] ?? null; 

    if ($stmt->execute([$new_order_id, $name, $total_price, $note, $name, $email, $phone, $voucher_code, $voucher_id, $payment, $address, $product_name, $color, $size, $quantity])) {
        echo "<script>alert('Đặt hàng thành công!');</script>";
        echo "<script>setTimeout(function(){ window.location.href = 'index.php'; }, 3000);</script>";
    } else {
        echo "Lỗi: " . $stmt->errorInfo();
    }
}
?>
