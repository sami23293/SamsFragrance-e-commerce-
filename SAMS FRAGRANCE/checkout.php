<?php
session_start();  

//  Connect to the database
$conn = new mysqli("localhost", "root", "", "sams");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

//  Determine if it's a single product  or from Cart
$cart = $_SESSION['cart'] ?? [];
$isSingleProduct = isset($_GET['variant_id']) && (!isset($_GET['from_cart']) || empty($cart));
$variant_id = isset($_GET['variant_id']) ? (int)$_GET['variant_id'] : 0;
$quantity = isset($_GET['qty']) ? max(1, (int)$_GET['qty']) : 1;

$perfume = null;
$cart_details = [];

if (isset($_GET['from_cart']) && $_GET['from_cart'] == 1) {
    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        $cart_details = $_SESSION['cart'];
        
        $total_cart_price = 0;
        foreach ($cart_details as $item) {
            $item['total'] = $item['price'] * $item['quantity'];
            $total_cart_price += $item['total'];
        }
    }
} else {
    // Handle single product flow (set $isSingleProduct = true if valid)
}

//  Handle AJAX request to fetch delivery price
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['get_delivery_price'])) {
    $wilaya_id = (int)$_POST['wilaya_id'];
    $delivery_method = $_POST['method'];

    $column = ($delivery_method === 'depot') ? 'price_depot' : 'price_home';

    $stmt = $conn->prepare("SELECT $column AS price FROM wilayas WHERE id = ?");
    $stmt->bind_param("i", $wilaya_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        echo json_encode(['success' => true, 'price' => $row['price']]);
    } else {
        echo json_encode(['success' => false, 'message' => 'No delivery price found.']);
    }

    $stmt->close();
    $conn->close();
    exit;
}

//  Fetch wilayas
$wilayas = $conn->query("SELECT id, name FROM wilayas ORDER BY name ASC")->fetch_all(MYSQLI_ASSOC);

