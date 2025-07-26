
  document.addEventListener("DOMContentLoaded", () => {
    const dropdown = document.querySelector(".nav-item.dropdown");
    const menu = dropdown.querySelector(".mega-menu");

    let timeout;

    dropdown.addEventListener("mouseenter", () => {
      clearTimeout(timeout);
      menu.style.opacity = "1";
      menu.style.visibility = "visible";
      menu.style.pointerEvents = "auto";
    });

    dropdown.addEventListener("mouseleave", () => {
      timeout = setTimeout(() => {
        menu.style.opacity = "0";
        menu.style.visibility = "hidden";
        menu.style.pointerEvents = "none";
      }, 200); // delay 200ms
    });
 
    



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
console.log("Total allProducts:", allProducts.length);
console.log("Total filtered:", filtered.length);
console.log("Visible count:", visibleCount);
console.log("Filtered Products:", filtered.map(p => p.name));

  const visibleItems = filtered.slice(0, visibleCount);

  for (const product of visibleItems) {
    const col = document.createElement('div');
    col.className = 'col-6 col-sm-6 col-md-3';

    // Gunakan gambar dari mapping manual, atau fallback default
    const imgSrc = product.image || 'images/default.jpg';

    col.innerHTML = `
      <a href="${product.url}" class="text-decoration-none text-dark">
        <div class="product-card" style="shadow-sm; padding: 16px; border-radius: 8px;">
          <img 
            src="${imgSrc}" 
            alt="${product.name}" 
            class="product-img"
            onerror="this.onerror=null;this.src='images/default.jpg';"
          />
          <p class="product-title">${product.name}</p>
          <div class="price">Harga mulai dari ${product.price}</div>
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

