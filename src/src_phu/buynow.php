<?php
// Kết nối đến cơ sở dữ liệu bằng PDO
try {
    $conn = new PDO("mysql:host=localhost;dbname=cuoiky", "root", password: "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Khởi tạo các biến
$product = [];
$size = $color = $quantity = "";

// Kiểm tra phương thức GET
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['product_id'])) {
    $product_id = (int)$_GET['product_id']; // Chuyển đổi sang số nguyên

    // Lấy thông tin sản phẩm từ cơ sở dữ liệu
    $stmt = $conn->prepare("SELECT name_product, price, img1 FROM product WHERE product_id = :product_id");
    $stmt->execute(['product_id' => $product_id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    // Lấy size, color, quantity từ query string
    $size = isset($_GET['size']) ? htmlspecialchars($_GET['size']) : 'Chưa chọn kích thước';
    $color = isset($_GET['color']) ? htmlspecialchars($_GET['color']) : 'Chưa chọn màu sắc';
    $quantity = isset($_GET['quantity']) ? (int)$_GET['quantity'] : 0;
}

// Kiểm tra phương thức POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Lấy dữ liệu từ biểu mẫu
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $address = htmlspecialchars(trim($_POST['address']));
    $phone = htmlspecialchars(trim($_POST['phone']));
    $birthday = htmlspecialchars(trim($_POST['birthday']));
    $voucher_code = htmlspecialchars(trim($_POST['voucher_code']));
    $price = (float) $_POST['price']; // Giá từ biểu mẫu
    $total = $quantity * $price; // Tính tổng tiền

    // Thêm đơn hàng vào cơ sở dữ liệu
    $sql = "INSERT INTO orders (username, date_create, total, note, status, name, email, phone, voucher_code, payment, address, size, color)
            VALUES (?, NOW(), ?, '', 'Pending', ?, ?, ?, '', ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    
    if ($stmt->execute([$name, $total, $product['name_product'], $email, $phone, $voucher_code, $address, $size, $color])) {
        echo "Đặt hàng thành công!";
    } else {
        echo "Lỗi: " . $stmt->errorInfo();
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./output.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.css" rel="stylesheet">
    <title>Thông tin đặt hàng</title>
</head>
<body>
    <section class="bg-gray-50 dark:bg-gray-900">
        <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16 grid lg:grid-cols-2 gap-8 lg:gap-16">
            
            <!-- Cột trái: Thông tin sản phẩm -->
            <?php
            // Kiểm tra xem các biến đã được khởi tạo chưa
            $productName = isset($product['name_product']) ? htmlspecialchars($product['name_product']) : 'Không có tên sản phẩm';
            $productPrice = isset($product['price']) ? number_format($product['price']) . ' VND' : '0 VND';
            $productImg = isset($product['img1']) ? htmlspecialchars($product['img1']) : 'default-image.jpg'; // Hình ảnh mặc định

            $size = isset($size) ? htmlspecialchars($size) : 'Chưa chọn kích thước';
            $color = isset($color) ? htmlspecialchars($color) : 'Chưa chọn màu sắc';
            $quantity = isset($quantity) ? htmlspecialchars($quantity) : '0';

            // Tính tổng tiền nếu đã có giá và số lượng
            $total = isset($product['price']) && isset($quantity) ? number_format($quantity * $product['price']) . ' VND' : '0 VND';
            ?>

            <div class="flex flex-col justify-center">
                <h1 class="mb-4 text-2xl font-bold tracking-tight leading-none text-gray-900 md:text-2xl lg:text-2xl dark:text-white">Thông tin sản phẩm</h1>
                <div class="bg-white p-6 rounded-lg shadow-xl dark:bg-gray-800">
                    <div class="mb-4">
                        <p class="text-lg font-bold text-gray-900 dark:text-white">Tên sản phẩm: </p>
                        <p class="text-gray-700 dark:text-gray-400"><?php echo $productName; ?></p>
                    </div>
                    <div class="mb-4">
                        <p class="text-lg font-bold text-gray-900 dark:text-white">Giá: </p>
                        <p class="text-gray-700 dark:text-gray-400"><?php echo $productPrice; ?></p>
                    </div>
                    <div class="mb-4">
                        <p class="text-lg font-bold text-gray-900 dark:text-white">Kích thước: </p>
                        <p class="text-gray-700 dark:text-gray-400"><?php echo $size; ?></p>
                    </div>
                    <div class="mb-4">
                        <p class="text-lg font-bold text-gray-900 dark:text-white">Màu sắc: </p>
                        <p class="text-gray-700 dark:text-gray-400"><?php echo $color; ?></p>
                    </div>
                    <div class="mb-4">
                        <p class="text-lg font-bold text-gray-900 dark:text-white">Số lượng: </p>
                        <p class="text-gray-700 dark:text-gray-400"><?php echo $quantity; ?></p>
                    </div>
                    <div class="mb-4">
                        <p class="text-lg font-bold text-gray-900 dark:text-white">Tổng tiền: </p>
                        <p class="text-gray-700 dark:text-gray-400"><?php echo $total; ?></p>
                    </div>
                    <div class="mb-4">
                        <p class="text-lg font-bold text-gray-900 dark:text-white">Hình ảnh </p>
                        <img src="./../../img/<?php echo $productImg; ?>" alt="">
                    </div>
                </div>
            </div>

            <!-- Cột phải: Thông tin khách hàng -->
            <div>
                <div class="w-full lg:max-w-xl p-6 space-y-8 sm:p-8 bg-white rounded-lg shadow-xl dark:bg-gray-800">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Thông tin khách hàng</h2>
                    <form class="space-y-4" method="POST" action="process_order.php"> <!-- Bạn có thể thay đổi action nếu cần -->
                        <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                        <input type="hidden" name="size" value="<?php echo $size; ?>">
                        <input type="hidden" name="color" value="<?php echo $color; ?>">
                        <input type="hidden" name="quantity" value="<?php echo $quantity; ?>">
                        <input type="hidden" name="price" value="<?php echo $product['price']; ?>">

                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-900 dark:text-white">Tên của bạn</label>
                            <input type="text" id="name" name="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Tên của bạn" required />
                        </div>
                        
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-900 dark:text-white">Email</label>
                            <input type="email" id="email" name="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Email" required />
                        </div>
                        
                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-900 dark:text-white">Địa chỉ</label>
                            <input type="text" id="address" name="address" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Địa chỉ của bạn" required />
                        </div>
                        
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-900 dark:text-white">Số điện thoại</label>
                            <input type="tel" id="phone" name="phone" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Số điện thoại của bạn" required />
                        </div>

                        <div>
                            <label for="birthday" class="block text-sm font-medium text-gray-900 dark:text-white">Ngày sinh</label>
                            <input type="date" id="birthday" name="birthday" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required />
                        </div>
                        
                        <div>
                            <label for="voucher_code" class="block text-sm font-medium text-gray-900 dark:text-white">Mã voucher</label>
                            <input type="text" id="voucher_code" name="voucher_code" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Mã voucher" />
                        </div>
                        
                        <button type="submit" name="submit" class="w-full px-4 py-2 text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300">Đặt hàng</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-red-200 dark:bg-gray-900 mt-40">
    <div class="mx-auto w-full max-w-screen-xl">
      <div class="grid grid-cols-2 gap-8 px-4 py-6 lg:py-8 md:grid-cols-4">
        <div>
            <h2 class="mb-6 text-sm font-semibold text-red-700 uppercase dark:text-white">Về chúng tôi</h2>
            <ul class="text-red-700 dark:text-gray-700 font-medium">
                <li class="mb-4">
                    <a href="#" class=" hover:underline">About</a>
                </li>
                <li class="mb-4">
                    <a href="#" class="hover:underline">Careers</a>
                </li>
                <li class="mb-4">
                    <a href="#" class="hover:underline">Brand Center</a>
                </li>
                <li class="mb-4">
                    <a href="#" class="hover:underline">Blog</a>
                </li>
            </ul>
        </div>
        <div>
            <h2 class="mb-6 text-sm font-semibold text-red-700 uppercase dark:text-white">Thông tin</h2>
            <ul class="text-red-700 dark:text-gray-400 font-medium">
                <li class="mb-4">
                    <a href="#" class="hover:underline">Trạng thái đơn hàng</a>
                </li>
                <li class="mb-4">
                    <a href="#" class="hover:underline">Chính sách đổi trả</a>
                </li>
                <li class="mb-4">
                    <a href="#" class="hover:underline">Hình thức thanh toán</a>
                </li>
                <li class="mb-4">
                    <a href="#" class="hover:underline">Chính sách khách hàng thân thiết</a>
                </li>
            </ul>
        </div>
        <div>
            <h2 class="mb-6 text-sm font-semibold text-red-700 uppercase dark:text-white">Trợ giúp</h2>
            <ul class="text-red-700 dark:text-gray-400 font-medium">
                <li class="mb-4">
                    <a href="#" class="hover:underline">Tuyển dụng</a>
                </li>
                <li class="mb-4">
                    <a href="#" class="hover:underline">Liên hệ hợp tác</a>
                </li>
                <li class="mb-4">
                    <a href="#" class="hover:underline">Q&A</a>
                </li>
            </ul>
        </div>
        <div>
            <h2 class="mb-6 text-sm font-semibold text-red-700 uppercase dark:text-white">Hệ thống cửa hàng</h2>
            <ul class="text-red-700 dark:text-gray-400 font-medium">
                <li class="mb-4">
                    <a href="#" class="hover:underline">Chi nhánh 1: ABCXYZ</a>
                </li>
               
            </ul>
        </div>
    </div>
    <div class="px-4 py-6 bg-gray-100 dark:bg-gray-700 md:flex md:items-center md:justify-between">
        <span class="text-sm text-gray-500 dark:text-gray-300 sm:text-center">© 2023 <a href="#"></a>. All Rights Reserved.
        </span>
        <div class="flex mt-4 sm:justify-center md:mt-0 space-x-5 rtl:space-x-reverse">
            <a href="https://www.facebook.com/phuc.fckb" class="text-gray-400 hover:text-gray-900 dark:hover:text-white">
                  <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 8 19">
                        <path fill-rule="evenodd" d="M6.135 3H8V0H6.135a4.147 4.147 0 0 0-4.142 4.142V6H0v3h2v9.938h3V9h2.021l.592-3H5V3.591A.6.6 0 0 1 5.592 3h.543Z" clip-rule="evenodd"/>
                    </svg>
                  <span class="sr-only">Facebook page</span>
              </a>
              <a href="https://oj.vnoi.info/user/HyhTonHappy" class="text-gray-400 hover:text-gray-900 dark:hover:text-white">
                  <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 21 16">
                        <path d="M16.942 1.556a16.3 16.3 0 0 0-4.126-1.3 12.04 12.04 0 0 0-.529 1.1 15.175 15.175 0 0 0-4.573 0 11.585 11.585 0 0 0-.535-1.1 16.274 16.274 0 0 0-4.129 1.3A17.392 17.392 0 0 0 .182 13.218a15.785 15.785 0 0 0 4.963 2.521c.41-.564.773-1.16 1.084-1.785a10.63 10.63 0 0 1-1.706-.83c.143-.106.283-.217.418-.33a11.664 11.664 0 0 0 10.118 0c.137.113.277.224.418.33-.544.328-1.116.606-1.71.832a12.52 12.52 0 0 0 1.084 1.785 16.46 16.46 0 0 0 5.064-2.595 17.286 17.286 0 0 0-2.973-11.59ZM6.678 10.813a1.941 1.941 0 0 1-1.8-2.045 1.93 1.93 0 0 1 1.8-2.047 1.919 1.919 0 0 1 1.8 2.047 1.93 1.93 0 0 1-1.8 2.045Zm6.644 0a1.94 1.94 0 0 1-1.8-2.045 1.93 1.93 0 0 1 1.8-2.047 1.918 1.918 0 0 1 1.8 2.047 1.93 1.93 0 0 1-1.8 2.045Z"/>
                    </svg>
                  <span class="sr-only">Discord community</span>
              </a>
              <a href="#" class="text-gray-400 hover:text-gray-900 dark:hover:text-white">
                  <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 17">
                    <path fill-rule="evenodd" d="M20 1.892a8.178 8.178 0 0 1-2.355.635 4.074 4.074 0 0 0 1.8-2.235 8.344 8.344 0 0 1-2.605.98A4.13 4.13 0 0 0 13.85 0a4.068 4.068 0 0 0-4.1 4.038 4 4 0 0 0 .105.919A11.705 11.705 0 0 1 1.4.734a4.006 4.006 0 0 0 1.268 5.392 4.165 4.165 0 0 1-1.859-.5v.05A4.057 4.057 0 0 0 4.1 9.635a4.19 4.19 0 0 1-1.856.07 4.108 4.108 0 0 0 3.831 2.807A8.36 8.36 0 0 1 0 14.184 11.732 11.732 0 0 0 6.291 16 11.502 11.502 0 0 0 17.964 4.5c0-.177 0-.35-.012-.523A8.143 8.143 0 0 0 20 1.892Z" clip-rule="evenodd"/>
                </svg>
                  <span class="sr-only">Twitter page</span>
              </a>
              <a href="#" class="text-gray-400 hover:text-gray-900 dark:hover:text-white">
                  <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 .333A9.911 9.911 0 0 0 6.866 19.65c.5.092.678-.215.678-.477 0-.237-.01-1.017-.014-1.845-2.757.6-3.338-1.169-3.338-1.169a2.627 2.627 0 0 0-1.1-1.451c-.9-.615.07-.6.07-.6a2.084 2.084 0 0 1 1.518 1.021 2.11 2.11 0 0 0 2.884.823c.044-.503.268-.973.63-1.325-2.2-.25-4.516-1.1-4.516-4.9A3.832 3.832 0 0 1 4.7 7.068a3.56 3.56 0 0 1 .095-2.623s.832-.266 2.726 1.016a9.409 9.409 0 0 1 4.962 0c1.89-1.282 2.717-1.016 2.717-1.016.366.83.402 1.768.1 2.623a3.827 3.827 0 0 1 1.02 2.659c0 3.807-2.319 4.644-4.525 4.889a2.366 2.366 0 0 1 .673 1.834c0 1.326-.012 2.394-.012 2.72 0 .263.18.572.681.475A9.911 9.911 0 0 0 10 .333Z" clip-rule="evenodd"/>
                  </svg>
                  <span class="sr-only">GitHub account</span>
              </a>
              <a href="#" class="text-gray-400 hover:text-gray-900 dark:hover:text-white">
                  <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 0a10 10 0 1 0 10 10A10.009 10.009 0 0 0 10 0Zm6.613 4.614a8.523 8.523 0 0 1 1.93 5.32 20.094 20.094 0 0 0-5.949-.274c-.059-.149-.122-.292-.184-.441a23.879 23.879 0 0 0-.566-1.239 11.41 11.41 0 0 0 4.769-3.366ZM8 1.707a8.821 8.821 0 0 1 2-.238 8.5 8.5 0 0 1 5.664 2.152 9.608 9.608 0 0 1-4.476 3.087A45.758 45.758 0 0 0 8 1.707ZM1.642 8.262a8.57 8.57 0 0 1 4.73-5.981A53.998 53.998 0 0 1 9.54 7.222a32.078 32.078 0 0 1-7.9 1.04h.002Zm2.01 7.46a8.51 8.51 0 0 1-2.2-5.707v-.262a31.64 31.64 0 0 0 8.777-1.219c.243.477.477.964.692 1.449-.114.032-.227.067-.336.1a13.569 13.569 0 0 0-6.942 5.636l.009.003ZM10 18.556a8.508 8.508 0 0 1-5.243-1.8 11.717 11.717 0 0 1 6.7-5.332.509.509 0 0 1 .055-.02 35.65 35.65 0 0 1 1.819 6.476 8.476 8.476 0 0 1-3.331.676Zm4.772-1.462A37.232 37.232 0 0 0 13.113 11a12.513 12.513 0 0 1 5.321.364 8.56 8.56 0 0 1-3.66 5.73h-.002Z" clip-rule="evenodd"/>
                </svg>
                  <span class="sr-only">Dribbble account</span>
              </a>
        </div>
      </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.js"></script>
</body>
</html>