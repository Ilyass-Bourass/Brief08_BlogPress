<?php

include 'connexion.php';

$nom = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];


$requette = "INSERT INTO auteur (username, email, password) VALUES ('$nom', '$email', '$password')";


$query = mysqli_query($conn, $requette);


if ($query) {
    echo "<h1>Bravo, l'auteur $nom a été créé avec succès !</h1>";
} else {
    echo "Erreur : " . mysqli_error($conn); 
}

?>
