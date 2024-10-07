<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

// Kết nối cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cuoiky";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Kết nối thất bại: " . $e->getMessage());
}

// Lấy từ khóa tìm kiếm nếu có
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Truy vấn sản phẩm với thông tin size, color và brand_name
$sql = "
    SELECT p.*, b.brand_name 
    FROM product p
    LEFT JOIN brand b ON p.brand_id = b.brand_id
";

// Nếu có từ khóa tìm kiếm, thêm điều kiện WHERE
if ($search) {
    $sql .= " WHERE p.name_product LIKE :search";
}
$productsStmt = $conn->prepare($sql);

// Bind từ khóa tìm kiếm nếu có
if ($search) {
    $productsStmt->bindValue(':search', '%' . $search . '%');
}
$productsStmt->execute();
$products = $productsStmt->fetchAll(PDO::FETCH_ASSOC);

// Thêm sản phẩm
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_product'])) {
    $product_id = $_POST['product_id'];
    $name = $_POST['name_product'];
    $brand_id = $_POST['brand_id'];
    $status = $_POST['status'];
    $size_ids = $_POST['size_ids']; // Array of size IDs
    $color_ids = $_POST['color_ids']; // Array of color IDs

    // Cập nhật thông tin sản phẩm
    $stmt = $conn->prepare("UPDATE product SET name_product = :name, brand_id = :brand_id, status = :status WHERE product_id = :product_id");
    $stmt->execute([
        ':name' => $name,
        ':brand_id' => $brand_id,
        ':status' => $status,
        ':product_id' => $product_id,
    ]);

    // Cập nhật sizes và colors
    // Xóa tất cả size_product và color_product hiện tại và thêm mới
    $conn->prepare("DELETE FROM size_product WHERE product_id = :product_id")->execute([':product_id' => $product_id]);
    $conn->prepare("DELETE FROM color_product WHERE product_id = :product_id")->execute([':product_id' => $product_id]);

    // Thêm lại các size được chọn
    foreach ($size_ids as $size_id) {
        $conn->prepare("INSERT INTO size_product (product_id, size_id) VALUES (:product_id, :size_id)")
             ->execute([':product_id' => $product_id, ':size_id' => $size_id]);
    }

    // Thêm lại các color được chọn
    foreach ($color_ids as $color_id) {
        $conn->prepare("INSERT INTO color_product (product_id, color_id) VALUES (:product_id, :color_id)")
             ->execute([':product_id' => $product_id, ':color_id' => $color_id]);
    }

    // Hiển thị thông báo thành công
    $_SESSION['success'] = "Sản phẩm đã được cập nhật thành công!";
    header("Location: admin.php"); // Reload the page to see the changes
    exit;
}

if (isset($_SESSION['error'])) {
    echo '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">';
    echo '<strong>Lỗi:</strong> ' . $_SESSION['error'];
    echo '</div>';
    unset($_SESSION['error']);
}

