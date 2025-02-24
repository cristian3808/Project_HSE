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

function loadSignature(event, canvasIndex) {
    const file = event.target.files[0];
    const reader = new FileReader();
    reader.onload = function(e) {
        const canvas = document.querySelectorAll('.signature-pad')[canvasIndex - 1];
        const context = canvas.getContext('2d');
        const img = new Image();
        
        img.onload = function() {
            context.clearRect(0, 0, canvas.width, canvas.height); // Limpiar el canvas antes de dibujar

            // Calcular la escala para mantener la proporción
            const scale = Math.min(canvas.width / img.width, canvas.height / img.height);
            const x = (canvas.width - img.width * scale) / 2;  // Centrado horizontal
            const y = (canvas.height - img.height * scale) / 2; // Centrado vertical
            
            // Dibujar la imagen escalada y centrada
            context.drawImage(img, 0, 0, img.width, img.height, x, y, img.width * scale, img.height * scale);
        };

        img.src = e.target.result;
    };
    reader.readAsDataURL(file);
}

// Función para limpiar el canvas
function clearSignature(canvasIndex) {
    const canvas = document.querySelectorAll('.signature-pad')[canvasIndex - 1];
    const context = canvas.getContext('2d');
    context.clearRect(0, 0, canvas.width, canvas.height); // Limpiar el canvas
}

document.querySelectorAll('.clear-signature').forEach((button, index) => {
    button.addEventListener('click', function() {
        const canvas = document.querySelectorAll('.signature-pad')[index];
        const context = canvas.getContext('2d');
        context.clearRect(0, 0, canvas.width, canvas.height); // Limpiar el canvas

        // Restablecer el input de archivo
        const fileInput = document.getElementById(`upload-signature-${index + 1}`);
        if (fileInput) {
            fileInput.value = ''; // Reiniciar el input para permitir cargar la misma imagen nuevamente
        }
    });
});

const localizacionInput = document.getElementById('localizacion');
const fechaInput = document.getElementById('fecha');
const inspeccion_n_Input = document.getElementById('inspeccion_n');
const horaInput = document.getElementById('hora');
const inspectorInput = document.getElementById('inspector');
const downloadButton = document.getElementById('download-pdf');

function showAlertIfMissingFields(event){
    let missingFields = [];
    if(!localizacionInput.value) missingFields.push("localizacion");
    if(!fechaInput.value) missingFields.push("fecha");
    if(!inspeccion_n_Input.value) missingFields.push("inspeccion_n ");
    if(!horaInput.value) missingFields.push("hora");
    if(!inspectorInput.value) missingFields.push("inspector");
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

    // Deshabilitar el botón para evitar clics múltiples
    this.disabled = true;

    // Ocultar botones de limpiar y columnas de acción
    clearButtons.forEach(button => button.style.display = 'none');
    actionColumns.forEach(column => column.style.display = 'none');

    html2canvas(formContent, { backgroundColor: null }).then(canvas => {
        const imgData = canvas.toDataURL('image/png');
        const pdf = new jsPDF('portrait');
        const imgProps = pdf.getImageProperties(imgData);
        const pdfWidth = pdf.internal.pageSize.getWidth();
        const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;
        pdf.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);

        // Guardar el PDF
        pdf.save('inspeccion_gerencial.pdf');

        // Mostrar botones de limpiar y columnas de acción nuevamente
        clearButtons.forEach(button => button.style.display = 'block');
        actionColumns.forEach(column => column.style.display = 'table-cell');

        // Enviar el PDF al servidor
        const pdfData = pdf.output('datauristring').split(',')[1];
        if (pdfData) {
            fetch('inspeccionGerencial.php', {
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
    // Redirigir rápidamente mientras el proceso continúa ejecutándose
    setTimeout(() => {
        window.location.href = 'index.php'; // Cambiar 'index.php' si es necesario
    }, 500); // Redirección más rápida (500 ms)
});

// Inicializar los pads de firma
document.querySelectorAll('.signature-pad').forEach(canvas => {
    new SignaturePad(canvas);
});

function enviarCorreo() {
    $.ajax({
        url: 'inspeccionGerencial.php',
        method: 'POST',
        data: { btnEnviarCorreo: true },
        success: function(response) {
            // Mostrar la notificación
            $('#toast-simple').removeClass('hidden').fadeIn();

            // Redirigir al índice más rápidamente después de enviar el correo
            setTimeout(function() {
                window.location.href = 'index.php';
            }, 500); // Redirección más rápida
        },
        error: function() {
            alert("Hubo un error al enviar el correo.");
        }
    });
}

// Asignar el evento al formulario para llamar a la función enviarCorreo
$('#frmEnviarCorreo').on('submit', function(e) {
    e.preventDefault(); // Evitar el envío predeterminado
    enviarCorreo(); // Llamar a la función enviarCorreo
});
