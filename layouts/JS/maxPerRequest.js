function validarFormulario() {
    var totalImages = document.getElementById('totalImages').files;
    var maxPerRequest = 80;
    var useWebp = false;

    for (var i = 0; i < totalImages.length; i++) {
        var fileExtension = totalImages[i].name.split('.').pop().toLowerCase();
        if (fileExtension === 'webp') {
            useWebp = true;
            break;
        }
    }

    if (totalImages.length > maxPerRequest) {
        alert('Se ha excedido el límite máximo de 80 imágenes permitidas.');
        return false;
    }

    if (totalImages.length === 0) {
        alert('No has seleccionado ninguna imagen! Selecciona una por favor.');
        return false;
    }

    if (useWebp) {
        alert('Estás seleccionando imágenes que ya están en formato .webp! Elige otro formato de imagen por favor.');
        return false;
    }

    return true;
}