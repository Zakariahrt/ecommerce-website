<html>
    <head>
        <link href="https://fonts.googleapis.com/css?family=Work+Sans:400,800" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet">
        <link rel="stylesheet" href="index.css">
		<link rel="stylesheet" href="products.css">


    </head>
    <body>
<class="new-wrapper">
			<div class="rubrique" style="width:150%; margin-left:100px">	
				<form method="get" action="?sort">
				
				<input type="text" name="search_ctg" value="<?php if (isset($_GET['search_ctg'])){$search=htmlspecialchars($_GET['search_ctg']);/*echo $search;*/}?>"placeholder="Recherche par categorie...">
				  <button type="submit" name="search_ctg">Rechercher</button>
				</form>
			</div>	
</class>


        <?php
            session_start();
		// Check if user is authenticated and is an admin
		if (!isset($_SESSION['user_type'])) {
			header('Location: signin.php');
		}
            //Recherche par categorie
				if (isset($_GET['search_ctg'])) {
                $result = mysqli_query($conn, $sql);
                if (!$result) {
	            die('Database query error: ' . mysqli_error($conn));
                }
                $Cat=$_GET['search_ctg'];
                $sql="SELECT * FROM produit WHERE categorie LIKE '%$Cat%'" ;
                 $req = mysqli_query($conn,$sql) or die('Erreur SQL !<br />'.$sql.'<br />'.mysqli_error());
			}
            ?>
           </body></html>