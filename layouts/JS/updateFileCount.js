function updateFileCount() {
    const input = document.getElementById('totalImages');
    const label = document.querySelector('label[for="totalImages"]');
    const fileCount = input.files.length;
    if (fileCount == 1) {
        label.textContent = 'Seleccionada ' + fileCount + ' Imagen';
    } else {
        label.textContent = 'Seleccionada ' + fileCount + ' Imágenes';
    }
}