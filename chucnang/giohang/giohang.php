<?php
//session_start();
require "cauhinh/ketnoi.php"; // Kết nối cơ sở dữ liệu của bạn

if (isset($_POST['update_cart'])) {
    if (isset($_POST['sl'])) {
        foreach ($_POST['sl'] as $id_sp => $sl) {
            // Nếu số lượng nhập vào là 0 thì unset sản phẩm đó
            if ($sl == 0) {
                unset($_SESSION['giohang'][$id_sp]);
            } else {
                // Nếu số khác 0 thì gán ngược lại
                $_SESSION['giohang'][$id_sp] = $sl;
            }
        }
    }
}

?>
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h2 class="text-3xl md:text-4xl font-bold text-center text-gray-800 mb-8 pb-4 border-b-2 border-blue-600">
        Giỏ hàng của bạn
    </h2>
    
    <?php
    if (isset($_SESSION['giohang'])) {
        $arrId = array();
        foreach ($_SESSION['giohang'] as $id_sp => $sl) {
            $arrId[] = $id_sp;
        }

        $strID = implode(',', $arrId);

        if (!empty($strID)) {
            $sql = "SELECT * FROM sanpham WHERE id_sp IN ($strID)";
            $query = mysqli_query($conn, $sql);
            $totalPriceAll = 0;
    ?>
            <form method="post" id="giohang" class="space-y-6">
                <?php
                while ($row = mysqli_fetch_array($query)) {
                    $totalPrice = $_SESSION['giohang'][$row['id_sp']] * $row['gia_sp'];
                    $totalPriceAll += $totalPrice;
                ?>
                    <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 p-6 border border-gray-200">
                        <div class="flex flex-col md:flex-row gap-6">
                            <!-- Product Image -->
                            <div class="flex-shrink-0">
                                <img src="<?php echo htmlspecialchars($row['anh_sp']); ?>" 
                                     alt="<?php echo htmlspecialchars($row['ten_sp']); ?>"
                                     class="w-32 h-32 md:w-40 md:h-40 object-cover rounded-lg shadow-md">
                            </div>
                            
                            <!-- Product Info -->
                            <div class="flex-grow">
                                <h3 class="text-lg font-bold text-gray-800 mb-2">
                                    <?php echo htmlspecialchars($row['ten_sp']); ?>
                                </h3>
                                
                                <div class="space-y-3 mb-4">
                                    <div class="flex items-center">
                                        <span class="text-gray-600 font-medium w-24">Giá:</span>
                                        <span class="product-price text-xl font-bold text-blue-600" data-price="<?php echo $row['gia_sp'] ?>">
                                            <?php echo number_format($row['gia_sp'], 0, ',', '.') ?>₫
                                        </span>
                                    </div>
                                    
                                    <div class="flex items-center flex-wrap gap-2">
                                        <span class="text-gray-600 font-medium w-24">Số lượng:</span>
                                        <div class="flex items-center border border-gray-300 rounded-lg overflow-hidden">
                                            <button type="button" class="decrement px-4 py-2 bg-gray-100 hover:bg-gray-200 transition-colors duration-200 font-bold text-gray-700">
                                                -
                                            </button>
                                            <input type="number" 
                                                   name="sl[<?php echo $row['id_sp'] ?>]" 
                                                   value="<?php echo $_SESSION['giohang'][$row['id_sp']] ?>" 
                                                   class="quantity-input w-16 text-center border-x border-gray-300 py-2 focus:outline-none focus:ring-2 focus:ring-pink-500" 
                                                   min="0" 
                                                   data-max="<?php echo $row['so_luong'] ?>" />
                                            <button type="button" class="increment px-4 py-2 bg-gray-100 hover:bg-gray-200 transition-colors duration-200 font-bold text-gray-700">
                                                +
                                            </button>
                                        </div>
                                        <?php if ($row['so_luong'] > 0): ?>
                                            <span class="text-sm text-gray-500 ml-2">
                                                (<?php echo $row['so_luong'] ?> sản phẩm có sẵn)
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                
                                <a href="chucnang/giohang/xoahang.php?id_sp=<?php echo $row['id_sp'] ?>" 
                                   class="delete-item inline-flex items-center text-red-600 hover:text-red-700 transition-colors duration-200">
                                    <i class="fa-solid fa-trash mr-2"></i>
                                    <span>Xóa sản phẩm</span>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
                <input type="hidden" name="update_cart" value="1" />
            </form>

            <!-- Cart Summary -->
            <div class="mt-8 bg-gradient-to-r from-pink-50 to-purple-50 rounded-lg p-6 shadow-md">
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                    <div>
                        <p class="text-lg font-semibold text-gray-700">
                            Tổng giá trị giỏ hàng:
                            <span id="total-price" class="text-2xl font-bold text-blue-600 ml-2">
                                <?php echo number_format($totalPriceAll, 0, ',', '.') ?>₫
                            </span>
                        </p>
                    </div>
                    <div class="flex flex-wrap gap-3">
                        <a href="index.php" 
                           class="px-6 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg font-semibold transition-colors duration-200">
                            Thêm sản phẩm
                        </a>
                        <a href="chucnang/giohang/xoahang.php?id_sp=0" 
                           class="px-6 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg font-semibold transition-colors duration-200">
                            Xóa hết sản phẩm
                        </a>
                        <a href="index.php?page_layout=muahang" 
                           class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-semibold transition-colors duration-200 shadow-lg">
                            Thanh toán
                        </a>
                    </div>
                </div>
            </div>
    <?php
        } else {
            echo '
            <div class="flex flex-col items-center justify-center py-16 px-4">
                <a href="index.php" class="mb-6 text-blue-600 hover:text-blue-700 font-semibold transition-colors duration-200">
                    ← Quay lại trang chủ
                </a>
                <img src="anh/empty-cart.png" alt="Giỏ hàng trống" class="max-w-xs mb-6">
                <p class="text-xl text-gray-600 font-semibold">Giỏ hàng trống</p>
            </div>';
        }
    } else {
        echo '
        <div class="flex flex-col items-center justify-center py-16 px-4">
            <a href="index.php" class="mb-6 text-blue-600 hover:text-blue-700 font-semibold transition-colors duration-200">
                ← Quay lại trang chủ
            </a>
            <img src="anh/empty-cart.png" alt="Giỏ hàng trống" class="max-w-xs mb-6">
            <p class="text-xl text-gray-600 font-semibold">Giỏ hàng trống</p>
        </div>';
    }
    ?>
</div>

<script>
    function formatCurrency(value) {
        return value.toLocaleString('vi-VN', {
            style: 'currency',
            currency: 'VND'
        });
    }

    document.querySelectorAll('.increment').forEach(button => {
        button.addEventListener('click', function() {
            let input = this.previousElementSibling;
            let maxQuantity = parseInt(input.dataset.max);
            let currentQuantity = parseInt(input.value);

            if (currentQuantity < maxQuantity) {
                input.value = currentQuantity + 1;
                document.getElementById('giohang').submit(); // Gửi form để cập nhật giỏ hàng
            } else {
                alert('Số lượng bạn chọn đã đạt mức tối đa của sản phẩm này.');
            }
        });
    });

    document.querySelectorAll('.decrement').forEach(button => {
        button.addEventListener('click', function() {
            let input = this.nextElementSibling;
            let quantity = parseInt(input.value);
            if (quantity > 0) {
                quantity--;
                input.value = quantity;
                if (quantity === 0) {
                    confirmDeletion(input);
                } else {
                    document.getElementById('giohang').submit(); // Gửi form để cập nhật giỏ hàng
                }
            }
        });
    });

    function confirmDeletion(input) {
        const productCard = input.closest('.bg-white');
        const productName = productCard.querySelector('h3').textContent.trim();
        if (confirm(`Bạn chắc chắn muốn bỏ sản phẩm này?\n\n${productName}`)) {
            document.getElementById('giohang').submit();
        } else {
            input.value = 1;
        }
    }

    function updateTotalPrice() {
        let totalPrice = 0;
        document.querySelectorAll('.quantity-input').forEach(input => {
            const productCard = input.closest('.bg-white');
            const price = parseFloat(productCard.querySelector('.product-price').dataset.price);
            const quantity = parseInt(input.value) || 0;
            totalPrice += price * quantity;
        });

        const totalPriceElement = document.getElementById('total-price');
        if (totalPriceElement) {
            totalPriceElement.textContent = formatCurrency(totalPrice);
        }
    }

    // Xử lý sự kiện click trên các liên kết xóa sản phẩm
    document.querySelectorAll('.delete-item').forEach(function(deleteLink) {
        deleteLink.addEventListener('click', function(event) {
            event.preventDefault();
            const productCard = this.closest('.bg-white');
            const productName = productCard.querySelector('h3').textContent.trim();
            const deleteUrl = this.href;

            if (confirm(`Bạn có chắc chắn muốn xóa sản phẩm "${productName}" khỏi giỏ hàng không?`)) {
                window.location.href = deleteUrl;
            }
        });
    });

    // Xử lý sự kiện click trên liên kết "Xóa hết sản phẩm"
    const clearAllLink = document.querySelector('a[href*="xoahang.php?id_sp=0"]');
    if (clearAllLink) {
        clearAllLink.addEventListener('click', function(event) {
            event.preventDefault();
            if (confirm('Bạn có chắc chắn muốn xóa tất cả sản phẩm khỏi giỏ hàng không?')) {
                window.location.href = this.href;
            }
        });
    }


    // Cập nhật giá trị tổng khi trang được tải
    document.addEventListener('DOMContentLoaded', updateTotalPrice);
</script>