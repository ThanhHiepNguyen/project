<div class="relative">
    <a href="index.php?page_layout=giohang" class="relative inline-flex items-center justify-center p-2 border border-gray-300 rounded-lg bg-white hover:bg-blue-50 transition-all duration-200 shadow-sm hover:shadow-md group">
        <i class="fa-solid fa-cart-shopping text-xl text-blue-600 group-hover:text-blue-700"></i>
        <?php
        $cart_count = isset($_SESSION['giohang']) ? count($_SESSION['giohang']) : 0;
        if ($cart_count > 0):
        ?>
            <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center animate-pulse">
                <?php echo $cart_count; ?>
            </span>
        <?php endif; ?>
    </a>
</div> 
