document.addEventListener("DOMContentLoaded",()=>{

    const icondispalyFormulaireAjouterAuteur=document.querySelector(".icondispalyFormulaire");
    const formulaireAjouterAuteur=document.querySelector(".form-container");
    const btnInscriptionAutuer=document.querySelector("#btnInscriptionAutuer");

    const formulaireConnexon=document.querySelector("#section_connexion .form_connexion");
    const icondispalyFormulaireConnexion=document.querySelector("#section_connexion .icondispalyFormulaire");
    const btnConnexion=document.querySelector("#btnConnexion");
    
    
    if(btnInscriptionAutuer){
        btnInscriptionAutuer.addEventListener("click",()=>{
        formulaireConnexon.style.display="none";
        formulaireAjouterAuteur.style.display="block";
    });
    }
    
    if(icondispalyFormulaireAjouterAuteur){
        icondispalyFormulaireAjouterAuteur.addEventListener("click",()=>{
        formulaireAjouterAuteur.style.display="none";
    });
    }
    
    
    btnConnexion.addEventListener("click",()=>{
        formulaireAjouterAuteur.style.display="none";
        formulaireConnexon.style.display="block";
    });

    if(icondispalyFormulaireConnexion){
        icondispalyFormulaireConnexion.addEventListener("click",()=>{
        formulaireConnexon.style.display="none";
    });
    }
    

})

