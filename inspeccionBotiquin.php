<?php
require_once  'php/inspeccionBotiquin.php';
?>
<html>
<html lang="es">
<head>
    <meta charset="UTF-8">  
    <title>Inspección de Botiquin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.0.0-rc.7/dist/html2canvas.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="icon" type="image/x-icon" href="/static/img/TF.ico"/>
    <style>
        .no-shadow {
            box-shadow: none !important;
        }
    </style>
</head>
<body class="bg-[#E1EEE2] p-8">
<div class="mt-4 flex justify-between items-center space-x-2">
    <!-- Botón de atrás -->
    <button onclick="location.href='index.php'"  class="bg-green-800 hover:bg-green-600 text-white px-4 py-2 rounded flex items-center" id="back-btn">
        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
        Atrás
    </button>
    
    <div class="text-right flex space-x-2">
        <!-- Alerta de completar campos obligatorios -->
        <div id="toast-warning" class="flex items-center w-full max-w-xs p-4 text-gray-500 bg-white rounded-lg shadow dark:text-gray-400 dark:bg-gray-800" role="alert">
            <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-orange-500 bg-orange-100 rounded-lg dark:bg-orange-700 dark:text-orange-200">
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM10 15a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm1-4a1 1 0 0 1-2 0V6a1 1 0 0 1 2 0v5Z"/>
                </svg>
            </div>
            <div class="ms-3 text-sm font-normal text-center">Complete los campos necesarios; en caso contrario, escriba 'No aplica'.</div>
        </div>
        <!-- Btn de descarga PDF -->
        <button class="bg-blue-500 text-white px-4 py-2 rounded min-h-[48px] flex flex-col items-center justify-center" id="download-pdf">
            <img src="/static/img/enviar.svg" alt="Descarga PDF" class="h-8 w-8 text-white">
            <h4>Enviar</h4>
        </button>
    </div>
</div><br>

<div class="bg-white p-6 rounded-lg shadow-lg no-shadow" id="form-content">
    <div class="flex justify-between items-center mb-4">
        <div>
            <a href="/index.php">
                <img src="/static/img/TF.png" alt="Logo de la empresa" class="h-20">
            </a>
        </div>
        <div class="text-center">
            <h1 class="text-lg x.php">GESTIÓN DE SEGURIDAD Y SALUD EN EL TRABAJO</h1>
            <h2 class="text-md">INSPECCIÓN AL BOTIQUIN</h2>
        </div>
    <div>
        <span class="block text-right">VERSIÓN: 5</span>
        <span class="block text-right">F-HS-13</span>
    </div>
    </div>
    <form>
        
    <div class="mb-5 grid grid-cols-1 sm:grid-cols-3 gap-5 w-full">
    <!-- Fila superior (3 campos) -->
    <div class="flex flex-col w-full">
        <label for="Nombre Completo">Nombre Completo</label>
        <input class="border p-1 w-96" type="text" id="nombre_completo" minlength="5" maxlength="50"/>
    </div>

    <div class="flex flex-col w-96">
        <label for="Fecha de inspección">Fecha de inspección</label>
        <input class="border p-1 w-96" type="date" id="fecha_inspeccion"/>
    </div>

    <div class="flex flex-col w-full">
        <label for="mes">Próxima inspección</label>
        <select class="border p-1 w-96 sm:w-[200px]" name="mes" id="mes">
            <option>Seleccione</option>
            <option value="Enero">Enero</option>
            <option value="Febrero">Febrero</option>
            <option value="Marzo">Marzo</option>
            <option value="Abril">Abril</option>
            <option value="Mayo">Mayo</option>
            <option value="Junio">Junio</option>
            <option value="Julio">Julio</option>
            <option value="Agosto">Agosto</option>
            <option value="Septiembre">Septiembre</option>
            <option value="Octubre">Octubre</option>
            <option value="Noviembre">Noviembre</option>
            <option value="Diciembre">Diciembre</option>
        </select>
    </div>

    <!-- Fila inferior (2 campos) -->
    <div class="flex flex-col w-full sm:w-auto">
        <label for="Cargo">Cargo</label>
        <input class="border p-1 w-96" type="text" id="cargo" minlength="5" maxlength="50"/>
    </div>

    <div class="flex flex-col w-full sm:w-auto">
        <label for="Lugar">Lugar</label>
        <input class="border p-1 w-96" type="text" id="lugar" minlength="5" maxlength="50"/>
    </div>
