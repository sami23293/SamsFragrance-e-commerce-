<?php
$conn = new mysqli("localhost", "root", "", "sams");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "Invalid or missing perfume ID.";
    exit;
}

$id = (int) $_GET['id'];
if ($id <= 0) {
    echo "Invalid perfume ID.";
    exit;
}

$sql = "SELECT * FROM perfumes WHERE id = $id";
$result = $conn->query($sql);

if (!$result || $result->num_rows === 0) {
    echo "Perfume not found.";
    exit;
}

$perfume = $result->fetch_assoc();


$variant_query = "SELECT * FROM variants WHERE perfume_id = $id";
$variant_result = $conn->query($variant_query);

// Create an array to hold the variants (10ml and 100ml)
$variants = [];
while ($row = $variant_result->fetch_assoc()) {
    $variants[$row['size_ml']] = [
        'id' => $row['id'],
        'price' => $row['price'],
        'quantity' => $row['quantity'],
    ];
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($perfume['name']) ?> - Buy Now</title>
  <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600&display=swap" rel="stylesheet">
  <style>

.product-details {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  padding: 40px;
  background: #fff;
  border-radius: 20px;
  box-shadow: 0 12px 30px rgba(0, 0, 0, 0.1);
  gap: 40px;
}

.product-details .left {
  width: 50%;
  display: flex;
  justify-content: center;
  align-items: center;
}

.product-details .right {
  width: 50%;
  text-align: left;
  display: flex;
  flex-direction: column;
  justify-content: center;
}

.product-details img {
  max-width: 100%;
  max-height: 400px;
  border-radius: 16px;
  object-fit: contain;
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
}

.product-details h1 {
  font-size: 40px;
  margin-bottom: 20px;
  font-weight: bold;
  color: #333;
}

.product-details p {
  font-size: 18px;
  margin: 8px 0;
  color: #555;
}

.price {
  font-size: 26px;
  font-weight: bold;
  color: #28a745;
  margin-bottom: 25px;
}

.custom-select {
  position: relative;
  display: inline-block;
  width: 100%;
}

.options select {
  padding: 14px 18px;
  margin: 12px 0;
  font-size: 16px;
  border-radius: 12px;
  border: 2px solid #333;
  outline: none;
  background-color: #fff;
  color: #333;
  font-weight: 500;
  appearance: none;

  background-image: url('data:image/svg+xml;utf8,<svg fill="%23333" height="20" viewBox="0 0 24 24" width="20" xmlns="http://www.w3.org/2000/svg"><path d="M7 10l5 5 5-5z"/></svg>');
  background-repeat: no-repeat;
  background-position: right 14px center;
  background-size: 16px 16px;

  cursor: pointer;
  transition: all 0.3s ease, transform 0.2s ease;
}

/* Hover effect for dropdown */
.options select:hover {
  border-color: #28a745; /* Green border on hover */
}

/* Focus effect for dropdown */
.options select:focus {
  border-color: #28a745; /* Green border on focus */
  background-color: #f9f9f9; /* Light background color when focused */
}

/* When the dropdown is selected, add a subtle animation */
.options select:active {
  transform: scale(1.05); /* Slight zoom effect on click */
}

/* Disabled option for dropdown */
.options select:disabled {
  color: #aaa;
  background-color: #f0f0f0;
}

/* For the placeholder option */
.options select option:disabled {
  color: #aaa; /* Lighter color for the disabled placeholder */
}


.quantity-container {
  display: flex;
  align-items: center;
  margin-bottom: 25px;
}

.quantity-container button {
  padding: 10px 15px;
  font-size: 20px;
  border: none;
  background: #eee;
  cursor: pointer;
  border-radius: 8px;
  transition: background 0.3s ease;
}

.quantity-container button:hover {
  background: #ddd;
}

.quantity-container input {
  width: 60px;
  text-align: center;
  font-size: 18px;
  margin: 0 12px;
  border: 1px solid #ccc;
  border-radius: 8px;
  padding: 8px;
}

.buttons-container {
  display: flex;
  gap: 20px;
}

.buttons-container button {
  padding: 15px 35px;
  font-size: 18px;
  font-weight: bold;
  cursor: pointer;
  border-radius: 12px;
  border: 2px solid black;
  background-color: white;
  color: black;
  transition: all 0.3s ease, transform 0.2s ease;
}

#add-to-cart:hover,
#buy-now:hover {
  background-color: black;
  color: white;
  transform: scale(1.05);
}

