<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="/static/img/TF.ico"/>
    <script src="https://cdn.tailwindcss.com"></script>
    <title>TF HSE</title>
</head>
<body class="bg-[#E1EEE2]">
<!-- Encabezado de la página -->
<header class="bg-white text-gray-600 body-font">
    <div class="container mx-auto flex flex-wrap p-5 flex-col md:flex-row items-center">
        <nav class="flex lg:w-2/5 flex-wrap items-center text-base md:ml-auto"></nav>
        <a href="https://tfauditores.com/" class="flex order-first lg:order-none lg:w-1/5 title-font font-medium items-center text-gray-900 lg:items-center lg:justify-center mb-4 md:mb-0">
            <img src="/static/img/TF.png" alt="" class="h-20">
        </a>
        <div class="lg:w-2/5 inline-flex lg:justify-end ml-5 lg:ml-0"></div>
    </div>
</header>
<!-- Contenido de la página inspecciones -->
<section class="text-gray-600 body-font">
    <div class="container px-5 py-24 mx-auto">
        <div class="flex flex-wrap -m-4">
            <div class="lg:w-1/4 md:w-1/2 p-4 w-full">
                <a href="/inspeccionComportamental.php" class="block relative h-48 rounded overflow-hidden">
                    <img alt="Inspección Comportamental" class="object-cover object-center w-full h-full block" src="/static/img/inspeccionComportamental.png">
                </a>
                <div class="mt-4">
                    <h1 class="text-gray-900 title-font text-lg font-small text-center">Inspección Comportamental</h1>
                </div>
            </div>

            <div class="lg:w-1/4 md:w-1/2 p-4 w-full">
                <a href="/inspeccionPuestoTrabajo.php" class="block relative h-48 rounded overflow-hidden">
                    <img alt="Puesto De Trabajo" class="object-cover object-center w-full h-full block" src="/static/img/puestoTrabajo.png">
                </a>
                <div class="mt-4">
                    <h1 class="text-gray-900 title-font text-lg font-small text-center">Puesto De Trabajo</h1>
                </div>
            </div>

            <div class="lg:w-1/4 md:w-1/2 p-4 w-full">
                <a href="/inspeccionGerencial.php" class="block relative h-48 rounded overflow-hidden">
                    <img alt="Inspección Gerencial" class="object-cover object-center w-full h-full block" src="/static/img/inspeccionGerencial.png">
                </a>
                <div class="mt-4">
                    <h2 class="text-gray-900 title-font text-lg font-small text-center">Inspección Gerencial</h2>
                </div>
            </div>

            <div class="lg:w-1/4 md:w-1/2 p-4 w-full">
                <a href="/listadoAsistencia.php" class="block relative h-48 rounded overflow-hidden">
                    <img alt="Listado De Asistencia" class="object-cover object-center w-full h-full block" src="/static/img/listadoAsistencia.png">
                </a>
                <div class="mt-4">
                    <h2 class="text-gray-900 title-font text-lg font-small text-center">Listado De Asistencia</h2>
                </div>
            </div>

            <div class="lg:w-1/4 md:w-1/2 p-4 w-full">
                <a href="/inspeccionBotiquin.php" class="block relative h-48 rounded overflow-hidden">
                    <img alt="Inspección Botiquín" class="object-cover object-center w-full h-full block" src="/static/img/inspeccionBotiquin.png">
                </a>
                <div class="mt-4">
                    <h2 class="text-gray-900 title-font text-lg font-small text-center">Inspección Botiquín</h2>
                </div>
            </div>

            <div class="lg:w-1/4 md:w-1/2 p-4 w-full">
                <a href="/inspeccionCafeteria.php" class="block relative h-48 rounded overflow-hidden">
                    <img alt="Inspección Cafetería" class="object-cover object-center w-full h-full block" src="/static/img/inspeccionCafeteria.png">
                </a>
                <div class="mt-4">
                    <h2 class="text-gray-900 title-font text-lg font-small text-center">Inspección Cafetería</h2>
                </div>
            </div>

            <div class="lg:w-1/4 md:w-1/2 p-4 w-full">
                <a href="/inspeccionOrdenAseo.php" class="block relative h-48 rounded overflow-hidden">
                    <img alt="Inspección Orden y Aseo" class="object-cover object-center w-full h-full block" src="/static/img/inspeccionOrdenAseo.png">
                </a>
                <div class="mt-4">
                    <h2 class="text-gray-900 title-font text-lg font-small text-center">Inspección Orden y Aseo</h2>
                </div>
            </div>

            <div class="lg:w-1/4 md:w-1/2 p-4 w-full">
                <a href="/evaluacionFuncionesYResponsabilidades.php" class="block relative h-48 rounded overflow-hidden">
                    <img alt="Evaluación de funciones y responsabilidades" class="object-cover object-center w-full h-full block" src="/static/img/evaluacionFuncionesResponsabilidades.png">
                </a>
                <div class="mt-4">
                    <h2 class="text-gray-900 title-font text-lg font-small text-center">Evaluación de funciones y responsabilidades</h2>
                </div>
            </div>

            <div class="lg:w-1/4 md:w-1/2 p-4 w-full">
                <a href="/inspeccionExtintores.php" class="block relative h-48 rounded overflow-hidden">
                    <img alt="Inspección Extintores" class="object-cover object-center w-full h-full block" src="/static/img/inspeccionExtintores.png">
                </a>
                <div class="mt-4">
                    <h2 class="text-gray-900 title-font text-lg font-small text-center">Inspección Extintores</h2>
                </div>
            </div>

            <div class="lg:w-1/4 md:w-1/2 p-4 w-full">
                <a href="/inspeccionDotacion.php" class="block relative h-48 rounded overflow-hidden">
                    <img alt="Inspección Dotación" class="object-cover object-center w-full h-full block" src="/static/img/inspeccionDotacion.png">
                </a>
                <div class="mt-4">
                    <h2 class="text-gray-900 title-font text-lg font-small text-center">Inspección Dotación</h2>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Footer de la página -->
