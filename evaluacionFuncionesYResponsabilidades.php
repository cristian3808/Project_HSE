<?php
require_once  'php/evaluacionFuncionesYResponsabilidades.php';
?>
<html>
<head>
    <meta charset="UTF-8">
    <title>Evaluación de Funciones y Responsabilidades HSEQ</title>
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
            <div class="ms-3 text-sm font-normal text-center">Ingrese un valor entre 1 y 5 al responder ( RESPONSABILIDADES HSEQ ) .</div>
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
                <h1 class="text-lg font-bold">GESTIÓN ADMINISTRATIVA Y FINANCIERA</h1>
                <h2 class="text-md">EVALUACIÓN DE FUNCIONES Y RESPONSABILIDADES HSEQ</h2>
                <h3 class="text-sm">CÓDIGO: F-AF-33</h3>
            </div>
            <div class="text-right">
                <p class="text-sm">VERSIÓN: 2</p>
                <p class="text-sm">Fecha de Evaluación: <input type="date" id="fechaEvaluacion" class="border border-gray-400 p-1 transparent-input"></p>
                <p class="text-sm">Periodo de Evaluación: 
                <select name="" id="">
                    <option value="2024">2025</option>
                    <option value="2024">2026</option>
                    <option value="2024">2027</option>
                    <option value="2024">2028</option>  
                    <option value="2024">2029</option>
                    <option value="2024">2030</option>
                    <option value="2024">2031</option>
                    <option value="2024">2032</option>
                    <option value="2024">2033</option>
                    <option value="2024">2034</option>
                </select></p>
            </div>
        </div>
        <div class="border-t border-gray-400 pt-2">
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <p><strong>Nombre trabajador:</strong> <input type="text" class="border border-gray-400 p-1 transparent-input w-96" id="nombreTrabajador"></p>
                    <p><strong>Cargo actual:</strong> <input type="text" class="border border-gray-400 p-1 transparent-input" id="cargoActual"></p>
                </div>
                <div>
                <p><strong>Nivel del cargo:</strong> <select name="" id="">
                        <option value="#">Seleccione</option>
                        <option value="alta gerencia">1. Alta gerencia</option>
                        <option value="gerencia media">2. Gerencia media</option>
                        <option value="nivel de coordinacion">3. Nivel de coordinacion</option>
                        <option value="demas trabajadores">4. Demas trabajadores</option>
                        <option value="Director - coordinador">5. Director - Coordinador HSE-SGI</option>
                    </select></p>
                    <p><strong>Cargo que evalua:</strong> <input type="text" class="border border-gray-400 p-1 transparent-input" id="cargoEvalue"></p>
                </div>
            </div>
            <div class="border-t border-gray-400 pt-2">
            <h4 class="text-center font-bold mb-2"></h4>
            <table class="w-full border-collapse border border-gray-400 text-sm">
            <thead>
                <tr>
                    <th class="border border-gray-400 p-1" rowspan="2" style="text-align: center;">RESPONSABILIDADES HSEQ</th>
                    <th colspan="2" class="border border-gray-400 p-1">GRADOS DE APLICACIÓN</th>
                    <th class="border border-gray-400 w-25  " rowspan="2 w-25"  style="text-align: center; width: 25px;">PUNTOS</th>
                </tr>
                <tr>
                    <th class="border border-gray-400 p-1" style="width: 100px;">Evaluador</th>
                    <th class="border border-gray-400 p-1" style="width: 100px;">Auto Evaluación</th>
                </tr>
            </thead>
                    <tbody>
                    <tr>
                        <td class="border border-gray-400 p-2 align-middle">
                            Conocer y apoyar la protección de los derechos humanos, respetando la diversidad, interculturalidad y NO discriminando.
                        </td>
                        <td class="border border-gray-400 p-2">
                            <input type="number" id="cero1" class="border border-gray-400 p-1 transparent-input w-full" 
                                step="0.1" oninput="validarRango(this); sumarValores()" placeholder="0" >
                        </td>
                        <td class="border border-gray-400 p-2">
                            <input type="number" id="cero2" class="border border-gray-400 p-1 transparent-input w-full" 
                                step="0.1" oninput="validarRango(this); sumarValores()" placeholder="0" >
                        </td>
                        <td class="border border-gray-400 p-2">
                            <div>
                                <p><input type="number" id="sumacero" class="border border-gray-400 p-1 transparent-input" readonly></p>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="border border-gray-400 p-2 align-middle">
                            Manejar adecuadamente la información y reportar las inquietudes o denuncias respecto a aspectos éticos (Incluyendo corrupcion,extorsión,soborno,<br>trabaja forzoso o infantil,violación de derechos humanos entre otros).
                        </td>
                        <td class="border border-gray-400 p-2">
                            <input type="number" id="uno1" class="border border-gray-400 p-1 transparent-input w-full" 
                            step="0.1" oninput="validarRango(this); sumarValores1()" placeholder="0" >
                        </td>
                        <td class="border border-gray-400 p-2">
                            <input type="number" id="uno2" class="border border-gray-400 p-1 transparent-input w-full" 
                            step="0.1"oninput="validarRango(this); sumarValores1()" placeholder="0" >
                        </td>
                        <td class="border border-gray-400 p-2">
                            <div>
                                <p> <input type="number" id="sumauno" class="border border-gray-400 p-1 transparent-input" readonly></p>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="border border-gray-400 p-2 align-middle">Ejecutar sus actividades conforme a los valores y compromisos corporativos establecidos en materia de HSE y RSE.</td>
                        <td class="border border-gray-400 p-2">
                            <input type="number" id="dos1" class="border border-gray-400 p-1 transparent-input w-full" step="0.1" oninput="validarRango(this);sumarValores2()" placeholder="0" >
                        </td>
                        <td class="border border-gray-400 p-2">
                            <input type="number" id="dos2" class="border border-gray-400 p-1 transparent-input w-full" step="0.1" oninput="validarRango(this);sumarValores2()" placeholder="0" >
                        </td>
                        <td class="border border-gray-400 p-2">
                            <div>
                                <p> <input type="number" id="sumados" class="border border-gray-400 p-1 transparent-input" readonly></p>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="border border-gray-400 p-2 align-middle">Propiciar la capacidad de escucha y de negociació (Resolución de conflictos).</td>
                        <td class="border border-gray-400 p-2">
                            <input type="number" id="tres1" class="border border-gray-400 p-1 transparent-input w-full" step="0.1" oninput="validarRango(this);sumarValores3()" placeholder="0" >
                        </td>
                        <td class="border border-gray-400 p-2">
                            <input type="number" id="tres2" class="border border-gray-400 p-1 transparent-input w-full" step="0.1" oninput="validarRango(this);sumarValores3()" placeholder="0" >
                        </td>
                        <td class="border border-gray-400 p-2">
                            <div>
                                <p> <input type="number" id="sumatres" class="border border-gray-400 p-1 transparent-input" readonly></p>
                            </div>
                        </td>
                    </tr>
                    </tr>
                    <tr>
                        <td class="border border-gray-400 p-2 align-middle">Apoyar la implementación, mejoramiento y sonstenimiento del sistema de gestion mediante la participación en los programas de gestión establecidos por la <br>empresa para el cumplimiento de objetivos del sistema HSEQ tales como: Inspecciones. Charlas de 5 miutos, cursos y capacitaciones. </td>
                        <td class="border border-gray-400 p-2">
                            <input type="number" id="tres_uno" class="border border-gray-400 p-1 transparent-input w-full" step="0.1" oninput="validarRango(this);sumarValores3_1()" placeholder="0" >
                        </td>
                        <td class="border border-gray-400 p-2">
                            <input type="number" id="tres_uno" class="border border-gray-400 p-1 transparent-input w-full" step="0.1" oninput="validarRango(this);sumarValores3_1()" placeholder="0" >
                        </td>
                        <td class="border border-gray-400 p-2">
                            <div>
                                <p> <input type="number" id="sumatres_uno" class="border border-gray-400 p-1 transparent-input" readonly></p>
                            </div>
                        </td>
                        <tr>
                        <td class="border border-gray-400 p-2 align-middle">Asistir al proceso de inducción o re-inducción en HESQ cuando se programe.</td>
                            <td class="border border-gray-400 p-2">
                            <input type="number" id="cuatro" class="border border-gray-400 p-1 transparent-input w-full" step="0.1" oninput="validarRango(this);sumarValores4()" placeholder="0" >
                        </td>
                        <td class="border border-gray-400 p-2">
                            <input type="number" id="cuatro" class="border border-gray-400 p-1 transparent-input w-full" step="0.1" oninput="validarRango(this);sumarValores4()" placeholder="0" >
                        </td>
                        <td class="border border-gray-400 p-2">
                            <div>
                                <p> <input type="number" id="sumacuatro" class="border border-gray-400 p-1 transparent-input" readonly></p>
                            </div>
                        </td>
                    </tr>
                        </tr>
                        <tr>
                        <td class="border border-gray-400 p-2 align-middle">Conocer los peligros y riesgos a su puesto de trabajo asi como los aspectos e impactos ambientales de la organización. </td>
                            <td class="border border-gray-400 p-2">
                            <input type="number" id="cinco" class="border border-gray-400 p-1 transparent-input w-full" step="0.1" oninput="validarRango(this);sumarValores5()" placeholder="0" >
                        </td>
                        <td class="border border-gray-400 p-2">
                            <input type="number" id="cinco" class="border border-gray-400 p-1 transparent-input w-full" step="0.1" oninput="validarRango(this);sumarValores5()" placeholder="0" >
                        </td>
                        <td class="border border-gray-400 p-2">
                            <div>
                                <p> <input type="number" id="sumacinco" class="border border-gray-400 p-1 transparent-input" readonly></p>
                            </div>
                        </td>
                    </tr>
                        </tr>
                        <tr>
                        <td class="border border-gray-400 p-2 align-middle">Conocer y acatar los planes de emergencia y contingencia ambiental de la empresa y de los clientes.</td>
                            <td class="border border-gray-400 p-2">
                            <input type="number" id="seis" class="border border-gray-400 p-1 transparent-input w-full" step="0.1" oninput="validarRango(this);sumarValores6()" placeholder="0" >
                        </td>
                        <td class="border border-gray-400 p-2">
                            <input type="number" id="seis" class="border border-gray-400 p-1 transparent-input w-full" step="0.1"oninput="validarRango(this);sumarValores6()" placeholder="0" >
                        </td>
                        <td class="border border-gray-400 p-2">
                            <div>
                                <p> <input type="number" id="sumaseis" class="border border-gray-400 p-1 transparent-input" readonly></p>
                            </div>
                        </td>
                    </tr>
                        <tr>
                        <td class="border border-gray-400 p-2 align-middle">Conocer, entender  y difundir las politicas generales de la compañia, en especial las de HESQ, los objetivos y las metas a nivel empresa y a nivel departamento.</td>
                            <td class="border border-gray-400 p-2">
                            <input type="number" id="siete" class="border border-gray-400 p-1 transparent-input w-full" step="0.1" oninput="validarRango(this);sumarValores7()" placeholder="0" >
                        </td>
                        <td class="border border-gray-400 p-2">
                            <input type="number" id="siete" class="border border-gray-400 p-1 transparent-input w-full" step="0.1" oninput="validarRango(this);sumarValores7()" placeholder="0" >
                        </td>
                        <td class="border border-gray-400 p-2">
                            <div>
                                <p> <input type="number" id="sumasiete" class="border border-gray-400 p-1 transparent-input" readonly></p>
                            </div>
                        </td>
                    </tr>
                        <tr>
                        <td class="border border-gray-400 p-2 align-middle">Conocer, utilizar y hacer un buen uso de los diferentes elemnetos de proteccion personal, seguridad ocupacional, ergonomia, medio ambiente, en el caso que convenga.</td>
                            <td class="border border-gray-400 p-2">
                            <input type="number" id="ocho" class="border border-gray-400 p-1 transparent-input w-full" step="0.1" oninput="validarRango(this);sumarValores8()" placeholder="0" >
                        </td>
                        <td class="border border-gray-400 p-2">
                            <input type="number" id="ocho" class="border border-gray-400 p-1 transparent-input w-full" step="0.1" oninput="validarRango(this);sumarValores8()" placeholder="0" >
                        </td>
                        <td class="border border-gray-400 p-2">
                            <div>
                                <p> <input type="number" id="sumaocho" class="border border-gray-400 p-1 transparent-input" readonly></p>
                            </div>
                        </td>
                    </tr>
                        <tr>
                        <td class="border border-gray-400 p-2 align-middle">Conocer las normas o procedimientos del programa HSE, el reglamiento de higiene y seguridad industrial y el reglamento interno de trabajo. </td>
                            <td class="border border-gray-400 p-2">
                            <input type="number" id="nueve" class="border border-gray-400 p-1 transparent-input w-full" step="0.1" oninput="validarRango(this);sumarValores9()" placeholder="0" >
                        </td>
                        <td class="border border-gray-400 p-2">
                            <input type="number" id="nueve" class="border border-gray-400 p-1 transparent-input w-full" step="0.1" oninput="validarRango(this);sumarValores9()" placeholder="0" >
                        </td>
                        <td class="border border-gray-400 p-2">
                            <div>
                                <p> <input type="number" id="sumanueve" class="border border-gray-400 p-1 transparent-input" readonly></p>
                            </div>
                        </td>
                    </tr>
                        <tr>
                        <td class="border border-gray-400 p-2 align-middle">Detectar practicas inseguras, condiciones inseguras y practicas o condiciones medio ambientales riesgosas reportarlas y hacerle seguiemiento de cierre.</td>
                            <td class="border border-gray-400 p-2">
                            <input type="number" id="diez" class="border border-gray-400 p-1 transparent-input w-full" step="0.1" oninput="validarRango(this);sumarValores10()" placeholder="0" >
                        </td>
                        <td class="border border-gray-400 p-2">
                            <input type="number" id="diez" class="border border-gray-400 p-1 transparent-input w-full" step="0.1" oninput="validarRango(this);sumarValores10()" placeholder="0" >
                        </td>
                        <td class="border border-gray-400 p-2">
                            <div>
                                <p> <input type="number" id="sumadiez" class="border border-gray-400 p-1 transparent-input" readonly></p>
                            </div>
                        </td>
                    </tr>
                        <tr>
                        <td class="border border-gray-400 p-2 align-middle">Mantener su área y equipos de trabajo en buenas condiciones.</td>
                            <td class="border border-gray-400 p-2">
                            <input type="number" id="once" class="border border-gray-400 p-1 transparent-input w-full" step="0.1" oninput="validarRango(this);sumarValores11()" placeholder="0" >
                        </td>
                        <td class="border border-gray-400 p-2">
                            <input type="number" id="once" class="border border-gray-400 p-1 transparent-input w-full" step="0.1" oninput="validarRango(this);sumarValores11()" placeholder="0" >
                        </td>
                        <td class="border border-gray-400 p-2">
                            <div>
                                <p> <input type="number" id="sumaonce" class="border border-gray-400 p-1 transparent-input" readonly></p>
                            </div>
                        </td>
                    </tr>
                        <tr>
                        <td class="border border-gray-400 p-2 align-middle">Participar en la investigación de accidentes e incidentes que se presenten en los difertentes grupos de trabajo o en la oficina.</td>
                            <td class="border border-gray-400 p-2">
                            <input type="number" id="doce" class="border border-gray-400 p-1 transparent-input w-full" step="0.1" oninput="validarRango(this);sumarValores12()" placeholder="0" >
                        </td>
                        <td class="border border-gray-400 p-2">
                            <input type="number" id="doce" class="border border-gray-400 p-1 transparent-input w-full" step="0.1" oninput="validarRango(this);sumarValores12()" placeholder="0" >
                        </td>
                        <td class="border border-gray-400 p-2">
                            <div>
                                <p> <input type="number" id="sumadoce" class="border border-gray-400 p-1 transparent-input" readonly></p>
                            </div>
                        </td>
                    </tr>
                        <tr>
                        <td class="border border-gray-400 p-2 align-middle">Procurar el cuidado del medio ambiente haciendo una adecuada separación en la fuente de residuos y ahorrando agua y energía.</td>
                            <td class="border border-gray-400 p-2">
                            <input type="number" id="trece" class="border border-gray-400 p-1 transparent-input w-full" step="0.1" oninput="validarRango(this);sumarValores13()" placeholder="0" >
                        </td>
                        <td class="border border-gray-400 p-2">
                            <input type="number" id="trece" class="border border-gray-400 p-1 transparent-input w-full" step="0.1" oninput="validarRango(this);sumarValores13()" placeholder="0" >
                        </td>
                        <td class="border border-gray-400 p-2">
                            <div>
                                <p> <input type="number" id="sumatrece" class="border border-gray-400 p-1 transparent-input" readonly></p>
                            </div>
                        </td>
                    </tr>                    
                </tbody>
            </table>
            <tr>
                <td colspan="3" class="border border-gray-400 p-2 text-right align-middle">
                    <div class="text-right">
                        <strong>PROMEDIO: </strong>
                        <input type="number" id="promedio" class="border border-gray-400 p-1 transparent-input" readonly>
                    
                        <strong>PUNTAJE: </strong>
                        <input type="number" id="sumaTotal" class="border border-gray-400 p-1 transparent-input" readonly>
                    </div>
                </td>
            </tr><br>
            <table class="w-full border-collapse border border-gray-400">
    <thead>
        <tr>
            <th colspan="2" class="border border-gray-400 p-2 text-center bg-blue-200">ANÁLISIS EVALUACIÓN DE RESPONSABILIDADES HSEQ</th>
            <th colspan="2" class="border border-gray-400 p-2 text-center bg-blue-200">COMPROMISO DEL TRABAJADOR</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="2" class="border border-gray-400 p-2 bg-gray-200 text-center">
                A continuación describe brevemente las fortalezas y debilidades en el cumplimiento de las responsabilidades antes expuestas.
            </td>
            <td colspan="2" class="border border-gray-400 p-2 bg-gray-200 text-center">
                A continuación establece a qué se compromete como trabajador para mejorar su desempeño.
            </td>
        </tr>
        <tr>
            <td colspan="2" class="border border-gray-400 p-2 text-center">
                <input type="text" class="w-full">
            </td>
            <td colspan="2" class="border border-gray-400 p-2 text-center">
                <input type="text" class="w-full">
            </td>
        </tr>
        <tr>
            <th colspan="4" class="border border-gray-400 p-2 text-center bg-blue-200">ACCIONES A TOMAR</th>
        </tr>
        <tr>
            <td colspan="4" class="border border-gray-400 p-2 text-center">
                <div class="flex justify-center gap-4">
                    <label><input type="checkbox" class="mr-2"> Capacitación en funciones y responsabilidades técnicas</label>
                    <label><input type="checkbox" class="mr-2"> Fortalecimiento de habilidades</label>
                    <label><input type="checkbox" class="mr-2"> Capacitación en funciones y responsabilidades HSE</label>
                    <label><input type="checkbox" class="mr-2"> Reinducción</label>
                </div>
            </td>
        </tr>
        <tr>
            <th colspan="4" class="border border-gray-400 p-2 text-center bg-blue-200">PLAN DE ACCIÓN</th>
        </tr>
        <tr>
            <td class="border border-gray-400 p-2 text-center bg-gray-200">ACTIVIDAD</td>
            <td class="border border-gray-400 p-2 text-center bg-gray-200">RESPONSABLE SEGUIMIENTO</td>
            <td class="border border-gray-400 p-2 text-center bg-gray-200">RECURSO</td>
            <td class="border border-gray-400 p-2 text-center bg-gray-200">FECHA</td>
        </tr>

        <!-- Filas de plan de acción generadas con PHP o un bucle -->
        <?php for ($i = 0; $i < 1; $i++): ?>
            <tr>
                <td class="border border-gray-400 p-2"><input type="text" class="w-full"></td>
                <td class="border border-gray-400 p-2"><input type="text" class="w-full"></td>
                <td class="border border-gray-400 p-2"><input type="text" class="w-full"></td>
                <td class="border border-gray-400 p-2"><input type="date" class="w-full"></td>
            </tr>
            <tr>
                <td class="border border-gray-400 p-2"><input type="text" class="w-full"></td>
                <td class="border border-gray-400 p-2"><input type="text" class="w-full"></td>
                <td class="border border-gray-400 p-2"><input type="text" class="w-full"></td>
                <td class="border border-gray-400 p-2"><input type="date" class="w-full"></td>
            </tr>
            <tr>
                <td class="border border-gray-400 p-2"><input type="text" class="w-full"></td>
                <td class="border border-gray-400 p-2"><input type="text" class="w-full"></td>
                <td class="border border-gray-400 p-2"><input type="text" class="w-full"></td>
                <td class="border border-gray-400 p-2"><input type="date" class="w-full"></td>
            </tr>
        <?php endfor; ?>
    </tbody>
