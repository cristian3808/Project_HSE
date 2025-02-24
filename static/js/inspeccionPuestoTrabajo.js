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

const locacionInput = document.getElementById('locacion');
const fechaInput = document.getElementById('fecha');
const inspectorInput = document.getElementById('inspector');
const horaInput = document.getElementById('hora');
const downloadButton = document.getElementById('download-pdf');

function showAlertIfMissingFields(event){
    let missingFields = [];
    if(!locacionInput.value) missingFields.push("Locacion");
    if(!fechaInput.value) missingFields.push("fecha");
    if(!inspectorInput.value) missingFields.push("inspector");
    if(!horaInput.value) missingFields.push("hora");
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
// document.getElementById('download-pdf').addEventListener('click', function() {
downloadButton.addEventListener('click', function () {
    const { jsPDF } = window.jspdf;
    const formContent = document.getElementById('form-content');
    const clearButtons = formContent.querySelectorAll('.clear-signature');
    const actionColumns = formContent.querySelectorAll('.hide-on-pdf');

    // Deshabilitar el botón para evitar clics múltiples
    this.disabled = true;

    // Inicia la redirección después de un breve tiempo
    setTimeout(() => {
        window.location.href = 'index.php';
    }, 500); // Ajusta el tiempo según sea necesario.

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

        // Guardar PDF
        pdf.save('inspeccion_trabajo.pdf');

        // Restaurar botones de limpiar y columnas de acción
        clearButtons.forEach(button => button.style.display = 'block');
        actionColumns.forEach(column => column.style.display = 'table-cell');

        // Enviar el PDF al servidor
        const pdfData = pdf.output('datauristring').split(',')[1];
        if (pdfData) {
            fetch('inspeccionPuestoTrabajo.php', {
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
                })
                .finally(() => {
                    // Rehabilitar el botón después del envío
                    this.disabled = false;
                });
        }
    });
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
        success: function (response) {
            // Mostrar notificación
            $('#toast-simple').removeClass('hidden').fadeIn();

            // Ocultar notificación después de 2 segundos
            setTimeout(function () {
                $('#toast-simple').fadeOut();
            }, 2000);
        },
        error: function () {
            alert("Hubo un error al enviar el correo.");
        }
    });
}

// Asignar evento al formulario
$('#frmEnviarCorreo').on('submit', function (e) {
    e.preventDefault();
    enviarCorreo();
});
