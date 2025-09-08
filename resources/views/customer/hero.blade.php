
<div class="relative w-full  overflow-hidden rounded-2xl shadow mb-6">
    <!-- Slider Wrapper -->
    <div class="flex transition-transform duration-700 ease-in-out" id="promoSlider">
        <!-- Slide 1 -->
        <div class="relative w-full flex-shrink-0">
            <img src="https://images.pexels.com/photos/1458282/pexels-photo-1458282.jpeg"
                 alt="Hot Deal Roses"
                 class="w-full h-[400px] object-cover">
            <div class="absolute inset-0 bg-gradient-to-r from-black/60 to-transparent flex items-center">
                <div class="px-8 text-white">
                    <h2 class="text-3xl md:text-4xl font-bold mb-2">Hot Deal of the Week 🌹</h2>
                    <p class="mb-4">20% Off All Roses – Freshly Picked!</p>
                    <a href="{{ route('customer.shop') }}"
                       class="px-6 py-2 bg-pink-600 rounded-lg shadow hover:bg-pink-700 transition">
                        Shop Now
                    </a>
                </div>
            </div>
        </div>

        <!-- Slide 2 -->
        <div class="relative w-full flex-shrink-0">
            <img src="https://images.pexels.com/photos/931162/pexels-photo-931162.jpeg"
                 alt="Tulip Promo"
                 class="w-full h-[400px] object-cover">
            <div class="absolute inset-0 bg-gradient-to-r from-black/60 to-transparent flex items-center">
                <div class="px-8 text-white">
                    <h2 class="text-3xl md:text-4xl font-bold mb-2">Spring Tulip Sale 🌷</h2>
                    <p class="mb-4">Brighten your home with Tulips at just $15</p>
                    <a href="{{ route('customer.shop') }}"
                       class="px-6 py-2 bg-pink-600 rounded-lg shadow hover:bg-pink-700 transition">
                        Shop Now
                    </a>
                </div>
            </div>
        </div>

        <!-- Slide 3 -->
        <div class="relative w-full flex-shrink-0">
            <img src="https://images.pexels.com/photos/459335/pexels-photo-459335.jpeg"
                 alt="Orchid Deal"
                 class="w-full h-[400px] object-cover">
            <div class="absolute inset-0 bg-gradient-to-r from-black/60 to-transparent flex items-center">
                <div class="px-8 text-white">
                    <h2 class="text-3xl md:text-4xl font-bold mb-2">Exotic Orchids 🌸</h2>
                    <p class="mb-4">Orchids from $30 – Limited Stock!</p>
                    <a href="{{ route('customer.shop') }}"
                       class="px-6 py-2 bg-pink-600 rounded-lg shadow hover:bg-pink-700 transition">
                        Shop Now
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation Arrows -->
    <button id="prevSlide"
            class="absolute top-1/2 left-4 -translate-y-1/2 bg-black/50 text-white p-2 rounded-full hover:bg-black/70">
        ◀
    </button>
    <button id="nextSlide"
            class="absolute top-1/2 right-4 -translate-y-1/2 bg-black/50 text-white p-2 rounded-full hover:bg-black/70">
        ▶
    </button>

    <!-- Pagination Dots -->
    <div class="absolute bottom-4 w-full flex justify-center space-x-2">
        <span class="dot w-3 h-3 bg-white rounded-full opacity-70 cursor-pointer"></span>
        <span class="dot w-3 h-3 bg-white rounded-full opacity-40 cursor-pointer"></span>
        <span class="dot w-3 h-3 bg-white rounded-full opacity-40 cursor-pointer"></span>
    </div>
</div>

<script>
    const slider = document.getElementById("promoSlider");
    const slides = slider.children.length;
    let index = 0;

    const dots = document.querySelectorAll(".dot");

    function updateSlider() {
        slider.style.transform = `translateX(-${index * 100}%)`;
        dots.forEach((dot, i) => {
            dot.classList.toggle("opacity-70", i === index);
            dot.classList.toggle("opacity-40", i !== index);
        });
    }

    document.getElementById("nextSlide").addEventListener("click", () => {
        index = (index + 1) % slides;
        updateSlider();
    });

    document.getElementById("prevSlide").addEventListener("click", () => {
        index = (index - 1 + slides) % slides;
        updateSlider();
    });

    dots.forEach((dot, i) => {
        dot.addEventListener("click", () => {
            index = i;
            updateSlider();
        });
    });
</script>

