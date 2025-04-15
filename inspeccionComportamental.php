<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once  'php/inspeccionComportamental.php';
?>
<html>
<head>
    <meta charset="UTF-8">
    <title>Inspección Comportamental</title>
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
        .hide-on-pdf {
            display: table-cell;
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
        <button onclick="location.href='index.php'" class="bg-green-800 hover:bg-green-600 text-white px-4 py-2 rounded flex items-center" id="back-btn">
            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Atrás
        </button>
        
        <div class="text-right flex space-x-2">
                <div id="toast-warning" class="flex items-center w-full max-w-xs p-4 text-gray-500 bg-white rounded-lg shadow dark:text-gray-400 dark:bg-gray-800" role="alert">
                    <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-orange-500 bg-orange-100 rounded-lg dark:bg-orange-700 dark:text-orange-200">
                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM10 15a1 1 0 1 1 0-2 1 1 0 0 1 0 2Zm1-4a1 1 0 0 1-2 0V6a1 1 0 0 1 2 0v5Z"/>
                        </svg>
                    </div>
                    <div class="ms-3 text-sm font-normal text-center">Complete los campos necesarios; en caso contrario, escriba 'No aplica'.</div>
                </div>
                
                <button class="bg-blue-500 text-white px-4 py-2 rounded min-h-[48px] flex flex-col items-center justify-center" id="download-pdf">
                    <img src="/static/img/enviar.svg" alt="Descarga PDF" class="h-8 w-8 text-white">
                    <h4>Enviar</h4>
                </button>
                
                <button class="bg-amber-400 text-white px-4 py-2 rounded flex items-center gap-2" id="add-row">
                    <img src="/static/img/agregar.svg" alt="Agregar registro" class="h-8 w-8">
                    <strong>Agregar registro</strong>
                </button>
            </div>
        </div>

    <div class="bg-white p-6 rounded-lg shadow-lg no-shadow mt-5" id="form-content">
        <div class="flex justify-between items-center mb-4">
            <div>
                <a href="/index.php">
                    <img src="/static/img/TF.png" alt="Logo de la empresa" class="h-20">
                </a>
            </div>
            <div class="text-center">
                <h1 class="text-lg font-bold">GESTIÓN DE SEGURIDAD Y SALUD EN EL TRABAJO</h1>
                <h2 class="text-md">INSPECCIÓN COMPORTAMENTAL</h2>
            </div>
            <div>
                <span class="block text-right">VERSIÓN: 5</span>
                <span class="block text-right">F-HS-07</span>
            </div>
        </div>

        <div class="flex justify-between mb-4 items-end">
            <div class="w-1/3 flex flex-col items-start justify-start">
                <label for="Localizacion" class="text-center">Localización:</label>
                <input type="text" class="border border-gray-400 p-1 w-96" id="localizacion" minlength="5" maxlength="45">
            </div>
            <div class="w-1/3 flex flex-col items-center justify-center">
                <label for="Cliente" class="text-center">Cliente</label>
                <input type="text" class="border border-gray-400 p-1 w-96" id="cliente" minlength="5" maxlength="50">
            </div>
            <div class="w-1/3 flex flex-col items-end justify-center">
                <label for="numero-contrato" class="text-center">Número de contrato</label>
                <input type="number" class="border border-gray-400 p-1 w-96" id="numero-contrato">
            </div>
        </div>

        <div class="mt-4 text-sm">
            <p><strong>COMPORTAMIENTO No 1:</strong> <span class="ml-4">¿La persona demuestra atención en las actividades que desarrolla?</span></p>
            <p><strong>COMPORTAMIENTO No 2:</strong> <span class="ml-4">¿La persona mantiene el uso de epp durante la presencia de riesgo?</span></p>
            <p><strong>COMPORTAMIENTO No 3:</strong> <span class="ml-4">¿La persona presenta movimientos nerviosos o movimientos no habituales durante la labor?</span></p>
            <p><strong>COMPORTAMIENTO No 4:</strong> <span class="ml-4">¿La persona se comunica con los compañeros de trabajo en forma tranquila?</span></p>
            <p><strong>COMPORTAMIENTO No 5:</strong> <span class="ml-4">¿La persona demuestra cansancio en la ejecución de las actividades?</span></p>
        </div>

        <div class="overflow-x-auto mt-4">
            <table class="w-full border-collapse border border-gray-400 text-sm">
                <thead class="bg-[#E1EEE2]">
                <tr>
                    <th class="border border-gray-400 p-2 text-base w-24">Fecha</th>
                    <th class="border border-gray-400 p-2 text-base w-24">Hr</th>
                    <th class="border border-gray-400 p-2 text-base w-24">Nombre</th>
                    <th class="border border-gray-400 p-2 text-base w-24">Firma</th>
                    <th class="border border-gray-400 p-2 text-base w-24">Comportamiento</th>
                    <th class="border border-gray-400 p-2 text-base w-24">Recomendación</th>
                    <th class="border border-gray-400 p-2 text-base w-24">Correctiva</th>
                    <th class="border border-gray-400 p-2 text-base w-24">Responsable</th>
                    <th class="border border-gray-400 p-2 text-base w-24">Fecha de cumplimiento</th>
                    <th class="border border-gray-400 p-2 text-base w-16">Eliminar</th>
                </tr>
                </thead>
                <tbody id="table-body">
                    
                </tbody>
            </table>
        </div>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelector("#table-body").addEventListener("click", function (event) {
                if (event.target.classList.contains("remove-row")) {
                    event.target.closest("tr").remove(); // Elimina la fila donde se hizo clic
                }
            });
        });
    </script>
    </div>
<script src="/static/js/inspeccionComportamental.js"></script>
</body>
</html>