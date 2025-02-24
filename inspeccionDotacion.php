<?php
require_once'php/inspeccionDotacion.php';
?>
<html>
<head>
    <meta charset="UTF-8">
    <title>Inspección Dotación y Elementos de Protección Personal</title>
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
        
        <!-- Btn de nuevo registro -->
        <button class="bg-amber-400 text-white px-4 py-2 rounded flex items-center gap-2" id="add-row">
            <img src="/static/img/agregar.svg" alt="Agregar registro" class="h-8 w-8">
            <strong>Agregar registro</strong>
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
            <h2 class="text-md">INSPECCIÓN DOTACIÓN Y ELEMENTOS DE PROTECCIÓN PERSONAL</h2>
        </div>
        <div>
            <span class="block text-right">VERSIÓN: 5</span>
            <span class="block text-right">F-HS-08</span>
        </div>
    </div>

<div class="mb-4 grid grid-cols-4 gap-4">
    <div>
        <label for="Localización">Localización</label>
        <p> <input class="border p-1 w-full" type="text" id="localizacion"/> </p>
    </div>
    <div>
        <label for="Cliente">Cliente</label>
        <p> <input class="border p-1 w-full" type="text" id="cliente"/> </p>
    </div>
    <div>
        <label for="Inspector">Inspector</label>
        <p> <input class="border p-1 w-full" type="text" id="inspector"/> </p>
    </div>
    <div>
        <label for="Número del contrato">Número del contrato</label>
        <p> <input 
    class="border p-1 w-full" 
    type="text"  id="numeroContrato"  minlength="1"  maxlength="15" pattern="^[0-9]{1,15}$"  title="Solo se permiten números entre 1 y 15 dígitos" oninput="this.value=this.value.replace(/[^0-9]/g,'')" required />
</p>
    </div>
</div>

<div class="mt-4 flex justify-center items-center p-4">
    <p class="text-sm mr-4"><strong>B:</strong> Bueno</p>
    <p class="text-sm"><strong>M:</strong> Malo</p>
