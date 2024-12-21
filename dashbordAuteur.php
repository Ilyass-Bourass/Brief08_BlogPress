<?php
    session_start();
    if($_SESSION["autoriser"]!="oui"){
        echo "bonjour";
        var_dump($_SESSION); 
        echo $_SESSION["id_auteur"]; 
        header("location:index.php");
        exit();
    }
?>

<?php
    include 'connexion.php';
    if(isset($_POST['title']) && isset($_POST['content'])){
        $titre = $_POST['title'];
        $Contenu = $_POST['content'];
        $id_auteur=$_SESSION["id_auteur"];

       $requette = "insert into article(Auteur_id,titre,Contenu) values($id_auteur,'$titre','$Contenu')";
       $query = mysqli_query($conn, $requette);
       $Article_id = (int)mysqli_insert_id($conn);

       $queryStatistique = mysqli_query($conn, "INSERT INTO statistiques (Article_id, vues, nombre_commentaire, nombre_jaime) 
                                         VALUES ('$Article_id', 0, 0, 0);");



        if ($query && $queryStatistique) {
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
        $deletecommentaire=mysqli_query($conn, "DELETE FROM commentaire WHERE Article_id = '$id';");
        $deleteStatistiqueArtcile=mysqli_query($conn, "DELETE FROM statistiques WHERE Article_id = '$id';");
        $delete = mysqli_query($conn, "DELETE FROM article WHERE Article_id = '$id';");

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
                <li><a href="#" id="AjouterArtcile">AjouterArtcle</a></li>
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
    $id_auteur=$_SESSION["id_auteur"];
    $requette = "SELECT ar.Article_id,ar.titre , ar.Date_creation_article,ar.Contenu,sta.vues,sta.nombre_jaime from article ar join statistiques sta 
on ar.Article_id=sta.Article_id WHERE ar.Auteur_id=$id_auteur;";
    $query = mysqli_query($conn, $requette);
    $titres=[];
    $VuesTitre=[];
    $nombreJaime=[];
    if ($query) {
        if (mysqli_num_rows($query) > 0) {
            while ($row = mysqli_fetch_assoc($query)) {
                $Article_id=$row['Article_id'];
                echo "<tr>";
                    echo "<td>".$row['Article_id']."</td>";
                    echo "<td>".$row['titre']."</td>";
                    echo "<td>".$row['vues']."</td>"; 
                    echo "<td>".$row['nombre_jaime']."</td>"; 
                    echo "<td>".$row['Date_creation_article']."</td>";
                    echo "<td>";
                        
                        echo "<div class='action-buttons'>";
                            echo "<button class='btn-edit'onclick=window.location.href='dashbordAuteur.php?id_edit=$Article_id'>Modifier</button>";
                            echo "<button class='btn-delete' onclick=window.location.href='dashbordAuteur.php?id=$Article_id'>Delete</button>";
                        echo "</div>";
                    echo "</td>";
                echo "</tr>";
                $titres[]=$row['titre'];
                $VuesTitre[]=$row['vues'];
                $nombreJaime[]=$row['nombre_jaime'];
            }
        } else {
            echo "<p>Aucun article de vous n'a été trouvé dans la base de données.</p>";
        }
    } else {
        echo "Erreur : impossible d'exécuter la requête.";
    }
    $jsonTitres = json_encode($titres);
    $jsonVuesTitres = json_encode($VuesTitre);
    $nombreJaime = json_encode( $nombreJaime);
?>

        </tbody>
    </table>
</div>

</div>
<div class="containerStatistiqueChart">
    <h1>les statisques de votre articles avec des graphes</h1>
    <div class="statistiqueChart">
        <div id="vues">
            <canvas id="espaceVues"></canvas>
        </div>
        <div style="margin-top:100px" id="jaimes">
         <canvas id="espacejaimes"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  const ctx = document.getElementById('espaceVues');
  var titres = <?php echo $jsonTitres; ?>;
  var VuesTitres= <?php echo $jsonVuesTitres; ?>;
  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: titres,
      datasets: [{
        label: '# les statisituques vues',
        data: VuesTitres,
        borderWidth: 1
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true,
          title : {
            display:true,
            text:'Nombre de vues',
            font : {
                    size:16,
                    weight:'bold'
                },
             color: 'green'
          }
        },
        x:{
            title :{
                display:true,
                text:'Titres des articles',
                font : {
                    size:16,
                    weight:'bold'
                },
                color: 'red'
            }
        }
      }
    }
  });
</script>


<script>
  const ctx1 = document.getElementById('espacejaimes');
  var titres = <?php echo $jsonTitres; ?>;
  var nombreJaime= <?php echo  $nombreJaime; ?>;
  new Chart(ctx1, {
    type: 'line',
    data: {
      labels: titres,
      datasets: [{
        label: '# les statisituques Jaimes',
        data: nombreJaime,
        borderWidth: 1,
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true,
          title : {
            display:true,
            text:'Nombre de jaimes',
            font : {
                    size:16,
                    weight:'bold'
                },
             color: 'green'
          }
        },
        x:{
            title :{
                display:true,
                text:'Titres des articles',
                font : {
                    size:16,
                    weight:'bold'
                },
                color: 'red'
            }
        }
      }
    }
  });
</script>

</body>
</html>

<?php

?>