</table>
                <div class="flex flex-row items-center justify-center w-full space-x-10 mt-14">
                    <div class="flex flex-col items-center">
                        <label class="text-sm">Firma Evaluador</label>
                        <canvas class="signature-pad border border-gray-400" width="300" height="100"></canvas>
                        <div class="mt-2 flex flex-row space-x-2 justify-center">
                            <button type="button" class="bg-red-500 text-white px-2 py-1 rounded clear-signature flex items-center" onclick="clearSignature(1)">
                                Limpiar
                            </button>
                            <button type="button" class="bg-blue-500 text-white px-2 py-1 rounded flex items-center hide-on-pdf" onclick="document.getElementById('upload-signature-1').click();">
                                Subir Firma
                            </button>
                            <input type="file" accept="image/*" id="upload-signature-1" class="hidden" onchange="loadSignature(event, 1)" />
                        </div>
                    </div>
                    <div class="flex flex-col items-center">
                        <label class="text-sm">Firma Colaborador Evaluado</label>
                        <canvas class="signature-pad border border-gray-400" width="300" height="100"></canvas>
                        <div class="mt-2 flex flex-row space-x-2 justify-center">
                            <button type="button" class="bg-red-500 text-white px-2 py-1 rounded clear-signature flex items-center" onclick="clearSignature(2)">
                                Limpiar
                            </button>
                            <button type="button" class="bg-blue-500 text-white px-2 py-1 rounded flex items-center hide-on-pdf" onclick="document.getElementById('upload-signature-2').click();">
                                Subir Firma
                            </button>
                            <input type="file" accept="image/*" id="upload-signature-2" class="hidden" onchange="loadSignature(event, 2)" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script src="/static/js/evaluacionFuncionesYResponsabilidades.js"></script>
</body>
</html>