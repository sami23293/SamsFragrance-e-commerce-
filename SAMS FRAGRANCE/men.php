<?php 
 $conn = new mysqli("localhost", "root", "", "sams");
   if ($conn->connect_error) {
     die("Connection failed: " . $conn->connect_error);
   }
   ?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Shop - Men's Colognes</title>

   <link rel="stylesheet"
         href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&display=swap">
   <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600&display=swap" rel="stylesheet">
   <link rel="stylesheet" href="style.css">

   <style>
.search-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  backdrop-filter: blur(3px); 
  background-color: rgba(0, 0, 0, 0.2); 
  display: none;
  justify-content: flex-start; 
  align-items: flex-start;
  padding-top: 160px; 
  z-index: 999;
}

.search-box {
  background: white;
  padding: 15px;
  border-radius: 8px;
  display: flex;
  align-items: center;
  gap: 10px;
  margin: 0 auto; 
  width: 90%;
  max-width: 600px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.search-box input {
  flex: 1;
  padding: 10px;
  font-size: 15px;
  border: 1px solid #ccc;
  border-radius: 6px;
}

#close-search {
  background: transparent;
  border: none;
  font-size: 20px;
  cursor: pointer;
}

.search-results {
  margin: 20px auto;
  width: 90%;
  max-width: 600px;
  background: white;
  border-radius: 8px;
  padding: 10px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}
.product-carousel {
  max-width: 1100px;
  margin: 0 auto 40px auto;
  overflow: hidden;
  position: relative;
  background: #fffbe9;
  border-radius: 18px;
  box-shadow: 0 8px 32px rgba(191,161,108,0.10);
  padding: 32px 0 38px 0;
}
.carousel-track {
  display: flex;
  transition: transform 0.6s cubic-bezier(.4,0,.2,1);
  will-change: transform;
}
.product {
  min-width: 250px;
  max-width: 250px;
  margin: 0 18px;
  flex-shrink: 0;
  box-sizing: border-box;
  background: #fff;
  border-radius: 14px;
  box-shadow: 0 4px 18px rgba(191,161,108,0.08);
  padding: 18px 12px 20px 12px;
  display: flex;
  flex-direction: column;
  align-items: center;
  transition: box-shadow 0.2s, transform 0.2s;
}
.product:hover {
  box-shadow: 0 8px 32px rgba(191,161,108,0.18);
  transform: translateY(-6px) scale(1.03);
}