</div>

   <table class="mt-4 w-full border border-gray-300">
        <thead>
            <tr class="bg-gray-100">
                <th class="border px-4 py-2 text-center">SELECCIONE EN LA LISTA DESPEGABLE LA OPCIÓN</th>
                <th class="border px-4 py-2 text-left">B = Bueno  R = Regular    M = Malo  N/A = No Aplica</th>
            </tr>
        </thead>
    </table><br>

   <form>
        <table class="w-full border-collapse border border-gray-400 text-sm">
            <thead class="bg-[#E1EEE2]">
                <tr>
                    <th class="border border-gray-400 p-2 w-48">Elementos</th>
                    <th class="border border-gray-400 p-2 w-12">Cantidad</th>
                    <th class="border border-gray-400 p-2 w-14">Fecha Vencimiento</th>
                    <th class="border border-gray-400 p-2 w-28">Integridad empaque</th>
                    <th class="border border-gray-400 p-2 w-64">Acción Correctiva Propuesta</th>
                    <th class="border border-gray-400 p-2 w-24">Fecha Propuesta</th>
                    <th class="border border-gray-400 p-2 w-24">Fecha Ejecución</th>
                    <th class="border border-gray-400 p-2">Responsable</th>
                </tr>
            </thead>

             <tbody id="table-body">
                <tr>
                    <td class="border border-gray-400 p-2 ">
                    <select>
                        <option value="#">Seleccione</option>
                        <option value="alcohol">Alcohol</option>
                        <option value="algodon">Algodón</option>
                        <option value="cinta_micropore">Cinta micropore</option>
                        <option value="compresas">Compresas</option>
                        <option value="curas">Curas</option>
                        <option value="esparadrapo_de_4">Esparadrapo de 4</option>
                        <option value="gasa">Gasa</option>
                        <option value="Guantes Talla L">Guantes Talla L</option>
                        <option value="Guantes Talla M">Guantes Talla M</option>
                        <option value="Isodine Espuma">Isodine Espuma</option>
                        <option value="Inmovilizadores">Inmovilizadores</option>
                        <option value="Tijeras">Tijeras</option>
                        <option value="Vendas Elasticas 3*5">Vendas Elasticas 3*5</option>
                        <option value="Vendas triangulares">Vendas triangulares</option>
                        <option value="Mascarilla facial del bolsillo para RCCO">Mascarilla facial del bolsillo para RCCO</option>
                        <option value="Vendas elasticas 2*5">Vendas elasticas 2*5</option>
                        <option value="Vendas elasticas 5*5">Vendas elasticas 5*5</option>
                        <option value="Tapabocas">Tapabocas</option>
                        <option value="Bajalengias">Bajalengias</option>
                        <option value="Termometro">Termómetro</option>
                        <option value="Silbato">Silbato</option>
                        <option value="Yodopovidona">Yodopovidona</option>
                        <option value="Solución Salina">Solución Salina</option>
                        <option value="Linterna">Linterna</option>
                        <option value="collar Cervical">Collar Cervical</option>
                    </select>
                    </td>
                    <td class="border border-gray-400 p-2">
                        <input class="w-full border-none p-1 text-base" type="text" id="numberInput" maxlength="2" oninput="validateNumber(this)" />
                    </td>
                    <script>
                        function validateNumber(input) {
                            input.value = input.value.replace(/[^0-9]/g, '').slice(0, 2);
                            
                            if (input.value === '0') {
                                input.value = '';
                            }
                        }
                    </script>
                    <td class="border border-gray-400 p-2"><input class="w-full border-none p-1 text-base" type="date"/></td>
                    <td class="border border-gray-400 p-2">
                        <select class="w-full border-none p-1 text-base">
                            <option>Elija</option>
                            <option>B</option>
                            <option>R</option>
                            <option>M</option>
                            <option>N/A</option>
                        </select></td>
                    <td class="border border-gray-400 p-2"><input class="w-full border-none p-1 text-base" maxlength="55" type="text"/></td>
                    <td class="border border-gray-400 p-2"><input class="w-full border-none p-1 text-base" type="date"/></td>
                    <td class="border border-gray-400 p-2"><input class="w-full border-none p-1 text-base" type="date"/></td>
                    <td class="border border-gray-400 p-2" style="width: 200px;">
                        <input placeholder="-" type="text" class="w-full border-none p-1 text-base" maxlength="32" 
                        oninput="moveToNext(event, this.nextElementSibling)" onkeydown="moveToPrevious(event, this)">
                    </td>  
                </tr>
                <tr>
                    <td class="border border-gray-400 p-1">
                        <select>
                            <option value="#">Seleccione</option>
                            <option value="alcohol">Alcohol</option>
                            <option value="algodon">Algodón</option>
                            <option value="cinta_micropore">Cinta micropore</option>
                            <option value="compresas">Compresas</option>
                            <option value="curas">Curas</option>
                            <option value="esparadrapo_de_4">Esparadrapo de 4</option>
                            <option value="gasa">Gasa</option>
                            <option value="Guantes Talla L">Guantes Talla L</option>
                            <option value="Guantes Talla M">Guantes Talla M</option>
                            <option value="Isodine Espuma">Isodine Espuma</option>
                            <option value="Inmovilizadores">Inmovilizadores</option>
                            <option value="Tijeras">Tijeras</option>
                            <option value="Vendas Elasticas 3*5">Vendas Elasticas 3*5</option>
                            <option value="Vendas triangulares">Vendas triangulares</option>
                            <option value="Mascarilla facial del bolsillo para RCCO">Mascarilla facial del bolsillo para RCCO</option>
                            <option value="Vendas elasticas 2*5">Vendas elasticas 2*5</option>
                            <option value="Vendas elasticas 5*5">Vendas elasticas 5*5</option>
                            <option value="Tapabocas">Tapabocas</option>
                            <option value="Bajalengias">Bajalengias</option>
                            <option value="Termometro">Termómetro</option>
                            <option value="Silbato">Silbato</option>
                            <option value="Yodopovidona">Yodopovidona</option>
                            <option value="Solución Salina">Solución Salina</option>
                            <option value="Linterna">Linterna</option>
                            <option value="collar Cervical">Collar Cervical</option>
                        </select>
                        </td>
                        <td class="border border-gray-400 p-2">
                            <input class="w-full border-none p-1 text-base" type="text" id="numberInput" maxlength="2" oninput="validateNumber(this)" />
                        </td>                    <td class="border border-gray-400 p-2"><input class="w-full border-none p-1 text-base" type="date"/></td>
                    <td class="border border-gray-400 p-2">
                        <select class="w-full border-none p-1 text-base">
                            <option>Elija</option>
                            <option>B</option>
                            <option>R</option>
                            <option>M</option>
                            <option>N/A</option>
                        </select></td>
                    <td class="border border-gray-400 p-2"><input class="w-full border-none p-1 text-base" type="text"/></td>
                    <td class="border border-gray-400 p-2"><input class="w-full border-none p-1 text-base" type="date"/></td>
                    <td class="border border-gray-400 p-2"><input class="w-full border-none p-1 text-base" type="date"/></td>
                    <td class="border border-gray-400 p-2" style="width: 200px;">
                        <input placeholder="-" type="text" class="w-full border-none p-1 text-base" maxlength="27" 
                        oninput="moveToNext(event, this.nextElementSibling)" onkeydown="moveToPrevious(event, this)">
                    </td>  
                </tr>
                <tr>
                <td class="border border-gray-400 p-1">
                    <select>
                            <option value="#">Seleccione</option>
                            <option value="alcohol">Alcohol</option>
                            <option value="algodon">Algodón</option>
                            <option value="cinta_micropore">Cinta micropore</option>
                            <option value="compresas">Compresas</option>
                            <option value="curas">Curas</option>
                            <option value="esparadrapo_de_4">Esparadrapo de 4</option>
                            <option value="gasa">Gasa</option>
                            <option value="Guantes Talla L">Guantes Talla L</option>
                            <option value="Guantes Talla M">Guantes Talla M</option>
                            <option value="Isodine Espuma">Isodine Espuma</option>
                            <option value="Inmovilizadores">Inmovilizadores</option>
                            <option value="Tijeras">Tijeras</option>
                            <option value="Vendas Elasticas 3*5">Vendas Elasticas 3*5</option>
                            <option value="Vendas triangulares">Vendas triangulares</option>
                            <option value="Mascarilla facial del bolsillo para RCCO">Mascarilla facial del bolsillo para RCCO</option>
                            <option value="Vendas elasticas 2*5">Vendas elasticas 2*5</option>
                            <option value="Vendas elasticas 5*5">Vendas elasticas 5*5</option>
                            <option value="Tapabocas">Tapabocas</option>
                            <option value="Bajalengias">Bajalengias</option>
                            <option value="Termometro">Termómetro</option>
                            <option value="Silbato">Silbato</option>
                            <option value="Yodopovidona">Yodopovidona</option>
                            <option value="Solución Salina">Solución Salina</option>
                            <option value="Linterna">Linterna</option>
                            <option value="collar Cervical">Collar Cervical</option>
                        </select>
                    </td>
                    <td class="border border-gray-400 p-2">
                        <input class="w-full border-none p-1 text-base" type="text" id="numberInput" maxlength="2" oninput="validateNumber(this)" />
                    </td>
                    <td class="border border-gray-400 p-2"><input class="w-full border-none p-1 text-base" type="date"/></td>
                    <td class="border border-gray-400 p-2">
                        <select class="w-full border-none p-1 text-base">
                            <option>Elija</option>
                            <option>B</option>
                            <option>R</option>
                            <option>M</option>
                            <option>N/A</option>
                            </select></td>
                    <td class="border border-gray-400 p-2"><input class="w-full border-none p-1 text-base" type="text"/></td>
                    <td class="border border-gray-400 p-2"><input class="w-full border-none p-1 text-base" type="date"/></td>
                    <td class="border border-gray-400 p-2"><input class="w-full border-none p-1 text-base" type="date"/></td>
                    <td class="border border-gray-400 p-2" style="width: 200px;">
                        <input placeholder="-" type="text" class="w-full border-none p-1 text-base" maxlength="27" 
                        oninput="moveToNext(event, this.nextElementSibling)" onkeydown="moveToPrevious(event, this)">
                    </td>  
                </tr>
                <tr>
                <td class="border border-gray-400 p-1">
                    <select>
                            <option value="#">Seleccione</option>
                            <option value="alcohol">Alcohol</option>
                            <option value="algodon">Algodón</option>
                            <option value="cinta_micropore">Cinta micropore</option>
                            <option value="compresas">Compresas</option>
                            <option value="curas">Curas</option>
                            <option value="esparadrapo_de_4">Esparadrapo de 4</option>
                            <option value="gasa">Gasa</option>
                            <option value="Guantes Talla L">Guantes Talla L</option>
                            <option value="Guantes Talla M">Guantes Talla M</option>
                            <option value="Isodine Espuma">Isodine Espuma</option>
                            <option value="Inmovilizadores">Inmovilizadores</option>
                            <option value="Tijeras">Tijeras</option>
                            <option value="Vendas Elasticas 3*5">Vendas Elasticas 3*5</option>
                            <option value="Vendas triangulares">Vendas triangulares</option>
                            <option value="Mascarilla facial del bolsillo para RCCO">Mascarilla facial del bolsillo para RCCO</option>
                            <option value="Vendas elasticas 2*5">Vendas elasticas 2*5</option>
                            <option value="Vendas elasticas 5*5">Vendas elasticas 5*5</option>
                            <option value="Tapabocas">Tapabocas</option>
                            <option value="Bajalengias">Bajalengias</option>
                            <option value="Termometro">Termómetro</option>
                            <option value="Silbato">Silbato</option>
                            <option value="Yodopovidona">Yodopovidona</option>
                            <option value="Solución Salina">Solución Salina</option>
                            <option value="Linterna">Linterna</option>
                            <option value="collar Cervical">Collar Cervical</option>
                        </select>
                    </td>
                    <td class="border border-gray-400 p-2">
                        <input class="w-full border-none p-1 text-base" type="text" id="numberInput" maxlength="2" oninput="validateNumber(this)" />
                    </td>
                    <td class="border border-gray-400 p-2"><input class="w-full border-none p-1 text-base" type="date"/></td>
                    <td class="border border-gray-400 p-2">
                        <select class="w-full border-none p-1 text-base">
                            <option>Elija</option>
                            <option>B</option>
                            <option>R</option>
                            <option>M</option>
                            <option>N/A</option>
                        </select></td>
                    <td class="border border-gray-400 p-2"><input class="w-full border-none p-1 text-base" type="text"/></td>
                    <td class="border border-gray-400 p-2"><input class="w-full border-none p-1 text-base" type="date"/> </td>
                    <td class="border border-gray-400 p-2"><input class="w-full border-none p-1 text-base" type="date"/></td>
                    <td class="border border-gray-400 p-2" style="width: 200px;">
                        <input placeholder="-" type="text" class="w-full border-none p-1 text-base" maxlength="27" 
                        oninput="moveToNext(event, this.nextElementSibling)" onkeydown="moveToPrevious(event, this)">
                    </td>  
                </tr>
                <tr>
                <td class="border border-gray-400 p-1">
                    <select>
                        <option value="#">Seleccione</option>
                        <option value="alcohol">Alcohol</option>
                        <option value="algodon">Algodón</option>
                        <option value="cinta_micropore">Cinta micropore</option>
                        <option value="compresas">Compresas</option>
                        <option value="curas">Curas</option>
                        <option value="esparadrapo_de_4">Esparadrapo de 4</option>
                        <option value="gasa">Gasa</option>
                        <option value="Guantes Talla L">Guantes Talla L</option>
                        <option value="Guantes Talla M">Guantes Talla M</option>
                        <option value="Isodine Espuma">Isodine Espuma</option>
                        <option value="Inmovilizadores">Inmovilizadores</option>
                        <option value="Tijeras">Tijeras</option>
                        <option value="Vendas Elasticas 3*5">Vendas Elasticas 3*5</option>
                        <option value="Vendas triangulares">Vendas triangulares</option>
                        <option value="Mascarilla facial del bolsillo para RCCO">Mascarilla facial del bolsillo para RCCO</option>
                        <option value="Vendas elasticas 2*5">Vendas elasticas 2*5</option>
                        <option value="Vendas elasticas 5*5">Vendas elasticas 5*5</option>
                        <option value="Tapabocas">Tapabocas</option>
                        <option value="Bajalengias">Bajalengias</option>
                        <option value="Termometro">Termómetro</option>
                        <option value="Silbato">Silbato</option>
                        <option value="Yodopovidona">Yodopovidona</option>
                        <option value="Solución Salina">Solución Salina</option>
                        <option value="Linterna">Linterna</option>
                        <option value="collar Cervical">Collar Cervical</option>
                    </select>
                </td>
                    <td class="border border-gray-400 p-2">
                        <input class="w-full border-none p-1 text-base" type="text" id="numberInput" maxlength="2" oninput="validateNumber(this)" />
                    </td>
                    <td class="border border-gray-400 p-2"><input class="w-full border-none p-1 text-base" type="date"/></td>
                    <td class="border border-gray-400 p-2">
                        <select class="w-full border-none p-1 text-base">
                            <option>Elija</option>
                            <option>B</option>
                            <option>R</option>
                            <option>M</option>
                            <option>N/A</option>
                        </select></td>
                    <td class="border border-gray-400 p-2"><input class="w-full border-none p-1 text-base" type="text"/></td>
                    <td class="border border-gray-400 p-2"><input class="w-full border-none p-1 text-base" type="date"/></td>
                    <td class="border border-gray-400 p-2"><input class="w-full border-none p-1 text-base" type="date"/></td>
                    <td class="border border-gray-400 p-2" style="width: 200px;">
                        <input placeholder="-" type="text" class="w-full border-none p-1 text-base" maxlength="27" 
                        oninput="moveToNext(event, this.nextElementSibling)" onkeydown="moveToPrevious(event, this)">
                    </td> 
                </tr>
                <tr>
                <td class="border border-gray-400 p-1">
                    <select>
                        <option value="#">Seleccione</option>
                        <option value="alcohol">Alcohol</option>
                        <option value="algodon">Algodón</option>
                        <option value="cinta_micropore">Cinta micropore</option>
                        <option value="compresas">Compresas</option>
                        <option value="curas">Curas</option>
                        <option value="esparadrapo_de_4">Esparadrapo de 4</option>
                        <option value="gasa">Gasa</option>
                        <option value="Guantes Talla L">Guantes Talla L</option>
                        <option value="Guantes Talla M">Guantes Talla M</option>
                        <option value="Isodine Espuma">Isodine Espuma</option>
                        <option value="Inmovilizadores">Inmovilizadores</option>
                        <option value="Tijeras">Tijeras</option>
                        <option value="Vendas Elasticas 3*5">Vendas Elasticas 3*5</option>
                        <option value="Vendas triangulares">Vendas triangulares</option>
                        <option value="Mascarilla facial del bolsillo para RCCO">Mascarilla facial del bolsillo para RCCO</option>
                        <option value="Vendas elasticas 2*5">Vendas elasticas 2*5</option>
                        <option value="Vendas elasticas 5*5">Vendas elasticas 5*5</option>
                        <option value="Tapabocas">Tapabocas</option>
                        <option value="Bajalengias">Bajalengias</option>
                        <option value="Termometro">Termómetro</option>
                        <option value="Silbato">Silbato</option>
                        <option value="Yodopovidona">Yodopovidona</option>
                        <option value="Solución Salina">Solución Salina</option>
                        <option value="Linterna">Linterna</option>
                        <option value="collar Cervical">Collar Cervical</option>
                    </select>
                    </td>
                    <td class="border border-gray-400 p-2">
                        <input class="w-full border-none p-1 text-base" type="text" id="numberInput" maxlength="2" oninput="validateNumber(this)" />
                    </td>
                    <td class="border border-gray-400 p-2"><input class="w-full border-none p-1 text-base" type="date"/></td>
                    <td class="border border-gray-400 p-2">
                        <select class="w-full border-none p-1 text-base">
                            <option>Elija</option>
                            <option>B</option>
                            <option>R</option>
                            <option>M</option>
                            <option>N/A</option>
                        </select></td>
                    <td class="border border-gray-400 p-2"><input class="w-full border-none p-1 text-base" type="text"/></td>
                    <td class="border border-gray-400 p-2"><input class="w-full border-none p-1 text-base" type="date"/></td>
                    <td class="border border-gray-400 p-2"><input class="w-full border-none p-1 text-base" type="date"/></td>
                    <td class="border border-gray-400 p-2" style="width: 200px;">
                        <input placeholder="-" type="text" class="w-full border-none p-1 text-base" maxlength="27" 
                        oninput="moveToNext(event, this.nextElementSibling)" onkeydown="moveToPrevious(event, this)">
                    </td>  
                </tr>
                <tr>
                <td class="border border-gray-400 p-1">
                    <select>
                        <option value="#">Seleccione</option>
                        <option value="alcohol">Alcohol</option>
                        <option value="algodon">Algodón</option>
                        <option value="cinta_micropore">Cinta micropore</option>
                        <option value="compresas">Compresas</option>
                        <option value="curas">Curas</option>
                        <option value="esparadrapo_de_4">Esparadrapo de 4</option>
                        <option value="gasa">Gasa</option>
                        <option value="Guantes Talla L">Guantes Talla L</option>
                        <option value="Guantes Talla M">Guantes Talla M</option>
                        <option value="Isodine Espuma">Isodine Espuma</option>
                        <option value="Inmovilizadores">Inmovilizadores</option>
                        <option value="Tijeras">Tijeras</option>
                        <option value="Vendas Elasticas 3*5">Vendas Elasticas 3*5</option>
                        <option value="Vendas triangulares">Vendas triangulares</option>
                        <option value="Mascarilla facial del bolsillo para RCCO">Mascarilla facial del bolsillo para RCCO</option>
                        <option value="Vendas elasticas 2*5">Vendas elasticas 2*5</option>
                        <option value="Vendas elasticas 5*5">Vendas elasticas 5*5</option>
                        <option value="Tapabocas">Tapabocas</option>
                        <option value="Bajalengias">Bajalengias</option>
                        <option value="Termometro">Termómetro</option>
                        <option value="Silbato">Silbato</option>
                        <option value="Yodopovidona">Yodopovidona</option>
                        <option value="Solución Salina">Solución Salina</option>
                        <option value="Linterna">Linterna</option>
                        <option value="collar Cervical">Collar Cervical</option>
                    </select>
                    </td>
                    <td class="border border-gray-400 p-2">
                        <input class="w-full border-none p-1 text-base" type="text" id="numberInput" maxlength="2" oninput="validateNumber(this)" />
                    </td>
                    <td class="border border-gray-400 p-2"><input class="w-full border-none p-1 text-base" type="date"/></td>
                    <td class="border border-gray-400 p-2">
                        <select class="w-full border-none p-1 text-base">
                            <option>Elija</option>
                            <option>B</option>
                            <option>R</option>
                            <option>M</option>
                            <option>N/A</option>
                        </select></td>
                    <td class="border border-gray-400 p-2"><input class="w-full border-none p-1 text-base" type="text"/></td>
                    <td class="border border-gray-400 p-2"><input class="w-full border-none p-1 text-base" type="date"/></td >
                    <td class="border border-gray-400 p-2"><input class="w-full border-none p-1 text-base" type="date"/></td>
                    <td class="border border-gray-400 p-2" style="width: 200px;">
                        <input placeholder="-" type="text" class="w-full border-none p-1 text-base" maxlength="27" 
                        oninput="moveToNext(event, this.nextElementSibling)" onkeydown="moveToPrevious(event, this)">
                    </td> 
                </tr>
                <tr>
                <td class="border border-gray-400 p-1">
                    <select>
                        <option value="#">Seleccione</option>
                        <option value="alcohol">Alcohol</option>
                        <option value="algodon">Algodón</option>
                        <option value="cinta_micropore">Cinta micropore</option>
                        <option value="compresas">Compresas</option>
                        <option value="curas">Curas</option>
                        <option value="esparadrapo_de_4">Esparadrapo de 4</option>
                        <option value="gasa">Gasa</option>
                        <option value="Guantes Talla L">Guantes Talla L</option>
                        <option value="Guantes Talla M">Guantes Talla M</option>
                        <option value="Isodine Espuma">Isodine Espuma</option>
                        <option value="Inmovilizadores">Inmovilizadores</option>
                        <option value="Tijeras">Tijeras</option>
                        <option value="Vendas Elasticas 3*5">Vendas Elasticas 3*5</option>
                        <option value="Vendas triangulares">Vendas triangulares</option>
                        <option value="Mascarilla facial del bolsillo para RCCO">Mascarilla facial del bolsillo para RCCO</option>
                        <option value="Vendas elasticas 2*5">Vendas elasticas 2*5</option>
                        <option value="Vendas elasticas 5*5">Vendas elasticas 5*5</option>
                        <option value="Tapabocas">Tapabocas</option>
                        <option value="Bajalengias">Bajalengias</option>
                        <option value="Termometro">Termómetro</option>
                        <option value="Silbato">Silbato</option>
                        <option value="Yodopovidona">Yodopovidona</option>
                        <option value="Solución Salina">Solución Salina</option>
                        <option value="Linterna">Linterna</option>
                        <option value="collar Cervical">Collar Cervical</option>
                    </select>
                    </td>
                    <td class="border border-gray-400 p-2">
                        <input class="w-full border-none p-1 text-base" type="text" id="numberInput" maxlength="2" oninput="validateNumber(this)" />
                    </td>
                    <td class="border border-gray-400 p-2"><input class="w-full border-none p-1 text-base" type="date"/></td>
                    <td class="border border-gray-400 p-2">
                        <select class="w-full border-none p-1 text-base">
                        <option>Elija</option>
                        <option>B</option>
                        <option>R</option>
                        <option>M</option>
                        <option>N/A</option>
                        </select></td>
                    <td class="border border-gray-400 p-2">
                        <input class="w-full border-none p-1 text-base" type="text" id="numberInput" maxlength="2" oninput="validateNumber(this)" />
                    </td>
                    <td class="border border-gray-400 p-2"><input class="w-full border-none p-1 text-base" type="date"/></td>
                    <td class="border border-gray-400 p-2"><input class="w-full border-none p-1 text-base" type="date"/></td>
                    <td class="border border-gray-400 p-2" style="width: 200px;">
                        <input placeholder="-" type="text" class="w-full border-none p-1 text-base" maxlength="27" 
                        oninput="moveToNext(event, this.nextElementSibling)" onkeydown="moveToPrevious(event, this)">
                    </td>  
                </tr>
                <tr>                
                <td class="border border-gray-400 p-1">
                        <select>
                            <option value="#">Seleccione</option>
                            <option value="alcohol">Alcohol</option>
                            <option value="algodon">Algodón</option>
                            <option value="cinta_micropore">Cinta micropore</option>
                            <option value="compresas">Compresas</option>
                            <option value="curas">Curas</option>
                            <option value="esparadrapo_de_4">Esparadrapo de 4</option>
                            <option value="gasa">Gasa</option>
                            <option value="Guantes Talla L">Guantes Talla L</option>
                            <option value="Guantes Talla M">Guantes Talla M</option>
                            <option value="Isodine Espuma">Isodine Espuma</option>
                            <option value="Inmovilizadores">Inmovilizadores</option>
                            <option value="Tijeras">Tijeras</option>
                            <option value="Vendas Elasticas 3*5">Vendas Elasticas 3*5</option>
                            <option value="Vendas triangulares">Vendas triangulares</option>
                            <option value="Mascarilla facial del bolsillo para RCCO">Mascarilla facial del bolsillo para RCCO</option>
                            <option value="Vendas elasticas 2*5">Vendas elasticas 2*5</option>
                            <option value="Vendas elasticas 5*5">Vendas elasticas 5*5</option>
                            <option value="Tapabocas">Tapabocas</option>
                            <option value="Bajalengias">Bajalengias</option>
                            <option value="Termometro">Termómetro</option>
                            <option value="Silbato">Silbato</option>
                            <option value="Yodopovidona">Yodopovidona</option>
                            <option value="Solución Salina">Solución Salina</option>
                            <option value="Linterna">Linterna</option>
                            <option value="collar Cervical">Collar Cervical</option>
                        </select>
                    </td>
                    <td class="border border-gray-400 p-2">
                        <input class="w-full border-none p-1 text-base" type="text" id="numberInput" maxlength="2" oninput="validateNumber(this)" />
                    </td>
                    <td class="border border-gray-400 p-2"><input class="w-full border-none p-1 text-base" type="date"/></td>
                    <td class="border border-gray-400 p-2">
                    <select class="w-full border-none p-1 text-base">
                        <option>Elija</option>
                        <option>B</option>
                        <option>R</option>
                        <option>M</option>
                        <option>N/A</option>
                        </select></td>
                    <td class="border border-gray-400 p-2"><input class="w-full border-none p-1 text-base" type="text"/></td>
                    <td class="border border-gray-400 p-2"><input class="w-full border-none p-1 text-base" type="date"/></td>
                    <td class="border border-gray-400 p-2"><input class="w-full border-none p-1 text-base" type="date"/></td>
                    <td class="border border-gray-400 p-2" style="width: 200px;">
                        <input placeholder="-" type="text" class="w-full border-none p-1 text-base" maxlength="27" 
                        oninput="moveToNext(event, this.nextElementSibling)" onkeydown="moveToPrevious(event, this)">
                    </td>  
                </tr>
                <tr>
                    <td class="border border-gray-400 p-1">
                        <select>
                            <option value="#">Seleccione</option>
                            <option value="alcohol">Alcohol</option>
                            <option value="algodon">Algodón</option>
                            <option value="cinta_micropore">Cinta micropore</option>
                            <option value="compresas">Compresas</option>
                            <option value="curas">Curas</option>
                            <option value="esparadrapo_de_4">Esparadrapo de 4</option>
                            <option value="gasa">Gasa</option>
                            <option value="Guantes Talla L">Guantes Talla L</option>
                            <option value="Guantes Talla M">Guantes Talla M</option>
                            <option value="Isodine Espuma">Isodine Espuma</option>
                            <option value="Inmovilizadores">Inmovilizadores</option>
                            <option value="Tijeras">Tijeras</option>
                            <option value="Vendas Elasticas 3*5">Vendas Elasticas 3*5</option>
                            <option value="Vendas triangulares">Vendas triangulares</option>
                            <option value="Mascarilla facial del bolsillo para RCCO">Mascarilla facial del bolsillo para RCCO</option>
                            <option value="Vendas elasticas 2*5">Vendas elasticas 2*5</option>
                            <option value="Vendas elasticas 5*5">Vendas elasticas 5*5</option>
                            <option value="Tapabocas">Tapabocas</option>
                            <option value="Bajalengias">Bajalengias</option>
                            <option value="Termometro">Termómetro</option>
                            <option value="Silbato">Silbato</option>
                            <option value="Yodopovidona">Yodopovidona</option>
                            <option value="Solución Salina">Solución Salina</option>
                            <option value="Linterna">Linterna</option>
                            <option value="collar Cervical">Collar Cervical</option>
                        </select>
                    </td>
                    <td class="border border-gray-400 p-2">
                        <input class="w-full border-none p-1 text-base" type="text" id="numberInput" maxlength="2" oninput="validateNumber(this)" />
                    </td>
                    <td class="border border-gray-400 p-2"><input class="w-full border-none p-1 text-base" type="date"/></td>
                    <td class="border border-gray-400 p-2">
                        <select class="w-full border-none p-1 text-base">
                            <option>Elija</option>
                            <option>B</option>
                            <option>R</option>
                            <option>M</option>
                            <option>N/A</option>
                            </select></td>
                    <td class="border border-gray-400 p-2"><input class="w-full border-none p-1 text-base" type="text"/></td>
                    <td class="border border-gray-400 p-2"><input class="w-full border-none p-1 text-base" type="date"/></td>
                    <td class="border border-gray-400 p-2"><input class="w-full border-none p-1 text-base" type="date"/></td>
                    <td class="border border-gray-400 p-2" style="width: 200px;">
                        <input placeholder="-" type="text" class="w-full border-none p-1 text-base" maxlength="27" 
                        oninput="moveToNext(event, this.nextElementSibling)" onkeydown="moveToPrevious(event, this)">
                    </td>  
                </tr>
                <tr>
                    <td class="border border-gray-400 p-1">
                        <select>
                            <option value="#">Seleccione</option>
                            <option value="alcohol">Alcohol</option>
                            <option value="algodon">Algodón</option>
                            <option value="cinta_micropore">Cinta micropore</option>
                            <option value="compresas">Compresas</option>
                            <option value="curas">Curas</option>
                            <option value="esparadrapo_de_4">Esparadrapo de 4</option>
                            <option value="gasa">Gasa</option>
                            <option value="Guantes Talla L">Guantes Talla L</option>
                            <option value="Guantes Talla M">Guantes Talla M</option>
                            <option value="Isodine Espuma">Isodine Espuma</option>
                            <option value="Inmovilizadores">Inmovilizadores</option>
                            <option value="Tijeras">Tijeras</option>
                            <option value="Vendas Elasticas 3*5">Vendas Elasticas 3*5</option>
                            <option value="Vendas triangulares">Vendas triangulares</option>
                            <option value="Mascarilla facial del bolsillo para RCCO">Mascarilla facial del bolsillo para RCCO</option>
                            <option value="Vendas elasticas 2*5">Vendas elasticas 2*5</option>
                            <option value="Vendas elasticas 5*5">Vendas elasticas 5*5</option>
                            <option value="Tapabocas">Tapabocas</option>
                            <option value="Bajalengias">Bajalengias</option>
                            <option value="Termometro">Termómetro</option>
                            <option value="Silbato">Silbato</option>
                            <option value="Yodopovidona">Yodopovidona</option>
                            <option value="Solución Salina">Solución Salina</option>
                            <option value="Linterna">Linterna</option>
                            <option value="collar Cervical">Collar Cervical</option>
                        </select>
                        </td>
                        <td class="border border-gray-400 p-2">
                            <input class="w-full border-none p-1 text-base" type="text" id="numberInput" maxlength="2" oninput="validateNumber(this)" />
                        </td>
                    <td class="border border-gray-400 p-2"><input class="w-full border-none p-1 text-base" type="date"/></td>
                    <td class="border border-gray-400 p-2">
                        <select class="w-full border-none p-1 text-base">
                            <option>Elija</option>
                            <option>B</option>
                            <option>R</option>
                            <option>M</option>
                            <option>N/A</option>
                        </select></td>
                    <td class="border border-gray-400 p-2"><input class="w-full border-none p-1 text-base" type="text"/></td>
                    <td class="border border-gray-400 p-2"><input class="w-full border-none p-1 text-base" type="date"/></td>
                    <td class="border border-gray-400 p-2"> <input class="w-full border-none p-1 text-base" type="date"/></td>
                    <td class="border border-gray-400 p-2" style="width: 200px;">
                        <input placeholder="-" type="text" class="w-full border-none p-1 text-base" maxlength="27" 
                        oninput="moveToNext(event, this.nextElementSibling)" onkeydown="moveToPrevious(event, this)">
                    </td>  
                </tr>
                <tr>
                    <td class="border border-gray-400 p-1">
                        <select>
                            <option value="#">Seleccione</option>
                            <option value="alcohol">Alcohol</option>
                            <option value="algodon">Algodón</option>
                            <option value="cinta_micropore">Cinta micropore</option>
                            <option value="compresas">Compresas</option>
                            <option value="curas">Curas</option>
                            <option value="esparadrapo_de_4">Esparadrapo de 4</option>
                            <option value="gasa">Gasa</option>
                            <option value="Guantes Talla L">Guantes Talla L</option>
                            <option value="Guantes Talla M">Guantes Talla M</option>
                            <option value="Isodine Espuma">Isodine Espuma</option>
                            <option value="Inmovilizadores">Inmovilizadores</option>
                            <option value="Tijeras">Tijeras</option>
                            <option value="Vendas Elasticas 3*5">Vendas Elasticas 3*5</option>
                            <option value="Vendas triangulares">Vendas triangulares</option>
                            <option value="Mascarilla facial del bolsillo para RCCO">Mascarilla facial del bolsillo para RCCO</option>
                            <option value="Vendas elasticas 2*5">Vendas elasticas 2*5</option>
                            <option value="Vendas elasticas 5*5">Vendas elasticas 5*5</option>
                            <option value="Tapabocas">Tapabocas</option>
                            <option value="Bajalengias">Bajalengias</option>
                            <option value="Termometro">Termómetro</option>
                            <option value="Silbato">Silbato</option>
                            <option value="Yodopovidona">Yodopovidona</option>
                            <option value="Solución Salina">Solución Salina</option>
                            <option value="Linterna">Linterna</option>
                            <option value="collar Cervical">Collar Cervical</option>
                        </select>
                        </td>
                        <td class="border border-gray-400 p-2">
                            <input class="w-full border-none p-1 text-base" type="text" id="numberInput" maxlength="2" oninput="validateNumber(this)" />
                        </td>
                        <td class="border border-gray-400 p-2"><input class="w-full border-none p-1 text-base" type="date"/></td>
                    <td class="border border-gray-400 p-2">
                        <select class="w-full border-none p-1 text-base">
                            <option>Elija</option>
                            <option>B</option>
                            <option>R</option>
                            <option>M</option>
                            <option>N/A</option>
                        </select></td>
                    <td class="border border-gray-400 p-2"><input class="w-full border-none p-1 text-base" type="text"/></td>
                    <td class="border border-gray-400 p-2"><input class="w-full border-none p-1 text-base" type="date"/></td>
                    <td class="border border-gray-400 p-2"><input class="w-full border-none p-1 text-base" type="date"/></td>
                    <td class="border border-gray-400 p-2" style="width: 200px;">
                        <input placeholder="-" type="text" class="w-full border-none p-1 text-base" maxlength="27" 
                        oninput="moveToNext(event, this.nextElementSibling)" onkeydown="moveToPrevious(event, this)">
                    </td>  
                </tr>
                <tr>
                    <td class="border border-gray-400 p-1">
                        <select>
                            <option value="#">Seleccione</option>
                            <option value="alcohol">Alcohol</option>
                            <option value="algodon">Algodón</option>
                            <option value="cinta_micropore">Cinta micropore</option>
                            <option value="compresas">Compresas</option>
                            <option value="curas">Curas</option>
                            <option value="esparadrapo_de_4">Esparadrapo de 4</option>
                            <option value="gasa">Gasa</option>
                            <option value="Guantes Talla L">Guantes Talla L</option>
                            <option value="Guantes Talla M">Guantes Talla M</option>
                            <option value="Isodine Espuma">Isodine Espuma</option>
                            <option value="Inmovilizadores">Inmovilizadores</option>
                            <option value="Tijeras">Tijeras</option>
                            <option value="Vendas Elasticas 3*5">Vendas Elasticas 3*5</option>
                            <option value="Vendas triangulares">Vendas triangulares</option>
                            <option value="Mascarilla facial del bolsillo para RCCO">Mascarilla facial del bolsillo para RCCO</option>
                            <option value="Vendas elasticas 2*5">Vendas elasticas 2*5</option>
                            <option value="Vendas elasticas 5*5">Vendas elasticas 5*5</option>
                            <option value="Tapabocas">Tapabocas</option>
                            <option value="Bajalengias">Bajalengias</option>
                            <option value="Termometro">Termómetro</option>
                            <option value="Silbato">Silbato</option>
                            <option value="Yodopovidona">Yodopovidona</option>
                            <option value="Solución Salina">Solución Salina</option>
                            <option value="Linterna">Linterna</option>
                            <option value="collar Cervical">Collar Cervical</option>
                        </select>
                        </td>
                        <td class="border border-gray-400 p-2">
                            <input class="w-full border-none p-1 text-base" type="text" id="numberInput" maxlength="2" oninput="validateNumber(this)" />
                        </td>
                        <td class="border border-gray-400 p-2"><input class="w-full border-none p-1 text-base" type="date"/></td>
                    <td class="border border-gray-400 p-2">
                        <select class="w-full border-none p-1 text-base">
                            <option>Elija</option>
                            <option>B</option>
                            <option>R</option>
                            <option>M</option>
                            <option>N/A</option>
                        </select></td>
                    <td class="border border-gray-400 p-2"><input class="w-full border-none p-1 text-base" type="text"/></td>
                    <td class="border border-gray-400 p-2"><input class="w-full border-none p-1 text-base" type="date"/></td>
                    <td class="border border-gray-400 p-2"><input class="w-full border-none p-1 text-base" type="date"/></td>
                    <td class="border border-gray-400 p-2" style="width: 200px;">
                        <input placeholder="-" type="text" class="w-full border-none p-1 text-base" maxlength="27" 
                        oninput="moveToNext(event, this.nextElementSibling)" onkeydown="moveToPrevious(event, this)">
                    </td>  
                </tr>
                <tr>
                    <td class="border border-gray-400 p-1">
                        <select>
                            <option value="#">Seleccione</option>
                            <option value="alcohol">Alcohol</option>
                            <option value="algodon">Algodón</option>
                            <option value="cinta_micropore">Cinta micropore</option>
                            <option value="compresas">Compresas</option>
                            <option value="curas">Curas</option>
                            <option value="esparadrapo_de_4">Esparadrapo de 4</option>
                            <option value="gasa">Gasa</option>
                            <option value="Guantes Talla L">Guantes Talla L</option>
                            <option value="Guantes Talla M">Guantes Talla M</option>
                            <option value="Isodine Espuma">Isodine Espuma</option>
                            <option value="Inmovilizadores">Inmovilizadores</option>
                            <option value="Tijeras">Tijeras</option>
                            <option value="Vendas Elasticas 3*5">Vendas Elasticas 3*5</option>
                            <option value="Vendas triangulares">Vendas triangulares</option>
                            <option value="Mascarilla facial del bolsillo para RCCO">Mascarilla facial del bolsillo para RCCO</option>
                            <option value="Vendas elasticas 2*5">Vendas elasticas 2*5</option>
                            <option value="Vendas elasticas 5*5">Vendas elasticas 5*5</option>
                            <option value="Tapabocas">Tapabocas</option>
                            <option value="Bajalengias">Bajalengias</option>
                            <option value="Termometro">Termómetro</option>
                            <option value="Silbato">Silbato</option>
                            <option value="Yodopovidona">Yodopovidona</option>
                            <option value="Solución Salina">Solución Salina</option>
                            <option value="Linterna">Linterna</option>
                            <option value="collar Cervical">Collar Cervical</option>
                        </select>
                        </td>
                        <td class="border border-gray-400 p-2">
                            <input class="w-full border-none p-1 text-base" type="text" id="numberInput" maxlength="2" oninput="validateNumber(this)" />
                        </td>
                    <td class="border border-gray-400 p-2"><input class="w-full border-none p-1 text-base" type="date"/></td>
                    <td class="border border-gray-400 p-2">
                        <select class="w-full border-none p-1 text-base">
                            <option>Elija</option>
                            <option>B</option>
                            <option>R</option>
                            <option>M</option>
                            <option>N/A</option>
                        </select></td>
                    <td class="border border-gray-400 p-2"><input class="w-full border-none p-1 text-base " type="text"/></td>
                    <td class="border border-gray-400 p-2"><input class="w-full border-none p-1 text-base" type="date"/></td>
                    <td class="border border-gray-400 p-2"><input class="w-full border-none p-1 text-base" type="date"/></td>
                    <td class="border border-gray-400 p-2" style="width: 200px;">
                        <input placeholder="-" type="text" class="w-full border-none p-1 text-base" maxlength="27" 
                        oninput="moveToNext(event, this.nextElementSibling)" onkeydown="moveToPrevious(event, this)">
                    </td> 
                </tr>
                <tr>
                    <td class="border border-gray-400 p-1">
                        <select>
                            <option value="#">Seleccione</option>
                            <option value="alcohol">Alcohol</option>
                            <option value="algodon">Algodón</option>
                            <option value="cinta_micropore">Cinta micropore</option>
                            <option value="compresas">Compresas</option>
                            <option value="curas">Curas</option>
                            <option value="esparadrapo_de_4">Esparadrapo de 4</option>
                            <option value="gasa">Gasa</option>
                            <option value="Guantes Talla L">Guantes Talla L</option>
                            <option value="Guantes Talla M">Guantes Talla M</option>
                            <option value="Isodine Espuma">Isodine Espuma</option>
                            <option value="Inmovilizadores">Inmovilizadores</option>
                            <option value="Tijeras">Tijeras</option>
                            <option value="Vendas Elasticas 3*5">Vendas Elasticas 3*5</option>
                            <option value="Vendas triangulares">Vendas triangulares</option>
                            <option value="Mascarilla facial del bolsillo para RCCO">Mascarilla facial del bolsillo para RCCO</option>
                            <option value="Vendas elasticas 2*5">Vendas elasticas 2*5</option>
                            <option value="Vendas elasticas 5*5">Vendas elasticas 5*5</option>
                            <option value="Tapabocas">Tapabocas</option>
                            <option value="Bajalengias">Bajalengias</option>
                            <option value="Termometro">Termómetro</option>
                            <option value="Silbato">Silbato</option>
                            <option value="Yodopovidona">Yodopovidona</option>
                            <option value="Solución Salina">Solución Salina</option>
                            <option value="Linterna">Linterna</option>
                            <option value="collar Cervical">Collar Cervical</option>
                        </select>
                        </td>
                        <td class="border border-gray-400 p-2">
                            <input class="w-full border-none p-1 text-base" type="text" id="numberInput" maxlength="2" oninput="validateNumber(this)" />
                        </td>
                        <td class="border border-gray-400 p-2"><input class="w-full border-none p-1 text-base" type="date"/></td>
                    <td class="border border-gray-400 p-2">
                        <select class="w-full border-none p-1 text-base">
                            <option>Elija</option>
                            <option>B</option>
                            <option>R</option>
                            <option>M</option>
                            <option>N/A</option>
                        </select></td>
                    <td class="border border-gray-400 p-2"><input class="w-full border-none p-1 text-base" type="text"/></td>
                    <td class="border border-gray-400 p-2"><input class="w-full border-none p-1 text-base" type="date"/></td>
                    <td class="border border-gray-400 p-2"><input class="w-full border-none p-1 text-base" type="date"/></td>
                    <td class="border border-gray-400 p-2" style="width: 200px;">
                        <input placeholder="-" type="text" class="w-full border-none p-1 text-base" maxlength="27" 
                        oninput="moveToNext(event, this.nextElementSibling)" onkeydown="moveToPrevious(event, this)">
                    </td>  
                </tr>
            </tbody>
        </table><br>
        <table class="border-collapse w-full">
            <tr class="bg-[#E1EEE2]">
                <th class="border px-4 text-center text-base" colspan="2">CONCLUSIONES</th>
                <th class="border px-4 text-center text-base" colspan="2">SUGERENCIAS</th>
            </tr>
            <tr>
                <td class="border px-4 py-2" colspan="2">
                   <input type="text" class="w-full" placeholder="-">
                </td>
                <td class="border px-4 py-2" colspan="2">
                    <input type="text" class="w-full" placeholder="-">
                </td>
            </tr>
            <tr>
                <td class="border px-4 py-2" colspan="2">
                    <input type="text" class="w-full" placeholder="-">
                </td>
                <td class="border px-4 py-2" colspan="2">
                    <input type="text" class="w-full" placeholder="-">
                </td>
            </tr>
            <tr>
                <td class="border px-4 py-2" colspan="2">
                    <input type="text" class="w-full" placeholder="-">
                </td>
                <td class="border px-4 py-2" colspan="2">
                    <input type="text" class="w-full" placeholder="-">
                </td>
            </tr>
        </table>
            <div class="flex flex-col items-center justify-center w-full">
                <div class="mt-14">
                    <div class="flex justify-center space-x-150 ml-[120px]">
                        <div class="flex flex-col items-center">
                        <label class="text-sm">FIRMA ASESOR HSE</label>
                        <canvas class="signature-pad border border-gray-400" width="300" height="100"></canvas>
                        <div class="mt-2 flex flex-row space-x-2 justify-center">
                            <button type="button" class="bg-red-500 text-white px-2 py-1 rounded hide-on-pdf clear-signature flex items-center" onclick="clearSignature(1)">
                                <svg class="w-4 h-4 mr-2 text-red-200" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <path d="M3 6h18v2H3V6zm3 3h12v13H6V9zm4-5h4v2h-4V4zM5 6h14v16a2 2 0 01-2 2H7a2 2 0 01-2-2V6zm6 5v3h3V11h-3z"/>
                                </svg>    
                                Limpiar
                            </button>
                            <button type="button" class="bg-blue-500 text-white px-2 py-1 rounded hide-on-pdf flex items-center" onclick="document.getElementById('upload-signature-1').click();">
                                <svg class="w-4 h-4 mr-2 text-blue-200" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <path d="M12 2L8.59 5.41 13.17 10H4v2h9.17l-4.58 4.59L12 18l8-8-8-8zm0 4v3h-1v4h1v3h4v-3h1V9h-1V6h-4z"/>
                                </svg>
                                Subir Firma
                            </button>
                            <input type="file" accept="image/*" id="upload-signature-1" class="hidden" onchange="loadSignature(event, 1)" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<script src="/static/js/inspeccionBotiquin.js"></script>
</body>
</html>