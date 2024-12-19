document.addEventListener("DOMContentLoaded",()=>{
    const AjouterArtcile=document.querySelector("#AjouterArtcile");
    const formAjouterArtcile=document.querySelector(".formAjouterArtcile");
    const icondispalyFormulaire=document.querySelector(".formAjouterArtcile .fa-times ");
    
    
    AjouterArtcile.onclick=function(){
        formAjouterArtcile.style.display="block";
    }

    icondispalyFormulaire.onclick=function(){
        formAjouterArtcile.style.display="none";
    }
    
})

