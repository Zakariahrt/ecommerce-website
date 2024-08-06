<html>
    <head>
        <link href="https://fonts.googleapis.com/css?family=Work+Sans:400,800" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet">
        <link rel="stylesheet" href="index.css">
                <link rel="stylesheet" href="index2.css">

    </head>
    <body>
        <div class="primary-nav">

            <button href="#" class="hamburger open-panel nav-toggle">
        <span class="screen-reader-text">Menu</span>
        </button>
        
            <nav role="navigation" class="menu">
        
                <a href="#" class="logotype">FSR<span>Shoes</span></a>
        
                <div class="overflow-container">
        
                    <ul>
						<li><a href="index.php">Accueil</a><span class="icon"><i class="fa fa-home"></i></span></li>
						
						<?php
							session_start();
							if (!isset($_SESSION['user_type'])) {
								echo '<li><a href="signin.php">S\'identifier</a><span class="icon"><i class="fa fa-sign-in"></i></span></li>';
								echo '<li><a href="signup.php">S\'inscrire</a><span class="icon"><i class="fa fa-user-plus"></i></span></li>';
							}else if (isset($_SESSION['user_type']) && $_SESSION['user_type'] === 'admin') {
								echo '<li><a href="#">Connecter ' . $_SESSION['username'] . '</a><span class="icon"><i class="fa fa-user-circle"></i></span></li>';								
								echo '<li><a href="admin_clients.php">Gestion des clients</a><span class="icon"><i class="fa fa-users"></i></span></li>';
								echo '<li><a href="admin_products.php">Gestion des produits</a><span class="icon"><i class="fa fa-lock"></i></span></li>';
								echo '<li><a href="products.php">Produits</a><span class="icon"><i class="fa fa-shopping-cart"></i></span></li>';
								echo '<li><a href="signout.php">Déconnexion</a><span class="icon"><i class="fa fa-sign-out"></i></span></li>';
							}else {
								echo '<li><a href="#">Connecter ' . $_SESSION['username'] . '</a><span class="icon"><i class="fa fa-user-circle"></i></span></li>';
								echo '<li><a href="products.php">Produits</a><span class="icon"><i class="fa fa-shopping-cart"></i></span></li>';
								echo '<li><a href="signout.php">Déconnexion</a><span class="icon"><i class="fa fa-sign-out"></i></span></li>';
							}							
						?>

					</ul>
        
                </div>
        
            </nav>
        
        </div>
        
        <div class="new-wrapper">

            <div class="hero-section">
  <div class="hero-content">
    <h1>FSR SHOES</h1>
    <p>Welcome, friend!</p>

  </div>
</div>

        </div>
        <script src="index.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    </body>

</html>