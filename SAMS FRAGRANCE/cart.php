<?php
session_start();
$data = json_decode(file_get_contents("php://input"), true);
if (isset($data['cart'])) {
    $_SESSION['cart'] = $data['cart'];
    echo "Synced.";
}
// When adding to cart
if (isset($_POST['add_to_cart'])) {
    $perfume_id = $_POST['perfume_id'];
    $variant_id = $_POST['variant_id'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    $_SESSION['cart'][] = [
        'perfume_id' => $perfume_id,
        'variant_id' => $variant_id,
        'quantity' => $quantity,
        'price' => $price
    ];

  
    header('Location: cart.php');
    exit();
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
body {
  background:#fff;
  color: #232323;
  font-family: 'Montserrat', sans-serif;
  margin: 0;
  padding: 0;
}

.cart-container {
  max-width: 700px;
  margin: 60px auto 80px auto;
  background: #fff;
  border: 1px solid #ececec;
  box-shadow: 0 4px 24px rgba(180,160,80,0.06);
  padding: 40px 32px 32px 32px;
  color: #232323;
  border-radius: 0;
}

.cart-container h2 {
  font-family: 'Playfair Display', serif;
  font-size: 2.1rem;
  font-weight: 700;
  margin-bottom: 24px;
  color: #bfa16c;
  letter-spacing: 1px;
  text-shadow: none;
}

#cart-items {
  margin-bottom: 28px;
}

.cart-item {
  display: flex;
  align-items: center;
  gap: 24px;
  background: #fff;
  border: 1px solid #ececec;
  box-shadow: 0 1px 6px rgba(191,161,108,0.04);
  padding: 18px 14px;
  margin-bottom: 18px;
  border-radius: 0;
}

.cart-item img {
  width: 80px;
  height: 80px;
  object-fit: contain;
  border-radius: 0;
  background: #faf8f2;
  border: 1px solid #ececec;
}

.cart-item p {
  margin: 0;
  font-size: 1.13rem;
  color: #232323;
  font-weight: 500;
  letter-spacing: 0.1px;
  flex: 1 1 0;
}

.cart-item p:last-of-type {
  color: #000;
  font-weight: 700;
}


.remove-btn {
  background: none;
  border: 1.5px solid #bfa16c;
  color: #bfa16c;
  border-radius: 0;
  padding: 6px 16px;
  font-size: 1rem;
  font-weight: 600;
  cursor: pointer;
  transition: background 0.15s, color 0.15s, border-color 0.15s;
}
.remove-btn:hover {
  background: #f7ecd2;
  color: #232323;
  border-color: #e2c98f;
}
.cart-container h3 {
  font-size: 1.22rem;
  color: #232323;
  margin-bottom: 20px;
  font-weight: 700;
  letter-spacing: 0.5px;
}

#cart-total {
  color: #000;
  font-weight: 700;
  font-size: 1.22em;
  letter-spacing: 0.5px;
}

.buttons-container {
  display: flex;
  gap: 18px;
  justify-content: flex-end;
  margin-top: 18px;
}

.checkout-btn, .clear-cart-btn {
  border: 1.5px solid #bfa16c;
  border-radius: 0;
  padding: 11px 28px;
  font-size: 1.08rem;
  font-weight: 700;
  cursor: pointer;
  background: #fff;
  color: #bfa16c;
  transition: background 0.15s, color 0.15s, border-color 0.15s;
  font-family: 'Montserrat', sans-serif;
}

.checkout-btn:hover, .clear-cart-btn:hover {
  background: #f7ecd2;
  color: #232323;
  border-color: #e2c98f;
}

@media (max-width: 700px) {
  .cart-container {
    padding: 16px 2vw 16px 2vw;
  }
  .cart-item {
    flex-direction: column;
    align-items: flex-start;
    gap: 10px;
    padding: 10px 6px;
  }
  .cart-item img {
    width: 60px;
    height: 60px;
  }
  .buttons-container {
    flex-direction: column;
    gap: 10px;
    align-items: stretch;
  }
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


<main>
  <div class="cart-container">
    <h2>Your Shopping Cart</h2>
    <div id="cart-items">
    </div>
    <h3>Total: DA <span id="cart-total">0.00</span></h3>
    <div class="buttons-container">
      <a href="checkout.php" class="checkout-btn">Checkout</a>
      <button class="clear-cart-btn" id="clear-cart-btn">Clear Cart</button>
    </div>
  </div>
</main>

<script>
  const cart = JSON.parse(localStorage.getItem('cart')) || [];

  const cartItemsContainer = document.getElementById('cart-items');
  const cartTotalElement = document.getElementById('cart-total');
  const clearCartBtn = document.getElementById('clear-cart-btn');

  function updateCartTotal() {
    let total = 0;
    cart.forEach(item => {
      total += item.price * item.quantity;
    });
    cartTotalElement.textContent = total.toFixed(2);
  }

  function renderCart() {
    cartItemsContainer.innerHTML = '';
    if (cart.length > 0) {
      cart.forEach((item, index) => {
        const cartItem = document.createElement('div');
        cartItem.classList.add('cart-item');
        cartItem.innerHTML = `
          <img src="${item.image}" alt="${item.name}" width="100">
          <p>${item.name} (${item.size})</p>
          <p>Quantity: ${item.quantity}</p>
          <p>Price: DA ${item.price.toFixed(2)} DZD</p>
          <button class="remove-btn" onclick="removeItem(${index})">Remove</button>
        `;
        cartItemsContainer.appendChild(cartItem);
      });
    } else {
      cartItemsContainer.innerHTML = '<p>Your cart is empty.</p>';
    }
    updateCartTotal();
  }

  function removeItem(index) {
    cart.splice(index, 1);
    localStorage.setItem('cart', JSON.stringify(cart));
    renderCart();
  }

  function clearCart() {
    localStorage.removeItem('cart');
    cart.length = 0;
    renderCart();
  }

  clearCartBtn.addEventListener('click', clearCart);
  renderCart();

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
document.querySelector('.checkout-btn').addEventListener('click', function(e) {
  e.preventDefault();
  const cart = JSON.parse(localStorage.getItem('cart')) || [];
  fetch('cart.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ cart: cart })
  })
  .then(res => res.text())
  .then(() => {
    window.location.href = 'checkout.php';
  });
});
  document.getElementById('checkout-btn').addEventListener('click', () => {
  const userName = prompt('Please enter your full name:');
  const userPhone = prompt('Please enter your phone number:');
  
  if (!userName || !userPhone) {
    alert('Name and phone number are required!');
    return;
  }


  const cartData = cart.map(item => ({
    perfume_id: item.id, 
    variant_id: item.variantId, 
    quantity: item.quantity,
    price: item.price
  }));


  const orderData = {
    name: userName,
    phone: userPhone,
    cart: cartData,
    total_price: parseFloat(cartTotalElement.textContent),
    delivery_method: 'standard', 
    wilaya_id: 1 
  };


  fetch('checkout_cart.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify(orderData)
  })
  .then(response => response.json())
  .then(data => {
    if (data.success) {
      alert('Order placed successfully!');
      localStorage.removeItem('cart'); 
      window.location.href = 'order.php'; 
    } else {
      alert('There was an issue with your order. Please try again later.');
    }
  })
  .catch(error => {
    console.error('Error:', error);
    alert('An error occurred. Please try again.');
  });
});



document.getElementById('checkout-btn').addEventListener('click', () => {
  window.location.href = 'checkout_cart.php';
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


