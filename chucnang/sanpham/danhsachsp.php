<?php
$ten_dm = isset($_GET['ten_dm']) ? trim($_GET['ten_dm']) : 'Danh mục sản phẩm';
$id_dm = isset($_GET['id_dm']) ? (int)$_GET['id_dm'] : 0;
$rowPerPage = 8;
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$perRow = ($page * $rowPerPage) - $rowPerPage;
$totalRow = 0;

// Lấy danh sách sản phẩm yêu thích của khách hiện tại
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

if ($id_dm > 0) {
    $countRes = mysqli_query($conn, "SELECT COUNT(*) AS total FROM sanpham WHERE id_dm = {$id_dm}");
    if ($countRes) {
        $countData = mysqli_fetch_assoc($countRes);
        $totalRow = isset($countData['total']) ? (int)$countData['total'] : 0;
    }
}
?>

<div class="mb-12">
    <div class="text-center mb-8">
        <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4 relative inline-block">
            <span class="relative z-10 bg-gray-50 px-4"><?php echo htmlspecialchars($ten_dm); ?></span>
            <span class="absolute left-0 right-0 top-1/2 h-0.5 bg-gradient-to-r from-transparent via-blue-500 to-transparent"></span>
        </h2>
    </div>

    <?php if ($totalRow > 0): ?>
        <?php
            $sql = "SELECT * FROM sanpham WHERE id_dm = {$id_dm} ORDER BY id_sp DESC LIMIT {$perRow}, {$rowPerPage}";
            $query = mysqli_query($conn, $sql);
            $totalPage = (int)ceil($totalRow / $rowPerPage);
            $listPage = '';
            if ($page > 1) {
                $listPage .= '<a href="index.php?page_layout=danhsachsp&id_dm='.$id_dm.'&ten_dm='.$ten_dm.'&page=1"> First </a>';
                $prev = $page - 1;
                $listPage .= '<a href="index.php?page_layout=danhsachsp&id_dm='.$id_dm.'&ten_dm='.$ten_dm.'&page='.$prev.'"> << </a>';
            }
            for ($i = 1; $i <= $totalPage; $i++) {
                if ($i == $page) {
                    $listPage .= '<span> '.$i.' </span>';
                } else {
                    $listPage .= '<a href="index.php?page_layout=danhsachsp&id_dm='.$id_dm.'&ten_dm='.$ten_dm.'&page='.$i.'"> '.$i.' </a>';
                }
            }
            if ($page < $totalPage) {
                $next = $page + 1;
                $listPage .= '<a href="index.php?page_layout=danhsachsp&id_dm='.$id_dm.'&ten_dm='.$ten_dm.'&page='.$next.'"> >> </a>';
                $listPage .= '<a href="index.php?page_layout=danhsachsp&id_dm='.$id_dm.'&ten_dm='.$ten_dm.'&page='.$totalPage.'"> Last </a>';
            }
        ?>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <?php while ($row = mysqli_fetch_assoc($query)): ?>
                <?php $isFavorite = isset($favoriteIds[(int)$row['id_sp']]); ?>
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
                        <h3 class="text-sm font-semibold text-gray-800 mb-2 line-clamp-2 min-h-[2.5rem]">
                            <a href="index.php?page_layout=chitietsp&id_sp=<?php echo $row['id_sp'] ?>" 
                               class="hover:text-blue-600 transition-colors duration-200">
                                <?php echo htmlspecialchars($row['ten_sp']); ?>
                            </a>
                        </h3>
                        <p class="text-lg font-bold text-blue-600">
                            <?php echo number_format($row['gia_sp'], 0, ',', '.') ?>₫
                        </p>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>

        <div class="flex justify-center items-center space-x-2 mt-8 mb-8">
            <?php echo $listPage; ?>
        </div>
    <?php else: ?>
        <?php
            $subQuery = mysqli_query($conn, "SELECT * FROM dmphutung_con WHERE id_dm = {$id_dm} ORDER BY ten_dm_con ASC");
        ?>
        <?php if ($subQuery && mysqli_num_rows($subQuery) > 0): ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php while ($sub = mysqli_fetch_assoc($subQuery)): ?>
                    <?php
                        $images = [];
                        $safePart = mysqli_real_escape_string($conn, $sub['ten_dm_con']);
                        $imgRes = mysqli_query($conn, "SELECT image_link FROM images WHERE part_name = '{$safePart}' LIMIT 3");
                        if ($imgRes) {
                            while ($imgRow = mysqli_fetch_assoc($imgRes)) {
                                $images[] = $imgRow['image_link'];
                            }
                        }
                    ?>
                    <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-all duration-300 overflow-hidden">
                        <div class="h-52 bg-gray-100 flex items-center justify-center overflow-hidden">
                            <?php if (!empty($images)): ?>
                                <img src="<?php echo htmlspecialchars($images[0]); ?>" alt="<?php echo htmlspecialchars($sub['ten_dm_con']); ?>" class="w-full h-full object-cover">
                            <?php else: ?>
                                <div class="text-gray-400 text-sm text-center p-4">
                                    Chưa có hình minh hoạ
                                </div>
                            <?php endif; ?>
                        </div>
                        <?php if (count($images) > 1): ?>
                            <div class="flex items-center justify-center space-x-2 p-3 bg-gray-50">
                                <?php foreach ($images as $index => $thumb): ?>
                                    <?php if ($index === 0) continue; ?>
                                    <img src="<?php echo htmlspecialchars($thumb); ?>" alt="thumb"
                                         class="w-12 h-12 object-cover rounded-md border border-white shadow">
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-gray-800 mb-1">
                                <?php echo htmlspecialchars($sub['ten_dm_con']); ?>
                            </h3>
                            <p class="text-sm text-gray-500 mb-4">Đang cập nhật sản phẩm chi tiết.</p>
                            <a href="index.php?page_layout=danhsachsp&id_dm=<?php echo $id_dm; ?>&ten_dm=<?php echo urlencode($ten_dm); ?>&part=<?php echo urlencode($sub['ten_dm_con']); ?>"
                               class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-full hover:bg-blue-700 transition">
                                Tư vấn ngay
                                <i class="fa-solid fa-arrow-right ml-2 text-xs"></i>
                            </a>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <div class="text-center text-gray-500 py-16">
                Chưa có dữ liệu cho danh mục này. Vui lòng quay lại sau.
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>
