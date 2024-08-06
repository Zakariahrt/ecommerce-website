<html>
    <head>
        <link href="https://fonts.googleapis.com/css?family=Work+Sans:400,800" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet">
        <link rel="stylesheet" href="index.css">
		<link rel="stylesheet" href="login.css">
    </head>
    <body>
	<?php

		// Start session
		session_start();
		// Check if form is submitted
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			// Get username and password from form
			$username = $_POST['username'];
			$password = $_POST['password'];

			// Connect to MySQL database
			$conn = mysqli_connect('localhost', 'root', '', 'shop');

			// Check if connection was successful
			if (!$conn) {
				die('Connection failed: ' . mysqli_connect_error());
			}

			// Prepare SQL statement to select user from database
			$password = md5($password);
			$sql = "SELECT id,type,username FROM users WHERE username = '$username' AND password = '$password'";

			// Execute SQL statement
			$result = mysqli_query($conn, $sql);
			if (!$result) {
				// Error occurred while executing SQL statement
				$_SESSION['error'] = 'Invalid username or password.';
			}else {
				// Check if user was found in database
				if (mysqli_num_rows($result) === 1) {
					// User is authenticated, set session variables
					$user = mysqli_fetch_assoc($result);
					$_SESSION['user_id'] = $user['id'];
					$_SESSION['user_type'] = $user['type'];
					$_SESSION['username'] = $user['username'];
					// Redirect user to appropriate page based on user type
					if ($user['type'] === 'admin') {
						header('Location: admin_clients.php');
					} else {
						header('Location: products.php');
					}
				} else {
					// Authentication failed, display error message
					$_SESSION['error'] = 'Invalid username or password.';
				}
			}
			// Close database connection
			mysqli_close($conn);	
		}
	?>	
        <div class="primary-nav">

            <button href="#" class="hamburger open-panel nav-toggle">
        <span class="screen-reader-text">Menu</span>
        </button>
        
            <nav role="navigation" class="menu">
        
                <a href="#" class="logotype">FSR<span>SHOES</span></a>
        
                <div class="overflow-container">
        
                    <ul>
						<li><a href="index.php">Accueil</a><span class="icon"><i class="fa fa-home"></i></span></li>
						
						<?php
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
        <div class="new-wrapper" >
			<div class="container">
				<div class="info">
					<h1>Authentification</h1>
				</div>
				<div class="form">
				<?php
					if (isset($_SESSION['error'])) {
						echo '<p class="error-message">' . $_SESSION['error'] . '</p>';
						unset($_SESSION['error']);
					}
				?>				
					<div class="thumbnail"><i class="fa fa-user-circle"></i></div>
					<form method="post" class="login-form">
						<input type="text" name="username" placeholder="username">
						<input type="password" name="password" placeholder="password">
						<button type="submit">se connecter</button>
						<p class="message">Pas encore inscrit? <a href="signup.php">Creer un compte</a></p>
					</form>
				</div>
			</div>	
        </div>
        <script src="index.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    </body>

</html>