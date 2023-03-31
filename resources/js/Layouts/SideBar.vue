<template>
    <div class="sidebar">
        <div class="logo_content">
            <div class="logo">
                <div class="logo_name"> Menú </div>
            </div>
            <i class="fa fa-bars" id="sideMenu" aria-hidden="true"></i>
        </div>
        <!-- .................................................................................................. -->
        <!-- Lista de opciones para navegación del sistema -->
        <ul class="nav_list">
            <li>
                <a href="#">
                    <i class="fa fa-user-tie" aria-hidden="true"></i>
                    <span class="routes_name"> Administración </span>
                </a>
                <span class="tooltip"> Administración </span>
            </li>
            <li>
                <a class="nav-link" href="#">
                    <i class="fa fa-bookmark" aria-hidden="true"></i>
                    <span class="routes_name"> Categoría </span>
                </a>
                <span class="tooltip"> Categoría </span>
            </li>
            <li>
                <a class="nav-link" href="#">
                    <i class="fa fa-truck" aria-hidden="true"></i>
                    <span class="routes_name"> Inventario </span>
                </a>
                <span class="tooltip"> Inventario </span>
            </li>
            <li>
                <a href="#">
                    <i class="fas fa-question-circle fa-lg"></i>
                    <span class="routes_name"> Ayuda </span>
                </a>
                <span class="tooltip"> Ayuda </span>
            </li>
        </ul>
        <!-- .................................................................................................. -->
    </div>
</template>

<script setup>
    /*Mostrar ocultar menú principal*/
    var btn = document.querySelector("#sideMenu");
    var sidebar = document.querySelector(".sidebar");
    var content = document.querySelector(".py-4");


    btn.onclick = function () {
        sidebar.classList.toggle("active");
        content.classList.toggle("active");
    }
</script>