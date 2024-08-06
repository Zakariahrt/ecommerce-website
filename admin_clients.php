<html>
	<?php
		session_start();
		// Check if user is authenticated and is an admin
		if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
			http_response_code(401);
			echo '
			<head>
			<title>Unauthorized Access</title>
			</head>
			<body>
			<h1>Unauthorized Access</h1>
			<p>You are not authorized to access this page.</p>
			</body>';
			exit();
		}	
	?>
    <head>
        <link href="https://fonts.googleapis.com/css?family=Work+Sans:400,800" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet">
		<title>Administration</title>
		<link rel="stylesheet" href="index.css">
		<link rel="stylesheet" href="admin.css">
    </head>
    <body>
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
		<div class="new-wrapper">
			<?php
				// Connexion à la base de données
				$conn = mysqli_connect('localhost', 'root', '', 'shop');
				if (!$conn) {
					die("Connection failed: " . mysqli_connect_error());
				}

				// Ajouter un client
				if (isset($_POST['ajouter'])) {
					$email = $_POST['email'];
					if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
						$_SESSION['error'] = "Invalid email address";
					} else {					
						$username = $_POST['username'];
						$password = md5($_POST['password']);
						$type = $_POST['type'];
						$sql = "INSERT INTO users (email, username, password, type) VALUES ('$email', '$username', '$password','$type')";
						if (mysqli_query($conn, $sql)) {
							echo "<script>alert('Client ajouté avec succès.')</script>";
						} else {
							echo "Erreur: " . mysqli_error($conn);
						}
					}
				}

				// Mettre à jour un client
				if (isset($_POST['update'])) {
					$email = $_POST['email'];
					if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
						$_SESSION['error'] = "Invalid email address";
					} else {					
						$username = $_POST['username'];
						$password = md5($_POST['password']);
						$type = $_POST['type'];
						$sql = "UPDATE produit SET email='$email', name='$username', password='$password',type='$type' WHERE id=$id";
						if (mysqli_query($conn, $sql)) {
							echo "<script>alert('Client mis à jour avec succès.')</script>";
						} else {
							echo "Erreur: " . mysqli_error($conn);
						}
					}
				}			
				// Supprimer un produit
				if (isset($_POST['delete'])) {
					$id = $_POST['id'];
					$sql = "DELETE FROM users WHERE id=$id";
					if (mysqli_query($conn, $sql)) {
						echo "<script>alert('Client supprimé avec succès.')</script>";
					} else {
						echo "Erreur: " . mysqli_error($conn);
					}
				}

				// Fermer la connexion à la base de données
				mysqli_close($conn);
			?>	
			<center>			
				<p style="font-size: 30pt; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; color: black; border: none;padding: 0.5em 1em; margin-right:200px;margin-left:200px;">
					Gestion des clients
				</p>
			</center>

			<div class="container">
				<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
					<h2 style="font-size: 25pt">Ajouter un client</h2>
					<table style="border: none;">
						<tr>
							<td><label for="name">Email : </label></td>
							<td><input type="text" id="email" name="email" required></td>
						</tr>
						<tr>
							<td><label for="name">Username : </label></td>
							<td><input type="text" id="name" name="username" required></td>
						</tr>
						<tr>
							<td><label for="price">Password : </label></td>
							<td><input type="password" id="password" name="password" required></td>
						</tr>
						<tr>
							<td><label for="price">Type : </label></td>
							<td><select id="type" name="type" required><option value="admin">Admin</option><option value="user">User</option></select></td>
						</tr>						
						<tr>
							<td></td>
							<td><input type="submit" name="ajouter" value="Ajouter"></td>
						</tr>
					</table>				
				</form>

				<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
					<h2 style="font-size: 25pt">Mettre à jour un client</h2>
					<table style="border: none;">
						<tr>
							<td><label for="id">ID du client:</label></td>
							<td><input type="number" id="id" name="id" min="1" required></td>
						</tr>
						<tr>
							<td><label for="name">Email : </label></td>
							<td><input type="text" id="email" name="email" required></td>
						</tr>
						<tr>
							<td><label for="name">Username : </label></td>
							<td><input type="text" id="name" name="username" required></td>
						</tr>
						<tr>
							<td><label for="price">Password : </label></td>
							<td><input type="password" id="password" name="password" required></td>
						</tr>
						<tr>
							<td><label for="price">Type : </label></td>
							<td><select id="type" name="type" required><option value="admin">Admin</option><option value="user">User</option></select></td>
						</tr>						
						<tr>
							<td></td>
							<td><input type="submit" name="update" value="Mettre à jour"></td>
						</tr>
					</table>
				</form>

				<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
					<h2 style="font-size: 25pt">Supprimer un client</h2>
					<table style="border: none;">
						<tr>
							<td><label for="id">ID du client:</label></td>
							<td><input type="number" id="id" name="id" min="1" required></td>
						</tr>
						<tr>
							<td></td>
							<td><input type="submit" name="delete" value="Supprimer"></td>
						</tr>
					</table>
				</form>
				<?php
					if (isset($_SESSION['error'])) {
						echo '<script>alert("' . $_SESSION['error'] . '")</script>';
						unset($_SESSION['error']);
					}				
				?>
			</div>
		</div>
		<script src="index.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	</body>

</html>