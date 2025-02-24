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

const nombreInspectorInput = document.getElementById('nombreInspector');
const fechaInput = document.getElementById('fecha');
const downloadButton = document.getElementById('download-pdf');

// Función para mostrar alerta si faltan campos
function showAlertIfMissingFields(event){
    let missingFields = [];
    if(!nombreInspectorInput.value) missingFields.push("nombreInspector");
    if(!fechaInput.value) missingFields.push("fecha");
    if(missingFields.length > 0){
        event.preventDefault();
        alert(`Te falta: ${missingFields.join(', ')} para poder descargar el PDF.`);
        return false;
    }
    return true;
}

// Verificación de campos antes de proceder con la descarga del PDF
downloadButton.addEventListener('click', function(event) {
    const isFormValid = showAlertIfMissingFields(event);
    if (!isFormValid) {
        event.stopImmediatePropagation();
    }
});

// Evento para descarga de PDF
downloadButton.addEventListener('click', function() {
    const { jsPDF } = window.jspdf;
    const formContent = document.getElementById('form-content');
    const clearButtons = formContent.querySelectorAll('.clear-signature');
    const actionColumns = formContent.querySelectorAll('.hide-on-pdf');

    // Deshabilitar el botón para evitar clics múltiples
    this.disabled = true;

    // Ocultar botones claros y columnas de acción
    clearButtons.forEach(button => button.style.display = 'none');
    actionColumns.forEach(column => column.style.display = 'none');

    html2canvas(formContent, { backgroundColor: null }).then(canvas => {
        const imgData = canvas.toDataURL('image/png');
        const pdf = new jsPDF('landscape');
        const imgProps = pdf.getImageProperties(imgData);
        const pdfWidth = pdf.internal.pageSize.getWidth();
        const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;
        pdf.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);

        // Guardar PDF
        pdf.save('inspeccion_cafeteria.pdf');

        // Mostrar botones claros y columnas de acción nuevamente
        clearButtons.forEach(button => button.style.display = 'block');
        actionColumns.forEach(column => column.style.display = 'table-cell');

        // Enviar los datos PDF al servidor
        const pdfData = pdf.output('datauristring').split(',')[1];

        // Verifica que los datos sean válidos antes de enviar
        if (pdfData) {
            fetch('inspeccionCafeteria.php', {
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

// Inicializar los pads de firma
document.querySelectorAll('.signature-pad').forEach(canvas => {
    new SignaturePad(canvas);
});

function enviarCorreo() {
    $.ajax({
        url: 'inspeccionCafeteria.php',
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
