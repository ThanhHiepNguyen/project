<form method="post" name="sform" action="index.php?page_layout=danhsachtimkiem" class="flex items-center">
    <div class="relative flex items-center">
        <input type="text" 
               name="stext" 
               placeholder="Tìm kiếm phụ tùng xe..." 
               class="pl-10 pr-4 py-2 w-full sm:w-64 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 text-sm">
        <button name="sbutton" 
                type="submit" 
                value="" 
                class="absolute left-2 text-blue-600 hover:text-blue-700 transition-colors duration-200"
               title="Tìm kiếm phụ tùng xe">
            <i class="fa-solid fa-magnifying-glass text-lg"></i>
        </button>
    </div>
</form>