// Kiểm tra nếu có thông báo thành công từ session
if (isset($_SESSION['success'])) {
    echo '<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">';
    echo '<strong>Thành công:</strong> ' . $_SESSION['success'];
    echo '</div>';
    unset($_SESSION['success']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

<div class="container mx-auto my-8">
    <h1 class="text-2xl font-bold text-center mb-6">Admin Dashboard</h1>

    <!-- Notifications for New Orders -->
     <section>
     <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6" role="alert">
        <p class="font-bold">Thông báo</p>
        <?php if (!empty($newOrders)): ?>
            <p>Có đơn hàng mới đã được đặt:</p>
            <ul>
                <?php foreach ($newOrders as $order): ?>
                    <li>Mã đơn hàng: <?php echo htmlspecialchars($order['order_id']); ?> - Tổng tiền: <?php echo htmlspecialchars($order['total']); ?></li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>Không có đơn hàng mới.</p>
        <?php endif; ?>
    </div>
     </section>
   
     <section>
    <!-- Add Product -->
    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <h2 class="text-xl font-semibold mb-4">Thêm sản phẩm</h2>
        <form action="add_product.php" method="POST" class="space-y-4" enctype="multipart/form-data">
            <!-- Product name input -->
            <input type="text" name="product_name" placeholder="Tên sản phẩm" required class="border w-full p-2 rounded">

            <!-- Product price input -->
            <input type="number" name="price" placeholder="Giá" required class="border w-full p-2 rounded">

            <!-- Color selection -->
            <label class="block font-semibold">Chọn màu sắc</label>
            <div class="space-y-2">
                <?php
                // Fetch available colors from the database
                $colorQuery = $conn->query("SELECT * FROM colors");
                $colors = $colorQuery->fetchAll(PDO::FETCH_ASSOC);
                foreach ($colors as $color): ?>
                    <div class="flex items-center">
                        <input type="checkbox" name="colors[]" value="<?php echo $color['color_id']; ?>" class="mr-2">
                        <label><?php echo htmlspecialchars($color['color']); ?></label>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Size selection -->
            <label class="block font-semibold">Chọn kích thước</label>
            <div class="space-y-2">
                <?php
                // Fetch available sizes from the database
                $sizeQuery = $conn->query("SELECT * FROM sizes");
                $sizes = $sizeQuery->fetchAll(PDO::FETCH_ASSOC);
                foreach ($sizes as $size): ?>
                    <div class="flex items-center">
                        <input type="checkbox" name="sizes[]" value="<?php echo $size['size_id']; ?>" class="mr-2">
                        <label><?php echo htmlspecialchars($size['size']); ?></label>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Product status input -->
            <input type="text" name="status" placeholder="Trạng thái" required class="border w-full p-2 rounded">

            <!-- Product image uploads -->
            <label class="block font-semibold">Tải lên hình ảnh sản phẩm</label>
            <input type="file" name="img1" accept="image/*" required class="border w-full p-2 rounded">
            <input type="file" name="img2" accept="image/*" required class="border w-full p-2 rounded">
            <input type="file" name="img3" accept="image/*" required class="border w-full p-2 rounded">

            <!-- Brand selection -->
            <label class="block font-semibold">Chọn thương hiệu</label>
            <select name="brand_id" required class="border w-full p-2 rounded">
                <?php
                // Fetch available brands from the database
                $brandQuery = $conn->query("SELECT * FROM brand");
                $brands = $brandQuery->fetchAll(PDO::FETCH_ASSOC);
                foreach ($brands as $brand): ?>
                    <option value="<?php echo $brand['brand_id']; ?>"><?php echo htmlspecialchars($brand['brand_name']); ?></option>
                <?php endforeach; ?>
            </select>

            <!-- Product description input -->
            <textarea name="description" placeholder="Mô tả sản phẩm" class="border w-full p-2 rounded"></textarea>

            <!-- Submit button -->
            <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded">Thêm sản phẩm</button>
        </form>
    </div>
</section>

     



    <!-- Search Product -->
    <div class="mb-6">
        <form action="" method="GET">
            <input type="text" name="search" placeholder="Tìm kiếm sản phẩm..." class="border p-2 rounded-md">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Tìm kiếm</button>
        </form>
    </div>



    <!-- Edit Product -->
    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
    <h2 class="text-xl font-semibold mb-4">Chỉnh sửa sản phẩm</h2>
    <form action="edit_product.php?id=<?php echo htmlspecialchars($product['product_id']); ?>" method="POST" enctype="multipart/form-data">
        <?php foreach ($products as $product): ?>
            <div class="border-b border-gray-300 pb-4 mb-4">
                <h3 class="font-semibold mb-2">Sản phẩm: <?php echo htmlspecialchars($product['name_product']); ?></h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block mb-1">Tên sản phẩm:</label>
                        <input type="text" name="name_product" value="<?php echo htmlspecialchars($product['name_product']); ?>" class="border px-2 py-1 rounded w-full">
                    </div>
                    <div>
                        <label class="block mb-1">Thương hiệu:</label>
                        <input type="text" name="brand_name" value="<?php echo htmlspecialchars($product['brand_name']); ?>" class="border px-2 py-1 rounded w-full">
                    </div>
                    <div>
                        <label class="block mb-1">Giá tiền:</label>
                        <input type="text" name="price" value="<?php echo htmlspecialchars($product['price']); ?>" class="border px-2 py-1 rounded w-full">
                    </div>
                    <div>
                        <label class="block mb-1">Trạng thái:</label>
                        <select name="status" class="border px-2 py-1 rounded w-full">
                            <option value="Còn hàng" <?php echo $product['status'] == 'Còn hàng' ? 'selected' : ''; ?>>Còn hàng</option>
                            <option value="Hết hàng" <?php echo $product['status'] == 'Hết hàng' ? 'selected' : ''; ?>>Hết hàng</option>
                        </select>
                    </div>
                    
                    <!-- Màu sắc -->
                    <div>
                        <label class="block mb-1">Màu sắc:</label>
                        <?php 
                        $colors = $conn->prepare("SELECT c.color FROM color_product cp JOIN colors c ON cp.color_id = c.color_id WHERE cp.product_id = :product_id");
                        $colors->execute([':product_id' => $product['product_id']]);
                        $colorList = $colors->fetchAll(PDO::FETCH_COLUMN);
                        ?>
                        <input type="text" name="color_ids[]" value="<?php echo htmlspecialchars(implode(', ', $colorList)); ?>" class="border px-2 py-1 rounded w-full">
                        <input type="text" name="new_color" placeholder="Thêm màu mới" class="border px-2 py-1 rounded w-full mt-2">
                    </div>

                    <!-- Kích thước -->
                    <div>
                        <label class="block mb-1">Kích thước:</label>
                        <?php 
                        $sizes = $conn->prepare("SELECT s.size FROM size_product sp JOIN sizes s ON sp.size_id = s.size_id WHERE sp.product_id = :product_id");
                        $sizes->execute([':product_id' => $product['product_id']]);
                        $sizeList = $sizes->fetchAll(PDO::FETCH_COLUMN);
                        ?>
                        <input type="text" name="size_ids[]" value="<?php echo htmlspecialchars(implode(', ', $sizeList)); ?>" class="border px-2 py-1 rounded w-full">
                        <input type="text" name="new_size" placeholder="Thêm kích thước mới" class="border px-2 py-1 rounded w-full mt-2">
                    </div>
                    
                    <div>
                        <label class="block mb-1">Mô tả:</label>
                        <textarea name="description" class="border px-2 py-1 rounded w-full" rows="3"><?php echo htmlspecialchars($product['description']); ?></textarea>
                    </div>
                    <div>
                        <label class="block mb-1">Hình ảnh 1:</label>
                        <input type="text" name="img1" value="<?php echo htmlspecialchars($product['img1']); ?>" class="border px-2 py-1 rounded w-full">
                        <input type="file" name="image1" class="border px-2 py-1 rounded w-full mt-1">
                    </div>
                    <div>
                        <label class="block mb-1">Hình ảnh 2:</label>
                        <input type="text" name="img2" value="<?php echo htmlspecialchars($product['img2']); ?>" class="border px-2 py-1 rounded w-full">
                        <input type="file" name="image2" class="border px-2 py-1 rounded w-full mt-1">
                    </div>
                    <div>
                        <label class="block mb-1">Hình ảnh 3:</label>
                        <input type="text" name="img3" value="<?php echo htmlspecialchars($product['img3']); ?>" class="border px-2 py-1 rounded w-full">
                        <input type="file" name="image3" class="border px-2 py-1 rounded w-full mt-1">
                    </div>
                </div>
                <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['product_id']); ?>">
                <div class="flex mt-4">
                    <button type="submit" name="update_product" class="bg-blue-500 text-white px-4 py-2 rounded-md mr-2">Cập nhật</button>
                    <form action="delete_product.php" method="POST" class="inline">
                        <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['product_id']); ?>">
                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-md">Xóa</button>
                    </form>
                </div>
            </div>
        <?php endforeach; ?>
    </form>
