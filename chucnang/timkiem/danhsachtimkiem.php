<div class="mb-12">
    <?php
    if(isset($_POST['stext'])){
        $stext = $_POST['stext'];
    }else{
        $stext = '';
    }
    $newStext = str_replace(' ', '%', $stext);
    $sql = "SELECT * FROM sanpham WHERE ten_sp LIKE '%$newStext%'";
    $query = mysqli_query($conn, $sql);
    ?>
    <div class="text-center mb-8">
        <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">
            Kết quả tìm được với từ khóa 
            <span class="text-blue-600">"<?php echo htmlspecialchars($stext); ?>"</span>
        </h2>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        <?php
        while($row = mysqli_fetch_array($query)){
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
        <?php
        }
        ?>
    </div>
</div>

