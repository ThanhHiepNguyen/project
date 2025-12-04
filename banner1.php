<section class="relative w-full overflow-hidden">
    <div class="slider-content relative w-full h-96 md:h-[500px] lg:h-[600px]">
        <img src="anh/slide01.png" alt="Phụ tùng xe chính hãng" class="slider-image absolute inset-0 w-full h-full object-cover opacity-0 transition-opacity duration-1000" />
        <img src="anh/slide02.png" alt="Bộ sưu tập phụ tùng mới" class="slider-image absolute inset-0 w-full h-full object-cover opacity-0 transition-opacity duration-1000" />
        <img src="anh/slide03.png" alt="Khuyến mãi đặc biệt" class="slider-image absolute inset-0 w-full h-full object-cover opacity-0 transition-opacity duration-1000" />
        <img src="anh/slide04.png" alt="Khuyến mãi đặc biệt" class="slider-image absolute inset-0 w-full h-full object-cover opacity-0 transition-opacity duration-1000" />
        <img src="anh/slide05.png" alt="Khuyến mãi đặc biệt" class="slider-image absolute inset-0 w-full h-full object-cover opacity-0 transition-opacity duration-1000" />
        <img src="anh/slide06.png" alt="Khuyến mãi đặc biệt" class="slider-image absolute inset-0 w-full h-full object-cover opacity-0 transition-opacity duration-1000" />
        
        <!-- Overlay gradient -->
        <div class="absolute inset-0 bg-gradient-to-r from-black/30 to-transparent"></div>
        
        <!-- Navigation arrows -->
        <button onclick="prevSlide()" class="absolute left-4 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white text-gray-800 p-3 rounded-full shadow-lg transition-all duration-200 hover:scale-110 z-10">
            <i class="fa-solid fa-chevron-left text-xl"></i>
        </button>
        <button onclick="nextSlide()" class="absolute right-4 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white text-gray-800 p-3 rounded-full shadow-lg transition-all duration-200 hover:scale-110 z-10">
            <i class="fa-solid fa-chevron-right text-xl"></i>
        </button>
        
        <!-- Dots indicator -->
        <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex space-x-2 z-10">
            <button onclick="goToSlide(0)" class="slider-dot w-3 h-3 rounded-full bg-white/50 hover:bg-white transition-all duration-200"></button>
            <button onclick="goToSlide(1)" class="slider-dot w-3 h-3 rounded-full bg-white/50 hover:bg-white transition-all duration-200"></button>
            <button onclick="goToSlide(2)" class="slider-dot w-3 h-3 rounded-full bg-white/50 hover:bg-white transition-all duration-200"></button>
            <button onclick="goToSlide(3)" class="slider-dot w-3 h-3 rounded-full bg-white/50 hover:bg-white transition-all duration-200"></button>
            <button onclick="goToSlide(4)" class="slider-dot w-3 h-3 rounded-full bg-white/50 hover:bg-white transition-all duration-200"></button>
            <button onclick="goToSlide(5)" class="slider-dot w-3 h-3 rounded-full bg-white/50 hover:bg-white transition-all duration-200"></button>
        </div>
    </div>
</section>

<script>
    let currentSlide = 0;
    const slides = document.querySelectorAll('.slider-image');
    const dots = document.querySelectorAll('.slider-dot');
    const totalSlides = slides.length;

    function showSlide(index) {
        // Hide all slides
        slides.forEach(slide => {
            slide.classList.remove('opacity-100');
            slide.classList.add('opacity-0');
        });
        
        // Show current slide
        if (slides[index]) {
            slides[index].classList.remove('opacity-0');
            slides[index].classList.add('opacity-100');
        }
        
        // Update dots
        dots.forEach((dot, i) => {
            if (i === index) {
                dot.classList.remove('bg-white/50');
                dot.classList.add('bg-white', 'w-8');
            } else {
                dot.classList.remove('bg-white', 'w-8');
                dot.classList.add('bg-white/50');
            }
        });
    }

    function nextSlide() {
        currentSlide = (currentSlide + 1) % totalSlides;
        showSlide(currentSlide);
    }

    function prevSlide() {
        currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
        showSlide(currentSlide);
    }

    function goToSlide(index) {
        currentSlide = index;
        showSlide(currentSlide);
    }

    // Auto play
    let autoPlayInterval = setInterval(nextSlide, 3000);

    // Pause on hover
    const slider = document.querySelector('.slider-content');
    slider.addEventListener('mouseenter', () => clearInterval(autoPlayInterval));
    slider.addEventListener('mouseleave', () => {
        autoPlayInterval = setInterval(nextSlide, 3000);
    });

    // Initialize
    showSlide(0);
</script>