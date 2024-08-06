<html>
    <head>
        <link href="https://fonts.googleapis.com/css?family=Work+Sans:400,800" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet">
        <link rel="stylesheet" href="index.css">
		<link rel="stylesheet" href="products.css">


    </head>
    <body>
		<?php
		session_start();
		// Check if user is authenticated and is an admin
		if (!isset($_SESSION['user_type'])) {
			header('Location: signin.php');
		}

		if(isset($_POST['add-to-card'])) {

			// Get form data
			$user_id = $_SESSION['user_id'];
			$product_id = $_POST['product_id'];

			// Insert data into database
			$conn = mysqli_connect("localhost", "root", "", "shop");

			if (!$conn) {
				die("Connection failed: " . mysqli_connect_error());
			}

			$sql = "INSERT INTO paniers (user_id, product_id) VALUES ('$user_id', '$product_id')";

			if (mysqli_query($conn, $sql)) {
				echo '<script>alert("Product added to cart")</script>';
			} else {
				echo "Error: " . $sql . "<br>" . mysqli_error($conn);
			}

			mysqli_close($conn);
			
		}
			// Redirect the user to the panier page
		if (isset($_POST['proceed-to-payment']) && $_POST['proceed-to-payment'] === 'true') {
			// Redirect the user to the payment page
			header("Location: panier.php");
			exit();
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
        <div class="new-wrapper">
			<div class="rubrique" style="width:150%; margin-left:295px">	
				<form method="get" action="?sort">
				  <input type="text" name="search" value="<?php if (isset($_GET['search'])){$search=htmlspecialchars($_GET['search']);echo $search;}?>"placeholder="Recherche...">
				  <select name="sort">
					<option value="">Trier par</option>
					<option value="price_asc">Prix croissant</option>
					<option value="price_desc">Prix décroissant</option>
					<option value="name_asc">Nom croissant</option>
					<option value="name_desc">Nom décroissant</option>
				  </select>
				  <button type="submit" name="search_ctg">Rechercher</button>
				</form>
			</div>	
			<?php
				$conn = mysqli_connect('localhost', 'root', '', 'shop');
				if (!$conn) {
					die('Database connection error: ' . mysqli_connect_error());
				}
				// get products from database				
				if (isset($_GET['search'])) {
				  $search = preg_replace("/[^a-zA-Z0-9.]/", "", $_GET['search']);
				  $search = mysqli_real_escape_string($conn, $_GET['search']);
				  $sort = "";
				  if (isset($_GET['sort'])) {
					switch($_GET['sort']) {
					  case 'price_asc':
						$sort = " ORDER BY price ASC";
						break;
					  case 'price_desc':
						$sort = " ORDER BY price DESC";
						break;
					  case 'name_asc':
						$sort = " ORDER BY name ASC";
						break;
					  case 'name_desc':
						$sort = " ORDER BY name DESC";
						break;
					  default:
						$sort = "";
					}
				  }
				  $sql = "SELECT * FROM produit WHERE name LIKE '%$search%' OR price LIKE '%$search%' OR categorie LIKE '%$search%' OR description LIKE '%$search%'$sort";
				} else if (isset($_GET['sort'])) {
				  switch($_GET['sort']) {
					case 'price_asc':
					  $sql = "SELECT * FROM produit ORDER BY price ASC";
					  break;
					case 'price_desc':
					  $sql = "SELECT * FROM produit ORDER BY price DESC";
					  break;
					case 'name_asc':
					  $sql = "SELECT * FROM produit ORDER BY name ASC";
					  break;
					case 'name_desc':
					  $sql = "SELECT * FROM produit ORDER BY name DESC";
					  break;
					default:
					  $sql = "SELECT * FROM produit";
				  }
				} else {
				  $sql = "SELECT * FROM produit";
				}
				// display products
				$result = mysqli_query($conn, $sql);
				if (!$result) {
					die('Database query error: ' . mysqli_error($conn));
				}
				while ($row = mysqli_fetch_assoc($result)) {
					echo '<div class="product">';
					echo '<img src="img/product' . $row['id'] . '.png" alt="Product Image">';
					echo '<div class="product-info">';
					echo '<h2>' . $row['name'] . '</h2>';
					echo '<p>' . $row['description'] . '</p>';
					echo '<p class="price">' . number_format($row['price'], 0 , ".", " ") . ' DH' . '</p>';
					echo '<form method="post"><input type="hidden" name="product_id" value="' . $row['id'] . '"><button name="add-to-card" type="submit">Ajouter au panier</button></form>';
					echo '</div>';
					echo '</div>';
				}		
				
			?>

			<div class="proceed-to-payment" style="width:150%;margin-right:400px">
				<center><form method="post"><input type="hidden" name="proceed-to-payment" value="true"><button type="submit">Voir votre panier</button></form></center>
			</div>
		</div>
		
        <?php
            //Recherche par categorie
			if (isset($_GET['search_ctg'])) {
				$Cat =htmlspecialchars($_GET['search']);
			
				// Requête SQL pour récupérer les produits de la catégorie spécifiée
				$sql = "SELECT * FROM produit WHERE categorie LIKE '%$Cat%'";
				$result = mysqli_query($conn, $sql);
			
				if (!$result) {
					die('Database query error: ' . mysqli_error($conn));
				}
			
				// Affichage des résultats
				/*while ($row = mysqli_fetch_assoc($result)) {
					echo '<div class="product">';
					echo '<img src="img/product' . $row['id'] . '.png" alt="Product Image">';
					echo '<div class="product-info">';
					echo '<h2>' . $row['name'] . '</h2>';
					echo '<p>' . $row['description'] . '</p>';
					echo '<p class="price">' . number_format($row['price'], 0 , ".", " ") . ' DH' . '</p>';
					echo '<form method="post"><input type="hidden" name="product_id" value="' . $row['id'] . '"><button name="add-to-card" type="submit">Ajouter au panier</button></form>';
					echo '</div>';
					echo '</div>';
				}*/
			}
			mysqli_close($conn);
            ?>
			
        <script src="index.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    </body>

</html>