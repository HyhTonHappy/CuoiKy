<?php
// Danh sách sản phẩm
$products = [
    [
        'name' => 'Giày Nike',
        'price' => '1,000,000 VNĐ',
        'image' => '/img/product1.jpg'
    ],
    [
        'name' => 'Giày Adidas',
        'price' => '1,200,000 VNĐ',
        'image' => '/img/product2.jpg'
    ],
    [
        'name' => 'Giày Bitis',
        'price' => '800,000 VNĐ',
        'image' => '/img/product3.jpg'
    ],
    // Thêm nhiều sản phẩm ở đây
];
?>

<!doctype html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="./output.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.css" rel="stylesheet">
    <title>Bán hàng</title>
</head>
<body>
    <header>
        <nav class="dark:bg-gray-900 w-full z-20 top-0 start-0 bg-red-400">
            <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
                <a href="#" class="flex items-center space-x-3 rtl:space-x-reverse">
                    <span class="self-center text-4xl font-semibold whitespace-nowrap text-white">Bán hàng</span>
                </a>

                <div class="flex md:order-2 space-x-3 rtl:space-x-reverse justify-between items-center">
                    <button type="button" class="text-red-400 bg-white hover:bg-red-400 hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center transition-all duration-500">Đăng nhập</button>
                    <button type="button" class="text-red-400 bg-white hover:bg-red-400 hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center transition-all duration-500">Đăng ký</button>
                </div>

                <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-sticky">
                    <ul class="flex flex-col p-4 md:p-0 mt-4 font-medium md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0">
                        <li><a href="#" class="block py-2 px-3 text-white rounded md:bg-transparent md:text-white md:p-0 md:dark:text-white hover:text-red-100" aria-current="Home">Trang chủ</a></li>
                        <li><a href="#" class="block py-2 px-3 text-white rounded md:hover:bg-transparent md:hover:text-red-100 md:p-0 dark:text-white dark:hover:text-white md:dark:hover:bg-transparent">Chính sách</a></li>
                        <li><a href="#" class="block py-2 px-3 text-white rounded md:hover:bg-transparent md:p-0 dark:text-white dark:hover:text-white md:dark:hover:bg-transparent">Đối tác</a></li>
                        <li><a href="#" class="block py-2 px-3 text-white rounded md:hover:bg-transparent md:p-0 dark:text-white dark:hover:text-white md:dark:hover:bg-transparent">Hàng mới về</a></li>
                    </ul>
                </div>

                <div class="flex md:hidden ml-right">
                    <button id="menu-toggle" type="button" class="text-white focus:outline-none">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Menu di động -->
            <div class="md:hidden hidden" id="mobile-menu">
                <ul class="flex flex-col p-4 space-y-2">
                    <li><a href="#" class="block py-2 px-3 text-white rounded hover:bg-gray-700">Trang chủ</a></li>
                    <li><a href="#" class="block py-2 px-3 text-white rounded hover:bg-gray-700">Hàng mới nhất</a></li>
                    <li><a href="#" class="block py-2 px-3 text-white rounded hover:bg-gray-700">Đồ nam</a></li>
                    <li><a href="#" class="block py-2 px-3 text-white rounded hover:bg-gray-700">Đồ nữ</a></li>
                    <li><a href="#" class="block py-2 px-3 text-white rounded hover:bg-gray-700">Đồ trẻ em</a></li>
                </ul>
            </div>
        </nav>
    </header>

    <main>
        <section class="carousel">
            <div id="default-carousel" class="relative w-full" data-carousel="slide">
                <div class="relative h-[300px] md:h-[800px] w-full overflow-hidden rounded-lg">
                    <!-- Item 1 -->
                    <div class="hidden duration-700 ease-in-out" data-carousel-item>
                        <img src="/img/banner-website_master.webp" class="absolute inset-0 w-full h-full object-cover" alt="Banner 1">
                    </div>
                    <!-- Item 2 -->
                    <div class="hidden duration-700 ease-in-out" data-carousel-item>
                        <img src="/img/banner.jpg" class="absolute inset-0 w-full h-full object-cover" alt="Banner 2">
                    </div>
                    <!-- Item 3 -->
                    <div class="hidden duration-700 ease-in-out" data-carousel-item>
                        <img src="/img/banner-1.jpg" class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="Banner 3">
                    </div>
                </div>

                <!-- Slider indicators -->
                <div class="absolute z-30 flex -translate-x-1/2 bottom-5 left-1/2 space-x-3" style="color: white;">
                    <button type="button" class="w-3 h-3 rounded-full" aria-current="true" aria-label="Slide 1" data-carousel-slide-to="0"></button>
                    <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 2" data-carousel-slide-to="1"></button>
                    <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 3" data-carousel-slide-to="2"></button>
                </div>

                <!-- Slider controls -->
                <button type="button" class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-prev>
                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 group-focus:ring-4 group-focus:ring-white group-focus:outline-none">
                        <svg class="w-4 h-4 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4" />
                        </svg>
                        <span class="sr-only">Previous</span>
                    </span>
                </button>
                <button type="button" class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-next>
                    <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 group-focus:ring-4 group-focus:ring-white group-focus:outline-none">
                        <svg class="w-4 h-4 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
                        </svg>
                        <span class="sr-only">Next</span>
                    </span>
                </button>
            </div>
        </section>

        <section class="list mt-10">
                <div class="container">
                    <div class="sm:hidden">
                        <label for="tabs" class="sr-only">Select your
                            country</label>
                        <select id="tabs"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="#all">Tất cả</option>
                            <option value="#nike">Giày nike</option>
                            <option value="#adidas">Giày adidas</option>
                            <option value="#bitis">Giày bitis</option>
                        </select>
                    </div>
                    <ul class="hidden text-sm font-medium text-center text-gray-500 rounded-lg shadow sm:flex dark:divide-gray-700 dark:text-gray-400">
                        <li class="w-full focus-within:z-10">
                            <a href="#all" class="inline-block w-full p-4 text-white bg-red-400 border-r border-gray-200 dark:border-gray-700 rounded-s-lg focus:ring-4 focus:ring-blue-300 focus:outline-none dark:bg-gray-700 dark:text-white link-item" aria-current="page">Tất cả</a>
                        </li>
                        <li class="w-full focus-within:z-10">
                            <a href="#nike" class="inline-block w-full p-4 text-white bg-red-400 border-r border-gray-200 dark:border-gray-700 hover:text-white hover:bg-red-400 focus:ring-4 focus:ring-blue-300 focus:outline-none dark:hover:text-white dark:bg-gray-800 link-item">Giày nike</a>
                        </li>
                        <li class="w-full focus-within:z-10">
                            <a href="#adidas" class="inline-block w-full p-4 text-white bg-red-400 border-r border-gray-200 dark:border-gray-700 hover:text-white hover:bg-red-400 focus:ring-4 focus:ring-blue-300 focus:outline-none dark:hover:text-white dark:bg-gray-800 link-item">Giày adidas</a>
                        </li>
                        <li class="w-full focus-within:z-10">
                            <a href="#bitis" class="inline-block w-full p-4 text-white bg-red-400 border-s-0 border-gray-200 dark:border-gray-700 rounded-e-lg hover:text-white hover:bg-red-400 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:hover:text-white dark:bg-gray-800 link-item">Giày bitis</a>
                        </li>
                    </ul>
                    
                    <div class="tab-content mt-10">

                
                        
                        <form class="max-w-md ml-auto mb-10">   
                            <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                    </svg>
                                </div>
                                <input type="search" id="default-search" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search Mockups, Logos..." required />
                                <button type="submit" class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Search</button>
                            </div>
                        </form>
                        <div id="all" class="content">  
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                                <div class="border border-inherit">
                                    <img class="adidas_1 h-auto max-w-full rounded-lg" src="/img/adidas_1.webp" alt="">
                                    <div class="content pl-5">
                                      <p class="mt-1 font-bold">Giày adidas trắng style mới nhất</p>
                                      <p class="mt-1">1,500,000 <span>VND</span></p> 
                                      <div class="flex justify-between mt-5">
                                        <button class="relative inline-flex items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-pink-500 to-orange-400 group-hover:from-pink-500 group-hover:to-orange-400 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-pink-200 dark:focus:ring-pink-800">
                                            <span class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                                                Mua ngay
                                            </span>
                                            </button>
                                            <button class="relative inline-flex items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-pink-500 to-orange-400 group-hover:from-pink-500 group-hover:to-orange-400 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-pink-200 dark:focus:ring-pink-800">
                                                <span class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                                                    Thêm vào giỏ hàng
                                                </span>
                                                </button>
                                        
                                      </div>

                                    </div>
                                </div>
                                <div class="border border-inherit">
                                    <img class="adidas_1 h-auto max-w-full rounded-lg" src="/img/adidas_1.webp" alt="">
                                    <div class="content pl-5">
                                      <p class="mt-1 font-bold">Giày adidas trắng style mới nhất</p>
                                      <p class="mt-1">1,500,000 <span>VND</span></p> 
                                      <div class="flex justify-between mt-5">
                                        <button class="relative inline-flex items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-pink-500 to-orange-400 group-hover:from-pink-500 group-hover:to-orange-400 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-pink-200 dark:focus:ring-pink-800">
                                            <span class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                                                Mua ngay
                                            </span>
                                            </button>
                                            <button class="relative inline-flex items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-pink-500 to-orange-400 group-hover:from-pink-500 group-hover:to-orange-400 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-pink-200 dark:focus:ring-pink-800">
                                                <span class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                                                    Thêm vào giỏ hàng
                                                </span>
                                                </button>
                                        
                                      </div>

                                    </div>
                                </div>
                                <div class="border border-inherit">
                                    <img class="adidas_1 h-auto max-w-full rounded-lg" src="/img/adidas_1.webp" alt="">
                                    <div class="content pl-5">
                                      <p class="mt-1 font-bold">Giày adidas trắng style mới nhất</p>
                                      <p class="mt-1">1,500,000 <span>VND</span></p> 
                                      <div class="flex justify-between mt-5">
                                        <button class="relative inline-flex items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-pink-500 to-orange-400 group-hover:from-pink-500 group-hover:to-orange-400 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-pink-200 dark:focus:ring-pink-800">
                                            <span class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                                                Mua ngay
                                            </span>
                                            </button>
                                            <button class="relative inline-flex items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-pink-500 to-orange-400 group-hover:from-pink-500 group-hover:to-orange-400 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-pink-200 dark:focus:ring-pink-800">
                                                <span class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                                                    Thêm vào giỏ hàng
                                                </span>
                                                </button>
                                        
                                      </div>

                                    </div>
                                </div>
                                <div class="border border-inherit">
                                    <img class="adidas_1 h-auto max-w-full rounded-lg" src="/img/adidas_1.webp" alt="">
                                    <div class="content pl-5">
                                      <p class="mt-1 font-bold">Giày adidas trắng style mới nhất</p>
                                      <p class="mt-1">1,500,000 <span>VND</span></p> 
                                      <div class="flex justify-between mt-5">
                                        <button class="relative inline-flex items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-pink-500 to-orange-400 group-hover:from-pink-500 group-hover:to-orange-400 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-pink-200 dark:focus:ring-pink-800">
                                            <span class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                                                Mua ngay
                                            </span>
                                            </button>
                                            <button class="relative inline-flex items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-pink-500 to-orange-400 group-hover:from-pink-500 group-hover:to-orange-400 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-pink-200 dark:focus:ring-pink-800">
                                                <span class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                                                    Thêm vào giỏ hàng
                                                </span>
                                                </button>
                                        
                                      </div>

                                    </div>
                                </div>
                                <div class="border border-inherit">
                                    <img class="adidas_1 h-auto max-w-full rounded-lg" src="/img/adidas_1.webp" alt="">
                                    <div class="content pl-5">
                                      <p class="mt-1 font-bold">Giày adidas trắng style mới nhất</p>
                                      <p class="mt-1">1,500,000 <span>VND</span></p> 
                                      <div class="flex justify-between mt-5">
                                        <button class="relative inline-flex items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-pink-500 to-orange-400 group-hover:from-pink-500 group-hover:to-orange-400 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-pink-200 dark:focus:ring-pink-800">
                                            <span class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                                                Mua ngay
                                            </span>
                                            </button>
                                            <button class="relative inline-flex items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-pink-500 to-orange-400 group-hover:from-pink-500 group-hover:to-orange-400 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-pink-200 dark:focus:ring-pink-800">
                                                <span class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                                                    Thêm vào giỏ hàng
                                                </span>
                                                </button>
                                        
                                      </div>

                                    </div>
                                </div>
                                <div class="border border-inherit">
                                    <img class="adidas_1 h-auto max-w-full rounded-lg" src="/img/adidas_1.webp" alt="">
                                    <div class="content pl-5">
                                      <p class="mt-1 font-bold">Giày adidas trắng style mới nhất</p>
                                      <p class="mt-1">1,500,000 <span>VND</span></p> 
                                      <div class="flex justify-between mt-5">
                                        <button class="relative inline-flex items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-pink-500 to-orange-400 group-hover:from-pink-500 group-hover:to-orange-400 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-pink-200 dark:focus:ring-pink-800">
                                            <span class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                                                Mua ngay
                                            </span>
                                            </button>
                                            <button class="relative inline-flex items-center justify-center p-0.5 mb-2 me-2 overflow-hidden text-sm font-medium text-gray-900 rounded-lg group bg-gradient-to-br from-pink-500 to-orange-400 group-hover:from-pink-500 group-hover:to-orange-400 hover:text-white dark:text-white focus:ring-4 focus:outline-none focus:ring-pink-200 dark:focus:ring-pink-800">
                                                <span class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-white dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                                                    Thêm vào giỏ hàng
                                                </span>
                                                </button>
                                        
                                      </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    
                        <div id="nike" class="content hidden">
                            <h3>Menu 2 - Giày Nike</h3>
                            <p>Some content about Nike shoes.</p>
                        </div>
                        <div id="adidas" class="content hidden">
                            <h3>Menu 3 - Giày Adidas</h3>
                            <p>Some content about Adidas shoes.</p>
                        </div>
                        <div id="bitis" class="content hidden">
                            <h3>Menu 4 - Giày Biti's</h3>
                            <p>Some content about Biti's shoes.</p>
                        </div>
                    </div>
                    
                    
                    
                </div>
               
            </section>


    </main>

    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.js"></script>
    <script>
        const menuToggle = document.getElementById('menu-toggle');
        const mobileMenu = document.getElementById('mobile-menu');

        menuToggle.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    </script>
</body>
</html>
