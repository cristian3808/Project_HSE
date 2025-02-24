<?php
require_once  'php/inspeccionExtintores.php';
?>
<html>
<head>
    <meta charset="UTF-8">
    <title>Formato Inspección de Extintores</title>
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
        .button-container {
            display: flex;
            gap: 8px;
            justify-content: center;
            align-items: center;
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
</div>
    <div class="bg-white p-6 rounded-lg shadow-lg no-shadow mt-5" id="form-content">
        <div class="flex justify-between items-center mb-4">
            <div>
                <a href="/index.php"><img src="/static/img/TF.png" alt="Logo de la empresa" class="h-20"></a>
            </div>
            <div class="text-center">
                <h1 class="text-lg font-bold">GESTIÓN DE SEGURIDAD Y SALUD EN EL TRABAJO</h1>
                <h2 class="text-md">INSPECCIÓN DE EXTINTORES</h2>
            </div>
            <div class="text-right">
                <span class="block">VERSIÓN: 6</span>
                <span class="block">F-HS-12</span>
            </div>
        </div>

        <div class="flex justify-between mb-4">
            <div class="w-1/3 flex flex-col items-start">
                <label for="Oficina">Oficina</label>
                <input class="border border-gray-400 p-1 w-60 " id="oficina" type="text" minlength="5" maxlength="25"/>
            </div>
            <div class="w-1/3 flex flex-col items-center">
                <label for="Responsable Inspección">Responsable Inspección</label>
                <input class="border border-gray-400 p-1 w-60 " id="responsableInspeccion" type="text" minlength="5" maxlength="28"/>
            </div>
            <div class="w-1/3 flex flex-col items-end">
                <label for="fecha-inspeccion">Fecha de inspección</label>
                <input class="border border-gray-400 p-1 w-60 " id="fechaInspeccion" type="date"/>
            </div>
        </div>
    <div class="flex items-center justify-center gap-6">
        <div class="flex justify-center items-center gap-6">
            <label type="text" style="margin-left: -240px;"> CONDICIONES DEL EXTINTOR:
            <span class="bg-[#E5E7EB] text-black py-1 px-3 border border-black rounded-full font-medium"> <strong>B: </strong>Bien</span>
            <span class="bg-[#E5E7EB]  text-black py-1 px-3 border border-black rounded-full font-medium"> <strong>M: </strong>Mal</span>
            <span class="bg-[#E5E7EB]  text-black py-1 px-3 border border-black rounded-full font-medium"> <strong>S: </strong>Sí</span>
            <span class="bg-[#E5E7EB] text-black py-1 px-3 border border-black rounded-full font-medium"> <strong>N: </strong>No</span>
        </div>
    </div>
        
    <table class="w-full border-collapse border border-gray-400 text-sm mt-5" style="font-size: 12px;">
        <thead class="bg-[#E1EEE2]">
            <tr>
                <th class="border border-gray-400 p-2">TIPO DE EXTINTOR</th>
                <th class="border border-gray-400 p-2">CLASE DE AGENTE EXTINTOR</th>
                <th class="border border-gray-400 p-2">CAPACIDAD</th>
                <th class="border border-gray-400 p-2">UBICACIÓN</th>
                <th class="border border-gray-400 p-2">FECHA DE RECARGA</th>
                <th class="border border-gray-400 p-2">ACT. PROX.</th>
                <th class="border border-gray-400 p-2">CONDICIONES DEL EXTINTOR</th>
                <th class="border border-gray-400 p-2 text-base w-16">Eliminar</th>
            </tr>
        </thead>
        <tbody id="table-body">
            <tr>
                <td class="border border-gray-400 p-2">
                    <select name="tipo_extintor" id="tipo_extintor">Tipo de extintor
                        <option value="#">Seleccione</option>
                        <option value="Clase A">Clase A</option>
                        <option value="Clase B">Clase B</option>
                        <option value="Clase C">Clase C</option>
                        <option value="Clase D">Clase D</option>
                        <option value="Clase K">Clase K</option>
                    </select>
                </td>
                <td class="border border-gray-400 p-2">
                    <select name="tipo_extintor" id="tipo_extintor">Clase de agente extintor
                        <option value="#">Seleccione</option>
                        <option value="Clase A">Agua</option>
                        <option value="Clase A">Espuma</option>
                        <option value="Clase A">Polvo</option>
                        <option value="Clase A">Dióxido de carbono</option>
                        <option value="Clase A">Halón</option>
                        <option value="Clase A">Agentes limpios</option>
                        <option value="Clase A">Halón alternativos</option>
                        <option value="Clase A">Pulverizador de agua</option>
                        <option value="Clase A">Agente expumante</option>
                        <option value="Clase A">Agente de inhibición</option>
                        <option value="Clase A">Multiproposito</option>
                    </select>
                </td>
                <td class="border border-gray-400 p-2">
                    <select name="Capacidad" id="Capacidad">
                        <option value="Seleccione">Seleccione</option>
                        <option value="2.5lb">2.5 lb</option>
                        <option value="5lb">5 lb</option>
                        <option value="10lb">10 lb</option>
                        <option value="15 lb">15 lb</option>
                        <option value="20 lb">20 lb</option>
                        <option value="30 lb">30 lb</option>
                        <option value="50 lb">50 lb</option>
                    </select>
                </td>
                <td class="border border-gray-400 p-2">
                    <select name="ubicacion" id="ubicacion">Ubicación
                        <option value="Seleccione">Seleccione</option>
                        <option value="Administracion">Administración</option>
                        <option value="Campo">Campo</option>
                    </select>
                </td>
                <td class="border border-gray-400 p-2"><input class="border border-gray-400 p-1 transparent-input" type="date" style="width: 100%;"/></td>
                <td class="border border-gray-400 p-2"><input class="border border-gray-400 p-1 transparent-input" type="date" style="width: 100%;"/></td>
                <td class="border border-gray-400 p-2">
                    <div class="grid grid-cols-2 gap-y-2 gap-x-1">
                        <div class="flex items-center">
                            <label class="mr-2"><strong>Presión:</strong></label>
                            <select name="presion" id="presion">
                                <option value="Seleccione">Seleccione</option>
                                <option value="Bien">Bien</option>
                                <option value="Mal">Mal</option>
                            </select>
                        </div>
                        <div class="flex items-center">
                            <label class="mr-2"><strong>Sello:</strong></label>
                            <select name="sello" id="sello">
                                <option value="Seleccione">Seleccione</option>>
                                <option value="Si">Si</option>
                                <option value="No">No</option>
                            </select>
                        </div>
                        <div class="flex items-center">
                            <label class="mr-2"><strong>Manómetro:</strong></label>
                            <select name="manometro" id="manometro">
                                <option value="Seleccione">Seleccione</option>
                                <option value="Bien">Bien</option>
                                <option value="Mal">Mal</option>
                            </select>
                        </div>
                        <div class="flex items-center">
                            <label class="mr-2"><strong>Recipiente:</strong></label>
                            <select name="recipiente" id="recipiente">
                                <option value="Seleccione">Seleccione</option>
                                <option value="Bien">Bien</option>
                                <option value="Mal">Mal</option>
                            </select>
                        </div>
                        <div class="flex items-center">
                            <label class="mr-2"><strong>Manija:</strong></label>
                            <select name="manija" id="manija">
                                <option value="Seleccione">Seleccione</option>
                                <option value="Bien">Bien</option>
                                <option value="Mal">Mal</option>
                            </select>
                        </div>
                        <div class="flex items-center">
                            <label class="mr-2"><strong>Manguera/Boquilla:</strong></label>
                            <select name="manguera" id="manguera">
                                <option value="Seleccione">Seleccione</option>
                                <option value="Bien">Bien</option>
                                <option value="Mal">Mal</option>
                            </select>
                        </div>
                        <div class="flex items-center">
                            <label class="mr-2"><strong>Pintura:</strong></label>
                            <select name="pintura" id="pintura">
                                <option value="Seleccione">Seleccione</option>
                                <option value="Si">Si</option>
                                <option value="No">No</option>
                            </select>
                        </div>
                        <div class="flex items-center">
                            <label class="mr-2"><strong>Señalización:</strong></label>
                            <select name="señalizacion" id="señalizacion">
                                <option value="Seleccione">Seleccione</option>
                                <option value="Si">Si</option>
                                <option value="No">No</option>
                            </select>
                        </div>
                        <div class="flex items-center">
                            <label class="mr-2"><strong>Falta:</strong></label>
                            <select name="falta" id="falta">
                                <option value="Seleccione">Seleccione</option>
                                <option value="Si">Si</option>
                                <option value="No">No</option>
                            </select>
                        </div>
                    </div>
                </td>
                <td class="border border-gray-400 p-2 text-center">
                        <button class="bg-red-500 text-white px-2 py-1 rounded remove-row">X</button>
                    </td>
            </tr>
        </tbody>
    </table>
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelector("#table-body").addEventListener("click", function (event) {
            if (event.target.classList.contains("remove-row")) {
                event.target.closest("tr").remove(); // Elimina la fila donde se hizo clic
            }
        });
    });
