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
  backdrop-filter: blur(6px);
  background-color: rgba(0, 0, 0, 0.3);
  display: none;
  justify-content: center;
  align-items: flex-start;
  padding-top: 100px;
  z-index: 9999;
  animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
  from { opacity: 0 }
  to { opacity: 1 }
}

.search-box {
  background: #ffffff;
  width: 90%;
  max-width: 600px;
  border-radius: 16px;
  box-shadow: 0 12px 28px rgba(0, 0, 0, 0.1);
  overflow: hidden;
  display: flex;
  flex-direction: column;
  border: 1px solid #ddd;
}

.search-header {
  display: flex;
  padding: 12px;
  gap: 10px;
  align-items: center;
  background-color: #fff;
}

.search-header input {
  flex: 1;
  padding: 12px;
  font-size: 16px;
  border: 1px solid #ddd;
  border-radius: 8px;
  outline: none;
  transition: border-color 0.2s ease;
}

.search-header input:focus {
  border-color: #aaa;
}

#close-search {
  background: none;
  border: none;
  font-size: 20px;
  cursor: pointer;
  color: #777;
  transition: color 0.2s ease;
}

#close-search:hover {
  color: #000;
}

.suggestions-box {
  max-height: 250px;
  overflow-y: auto;
  background-color: #fff;
  border-top: 1px solid #eee;
}

.suggestions-box div {
  padding: 12px 16px;
  font-size: 15px;
  cursor: pointer;
  border-bottom: 1px solid #f0f0f0;
  transition: background-color 0.2s ease, padding-left 0.2s ease;
}

.suggestions-box div:hover {
  background-color: #f9f9f9;
  padding-left: 20px;
}

.suggestions-box div:last-child {
  border-bottom: none;
}
.banner {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 100%;
  margin: 30px 0;
}

.banner img {
  width: 80%;           
  max-width: 1200px;    
  height: 300px;      
  object-fit: cover;    
  border-radius: 16px;
  display: block;
}
.premium-filter-form.merged-filter {
  display: flex;
  gap: 18px;
  justify-content: center;
  align-items: center;
  background: #fff;
  border-radius: 14px;
  box-shadow: 0 4px 24px rgba(191,161,108,0.10);
  padding: 14px 22px;
  margin: 36px auto 28px auto;
  max-width: 700px;
  border: 1.5px solid #f2e7d3;
}

