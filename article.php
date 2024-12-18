


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
           <!-- jai un prblem ici avec le code php   -->
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

    <section id="article-content">
        <div class="article-left">
            <!-- Contenu de l'article -->
            <div class="article-card">
            <?php
                include 'connexion.php';

                if(isset($_GET['idArticle'])){
                    $id_article=$_GET['idArticle'];
                    $query = mysqli_query($conn, "SELECT art.titre, art.Contenu, sta.vues, sta.nombre_jaime 
                    FROM blogpress.article art 
                    JOIN statistiques sta 
                    ON art.Article_id = sta.Article_id 
                    WHERE art.Article_id = '$id_article'");

                    $row =mysqli_fetch_assoc($query);
                    if($row){
                            echo "
                            <h2>".$row['titre']."</h2>
                            <p class='article-content'>".$row['Contenu']."</p>
                            <div class='article-stats'>
                            <span>Vue :".$row['vues']."</span>
                            <span>Jaime :".$row['nombre_jaime']."</span>
                            <button class='like-button'>J'aime</button>
                        " ;
                    }
                }
            ?>
                
                </div>
            </div>

            <!-- Zone pour ajouter un commentaire -->
            <div class="comment-section">
                <h3>Ajouter un commentaire</h3>
                <form action="commentaire.php" method="POST">
                    <input type="text" name="username" placeholder="Votre nom" required>
                    <textarea name="comment" rows="4" placeholder="Votre commentaire" required></textarea>
                    <button type="submit">Publier</button>
                </form>
            </div>
        </div>

        <div class="article-right">
            <!-- Affichage des commentaires -->
            <div class="comment-list">
                <div class="comment">
                    <div class="comment-header">
                        <img src="default-avatar.png" alt="avatar" class="comment-avatar">
                        <strong>Utilisateur 1</strong>
                    </div>
                    <p class="comment-text">Ceci est un commentaire exemple. Très intéressant !</p>
                </div>

                <div class="comment">
                    <div class="comment-header">
                        <img src="default-avatar.png" alt="avatar" class="comment-avatar">
                        <strong>Utilisateur 2</strong>
                    </div>
                    <p class="comment-text">Merci pour cet article. Très utile !</p>
                </div>
            </div>
        </div>
    </section>

    

    

    
 


</body>
</html>