<footer class="bg-white text-gray-600 body-font">
    <div class="container px-5 py-8 mx-auto flex items-center sm:flex-row flex-col">
        <a class="flex title-font font-medium items-center md:justify-start justify-center text-gray-900">
        </a>
        <p class="text-sm text-gray-700 sm:ml-4 sm:pl-4 sm:border-l-2 sm:border-gray-200 sm:py-2 sm:mt-0 mt-4">
            © <span id="year"></span> TF AUDITORES
        </p>
        <span class="inline-flex sm:ml-auto sm:mt-0 mt-4 justify-center sm:justify-start">
            <a href="https://www.facebook.com/people/TF-Auditores-y-Asesores-SAS-BIC/100065088457000/" class="text-gray-700 hover:text-blue-500">
                <svg fill="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-5 h-5" viewBox="0 0 24 24">
                    <path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"></path>
                </svg>
            </a>
            <a href="https://www.instagram.com/tfauditores/" class="ml-3 text-gray-700 hover:text-pink-500">
                <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-5 h-5" viewBox="0 0 24 24">
                    <rect width="20" height="20" x="2" y="2" rx="5" ry="5"></rect>
                    <path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37zm1.5-4.87h.01"></path>
                </svg>
            </a>
            <a href="https://www.linkedin.com/uas/login?session_redirect=https%3A%2F%2Fwww.linkedin.com%2Fcompany%2F10364571%2Fadmin%2Fdashboard%2F" class="ml-3 text-gray-700 hover:text-blue-300">
                <svg fill="currentColor" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="0" class="w-5 h-5" viewBox="0 0 24 24">
                    <path stroke="none" d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2z"></path>
                    <circle cx="4" cy="4" r="2" stroke="none"></circle>
                </svg>
            </a>
        </span> 
    </div>
</footer>
<script>    
    document.getElementById("year").textContent = new Date().getFullYear();
</script>
</body>
</html>