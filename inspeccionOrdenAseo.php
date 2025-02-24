<?php
require_once 'php/inspeccionOrdenAseo.php';
?>
<html>
<head>
<meta charset="UTF-8">
    <title>Inspección de Orden y Aseo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.0.0-rc.7/dist/html2canvas.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="icon" type="image/x-icon" href="/static/img/TF.ico"/>
    <style>
        .no-shadow {
            box-shadow: none !important;
        }
        .transparent-input {
            background-color: transparent;
            border: none;
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
                <h1 class="text-lg font-bold">GESTIÓN DE SEGURIDAD Y SALUD EN EL TRABAJO</h1>
                <h2 class="text-md">INSPECCIÓN DE ORDEN Y ASEO</h2>
            </div>
            <div>
                <span class="block text-right">VERSIÓN: 4</span>
                <span class="block text-right">F-HS-14</span>
            </div>
        </div>

        <div class="flex justify-between items-center mb-4 space-x-4">
            <div class="w-1/4">
                <label for="Instalaciones">Instalaciones</label><br>
                <input type="text" class="border border-gray-400 p-1 w-80 " id="instalaciones">
            </div>
            <div class="w-1/4">
                <label for="Área">Área</label><br>
                <input type="text" class="border border-gray-400 p-1 w-80 " id="area">
            </div>
            <div class="w-1/4">
                <label for="Inspector">Inspector</label><br>
                <input type="text" class="border border-gray-400 p-1 w-80 " id="inspector">
            </div>
            <div class="w-1/5.4">
                <label for="fecha">Fecha</label><br>
                <input type="date" class="border border-gray-400 p-1 w-80 " id="fecha">
            </div>
        </div>
        
        <table class="w-full border-collapse border border-gray-400 text-sm mt-[-10px]">
            <thead>
                <tr>
                    <th class="border border-gray-400 p-2">ITEM</th>
                    <th class="border border-gray-400 p-2">PARAMETROS A REVISAR</th>
                    <th class="border border-gray-400 p-2">SI</th>
                    <th class="border border-gray-400 p-1">NO</th>
                    <th class="border border-gray-400 p-2">ACCION DE MEJORAMIENTO</th>
                </tr>
            </thead>
            <tbody id="table-body">
                <tr>
                    <td class="border border-gray-400 p-1 text-center"><p>1</p></td>
                    <td class="border border-gray-400 p-1"><p>Existen sobre el escritorio documentos y elementos innecesarios.</p></td>
                    <td class="border border-gray-400 p-1 text-center"><input type="radio" name="si-no-1" value="si"></td>
                    <td class="border border-gray-400 p-1 text-center"><input type="radio" name="si-no-1" value="no"></td>
                    <td class="border border-gray-400 p-1" style="width: 300px;">
                        <input placeholder="-" type="text" class="w-full border-none p-1 text-xs" maxlength="42" 
                            oninput="moveToNext(event, this.nextElementSibling)" onkeydown="moveToPrevious(event, this)">
                        <input type="text" class="w-full border-none p-1 text-xs" maxlength="42" 
                            onkeydown="moveToPrevious(event, this)">
                    </td>  
                </tr>
                <tr>
                    <td class="border border-gray-400 p-1 text-center"><p>2</p></td>
                    <td class="border border-gray-400 p-1"><p>Se encuentra el puesto de trabajo sucio (polvo, restos de alimento, ganchos, etc).</p></td>
                    <td class="border border-gray-400 p-1 text-center"><input type="radio" name="si-no-2" value="si"></td>
                    <td class="border border-gray-400 p-1 text-center"><input type="radio" name="si-no-2" value="no"></td>
                    <td class="border border-gray-400 p-1" style="width: 300px;">
                        <input placeholder="-" type="text" class="w-full border-none p-1 text-xs" maxlength="42" 
                            oninput="moveToNext(event, this.nextElementSibling)" onkeydown="moveToPrevious(event, this)">
                        <input type="text" class="w-full border-none p-1 text-xs" maxlength="42" 
                            onkeydown="moveToPrevious(event, this)">
                    </td>  
                </tr>
                <tr>
                    <td class="border border-gray-400 p-1 text-center"><p>3</p></td>
                    <td class="border border-gray-400 p-1"><p>Los vidrios, ventanas o puertas se observan sucios o con elementos instalados o en mal funcionamiento.</p></td>
                    <td class="border border-gray-400 p-1 text-center"><input type="radio" name="si-no-3" value="si"></td>
                    <td class="border border-gray-400 p-1 text-center"><input type="radio" name="si-no-3" value="no"></td>
                    <td class="border border-gray-400 p-1" style="width: 300px;">
                        <input placeholder="-" type="text" class="w-full border-none p-1 text-xs" maxlength="42" 
                            oninput="moveToNext(event, this.nextElementSibling)" onkeydown="moveToPrevious(event, this)">
                        <input type="text" class="w-full border-none p-1 text-xs" maxlength="42" 
                            onkeydown="moveToPrevious(event, this)">
                    </td>  
                </tr>
                <tr>
                    <td class="border border-gray-400 p-1 text-center"><p>4</p></td>
                    <td class="border border-gray-400 p-1"><p>Las AZ y carpetas se encuentran sin rótulos.</p></td>
                    <td class="border border-gray-400 p-1 text-center"><input type="radio" name="si-no-4" value="si"></td>
                    <td class="border border-gray-400 p-1 text-center"><input type="radio" name="si-no-4" value="no"></td>
                    <td class="border border-gray-400 p-1" style="width: 300px;">
                        <input placeholder="-" type="text" class="w-full border-none p-1 text-xs" maxlength="42" 
                            oninput="moveToNext(event, this.nextElementSibling)" onkeydown="moveToPrevious(event, this)">
                        <input type="text" class="w-full border-none p-1 text-xs" maxlength="42" 
                            onkeydown="moveToPrevious(event, this)">
                    </td>  
                </tr>
                <tr>
                    <td class="border border-gray-400 p-1 text-center"><p>5</p></td>
                    <td class="border border-gray-400 p-1"><p>Los libros, carpetas, AZ no se encuentran en los estantes.</p></td>
                    <td class="border border-gray-400 p-1 text-center"><input type="radio" name="si-no-5" value="si"></td>
                    <td class="border border-gray-400 p-1 text-center"><input type="radio" name="si-no-5" value="no"></td>
                    <td class="border border-gray-400 p-1" style="width: 300px;">
                        <input placeholder="-" type="text" class="w-full border-none p-1 text-xs" maxlength="42" 
                            oninput="moveToNext(event, this.nextElementSibling)" onkeydown="moveToPrevious(event, this)">
                        <input type="text" class="w-full border-none p-1 text-xs" maxlength="42" 
                            onkeydown="moveToPrevious(event, this)">
                    </td>  
                </tr>
                <tr>
                    <td class="border border-gray-400 p-1 text-center"><p>6</p></td>
                    <td class="border border-gray-400 p-1"><p>Los cajones de los escritorios se encuentran abiertos.</p></td>
                    <td class="border border-gray-400 p-1 text-center"><input type="radio" name="si-no-6" value="si"></td>
                    <td class="border border-gray-400 p-1 text-center"><input type="radio" name="si-no-6" value="no"></td>
                    <td class="border border-gray-400 p-1" style="width: 300px;">
                        <input placeholder="-" type="text" class="w-full border-none p-1 text-xs" maxlength="42" 
                            oninput="moveToNext(event, this.nextElementSibling)" onkeydown="moveToPrevious(event, this)">
                        <input type="text" class="w-full border-none p-1 text-xs" maxlength="42" 
                            onkeydown="moveToPrevious(event, this)">
                    </td>  
                </tr>
                <tr>
                    <td class="border border-gray-400 text-center"><p>7</p></td>
                    <td class="border border-gray-400 P-1"><p>Se encuentran obstruidas las salidas, corredores o pasillos (cajas, elementos, etc).</p></td>
                    <td class="border border-gray-400 text-center"><input type="radio" name="si-no-7" value="si"></td>
                    <td class="border border-gray-400 text-center"><input type="radio" name="si-no-7" value="no"></td>
                    <td class="border border-gray-400" style="width: 300px;">
                        <input placeholder="-" type="text" class="w-full border-none p-1 text-xs" maxlength="42" 
                            oninput="moveToNext(event, this.nextElementSibling)" onkeydown="moveToPrevious(event, this)">
                        <input type="text" class="w-full border-none p-1 text-xs" maxlength="42" 
                            onkeydown="moveToPrevious(event, this)">
                    </td> 
                </tr>
                <tr>
                    <td class="border border-gray-400 text-center"><p>8</p></td>
                    <td class="border border-gray-400 P-1"><p>Cuentan con elementos ajenos o los propios de la oficina como llaves, cargadores, gabinetes, bibliotecas personales, etc.</p></td>
                    <td class="border border-gray-400 text-center"><input type="radio" name="si-no-8" value="si"></td>
                    <td class="border border-gray-400 text-center"><input type="radio" name="si-no-8" value="no"></td>
                    <td class="border border-gray-400" style="width: 300px;">
                        <input placeholder="-" type="text" class="w-full border-none p-1 text-xs" maxlength="42" 
                            oninput="moveToNext(event, this.nextElementSibling)" onkeydown="moveToPrevious(event, this)">
                        <input type="text" class="w-full border-none p-1 text-xs" maxlength="42" 
                            onkeydown="moveToPrevious(event, this)">
                    </td> 
                </tr>
                <tr>
                    <td class="border border-gray-400 text-center"><p>9</p></td>
                    <td class="border border-gray-400 P-1"><p>Los escritorios, gabinetes o bibliotecas presentan elementos innecesarios.</p></td>
                    <td class="border border-gray-400 text-center"><input type="radio" name="si-no-9" value="si"></td>
                    <td class="border border-gray-400 text-center"><input type="radio" name="si-no-9" value="no"></td>
                    <td class="border border-gray-400" style="width: 300px;">
                        <input placeholder="-" type="text" class="w-full border-none p-1 text-xs" maxlength="42" 
                            oninput="moveToNext(event, this.nextElementSibling)" onkeydown="moveToPrevious(event, this)">
                        <input type="text" class="w-full border-none p-1 text-xs" maxlength="42" 
                            onkeydown="moveToPrevious(event, this)">
                    </td> 
                </tr>
                <tr>
                    <td class="border border-gray-400 text-center"><p>10</p></td>
                    <td class="border border-gray-400 P-1"><p>Faltan recipientes adecuados para basura.</p></td>
                    <td class="border border-gray-400 text-center"><input type="radio" name="si-no-10" value="si"></td>
                    <td class="border border-gray-400 text-center"><input type="radio" name="si-no-10" value="no"></td>
                    <td class="border border-gray-400" style="width: 300px;">
                        <input placeholder="-" type="text" class="w-full border-none p-1 text-xs" maxlength="42" 
                            oninput="moveToNext(event, this.nextElementSibling)" onkeydown="moveToPrevious(event, this)">
                        <input type="text" class="w-full border-none p-1 text-xs" maxlength="42" 
                            onkeydown="moveToPrevious(event, this)">
                    </td> 
                </tr>
                <tr>
                    <td class="border border-gray-400 text-center"><p>11</p></td>
                    <td class="border border-gray-400 P-1"><p>La cocina se encuentra organizada y sin deficiencias de las instalaciones hídricas y de desagüe.</p></td>
                    <td class="border border-gray-400 text-center"><input type="radio" name="si-no-11" value="si"></td>
                    <td class="border border-gray-400 text-center"><input type="radio" name="si-no-11" value="no"></td>
                    <td class="border border-gray-400" style="width: 300px;">
                        <input placeholder="-" type="text" class="w-full border-none p-1 text-xs" maxlength="42" 
                            oninput="moveToNext(event, this.nextElementSibling)" onkeydown="moveToPrevious(event, this)">
                        <input type="text" class="w-full border-none p-1 text-xs" maxlength="42" 
                            onkeydown="moveToPrevious(event, this)">
                    </td> 
                </tr>
                <tr>
                    <td class="border border-gray-400 text-center"><p>12</p></td>
                    <td class="border border-gray-400 P-1"><p>La cocina esta limpia y en orden.</p></td>
                    <td class="border border-gray-400 text-center"><input type="radio" name="si-no-12" value="si"></td>
                    <td class="border border-gray-400 text-center"><input type="radio" name="si-no-12" value="no"></td>
                    <td class="border border-gray-400" style="width: 300px;">
                        <input placeholder="-" type="text" class="w-full border-none p-1 text-xs" maxlength="42" 
                            oninput="moveToNext(event, this.nextElementSibling)" onkeydown="moveToPrevious(event, this)">
                        <input type="text" class="w-full border-none p-1 text-xs" maxlength="42" 
                            onkeydown="moveToPrevious(event, this)">
                    </td> 
                </tr>
            </tbody>
        </table><br>
        
        <table class="w-full border-collapse border border-gray-400 text-sm mt-[-15px]">
            <thead class="bg-[#E1EEE2]">
                <tr>
                    <th class="border border-gray-400 p-2 w-96">OBSERVACIONES</th>
                    <th class="border border-gray-400 p-2 w-40">NOMBRE DE LA PERSONA QUE REVISO</th>
                    <th class="border border-gray-400 p-2 w-20">PROXIMA REVISIÓN</th>
                </tr>
            </thead>
            <tbody id="table-body">
            <tr>
                <td class="border border-gray-400 p-0"><input class="border-none py-1 text-xs w-[900px]" type="text" placeholder="-"/></td>
                <td class="border border-gray-400 p-0"><input class="border-none py-1 text-xs w-[350px]" type="text" placeholder="-"/></td>
                <td class="border border-gray-400 p-0 text-center"><input class="border-none py-1 text-xs" type="date"/></td>
            </tr>
            <tr>
                <td class="border border-gray-400 p-0"><input class="border-none py-1 text-xs w-[900px]" type="text" placeholder="-"/></td>
                <td class="border border-gray-400 p-0"><input class="border-none py-1 text-xs w-[350px]" type="text" placeholder="-"/></td>
                <td class="border border-gray-400 p-0 text-center"><input class="border-none py-1 text-xs" type="date"/></td>
            </tr>
            <tr>
                <td class="border border-gray-400 p-0"><input class="border-none py-1 text-xs w-[900px]" type="text" placeholder="-"/></td>
                <td class="border border-gray-400 p-0"><input class="border-none py-1 text-xs w-[350px]" type="text" placeholder="-"/></td>
                <td class="border border-gray-400 p-0 text-center"><input class="border-none py-1 text-xs" type="date"/></td>
            </tr>
            </tbody>
        </table>
<script src="/static/js/inspeccionOrdenAseo.js"></script>
</body>
</html>