.product p {
  font-family: 'Montserrat', sans-serif;
  font-weight: 600;
  font-size: 17px;
  color: #222;
  margin: 10px 0 4px 0;
  text-align: center;
}
.product h3 {
  font-family: 'Playfair Display', serif;
  font-size: 16px;
  color: #bfa16c;
  margin: 0 0 10px 0;
  letter-spacing: 0.5px;
  text-align: center;
}
.details-button {
  margin-top: auto;
  background: linear-gradient(90deg, #bfa16c 60%, #e2c98f 100%);
  color: #fff;
  border: none;
  border-radius: 7px;
  padding: 8px 18px;
  font-weight: 600;
  font-size: 15px;
  cursor: pointer;
  transition: background 0.2s, box-shadow 0.2s;
  box-shadow: 0 2px 8px rgba(191,161,108,0.08);
  text-decoration: none;
  display: inline-block;
}
.details-button:hover {
  background: linear-gradient(90deg, #a88b4a 60%, #bfa16c 100%);
  color: #fff;
  box-shadow: 0 6px 24px rgba(191,161,108,0.13);
}
.carousel-arrow {
  background: #fff;
  border: 1.5px solid #bfa16c;
  color: #bfa16c;
  font-size: 28px;
  border-radius: 50%;
  width: 44px;
  height: 44px;
  cursor: pointer;
  transition: background 0.2s, color 0.2s, box-shadow 0.2s;
  z-index: 2;
  flex-shrink: 0;
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  box-shadow: 0 2px 8px rgba(191,161,108,0.10);
}
.carousel-arrow.left { left: 10px; }
.carousel-arrow.right { right: 10px; }
.carousel-arrow:hover {
  background: #bfa16c;
  color: #fff;
  box-shadow: 0 6px 24px rgba(191,161,108,0.13);
}
.hero-men {
  position: relative;
  min-height: 340px;
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
  border-radius: 18px;
  margin: 36px auto 48px auto;
  max-width: 1100px;
  box-shadow: 0 8px 32px rgba(30,30,60,0.18);
}

.hero-men-bg {
  position: absolute;
  inset: 0;
  background: 
    linear-gradient(120deg, rgba(24,27,34,0.92) 60%, rgba(40,44,54,0.85) 100%),
    url('https://images.unsplash.com/photo-1517841905240-472988babdf9?auto=format&fit=crop&w=1100&q=80') center/cover no-repeat;
  z-index: 1;
  filter: brightness(0.95) blur(0.5px);
}

.hero-men-content {
  position: relative;
  z-index: 2;
  text-align: center;
  color: #fff;
  padding: 36px 24px;
}

.hero-men-content h2 {
  font-family: 'Playfair Display', serif;
  font-size: 2.5rem;
  font-weight: 700;
  letter-spacing: 1.5px;
  margin-bottom: 18px;
  color: #ffd700;
  text-shadow: 0 4px 24px rgba(0,0,0,0.18);
}

.hero-men-content p {
  font-family: 'Montserrat', sans-serif;
  font-size: 1.25rem;
  color: #f5f5f7;
  margin-bottom: 28px;
  text-shadow: 0 2px 8px rgba(0,0,0,0.12);
}

.hero-men-btn {
  display: inline-block;
  background: linear-gradient(90deg, #ffd700 60%, #bfa16c 100%);
  color: #181b22;
  font-weight: 700;
  font-size: 1.1rem;
  padding: 12px 32px;
  border-radius: 8px;
  text-decoration: none;
  box-shadow: 0 2px 12px rgba(30,30,60,0.10);
  transition: background 0.18s, color 0.18s, box-shadow 0.18s;
}

.hero-men-btn:hover {
  background: linear-gradient(90deg, #bfa16c 60%, #ffd700 100%);
  color: #23272f;
  box-shadow: 0 6px 24px rgba(191,161,108,0.13);
}
html {
  scroll-behavior: smooth;
}

  </style>

</head>
<body>
  <header class="header">
  <div class="logo-centered">
    <a href="index.php"><img src="LGO.png" alt="Logo"></a>
  </div>
  <nav class="navbar">
    <div class="navbar-row">
      <div class="nav-links">
        <a href="index.php">Home</a>
        <a href="women.php">Women</a>
        <a href="men.php">Men</a>
        <a href="about_us.php">About Us</a>
      </div>
      <div class="nav-icons">
        <div id="search-icon"><img src="SEARCH.jpg" alt="Search" class="icon"></div>
<a href="cart.php" style="position: relative;">
  <img src="cart.png" alt="Cart" class="icon">
<span id="cart-badge" style="
  position: absolute;
  top: -7px;
  right: -10px;
  width: 22px;
  height: 22px;
  background: linear-gradient(135deg, #e53935 60%, #b71c1c 100%);
  color: #fff;
  border-radius: 50%;
  font-size: 13px;
  font-weight: 700;
  box-shadow: 0 2px 8px rgba(229,57,53,0.18);
  border: 2px solid #fff;
  display: none;
  text-align: center;
  line-height: 22px; /* Match height for vertical centering */
  z-index: 2;
  letter-spacing: 0.5px;
  transition: background 0.2s, box-shadow 0.2s;
  padding: 0;
  vertical-align: middle;
">0</span>
</a>
      </div>
    </div>
  </nav>
</header>

<div id="search-overlay" class="search-overlay">
  <div class="search-box">
    <input type="text" placeholder="Search perfumes...">
    <button id="close-search">✖️</button>
  </div>
</div>

  
 <section class="hero-men">
  <div class="hero-men-bg"></div>
  <div class="hero-men-content">
    <h2>Unleash Your Signature Scent</h2>
    <p>Discover bold, unforgettable colognes for every man and every moment.</p>
    <a href="#shop" class="hero-men-btn">Shop Men's Fragrances <i class="fa-solid fa-arrow-down"></i></a>
  </div>
</section>

<section class="product-list" id="shop">
  <div class="product-carousel">
    <button class="carousel-arrow left" style="display:none;">&#8592;</button>
    <div class="carousel-track">
      <?php
$sql = "SELECT 
            p.id, 
            p.name, 
            p.image, 
            MIN(v.price) AS price, 
            SUM(v.quantity) AS total_qty
        FROM perfumes p
        JOIN variants v ON p.id = v.perfume_id
        WHERE p.category = 'Man' AND v.size_ml = 10
        GROUP BY p.id, p.name, p.image";
$result = $conn->query($sql);
      if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
              echo '<div class="product">';
               if ($row["total_qty"] == 0) {
            echo '<div class="out-of-stock-badge">Out of Stock</div>';
        }
              echo '<a href="product.php?id=' . $row["id"] . '">';
              echo '<img src="' . $row["image"] . '" alt="' . $row["name"] . '">';
              echo '<p>' . $row["name"] . '</p>';
              echo '<h3>FROM ' . number_format($row["price"], 2) . ' DA</h3>';
              echo '</a>';
              echo '<a href="product.php?id=' . $row["id"] . '" class="details-button">More Details</a>';
              echo '</div>';
          }
      } else {
          echo "No perfumes found.";
      }
      ?>
    </div>
    <button class="carousel-arrow right">&#8594;</button>
  </div>
</section>
<script>
  const searchIcon = document.getElementById('search-icon');
  const searchOverlay = document.getElementById('search-overlay');
  const closeSearch = document.getElementById('close-search');

  searchIcon.addEventListener('click', () => {
    searchOverlay.style.display = 'flex';
  });

  closeSearch.addEventListener('click', () => {
    searchOverlay.style.display = 'none';
  });

  searchOverlay.addEventListener('click', (e) => {
    if (e.target === searchOverlay) {
      searchOverlay.style.display = 'none';
    }
  });
  function updateCartBadge() {
  const badge = document.getElementById('cart-badge');
  const cart = JSON.parse(localStorage.getItem('cart')) || [];
  let totalQty = 0;
  cart.forEach(item => {
    totalQty += item.quantity;
  });
  if (totalQty > 0) {
    badge.textContent = totalQty;
    badge.style.display = 'inline-block';
  } else {
    badge.style.display = 'none';
  }
}

document.addEventListener('DOMContentLoaded', updateCartBadge);

      
if (typeof addToCartBtn !== 'undefined' && addToCartBtn) {
  addToCartBtn.addEventListener('click', function() {
    setTimeout(updateCartBadge, 100); 
  });
}
  document.addEventListener('click', (e) => {
    if (!input.contains(e.target) && !suggestionsBox.contains(e.target)) {
      suggestionsBox.innerHTML = '';
    }
  });
function updateCartBadge() {
  const badge = document.getElementById('cart-badge');
  const cart = JSON.parse(localStorage.getItem('cart')) || [];
  let totalQty = 0;
  cart.forEach(item => {
    totalQty += item.quantity;
  });
  console.log('Cart badge update:', totalQty, cart); 
  if (totalQty > 0) {
    badge.textContent = totalQty;
    badge.style.display = 'inline-block';
  } else {
    badge.style.display = 'none';
  }
}
document.addEventListener('DOMContentLoaded', updateCartBadge);

if (typeof addToCartBtn !== 'undefined' && addToCartBtn) {
  addToCartBtn.addEventListener('click', function() {
    setTimeout(updateCartBadge, 100); 
  });
}
document.addEventListener('DOMContentLoaded', function() {
  document.querySelectorAll('.product-carousel').forEach(function(carousel) {
    const track = carousel.querySelector('.carousel-track');
    const products = Array.from(track.querySelectorAll('.product'));
    const leftArrow = carousel.querySelector('.carousel-arrow.left');
    const rightArrow = carousel.querySelector('.carousel-arrow.right');
    const visibleCount = 4;
    let page = 0;

    function getProductWidth() {
      const prod = products[0];
      const style = getComputedStyle(prod);
      return prod.offsetWidth + parseInt(style.marginLeft) + parseInt(style.marginRight);
    }

    function updateCarousel() {
      const productWidth = getProductWidth();
      const maxOffset = Math.max(0, (products.length - visibleCount) * productWidth);
      const offset = Math.min(page * visibleCount * productWidth, maxOffset);
      track.style.transform = `translateX(-${offset}px)`;
      leftArrow.style.display = page === 0 ? 'none' : '';
      rightArrow.style.display = (offset >= maxOffset) ? 'none' : '';
    }

    leftArrow.addEventListener('click', function() {
      if (page > 0) {
        page--;
        updateCarousel();
      }
    });

    rightArrow.addEventListener('click', function() {
      const productWidth = getProductWidth();
      const maxPage = Math.ceil(products.length / visibleCount) - 1;
      if (page < maxPage) {
        page++;
        updateCarousel();
      }
    });

    let imagesLoaded = 0;
    const images = track.querySelectorAll('img');
    if (images.length === 0) {
      updateCarousel();
    } else {
      images.forEach(img => {
        if (img.complete) {
          imagesLoaded++;
        } else {
          img.addEventListener('load', () => {
            imagesLoaded++;
            if (imagesLoaded === images.length) updateCarousel();
          });
        }
      });
      if (imagesLoaded === images.length) updateCarousel();
    }
  });
});
</script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

<footer style="background: #111; color: #fff; padding: 40px 0; text-align: center; font-family: 'Segoe UI', sans-serif;">
  <div style="max-width: 1200px; margin: 0 auto;">
    <h2 style="margin-bottom: 10px; font-size: 28px; letter-spacing: 1px;">Sams Fragrance</h2>
    <p style="color: #aaa; margin-bottom: 25px;">Elevate your scent. Be unforgettable.</p>

    <div style="margin-bottom: 25px;">
      <a href="#" style="margin: 0 15px; color: #aaa; text-decoration: none;">Home</a>
      <a href="#" style="margin: 0 15px; color: #aaa; text-decoration: none;">Shop</a>
      <a href="#" style="margin: 0 15px; color: #aaa; text-decoration: none;">Contact</a>
      <a href="#" style="margin: 0 15px; color: #aaa; text-decoration: none;">About</a>
    </div>

    <div style="margin-bottom: 25px;">
      <a href="#" style="color: #fff; margin: 0 10px;"><i class="fab fa-facebook-f"></i></a>
      <a href="#" style="color: #fff; margin: 0 10px;"><i class="fab fa-instagram"></i></a>
      <a href="#" style="color: #fff; margin: 0 10px;"><i class="fab fa-tiktok"></i></a>
    </div>

    <p style="color: #555;">&copy; <?= date('Y') ?> Sams Fragrance. All rights reserved.</p>
  </div>
</footer>

</body>
</html>