.premium-select {
  appearance: none;
  background: linear-gradient(90deg, #faf7f2 60%, #f7f3e9 100%);
  border: 1.5px solid #e0e0e0;
  border-radius: 8px;
  padding: 10px 38px 10px 16px;
  font-size: 15px;
  color: #222;
  font-weight: 500;
  box-shadow: 0 2px 8px rgba(191,161,108,0.03);
  transition: border-color 0.2s;
  min-width: 130px;
  cursor: pointer;
  outline: none;
  position: relative;
}

.premium-select:focus {
  border-color: #bfa16c;
  background: #fffbe9;
}

.premium-select option {
  background: #fff;
  color: #222;
  font-weight: 500;
}

.filter-btn {
  padding: 10px 18px;
  background: linear-gradient(90deg, #bfa16c 60%, #e2c98f 100%);
  color: #fff;
  border-radius: 8px;
  border: none;
  font-weight: 700;
  font-size: 18px;
  box-shadow: 0 4px 16px rgba(191,161,108,0.08);
  cursor: pointer;
  transition: background 0.2s, box-shadow 0.2s;
  display: flex;
  align-items: center;
  justify-content: center;
}

.filter-btn:hover {
  background: linear-gradient(90deg, #a88b4a 60%, #bfa16c 100%);
  box-shadow: 0 6px 24px rgba(191,161,108,0.13);
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
.urgency-banner {
  display: flex;
  align-items: center;
  justify-content: center;
  background: #111;
  color: #fff;
  font-weight: 700;
  font-size: 1.18rem;
  padding: 18px 0 16px 0;
  margin: 0 auto 18px auto;
  border-bottom: 2px solid #d32f2f;
  letter-spacing: 0.3px;
  position: relative;
  z-index: 2;
  box-shadow: 0 2px 12px rgba(211,47,47,0.10);
}

.neon-text {
  color: #ff2222;
  text-shadow:
    0 0 6px #ff2222,
    0 0 12px #ff2222,
    0 0 20px #111,
    0 0 30px #111;
}

.neon-gold {
  color: #fff;
  background: #bfa16c;
  padding: 2px 8px;
  border-radius: 3px;
  margin: 0 2px;
  font-weight: 700;
  box-shadow:
    0 0 6px #bfa16c,
    0 0 12px #bfa16c;
  text-shadow:
    0 0 6px #bfa16c,
    0 0 12px #bfa16c;
}

.neon-arrow {
  display: inline-block;
  font-size: 2.2em;
  color: #ff2222;
  text-shadow:
    0 0 8px #ff2222,
    0 0 16px #111;
  margin-right: 18px;
  animation: curlDown 1.2s infinite cubic-bezier(.68,-0.55,.27,1.55);
}

@keyframes curlDown {
  0%   { transform: rotate(-30deg) translateY(0) scale(1);}
  40%  { transform: rotate(-30deg) translateY(8px) scale(1.08);}
  60%  { transform: rotate(-30deg) translateY(12px) scale(1.12);}
  80%  { transform: rotate(-30deg) translateY(8px) scale(1.08);}
  100% { transform: rotate(-30deg) translateY(0) scale(1);}
}
.urgency-text-group {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  gap: 7px;
}

.urgency-arabic.premium-arabic {
  display: block;
  width: 100%;
  text-align: center;
  color: #fff;
  font-size: 1.35rem;
  font-family: 'Playfair Display', 'Tajawal', 'Cairo', Arial, sans-serif;
  font-weight: 700;
  letter-spacing: 0.5px;
  margin-top: 10px;
  direction: rtl;
  text-shadow:
    0 0 8px #111,
    0 0 18px #111;
}
.hero-premium {
  position: relative;
  min-height: 220px;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 38px auto 38px auto;
  max-width: 1100px;
  border-radius: 18px;
  overflow: hidden;
  box-shadow: 0 8px 32px rgba(191,161,108,0.10);
  background: none;
}
.hero-premium-bg {
  position: absolute;
  inset: 0;
  background: linear-gradient(120deg, #fffbe9 60%, #f7f3e9 100%);
  opacity: 0.92;
  z-index: 1;
}
.hero-premium-content {
  position: relative;
  z-index: 2;
  text-align: center;
  width: 100%;
  padding: 38px 18px 32px 18px;
  display: flex;
  flex-direction: column;
  align-items: center;
}
.hero-premium-badge {
  display: inline-block;
  background: linear-gradient(90deg, #bfa16c 60%, #e2c98f 100%);
  color: #fff;
  font-weight: 700;
  font-size: 1.08rem;
  letter-spacing: 1.2px;
  padding: 7px 22px 7px 18px;
  border-radius: 8px;
  margin-bottom: 18px;
  box-shadow: 0 2px 8px rgba(191,161,108,0.10);
  text-transform: uppercase;
  font-family: 'Montserrat', sans-serif;
}
.hero-premium-badge i {
  margin-right: 8px;
  color: #fffbe9;
}
.hero-premium-title {
  font-family: 'Playfair Display', serif;
  font-size: 2.2rem;
  font-weight: 700;
  color: #232323;
  margin: 0 0 12px 0;
  letter-spacing: 1.2px;
  text-shadow: 0 2px 12px rgba(191,161,108,0.08);
}
.hero-premium-desc {
  font-family: 'Montserrat', sans-serif;
  font-size: 1.13rem;
  color: #7a6a3a;
  margin: 0;
  font-weight: 500;
  letter-spacing: 0.2px;
  max-width: 600px;
}
.section-header {
  text-align: center;
  margin: 54px 0 24px 0;
  position: relative;
}
.section-badge {
  display: inline-block;
  background: linear-gradient(90deg, #bfa16c 60%, #e2c98f 100%);
  color: #fff;
  font-weight: 700;
  font-size: 1.02rem;
  letter-spacing: 1.1px;
  padding: 6px 18px 6px 14px;
  border-radius: 8px;
  margin-bottom: 12px;
  box-shadow: 0 2px 8px rgba(191,161,108,0.10);
  text-transform: uppercase;
  font-family: 'Montserrat', sans-serif;
  vertical-align: middle;
}
.section-badge i {
  margin-right: 7px;
  color: #fffbe9;
}
.section-title {
  font-family: 'Playfair Display', serif;
  font-size: 2rem;
  font-weight: 700;
  color: #232323;
  margin: 10px 0 6px 0;
  letter-spacing: 1.1px;
}
.section-subtitle {
  font-family: 'Montserrat', sans-serif;
  font-size: 1.08rem;
  color: #7a6a3a;
  margin: 0 0 10px 0;
  font-weight: 500;
  letter-spacing: 0.2px;
}
.section-divider {
  width: 60px;
  height: 3px;
  background: linear-gradient(90deg, #bfa16c 60%, #e2c98f 100%);
  margin: 18px auto 0 auto;
  border-radius: 2px;
}

.premium-bg-blur {
  position: fixed;
  inset: 0;
  z-index: 0;
  background: 
    linear-gradient(120deg, rgba(60,62,70,0.18) 0%, rgba(220,220,220,0.22) 100%),
    url('https://images.unsplash.com/photo-1464983953574-0892a716854b?auto=format&fit=crop&w=1200&q=80') center/cover no-repeat;
  filter: blur(12px) brightness(0.85);
  opacity: 0.93;
  pointer-events: none;
}
body {
  position: relative;
  z-index: 1;
  background: none !important;
}
.out-of-stock-badge {
  position: absolute;
  top: 18px;
  right: 18px;
  background: #f44336;
  color: #fff;
  font-family: 'Montserrat', 'Segoe UI', Arial, sans-serif;
  font-weight: 700;
  font-size: 1rem;
  padding: 8px 20px;
  border-radius: 12px 4px 12px 4px;
  box-shadow: 0 2px 10px rgba(244,67,54,0.08);
  letter-spacing: 1px;
  z-index: 10;
  text-shadow: 0 1px 4px rgba(0,0,0,0.08);
  border: 2px solid #fff;
  animation: badgePopIn 0.5s cubic-bezier(.68,-0.55,.27,1.55);
  box-sizing: border-box;
  user-select: none;
  pointer-events: none;
  display: flex;
  align-items: center;
  gap: 8px;
}

.out-of-stock-badge::before {
  content: "\f023";
  font-family: "Font Awesome 6 Free";
  font-weight: 900;
  font-size: 1.1em;
  margin-right: 6px;
  display: inline-block;
  vertical-align: middle;
  opacity: 0.85;
}

@keyframes badgePopIn {
  0% {
    transform: scale(0.7) translateY(-20px);
    opacity: 0;
  }
  70% {
    transform: scale(1.08) translateY(4px);
    opacity: 1;
  }
  100% {
    transform: scale(1) translateY(0);
  }
}
.product {
    position: relative; 
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
    <div class="search-header">
      <input type="text" id="search-input" placeholder="Search perfumes..." autocomplete="off">
      <button id="close-search">✖️</button>
    </div>
    <div id="suggestions" class="suggestions-box"></div>
  </div>
</div>

<form method="GET" class="premium-filter-form merged-filter">
  <select name="brand" id="brand" class="premium-select">
    <option value="">Brand</option>
    <?php
      $brandResult = $conn->query("SELECT DISTINCT brand FROM perfumes WHERE brand IS NOT NULL AND brand != ''");
      while ($b = $brandResult->fetch_assoc()) {
        $selected = (isset($_GET['brand']) && $_GET['brand'] == $b['brand']) ? 'selected' : '';
        echo "<option value=\"".htmlspecialchars($b['brand'])."\" $selected>".htmlspecialchars($b['brand'])."</option>";
      }
    ?>
  </select>
  <select name="category" id="category" class="premium-select">
    <option value="">Category</option>
    <?php
      $catResult = $conn->query("SELECT DISTINCT category FROM perfumes WHERE category IS NOT NULL AND category != ''");
      while ($c = $catResult->fetch_assoc()) {
        $selected = (isset($_GET['category']) && $_GET['category'] == $c['category']) ? 'selected' : '';
        echo "<option value=\"".htmlspecialchars($c['category'])."\" $selected>".htmlspecialchars($c['category'])."</option>";
      }
    ?>
  </select>
  <select name="price" id="price" class="premium-select">
    <option value="">Price</option>
    <option value="0-2000" <?= (isset($_GET['price']) && $_GET['price'] == '0-2000') ? 'selected' : '' ?>>0 - 2,000 DA</option>
    <option value="2000-4000" <?= (isset($_GET['price']) && $_GET['price'] == '2000-4000') ? 'selected' : '' ?>>2,000 - 4,000 DA</option>
    <option value="4000-10000" <?= (isset($_GET['price']) && $_GET['price'] == '4000-10000') ? 'selected' : '' ?>>4,000 - 10,000 DA</option>
    <option value="10000-19000" <?= (isset($_GET['price']) && $_GET['price'] == '10000-19000') ? 'selected' : '' ?>>10,000 - 19,000 DA</option>
    <option value="20000-35000" <?= (isset($_GET['price']) && $_GET['price'] == '20000-35000') ? 'selected' : '' ?>>20,000 - 35,000 DA</option>
    <option value="35000-60000" <?= (isset($_GET['price']) && $_GET['price'] == '35000-60000') ? 'selected' : '' ?>>35,000 - 60,000 DA</option>
  </select>
  <button type="submit" class="filter-btn" title="Filter"><i class="fa-solid fa-filter"></i></button>
</form>
  
<div class="urgency-banner">
  <span class="urgency-emoji">
    <span class="neon-arrow">&#10549;</span>
  </span>
  <div class="urgency-text-group">
    <span class="urgency-text neon-text">
      <strong>Hurry!</strong> Only a few left — <span class="decant-highlight neon-gold">Decant Service</span> available. Try luxury scents before they're gone!
    </span>
    <span class="urgency-arabic premium-arabic">
      تقسيم العطور الأصلية - جرب أفخم العطور بأقل سعر، مع ضمان الجودة والتوصيل السريع!
    </span>
  </div>
</div>
<div class="banner">
    <img src="BAN.jpg" alt="Banner Image">
  </div>
 <section class="hero-premium">
  <div class="hero-premium-bg"></div>
  <div class="hero-premium-content">
    <span class="hero-premium-badge"><i class="fa-solid fa-crown"></i> PREMIUM EXPERIENCE</span>
    <h1 class="hero-premium-title">Discover the Art of Scent</h1>
    <p class="hero-premium-desc">
      Elevate your senses with our exclusive collection of authentic fragrances, curated for those who demand the best.
    </p>
  </div>
</section>
<section class="product-list">
  <div class="product-carousel">
    <button class="carousel-arrow left" style="display:none;">&#8592;</button>
    <div class="carousel-track">
      <?php
      // Build filter conditions
      $where = "WHERE p.is_trendy = 1 ";
      if (!empty($_GET['brand'])) {
          $brand = $conn->real_escape_string($_GET['brand']);
          $where .= " AND p.brand = '$brand'";
      }
      if (!empty($_GET['category'])) {
          $category = $conn->real_escape_string($_GET['category']);
          $where .= " AND p.category = '$category'";
      }
      if (!empty($_GET['price'])) {
          list($min, $max) = explode('-', $_GET['price']);
          $min = (int)$min;
          $max = (int)$max;
          $where .= " AND v.price BETWEEN $min AND $max";
      }

$sql = "SELECT p.id, p.name, p.image, MIN(v.price) as price, SUM(v.quantity) as total_qty
        FROM perfumes p
        JOIN variants v ON p.id = v.perfume_id
        $where
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


<div class="section-header">
  <span class="section-badge"><i class="fa-solid fa-star"></i> NEW</span>
  <h2 class="section-title">New Arrivals</h2>
  <p class="section-subtitle">Discover the latest additions to our exclusive fragrance collection.</p>
  <div class="section-divider"></div>
</div>
<section class="product-list">
  <div class="product-carousel">
    <button class="carousel-arrow left" style="display:none;">&#8592;</button>
    <div class="carousel-track">
      <?php
  
      $where = "WHERE p.is_new_arrival = 1";
      if (!empty($_GET['brand'])) {
          $brand = $conn->real_escape_string($_GET['brand']);
          $where .= " AND p.brand = '$brand'";
      }
      if (!empty($_GET['category'])) {
          $category = $conn->real_escape_string($_GET['category']);
          $where .= " AND p.category = '$category'";
      }
      if (!empty($_GET['price'])) {
          list($min, $max) = explode('-', $_GET['price']);
          $min = (int)$min;
          $max = (int)$max;
          $where .= " AND v.price BETWEEN $min AND $max";
      }

      $sql = "SELECT p.id, p.name, p.image, MIN(v.price) as price, SUM(v.quantity) as total_qty
        FROM perfumes p
        JOIN variants v ON p.id = v.perfume_id
        $where
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
  const input = document.getElementById('search-input');
  const suggestionsBox = document.getElementById('suggestions');

  searchIcon.addEventListener('click', () => {
    searchOverlay.style.display = 'flex';
    input.focus();
  });

  closeSearch.addEventListener('click', () => {
    searchOverlay.style.display = 'none';
    input.value = '';
    suggestionsBox.innerHTML = '';
  });

  searchOverlay.addEventListener('click', (e) => {
    if (e.target === searchOverlay) {
      searchOverlay.style.display = 'none';
      input.value = '';
      suggestionsBox.innerHTML = '';
    }
  });

  input.addEventListener('input', () => {
    const term = input.value.trim();

    if (term.length === 0) {
      suggestionsBox.innerHTML = '';
      return;
    }

    fetch(`search.php?term=${encodeURIComponent(term)}`)
      .then(res => res.json())
      .then(results => {
        suggestionsBox.innerHTML = '';

        if (results.length === 0) {
          const noResult = document.createElement('div');
          noResult.textContent = 'No perfumes found.';
          noResult.style.color = '#999';
          suggestionsBox.appendChild(noResult);
          return;
        }

        results.forEach(perfume => {
          const div = document.createElement('div');
          div.textContent = perfume.name;
          div.addEventListener('click', () => {
            window.location.href = `product.php?id=${perfume.id}`;
          });
          suggestionsBox.appendChild(div);
        });
      })
      .catch(err => {
        suggestionsBox.innerHTML = '';
        const errorDiv = document.createElement('div');
        errorDiv.textContent = 'Error fetching suggestions.';
        errorDiv.style.color = 'red';
        suggestionsBox.appendChild(errorDiv);
        console.error(err);
      });
  });

  // Hide suggestions 
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

    // Call after add to cart
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
