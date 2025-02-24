<?php
include_once  'php/inspeccionGerencial.php';
?>
<html>
<head>
    <meta charset="UTF-8">
    <title>Inspección Gerencial</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.0.0-rc.7/dist/html2canvas.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>
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
    <button onclick="window.location.href='index.php'" class="bg-green-800 hover:bg-green-600 text-white px-4 py-2 rounded flex items-center" id="back-btn">
        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
        Atrás
    </button>

    <div class="flex space-x-2">
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
</div>
<br>

<div class="bg-white p-8 rounded-lg shadow-lg no-shadow" id="form-content">
    <div class="flex justify-between items-center mb-6">
        <div>
            <a href="/index.php">
                <img src="/static/img/TF.png" alt="Logo de la empresa" class="h-24">
            </a>
        </div>
        <div class="text-center">
            <h1 class="text-xl font-bold">GESTIÓN GERENCIAL</h1>
            <h2 class="text-lg">INSPECCIÓN GERENCIAL</h2>
        </div>
        <div>
            <span class="block text-right text-base">VERSIÓN: 4</span>
            <span class="block text-right text-base">CÓDIGO: F-GE-02</span>
        </div>
    </div>

    <form>
    <div class="grid grid-cols-3 grid-rows-2 gap-4 mb-4">
        <div>
            <label class="text-base">Localización</label>
            <input type="text" class="w-full border border-gray-400 p-2 text-sm" id="localizacion" minlength="5" maxlength="50">
        </div>
        <div>
            <label class="text-base">Fecha</label>
            <input type="date" class="w-full border border-gray-400 p-2 text-sm" id="fecha">
        </div>
        <div>
            <label class="text-base">Inspección N°</label>
            <input type="text" class="w-full border border-gray-400 p-2 text-sm" id="inspeccion_n" minlength="5" maxlength="50">
        </div>
        <div>
            <label class="text-base">Hora</label>
            <input type="time" class="w-full border border-gray-400 p-2 text-sm" id="hora">
        </div>
        <div>
            <label class="text-base">Inspector</label>
            <input type="text" class="w-full border border-gray-400 p-2 text-sm" id="inspector" minlength="5" maxlength="50">
        </div>
    </div>

    <div class="mt-4">
        <p class="text-base font-bold">Clasificación de riesgos:</p>
        <p class="text-base"><strong>A:</strong> Riesgo que puede causar lesiones, daño a la propiedad o daño ambiental.</p>
        <p class="text-base"><strong>B:</strong> Riesgo que puede causar incapacidad temporal o daño a la propiedad que no es destructivo.</p>
        <p class="text-base"><strong>C:</strong> Riesgo que puede causar lesiones leves, daño a la propiedad que no es destructivo.</p>
    </div>

        <table class="w-full border-collapse border border-gray-400 text-sm mt-4">
            <thead class="bg-[#E1EEE2]">
                <tr>
                    <th class="border border-gray-400 p-2 w-96">AGENTES GENERADORES DE RIESGO</th>
                    <th class="border border-gray-400 p-2 w-14">CLASE DE RIESGO</th>
                    <th class="border border-gray-400 p-2 w-14">CUMPLE</th>
                    <th class="border border-gray-400 p-2">RECOMENDACIONES</th>
                </tr>
            </thead>
            <tbody id="table-body">
                <tr>
                    <td class="border border-gray-400 p-2">
                        <p class="text-base">Las áreas de trabajo están en completo orden y aseo.</p>
                    </td>
                    <td class="border border-gray-400 p-2 text-center">
                        <select class="w-full border-none p-1 text-base transparent-input">
                            <option value="" selected>Seleccione</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                        </select>
                    </td>
                    <td class="border border-gray-400 p-2 text-center">
                        <select class="w-full border-none p-1 text-base transparent-input">
                            <option value="" selected>Seleccione</option>
                            <option value="SI">SI</option>
                            <option value="NO">NO</option>
                            <option value="NO">N/A</option>
                        </select>
                    </td>
                    <td class="border border-gray-400 p-2" style="width: 200px;">
                        <input placeholder="-" type="text" class="w-full border-none p-1 text-base" maxlength="26" 
                            oninput="moveToNext(event, this.nextElementSibling)" onkeydown="moveToPrevious(event, this)">
                    </td>
                </tr>
                <tr>
                <td class="border border-gray-400 p-2">
                        <p class="text-base">La iluminación es adecuada para cada área de trabajo.</p>
                    </td>
                    <td class="border border-gray-400 p-2 text-center">
                        <select class="w-full border-none p-1 text-base transparent-input">
                            <option value="" selected>Seleccione</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                        </select>
                    </td>
                    <td class="border border-gray-400 p-2 text-center">
                        <select class="w-full border-none p-1 text-base transparent-input">
                            <option value="" selected>Seleccione</option>
                            <option value="SI">SI</option>
                            <option value="NO">NO</option>
                            <option value="NO">N/A</option>
                        </select>
                    </td>
                    <td class="border border-gray-400 p-2" style="width: 200px;">
                        <input placeholder="-" type="text" class="w-full border-none p-1 text-base" maxlength="26" 
                            oninput="moveToNext(event, this.nextElementSibling)" onkeydown="moveToPrevious(event, this)">
                    </td>
                </tr>
                <tr>
                <td class="border border-gray-400 p-2">
                    <p class="text-base">El personal cuenta con los elementos necesarios para el desarrollo de las labores.</p>
                    </td>
                    <td class="border border-gray-400 p-2 text-center">
                        <select class="w-full border-none p-1 text-base transparent-input">
                            <option value="" selected>Seleccione</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                        </select>
                    </td>
                    <td class="border border-gray-400 p-2 text-center">
                        <select class="w-full border-none p-1 text-base transparent-input">
                            <option value="" selected>Seleccione</option>
                            <option value="SI">SI</option>
                            <option value="NO">NO</option>
                            <option value="NO">N/A</option>
                        </select>
                    </td>
                    <td class="border border-gray-400 p-2" style="width: 200px;">
                        <input placeholder="-" type="text" class="w-full border-none p-1 text-base" maxlength="26" 
                            oninput="moveToNext(event, this.nextElementSibling)" onkeydown="moveToPrevious(event, this)">
                    </td>
                </tr>
                <tr>
                    <td class="border border-gray-400 p-2">
                        <p class="text-base">Los pisos, pasillos y escaleras están libres de materiales innecesarios, cables eléctricos que puedan obstruir o dificultar el paso.</p>
                    </td>
                    <td class="border border-gray-400 p-2 text-center">
                        <select class="w-full border-none p-1 text-base transparent-input">
                            <option value="" selected>Seleccione</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                        </select>
                    </td>
                    <td class="border border-gray-400 p-2 text-center">
                        <select class="w-full border-none p-1 text-base transparent-input">
                            <option value="" selected>Seleccione</option>
                            <option value="SI">SI</option>
                            <option value="NO">NO</option>
                            <option value="NO">N/A</option>
                        </select>
                    </td>
                    <td class="border border-gray-400 p-2" style="width: 200px;">
                        <input placeholder="-" type="text" class="w-full border-none p-1 text-base" maxlength="26" 
                            oninput="moveToNext(event, this.nextElementSibling)" onkeydown="moveToPrevious(event, this)">
                    </td>
                </tr>
                <tr>
                <td class="border border-gray-400 p-2">
                        <p class="text-base">Las herramientas se mantienen y se guardan limpias y en buen estado.</p>
                    </td>
                    <td class="border border-gray-400 p-2 text-center">
                        <select class="w-full border-none p-1 text-base transparent-input">
                            <option value="" selected>Seleccione</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                        </select>
                    </td>
                    <td class="border border-gray-400 p-2 text-center">
                        <select class="w-full border-none p-1 text-base transparent-input">
                            <option value="" selected>Seleccione</option>
                            <option value="SI">SI</option>
                            <option value="NO">NO</option>
                            <option value="NO">N/A</option>
                        </select>
                    </td>
                    <td class="border border-gray-400 p-2" style="width: 200px;">
                        <input placeholder="-" type="text" class="w-full border-none p-1 text-base" maxlength="26" 
                            oninput="moveToNext(event, this.nextElementSibling)" onkeydown="moveToPrevious(event, this)">
                    </td>
                </tr>
                <tr>
                    <td class="border border-gray-400 p-2">
                       <p class="text-base">Los residuos y basuras se clasifican de acuerdo con las normas de reciclaje y se disponen en canecas debidamente señalizadas.</p>
                    </td>
                    <td class="border border-gray-400 p-2 text-center">
                        <select class="w-full border-none p-1 text-base transparent-input">
                            <option value="" selected>Seleccione</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                        </select>
                    </td>
                    <td class="border border-gray-400 p-2 text-center">
                        <select class="w-full border-none p-1 text-base transparent-input">
                            <option value="" selected>Seleccione</option>
                            <option value="SI">SI</option>
                            <option value="NO">NO</option>
                            <option value="NO">N/A</option>
                        </select>
                    </td>
                    <td class="border border-gray-400 p-2" style="width: 200px;">
                        <input placeholder="-" type="text" class="w-full border-none p-1 text-base" maxlength="26" 
                            oninput="moveToNext(event, this.nextElementSibling)" onkeydown="moveToPrevious(event, this)">
                    </td>
                </tr>
                <tr>
                <td class="border border-gray-400 p-2">
                        <p class="text-base">Las instalaciones cuentan con un adecuado sistema de alarma.</p>
                    </td>
                    <td class="border border-gray-400 p-2 text-center">
                        <select class="w-full border-none p-1 text-base transparent-input">
                            <option value="" selected>Seleccione</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                        </select>
                    </td>
                    <td class="border border-gray-400 p-2 text-center">
                        <select class="w-full border-none p-1 text-base transparent-input">
                            <option value="" selected>Seleccione</option>
                            <option value="SI">SI</option>
                            <option value="NO">NO</option>
                            <option value="NO">N/A</option>
                        </select>
                    </td>
                    <td class="border border-gray-400 p-2" style="width: 200px;">
                        <input placeholder="-" type="text" class="w-full border-none p-1 text-base" maxlength="26" 
                            oninput="moveToNext(event, this.nextElementSibling)" onkeydown="moveToPrevious(event, this)">
                    </td>
                </tr>
                <tr>
                    <td class="border border-gray-400 p-2">
                       <p class="text-base">Las oficinas están libres de grietas, deterioramiento, humedad, las cuales pueden afectar la estructura de las áreas de trabajo.</p>
                    </td>
                    <td class="border border-gray-400 p-2 text-center">
                        <select class="w-full border-none p-1 text-base transparent-input">
                            <option value="" selected>Seleccione</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                        </select>
                    </td>
                    <td class="border border-gray-400 p-2 text-center">
                        <select class="w-full border-none p-1 text-base transparent-input">
                            <option value="" selected>Seleccione</option>
                            <option value="SI">SI</option>
                            <option value="NO">NO</option>
                            <option value="NO">N/A</option>
                        </select>
                    </td>
                    <td class="border border-gray-400 p-2" style="width: 200px;">
                        <input placeholder="-" type="text" class="w-full border-none p-1 text-base" maxlength="26" 
                            oninput="moveToNext(event, this.nextElementSibling)" onkeydown="moveToPrevious(event, this)">
                    </td>
                </tr>
                <tr>
                <td class="border border-gray-400 p-2">
                        <p class="text-base">Los EPP tiene un buen uso y mantenimiento adecuado.</p>
                    </td>
                    <td class="border border-gray-400 p-2 text-center">
                        <select class="w-full border-none p-1 text-base transparent-input">
                            <option value="" selected>Seleccione</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                        </select>
                    </td>
                    <td class="border border-gray-400 p-2 text-center">
                        <select class="w-full border-none p-1 text-base transparent-input">
                            <option value="" selected>Seleccione</option>
                            <option value="SI">SI</option>
                            <option value="NO">NO</option>
                            <option value="NO">N/A</option>
                        </select>
                    </td>
                    <td class="border border-gray-400 p-2" style="width: 200px;">
                        <input placeholder="-" type="text" class="w-full border-none p-1 text-base" maxlength="26" 
                            oninput="moveToNext(event, this.nextElementSibling)" onkeydown="moveToPrevious(event, this)">
                    </td>
                </tr>
                <tr>
                <td class="border border-gray-400 p-2">
                        <p class="text-base">La señalización de emergencias existe y es adecuada a la estructura de la empresa.</p>
                    </td>
                    <td class="border border-gray-400 p-2 text-center">
                        <select class="w-full border-none p-1 text-base transparent-input">
                            <option value="" selected>Seleccione</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                        </select>
                    </td>
                    <td class="border border-gray-400 p-2 text-center">
                        <select class="w-full border-none p-1 text-base transparent-input">
                            <option value="" selected>Seleccione</option>
                            <option value="SI">SI</option>
                            <option value="NO">NO</option>
                            <option value="NO">N/A</option>
                        </select>
                    </td>
                    <td class="border border-gray-400 p-2" style="width: 200px;">
                        <input placeholder="-" type="text" class="w-full border-none p-1 text-base" maxlength="26" 
                            oninput="moveToNext(event, this.nextElementSibling)" onkeydown="moveToPrevious(event, this)">
                    </td>
                </tr>
                <tr>
                <td class="border border-gray-400 p-2">
                       <p class="text-base">Los brigadistas cuentan con los equipos necesarios para atender una emergencia.</p>
                    </td>
                    <td class="border border-gray-400 p-2 text-center">
                        <select class="w-full border-none p-1 text-base transparent-input">
                            <option value="" selected>Seleccione</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                        </select>
                    </td>
                    <td class="border border-gray-400 p-2 text-center">
                        <select class="w-full border-none p-1 text-base transparent-input">
                            <option value="" selected>Seleccione</option>
                            <option value="SI">SI</option>
                            <option value="NO">NO</option>
                            <option value="NO">N/A</option>
                        </select>
                    </td>
                    <td class="border border-gray-400 p-2" style="width: 200px;">
                        <input placeholder="-" type="text" class="w-full border-none p-1 text-base" maxlength="26" 
                            oninput="moveToNext(event, this.nextElementSibling)" onkeydown="moveToPrevious(event, this)">
                    </td>
                </tr>
                <tr>
                <td class="border border-gray-400 p-2">
                        <p class="text-base">La camilla esta en ubicación y condiciones adecuadas.</p>
                    </td>
                    <td class="border border-gray-400 p-2 text-center">
                        <select class="w-full border-none p-1 text-base transparent-input">
                            <option value="" selected>Seleccione</option>
                            <option value="A">A</option>
                            <option value="B">B</option>
                            <option value="C">C</option>
                        </select>
                    </td>
                    <td class="border border-gray-400 p-2 text-center">
                        <select class="w-full border-none p-1 text-base transparent-input">
                            <option value="" selected>Seleccione</option>
                            <option value="SI">SI</option>
                            <option value="NO">NO</option>
                            <option value="NO">N/A</option>
                        </select>
                    </td>
                    <td class="border border-gray-400 p-2" style="width: 200px;">
                        <input placeholder="-" type="text" class="w-full border-none p-1 text-base" maxlength="26" 
                            oninput="moveToNext(event, this.nextElementSibling)" onkeydown="moveToPrevious(event, this)">
                    </td>
                </tr>
            </tbody>
        </table>
        
        <div class="mt-4">
            <table class="w-full border-collapse border border-gray-400 text-sm mt-2">
                <thead class="bg-[#E1EEE2]">
                    <tr>
                        <th class="border border-gray-400 p-2">ACCION CORRECTIVA Y/O PREVENTIVA</th>
                        <th class="border border-gray-400 p-2">RESPONSABLE</th>
                        <th class="border border-gray-400 p-2">FECHA DE CUMPLIMIENTO</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="border border-gray-400 p-2"><input type="text" class="w-full border-none p-1 text-base transparent-input"></td>
                        <td class="border border-gray-400 p-2"><input type="text" class="w-full border-none p-1 text-base transparent-input"></td>
                        <td class="border border-gray-400 p-2 w-1/4"><input type="date" class="w-full border-none p-1 text-base transparent-input"></td>
                    </tr>
                    <tr>
                        <td class="border border-gray-400 p-2"><input type="text" class="w-full border-none p-1 text-base transparent-input"></td>
                        <td class="border border-gray-400 p-2"><input type="text" class="w-full border-none p-1 text-base transparent-input"></td>
                        <td class="border border-gray-400 p-2 w-1/4"><input type="date" class="w-full border-none p-1 text-base transparent-input"></td>
                    </tr>
                    <tr>
                        <td class="border border-gray-400 p-2"><input type="text" class="w-full border-none p-1 text-base transparent-input"></td>
                        <td class="border border-gray-400 p-2"><input type="text" class="w-full border-none p-1 text-base transparent-input"></td>
                        <td class="border border-gray-400 p-2 w-1/4"><input type="date" class="w-full border-none p-1 text-base transparent-input"></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            <div class="flex justify-center space-x-80">
                <div class="flex flex-col items-center">
                    <label class="text-sm">FIRMA RESPONSABLE DE INSPECCIÓN</label>
                    <canvas class="signature-pad border border-gray-300" width="300" height="100"></canvas>
                    <div class="mt-2 flex flex-row space-x-2 justify-center">
                        <button type="button" class="bg-red-500 text-white px-2 py-1 rounded clear-signature flex items-center" onclick="clearSignature(1)">
                        <svg class="w-4 h-4 mr-2 text-red-200" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path d="M3 6h18v2H3V6zm3 3h12v13H6V9zm4-5h4v2h-4V4zM5 6h14v16a2 2 0 01-2 2H7a2 2 0 01-2-2V6zm6 5v3h3V11h-3z"/>
                        </svg>     
                        Limpiar</button>
                        <button type="button" class="bg-blue-500 text-white px-2 py-1 rounded hide-on-pdf flex items-center" onclick="document.getElementById('upload-signature-1').click();">
                            <svg class="w-4 h-4 mr-2 text-blue-200" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <path d="M12 2L8.59 5.41 13.17 10H4v2h9.17l-4.58 4.59L12 18l8-8-8-8zm0 4v3h-1v4h1v3h4v-3h1V9h-1V6h-4z"/>
                            </svg>
                            Subir Firma
                        </button>
                        <input type="file" accept="image/*" id="upload-signature-1" class="hidden" onchange="loadSignature(event, 1)" />
                    </div>
                </div>
                <div class="flex flex-col items-center">
                    <label class="text-sm">FIRMA ASESOR HSE</label>
                    <img src="/static/img/Firma.jpg" alt="Mario Acosta" class="mt-5">
                </div>
            </div>
        </div>
    </form>
</div>
<script src="/static/js/inspeccionGerencial.js"></script>
</body>
</html>