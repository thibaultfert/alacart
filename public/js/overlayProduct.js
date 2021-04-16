
// Récupération de l'élément <html>
var blocCorpsPage = document.getElementById("bloc_corps_page_produits");
// Récupération du bloc dédié à la liste des prdt 
var blocProduitElt = document.getElementById("bloc_produits");  
// Récupération de la balise titre pour savoir quelle page est ouverte
var BaliseTitleElt = document.getElementById("titre_page"); 
// Récupération du bloc réservé à la popup Image produit
var overlayElt = document.getElementById('overlay');
// Récupération du bouton fermant la popup produit 
var btnClose = document.getElementById('bouton_close');
// Récupération du bloc footer de la popup 
var popupFooterElt = document.getElementById("popup_footer"); // On récupère l'élément 'image de la popup'



// Gestion évenement "click sur une image du bloc produit" -> fait apparaitre la popup image
imgProduitElt.addEventListener('click',function() {afficherFenetrePopupImage(produit, dossierImg)});

// Gestion évenements liés à la navigation dans la popup image
btnClose.addEventListener('click',closeModal); // Fermer la popup

function closeModal() {
	overlayElt.style.display='none';
	popupFooterElt.innerHTML = '';
}

function afficherComingSoonImage(imageElt) { 
    imageElt.src = "../images/image-manquante.jpg";            
    imageElt.onerror = null;           // Evite la loop si erreur à nouveau
    imageElt.style.maxWidth ="95%";	        
}

function afficherFenetrePopupImage(produit, dossierImg) {
    var popupImageElt = document.getElementById("popup_image"); // On récupère l'élément 'image de la popup'
    var txtFooterPopupElt = document.createElement("div");  // Texte partie gauche du popup_footer
    txtFooterPopupElt.className = "element_bloc_popup";

    overlayElt.style.display="block";       // L'overlay apparait par dessus la page
    popupImageElt.src = "../images/" + dossierImg + "/big-size/" + produit.images[0]; // Affichage de l'image "big size" dans la popup
    popupImageElt.style.maxHeight = "100%";           
    popupImageElt.style.maxWidth ="95%"; 

    popupImageElt.onerror = function(){afficherComingSoonImage(popupImageElt)};
    
    // Création des boutons de navigation de la popup pour choisir l'image parmis celle présentes dans le tab images[] du produit
    if (produit.images.length > 1) {
        txtFooterPopupElt.innerHTML = "Photos du produit : ";
        popupFooterElt.appendChild(txtFooterPopupElt);  
                    
        for (var i = 0; i < produit.images.length; i++) {                   
            let blocAutrePopupImageElt = document.createElement("div");     // Création d'un bouton de navigation
            blocAutrePopupImageElt.className = "bouton_popup";              // Le CSS se charge de la mise en forme sur cette class
            blocAutrePopupImageElt.id = i;                                  // L'id de l'élément = i, utile lors du click sur ce dernier
            blocAutrePopupImageElt.innerHTML = (i + 1);                     // Numéro de la photo dans le bouton
            // Au clic, l'image popup devient celle associée au bouton (pour cet affichage, image "big size")
            blocAutrePopupImageElt.addEventListener('click',function() {    
                popupImageElt.src = "../images/" + dossierImg + "/big-size/" + produit.images[blocAutrePopupImageElt.id];
                // Si Erreur lors du chgt de l'image dans la popup, on affiche un "Comming Soon"
                popupImageElt.onerror = function(){afficherComingSoonImage(popupImageElt)};
            });
            // Ajout du bouton de navigation crée précédemment
            popupFooterElt.appendChild(blocAutrePopupImageElt);
        }     
    }
};