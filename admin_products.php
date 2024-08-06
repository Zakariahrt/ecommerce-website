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

				// Ajouter un produit
				if (isset($_POST['ajouter'])) {
					$name = $_POST['name'];
					$price = $_POST['price'];
					$description = $_POST['description'];
					$categorie=$_POST['categorie'];
					$sql = "INSERT INTO produit (name, price, description,categorie) VALUES ('$name', '$price','$description','$categorie')";
					if (mysqli_query($conn, $sql)) {
						echo "<script>alert('Produit ajouté avec succès.')</script>";
					} else {
						echo "Erreur: " . mysqli_error($conn);
					}
				}

				// Mettre à jour un produit
				if (isset($_POST['update'])) {
					$id = $_POST['id'];
					$name = $_POST['name'];
					$price = $_POST['price'];
					$description = $_POST['description'];					
					$sql = "UPDATE produit SET name='$name', price='$price',description='$description' WHERE id=$id";
					if (mysqli_query($conn, $sql)) {
						echo "<script>alert('Produit mis à jour avec succès.')</script>";
					} else {
						echo "Erreur: " . mysqli_error($conn);
					}
				}

				// Supprimer un produit
				if (isset($_POST['delete'])) {
					$id = $_POST['id'];
					$sql = "DELETE FROM produit WHERE id=$id";
					if (mysqli_query($conn, $sql)) {
						echo "<script>alert('Produit supprimé avec succès.')</script>";
					} else {
						echo "Erreur: " . mysqli_error($conn);
					}
				}

				// Fermer la connexion à la base de données
				mysqli_close($conn);
			?>	
			<center>			
				<p style="font-size: 30pt; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; color: black; border: none;padding: 0.5em 1em; margin-right:200px;margin-left:200px;">
					Gestion des produits
				</p>
			</center>

			<div class="container">
				<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
					<h2 style="font-size: 25pt">Ajouter un produit</h2>
					<table style="border: none;">
						<tr>
							<td><label for="name">Nom du produit:</label></td>
							<td><input type="text" id="name" name="name" required></td>
						</tr>
						<tr>
							<td><label for="price">Description du produit: </label></td>
							<td><input type="text" id="description" name="description" required></td>
						</tr>
						<tr>
							<td><label for="price">Prix du produit:</label></td>
							<td><input type="number" id="price" name="price" min="0" step="0.01" required></td>
						</tr>
						<tr>
							<td><label for="price">Categorie du produit:</label></td>
							<td><input type="text" id="categorie" name="categorie" min="0" step="0.01" required></td>
						</tr>						
						<tr>
							<td></td>
							<td><input type="submit" name="ajouter" value="Ajouter"></td>
						</tr>
					</table>
				</form>

				<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
					<h2 style="font-size: 25pt">Mettre à jour un produit</h2>
					<table style="border: none;">
						<tr>
							<td><label for="id">ID du produit:</label></td>
							<td><input type="number" id="id" name="id" min="1" required></td>
						</tr>
						<tr>
							<td><label for="name">Nom du produit:</label></td>
							<td><input type="text" id="name" name="name" required></td>
						</tr>
						<tr>
							<td><label for="price">Description du produit: </label></td>
							<td><input type="text" id="description" name="description" required></td>
						</tr>						
						<tr>
							<td><label for="price">Prix du produit:</label></td>
							<td><input type="number" id="price" name="price" min="0" step="0.01" required></td>
						</tr>
						<tr>
							<td></td>
							<td><input type="submit" name="update" value="Mettre à jour"></td>
						</tr>
					</table>
				</form>

				<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
					<h2 style="font-size: 25pt">Supprimer un produit</h2>
					<table style="border: none;">
						<tr>
							<td><label for="id">ID du produit:</label></td>
							<td><input type="number" id="id" name="id" min="1" required></td>
						</tr>
						<tr>
							<td></td>
							<td><input type="submit" name="delete" value="Supprimer"></td>
						</tr>
					</table>
				</form>

			</div>
		</div>
		<script src="index.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	</body>

</html>