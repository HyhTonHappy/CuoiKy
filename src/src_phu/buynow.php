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
            <div class="flex flex-col justify-center">
                <h1 class="mb-4 text-2xl font-bold tracking-tight leading-none text-gray-900 md:text-2xl lg:text-2xl dark:text-white">Thông tin sản phẩm</h1>
                <div class="bg-white p-6 rounded-lg shadow-xl dark:bg-gray-800">
                    <div class="mb-4">
                        <p class="text-lg font-bold text-gray-900 dark:text-white">Tên sản phẩm: </p>
                        <p class="text-gray-700 dark:text-gray-400">Sản phẩm ABC XYZ</p>
                    </div>
                    <div class="mb-4">
                        <p class="text-lg font-bold text-gray-900 dark:text-white">Giá: </p>
                        <p class="text-gray-700 dark:text-gray-400">1.200.000 VND</p>
                    </div>
                    <div class="mb-4">
                        <p class="text-lg font-bold text-gray-900 dark:text-white">Số lượng: </p>
                        <p class="text-gray-700 dark:text-gray-400">2</p>
                    </div>
                    <div class="mb-4">
                        <p class="text-lg font-bold text-gray-900 dark:text-white">Tổng tiền: </p>
                        <p class="text-gray-700 dark:text-gray-400">2.400.000 VND</p>
                    </div>
                    <div class="mb-4">
                        <p class="text-lg font-bold text-gray-900 dark:text-white">Hình ảnh </p>
                        <img src="./../../img/adidas1_1.webp" alt="">
                    </div>
                </div>
            </div>

            <!-- Cột phải: Thông tin khách hàng -->
            <div>
                <div class="w-full lg:max-w-xl p-6 space-y-8 sm:p-8 bg-white rounded-lg shadow-xl dark:bg-gray-800">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Thông tin khách hàng</h2>
                    <form class="space-y-4" method="POST" action="">
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
                            <input type="text" id="voucher_code" name="voucher_code" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white" placeholder="Mã voucher" required />
                        </div>
                        
                        <button type="submit" name="submit" class="text-white bg-red-700 hover:bg-red-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700">Đặt hàng</button>
                    </form>
                </div>
            </div>

        </div>
    </section>

    <footer class="bg-red-200 dark:bg-gray-900 mt-16">
        <div class="mx-auto w-full max-w-screen-xl">
            <div class="grid grid-cols-2 gap-8 px-4 py-6 lg:py-8 md:grid-cols-4">
                <div>
                    <h2 class="mb-6 text-sm font-semibold text-red-700 uppercase dark:text-white">Về chúng tôi</h2>
                    <ul class="text-red-700 dark:text-gray-700 font-medium">
                        <li class="mb-4">
                            <a href="#" class="hover:underline">About</a>
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
                <span class="text-sm text-gray-500 dark:text-gray-300">© 2023 <a href="#" class="hover:underline">Tên công ty</a>. All Rights Reserved.</span>
            </div>
        </div>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.4.0/flowbite.min.js"></script>
</body>
</html>