</div>
<form class="p-2">
    <table class="w-full border-collapse border border-gray-400 text-sm table-auto">
        <thead class="bg-[#E1EEE2]">
            <tr>
                <th class="border border-gray-400 p-2">FECHA</th>
                <th class="border border-gray-400 p-2">NOMBRE DEL INSPECCIONADO</th>
                <th class="border border-gray-400 p-2">CEDULA</th>
                <th class="border border-gray-400 p-2">FIRMA</th>
                <th class="border border-gray-400 p-2">
                    DOTACIÓN
                    <div class="grid grid-cols-4 gap-2 mt-1 text-xs">
                        <span>Camisa</span>
                        <span>Pantalón</span>
                        <span>Botas</span>
                        <span>Nomex</span>
                    </div>
                </th>
                <th class="border border-gray-400 p-2">
                    EPP
                    <div class="grid grid-cols-5 gap-2 mt-1 text-xs">
                        <span>Casco</span>
                        <span>Gafas</span>
                        <span>Guantes</span>
                        <span>Mascarilla</span>
                        <span class="ml-2">Filtro</span>
                    </div>
                </th>
                <th class="border border-gray-400 p-2">
                    AUDÍFONOS
                    <div class="grid grid-cols-2 gap-2 mt-1 text-xs">
                        <span>Copa</span>
                        <span>Inserción</span>
                    </div>
                </th>
                <th class="border border-gray-400 p-2">
                    ROPA DE INVIERNO
                    <div class="grid grid-cols-2 gap-2 mt-1 text-xs">
                        <span>Impermeable</span>
                        <span>Botas</span>
                    </div>
                </th>
                <th class="border border-gray-400 p-2 text-base w-16">Eliminar</th>
            </tr>
        </thead>
        <tbody id="table-body">
            <tr>
                <td class="border border-gray-400 p-2">
                    <input class="w-full border-transparent p-1 text-xs rounded" type="date" />
                </td>
                <td class="border border-gray-400 p-2">
                    <input class="w-full border-transparent p-1 text-xs rounded" type="text" />
                </td>
                <td class="border border-gray-400 p-2">
                    <input class="w-full border-transparent p-1 text-xs rounded" type="text" />
                </td>
                <td class="border border-gray-400 p-2 flex flex-col items-center justify-center">
                    <canvas class="border border-gray-400 p-1 signature-pad" width="150" height="55"></canvas>
                    <div class="mt-2 inline-flex space-x-2 justify-center hide-on-pdf">
                        <!-- Botón Limpiar -->
                        <button class="bg-red-500 text-white px-2 py-1 rounded clear-signature flex items-center">
                            <svg class="w-2.5 h-2.5 mr-1 text-red-200" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <path d="M3 6h18v2H3V6zm3 3h12v13H6V9zm4-5h4v2h-4V4zM5 6h14v16a2 2 0 01-2 2H7a2 2 0 01-2-2V6zm6 5v3h3V11h-3z"/>
                            </svg> 
                            Limpiar
                        </button>

                        <!-- Botón Subir Firma -->
                        <label class="bg-blue-500 text-white px-2 py-1 rounded cursor-pointer flex items-center">
                            <input type="file" class="hidden" accept="image/*" id="upload-signature" onchange="uploadSignature(event)">
                            <svg class="w-2.5 h-2.5 mr-1 text-blue-200" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <path d="M12 2L8.59 5.41 13.17 10H4v2h9.17l-4.58 4.59L12 18l8-8-8-8zm0 4v3h-1v4h1v3h4v-3h1V9h-1V6h-4z"/>
                            </svg>
                            Subir 
                        </label>
                    </div>
                </td>
                <td class="border border-gray-400 p-2">
                    <div class="grid grid-cols-4 gap-2 text-xs">
                        <select class="w-full border-transparent p-1 text-xs rounded" required>
                            <option value="" selected>Seleccione</option>
                            <option value="B">B</option>
                            <option value="M">M</option>
                        </select>
                        <select class="w-full border-transparent p-1 text-xs rounded" required>
                            <option value="" selected>Seleccione</option>
                            <option value="B">B</option>
                            <option value="M">M</option>
                        </select>
                        <select class="w-full border-transparent p-1 text-xs rounded" required>
                            <option value="" selected>Seleccione</option>
                            <option value="B">B</option>
                            <option value="M">M</option>
                        </select>
                        <select class="w-full border-transparent p-1 text-xs rounded" required>
                            <option value="" selected>Seleccione</option>
                            <option value="B">B</option>
                            <option value="M">M</option>
                            <option value="n/a">N/A</option>
                        </select>
                    </div>
                </td>
                <td class="border border-gray-400 p-2">
                    <div class="grid grid-cols-5 gap-2 text-xs">
                        <select class="w-full border-transparent p-1 text-xs rounded" required>
                            <option value="" selected>Seleccione</option>
                            <option value="B">B</option>
                            <option value="M">M</option>
                        </select>
                        <select class="w-full border-transparent p-1 text-xs rounded" required>
                            <option value="" selected>Seleccione</option>
                            <option value="B">B</option>
                            <option value="M">M</option>
                        </select>
                        <select class="w-full border-transparent p-1 text-xs rounded" required>
                            <option value="" selected>Seleccione</option>
                            <option value="B">B</option>
                            <option value="M">M</option>
                        </select>
                        <select class="w-full border-transparent p-1 text-xs rounded" required>
                            <option value="" selected>Seleccione</option>
                            <option value="B">B</option>
                            <option value="M">M</option>
                        </select>
                        <select class="w-full border-transparent p-1 text-xs rounded" required>
                            <option value="" selected>Seleccione</option>
                            <option value="B">B</option>
                            <option value="M">M</option>
                        </select>
                    </div>
                </td>
                <td class="border border-gray-400 p-2">
                    <div class="grid grid-cols-2 gap-2 text-xs">
                        <select class="w-full border-transparent p-1 text-xs rounded" required>
                            <option value="" selected>Seleccione</option>
                            <option value="B">B</option>
                            <option value="M">M</option>
                        </select>
                        <select class="w-full border-transparent p-1 text-xs rounded" required>
                            <option value="" selected>Seleccione</option>
                            <option value="B">B</option>
                            <option value="M">M</option>
                        </select>
                    </div>
                </td>
                <td class="border border-gray-400 p-2">
                    <div class="grid grid-cols-2 gap-2 text-xs">
                        <select class="w-full border-transparent p-1 text-xs rounded" required>
                            <option value="" selected>Seleccione</option>
                            <option value="B">B</option>
                            <option value="M">M</option>
                            <option value="n/a">N/A</option>
                        </select>
                        <select class="w-full border-transparent p-1 text-xs rounded" required>
                            <option value="" selected>Seleccione</option>
                            <option value="B">B</option>
                            <option value="M">M</option>
                            <option value="n/a">N/A</option>
                        </select>
                    </div>
                </td>
                <td class="border border-gray-400 p-2 text-center">
                    <button class="bg-red-500 text-white px-2 py-1 rounded remove-row">X</button>
                </td>
            </tr>
        </tbody>
    </table>
