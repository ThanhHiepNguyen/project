<?php
if (!isset($_SESSION)) {
    session_start();
}
require_once __DIR__ . '/../../cauhinh/ketnoi.php';

if (!isset($_SESSION['khachhang'])) {
    echo '<div class="min-h-[50vh] flex items-center justify-center">
            <div class="bg-white p-8 rounded-xl shadow-md text-center max-w-md w-full">
                <h2 class="text-2xl font-bold text-gray-800 mb-3">Bạn chưa đăng nhập</h2>
                <p class="text-gray-600 mb-6">Vui lòng đăng nhập để xem danh sách sản phẩm yêu thích.</p>
                <a href="index.php?page_layout=dangnhap"
                   class="inline-flex items-center px-6 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition">
                    Đăng nhập
                </a>
            </div>
          </div>';
    return;
}

$id_khachhang = (int)$_SESSION['khachhang']['id_khachhang'];

$sql = "SELECT s.*
        FROM yeu_thich yt
        JOIN sanpham s ON yt.id_sanpham = s.id_sp
        WHERE yt.id_khachhang = $id_khachhang
        ORDER BY yt.ngay_them DESC";
$query = mysqli_query($conn, $sql);
?>

<div class="mb-12">
    <div class="text-center mb-8">
        <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4 relative inline-block">
            <span class="relative z-10 bg-gray-50 px-4">Sản phẩm yêu thích của bạn</span>
            <span class="absolute left-0 right-0 top-1/2 h-0.5 bg-gradient-to-r from-transparent via-pink-500 to-transparent"></span>
        </h2>
        <p class="text-gray-500 text-sm max-w-xl mx-auto">
            Những sản phẩm bạn đã đánh dấu yêu thích sẽ xuất hiện tại đây để tiện theo dõi và mua lại.
        </p>
    </div>

    <?php if ($query && mysqli_num_rows($query) > 0): ?>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <?php while ($row = mysqli_fetch_assoc($query)): ?>
                <div class="group relative bg-white rounded-lg shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden transform hover:-translate-y-2">
                    <a href="index.php?page_layout=chitietsp&id_sp=<?php echo $row['id_sp'] ?>" class="block">
                        <div class="relative overflow-hidden bg-gray-100 aspect-square">
                            <img src="<?php echo htmlspecialchars($row['anh_sp']); ?>"
                                 alt="<?php echo htmlspecialchars($row['ten_sp']); ?>"
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/5 transition-colors duration-300"></div>
                        </div>
                    </a>
                    <div class="p-4">
                        <h3 class="text-sm font-semibold text-gray-800 mb-2 line-clamp-2 min-h-[2.5rem]">
                            <a href="index.php?page_layout=chitietsp&id_sp=<?php echo $row['id_sp'] ?>"
                               class="hover:text-blue-600 transition-colors duration-200">
                                <?php echo htmlspecialchars($row['ten_sp']); ?>
                            </a>
                        </h3>
                        <p class="text-lg font-bold text-blue-600 mb-3">
                            <?php echo number_format($row['gia_sp'], 0, ',', '.'); ?>₫
                        </p>
                        <div class="flex justify-between items-center">
                            <a href="chucnang/yeuthich/toggle.php?id_sp=<?php echo $row['id_sp']; ?>&redirect=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>"
                               class="inline-flex items-center text-sm text-red-500 hover:text-red-600">
                                <i class="fa-solid fa-heart mr-1"></i> Bỏ yêu thích
                            </a>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    <?php else: ?>
        <div class="text-center text-gray-500 py-16">
            Hiện tại bạn chưa có sản phẩm yêu thích nào.
        </div>
    <?php endif; ?>
</div>


