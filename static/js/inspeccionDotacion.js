// Función para mover al siguiente input
function moveToNext(event, nextInput) {
    const input = event.target;

    // Si el campo tiene el número máximo de caracteres, movemos el foco al siguiente input
    if (input.value.length === input.maxLength && nextInput) {
        nextInput.focus();
    }
}

// Función para mover al input anterior al presionar Backspace
function moveToPrevious(event, currentInput) {
    if (event.key === "Backspace") {
        // Si el campo está vacío, movemos el foco al input anterior
        if (currentInput && currentInput.value === "") {
            let previousInput = currentInput.previousElementSibling;
            while (previousInput && previousInput.value === "") {
                previousInput = previousInput.previousElementSibling;
            }
            if (previousInput) {
                previousInput.focus();
            }
        }
    }
}

// Función para subir y mostrar una imagen en el canvas como firma
function uploadSignature(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = new Image();
            img.onload = function() {
                const canvas = event.target.closest('td').querySelector('.signature-pad');
                const ctx = canvas.getContext("2d");
                
                // Limpiar el canvas antes de dibujar
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                
                // Calcular la escala para mantener la proporción de la imagen
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

// Función para inicializar todos los pads de firma
function initializeSignaturePads() {
    document.querySelectorAll('.signature-pad').forEach(canvas => {
        new SignaturePad(canvas);  // Inicializar un nuevo SignaturePad para cada canvas
    });
}

// Función para limpiar todas las firmas
function clearAllSignatures() {
    document.querySelectorAll('.signature-pad').forEach(canvas => {
        const signaturePad = new SignaturePad(canvas);
        signaturePad.clear();
    });
}

// Inicializar los pads de firma existentes cuando la página se carga
initializeSignaturePads();

// Agregar una nueva fila a la tabla
document.getElementById('add-row').addEventListener('click', function() {
    const tableBody = document.getElementById('table-body');
    
    if (tableBody.rows.length >= 18) {
        const tableBody = document.getElementById('table-body');
            const toast = document.createElement('div');
            toast.classList.add(
                'fixed', 'top-20', 'left-1/2', '-translate-x-1/2', '-translate-y-1/2', 
                'bg-orange-300', 'text-black', 'px-6', 'py-3', 'rounded-lg', 
                'shadow-lg', 'transition-all', 'duration-300', 'ease-in-out', 
                'text-center'
            );
            toast.textContent = 'Solo puedes agregar un máximo de 18 registros, envía y crea otro archivo para poder seguir registrando. Gracias.';
            
            document.body.appendChild(toast);
        
            setTimeout(() => {
                toast.classList.add('opacity-0');
                setTimeout(() => toast.remove(), 300);
            }, 3000); // El toast desaparecerá después de 3 segundos
        
        return; // Detener la ejecución si ya hay 6 filas
    }

    const newRow = document.createElement('tr');
    newRow.innerHTML = `
        <td class="border border-gray-400 p-2">
            <input class="w-full border-none p-1 text-xs" type="date"/>
        </td>
        <td class="border border-gray-400 p-2">
            <input class="w-full border-none p-1 text-xs" type="text"/>
        </td>
        <td class="border border-gray-400 p-2">
            <input class="w-full border-none p-1 text-xs" type="text"/>
        </td>
        <td class="border border-gray-400 p-2 flex flex-col items-center justify-center">
            <canvas class="border border-gray-400 p-1 signature-pad" width="150" height="55"></canvas>
            <div class="mt-2 inline-flex space-x-2 justify-center hide-on-pdf">
                <button class="bg-red-500 text-white px-2 py-1 rounded clear-signature flex items-center">
                    <svg class="w-2.5 h-2.5 mr-1 text-red-200" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <path d="M3 6h18v2H3V6zm3 3h12v13H6V9zm4-5h4v2h-4V4zM5 6h14v16a2 2 0 01-2 2H7a2 2 0 01-2-2V6zm6 5v3h3V11h-3z"/>
                    </svg> 
                    Limpiar
                </button>
    
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
            <div class="grid grid-cols-4 gap-2">
                <select class="w-full border-none p-1 text-xs" required>
                    <option value="" selected>Seleccione</option>
                    <option value="B">B</option>
                    <option value="M">M</option>
                </select>
                <select class="w-full border-none p-1 text-xs" required>
                    <option value="" selected>Seleccione</option>
                    <option value="B">B</option>
                    <option value="M">M</option>
                </select>
                <select class="w-full border-none p-1 text-xs" required>
                    <option value="" selected>Seleccione</option>
                    <option value="B">B</option>
                    <option value="M">M</option>
                </select>
                <select class="w-full border-none p-1 text-xs" required>
                    <option value="" selected>Seleccione</option>
                    <option value="B">B</option>
                    <option value="M">M</option>
                    <option value="n/a">N/A</option>
                </select>
            </div>
        </td>
        <td class="border border-gray-400 p-2">
            <div class="grid grid-cols-6 gap-2">
                <select class="w-full border-none p-1 text-xs" required>
                    <option value="" selected>Seleccione</option>
                    <option value="B">B</option>
                    <option value="M">M</option>
                </select>
                <select class="w-full border-none p-1 text-xs" required>
                    <option value="" selected>Seleccione</option>
                    <option value="B">B</option>
                    <option value="M">M</option>
                </select>
                <select class="w-full border-none p-1 text-xs" required>
                    <option value="" selected>Seleccione</option>
                    <option value="B">B</option>
                    <option value="M">M</option>
                </select>
                <select class="w-full border-none p-1 text-xs" required>
                    <option value="" selected>Seleccione</option>
                    <option value="B">B</option>
                    <option value="M">M</option>
                </select>
                <select class="w-full border-none p-1 text-xs" required>
                    <option value="" selected>Seleccione</option>
                    <option value="B">B</option>
                    <option value="M">M</option>
                </select>
                <select class="w-full border-none p-1 text-xs" required>
                    <option value="" selected>Seleccione</option>
                    <option value="B">B</option>
                    <option value="M">M</option>
                </select>
            </div>
        </td>
        <td class="border border-gray-400 p-2">
            <div class="grid grid-cols-2 gap-2">
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
        <td class="border border-gray-400 p-2">
            <!-- Ropa de Invierno -->
            <div class="grid grid-cols-2 gap-2 text-xs">
                <select class="w-full border-transparent p-1 text-xs rounded" required>
                    <option value="" selected>Seleccione</option>
                    <option value="Impermeable">Impermeable</option>
                    <option value="Botas">Botas</option>
                </select>
                <select class="w-full border-transparent p-1 text-xs rounded" required>
                    <option value="" selected>Seleccione</option>
                    <option value="Impermeable">Impermeable</option>
                    <option value="Botas">Botas</option>
                </select>
            </div>
        </td>
         <td class="border border-gray-400 p-2 text-center">
            <button class="bg-red-500 text-white px-2 py-1 rounded remove-row flex items-center justify-center mx-auto">
                X
            </button>
        </td>
    `;
    
    tableBody.appendChild(newRow);

    // Inicializar los pads de firma para la nueva fila
    const newSignaturePad = new SignaturePad(newRow.querySelector('.signature-pad'));

    // Agregar el evento para limpiar la firma de la fila recién creada
    newRow.querySelector('.clear-signature').addEventListener('click', function() {
        newSignaturePad.clear();
    });
});


// Asegúrate de que los botones de limpieza en las filas existentes también funcionen
document.querySelectorAll('.clear-signature').forEach(button => {
    button.addEventListener('click', function() {
        const canvas = this.closest('td').querySelector('.signature-pad');
        const signaturePad = new SignaturePad(canvas);
        signaturePad.clear();
    });
});


const localizacionInput = document.getElementById('localizacion');
const clienteInput = document.getElementById('cliente');
const inspectorInput = document.getElementById('inspector');
const numeroContratoInput = document.getElementById('numeroContrato');
const downloadButton = document.getElementById('download-pdf');

function showAlertIfMissingFields(event){
    let missingFields = [];
    if(!localizacionInput.value) missingFields.push("localizacion");
    if(!clienteInput.value) missingFields.push("cliente");
    if(!inspectorInput.value) missingFields.push("inspector ");
    if(!numeroContratoInput.value) missingFields.push("numeroContrato");
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
        pdf.save('inspección_dotación.pdf');

        // Restaurar los estilos originales
        originalDisplayStyles.forEach(({ element, display }) => {
            element.style.display = display;
        });

        // Enviar los datos del PDF al servidor
        const pdfData = pdf.output('datauristring').split(',')[1];

        // Verificar que los datos sean válidos antes de enviarlos
        if (pdfData) {
            fetch('inspeccionDotacion.php', {
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

// Initialize signature pads
document.querySelectorAll('.signature-pad').forEach(canvas => {
    new SignaturePad(canvas);
});


function enviarCorreo() {
$.ajax({
    url: 'inspeccionComportamental.php',
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
