// Función para cargar la firma
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
    const signaturePad = new SignaturePad(canvas);
    signaturePad.clear(); // Limpiar utilizando SignaturePad
}

// Inicializar los pads de firma
document.querySelectorAll('.signature-pad').forEach(canvas => {
    new SignaturePad(canvas); // Asegurarse de inicializar SignaturePad en todos los canvas
});

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

const nombre_completoInput = document.getElementById('nombre_completo');
const fecha_inspeccionInput = document.getElementById('fecha_inspeccion');
const mesInput = document.getElementById('mes');
const cargoInput = document.getElementById('cargo');
const lugarInput = document.getElementById('lugar');
const downloadButton = document.getElementById('download-pdf');

// Función para mostrar alerta si faltan campos
function showAlertIfMissingFields(event){
    let missingFields = [];
    if(!nombre_completoInput.value) missingFields.push("nombre completo");
    if(!fecha_inspeccionInput.value) missingFields.push("fecha inspeccion");
    if(!mesInput.value) missingFields.push("mes ");
    if(!cargoInput.value) missingFields.push("cargo");
    if(!lugarInput.value) missingFields.push("lugar");
    if(missingFields.length > 0){
        event.preventDefault();
        alert(`Te falta: ${missingFields.join(', ')} para poder descargar el PDF.`);
        return false;
    }
    return true;
}

// Verificación de campos antes de continuar con la descarga del PDF
downloadButton.addEventListener('click', function(event) {
    const isFormValid = showAlertIfMissingFields(event);
    if (!isFormValid) {
        event.stopImmediatePropagation();
    }
});

downloadButton.addEventListener('click', function() {
    const { jsPDF } = window.jspdf;
    const formContent = document.getElementById('form-content');
    const actionColumns = formContent.querySelectorAll('.hide-on-pdf');

    // Deshabilitar el botón para evitar clics múltiples
    this.disabled = true;

    // Ocultar columnas de acción
    actionColumns.forEach(column => column.style.display = 'none');

    // Guardamos los selects con "Seleccione" y "Elija" y los vaciamos sin ocultarlos
    const selects = formContent.querySelectorAll('select');
    selects.forEach(select => {
        // Reemplazamos los valores que sean "#", "Seleccione" o "Elija" por un valor vacío
        if (select.value === "#" || select.options[select.selectedIndex].text.trim() === "Seleccione" || select.options[select.selectedIndex].text.trim() === "Elija") {
            // Cambiamos el valor del select a un string vacío para que quede vacío en el PDF
            select.value = '';
        }
    });

    // Captura el contenido después de hacer las modificaciones
    html2canvas(formContent, { backgroundColor: null }).then(canvas => {
        const imgData = canvas.toDataURL('image/png');
        const pdf = new jsPDF('portrait');
        const imgProps = pdf.getImageProperties(imgData);
        const pdfWidth = pdf.internal.pageSize.getWidth();
        const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;
        pdf.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);

        // Guardar PDF
        pdf.save('inspección_botiquin.pdf');

        // Restauramos los valores de los selects si los cambiamos
        selects.forEach(select => {
            if (select.value === '') {
                select.value = '#'; // Restauramos el valor original (o puedes dejarlo vacío si prefieres)
            }
        });

        // Mostrar columnas de acción nuevamente
        actionColumns.forEach(column => column.style.display = 'table-cell');

        // Enviar los datos PDF al servidor
        const pdfData = pdf.output('datauristring').split(',')[1];

        // Verifica que los datos sean válidos antes de enviar
        if (pdfData) {
            fetch('inspeccionBotiquin.php', {
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


// Función para crear una copia del formulario con solo los valores
function createPrintableVersion() {
    const original = document.querySelector('#form-content');
    const printable = original.cloneNode(true);
    
    // Procesar inputs
    printable.querySelectorAll('input').forEach(input => {
        if (input.type === 'date' && input.value) {
            const date = new Date(input.value);
            const formattedDate = date.toLocaleDateString('es-CO');
            const span = document.createElement('span');
            span.textContent = formattedDate;
            input.parentNode.replaceChild(span, input);
        } else if (input.value) {
            const span = document.createElement('span');
            span.textContent = input.value;
            input.parentNode.replaceChild(span, input);
        } else {
            const span = document.createElement('span');
            span.textContent = '-';
            input.parentNode.replaceChild(span, input);
        }
    });

    // Procesar selects
    printable.querySelectorAll('select').forEach(select => {
        const span = document.createElement('span');
        span.textContent = select.value || '-';
        select.parentNode.replaceChild(span, select);
    });

    // Estilizar para impresión
    printable.querySelectorAll('td').forEach(td => {
        td.style.padding = '8px';
        td.style.fontSize = '12px';
    });

    return printable;
}

// Función para enviar correo
function enviarCorreo() {
    $.ajax({
        url: 'inspeccionBotiquin.php',
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