</div>






    <!-- Order Management -->
    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <h2 class="text-xl font-semibold mb-4">Quản lý đơn hàng</h2>
        <table class="min-w-full border border-gray-300">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border px-4 py-2">Mã đơn hàng</th>
                    <th class="border px-4 py-2">Người dùng</th>
                    <th class="border px-4 py-2">Tổng tiền</th>
                    <th class="border px-4 py-2">Trạng thái</th>
                    <th class="border px-4 py-2">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td class="border px-4 py-2"><?php echo htmlspecialchars($order['order_id']); ?></td>
                        <td class="border px-4 py-2"><?php echo htmlspecialchars($order['username']); ?></td>
                        <td class="border px-4 py-2"><?php echo htmlspecialchars($order['total']); ?></td>
                        <td class="border px-4 py-2"><?php echo htmlspecialchars($order['status']); ?></td>
                        <td class="border px-4 py-2">
                            <form action="update_order.php" method="POST" class="inline">
                                <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($order['order_id']); ?>">
                                <select name="status" class="border p-1 rounded-md">
                                    <option value="pending" <?php if ($order['status'] == 'pending') echo 'selected'; ?>>Đang chờ</option>
                                    <option value="shipped" <?php if ($order['status'] == 'shipped') echo 'selected'; ?>>Đã gửi</option>
                                    <option value="in transit" <?php if ($order['status'] == 'in transit') echo 'selected'; ?>>Đang vận chuyển</option>
                                    <option value="delivered" <?php if ($order['status'] == 'delivered') echo 'selected'; ?>>Đã giao</option>
                                </select>
                                <button type="submit" class="bg-blue-500 text-white px-2 py-1 rounded-md">Cập nhật</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
