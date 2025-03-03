<?php
require_once  'php/listadoAsistencia.php';
?>
<html>
<head>
    <meta charset="UTF-8">
    <title>Listado de Asistencia</title>
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
            <h1 class="text-lg font-bold">GESTIÓN ADMINISTRATIVA Y FINANCIERA</h1>
            <h2 class="text-md">LISTADO ASISTENCIA</h2>
        </div>
        <div>
            <span class="block text-right">VERSIÓN: 04</span>
            <span class="block text-right">CÓDIGO: F-AF-19</span>
        </div>
    </div>
    <div class="flex justify-between mb-4 items-end">
        <div class="w-1/3 flex flex-col items-start justify-start">
            <label for="Tema">Tema</label>
            <input type="text" class="border border-gray-400 p-1 w-96" id="tema" minlength="5" maxlength="40">
        </div>
        <div class="w-1/3 flex flex-col items-center justify-start">
            <label for="Exponente">Exponente</label>
            <input type="text" class="border border-gray-400 p-1 w-96" id="exponente" minlength="5" maxlength="50">
        </div>
        <div class="w-1/3 flex flex-col items-end justify-center">
            <label for="Fecha">Fecha</label>
            <input type="date" class="border border-gray-400 p-1 w-96" id="fecha">
        </div>
    </div>
    
    <form>
        <table class="w-full border-collapse border border-gray-400 text-sm" id="form-content">
            <thead>
                <tr>
                    <th colspan="5" class="border border-gray-400 p-2 text-center bg-[#E1EEE2]">ASISTENTES</th>
                </tr>
                <tr>
                    <th class="border border-gray-400 p-2">CÉDULA</th>
                    <th class="border border-gray-400 p-2">APELLIDOS</th>
                    <th class="border border-gray-400 p-2">NOMBRES</th>
                    <th class="border border-gray-400 p-2">EMPRESA</th>
                    <th class="border border-gray-400 p-2">FIRMA</th>
                    <th class="border border-gray-400 p-2 text-base w-16">Eliminar</th>
                </tr>
            </thead>
            <tbody id="table-body">
                <tr>
                
                </tr>
            </tbody>
        </table>
    </form>
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
<script src="/static/js/listadoAsistencia.js"></script>
</body>
</html>