
  document.addEventListener('DOMContentLoaded', function () {
    const produkToggle = document.getElementById('produkDropdown');
    const megaMenu = produkToggle?.nextElementSibling;
    const isTouchDevice = !window.matchMedia('(hover: hover)').matches;

    if (isTouchDevice && produkToggle && megaMenu) {
      let isOpen = false;

      produkToggle.addEventListener('click', function (e) {
        e.preventDefault();
        isOpen = !isOpen;
        megaMenu.classList.toggle('d-none', !isOpen);
      });

      document.addEventListener('click', function (e) {
        if (!produkToggle.contains(e.target) && !megaMenu.contains(e.target)) {
          isOpen = false;
          megaMenu.classList.add('d-none');
        }
      });
    }



  // Toggle submenu "Layanan"
  function toggleSubmenu() {
    const submenu = document.getElementById('submenu');
    submenu.classList.toggle('d-none');
  }



  // --- Produk Filter ---
  const allProducts = window.products || [];

let currentCategory = 'all';
let visibleCount = 8;


function renderProducts() {
  const grid = document.getElementById('productGrid');
  const searchValue = document.getElementById('searchInput')?.value.toLowerCase() || '';
  if (!grid) return;

  grid.innerHTML = '';

  const filtered = allProducts.filter(p =>
    (currentCategory === 'all' || p.category === currentCategory) &&
    p.name.toLowerCase().includes(searchValue)
  );

  const visibleItems = filtered.slice(0, visibleCount);

  for (const product of visibleItems) {
    const col = document.createElement('div');
    col.className = 'col-6 col-sm-6 col-md-3';

    // Gunakan gambar dari mapping manual, atau fallback default
    const imgSrc = product.image || 'images/default.jpg';

    col.innerHTML = `
      <a href="${product.url}" class="text-decoration-none text-dark">
        <div class="product-card" style="border: 1px solid #ddd; padding: 16px; border-radius: 5px;">
          <img 
            src="${imgSrc}" 
            alt="${product.name}" 
            style="width: 100%; height: 180px; object-fit: cover; border-radius: 5px;"
            onerror="this.onerror=null;this.src='images/default.jpg';"
          />
          <p class="product-title">${product.name}</p>
          <div class="price">Harga dari ${product.price}</div>
        </div>
      </a>
    `;
    grid.appendChild(col);
  }
}

const searchInput = document.getElementById('searchInput');
if (searchInput) {
  searchInput.addEventListener('input', renderProducts);
}

window.filterCategory = function (category, btn) {
  currentCategory = category;
  visibleCount = 8;
  document.querySelectorAll('.filter-buttons .btn').forEach(b => b.classList.remove('active'));
  btn.classList.add('active');
  renderProducts();
};

window.loadMore = function () {
  visibleCount += 4;
  renderProducts();
};

renderProducts();


  // --- AOS ---
  AOS.init({
    duration: 1000,
    once: true
  });

  // --- Animasi "Kenapa Kami" ---
  const animateElements = document.querySelectorAll("[data-animate]");
  const animateOnScroll = () => {
    animateElements.forEach((el) => {
      const rect = el.getBoundingClientRect();
      if (rect.top < window.innerHeight - 100) {
        el.classList.add("show");
      }
    });
  };
  window.addEventListener("scroll", animateOnScroll);
  animateOnScroll();

  // --- Animasi Portofolio ---
  const images = document.querySelectorAll('.portfolio-img');
  const animateImages = () => {
    images.forEach(img => {
      const rect = img.getBoundingClientRect();
      if (rect.top < window.innerHeight - 50) {
        img.classList.add('show');
      }
    });
  };
  window.addEventListener('scroll', animateImages);
  animateImages();

  // --- Swiper ---
  const swiper = new Swiper(".testimoni-swiper", {
    loop: true,
    autoplay: {
      delay: 4000,
      disableOnInteraction: false,
    },
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
    },
  });
});

