window.onload = function() {
    const loader = document.getElementById('icon-load');
    loader.style.opacity = 0;

    setTimeout(function() {
        loader.style.display = 'none';
    }, 100);

    // clear images selected
    var input = document.getElementById('totalImages');
    input.value = '';
};