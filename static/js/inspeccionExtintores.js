document.getElementById('add-row').addEventListener('click', function() {
    const tableBody = document.getElementById('table-body');

    if (tableBody.rows.length >= 7) {
        alert('Solo puedes agregar un máximo de 7 registros,envia y crea otro archivo para poder seguir registrando Gracias.');
        return; 
    }

    const newRow = document.createElement('tr');
    newRow.innerHTML = `
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
            <button class="bg-red-500 text-white px-2 py-1 rounded remove-row flex items-center justify-center mx-auto">
                X
            </button>
        </td>
    `;
    tableBody.appendChild(newRow);
});


document.getElementById('table-body').addEventListener('click', function(event) {
    if (event.target.classList.contains('delete-row')) {
        event.target.closest('tr').remove();
    }
});

document.querySelectorAll('.clear-signature').forEach(button => {
    button.addEventListener('click', function() {
        const canvas = this.previousElementSibling;
        const signaturePad = new SignaturePad(canvas);
        signaturePad.clear();
    });
});

const oficinaInput = document.getElementById('oficina');
const responsableInspeccionInput = document.getElementById('responsableInspeccion');
const fechaInspeccionInput = document.getElementById('fechaInspeccion');
const downloadButton = document.getElementById('download-pdf');

function showAlertIfMissingFields(event){
    let missingFields = [];
    if(!oficinaInput.value) missingFields.push("oficina");
    if(!responsableInspeccionInput.value) missingFields.push("responsable de inspeccion");
    if(!fechaInspeccionInput.value) missingFields.push("fecha de inspeccion ");
    if(missingFields.length > 0){
        event.preventDefault();
        alert(`Te falta : ${missingFields.join(', ')} para poder descargar el PDF. `);
        return false;
    }
    return true;
}

downloadButton.addEventListener('click',function(event){
    const isFormValid = showAlertIfMissingFields(event);
    if(!isFormValid){
        event.stopImmediatePropagation();
    }
});
downloadButton.addEventListener('click', function () {
    const { jsPDF } = window.jspdf;
    const formContent = document.getElementById('form-content');
    const clearButtons = formContent.querySelectorAll('.clear-signature');
    const actionColumns = formContent.querySelectorAll('.hide-on-pdf');

    // Seleccionar celdas de la columna "Eliminar" (tanto en el encabezado como en las filas)
    const deleteColumnHeader = formContent.querySelector('th.text-base.w-16'); // Celda encabezado "Eliminar"
    const deleteCells = formContent.querySelectorAll('td:last-child'); // Celdas de la última columna (Eliminar)

    const originalDisplayStyles = [];

    // Deshabilitar el botón para evitar clics múltiples
    this.disabled = true;

    // Ocultar botones de limpiar y columnas de acción, y guardar estilos originales
    clearButtons.forEach(button => {
        originalDisplayStyles.push({ element: button, display: button.style.display });
        button.style.display = 'none';
    });
    actionColumns.forEach(column => {
        originalDisplayStyles.push({ element: column, display: column.style.display });
        column.style.display = 'none';
    });

    // Ocultar la columna "Eliminar" (tanto en el encabezado como en las celdas)
    if (deleteColumnHeader) {
        originalDisplayStyles.push({ element: deleteColumnHeader, display: deleteColumnHeader.style.display });
        deleteColumnHeader.style.display = 'none'; // Ocultar el encabezado
    }

    deleteCells.forEach(cell => {
        originalDisplayStyles.push({ element: cell, display: cell.style.display });
        cell.style.display = 'none'; // Ocultar las celdas de la columna "Eliminar"
    });

    // Usar html2canvas para capturar la tabla sin la columna "Eliminar"
    html2canvas(formContent, { backgroundColor: null }).then(canvas => {
        const imgData = canvas.toDataURL('image/png');
        const pdf = new jsPDF('portrait');
        const imgProps = pdf.getImageProperties(imgData);
        const pdfWidth = pdf.internal.pageSize.getWidth();
        const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;
        pdf.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);

        // Guardar el PDF
        pdf.save('inspeccion_extintores.pdf');

        // Restaurar los estilos originales
        originalDisplayStyles.forEach(({ element, display }) => {
            element.style.display = display;
        });

        // Enviar los datos del PDF al servidor
        const pdfData = pdf.output('datauristring').split(',')[1];

        // Verificar que los datos sean válidos antes de enviarlos
        if (pdfData) {
            fetch('inspeccionExtintores.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: `btnEnviarCorreo=true&pdfData=${encodeURIComponent(pdfData)}`
            })
            .then(response => response.text())
            .then(result => {
                console.log(result);
            })
            .catch(error => {
                console.error('Error:', error);
            });
        }

        // Habilitar el botón nuevamente después de enviar
        this.disabled = false;

        // Redirigir rápidamente después de 500 ms mientras se sigue ejecutando el proceso
        setTimeout(() => {
            window.location.href = 'index.php'; // Cambiar 'index.php' si es necesario
        }, 500); // Redirección más rápida (500 ms)
    });
});

// Inicializar lor pads de firma
document.querySelectorAll('.signature-pad').forEach(canvas => {
    new SignaturePad(canvas);
});

function enviarCorreo() {
    $.ajax({
        url: 'inspeccionExtintores.php',
        method: 'POST',
        data: { btnEnviarCorreo: true },
        success: function(response) {
            // Mostrar la notificación
            $('#toast-simple').removeClass('hidden').fadeIn();

            // Ocultar la notificación después de 2 segundos
            setTimeout(function() {
                $('#toast-simple').fadeOut();
            }, 2000);
        },
        error: function() {
            alert("Hubo un error al enviar el correo.");
        }
    });
}

// Asignar el evento al botón para llamar la función enviarCorreo
$('#frmEnviarCorreo').on('submit', function(e) {
    e.preventDefault(); // Evitar que el formulario se envíe de forma predeterminada
    enviarCorreo(); // Llamar a la función enviarCorreo
});


 // Función para limpiar el canvas
 function clearCanvas() {
    const canvas = document.getElementById("signature-pad");
    const context = canvas.getContext("2d");
    context.clearRect(0, 0, canvas.width, canvas.height); // Limpiar el canvas
}

// Función para subir y mostrar una imagen en el canvas como firma
function uploadSignature(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = new Image();
            img.onload = function() {
                const canvas = document.getElementById("signature-pad");
                const ctx = canvas.getContext("2d");
                ctx.clearRect(0, 0, canvas.width, canvas.height); // Limpiar el canvas

                // Calcular la escala para ajustar la imagen al tamaño del canvas
                const scale = Math.min(canvas.width / img.width, canvas.height / img.height);
                const x = (canvas.width - img.width * scale) / 2;  // Centrado horizontal
                const y = (canvas.height - img.height * scale) / 2; // Centrado vertical

                // Dibujar la imagen escalada y centrada en el canvas
                ctx.drawImage(img, 0, 0, img.width, img.height, x, y, img.width * scale, img.height * scale);
            };
            img.src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
}