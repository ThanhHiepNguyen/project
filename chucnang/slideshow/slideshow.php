

<script>
    document.addEventListener("DOMContentLoaded", function() {
    let images = document.querySelectorAll("#slideshow img");
    let currentIndex = 0;

    images[currentIndex].classList.add("active");

    setInterval(function() {
        images[currentIndex].classList.remove("active");
        currentIndex = (currentIndex + 1) % images.length;
        images[currentIndex].classList.add("active");
    }, 3000);
});

</script>

<style>
    #slideshow {
    position: relative;
    width: 100%;
    height: auto;
    overflow: hidden;
}

#slideshow img {
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
    height: auto;
    opacity: 0;
    transition: opacity 1s ease-in-out;
}

#slideshow img.active {
    opacity: 1;
}
</style>

<div id="slideshow">
	<img src="anh/slide1.png" alt="Slideshow Image 1" />
    <img src="anh/slide2.png" alt="Slideshow Image 2" />
    <img src="anh/slide3.png" alt="Slideshow Image 3" />
    <img src="anh/slide4.png" alt="Slideshow Image 3" />
    <img src="anh/slide5.png" alt="Slideshow Image 3" />
    <img src="anh/slide6.png" alt="Slideshow Image 3" />
</div>