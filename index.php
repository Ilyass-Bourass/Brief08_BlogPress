<?php
    include "signin.php";
?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <title>Afficher les Données</title>
    <script src="index.js" defer></script>
</head>
<body>

    <header>
        <nav>
            <div class="logo">
                <img src="logo.svg" alt="Logo de l'entreprise">
            </div>
            
            <ul>
                
                <?php
                    if(isset($_SESSION["autoriser"]) && $_SESSION["autoriser"]==="oui"){
                        echo "<li><a href='index.php'>Accueil</a></li>";
                        echo "<li><a href='dashbordAuteur.php'>MonEspace</a></li>";
                        echo "<li><a href='Deconnexion.php' id='btnConnexion'>Deconnexion</a></li>";
                    }else{
                        echo "<li><a href='index.php'>Accueil</a></li>";
                        echo "<li><a href='#signup' id='btnInscriptionAutuer'>Inscription</a></li>";
                        echo "<li><a href='#signin' id='btnConnexion'>Connexion</a></li>";
                    }
                ?>   
            </ul>
        </nav>
    </header>
    
    

    <section id="form-section">
        <div class="form-container">
            <div class="icondispalyFormulaire">
                <i class="fas fa-times"></i>
            </div>
        
            <h1>Créer un Auteur</h1>
            <form action="signup.php" method="POST">
                <!-- Champ Nom d'utilisateur -->
                <label for="username">Nom</label>
                <input type="text" id="username" name="username" maxlength="50" placeholder="Entrez votre nom d'utilisateur" required>
                
                <!-- Champ Email -->
                <label for="email-inscription">Email :</label>
                <input type="email" id="email-inscription" name="email" placeholder="Entrez votre email" required>
                
               
                <label for="password-inscription">Mot de passe :</label>
                <input type="password" id="password-inscription" name="password" minlength="6" placeholder="Entrez votre mot de passe" required>
                
            
                <button type="submit">Créer</button>
            </form>
        </div>
    </section>

    <section id="section_connexion">
        <div class="form-container form_connexion">
            <div class="icondispalyFormulaire">
                <i class="fas fa-times"></i>
            </div>
        
            <h1>Connexion</h1>
            <form action="index.php" method="POST">
                
                <label for="email-connexion">Email :</label>
                <input type="email" id="email-connexion" name="email" placeholder="Entrez votre email" required>
                
               
                <label for="password-connexion">Mot de passe :</label>
                <input type="password" id="password-connexion" name="password" minlength="6" placeholder="Entrez votre mot de passe" required>
                
               
                <button type="submit" name="connexion">Connexion</button>

            </form>
        </div>
    </section>

    <?php
    
    if (isset($error_message)) {
        echo "<p style='color: red;'>$error_message</p>";
    }
    ?>

    <div class="title">
        <h1>La liste des articles de notre application</h1>
    </div>
    
 <section id="blogs">

 <?php
include 'connexion.php';

$requette = "SELECT ar.Article_id,ar.titre , ar.Date_creation_article,ar.Contenu,sta.vues,sta.nombre_jaime from article ar join statistiques sta 
on ar.Article_id=sta.Article_id ORDER BY sta.vues DESC;";
$query = mysqli_query($conn, $requette);

if ($query) {
    if (mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_assoc($query)) {
            echo "<div class='blog'>";

            echo "<img src='logo.svg' alt='Image du blog'>";
            echo "<div class='TitleDate'>";
            echo "<h2><a href='article.php?idArticle=" . $row['Article_id'] . "'>" . $row['titre'] . "</a></h2>";
            echo "<p>" . $row['Date_creation_article'] . "</p> ";
            echo "</div>";
            $contenu = $row['Contenu'];
            $mots = explode(' ', $contenu);
            $contenu_coupe = implode(' ', array_slice($mots, 0, 25));
            echo "<p>" . $contenu_coupe . "...</p>";

            echo "<div class='stats'>";
            echo "<span class='views'>Vues:" . $row['vues'] . "</span>";
            echo "<span class='likes'>J'aime: " . $row['nombre_jaime'] . "</span>";
            echo "</div>";

            echo "</div>";
        }
    } else {
        echo "<p>Aucun article n'a été trouvé dans la base de données.</p>";
    }
} else {
    echo "Erreur : impossible d'exécuter la requête.";
}
?>



   
 

    <!-- <div class="blog">
        <img src="logo.svg" alt="Image du blog">
        <h2>Titre du Blog</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam non urna vitae leo volutpat euismod.</p>
        <div class="stats">
            <span class="views">Vues: 123</span>
            <span class="likes">J'aime: 45</span>
        </div>
    </div> -->

    <!-- <div class="blog">
        <img src=logo.svg alt="Image du blog">
        <h2>Titre du Blog</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam non urna vitae leo volutpat euismod.</p>
        <div class="stats">
            <span class="views">Vues: 123</span>
            <span class="likes">J'aime: 45</span>
        </div>
    </div> -->

</section >

</body>
</html>
