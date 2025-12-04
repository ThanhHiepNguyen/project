<!-- Header -->
<header class="sticky top-0 z-50 bg-gradient-to-r from-blue-600 via-blue-500 to-blue-600 border-b-2 border-blue-700 shadow-lg">
    <!-- Top Header -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <!-- Logo -->
            <div class="flex-shrink-0">
                <a href="index.php" class="block">
                    <img src="anh/logo.png" alt="Phụ Tùng Xe Hạnh Phương" class="h-12 w-auto hover:opacity-80 transition-opacity">
                </a>
            </div>

            <!-- Navigation Menu -->
            <nav class="hidden md:flex items-center space-x-8">
                <a href="index.php" class="text-white hover:text-yellow-300 font-semibold transition-colors duration-200 relative group">
                    Trang chủ
                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-yellow-300 transition-all duration-300 group-hover:w-full"></span>
                </a>
                <a href="index.php?page_layout=gioithieu" class="text-white hover:text-yellow-300 font-semibold transition-colors duration-200 relative group">
                    Giới thiệu
                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-yellow-300 transition-all duration-300 group-hover:w-full"></span>
                </a>
                <a href="index.php?page_layout=lienhe" class="text-white hover:text-yellow-300 font-semibold transition-colors duration-200 relative group">
                    Liên hệ
                    <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-yellow-300 transition-all duration-300 group-hover:w-full"></span>
                </a>
            </nav>

            <!-- Right Side: Search, Cart, Order Tracking -->
            <div class="flex items-center space-x-4">
                <!-- Search Bar -->
                <div class="hidden lg:block">
                    <?php require "chucnang/timkiem/timkiem.php"; ?>
                </div>

                <!-- Order Tracking -->
                <div class="hidden md:block">
                    <?php require "chucnang/giohang/tracuudonhang.php"; ?>
                </div>

                <!-- Cart -->
                <div>
                    <?php require "chucnang/giohang/giohangcuaban.php"; ?>
                </div>

                <!-- Mobile Menu Button -->
                <button id="mobile-menu-button" class="md:hidden p-2 rounded-md text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-yellow-300">
                    <i class="fa-solid fa-bars text-xl"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Search Bar -->
        <div class="lg:hidden pb-3">
            <?php require "chucnang/timkiem/timkiem.php"; ?>
        </div>
    </div>

    <!-- Category Navigation -->
    <div class="bg-white border-t border-gray-300 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex items-center justify-center overflow-x-auto py-3 space-x-6">
                <?php
                $sql = "SELECT * FROM dmsanpham";
                $query = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_array($query)) {
                ?>
                    <a href="index.php?page_layout=danhsachsp&id_dm=<?php echo $row['id_dm'];?>&ten_dm=<?php echo urlencode($row['ten_dm']);?>" 
                       class="flex-shrink-0 text-gray-700 hover:text-blue-600 font-semibold px-4 py-2 rounded-md transition-colors duration-200 whitespace-nowrap hover:bg-blue-50 border-b-2 border-transparent hover:border-blue-600">
                        <i class="fa-solid fa-wrench mr-2"></i>
                        <?php echo htmlspecialchars($row['ten_dm']); ?>
                    </a>
                <?php
                }
                ?>
            </nav>
        </div>
    </div>

    <!-- Mobile Menu (Hidden by default) -->
    <div id="mobile-menu" class="hidden md:hidden bg-white border-t border-gray-200">
        <div class="px-4 pt-2 pb-4 space-y-1">
            <a href="index.php" class="block px-3 py-2 rounded-md text-gray-700 hover:bg-blue-50 hover:text-blue-600 font-medium">
                <i class="fa-solid fa-home mr-2"></i>Trang chủ
            </a>
            <a href="index.php?page_layout=gioithieu" class="block px-3 py-2 rounded-md text-gray-700 hover:bg-blue-50 hover:text-blue-600 font-medium">
                <i class="fa-solid fa-info-circle mr-2"></i>Giới thiệu
            </a>
            <a href="index.php?page_layout=lienhe" class="block px-3 py-2 rounded-md text-gray-700 hover:bg-blue-50 hover:text-blue-600 font-medium">
                <i class="fa-solid fa-phone mr-2"></i>Liên hệ
            </a>
            <div class="pt-2">
                <?php require "chucnang/giohang/tracuudonhang.php"; ?>
            </div>
        </div>
    </div>
</header>

<script>
    // Mobile menu toggle
    document.getElementById('mobile-menu-button')?.addEventListener('click', function() {
        const menu = document.getElementById('mobile-menu');
        menu.classList.toggle('hidden');
    });
</script>