.search-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  backdrop-filter: blur(3px); /* Less blur */
  background-color: rgba(0, 0, 0, 0.2); /* Softer dark */
  display: none;
  justify-content: flex-start; /* Push to top */
  align-items: flex-start;
  padding-top: 160px; /* Distance from top navbar */
  z-index: 999;
}

.search-box {
  background: white;
  padding: 15px;
  border-radius: 8px;
  display: flex;
  align-items: center;
  gap: 10px;
  margin: 0 auto; /* Center horizontally */
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

<section class="product-details">
  <div class="left">
    <img src="<?= htmlspecialchars($perfume['image']) ?>" alt="<?= htmlspecialchars($perfume['name']) ?>">
  </div>


  <div class="right">
    <h1><?= htmlspecialchars($perfume['name']) ?></h1>

    <p class="price" id="price">DA <?= number_format($variants[100]['price'], 2) ?> DZD</p>

    <div class="options">
      <label for="size" class="label">Choose Size:</label>
      <div class="custom-select">
       
<select id="size" name="size">
<?php
foreach ([10, 125, 100] as $size): ?>
  <?php if (isset($variants[$size])): 
    $v = $variants[$size];
    $disabled = $v['quantity'] <= 0 ? 'disabled' : '';
    $label = $size . 'ml - ' . number_format($v['price'], 2) . ' DZD';
    if ($v['quantity'] <= 0) $label .= ' (Out of Stock)';
  ?>
    <option value="<?= $size ?>ml"
            data-price="<?= $v['price'] ?>"
            data-variant-id="<?= $v['id'] ?>"
            <?= $disabled ?>
            <?= ($size == 100 && empty($disabled)) ? 'selected' : '' ?>>
      <?= $label ?>
    </option>
  <?php endif; ?>
<?php endforeach; ?>
</select>
      </div>
    </div>

    <div class="quantity-container">
      <button id="minus" disabled>-</button>
      <input type="number" id="quantity" value="1" readonly>
      <button id="plus">+</button>
    </div>

  <div class="buttons-container">
  <button id="add-to-cart"
    data-id="<?= $perfume['id'] ?>"
    data-name="<?= htmlspecialchars($perfume['name']) ?>"
    data-image="<?= htmlspecialchars($perfume['image']) ?>"
    data-price="<?= $variants[100]['price'] ?>"
    data-quantity="1">
    Add to Cart
  </button>

  <a href="checkout.php?variant_id=<?= $variant_id ?>&qty=<?= $quantity ?>">
  <button id="buy-now">Buy Now</button>
</a>



    </div>
  </div>
</section>
<script>
  
document.addEventListener('DOMContentLoaded', function () {
  const quantity = document.getElementById('quantity');
  const plus = document.getElementById('plus');
  const minus = document.getElementById('minus');
  const priceElement = document.getElementById('price');
  const sizeSelect = document.getElementById('size');

  const addToCartBtn = document.getElementById('add-to-cart');
  const buyNowBtn = document.getElementById('buy-now');

  let basePrice = parseFloat(sizeSelect.options[sizeSelect.selectedIndex].dataset.price);

  function updatePriceDisplay() {
    const qty = parseInt(quantity.value);
    const total = basePrice * qty;
    priceElement.textContent = "DA " + total.toFixed(2) + " DZD";
  }

  plus.addEventListener('click', () => {
    let qty = parseInt(quantity.value) + 1;
    quantity.value = qty;
    if (qty > 1) minus.disabled = false;
    updatePriceDisplay();
  });

  minus.addEventListener('click', () => {
    let qty = parseInt(quantity.value);
    if (qty > 1) {
      qty--;
      quantity.value = qty;
      if (qty === 1) minus.disabled = true;
    }
    updatePriceDisplay();
  });

  sizeSelect.addEventListener('change', () => {
    basePrice = parseFloat(sizeSelect.options[sizeSelect.selectedIndex].dataset.price);
    quantity.value = 1;
    minus.disabled = true;
    updatePriceDisplay();
  });

  updatePriceDisplay();

 if (addToCartBtn) {
  addToCartBtn.addEventListener('click', () => {
    const size = sizeSelect.value;
    if (!size) {
      alert("Please choose a size first.");
      return;
    }

    const qty = parseInt(quantity.value);
    const price = parseFloat(sizeSelect.options[sizeSelect.selectedIndex].dataset.price);
    const variantId = sizeSelect.options[sizeSelect.selectedIndex].dataset.variantId || 0;

    const perfumeId = "<?= $perfume['id'] ?>";
    const perfumeName = "<?= htmlspecialchars($perfume['name']) ?>";
    const perfumeImage = "<?= htmlspecialchars($perfume['image']) ?>";

    const cart = JSON.parse(localStorage.getItem('cart')) || [];

    // Check if the variant is already in the cart
    const existingItem = cart.find(item => item.variant_id === parseInt(variantId));

    if (existingItem) {
      existingItem.quantity += qty;
    } else {
      cart.push({
        id: perfumeId,
        name: perfumeName,
        image: perfumeImage,
        size: size,
        price: price,
        quantity: qty,
        variant_id: parseInt(variantId)
      });
    }

    localStorage.setItem('cart', JSON.stringify(cart));
    updateCartBadge(); // Instantly update the badge here!
    alert("Added to cart!");

    fetch('sync_cart.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify({ cart: cart })
    })
    .then(response => response.text())
    .then(data => {
      console.log('Cart synced with backend:', data);
    })
    .catch(error => console.error('Error syncing cart:', error));
  });
}
  if (buyNowBtn) {
    buyNowBtn.addEventListener('click', (e) => {
      e.preventDefault();
      const size = sizeSelect.value;
      if (!size) {
        alert("Please choose a size first.");
        return;
      }

      const qty = parseInt(quantity.value);
      const price = parseFloat(sizeSelect.options[sizeSelect.selectedIndex].dataset.price);
      const variantId = sizeSelect.options[sizeSelect.selectedIndex].dataset.variantId || 0;

      const perfumeId = "<?= $perfume['id'] ?>";
      const perfumeName = "<?= htmlspecialchars($perfume['name']) ?>";
      const perfumeImage = "<?= htmlspecialchars($perfume['image']) ?>";

      // Construct the URL to redirect to checkout
      const total = price * qty;
      const checkoutUrl = `checkout.php?variant_id=${variantId}&qty=${qty}&total_price=${total}&perfume_id=${perfumeId}&perfume_name=${encodeURIComponent(perfumeName)}&perfume_image=${encodeURIComponent(perfumeImage)}`;

      window.location.href = checkoutUrl;
    });
  }
});

// Update cart badge from localStorage
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

// Call on page load
document.addEventListener('DOMContentLoaded', updateCartBadge);

// Call after adding to cart
if (typeof addToCartBtn !== 'undefined' && addToCartBtn) {
  addToCartBtn.addEventListener('click', function() {
    setTimeout(updateCartBadge, 100); 
  });
}
function updateButtonsForStock() {
  const sizeSelect = document.getElementById('size');
  const addToCartBtn = document.getElementById('add-to-cart');
  const buyNowBtn = document.getElementById('buy-now');
  const selectedOption = sizeSelect.options[sizeSelect.selectedIndex];
  const isDisabled = selectedOption.disabled;
  addToCartBtn.disabled = isDisabled;
  buyNowBtn.disabled = isDisabled;
}
document.addEventListener('DOMContentLoaded', updateButtonsForStock);
document.getElementById('size').addEventListener('change', updateButtonsForStock);
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
