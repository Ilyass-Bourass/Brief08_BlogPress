<?php
    session_start();
    include 'connexion.php';
    if(isset($_GET['idArticle'])){
        $id_article=$_GET['idArticle'];
        $query = mysqli_query($conn, "SELECT sta.vues from statistiques sta 
                join article art 
                on sta.Article_id=art.Article_id where art.Article_id='$id_article'");

        $row =mysqli_fetch_assoc($query);
        $nombreVue=((int)$row['vues']);
        $nombreVue++;
        $queryupdatNombreVues=mysqli_query($conn,"update  statistiques set vues='$nombreVue' where Article_id='$id_article';");
    }
?>




<?php
   include 'connexion.php';
   if(isset($_POST['username']) && isset($_POST['comment'])){
    $username = $_POST['username'];
    $comment = $_POST['comment'];
    $id_article=$_POST['idArticle'] ??$_GET['idArticle'] ;


   $requette = "insert into commentaire(contenu_Commentaire,Article_id,nom_visiteur) values('$comment','$id_article',' $username')";


    $query = mysqli_query($conn, $requette);


    if ($query) {
        echo "<script> alert('l'article a été ajouter avec succée')</script>";
    } else {
    echo "Erreur : " . mysqli_error($conn); 
}
   };
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
                            <div class='reaction-buttons'>
                                <button class='like-button'>
                                    <i class='fa fa-thumbs-up'></i>
                                </button>
                                <button class='dislike-button'>
                                    <i class='fa fa-thumbs-down'></i>
                                </button>
                            </div>
                        " ;
                    }
                }
            ?>
                
                </div>
            </div>

            <!-- Zone pour ajouter un commentaire -->
            <div class="comment-section">
                <h3>Ajouter un commentaire</h3>
                <form action="article.php?idArticle=<?php echo $_GET['idArticle']; ?>" method="POST">
                    <input type="hidden" name="idArticle" value="<?php echo $_GET['idArticle']; ?>">
                    <input type="text" name="username" placeholder="Votre nom" required>
                    <textarea name="comment" rows="4" placeholder="Votre commentaire" required></textarea>
                    <button type="submit">Publier</button>
                </form>

            </div>
        </div>

        <div class="article-right">
            <!-- Affichage des commentaires -->
            <div class="comment-list">

                <?php
                    include 'connexion.php';
                    $id=$_GET['idArticle'];
                    $query = mysqli_query($conn, "SELECT * FROM commentaire WHERE Article_id =$id");
                    while($row=mysqli_fetch_assoc($query)){
                         echo "
                    <div class='comment'>
                        <div class='comment-header'>
                        <img src='default-avatar.png' alt='avatar' class='comment-avatar'>
                        <strong>".$row['nom_visiteur']."</strong>
                        <p style='padding-left:35%'>".$row['Date_creation_commentaire']."</p>
                        </div>
                        <p class='comment-text'>".$row['contenu_Commentaire']."</p>
                    </div>
                    ";
                    }
                   
                ?>

                <!-- <div class="comment">
                    <div class="comment-header">
                        <img src="default-avatar.png" alt="avatar" class="comment-avatar">
                        <strong>Utilisateur 2</strong>
                        <p style="padding-left:30%">2024-12-11</p>
                    </div>
                    <p class="comment-text">Merci pour cet article. Très utile !</p>
                </div> -->
            </div>
        </div>
    </section>

    

    

    
 


</body>
</html>