</script>
    <table class="w-full border-collapse border border-gray-400 text-sm mt-5">
        <thead class="bg-[#E1EEE2]">
            <tr>
                <th class="border border-gray-400 p-2">ACCIÓN CORRECTIVA Y/O PREVENTIVA</th>
                <th class="border border-gray-400 p-2">RESPONSABLE</th>
                <th class="border border-gray-400 p-2">FECHA INICIO</th>
                <th class="border border-gray-400 p-2">FECHA FINAL</th>
            </tr>
        </thead>
        <tbody id="table-body">
            <tr>
                <td class="border border-gray-400 p-2"><input class="w-full border-none p-1 text-xs" type="text"/></td>
                <td class="border border-gray-400 p-2"><input class="w-full border-none p-1 text-xs" type="text"/></td>
                <td class="border border-gray-400 p-2"><input class="w-full border-none p-1 text-xs" type="date"/></td>
                <td class="border border-gray-400 p-2"><input class="w-full border-none p-1 text-xs" type="date"/></td>
            </tr>
            <tr>
                <td class="border border-gray-400 p-2"><input class="w-full border-none p-1 text-xs" type="text"/></td>
                <td class="border border-gray-400 p-2"><input class="w-full border-none p-1 text-xs" type="text"/></td>
                <td class="border border-gray-400 p-2"><input class="w-full border-none p-1 text-xs" type="date"/></td>
                <td class="border border-gray-400 p-2"><input class="w-full border-none p-1 text-xs" type="date"/></td>
            </tr>
            <tr>
                <td class="border border-gray-400 p-2"><input class="w-full border-none p-1 text-xs" type="text"/></td>
                <td class="border border-gray-400 p-2"><input class="w-full border-none p-1 text-xs" type="text"/></td>
                <td class="border border-gray-400 p-2"><input class="w-full border-none p-1 text-xs" type="date"/></td>
                <td class="border border-gray-400 p-2"><input class="w-full border-none p-1 text-xs" type="date"/></td>
            </tr>
        </body>
    </table>

    <td class="border border-gray-400 p-2">
        <div class="flex flex-col items-center justify-center w-full mt-6">
            <th class="border border-gray-400 p-2 text-center w-full">Firma</th>
            <!-- Canvas donde se dibuja la firma -->
            <canvas id="signature-pad" class="signature-pad border border-gray-400" height="80" width="220"></canvas>
            <div class="flex space-x-2 mt-4 justify-center w-full"> <!-- Contenedor flex para los botones centrado -->
                <button class="bg-red-500 text-white px-2 py-1 rounded clear-signature flex items-center" type="button" onclick="clearCanvas()">
                    <svg class="w-4 h-4 mr-2 text-red-200" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path d="M3 6h18v2H3V6zm3 3h12v13H6V9zm4-5h4v2h-4V4zM5 6h14v16a2 2 0 01-2 2H7a2 2 0 01-2-2V6zm6 5v3h3V11h-3z"/>
                    </svg>     
                Limpiar</button>
                <!-- Botón para subir imagen de la firma -->
                <label class="bg-blue-500 text-white px-4 py-2 rounded cursor-pointer flex items-center justify-center text-sm hide-on-pdf">
                    <input type="file" class="hidden " accept="image/*" id="upload-signature" onchange="uploadSignature(event)">
                    <svg class="w-4 h-4 mr-2 text-blue-200" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path d="M12 2L8.59 5.41 13.17 10H4v2h9.17l-4.58 4.59L12 18l8-8-8-8zm0 4v3h-1v4h1v3h4v-3h1V9h-1V6h-4z"/>
                    </svg>
                    Subir firma
                </label>
            </div>
        </div>
    </td>

<script>
    const uploadBtn = document.getElementById('upload-btn');
    const uploadInput = document.getElementById('upload-signature');
    const canvas = document.querySelector('.signature-pad');
    const context = canvas.getContext('2d');

    uploadBtn.addEventListener('click', () => {
        uploadInput.click();
    });

    uploadInput.addEventListener('change', (event) => {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = new Image();
                img.onload = function() {
                    // Limpiar el canvas antes de dibujar la nueva imagen
                    context.clearRect(0, 0, canvas.width, canvas.height);
                    // Dibujar la imagen en el canvas
                    context.drawImage(img, 0, 0, canvas.width, canvas.height);
                }
                img.src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    });

    const clearButton = document.querySelector('.clear-signature');
    clearButton.addEventListener('click', () => {
        context.clearRect(0, 0, canvas.width, canvas.height);
        uploadInput.value = ''; // Limpiar la selección del archivo
    });
</script>
<script src="/static/js/inspeccionExtintores.js"></script>
</body>
</html>