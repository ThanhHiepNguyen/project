<?php
// Load environment variables
require_once __DIR__ . '/cauhinh/env.php';
?>
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

            <!-- Right Side: Search, Cart, Order Tracking, User -->
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

                <!-- User Auth (desktop dropdown) -->
                <div class="hidden md:block relative">
                    <button id="user-menu-button"
                            class="flex items-center space-x-2 px-4 py-1.5 rounded-full border border-white/60 bg-blue-500/40 text-white text-sm font-semibold hover:bg-blue-500/70 transition">
                        <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-white/20 text-xs font-bold uppercase">
                            <?php
                            if (isset($_SESSION['khachhang'])) {
                                $name = trim($_SESSION['khachhang']['ten_khachhang']);
                                $initials = mb_substr($name, 0, 1, 'UTF-8');
                                echo htmlspecialchars($initials);
                            } else {
                                echo '<i class="fa-solid fa-user"></i>';
                            }
                            ?>
                        </span>
                        <span>
                            <?php if (isset($_SESSION['khachhang'])): ?>
                                Xin chào, <span class="font-bold"><?php echo htmlspecialchars($_SESSION['khachhang']['ten_khachhang']); ?></span>
                            <?php else: ?>
                                Tài khoản
                            <?php endif; ?>
                        </span>
                        <i class="fa-solid fa-chevron-down text-xs opacity-80"></i>
                    </button>

                    <div id="user-menu"
                         class="hidden absolute right-0 mt-2 w-48 rounded-xl bg-white shadow-lg border border-gray-100 py-2 z-50">
                        <?php if (isset($_SESSION['khachhang'])): ?>
                            <a href="index.php?page_layout=donhangcuatoi"
                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700">
                                Đơn hàng của tôi
                            </a>
                            <button onclick="window.location.href='index.php?page_layout=dangxuat'"
                                    class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-red-50 hover:text-red-600">
                                Đăng xuất
                            </button>
                        <?php else: ?>
                            <a href="index.php?page_layout=dangnhap"
                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700">
                                Đăng nhập
                            </a>
                            <a href="index.php?page_layout=dangky"
                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-700">
                                Đăng ký
                            </a>
                        <?php endif; ?>
                    </div>
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
            <div class="pt-2 border-t border-gray-200 mt-2">
                <?php if (isset($_SESSION['khachhang'])): ?>
                    <p class="px-3 py-2 text-sm text-gray-700">
                        Xin chào,
                        <span class="font-semibold">
                            <?php echo htmlspecialchars($_SESSION['khachhang']['ten_khachhang']); ?>
                        </span>
                    </p>
                    <a href="index.php?page_layout=donhangcuatoi"
                       class="block px-3 py-2 rounded-md text-gray-700 hover:bg-blue-50 hover:text-blue-600 font-medium">
                        <i class="fa-solid fa-box mr-2"></i>Đơn hàng của tôi
                    </a>
                    <a href="index.php?page_layout=dangxuat"
                       class="block px-3 py-2 rounded-md text-gray-700 hover:bg-blue-50 hover:text-blue-600 font-medium">
                        <i class="fa-solid fa-right-from-bracket mr-2"></i>Đăng xuất
                    </a>
                <?php else: ?>
                    <a href="index.php?page_layout=dangnhap"
                       class="block px-3 py-2 rounded-md text-gray-700 hover:bg-blue-50 hover:text-blue-600 font-medium">
                        <i class="fa-solid fa-right-to-bracket mr-2"></i>Đăng nhập
                    </a>
                    <a href="index.php?page_layout=dangky"
                       class="block px-3 py-2 rounded-md text-gray-700 hover:bg-blue-50 hover:text-blue-600 font-medium">
                        <i class="fa-solid fa-user-plus mr-2"></i>Đăng ký
                    </a>
                <?php endif; ?>
            </div>
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

    // User dropdown (desktop)
    const userMenuButton = document.getElementById('user-menu-button');
    const userMenu = document.getElementById('user-menu');

    if (userMenuButton && userMenu) {
        userMenuButton.addEventListener('click', function (e) {
            e.stopPropagation();
            userMenu.classList.toggle('hidden');
        });

        document.addEventListener('click', function () {
            if (!userMenu.classList.contains('hidden')) {
                userMenu.classList.add('hidden');
            }
        });
    }
</script>

<!-- Firebase SDK -->
<script src="https://www.gstatic.com/firebasejs/9.6.1/firebase-app-compat.js"></script>
<script src="https://www.gstatic.com/firebasejs/9.6.1/firebase-auth-compat.js"></script>
<script>
  // Your web app's Firebase configuration
  const firebaseConfig = {
    apiKey: "<?php echo getenv('FIREBASE_API_KEY'); ?>",
    authDomain: "<?php echo getenv('FIREBASE_AUTH_DOMAIN'); ?>",
    projectId: "<?php echo getenv('FIREBASE_PROJECT_ID'); ?>",
    storageBucket: "<?php echo getenv('FIREBASE_STORAGE_BUCKET'); ?>",
    messagingSenderId: "<?php echo getenv('FIREBASE_MESSAGING_SENDER_ID'); ?>",
    appId: "<?php echo getenv('FIREBASE_APP_ID'); ?>"
  };

  // Initialize Firebase
  const app = firebase.initializeApp(firebaseConfig);
  const auth = firebase.auth();
</script>