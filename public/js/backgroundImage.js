var centralBlocElt = document.getElementById("central_bloc");
var pageTitleElt = document.getElementById("page_title");
var titleContent = pageTitleElt.innerHTML;

// Suppression des espacements début et fin de chaîne
titleContent = titleContent.trim();
console.log(titleContent);

switch (titleContent){
    case 'Alacart\' - Vins et Gourmandises':
    centralBlocElt.style.backgroundImage = "url('../images/home.jpg')";
    break;
    case 'Vins Rouges':
    centralBlocElt.style.backgroundImage = "url('../images/red_wine.jpg')";
    break;
    case 'Vins Blancs':
    centralBlocElt.style.backgroundImage = "url('../images/white_wine.jpg')";
    break;
    case 'Vins Roses':
    centralBlocElt.style.backgroundImage = "url('../images/rose_wine.jpg')";
    break;
    case 'Champagnes et Bulles':
    centralBlocElt.style.backgroundImage = "url('../images/champagne.jpg')";
    break;
    case 'Jambon Serrano':
    centralBlocElt.style.backgroundImage = "url('../images/ham.jpg')";
    break;
    case 'Foies Gras et Terrines':
    centralBlocElt.style.backgroundImage = "url('../images/foie_gras.jpg')";
    break;
    case 'Huiles':
    centralBlocElt.style.backgroundImage = "url('../images/oil.jpg')";
    break;  
    default:
    console.error('Aucun marque page reconnu');
}
