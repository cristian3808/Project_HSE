<?php
require_once  'php/inspeccionCafeteria.php';
?>
<html>
<head>
    <meta charset="UTF-8">  
    <title>Inspección de Cafetería</title>
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
            <h1 class="text-lg font-bold">GESTIÓN DE SEGURIDAD Y SALUD EN EL TRABAJO</h1>
            <h2 class="text-md">INSPECCIÓN DE CAFETERÍA</h2>
        </div>
    <div>
    <span class="block text-right">VERSIÓN: 3</span>
    <span class="block text-right">F-HS-19</span>
</div>
    </div>
    
    <div class="mb-4 grid grid-cols-2 gap-8">
    <div>
        <label for="nombreInspector" class="text-sm">Nombre Inspector</label>
        <input class="border p-2 w-full" type="text" id="nombreInspector" minlength="5" maxlength="50"/>
    </div>
    <div>
        <label for="fecha" class="text-sm">Fecha</label>
        <input class="border p-2 w-full" type="date" id="fecha" />
    </div>
</div>

    <form>
        <table class="w-full border-collapse border border-gray-400 text-sm">
        <thead class="bg-[#E1EEE2]">
            <tr>
                <th class="border border-gray-400 p-1 w-40">INSTALACIONES</th>
                <th class="border border-gray-400 p-2 w-10">SI / NO</th>
                <th class="border border-gray-400 p-2 w-60">OBSERVACIONES</th>
            </tr>
        </thead>

            <tbody id="table-body">
                <tr>
                    <td class="border border-gray-400 p-2">Se encuentra en un sitio apropiado?</td>
                    <td class="border border-gray-400 p-2 text-center">
                        <select class="w-full border-none p-1 text-xs">
                            <option value="" selected>Seleccione</option>
                            <option value="SI">SI</option>
                            <option value="NO">NO</option>
                            <option value="N/A">N/A</option>
                        </select>
                    </td>
                    <td class="border border-gray-400 p-2" style="width: 200px;">
                        <input placeholder="-" type="text" class="w-full border-none p-1 text-xs" 
                            oninput="moveToNext(event, this.nextElementSibling)" onkeydown="moveToPrevious(event, this)">
                    </td>  
                </tr>
                <tr>
                    <td class="border border-gray-400 p-2">El suministro de agua es adecuado?</td>
                    <td class="border border-gray-400 p-2 text-center">
                        <select class="w-full border-none p-1 text-xs">
                            <option value="" selected>Seleccione</option>
                            <option value="SI">SI</option>
                            <option value="NO">NO</option>
                            <option value="N/A">N/A</option>
                        </select>
                    </td>
                    <td class="border border-gray-400 p-2" style="width: 200px;">
                        <input placeholder="-" type="text" class="w-full border-none p-1 text-xs" 
                            oninput="moveToNext(event, this.nextElementSibling)" onkeydown="moveToPrevious(event, this)">
                    </td>  
                </tr>
                <tr>
                    <td class="border border-gray-400 p-2">El agua que se consume es tratada?</td>
                    <td class="border border-gray-400 p-2 text-center">
                        <select class="w-full border-none p-1 text-xs">
                            <option value="" selected>Seleccione</option>
                            <option value="SI">SI</option>
                            <option value="NO">NO</option>
                            <option value="N/A">N/A</option>
                        </select>
                    </td>
                    <td class="border border-gray-400 p-2" style="width: 200px;">
                        <input placeholder="-" type="text" class="w-full border-none p-1 text-xs" 
                            oninput="moveToNext(event, this.nextElementSibling)" onkeydown="moveToPrevious(event, this)">
                    </td>  
                </tr>
                <tr>
                    <td class="border border-gray-400 p-2">Se han adelantado análisis de potabilidad de Aguas?</td>
                    <td class="border border-gray-400 p-2 text-center">
                        <select class="w-full border-none p-1 text-xs">
                            <option value="" selected>Seleccione</option>
                            <option value="SI">SI</option>
                            <option value="NO">NO</option>
                            <option value="N/A">N/A</option>
                        </select>
                    </td>
                    <td class="border border-gray-400 p-2" style="width: 200px;">
                        <input placeholder="-" type="text" class="w-full border-none p-1 text-xs"
                            oninput="moveToNext(event, this.nextElementSibling)" onkeydown="moveToPrevious(event, this)">
                    </td>  
                </tr>
                <tr>
                    <td class="border border-gray-400 p-2">Cuentan con avisos de señalización?</td>
                    <td class="border border-gray-400 p-2 text-center">
                        <select class="w-full border-none p-1 text-xs">
                            <option value="" selected>Seleccione</option>
                            <option value="SI">SI</option>
                            <option value="NO">NO</option>
                            <option value="N/A">N/A</option>
                        </select>
                    </td>
                    <td class="border border-gray-400 p-2" style="width: 200px;">
                        <input placeholder="-" type="text" class="w-full border-none p-1 text-xs" 
                            oninput="moveToNext(event, this.nextElementSibling)" onkeydown="moveToPrevious(event, this)">
                    </td>  
                </tr>
                <tr>
                    <td class="border border-gray-400 p-2">Las basuras son clasificadas?</td>
                    <td class="border border-gray-400 p-2 text-center">
                        <select class="w-full border-none p-1 text-xs">
                            <option value="" selected>Seleccione</option>
                            <option value="SI">SI</option>
                            <option value="NO">NO</option>
                            <option value="N/A">N/A</option>
                        </select>
                    </td>
                    <td class="border border-gray-400 p-2" style="width: 200px;">
                        <input placeholder="-" type="text" class="w-full border-none p-1 text-xs" 
                            oninput="moveToNext(event, this.nextElementSibling)" onkeydown="moveToPrevious(event, this)">
                    </td>  
                </tr>
                <tr>
                    <td class="border border-gray-400 p-2">Hay sitio adecuado para las basuras?</td>
                    <td class="border border-gray-400 p-2 text-center">
                        <select class="w-full border-none p-1 text-xs">
                            <option value="" selected>Seleccione</option>
                            <option value="SI">SI</option>
                            <option value="NO">NO</option>
                            <option value="N/A">N/A</option>
                        </select>
                    </td>
                    <td class="border border-gray-400 p-2" style="width: 200px;">
                        <input placeholder="-" type="text" class="w-full border-none p-1 text-xs" 
                            oninput="moveToNext(event, this.nextElementSibling)" onkeydown="moveToPrevious(event, this)">
                    </td>  
                </tr>
                <tr>
                    <td class="border border-gray-400 p-2">Las instalaciones eléctricas son adecuadas?</td>
                    <td class="border border-gray-400 p-2 text-center">
                        <select class="w-full border-none p-1 text-xs">
                            <option value="" selected>Seleccione</option>
                            <option value="SI">SI</option>
                            <option value="NO">NO</option>
                            <option value="N/A">N/A</option>
                        </select>
                    </td>
                    <td class="border border-gray-400 p-2" style="width: 200px;">
                        <input placeholder="-" type="text" class="w-full border-none p-1 text-xs"  
                            oninput="moveToNext(event, this.nextElementSibling)" onkeydown="moveToPrevious(event, this)">
                    </td>  
                </tr>
                <tr>
                    <td class="border border-gray-400 p-2">Se revisa redes de gas domiciliario?</td>
                    <td class="border border-gray-400 p-2 text-center">
                        <select class="w-full border-none p-1 text-xs">
                            <option value="" selected>Seleccione</option>
                            <option value="SI">SI</option>
                            <option value="NO">NO</option>
                            <option value="N/A">N/A</option>
                        </select>
                    </td>
                    <td class="border border-gray-400 p-2" style="width: 200px;">
                        <input placeholder="-" type="text" class="w-full border-none p-1 text-xs" 
                            oninput="moveToNext(event, this.nextElementSibling)" onkeydown="moveToPrevious(event, this)">
                    </td>  
                </tr>
            </tbody>
        </table>
        <table class="w-full border-collapse border border-bg-[#E1EEE2]0 text-sm mt-4">
            <thead class="bg-[#E1EEE2]">
                <tr>
                    <th class="border border-gray-400 p-2 w-40">IMPLEMENTOS DE SEGURIDAD</th>
                    <th class="border border-gray-400 p-2 w-10">SI / NO</th>
                    <th class="border border-gray-400 p-2 w-60">OBSERVACIONES</th>
                </tr>
            </thead>
            <tbody id="table-body">
                <tr>
                    <td class="border border-gray-400 p-2">Hay extintor en la cafetería</td>
                    <td class="border border-gray-400 p-2 text-center">
                        <select class="w-full border-none p-1 text-xs">
                            <option value="" selected>Seleccione</option>
                            <option value="SI">SI</option>
                            <option value="NO">NO</option>
                            <option value="N/A">N/A</option>
                        </select>
                    </td>
                    <td class="border border-gray-400 p-2" style="width: 200px;">
                        <input placeholder="-" type="text" class="w-full border-none p-1 text-xs"  
                            oninput="moveToNext(event, this.nextElementSibling)" onkeydown="moveToPrevious(event, this)">
                    </td>  
                </tr>
                <tr>
                    <td class="border border-gray-400 p-2">Hay botiquín de primeros auxilios en la cocina?</td>
                    <td class="border border-gray-400 p-2 text-center">
                        <select class="w-full border-none p-1 text-xs">
                            <option value="" selected>Seleccione</option>
                            <option value="SI">SI</option>
                            <option value="NO">NO</option>
                            <option value="N/A">N/A</option>
                        </select>
                    </td>
                    <td class="border border-gray-400 p-2" style="width: 200px;">
                        <input placeholder="-" type="text" class="w-full border-none p-1 text-xs"  
                            oninput="moveToNext(event, this.nextElementSibling)" onkeydown="moveToPrevious(event, this)">
                    </td>  
                </tr>
                <tr>
                    <td class="border border-gray-400 p-2">Se cuenta con avisos de seguridad de Higiene en el sitio de trabajo?</td>
                    <td class="border border-gray-400 p-2 text-center">
                        <select class="w-full border-none p-1 text-xs">
                            <option value="" selected>Seleccione</option>
                            <option value="SI">SI</option>
                            <option value="NO">NO</option>
                            <option value="N/A">N/A</option>
                        </select>
                    </td>
                    <td class="border border-gray-400 p-2" style="width: 200px;">
                        <input placeholder="-" type="text" class="w-full border-none p-1 text-xs" 
                            oninput="moveToNext(event, this.nextElementSibling)" onkeydown="moveToPrevious(event, this)">
                    </td>  
                </tr>
                <tr>
                    <td class="border border-gray-400 p-2">El personal identifica el punto de alarma de fuego cercano, las rutas de evacuación y el punto de encuentro?</td>
                    <td class="border border-gray-400 p-2 text-center">
                        <select class="w-full border-none p-1 text-xs">
                            <option value="" selected>Seleccione</option>
                            <option value="SI">SI</option>
                            <option value="NO">NO</option>
                            <option value="N/A">N/A</option>
                        </select>
                    </td>
                    <td class="border border-gray-400 p-2" style="width: 200px;">
                        <input placeholder="-" type="text" class="w-full border-none p-1 text-xs"  
                            oninput="moveToNext(event, this.nextElementSibling)" onkeydown="moveToPrevious(event, this)">
                    </td>  
                </tr>
            </tbody>
        </table>
    </form>
        <div class="border border-gray-400 p-2">
            <p class="font-semibold">NOMBRE DE QUIEN ATENDIÓ LA INSPECCIÓN</p>
            <input class="w-full border-none p-1 text-xs" type="text"/>
        </div>
    </div>
</div>
<script src="/static/js/inspeccionCafeteria.js"></script>
</body>
</html>