// If single product, fetch its details
$perfume = null;
if ($isSingleProduct) {
    $stmt = $conn->prepare("
        SELECT 
            v.id AS variant_id,
            v.size_ml,
            v.price,
            p.id AS perfume_id,
            p.name,
            p.image,
            p.category
        FROM variants v
        JOIN perfumes p ON v.perfume_id = p.id
        WHERE v.id = ?
    ");
    $stmt->bind_param("i", $variant_id);
    $stmt->execute();
    $perfume = $stmt->get_result()->fetch_assoc();
    $stmt->close();
}

$base_price = isset($perfume['price']) ? (float)$perfume['price'] : 0;
$final_price = $base_price * $quantity;

$cart = $_SESSION['cart'] ?? [];
$total_cart_price = 0;
$total_quantity = 0;
foreach ($cart as $item) {
    if (!isset($item['variant_id'])) continue; // Skip if variant_id is missing

    $item_quantity = (int)$item['quantity'];
    $price = (float)$item['price'];
    $item_total = $item_quantity * $price;
    $total_cart_price += $item_total;
    $total_quantity += $item_quantity;

    $image = $item['image'] ?? '';
    if (!$image && isset($item['id'])) {
        $stmt = $conn->prepare("SELECT image FROM perfumes WHERE id = ?");
        $stmt->bind_param("i", $item['id']);
        $stmt->execute();
        $imgResult = $stmt->get_result();
        $imgRow = $imgResult->fetch_assoc();
        $image = $imgRow['image'] ?? '';
        $stmt->close();
    }

    $cart_details[] = [
        'variant_id' => $item['variant_id'],
        'name' => $item['name'],
        'size' => $item['size'],
        'price' => $price,
        'quantity' => $item_quantity,
        'total' => $item_total,
        'image' => $image
    ];
}
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['get_delivery_price'])) {
    //  Collect order info
$name = mysqli_real_escape_string($conn, $_POST['name']);
$phone = mysqli_real_escape_string($conn, $_POST['phone']);
$wilaya_id = (int)$_POST['wilaya'];
$delivery_method = $_POST['delivery_method'];
$commune = isset($_POST['commune']) ? mysqli_real_escape_string($conn, $_POST['commune']) : null;
$address = isset($_POST['address']) ? mysqli_real_escape_string($conn, $_POST['address']) : null;
$total_price = 0;
    //  Prepare items array (single or cart)
    $items = [];
    if (isset($_POST['variant_id']) && isset($_POST['quantity'])) {
        // Single product order
        $items[] = [
            'variant_id' => (int)$_POST['variant_id'],
            'quantity' => (int)$_POST['quantity']
        ];
    } elseif (!empty($_SESSION['cart'])) {
        // Cart order
        foreach ($_SESSION['cart'] as $item) {
            $items[] = [
                'variant_id' => (int)$item['variant_id'],
                'quantity' => (int)$item['quantity']
            ];
        }
    } else {
        die("No items to order.");
    }

    // 3. Calculate total price (sum all items + delivery)
    foreach ($items as $item) {
        $stmt = $conn->prepare("SELECT price FROM variants WHERE id = ?");
        $stmt->bind_param("i", $item['variant_id']);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $total_price += $row['price'] * $item['quantity'];
        $stmt->close();
    }
    // Add delivery price
    $column = ($delivery_method === 'depot') ? 'price_depot' : 'price_home';
    $stmt = $conn->prepare("SELECT $column AS price FROM wilayas WHERE id = ?");
    $stmt->bind_param("i", $wilaya_id);
    $stmt->execute();
    $delivery_price_result = $stmt->get_result();
    $delivery_price = 0;
    if ($delivery_price_result->num_rows > 0) {
        $delivery_price = (float)$delivery_priceS_result->fetch_assoc()['price'];
    }
    $stmt->close();
    $total_price += $delivery_price;

    // 4 Insert into orders table-
$stmt = $conn->prepare("INSERT INTO orders (full_name, phone_number, address 
, wilaya_id, delivery_method, commune, created_at, total_price) VALUES (?, ?, ?, ?, ?, ?, NOW(), ?)");
$stmt->bind_param("sssissd", $name, $phone, $address, $wilaya_id, $delivery_method, $commune, $total_price);
if (!$stmt->execute()) {
    die("Order insert error: " . $stmt->error);
}
$order_id = $stmt->insert_id;
$stmt->close();
    // 5 Insert each item into order_items-
    $stmt = $conn->prepare("INSERT INTO order_items (order_id, variant_id, quantity) VALUES (?, ?, ?)");
    foreach ($items as $item) {
        $stmt->bind_param("iii", $order_id, $item['variant_id'], $item['quantity']);
        $stmt->execute();
    }
    $stmt->close();

    if (isset($_GET['variant_id'], $_GET['qty']) && is_numeric($_GET['variant_id']) && is_numeric($_GET['qty'])) {
    $variant_id = (int)$_GET['variant_id'];
    $qty = (int)$_GET['qty'];

    // 1 Decrement the ordered variant's quantity
    $stmt = $conn->prepare("UPDATE variants SET quantity = quantity - ? WHERE id = ? AND quantity >= ?");
    $stmt->bind_param("iii", $qty, $variant_id, $qty);
    $stmt->execute();

    // 2 Check if this variant is now out of stock and is a decant (e.g., 10ml)
    $stmt = $conn->prepare("SELECT id, perfume_id, size_ml, quantity FROM variants WHERE id = ?");
    $stmt->bind_param("i", $variant_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $variant = $result->fetch_assoc();

    if ($variant && $variant['quantity'] <= 0 && $variant['size_ml'] == 10) {
        // Find the full bottle variant for this perfume
        $stmt2 = $conn->prepare("SELECT id, quantity FROM variants WHERE perfume_id = ? AND size_ml >= 100 ORDER BY size_ml DESC LIMIT 1");
        $stmt2->bind_param("i", $variant['perfume_id']);
        $stmt2->execute();
        $full = $stmt2->get_result()->fetch_assoc();

        if ($full && $full['quantity'] > 0) {
            // Subtract 1 from the full bottle
            $conn->query("UPDATE variants SET quantity = quantity - 1 WHERE id = {$full['id']} AND quantity > 0");
            // Reset decant quantity to standard (e.g., 10)
            $conn->query("UPDATE variants SET quantity = 10 WHERE id = {$variant['id']}");
        }
    }
}
}
    // 6. Clear cart if needed
    unset($_SESSION['cart']);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['get_delivery_price'])) {
    // ... your order processing code ...

    // Show confirmation and exit
    echo "<div style='max-width:500px;margin:30px auto;padding:20px;background:#f0fff4;border:2px solid #38a169;border-radius:10px;text-align:center;'>
        <h2>🎉 Order Confirmed!</h2>
        <p>Thank you, <strong>{$name}</strong>.<br>Your order has been placed successfully.</p>
        <p>Total to pay: <strong>{$total_price} DA</strong></p>
        <a href='index.php' style='display:inline-block;margin-top:15px;padding:10px 20px;background:#38a169;color:#fff;text-decoration:none;border-radius:5px;font-weight:bold;'>⬅️ Back to Home</a>
    </div>";
  
    $conn->close();
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Cart</title>
  <link rel="stylesheet" href="style.css" />
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600&display=swap" rel="stylesheet">
<style>
/* General Styles */
body {
  font-family: Arial, sans-serif;
  margin: 0;
  padding: 0;
  background-color: #fff;
}

.checkout-wrapper {
  display: flex;
  justify-content: center;
  align-items: flex-start;
  gap: 30px;
  margin: 40px auto 40px auto;
  max-width: 1000px;
  width: 100%;
  box-sizing: border-box;
}

.perfume-summary {
  flex: 1 1 320px;
  min-width: 280px;
  max-width: 350px;
  background: #fff;
  border: 1px solid #ececec;
  border-radius: 0;
  box-shadow: 0 2px 10px rgba(180,160,80,0.06);
  padding: 24px 18px 18px 18px;
  margin-bottom: 20px;
}


.perfume-summary h3 {
  margin: 0;
  font-size: 18px;
  font-weight: bold;
}

.perfume-summary img {
  max-width: 100%;
  height: auto;
  border-radius: 8px;
  margin-top: 10px;
}

.perfume-info p {
  margin: 5px 0;
  font-size: 14px;
  color: #555;
}

/* Checkout Form Styles */
.checkout-container {
  flex: 1 1 340px;
  min-width: 320px;
  max-width: 420px;
  margin: 0 auto;
  background: #fff;
  border: 1px solid #ececec;
  border-radius: 0;
  box-shadow: 0 2px 10px rgba(180,160,80,0.06);
  padding: 28px 24px 24px 24px;
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.checkout-container h2 {
  text-align: left;
  margin: 0 0 20px 0;
  font-size: 24px;
  font-weight: bold;
  color: #bfa16c;
}

.checkout-container form {
  display: flex;
  flex-direction: column;
  gap: 15px;
}

.checkout-container form label {
  display: block;
  font-size: 14px;
  margin-bottom: 5px;
  color: #333;
}

.checkout-container form input[type="text"],
.checkout-container form select {
  width: 100%;
  padding: 10px;
  border: 1px solid #ddd;
  border-radius: 0;
  font-size: 14px;
  color: #333;
  background: #faf8f2;
}

.checkout-container form input[type="radio"] {
  margin-right: 10px;
  accent-color: #bfa16c;
}


#commune-field, #address-field {
  display: none;
}

#total-line {
  margin-top: 20px;
  font-weight: bold;
  font-size: 16px;
  color: #333;
}

