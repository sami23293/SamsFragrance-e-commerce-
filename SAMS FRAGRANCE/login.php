<?php
session_start();


$admin_username = 'admin23';
$admin_password = 'sam123456'; 

// login
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username === $admin_username && $password === $admin_password) {
        $_SESSION['admin_logged_in'] = true;
        header("Location: admin.php");
        exit();
    } else {
        $error = "Incorrect username or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=Montserrat:wght@500;700&display=swap" rel="stylesheet">
    <style>
  body {
    margin: 0;
    min-height: 100vh;
    font-family: 'Montserrat', 'Inter', Arial, sans-serif;
    background: #23272f;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    overflow: hidden;
}
.luxury-bg {
    position: fixed;
    inset: 0;
    z-index: 0;
    background: 
        linear-gradient(120deg, rgba(191,161,108,0.10) 0%, rgba(35,39,47,0.98) 100%),
        url('https://images.unsplash.com/photo-1464983953574-0892a716854b?auto=format&fit=crop&w=1200&q=80') center/cover no-repeat;
    filter: blur(8px) brightness(0.8);
}
.gold-overlay {
    position: fixed;
    inset: 0;
    z-index: 1;
    pointer-events: none;
    background: radial-gradient(ellipse at 60% 20%, rgba(191,161,108,0.13) 0%, transparent 70%);
    opacity: 0.6;
}
.login-box {
    position: relative;
    z-index: 2;
    background: rgba(44, 48, 58, 0.93);
    border-radius: 28px;
    box-shadow: 0 8px 32px rgba(191,161,108,0.13), 0 2px 8px rgba(0,0,0,0.13);
    width: 100%;
    max-width: 410px;
    padding: 48px 36px 36px 36px;
    text-align: center;
    backdrop-filter: blur(8px);
    border: 2.5px solid #bfa16c;
    margin: 0 18px;
    display: flex;
    flex-direction: column;
    align-items: center;
    animation: fadeInUp 1s cubic-bezier(.23,1.02,.32,1) both;
}
@keyframes fadeInUp {
    from { opacity: 0; transform: translateY(40px);}
    to { opacity: 1; transform: translateY(0);}
}
.logo-wrap {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-bottom: 18px;
}
.admin-logo {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    background: #f7f7fa;
    object-fit: contain;
    border: 2.5px solid #e2c98f;
    box-shadow: 0 4px 18px 0 rgba(191,161,108,0.22), 0 2px 8px rgba(0,0,0,0.10);
    padding: 8px;
    transition: box-shadow 0.3s;
}
.admin-logo:hover {
    box-shadow: 0 0 0 4px #bfa16c55, 0 4px 18px 0 rgba(191,161,108,0.22);
}
.login-box h2 {
    font-family: 'Playfair Display', serif;
    margin-bottom: 12px;
    font-weight: 700;
    font-size: 2.1rem;
    color: #f7e7b4;
    letter-spacing: 1.2px;
    text-shadow: 0 2px 18px rgba(191,161,108,0.13);
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
    50% { filter: brightness(1.35); }
    100% { filter: brightness(1); }
}
.input-group {
    width: 100%;
    margin-bottom: 18px;
    display: flex;
    flex-direction: column;
    align-items: center;
}
.login-box input[type="text"],
.login-box input[type="password"] {
    width: 100%;
    padding: 15px;
    border: 1.5px solid #e2c98f;
    border-radius: 9px;
    font-size: 17px;
    background: rgba(247,247,250,0.97);
    color: #23272f;
    font-family: 'Montserrat', sans-serif;
    transition: border 0.2s, background 0.2s, box-shadow 0.2s;
    text-align: left;
    box-shadow: 0 0 0 0 #bfa16c;
    outline: none;
}
.login-box input[type="text"]:focus,
.login-box input[type="password"]:focus {
    border-color: #bfa16c;
    background: #fff;
    box-shadow: 0 0 0 3px #bfa16c33;
    animation: inputPulse 0.5s;
}
@keyframes inputPulse {
    0% { box-shadow: 0 0 0 0 #bfa16c33; }
    70% { box-shadow: 0 0 0 8px #bfa16c22; }
    100% { box-shadow: 0 0 0 3px #bfa16c33; }
}
.gold-btn {
    background: linear-gradient(90deg, #bfa16c 60%, #e2c98f 100%);
    color: #232323;
    padding: 15px 0;
    width: 100%;
    border: none;
    border-radius: 9px;
    font-size: 1.13rem;
    font-weight: 700;
    font-family: 'Montserrat', sans-serif;
    cursor: pointer;
    box-shadow: 0 2px 8px rgba(191,161,108,0.13);
    letter-spacing: 0.6px;
    margin-top: 10px;
    margin-bottom: 2px;
    transition: background 0.3s, color 0.2s, box-shadow 0.2s, transform 0.15s;
    outline: none;
}
.gold-btn:hover, .gold-btn:focus {
    background: linear-gradient(90deg, #e2c98f 60%, #bfa16c 100%);
    color: #18120c;
    box-shadow: 0 4px 18px rgba(191,161,108,0.18);
    transform: translateY(-2px) scale(1.03);
}
.error {
    color: #e53935;
    background: #fff4f4;
    border-left: 4px solid #e53935;
    border-radius: 6px;
    margin-bottom: 18px;
    padding: 10px 0 10px 12px;
    font-weight: 600;
    font-size: 1.07rem;
    box-shadow: 0 2px 8px rgba(229,57,53,0.06);
}
@media (max-width: 600px) {
    .login-box { padding: 24px 6vw 24px 6vw; }
    .admin-logo { width: 48px; height: 48px; }
}
    </style>
</head>
<body>
    <div class="luxury-bg"></div>
    <div class="gold-overlay"></div>
    <div class="login-box">
        <div class="logo-wrap">
            <img src="LGO.png" alt="Admin Logo" class="admin-logo">
        </div>
        <h2>Admin Access</h2>
        <div class="gold-divider"></div>
        <?php if (isset($error)) echo "<div class='error'>$error</div>"; ?>
        <form method="POST" autocomplete="off">
            <div class="input-group">
                <input type="text" name="username" placeholder="Username" required autofocus>
            </div>
            <div class="input-group">
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <button type="submit" class="gold-btn">Login</button>
        </form>
    </div>
</body>
</html>