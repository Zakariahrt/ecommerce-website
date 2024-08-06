<html>
    <head>
        <link href="https://fonts.googleapis.com/css?family=Work+Sans:400,800" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet">
        <link rel="stylesheet" href="index.css">
		<link rel="stylesheet" href="products.css">
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
			<form method="post">
				<div class="cart-header">
				  <span class="fa fa-shopping-cart"></span> Votre panier
				</div>

				<table>
					<tr>
						<th>image</th>
						<th>Nom</th>
						<th>Prix</th>
						<th>Action</th>
					</tr>
					<?php
					if (isset($_SESSION['user_id'])) {
						$user_id = $_SESSION['user_id'];
					} else {
						header("Location: signin.php");
					}

					$conn = mysqli_connect("localhost", "root", "", "shop");

					if (!$conn) {
						die("Connection failed: " . mysqli_connect_error());
					}

					if (isset($_POST['remove'])) {
						$remove_id = $_POST['remove'];
						$sql = "DELETE FROM paniers WHERE user_id = $user_id AND product_id = $remove_id";
						if (!mysqli_query($conn, $sql)) {
							echo "Error: " . $sql . "<br>" . mysqli_error($conn);
						}
					}

					$sql = "SELECT produit.id, produit.name, produit.price
					FROM paniers
					INNER JOIN produit ON paniers.product_id = produit.id
					WHERE paniers.user_id = $user_id";

					$result = mysqli_query($conn, $sql);

					while ($row = mysqli_fetch_assoc($result)) {
						echo '<tr>';
						echo '<td><img src="img/product' . $row['id'] . '.png" alt="' . $row['name'] . '"></td>'; 
						echo '<td>' . $row['name'] . '</td>';
						echo '<td>' . $row['price'] . " DH" . '</td>';
						echo '<td><button class="remove-button" type="submit" name="remove" value="' . $row['id'] . '">Retirer</button></td>';
						echo '</tr>';
					}

					mysqli_close($conn);
					?>
				</table>
				<input type="submit" name="pay" value="Acheter">
			</form>
		</div>
		<style>
			.new-wrapper{
				margin-left:100px
			}
			table, form {
			  border-collapse: collapse;
			  width: 100%;
			  max-width: 800px;
			  margin: 20px auto;
			}

			th, td {
			  text-align: left;
			  padding: 8px;
			}

			th {
			  background-color: #f2f2f2;
			}

			tr:nth-child(even) {
			  background-color: #f2f2f2;
			}

			tr:hover {
			  background-color: #ddd;
			}

			td:last-child {
			  text-align: right;
			}

			.total {
			  text-align: right;
			  font-weight: bold;
			  margin-top: 20px;
			}

			form {
			  box-shadow: none;
			  padding: 0;
			}

			label {
			  display: block;
			  margin-bottom: 10px;
			  font-weight: bold;
			  font-size: 16px;
			}

			input[type="text"],
			input[type="email"],
			input[type="tel"],
			input[type="number"],
			input[type="submit"] {
			  width: 100%;
			  padding: 10px;
			  margin-bottom: 20px;
			  border: none;
			  border-radius: 5px;
			  box-shadow: inset 0px 0px 5px rgba(0, 0, 0, 0.2);
			  font-size: 16px;
			  outline: none;
			}

			input[type="submit"] {
			  background-color: black;
			  color: white;
			  cursor: pointer;
			  transition: background-color 0.3s ease-in-out;
			}

			input[type="submit"]:hover {
			  background-color: gray;
			}
			.remove-button {
			  background-color: gray;
			  color: #fff;
			  border: none;
			  border-radius: 5px;
			  padding: 5px 10px;
			  cursor: pointer;
			  display: block;
			  margin-left: auto;
			}
			.remove-button:hover {
				background-color:black;
			}
			.cart-header {
			  display: flex;
			  align-items: center;
			  justify-content: center;
			  background-color: #dfdfdf;
			  color: #1c1c1c;
			  font-size: 24px;
			  font-weight: bold;
			  padding: 10px;
			}

			.cart-header .fa {
			  margin-right: 10px;
			}
			td img {
				width:25%;
			}
		</style>
	</body>
</html>	