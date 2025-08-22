<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>GRR Website</title>
  <link rel="stylesheet" href="/css/style.css">

  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background: #EEEEEE;
    }

    /* Navigation bar */
    nav.main-nav {
      padding-top: 5px;
      position: absolute;    /* sticks to top */
      width: 100%;
      z-index: 5;      /* on top of other content */
      background: transparent;
      text-align: right;
    }

    nav.main-nav a {
      text-decoration: none;
      margin: 0 10px;
      color: #DC5F00;
      font-weight: bold;
    }

    nav.main-nav a:hover {
      color: #EEEE;
    }

  </style>
</head>
<body>

  <!-- Nav bar -->
  <nav class="main-nav">
    <a href="/">Home</a>
    <a href="/info">Information</a>
    <a href="/book">Book Now</a>
    <a href="/shop">Shop</a>
    <a href="/review">Review Us</a>
  </nav>
</body>
</html>
