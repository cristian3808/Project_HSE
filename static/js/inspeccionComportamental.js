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
// Función para limpiar el canvas
document.querySelector('.clear-signature').addEventListener('click', function() {
    const canvas = document.querySelector('.signature-pad');
    const context = canvas.getContext('2d');
    context.clearRect(0, 0, canvas.width, canvas.height);
});
document.getElementById('add-row').addEventListener('click', function() {
    const tableBody = document.getElementById('table-body');

    if (tableBody.rows.length >= 17) {
        const toast = document.createElement('div');
        toast.classList.add(
            'fixed', 'top-20', 'left-1/2', '-translate-x-1/2', '-translate-y-1/2', 
            'bg-orange-300', 'text-black', 'px-6', 'py-3', 'rounded-lg', 
            'shadow-lg', 'transition-all', 'duration-300', 'ease-in-out', 
            'text-center'
        );
        toast.textContent = 'Solo puedes agregar un máximo de 17 registros, envía y crea otro archivo para poder seguir registrando. Gracias.';
        
        document.body.appendChild(toast);
    
        setTimeout(() => {
            toast.classList.add('opacity-0');
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    
        return;
    }
    
    const newRow = document.createElement('tr');
    newRow.innerHTML = `
        <td class="border border-gray-400 p-2">
            <input type="date" class="border border-gray-400 p-1 transparent-input" id="fecha">
        </td>
        <td class="border border-gray-400 p-2">
            <input type="time" class="border border-gray-400 p-1 transparent-input" id="hora">
        </td>
        <td class="border border-gray-400 p-2">
            <input type="text" placeholder="." class="border border-gray-400 p-1 transparent-input">
        </td>
        <td class="border border-gray-400 p-2 flex flex-col items-center justify-center">
            <canvas class="border border-gray-400 p-1 signature-pad" width="155" height="30"></canvas>
            <div class="mt-2 inline-flex space-x-2 justify-center hide-on-pdf">
                <button class="bg-red-500 text-white px-2 py-1 rounded clear-signature flex items-center">
                    Limpiar
                </button>
                <label class="bg-blue-500 text-white px-2 py-1 rounded cursor-pointer flex items-center">
                    <input type="file" class="hidden" accept="image/*" id="upload-signature" onchange="uploadSignature(event)">
                    Subir
                </label>
            </div>
        </td>
        <td class="border border-gray-400 p-2 text-xs">
            <label><strong>1.</strong> SI <input type="radio" name="comportamiento1-${tableBody.rows.length + 1}" class="mr-2"> NO <input type="radio" name="comportamiento1-${tableBody.rows.length + 1}" class="mr-2"></label><br>
            <label><strong>2.</strong> SI <input type="radio" name="comportamiento2-${tableBody.rows.length + 1}" class="mr-2"> NO <input type="radio" name="comportamiento2-${tableBody.rows.length + 1}" class="mr-2"></label><br>
            <label><strong>3.</strong> SI <input type="radio" name="comportamiento3-${tableBody.rows.length + 1}" class="mr-2"> NO <input type="radio" name="comportamiento3-${tableBody.rows.length + 1}" class="mr-2"></label><br>
            <label><strong>4.</strong> SI <input type="radio" name="comportamiento4-${tableBody.rows.length + 1}" class="mr-2"> NO <input type="radio" name="comportamiento4-${tableBody.rows.length + 1}" class="mr-2"></label><br>
            <label><strong>5.</strong> SI <input type="radio" name="comportamiento5-${tableBody.rows.length + 1}" class="mr-2"> NO <input type="radio" name="comportamiento5-${tableBody.rows.length + 1}" class="mr-2"></label>
        </td>
        <td class="border border-gray-400 p-2" style="width: 200px;">
            <input placeholder="." type="text" class="w-full border-none p-1 text-xs" maxlength="28">
            <input type="text" class="w-full border-none p-1 text-xs" maxlength="28">
        </td>
        <td class="border border-gray-400 p-2" style="width: 200px;">
            <input placeholder="." type="text" class="w-full border-none p-1 text-xs" maxlength="28">
            <input type="text" class="w-full border-none p-1 text-xs" maxlength="28">
        </td>
        <td class="border border-gray-400 p-2">
            <input type="text" class="border border-gray-400 p-1 transparent-input" placeholder=".">
        </td>
        <td class="border border-gray-400 p-2">
            <input type="date" class="border border-gray-400 p-1 transparent-input">
        </td>
        <td class="border border-gray-400 p-2 text-center">
            <button class="bg-red-500 text-white px-2 py-1 rounded remove-row flex items-center justify-center mx-auto">
                X
            </button>
        </td>
    `;
    
    newRow.querySelector('.remove-row').addEventListener('click', function() {
        newRow.remove();
    });
    tableBody.appendChild(newRow);

    // Inicializar SignaturePad para el canvas de la nueva fila
    const canvas = newRow.querySelector('.signature-pad');
    const signaturePad = new SignaturePad(canvas);
    
    // Asignar el evento para cargar la imagen
    const fileInput = newRow.querySelector('.upload-signature');
    fileInput.addEventListener('change', uploadSignature);
    
    // Evento para limpiar la firma en este canvas específico
    newRow.querySelector('.clear-signature').addEventListener('click', function() {
        signaturePad.clear();
    });
});


// Inicializar los pads de firma en las filas existentes
document.querySelectorAll('.signature-pad').forEach(canvas => {
    new SignaturePad(canvas);
});

//Funcion para limpiar la firma
document.querySelectorAll('.clear-signature').forEach(button => {
    button.addEventListener('click', function() {
        const canvas = this.closest('td').querySelector('.signature-pad');
        const signaturePad = new SignaturePad(canvas);
        signaturePad.clear();
    });
});
//Funcion para eliminar una fila
document.getElementById('table-body').addEventListener('click', function(event) {
    if (event.target.classList.contains('delete-row')) {
        event.target.closest('tr').remove();
    }
});

const localizacionInput = document.getElementById('localizacion');
const clienteInput = document.getElementById('cliente');
const numeroContratoInput = document.getElementById('numero-contrato');
const downloadButton = document.getElementById('download-pdf');

function showAlertIfMissingFields(event){
    let missingFields = [];
    if(!localizacionInput.value) missingFields.push("Localización");
    if(!clienteInput.value) missingFields.push("Cliente");
    if(!numeroContratoInput.value) missingFields.push("Número de contrato");
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

downloadButton.addEventListener('click', function() {
    const { jsPDF } = window.jspdf;
    const formContent = document.getElementById('form-content');
    const clearButtons = formContent.querySelectorAll('.clear-signature');
    const actionColumns = formContent.querySelectorAll('.hide-on-pdf');
    const deleteColumn = document.querySelectorAll('td:last-child, th:last-child'); // Última columna (Eliminar)

    // Deshabilitar el botón para evitar clics múltiples
    this.disabled = true;

    // Ocultar botones de limpiar, columnas de acción y la columna "Eliminar"
    clearButtons.forEach(button => button.style.display = 'none');
    actionColumns.forEach(column => column.style.display = 'none');
    deleteColumn.forEach(column => column.style.display = 'none');

    html2canvas(formContent, { backgroundColor: null }).then(canvas => {
        const imgData = canvas.toDataURL('image/png');
        const pdf = new jsPDF('portrait');
        const imgProps = pdf.getImageProperties(imgData);
        const pdfWidth = pdf.internal.pageSize.getWidth();
        const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;
        pdf.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);

        // Guardar el PDF
        pdf.save('inspeccion_comportamental.pdf');

        // Restaurar los elementos ocultos después de la captura
        clearButtons.forEach(button => button.style.display = 'block');
        actionColumns.forEach(column => column.style.display = 'table-cell');
        deleteColumn.forEach(column => column.style.display = 'table-cell'); // Mostrar columna de nuevo

        // Enviar el PDF al servidor
        const pdfData = pdf.output('datauristring').split(',')[1];
        if (pdfData) {
            fetch('inspeccionComportamental.php', {
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
    });

    // Redirigir inmediatamente mientras el proceso continúa
    setTimeout(() => {
        window.location.href = 'index.php'; // Cambiar 'index.php' si es necesario
    }, 500); // Redirección más rápida: después de 500 ms
});

// Inicializar los pads de firma
document.querySelectorAll('.signature-pad').forEach(canvas => {
    new SignaturePad(canvas);
});

function enviarCorreo() {
    $.ajax({
        url: 'inspeccionComportamental.php',
        method: 'POST',
        data: { btnEnviarCorreo: true },
        success: function(response) {
            // Mostrar notificación
            $('#toast-simple').removeClass('hidden').fadeIn();

            // Redirigir al índice casi inmediatamente
            setTimeout(function() {
                window.location.href = 'index.php';
            }, 500); // Cambiar el tiempo si es necesario
        },
        error: function() {
            alert("Hubo un error al enviar el correo.");
        }
    });
}

// Asignar el evento al formulario para llamar la función enviarCorreo
$('#frmEnviarCorreo').on('submit', function(e) {
    e.preventDefault(); // Evitar el envío predeterminado
    enviarCorreo(); // Llamar a la función para enviar el correo
});