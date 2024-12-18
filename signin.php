<?php
include 'connexion.php';
session_start();
    echo " <script>
        document.addEventListener('DOMContentLoaded',()=>{
        const formulaireConnexon=document.querySelector('#section_connexion .form_connexion');
        formulaireConnexon.style.display='none';



});
    </script>" ;



if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $requette = "SELECT * FROM auteur WHERE email = '$email' and password='$password'";
    $query = mysqli_query($conn, $requette);
    $row=mysqli_fetch_assoc($query);
    if ($query) {
        if (mysqli_num_rows($query) > 0) {
                $_SESSION["autoriser"]="oui";
                $_SESSION["id_auteur"]=$row['Auteur_id']; 
                header('Location:dashbordAuteur.php');
                exit();
        } else {
            echo "<script>";
            echo "alert('Email ou mot de passe incorrect');";
            echo "window.location.href='index.php';";
            echo "</script>";   
        }
    } else {
        $error_message = "Erreur dans la requête : " . mysqli_error($conn);
    }
} 
?>
