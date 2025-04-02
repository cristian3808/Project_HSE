<?php
require_once  'php/inspeccionPuestoTrabajo.php';
?>
<html>
<head>
    <meta charset="UTF-8">
    <title>Inspección de Puestos de Trabajo y Locativas</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sigN/Ature_pad@4.0.0/dist/sigN/Ature_pad.umd.min.js"></script>
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
                <h2 class="text-md">INSPECCIÓN DE PUESTO DE TRABAJO Y LOCATIVAS</h2>
            </div>
            <div>
                <span class="block text-right">VERSIÓN: 5</span>
                <span class="block text-right">F-HS-09</span>
            </div>
        </div>

        <div class="mb-4 grid grid-rows-2 grid-cols-2 gap-4">
            <div>
                <label for="Localizacion" class="text-base">Localización</label>
                <p><input class="border p-1 w-full" type="text" id="locacion" minlength="5" maxlength="50"/></p>
            </div>
            <div>
                <label for="Fecha">Fecha</label>
                <p><input class="border p-1 w-full" type="date" id="fecha"/></p>
            </div>  
            <div>
                <label for="Inspector">Inspector</label>
                <p><input class="border p-1 w-full" type="text" id="inspector" minlength="5" maxlength="50"/></p>
            </div>
            <div>
                <label for="Hora">Hora</label>
                <p><input class="border p-1 w-full" type="time" id="hora"/></p>
            </div>
        </div>

    <div class="mt-4">
        <p class="text-sm"><strong>Clasificación de los riesgos:</strong></p>
        <p class="text-base"><strong>A:</strong>  Cualquier condición o práctica subestandar que pueda causar muerte, lesión total, permanente y/o daños catastróficos a la propiedad.</p>
        <p class="text-base"><strong>B:</strong>  Cualquier condición o práctica subestandar que pueda causar lesión/enfermedad grave,incapacidad temporal o daño a la propiedad que es destructiva pero menos grave. </p>
        <p class="text-base"><strong>C:</strong>  Cualquier condición o práctica subestandar que pueda causar lesión/enfermedad grave leve, no incapacitante, y/o daño a la propiedad menor que no es destructivo. </p>
    </div>
    <form class="mt-4">
        <table class="w-full border-collapse border border-gray-400 text-sm mt-[-4px]">
            <thead class="bg-[#E1EEE2]">
                <tr>
                    <th class="border border-gray-400 p-2 w-80">AGENTES GENERADORES DE RIESGO</th>
                    <th class="border border-gray-400 p-2 w-12">CLASE DE RIESGO</th>
                    <th class="border border-gray-400 p-2 w-12">CUMPLE</th>
                    <th class="border border-gray-400 p-2 ">RECOMENDACIONES</th>
                </tr>
            </thead>
            <tbody id="table-body">
                <tr>
                    <td class="border border-gray-400 p-1 text-base">Instalaciones eléctricas: Alambres, cables, conexiones a tierra, enchufes, conexión de equipos a tomas reguladas.</td>
                    <td class="border border-gray-400 p-2 text-center">
                        <select class="w-full border-none p-1 text-base">
                            <option value="">Seleccione</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                        </select>
                    </td>
                    <td class="border border-gray-400 p-2 text-center">
                        <select class="w-full border-none p-1 text-base">
                            <option value="">Seleccione</option>
                            <option value="SI">SI</option>
                            <option value="NO">NO</option>
                            <option value="N/A">N/A</option>
                        </select>
                    </td>
                    <td class="border border-gray-400 p-2" style="width: 200px;">
                        <input placeholder="-" type="text" class="w-full border-none p-1 text-base" maxlength="40" 
                        oninput="moveToNext(event, this.nextElementSibling)" onkeydown="moveToPrevious(event, this)">
                    </td> 
                </tr>
                <tr>
                    <td class="border border-gray-400 p-1 text-base">Superficies de trabajo y desplazamiento: pisos y techos.</td>
                    <td class="border border-gray-400 p-2 text-center">
                        <select class="w-full border-none p-1 text-base">
                            <option value="">Seleccione</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                        </select>
                    </td>
                    <td class="border border-gray-400 p-2 text-center">
                        <select class="w-full border-none p-1 text-base">
                            <option value="">Seleccione</option>
                            <option value="SI">SI</option>
                            <option value="NO">NO</option>
                            <option value="N/A">N/A</option>
                        </select>
                    </td>
                    <td class="border border-gray-400 p-2" style="width: 200px;">
                        <input placeholder="-" type="text" class="w-full border-none p-1 text-base" maxlength="40" 
                        oninput="moveToNext(event, this.nextElementSibling)" onkeydown="moveToPrevious(event, this)">
                    </td> 
                </tr>
                <tr>
                    <td class="border border-gray-400 p-1 text-base">Estado del equipo contra incendio, señalización, acceso, fecha de vencimiento.</td>
                    <td class="border border-gray-400 p-2 text-center">
                        <select class="w-full border-none p-1 text-base">
                            <option value="">Seleccione</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                        </select>
                    </td>
                    <td class="border border-gray-400 p-2 text-center">
                        <select class="w-full border-none p-1 text-base">
                            <option value="">Seleccione</option>
                            <option value="SI">SI</option>
                            <option value="NO">NO</option>
                            <option value="N/A">N/A</option>
                        </select>
                    </td>
                    <td class="border border-gray-400 p-2" style="width: 200px;">
                        <input placeholder="-" type="text" class="w-full border-none p-1 text-base" maxlength="40" 
                        oninput="moveToNext(event, this.nextElementSibling)" onkeydown="moveToPrevious(event, this)">
                    </td> 
                </tr>
                <tr>
                    <td class="border border-gray-400 p-1 text-base">Vías de evacuación, señalización, visibilidad, accesos no obstruidos.</td>
                    <td class="border border-gray-400 p-2 text-center">
                        <select class="w-full border-none p-1 text-base">
                            <option value="">Seleccione</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                        </select>
                    </td>
                    <td class="border border-gray-400 p-2 text-center">
                        <select class="w-full border-none p-1 text-base">
                            <option value="">Seleccione</option>
                            <option value="SI">SI</option>
                            <option value="NO">NO</option>
                            <option value="N/A">N/A</option>
                        </select>
                    </td>
                    <td class="border border-gray-400 p-2" style="width: 200px;">
                        <input placeholder="-" type="text" class="w-full border-none p-1 text-base" maxlength="40" 
                        oninput="moveToNext(event, this.nextElementSibling)" onkeydown="moveToPrevious(event, this)">
                    </td> 
                </tr>
                <tr>
                    <td class="border border-gray-400 p-1 text-base">Orden de aseo del puesto de trabajo.</td>
                    <td class="border border-gray-400 p-2 text-center">
                        <select class="w-full border-none p-1 text-base">
                            <option value="">Seleccione</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                        </select>
                    </td>
                    <td class="border border-gray-400 p-2 text-center">
                        <select class="w-full border-none p-1 text-base">
                            <option value="">Seleccione</option>
                            <option value="SI">SI</option>
                            <option value="NO">NO</option>
                            <option value="N/A">N/A</option>
                        </select>
                    </td>
                    <td class="border border-gray-400 p-2" style="width: 200px;">
                        <input placeholder="-" type="text" class="w-full border-none p-1 text-base" maxlength="40" 
                        oninput="moveToNext(event, this.nextElementSibling)" onkeydown="moveToPrevious(event, this)">
                    </td> 
                </tr>
                <tr>
                    <td class="border border-gray-400 p-1 text-base">Condiciones de saneamiento básico: residuos sólidos.</td>
                    <td class="border border-gray-400 p-2 text-center">
                        <select class="w-full border-none p-1 text-base">
                            <option value="">Seleccione</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                        </select>
                    </td>
                    <td class="border border-gray-400 p-2 text-center">
                        <select class="w-full border-none p-1 text-base">
                            <option value="">Seleccione</option>
                            <option value="SI">SI</option>
                            <option value="NO">NO</option>
                            <option value="N/A">N/A</option>
                        </select>
                    </td>
                    <td class="border border-gray-400 p-2" style="width: 200px;">
                        <input placeholder="-" type="text" class="w-full border-none p-1 text-base" maxlength="40" 
                        oninput="moveToNext(event, this.nextElementSibling)" onkeydown="moveToPrevious(event, this)">
                    </td>                 
                </tr>
                <tr>
                    <td class="border border-gray-400 p-1 text-base">Elementos de protección personal (EPP),dotación,conocimiento de su mantenimiento.</td>
                    <td class="border border-gray-400 p-2 text-center">
                        <select class="w-full border-none p-1 text-base">
                            <option value="">Seleccione</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                        </select>
                    </td>
                    <td class="border border-gray-400 p-2 text-center">
                        <select class="w-full border-none p-1 text-base">
                            <option value="">Seleccione</option>
                            <option value="SI">SI</option>
                            <option value="NO">NO</option>
                            <option value="N/A">N/A</option>
                        </select>
                    </td>
                    <td class="border border-gray-400 p-2" style="width: 200px;">
                        <input placeholder="-" type="text" class="w-full border-none p-1 text-base" maxlength="40" 
                        oninput="moveToNext(event, this.nextElementSibling)" onkeydown="moveToPrevious(event, this)">
                    </td>   
                </tr>
                <tr>
                    <td class="border border-gray-400 p-1 text-base">Exposición a compuestos químicos inflamables y explosivos (líquidos, sólidos o gaseosos).</td>
                    <td class="border border-gray-400 p-2 text-center">
                        <select class="w-full border-none p-1 text-base">
                            <option value="">Seleccione</option>
                            <option value="A"> A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                        </select>
                    </td>
                    <td class="border border-gray-400 p-2 text-center">
                        <select class="w-full border-none p-1 text-base">
                            <option value="">Seleccione</option>
                            <option value="SI">SI</option>
                            <option value="NO">NO</option>
                            <option value="N/A">N/A</option>
                        </select>
                    </td>
                    <td class="border border-gray-400 p-2" style="width: 200px;">
                        <input placeholder="-" type="text" class="w-full border-none p-1 text-base" maxlength="40" 
                        oninput="moveToNext(event, this.nextElementSibling)" onkeydown="moveToPrevious(event, this)">
                    </td>                
                </tr>
                <tr>
                    <td class="border border-gray-400 p-1 text-base">Exposición a ruidos permanente (Ocasionado por maquinas o equipo).</td>
                    <td class="border border-gray-400 p-2 text-center">
                        <select class="w-full border-none p-1 text-base">
                            <option value="">Seleccione</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                        </select>
                    </td>
                    <td class="border border-gray-400 p-2 text-center">
                        <select class="w-full border-none p-1 text-base">
                            <option value="">Seleccione</option>
                            <option value="SI">SI</option>
                            <option value="NO">NO</option>
                            <option value="N/A">N/A</option>
                        </select>
                    </td>
                    <td class="border border-gray-400 p-2" style="width: 200px;">
                        <input placeholder="-" type="text" class="w-full border-none p-1 text-base" maxlength="40" 
                        oninput="moveToNext(event, this.nextElementSibling)" onkeydown="moveToPrevious(event, this)">
                    </td>
                </tr>
                <tr>
                    <td class="border border-gray-400 p-1 text-base">Condiciones de iluminación (limpieza de lámparas y luminarias) y ventilación del puesto de trabajo.</td>
                    <td class="border border-gray-400 p-2 text-center">
                        <select class="w-full border-none p-1 text-base">
                            <option value="">Seleccione</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                        </select>
                    </td>
                    <td class="border border-gray-400 p-2 text-center">
                        <select class="w-full border-none p-1 text-base">
                            <option value="">Seleccione</option>
                            <option value="SI">SI</option>
                            <option value="NO">NO</option>
                            <option value="N/A">N/A</option>
                        </select>
                    </td>
                    <td class="border border-gray-400 p-2" style="width: 200px;">
                        <input placeholder="-" type="text" class="w-full border-none p-1 text-base" maxlength="40" 
                        oninput="moveToNext(event, this.nextElementSibling)" onkeydown="moveToPrevious(event, this)">
                    </td>
                </tr>
                <tr>
                    <td class="border border-gray-400 p-1 text-base">Condiciones ergonómicas del puesto de trabajo, (sillas inadecuadas, escritorios, levantamiento y transporte de cargas).</td>
                    <td class="border border-gray-400 p-2 text-center">
                        <select class="w-full border-none p-1 text-base">
                            <option value="">Seleccione</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                        </select>
                    </td>
                    <td class="border border-gray-400 p-2 text-center">
                        <select class="w-full border-none p-1 text-base">
                            <option value="">Seleccione</option>
                            <option value="SI">SI</option>
                            <option value="NO">NO</option>
                            <option value="N/A">N/A</option>
                        </select>
                    </td>
                    <td class="border border-gray-400 p-2" style="width: 200px;">
                        <input placeholder="-" type="text" class="w-full border-none p-1 text-base" maxlength="40" 
                        oninput="moveToNext(event, this.nextElementSibling)" onkeydown="moveToPrevious(event, this)">
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
    <table class="w-full border-collapse border border-gray-400 text-sm mt-[-4px]">
            <thead class="bg-[#E1EEE2]">
                <tr>
                    <th class="border border-gray-400 p-2">ACCIÓN CORRECTIVA Y/O PREVENTIVA</th>
                    <th class="border border-gray-400 p-2">RESPONSABLE</th>
                    <th class="border border-gray-400 p-2">FECHA DE CUMPLIMIENTO</th>
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
        </body>
    </table>
<script src="/static/js/inspeccionPuestoTrabajo.js"></script>
</body>
</html>