<?php
require('layouts/PHP/head.php');
$title = 'ImageToWebp ❤';
$description = 'Proyecto de Inbydev para transformar imágenes a formato Webp!';
$otherjs = '<script defer src="/ImageToWebp/layouts/JS/app.js"></script>
<script src="/ImageToWebp/layouts/JS/maxPerRequest.js"></script>';
$othercss = '<link rel="stylesheet" href="/ImageToWebp/layouts/CSS/ImageToWebp.css">';
head($title, $description, $otherjs, $othercss);
?>
	<?php require('layouts/PHP/header.php') ?>
    <main>
        <section class="home" id="home">
            <h1>Imagen a <span>.Webp!</span></h1>
            <h2>Transforma tu imagen a formato <span>Webp!</span></h2>
        </section>

        <section class="converter__section" id="create">
            <form action="layouts/PHP/ImageToWebp.php" id="form__create__page" method="post" enctype="multipart/form-data" onsubmit="return validarFormulario()">
                <section class="form__section">
                    <label class="button_label" for="totalImages">Seleccionar Imagenes</label>
                    <input type="file" name="images[]" multiple accept="image/*" id="totalImages" maxlength="80" class="input-file" onchange="updateFileCount()">

                    <input type="submit" value="Convertir imágenes">
                </section>  
                <nav>
                    <h3>Configuraciones de las imágenes</h3>
                    <section class="nav__section">
                        <label for="slider">Nivel de compresión</label>
                        <input type="range" id="slider" name="slider" min="1" max="5" value="3">
                    </section>
                </nav>
            </form>
        </section>

        <section class="guide__section">
            <p>Convertidor de imágenes con formato:</p>
            <ul>
                <li>PNG</li>
                <li>JPG</li>
                <li>TIFF</li>
                <li>BMP</li>
            </ul>
            <p>Y pudiendo convertir 80 imágenes por vez! recuerda que cada 5 minutos se eliminan los archivos temporales! Además, existe un límite de 80MB por vez!</p>
        </section>

        <footer>
            <p>
                <a href="https://github.com/Inbydev/ImageToWebp">ImageToWebp</a> © 2024
                by
                <a href="https://github.com/Inbydev">Inbydev</a>
                is licensed under
                <a href="http://creativecommons.org/licenses/by/4.0/?ref=chooser-v1" target="_blank" style="display:inline-block;">CC BY 4.0
                </a>
            </p>
        </footer>
    </main>
    
    <script src="layouts/JS/updateFileCount.js"></script>
	<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
	<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
	<script src="layouts/JS/loader.js"></script>
</body>
</html>