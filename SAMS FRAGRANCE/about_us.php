<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Shop - Men's Colognes</title>

   <!-- Fonts and CSS -->
   <link rel="stylesheet"
         href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&display=swap">
   <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600&display=swap" rel="stylesheet">
   <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
  <style>
   body {
  margin: 0;
  font-family: 'Montserrat', 'Segoe UI', Arial, sans-serif;
  color: #232323;
  position: relative;
  min-height: 100vh;
  overflow-x: hidden;
}
.premium-bg-blur {
  position: fixed;
  left: 0; right: 0;
  top: 110px;  
  bottom: 120px;
  z-index: 0;
  background:
    linear-gradient(120deg, rgba(60,62,70,0.13) 0%, rgba(220,220,220,0.18) 100%),
    url('https://images.unsplash.com/photo-1464983953574-0892a716854b?auto=format&fit=crop&w=1200&q=80') center/cover no-repeat;
  filter: blur(14px) brightness(0.92);
  opacity: 0.93;
  pointer-events: none;
  border-radius: 32px;
}
.about-container {
  position: relative;
  z-index: 1;
  max-width: 900px;
  margin: 90px auto 60px auto;
  padding: 38px 36px 36px 36px;
  background: rgba(255,255,255,0.82);
  border-radius: 24px;
  box-shadow: 0 8px 32px rgba(191,161,108,0.10), 0 2px 8px rgba(0,0,0,0.07);
  backdrop-filter: blur(2px);
  border: 1.5px solid #e2c98f;
  overflow: hidden;
  animation: fadeInUp 1.1s cubic-bezier(.23,1.02,.32,1) both;
}
@keyframes fadeInUp {
  from { opacity: 0; transform: translateY(40px);}
  to { opacity: 1; transform: translateY(0);}
}
h1 {
  text-align: center;
  font-size: 2.5rem;
  color: #bfa16c;
  font-family: 'Playfair Display', serif;
  margin-bottom: 18px;
  letter-spacing: 1.2px;
}
.gold-divider {
  width: 70px;
  height: 4px;
  background: linear-gradient(90deg, #bfa16c 0%, #e2c98f 100%);
  margin: 0 auto 28px auto;
  border-radius: 2px;
  box-shadow: 0 0 16px 2px #bfa16c44;
  animation: shimmer 2.5s infinite linear;
}
@keyframes shimmer {
  0% { filter: brightness(1); }
  50% { filter: brightness(1.25); }
  100% { filter: brightness(1); }
}
p.description {
  font-size: 1.18rem;
  line-height: 1.7;
  text-align: center;
  margin-bottom: 38px;
  color: #555;
  font-family: 'Montserrat', sans-serif;
}
.contact-info {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-around;
  gap: 28px;
  margin-top: 30px;
}
.contact-card {
  flex: 1 1 220px;
  background: rgba(247,247,250,0.93);
  padding: 28px 18px;
  border-radius: 16px;
  text-align: center;
  transition: 0.3s;
  box-shadow: 0 2px 12px rgba(191,161,108,0.07);
  border: 1.5px solid #e2c98f;
  position: relative;
  overflow: hidden;
}
.contact-card:hover {
  background: #fffbe9;
  transform: translateY(-7px) scale(1.03);
  box-shadow: 0 6px 24px rgba(191,161,108,0.13);
}
.contact-card i {
  font-size: 32px;
  color: #bfa16c;
  margin-bottom: 12px;
  margin-top: 2px;
  transition: color 0.2s;
}
.contact-card:hover i {
  color: #e2c98f;
}
.contact-card a {
  text-decoration: none;
  color: #232323;
  font-size: 1.08rem;
  font-weight: 600;
  letter-spacing: 0.2px;
  transition: color 0.2s;
}
.contact-card a:hover {
  color: #bfa16c;
}
footer {
  margin-top: 60px;
  text-align: center;
  color: #999;
  font-size: 15px;
  padding: 32px 0 20px 0;
  background: #18120c;
  border-top: 1.5px solid #e2c98f;
  font-family: 'Montserrat', 'Segoe UI', sans-serif;
}
footer h2 {
  color: #e2c98f;
  margin-bottom: 10px;
  font-size: 1.7rem;
  letter-spacing: 1px;
  font-family: 'Playfair Display', serif;
}
footer a {
  color: #bfa16c;
  margin: 0 15px;
  text-decoration: none;
  font-weight: 600;
  transition: color 0.2s;
}
footer a:hover {
  color: #fff;
}
footer .fa-instagram, footer .fa-tiktok {
  color: #e2c98f;
  margin: 0 10px;
  font-size: 1.3em;
  transition: color 0.2s;
}
footer .fa-instagram:hover, footer .fa-tiktok:hover {
  color: #fff;
}
@media (max-width: 900px) {
  .about-container { padding: 18px 4vw 18px 4vw; }
  .contact-info { flex-direction: column; gap: 18px; }
}
  </style>

</head>
<body>
  <!-- Header Section -->
  <header class="header">
  <!-- Logo centered ABOVE the navbar -->
  <div class="logo-centered">
    <a href="index.php"><img src="LGO.png" alt="Logo"></a>
  </div>

  <!-- Navbar row with flex layout -->
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
 <div class="about-container">
    <h1>About Sams Fragrance</h1>
    <div class="gold-divider"></div>
    <p class="description">
      At Sams Fragrance, we believe that a great scent leaves a lasting impression. We’re passionate about making premium perfumes accessible to everyone. Whether you're looking for your signature scent or want to explore something new, we're here to help you smell unforgettable.
    </p>

    <div class="contact-info">
      <div class="contact-card">
        <i class="fas fa-envelope"></i>
        <p><a href="mailto:samsfragrance213@gmail.com">samsfragrance213@gmail.com</a></p>
      </div>

      <div class="contact-card">
        <i class="fab fa-whatsapp"></i>
        <p><a href="https://wa.me/213657377523" target="_blank">0657377523</a></p>
      </div>

      <div class="contact-card">
        <i class="fab fa-instagram"></i>
        <p><a href="https://instagram.com/sams_fragrances" target="_blank">@sams_fragrances</a></p>
      </div>

      <div class="contact-card">
        <i class="fab fa-tiktok"></i>
        <p><a href="https://www.tiktok.com/@SamsFragrance" target="_blank">@SamsFragrance</a></p>
      </div>
    </div>
  </div>
  <script>
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

    // Call after adding to cart
if (typeof addToCartBtn !== 'undefined' && addToCartBtn) {
  addToCartBtn.addEventListener('click', function() {
    setTimeout(updateCartBadge, 100); // Wait for localStorage update
  });
}
</script>
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
      <a href="#" style="color: #fff; margin: 0 10px;"><i class="fab fa-instagram"></i></a>
      <a href="#" style="color: #fff; margin: 0 10px;"><i class="fab fa-tiktok"></i></a>
    </div>

    <p style="color: #555;">&copy; <?= date('Y') ?> Sams Fragrance. All rights reserved.</p>
  </div>
</footer>

</body>
</html>
