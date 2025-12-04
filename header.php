<?php
$categoryMenu = [];
$categoryResult = mysqli_query($conn, "SELECT * FROM dmsanpham ORDER BY id_dm ASC");
if ($categoryResult) {
    while ($cat = mysqli_fetch_assoc($categoryResult)) {
        $cat['children'] = [];
        $categoryMenu[$cat['id_dm']] = $cat;
    }
}
if (!empty($categoryMenu)) {
    $childResult = mysqli_query($conn, "SELECT * FROM dmphutung_con ORDER BY id_dm ASC, ten_dm_con ASC");
    if ($childResult) {
        while ($child = mysqli_fetch_assoc($childResult)) {
            if (isset($categoryMenu[$child['id_dm']])) {
                $categoryMenu[$child['id_dm']]['children'][] = $child;
            }
        }
    }
}
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
    <div class="bg-white border-t border-gray-200 shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div class="relative w-full md:w-auto">
                <button id="mega-menu-toggle"
                        class="w-full md:w-auto inline-flex items-center justify-between md:justify-center px-5 py-2.5 rounded-full border border-blue-200 bg-blue-50 text-blue-700 font-semibold shadow-sm hover:bg-blue-100 transition-colors duration-200">
                    <span class="flex items-center">
                        <i class="fa-solid fa-bars mr-2"></i>
                        Danh mục sản phẩm
                    </span>
                    <i class="fa-solid fa-chevron-down text-xs ml-3"></i>
                </button>
                <div id="mega-menu-panel"
                     class="hidden absolute left-0 mt-3 w-full md:w-[720px] bg-white border border-gray-200 rounded-2xl shadow-2xl z-50">
                    <?php if (!empty($categoryMenu)): ?>
                        <div class="flex flex-col md:flex-row">
                            <div class="md:w-5/12 border-b md:border-b-0 md:border-r border-gray-100 bg-blue-50 rounded-t-2xl md:rounded-l-2xl p-3 space-y-1">
                                <?php
                                $firstKey = array_key_first($categoryMenu);
                                foreach ($categoryMenu as $catId => $category):
                                ?>
                                    <button
                                        class="category-item w-full text-left px-4 py-2 rounded-xl text-sm font-semibold transition-colors duration-150 <?php echo $catId === $firstKey ? 'bg-blue-600 text-white shadow' : 'text-blue-700 hover:bg-blue-100'; ?>"
                                        data-target="cat-<?php echo $catId; ?>">
                                        <?php echo htmlspecialchars($category['ten_dm']); ?>
                                    </button>
                                <?php endforeach; ?>
                            </div>
                            <div class="md:w-7/12 p-5 space-y-4">
                                <?php foreach ($categoryMenu as $catId => $category): ?>
                                    <div id="cat-<?php echo $catId; ?>" class="subcategory-panel <?php echo $catId === $firstKey ? '' : 'hidden'; ?>">
                                        <p class="text-sm font-semibold text-gray-500 mb-2 uppercase tracking-wide">
                                            <?php echo htmlspecialchars($category['ten_dm']); ?>
                                        </p>
                                        <?php if (!empty($category['children'])): ?>
                                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                                                <?php foreach ($category['children'] as $child): ?>
                                                    <a href="index.php?page_layout=danhsachsp&id_dm=<?php echo $category['id_dm']; ?>&ten_dm=<?php echo urlencode($category['ten_dm']); ?>"
                                                       class="px-3 py-2 rounded-lg bg-gray-50 hover:bg-blue-50 hover:text-blue-600 text-sm font-medium text-gray-700 transition-colors duration-150">
                                                        <?php echo htmlspecialchars($child['ten_dm_con']); ?>
                                                    </a>
                                                <?php endforeach; ?>
                                            </div>
                                        <?php else: ?>
                                            <p class="text-sm text-gray-500">Danh mục này đang được cập nhật.</p>
                                        <?php endif; ?>
                                        <div class="mt-4">
                                            <a href="index.php?page_layout=danhsachsp&id_dm=<?php echo $category['id_dm']; ?>&ten_dm=<?php echo urlencode($category['ten_dm']); ?>"
                                               class="inline-flex items-center text-xs font-semibold text-blue-600 hover:text-blue-700">
                                                Xem tất cả sản phẩm
                                                <i class="fa-solid fa-arrow-right ml-2 text-[10px]"></i>
                                            </a>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="p-4 text-sm text-gray-600">
                            Chưa có danh mục sản phẩm. Vui lòng bổ sung dữ liệu trong bảng <code>dmsanpham</code>.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="flex items-center space-x-4 text-sm font-semibold text-gray-600 overflow-x-auto">
                <a href="#" class="hover:text-blue-600 transition-colors duration-150">Tin tức</a>
                <a href="#" class="hover:text-blue-600 transition-colors duration-150">Tuyển dụng</a>
                <a href="index.php?page_layout=lienhe" class="hover:text-blue-600 transition-colors duration-150">Liên hệ</a>
                <a href="#" class="hover:text-blue-600 transition-colors duration-150">Sự kiện</a>
            </div>
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

    // Mega menu interactions
    const megaToggle = document.getElementById('mega-menu-toggle');
    const megaPanel = document.getElementById('mega-menu-panel');
    const categoryButtons = document.querySelectorAll('.category-item');
    const subPanels = document.querySelectorAll('.subcategory-panel');

    if (megaToggle && megaPanel) {
        megaToggle.addEventListener('click', function (e) {
            e.preventDefault();
            megaPanel.classList.toggle('hidden');
        });

        document.addEventListener('click', function (event) {
            if (!megaPanel.contains(event.target) && !megaToggle.contains(event.target)) {
                megaPanel.classList.add('hidden');
            }
        });
    }

    function setActiveCategory(button) {
        const targetId = button.getAttribute('data-target');
        categoryButtons.forEach(btn => btn.classList.remove('bg-blue-600', 'text-white', 'shadow'));
        button.classList.add('bg-blue-600', 'text-white', 'shadow');

        subPanels.forEach(panel => {
            if (panel.id === targetId) {
                panel.classList.remove('hidden');
            } else {
                panel.classList.add('hidden');
            }
        });
    }

    categoryButtons.forEach(button => {
        button.addEventListener('mouseenter', () => setActiveCategory(button));
        button.addEventListener('click', (e) => {
            e.preventDefault();
            setActiveCategory(button);
        });
    });
</script>