<div class="mb-12">
    <div class="text-center mb-8">
        <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4 relative inline-block">
            <span class="relative z-10 bg-gray-50 px-4"><?php echo htmlspecialchars($_GET['ten_dm']); ?></span>
            <span class="absolute left-0 right-0 top-1/2 h-0.5 bg-gradient-to-r from-transparent via-blue-500 to-transparent"></span>
        </h2>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
    <?php
        $sql="SELECT * FROM sanpham ORDER BY id_sp DESC";
        $query=mysqli_query($conn, $sql);
    ?>
    <?php
        $id_dm = $_GET['id_dm'];
        //Số bản ghi trên trang
        $rowPerPage = 8;
        //Số trang
        if(isset($_GET['page'])){
            $page = $_GET['page'];
        }else{
            $page = 1;
        }
        //Vị trí
        $perRow = $page*$rowPerPage-$rowPerPage;
        $sql = "SELECT * FROM sanpham WHERE id_dm = $id_dm LIMIT $perRow,$rowPerPage";
        $query = mysqli_query($conn, $sql);
        //Tổng số bản ghi
        $totalRow = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM sanpham WHERE id_dm = $id_dm"));
        //Tổng số trang
        $totalPage = Ceil($totalRow/$rowPerPage);
        $listPage = '';
        //Nút trang trước và trang đầu
        if($page>1){
            $listPage .= '<a href="index.php?page_layout=danhsachsp&id_dm='.$id_dm.'&ten_dm='.$ten_dm.'&page=1"> First </a>';
            $prev = $page-1;
            $listPage .= '<a href="index.php?page_layout=danhsachsp&id_dm='.$id_dm.'&ten_dm='.$ten_dm.'&page='.$prev.'"> << </a>';
        }
        //Các phím số
        for($i=1;$i<=$totalPage;$i++){
            if($i==$page){
                $listPage .=  '<span> '.$i.' </span>';
            }else{
                $listPage .= '<a href="index.php?page_layout=danhsachsp&id_dm='.$id_dm.'&ten_dm='.$ten_dm.'&page='.$i.'"> '.$i.' </a>';
            }
        }
        //Nút trang sau và trang cuối
        if($page<$totalPage){
            $next = $page+1;
            $listPage .= '<a href="index.php?page_layout=danhsachsp&id_dm='.$id_dm.'&ten_dm='.$ten_dm.'&page='.$next.'"> >> </a>';
            $listPage .= '<a href="index.php?page_layout=danhsachsp&id_dm='.$id_dm.'&ten_dm='.$ten_dm.'&page='.$totalPage.'"> Last </a>';
           
        }
        while($row = mysqli_fetch_array($query)){
    ?>
            <div class="group relative bg-white rounded-lg shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden transform hover:-translate-y-2">
                <a href="index.php?page_layout=chitietsp&id_sp=<?php echo $row['id_sp'] ?>" class="block">
                    <div class="relative overflow-hidden bg-gray-100 aspect-square">
                        <img src="quantri/anh/<?php echo $row['anh_sp'] ?>" 
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

<div class="flex justify-center items-center space-x-2 mt-8 mb-8">
    <?php echo $listPage; ?>
</div>

<style>
    #pagination a, #pagination span {
        display: inline-block;
        padding: 8px 16px;
        margin: 0 4px;
        border: 1px solid #ddd;
        border-radius: 6px;
        text-decoration: none;
        color: #333;
        transition: all 0.2s;
    }
    #pagination a:hover {
        background-color: #f3f4f6;
        border-color: #9ca3af;
    }
    #pagination span {
        background-color: #f3f4f6;
        color: #6b7280;
        border-color: #d1d5db;
    }
</style>
