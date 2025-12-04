<div class="mb-12">
    <div class="text-center mb-8">
        <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4 relative inline-block">
            <span class="relative z-10 bg-gray-50 px-4">Sản phẩm thịnh hành</span>
            <span class="absolute left-0 right-0 top-1/2 h-0.5 bg-gradient-to-r from-transparent via-blue-500 to-transparent"></span>
        </h2>
    
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        <?php
        // Lấy danh sách sản phẩm yêu thích hiện tại của khách (nếu có)
        $favoriteIds = [];
        if (isset($_SESSION['khachhang'])) {
            $id_khachhang = (int)$_SESSION['khachhang']['id_khachhang'];
            $favRes = mysqli_query($conn, "SELECT id_sanpham FROM yeu_thich WHERE id_khachhang = $id_khachhang");
            if ($favRes) {
                while ($favRow = mysqli_fetch_assoc($favRes)) {
                    $favoriteIds[(int)$favRow['id_sanpham']] = true;
                }
            }
        }

        $sql = "SELECT * FROM sanpham 
                ORDER BY so_luong_da_ban DESC, RAND() 
                LIMIT 12";
        $query = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_array($query)) {
            $isFavorite = isset($favoriteIds[(int)$row['id_sp']]);
        ?>
            <div class="group relative bg-white rounded-lg shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden transform hover:-translate-y-2">
                <a href="index.php?page_layout=chitietsp&id_sp=<?php echo $row['id_sp'] ?>" class="block">
                    <div class="relative overflow-hidden bg-gray-100 aspect-square">
                        <img src="<?php echo htmlspecialchars($row['anh_sp']); ?>" 
                             alt="<?php echo htmlspecialchars($row['ten_sp']); ?>"
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/5 transition-colors duration-300"></div>
                    </div>
                </a>
                <?php if (isset($_SESSION['khachhang'])): ?>
                    <a href="chucnang/yeuthich/toggle.php?id_sp=<?php echo $row['id_sp']; ?>&redirect=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>"
                       class="absolute top-3 left-3 inline-flex items-center justify-center w-9 h-9 rounded-full bg-white/90 shadow-md hover:bg-pink-50 transition">
                        <i class="<?php echo $isFavorite ? 'fa-solid fa-heart text-pink-500' : 'fa-regular fa-heart text-gray-400'; ?>"></i>
                    </a>
                <?php endif; ?>
                <div class="p-4">
                    <h3 class="prd-name text-sm font-semibold text-gray-800 mb-2 line-clamp-2 min-h-[2.5rem]">
                        <a href="index.php?page_layout=chitietsp&id_sp=<?php echo $row['id_sp'] ?>" 
                           class="hover:text-blue-600 transition-colors duration-200">
                            <?php echo htmlspecialchars($row['ten_sp']); ?>
                        </a>
                    </h3>
                    <p class="price text-lg font-bold text-blue-600 mb-3">
                        <?php echo number_format($row['gia_sp'], 0, ',', '.') ?>₫
                    </p>
                </div>
            </div>
        <?php
        }
        ?>
    </div>
</div>


