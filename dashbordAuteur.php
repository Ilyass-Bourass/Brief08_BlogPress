<?php
    session_start();
    if($_SESSION["autoriser"]!="oui"){
        header("location:index.php");
        exit();
    }
?>

<?php
    include 'connexion.php';
    if(isset($_POST['title']) && isset($_POST['content'])){
        $titre = $_POST['title'];
        $Contenu = $_POST['content'];


       $requette = "insert into article(Auteur_id,titre,Contenu) values(3,'$titre','$Contenu')";


        $query = mysqli_query($conn, $requette);


        if ($query) {
            echo "<script> alert('l'article a été ajouter avec succée')</script>";
        } else {
        echo "Erreur : " . mysqli_error($conn); 
    }
    }
    
?>

<?php
    include 'connexion.php';
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $delete = mysqli_query($conn, "DELETE FROM article WHERE Article_id = '$id'");

        
        if (!$delete) {
        
            echo "Erreur lors de la suppression : " . mysqli_error($conn);
        }
    }
?>




<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <script src="dashbordAuteur.js" defer></script>
    <title>Afficher les Données</title>
</head>
<body>
    <header>
        <nav>
            <div class="logo">
                <img src="logo.svg" alt="Logo de l'entreprise">
            </div>
            <ul>
                <li><a href='index.php'>Accueil</a></li>
                <li><a href="#" id="AjouterArtcile">AjouterArtcile</a></li>
                <li><a href="Deconnexion.php" id="btnConnexion">Déconnexion</a></li>
            </ul>

        </nav>
    </header>

    <?php
include 'connexion.php';

if (isset($_GET['id_edit'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id_edit']);
    
    
    $update = mysqli_query($conn, "SELECT * FROM article WHERE Article_id = '$id'");
    
    if ($row = mysqli_fetch_assoc($update)) {
        echo "
            <section id='form-section'>
                <div style='display:block' class='form-container formAjouterArtcile'>
                    <h1>Modifier un Article</h1>
                    <form id='article-form' action='' method='POST'>
                        <div class='form-group'>
                            <label for='title'>Titre</label>
                            <input type='text' id='title' name='title_modifier' value='" . $row['titre'] . "' required />
                        </div>
                        <div class='form-group'>
                            <label for='content'>Contenu</label>
                            <textarea id='content' name='content_modifier' rows='6' required>" . $row['Contenu']. "</textarea>
                        </div>
                        <button type='submit'>Modifier</button>
                    </form>
                </div>
            </section>
        ";
    } else {
        echo "Article introuvable.";
    }
}


if ( isset($_POST['title_modifier']) && isset($_POST['content_modifier'])) {
    $title_modifier = mysqli_real_escape_string($conn, $_POST['title_modifier']);
    $content_modifier = mysqli_real_escape_string($conn, $_POST['content_modifier']);

   
    $queryModification = "UPDATE article SET titre = '$title_modifier', Contenu = '$content_modifier' WHERE Article_id = '$id'";

    if (mysqli_query($conn, $queryModification)) {
        echo "Article mis à jour avec succès.";

        header("Location: dashbordAuteur.php");
        exit();
    } else {
        echo "Erreur lors de la mise à jour : " . mysqli_error($conn);
    }
}
?>


<section id="form-section">
  <div class="form-container formAjouterArtcile">
     <div class="icondispalyFormulaire">
                <i class="fas fa-times"></i>
    </div>
    <h1>Ajouter un Article</h1>
    <form id="article-form" action="dashbordAuteur.php" method="POST">
      <div class="form-group">
        <label for="title">Titre</label>
        <input type="text" id="title" name="title" placeholder="Entrez le titre de l'article" required />
      </div>
      <div class="form-group">
        <label for="content">Contenu</label>
        <textarea id="content" name="content" rows="6" placeholder="Entrez le contenu de l'article" required></textarea>
      </div>
      <button type="submit">Ajouter</button>
    </form>
  </div>
</section>


<div class="mainAdmin">
    <h1>Dashboard Auteur</h1>
<div class="parteRight">
    <h2>Liste des articles</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Titre</th>
                <th>Vues</th>
                <th>J'aime</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>

   
        <?php
    include 'connexion.php';

    $requette = "SELECT Article_id, titre, Date_creation_article FROM blogpress.article;";
    $query = mysqli_query($conn, $requette);

    if ($query) {
        if (mysqli_num_rows($query) > 0) {
            while ($row = mysqli_fetch_assoc($query)) {
                $Article_id=$row['Article_id'];
                echo "<tr>";
                    echo "<td>".$row['Article_id']."</td>";
                    echo "<td>".$row['titre']."</td>";
                    echo "<td>123</td>"; 
                    echo "<td>45</td>"; 
                    echo "<td>".$row['Date_creation_article']."</td>";
                    echo "<td>";
                        
                        echo "<div class='action-buttons'>";
                            echo "<button class='btn-edit'onclick=window.location.href='dashbordAuteur.php?id_edit=$Article_id'>Modifier</button>";
                            echo "<button class='btn-delete' onclick=window.location.href='dashbordAuteur.php?id=$Article_id'>Delete</button>";
                        echo "</div>";
                    echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<p>Aucun article n'a été trouvé dans la base de données.</p>";
        }
    } else {
        echo "Erreur : impossible d'exécuter la requête.";
    }
?>

        </tbody>
    </table>
</div>

</div>

</body>
</html>

<?php

?>

