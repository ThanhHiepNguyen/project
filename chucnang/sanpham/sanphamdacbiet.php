<?php
$dbHost = 'localhost';
$dbUsername = 'root';
$dbPassword = '';
$dbName = 'trangsucshop';

$conn = mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbName, '3306');
if ($conn) {
    $setLang = mysqli_query($conn, "SET NAMES 'utf8'");
} else {
    die('Kết nối thất bại!' . mysqli_connect_error());
}

// Hàm để lấy số lượng sản phẩm đã thêm vào giỏ hàng
function getQuantityInCart($id_sp) {
    return isset($_SESSION['giohang'][$id_sp]) ? $_SESSION['giohang'][$id_sp] : 0;
}
?>

<div class="mb-12">
    <div class="text-center mb-8">
        <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4 relative inline-block">
            <span class="relative z-10 bg-gray-50 px-4">Sản phẩm nổi bật</span>
            <span class="absolute left-0 right-0 top-1/2 h-0.5 bg-gradient-to-r from-transparent via-blue-500 to-transparent"></span>
        </h2>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        <?php
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

        $sql = "SELECT * FROM sanpham WHERE dac_biet = 1 ORDER BY id_sp DESC LIMIT 0,12";
        $query = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_array($query)) {
            $id_sp = $row['id_sp'];

            // Truy vấn để lấy số lượng sản phẩm trong kho
            $sql_stock = "SELECT so_luong FROM sanpham WHERE id_sp = ?";
            $stmt = $conn->prepare($sql_stock);
            $stmt->bind_param("i", $id_sp);
            $stmt->execute();
            $result = $stmt->get_result();
            $stock = ($result->num_rows > 0) ? $result->fetch_assoc()['so_luong'] : 0;

            // Lấy số lượng sản phẩm đã thêm vào giỏ hàng
            $quantity_in_cart = getQuantityInCart($id_sp);
            $isFavorite = isset($favoriteIds[(int)$id_sp]);
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
                    <a class="btn_cart absolute top-4 right-4 bg-white/90 backdrop-blur-sm rounded-full p-3 shadow-lg opacity-0 group-hover:opacity-100 transition-all duration-300 hover:bg-blue-600 hover:text-white transform translate-y-2 group-hover:translate-y-0" 
                       href="javascript:void(0);" 
                       onclick="checkStockAndProceed(<?php echo $stock; ?>, <?php echo $quantity_in_cart; ?>, 'chucnang/giohang/themhangindex.php?id_sp=<?php echo $row['id_sp']; ?>')"
                       title="Thêm vào giỏ hàng">
                        <i class="fa-solid fa-cart-plus text-lg"></i>
                    </a>
                </div>
            </div>
        <?php
        }
        ?>
    </div>
</div>

<script>
    function checkStockAndProceed(stock, quantityInCart, url) {
    var quantityToAdd = 1; // Số lượng thêm vào giỏ hàng

    if (stock <= 0) {
        // Sản phẩm không có sẵn trong kho
        alert('Sản phẩm này hiện không có sẵn');
    } else if (quantityInCart + quantityToAdd > stock) {
        // Số lượng trong giỏ hàng cộng với số lượng muốn thêm vượt quá số lượng trong kho
        alert('Bạn đã thêm hết số lượng sản phẩm có trong kho');
    } else {
        // Điều kiện để thêm sản phẩm vào giỏ hàng
        window.location.href = url;
    }
}
</script>

<?php

?>
