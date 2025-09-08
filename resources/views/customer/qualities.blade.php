<div class="max-w-7xl mx-auto px-4">
  <!-- Product Grid -->
  <div id="product-grid" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6 mb-6">
    <!-- Products will be injected here -->
  </div>

  <!-- Pagination Controls -->
  <div id="pagination" class="flex justify-center space-x-2 mt-6"></div>
</div>

<script>
  // Sample products (you can add as many as you want)
const products = [
  { name: "🌹 Roses", price: 25, image: "https://images.pexels.com/photos/102104/pexels-photo-102104.jpeg" },
  { name: "🌷 Tulips", price: 15, image: "https://images.pexels.com/photos/36764/marguerite-daisy-beautiful-beauty.jpg" },
  { name: "🌻 Lilies", price: 18, image: "https://images.pexels.com/photos/46216/sunflower-flowers-bright-yellow-46216.jpeg" },
  { name: "🌸 Orchids", price: 30, image: "https://images.pexels.com/photos/736230/pexels-photo-736230.jpeg" },
  { name: "🌼 Daisies", price: 12, image: "https://images.pexels.com/photos/459335/pexels-photo-459335.jpeg" },
  { name: "🌺 Hibiscus", price: 22, image: "https://images.pexels.com/photos/102104/pexels-photo-102104.jpeg" },
  { name: "🌷 Mixed Tulips", price: 20, image: "https://images.pexels.com/photos/36764/marguerite-daisy-beautiful-beauty.jpg" },
  { name: "🌻 Sunflowers", price: 28, image: "https://images.pexels.com/photos/46216/sunflower-flowers-bright-yellow-46216.jpeg" },

  // More flowers
  { name: "💐 Peonies", price: 26, image: "https://images.pexels.com/photos/36764/marguerite-daisy-beautiful-beauty.jpg" },
  { name: "🌹 Red Roses", price: 32, image: "https://images.pexels.com/photos/102104/pexels-photo-102104.jpeg" },
  { name: "🌸 Cherry Blossoms", price: 40, image: "https://images.pexels.com/photos/736230/pexels-photo-736230.jpeg" },
  { name: "🌼 Marigolds", price: 14, image: "https://images.pexels.com/photos/459335/pexels-photo-459335.jpeg" },
  { name: "🌺 Camellias", price: 24, image: "https://images.pexels.com/photos/102104/pexels-photo-102104.jpeg" },
  { name: "🌷 Yellow Tulips", price: 17, image: "https://images.pexels.com/photos/36764/marguerite-daisy-beautiful-beauty.jpg" },
  { name: "🌻 Sunflower Bouquet", price: 35, image: "https://images.pexels.com/photos/46216/sunflower-flowers-bright-yellow-46216.jpeg" },
  { name: "🌸 Exotic Orchids", price: 38, image: "https://images.pexels.com/photos/736230/pexels-photo-736230.jpeg" },

  // Continue filling
  { name: "🌼 Garden Daisies", price: 16, image: "https://images.pexels.com/photos/459335/pexels-photo-459335.jpeg" },
  { name: "🌺 Azaleas", price: 23, image: "https://images.pexels.com/photos/102104/pexels-photo-102104.jpeg" },
  { name: "🌷 Pink Tulips", price: 18, image: "https://images.pexels.com/photos/36764/marguerite-daisy-beautiful-beauty.jpg" },
  { name: "🌻 Golden Sunflowers", price: 29, image: "https://images.pexels.com/photos/46216/sunflower-flowers-bright-yellow-46216.jpeg" },
  { name: "🌹 White Roses", price: 27, image: "https://images.pexels.com/photos/102104/pexels-photo-102104.jpeg" },
  { name: "🌸 Wild Orchids", price: 34, image: "https://images.pexels.com/photos/736230/pexels-photo-736230.jpeg" },
  { name: "🌼 Chrysanthemums", price: 19, image: "https://images.pexels.com/photos/459335/pexels-photo-459335.jpeg" },
  { name: "🌺 Gardenias", price: 21, image: "https://images.pexels.com/photos/102104/pexels-photo-102104.jpeg" },

  // More unique ones
  { name: "🌷 White Tulips", price: 16, image: "https://images.pexels.com/photos/36764/marguerite-daisy-beautiful-beauty.jpg" },
  { name: "🌻 Bright Sunflowers", price: 31, image: "https://images.pexels.com/photos/46216/sunflower-flowers-bright-yellow-46216.jpeg" },
  { name: "🌹 Pink Roses", price: 33, image: "https://images.pexels.com/photos/102104/pexels-photo-102104.jpeg" },
  { name: "🌸 Orchid Mix", price: 36, image: "https://images.pexels.com/photos/736230/pexels-photo-736230.jpeg" },
  { name: "🌼 Wildflowers", price: 13, image: "https://images.pexels.com/photos/459335/pexels-photo-459335.jpeg" },
  { name: "🌺 Tropical Hibiscus", price: 25, image: "https://images.pexels.com/photos/102104/pexels-photo-102104.jpeg" },
  { name: "💐 Mixed Peonies", price: 28, image: "https://images.pexels.com/photos/36764/marguerite-daisy-beautiful-beauty.jpg" },
  { name: "🌻 Mini Sunflowers", price: 20, image: "https://images.pexels.com/photos/46216/sunflower-flowers-bright-yellow-46216.jpeg" },

  // Fill up to 40
  { name: "🌹 Rose Bouquet", price: 45, image: "https://images.pexels.com/photos/102104/pexels-photo-102104.jpeg" },
  { name: "🌸 Rare Orchid", price: 50, image: "https://images.pexels.com/photos/736230/pexels-photo-736230.jpeg" },
  { name: "🌼 Seasonal Daisies", price: 19, image: "https://images.pexels.com/photos/459335/pexels-photo-459335.jpeg" },
  { name: "🌺 Desert Rose", price: 37, image: "https://images.pexels.com/photos/102104/pexels-photo-102104.jpeg" },
  { name: "🌷 Spring Tulips", price: 22, image: "https://images.pexels.com/photos/36764/marguerite-daisy-beautiful-beauty.jpg" },
  { name: "🌻 Tall Sunflowers", price: 30, image: "https://images.pexels.com/photos/46216/sunflower-flowers-bright-yellow-46216.jpeg" },
  { name: "🌹 Golden Roses", price: 42, image: "https://images.pexels.com/photos/102104/pexels-photo-102104.jpeg" },
  { name: "🌸 Orchid Deluxe", price: 55, image: "https://images.pexels.com/photos/736230/pexels-photo-736230.jpeg" }
];


  const perPage = 25; // Products per page
  let currentPage = 1;

  function renderProducts(page) {
    const grid = document.getElementById("product-grid");
    grid.innerHTML = "";

    const start = (page - 1) * perPage;
    const end = start + perPage;
    const pageProducts = products.slice(start, end);

    pageProducts.forEach(p => {
      const card = `
        <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition transform hover:-translate-y-1">
          <img src="${p.image}" alt="${p.name}" class="h-48 w-full object-cover rounded-t-xl">
          <div class="p-4 flex flex-col items-center">
            <h5 class="text-lg font-semibold text-gray-800">${p.name}</h5>
            <p class="text-pink-600 font-bold mb-3">$${p.price}</p>
            <button class="px-4 py-2 bg-pink-500 text-white rounded-full shadow hover:bg-pink-600 focus:ring-2 focus:ring-pink-400 transition">
              Add to Cart
            </button>
          </div>
        </div>
      `;
      grid.innerHTML += card;
    });
  }

  function renderPagination() {
    const pagination = document.getElementById("pagination");
    pagination.innerHTML = "";

    const totalPages = Math.ceil(products.length / perPage);

    for (let i = 1; i <= totalPages; i++) {
      const btn = document.createElement("button");
      btn.innerText = i;
      btn.className =
        "px-4 py-2 rounded-lg " +
        (i === currentPage
          ? "bg-pink-500 text-white"
          : "bg-gray-200 text-gray-700 hover:bg-gray-300");
      btn.addEventListener("click", () => {
        currentPage = i;
        renderProducts(currentPage);
        renderPagination();
      });
      pagination.appendChild(btn);
    }
  }

  // Initial Render
  renderProducts(currentPage);
  renderPagination();
</script>
