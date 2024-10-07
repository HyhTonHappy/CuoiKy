<?php
session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "cuoiky";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Kết nối thất bại: " . $e->getMessage());
}

// Check if the product ID is passed in the URL
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Fetch the existing product data from the database
    $sql = "SELECT * FROM product WHERE product_id = :product_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
    $stmt->execute();
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$product) {
        $_SESSION['error'] = "Sản phẩm không tồn tại!";
        header('Location: admin.php');
        exit;
    }
} else {
    $_SESSION['error'] = "Không tìm thấy sản phẩm!";
    header('Location: admin.php');
    exit;
}

// Fetch available sizes, colors, and brands
$sizes = $pdo->query("SELECT * FROM sizes")->fetchAll(PDO::FETCH_ASSOC);
$colors = $pdo->query("SELECT * FROM colors")->fetchAll(PDO::FETCH_ASSOC);
$brands = $pdo->query("SELECT * FROM brand")->fetchAll(PDO::FETCH_ASSOC);

// If the form is submitted, process the update
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name_product = $_POST['name_product'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $color_ids = $_POST['color_ids']; // Mảng chứa ID màu sắc
    $size_ids = $_POST['size_ids']; // Mảng chứa ID kích thước
    $brand_id = $_POST['brand_id'];
    $img1 = $_POST['img1'];
    $img2 = $_POST['img2'];
    $img3 = $_POST['img3'];
    $status = $_POST['status'];

    // Validate inputs
    if (empty($name_product) || empty($price) || empty($description) || empty($color_ids) || empty($size_ids) || empty($brand_id)) {
        $_SESSION['error'] = "Vui lòng điền đầy đủ thông tin sản phẩm!";
        header("Location: edit_product.php?id=$product_id");
        exit;
    }

    // Update the product in the database
    $sql_update = "UPDATE product SET 
                    name_product = :name_product, 
                    price = :price, 
                    description = :description, 
                    brand_id = :brand_id, 
                    img1 = :img1, 
                    img2 = :img2, 
                    img3 = :img3, 
                    status = :status 
                    WHERE product_id = :product_id";

    $stmt_update = $pdo->prepare($sql_update);
    $stmt_update->bindParam(':name_product', $name_product);
    $stmt_update->bindParam(':price', $price);
    $stmt_update->bindParam(':description', $description);
    $stmt_update->bindParam(':brand_id', $brand_id);
    $stmt_update->bindParam(':img1', $img1);
    $stmt_update->bindParam(':img2', $img2);
    $stmt_update->bindParam(':img3', $img3);
    $stmt_update->bindParam(':status', $status);
    $stmt_update->bindParam(':product_id', $product_id, PDO::PARAM_INT);

    if ($stmt_update->execute()) {
        // Cập nhật lại các màu sắc
        foreach ($color_ids as $color_id) {
            // Kiểm tra nếu màu sắc đã tồn tại trong bảng color_product
            $sql_check = "SELECT * FROM color_product WHERE color_id = :color_id AND product_id = :product_id";
            $stmt_check = $pdo->prepare($sql_check);
            $stmt_check->bindParam(':color_id', $color_id);
            $stmt_check->bindParam(':product_id', $product_id);
            $stmt_check->execute();

            // Nếu màu sắc chưa tồn tại, thêm vào
            if (!$stmt_check->fetch()) {
                $pdo->prepare("INSERT INTO color_product (color_id, product_id) VALUES (:color_id, :product_id)")
                    ->execute([':color_id' => $color_id, ':product_id' => $product_id]);
            }
        }

        // Cập nhật lại các kích thước
        foreach ($size_ids as $size_id) {
            // Kiểm tra nếu kích thước đã tồn tại trong bảng size_product
            $sql_check = "SELECT * FROM size_product WHERE size_id = :size_id AND product_id = :product_id";
            $stmt_check = $pdo->prepare($sql_check);
            $stmt_check->bindParam(':size_id', $size_id);
            $stmt_check->bindParam(':product_id', $product_id);
            $stmt_check->execute();

            // Nếu kích thước chưa tồn tại, thêm vào
            if (!$stmt_check->fetch()) {
                $pdo->prepare("INSERT INTO size_product (size_id, product_id) VALUES (:size_id, :product_id)")
                    ->execute([':size_id' => $size_id, ':product_id' => $product_id]);
            }
        }

        $_SESSION['success'] = "Sản phẩm đã được cập nhật thành công!";
        header('Location: admin.php');
        exit;
    } else {
        $_SESSION['error'] = "Lỗi khi cập nhật sản phẩm!";
        header("Location: edit_product.php?id=$product_id");
        exit;
    }
}
?>