button[type="submit"] {
  padding: 10px 15px;
  background-color: #bfa16c;
  color: #fff;
  border: none;
  border-radius: 0;
  cursor: pointer;
  font-size: 16px;
  font-weight: 600;
  transition: background 0.15s;
}
button[type="submit"]:hover {
  background-color: #e2c98f;
  color: #232323;
}
@media (max-width: 900px) {
  .checkout-wrapper {
    flex-direction: column;
    align-items: stretch;
    gap: 0;
    max-width: 98vw;
  }
  .perfume-summary,
  .checkout-container {
    max-width: 98vw;
    margin: 0 auto 24px auto;
  }
}

.cart-section {
  background: #fff;
  border-radius: 10px;
  padding: 18px 20px 12px 20px;
  box-shadow: 0 2px 12px rgba(0,0,0,0.07);
  margin-bottom: 20px;
}
.cart-items-minimal {
  display: flex;
  flex-direction: column;
  gap: 14px;
}
.cart-item-minimal {
  display: flex;
  align-items: center;
  gap: 14px;
  padding: 8px 0;
  border-bottom: 1px solid #f0f0f0;
}
.cart-item-minimal:last-child {
  border-bottom: none;
}
.cart-mini-img {
  width: 48px;
  height: 48px;
  object-fit: center;
  border-radius: 7px;
  border: 1px solid #eee;
  background: #fafafa;
  flex-shrink: 0;
}
.cart-item-info {
  flex: 1;
  display: flex;
  flex-direction: row;
  align-items: center;
  justify-content: space-between;
  gap: 10px;
}
.cart-item-title {
  font-size: 15px;
  font-weight: 600;
  color: #222;
  white-space: nowrap;
}
.cart-item-size {
  font-size: 13px;
  color: #888;
  margin-left: 4px;
}
.cart-item-meta {
  display: flex;
  gap: 12px;
  font-size: 13px;
  color: #666;
  align-items: center;
}
.cart-item-qty {
  background: #f3f3f3;
  border-radius: 4px;
  padding: 1px 7px;
  font-weight: 500;
}
.cart-item-price {
  font-weight: 600;
  color: #007bff;
}
.cart-total {
  text-align: right;
  font-size: 16px;
  font-weight: bold;
  margin-top: 10px;
  color: #222;
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


<div class="checkout-wrapper">
  <?php if ($isSingleProduct && $perfume): ?>
  
    <div class="perfume-summary">
      <h3><?= htmlspecialchars($perfume['name']) ?> (<?= htmlspecialchars($perfume['size_ml']) ?> ml)</h3>
      <img src="<?= htmlspecialchars($perfume['image']) ?>" alt="Perfume Image">
      <div class="perfume-info">
        <p><strong>Category:</strong> <?= htmlspecialchars($perfume['category']) ?></p>
        <p><strong>Quantity:</strong> <?= $quantity ?></p>
        <p><strong>Unit Price:</strong> <?= number_format($perfume['price'], 2) ?> DZD</p>
        <p><strong>Total:</strong> <?= number_format($final_price, 2) ?> DZD</p>
      </div>
    </div>

  <?php elseif (!empty($cart_details)): ?>
<div class="cart-items-minimal">
  <?php foreach ($cart_details as $item): ?>
    <div class="cart-item-minimal">
      <img src="<?= htmlspecialchars($item['image']) ?>" alt="Perfume" class="cart-mini-img">
      <div class="cart-item-info">
        <span class="cart-item-title">
          <?= htmlspecialchars($item['name']) ?>
          <span class="cart-item-size">(<?= htmlspecialchars($item['size']) ?>)</span>
        </span>
        <span class="cart-item-meta">
          <span class="cart-item-qty">x<?= (int)$item['quantity'] ?></span>
          <span class="cart-item-price"><?= number_format($item['total'], 2) ?> DZD</span>
        </span>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
  <p class="cart-total"><strong>Total:</strong> <?= number_format($total_cart_price, 2) ?> DZD</p>
</div>
  <?php else: ?>
    <p>Your cart is empty or invalid product. <a href="index.php">Go back</a></p>
  <?php endif; ?>

  
  <div class="checkout-container">
    <h2>Checkout</h2>
    <form method="POST" >
     <?php if ($isSingleProduct && $perfume): ?>
  <input type="hidden" name="variant_id" value="<?= htmlspecialchars($variant_id) ?>">
  <input type="hidden" name="perfume_id" value="<?= htmlspecialchars($perfume['perfume_id']) ?>">
  <input type="hidden" name="quantity" value="<?= htmlspecialchars($quantity) ?>">
  <input type="hidden" name="perfume_price" value="<?= htmlspecialchars($final_price) ?>">
  <span id="base-price" data-price="<?= number_format($final_price, 2, '.', '') ?>"></span>
  
  <p id="order-total" style="font-weight:bold; font-size:18px; color:#007bff; margin-bottom:0.5em;">
    Total to Pay: <span id="order-total-value">DA <?= number_format($final_price, 2) ?> DZD</span>
  </p>
  <p><strong>Quantity:</strong> <?= $quantity ?></p>
<?php else: ?>
  <span id="base-price" data-price="<?= number_format($total_cart_price, 2, '.', '') ?>"></span>

 
  <p id="order-total" style="font-weight:bold; font-size:18px; color:#007bff; margin-bottom:0.5em;">
    Total to Pay: <span id="order-total-value">DA <?= number_format($total_cart_price, 2) ?> DZD</span>
  </p>
<?php
$total_quantity = 0;
if (!empty($cart_details)) {
    foreach ($cart_details as $item) {
        $total_quantity += (int)$item['quantity'];
    }
}
?>
<p><strong>Quantity:</strong> <?= $total_quantity ?></p>
<?php endif; ?>

    
      <label>Full Name:
        <input type="text" name="name" required>
      </label>

      <label>Phone Number:
        <input type="text" name="phone" required>
      </label>

      <label>Wilaya:
        <select name="wilaya" id="wilaya" required>
          <option value="">Select Wilaya</option>
          <?php foreach ($wilayas as $w): ?>
            <option value="<?= htmlspecialchars($w['id']) ?>"><?= htmlspecialchars($w['name']) ?></option>
          <?php endforeach; ?>
        </select>
      </label>

      
      <label>Choose Delivery Method:</label>
      <div class="delivery-methods">
        <label><input type="radio" name="delivery_method" value="depot" required> Depot (Pickup Point)</label>
        <label><input type="radio" name="delivery_method" value="house_delivery"> Home Delivery</label>
      </div>

      
      <div id="commune-field" style="display: none;">
        <label>Commune:
          <input type="text" name="commune">
        </label>
      </div>

      <div id="address-field" style="display: none;">
        <label>Address:
          <input type="text" name="address">
        </label>
      </div>

      <button type="submit">Place Order</button>
    </form>
  </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
  const wilayaSelect = document.getElementById('wilaya');
  const deliveryRadios = document.querySelectorAll('input[name="delivery_method"]');
  const basePriceEl = document.getElementById('base-price');
let basePrice = parseFloat(basePriceEl?.dataset.price || 0);
const finalPriceEl = document.getElementById('final-price');

  const communeField = document.getElementById('commune-field');
  const addressField = document.getElementById('address-field');

  let previouslySelected = null;
  let currentDeliveryFee = 0;

  function toggleFields() {
    const selected = document.querySelector('input[name="delivery_method"]:checked');
    const isHouse = selected?.value === 'house_delivery';
    communeField.style.display = isHouse ? 'block' : 'none';
    addressField.style.display = isHouse ? 'block' : 'none';
  }

  function fetchDeliveryPrice(wilayaId, method) {
    if (!wilayaId || !method) return Promise.resolve(0);
    return fetch(`delivery.php?wilaya_id=${encodeURIComponent(wilayaId)}&method=${encodeURIComponent(method)}`)
      .then(res => res.json())
      .then(data => {
        const fee = parseFloat(data.price);
        return isNaN(fee) ? 0 : fee;
      })
      .catch(() => 0);
  }
function updatePrice() {
  // Always get the latest base price from the DOM
  const basePriceEl = document.getElementById('base-price');
  let basePrice = parseFloat(basePriceEl?.dataset.price || 0);

  const total = basePrice + currentDeliveryFee;

  // Update the order total in the form
  const orderTotalValue = document.getElementById('order-total-value');
  if (orderTotalValue) {
    orderTotalValue.textContent = "DA " + total.toFixed(2) + " DZD";
  }
  // Optionally update a hidden field for the backend
  const finalPriceEl = document.getElementById('final-price');
  if (finalPriceEl) {
    finalPriceEl.textContent = "DA " + total.toFixed(2) + " DZD";
  }
}

  function handleDeliveryChange(radio) {
    const wilayaId = wilayaSelect?.value;
    const method = radio.value;

    if (!wilayaId) {
      currentDeliveryFee = 0;
      updatePrice();
      return;
    }

    fetchDeliveryPrice(wilayaId, method).then(fee => {
      currentDeliveryFee = fee || 0;
      updatePrice();
    });
  }

  deliveryRadios.forEach(radio => {
    radio.addEventListener('click', function () {
      if (previouslySelected === this) {
        this.checked = false;
        previouslySelected = null;
        currentDeliveryFee = 0;
        communeField.style.display = 'none';
        addressField.style.display = 'none';
        updatePrice();
      } else {
        previouslySelected = this;
        toggleFields();
        handleDeliveryChange(this);
      }
    });
  });

  wilayaSelect?.addEventListener('change', () => {
    const selected = document.querySelector('input[name="delivery_method"]:checked');
    if (selected) {
      handleDeliveryChange(selected);
    } else {
      currentDeliveryFee = 0;
      updatePrice();
    }
  });

  const initiallySelected = document.querySelector('input[name="delivery_method"]:checked');
  if (initiallySelected) {
    previouslySelected = initiallySelected;
    toggleFields();
    handleDeliveryChange(initiallySelected);
  } else {
    currentDeliveryFee = 0;
    updatePrice();
  }

  // Search  logic
  const searchIcon = document.getElementById('search-icon');
  const searchOverlay = document.getElementById('search-overlay');
  const closeSearch = document.getElementById('close-search');

  searchIcon?.addEventListener('click', () => {
    searchOverlay.style.display = 'flex';
  });

  closeSearch?.addEventListener('click', () => {
    searchOverlay.style.display = 'none';
  });

  searchOverlay?.addEventListener('click', (e) => {
    if (e.target === searchOverlay) {
      searchOverlay.style.display = 'none';
    }
  });
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

    // Call after adding to cart
if (typeof addToCartBtn !== 'undefined' && addToCartBtn) {
  addToCartBtn.addEventListener('click', function() {
    setTimeout(updateCartBadge, 100); 
  });
}

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