</form>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelector("#table-body").addEventListener("click", function (event) {
            if (event.target.classList.contains("remove-row")) {
                event.target.closest("tr").remove(); // Elimina la fila donde se hizo clic
            }
        });
    });
</script>

<form class="p-4">
    <table class="w-full border-collapse border border-gray-400 text-sm table-auto">
        <thead class="bg-[#E1EEE2]">
            <tr>
                <th class="border border-gray-400 p-2">OBSERVACIONES</th>
                <th class="border border-gray-400 p-2">ACCIONES A TOMAR</th>
                <th class="border border-gray-400 p-2">RESPONSABLES</th>
                <th class="border border-gray-400 p-2">FECHA LIMITE</th>
            </tr>
        </thead>
        <tbody id="table-body">
            <tr>
                <td class="border border-gray-400 p-2" style="min-width: 200px;">
                    <input placeholder="." type="text" class="w-full border-none p-1 text-xs" maxlength="75" 
                        oninput="moveToNext(event, this.nextElementSibling)" onkeydown="moveToPrevious(event, this)">
                </td>
                <td class="border border-gray-400 p-2" style="min-width: 200px;">
                    <input placeholder="." type="text" class="w-full border-none p-1 text-xs" maxlength="75" 
                        oninput="moveToNext(event, this.nextElementSibling)" onkeydown="moveToPrevious(event, this)">
                </td>
                <td class="border border-gray-400 p-2" style="min-width: 200px;">
                    <input placeholder="." type="text" class="w-full border-none p-1 text-xs" maxlength="75" 
                        oninput="moveToNext(event, this.nextElementSibling)" onkeydown="moveToPrevious(event, this)">
                </td>
                <td class="border border-gray-400 p-2">
                    <input class="w-full border-none p-1 text-xs" type="date" />
                </td>
            </tr>
            <tr>
                <td class="border border-gray-400 p-2" style="min-width: 200px;">
                    <input placeholder="." type="text" class="w-full border-none p-1 text-xs" maxlength="75" 
                        oninput="moveToNext(event, this.nextElementSibling)" onkeydown="moveToPrevious(event, this)">
                </td>
                <td class="border border-gray-400 p-2" style="min-width: 200px;">
                    <input placeholder="." type="text" class="w-full border-none p-1 text-xs" maxlength="75" 
                        oninput="moveToNext(event, this.nextElementSibling)" onkeydown="moveToPrevious(event, this)">
                </td>
                <td class="border border-gray-400 p-2" style="min-width: 200px;">
                    <input placeholder="." type="text" class="w-full border-none p-1 text-xs" maxlength="75" 
                        oninput="moveToNext(event, this.nextElementSibling)" onkeydown="moveToPrevious(event, this)">
                </td>
                <td class="border border-gray-400 p-2">
                    <input class="w-full border-none p-1 text-xs" type="date" />
                </td>
            </tr>
            <tr>
                <td class="border border-gray-400 p-2" style="min-width: 200px;">
                    <input placeholder="." type="text" class="w-full border-none p-1 text-xs" maxlength="75" 
                        oninput="moveToNext(event, this.nextElementSibling)" onkeydown="moveToPrevious(event, this)">
                </td>
                <td class="border border-gray-400 p-2" style="min-width: 200px;">
                    <input placeholder="." type="text" class="w-full border-none p-1 text-xs" maxlength="75" 
                        oninput="moveToNext(event, this.nextElementSibling)" onkeydown="moveToPrevious(event, this)">
                </td>
                <td class="border border-gray-400 p-2" style="min-width: 200px;">
                    <input placeholder="." type="text" class="w-full border-none p-1 text-xs" maxlength="75" 
                        oninput="moveToNext(event, this.nextElementSibling)" onkeydown="moveToPrevious(event, this)">
                </td>
                <td class="border border-gray-400 p-2">
                    <input class="w-full border-none p-1 text-xs" type="date" />
                </td>
            </tr>
        </tbody>
    </table>
</form>

<script src="/static/js/inspeccionDotacion.js"></script>
