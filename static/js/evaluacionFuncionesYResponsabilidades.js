const nombreTrabajadorInput = document.getElementById('nombreTrabajador');
const cargoActualInput = document.getElementById('cargoActual');
const cargoEvalueInput = document.getElementById('cargoEvalue');
const downloadButton = document.getElementById('download-pdf');

function showAlertIfMissingFields(event){
    let missingFields = [];
    if(!nombreTrabajadorInput.value) missingFields.push("nombre trabajador");
    if(!cargoActualInput.value) missingFields.push("cargo actual");
    if(!cargoEvalueInput.value) missingFields.push("cargo evalue ");
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
downloadButton.addEventListener('click',function(){
    const { jsPDF } = window.jspdf;
    const formContent = document.getElementById('form-content');
    const clearButtons = formContent.querySelectorAll('.clear-signature');
    const actionColumns = formContent.querySelectorAll('.hide-on-pdf');

    // Deshabilitar el botón para evitar clics múltiples
    this.disabled = true;

    // Hide clear buttons and action columns
    clearButtons.forEach(button => button.style.display = 'none');
    actionColumns.forEach(column => column.style.display = 'none');

    html2canvas(formContent, { backgroundColor: null }).then(canvas => {
        const imgData = canvas.toDataURL('image/png');
        const pdf = new jsPDF('portrait');  // Cambiado a 'portrait' para formato vertical
        const imgProps = pdf.getImageProperties(imgData);
        const pdfWidth = pdf.internal.pageSize.getWidth();
        const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;
        pdf.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);

        // Guardar PDF
        pdf.save('evaluacionFuncionesYResponsabilidades.pdf');

        // Mostrar botones de borrar y columnas de acción nuevamente
        clearButtons.forEach(button => button.style.display = 'block');
        actionColumns.forEach(column => column.style.display = 'table-cell');

        // Enviar los datos del PDF al servidor
        const pdfData = pdf.output('datauristring').split(',')[1];

        // Verifica que los datos sean válidos antes de enviar
        if (pdfData) {
            fetch('evaluacionFuncionesYResponsabilidades.php', {
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

// Inicializa los pads de firma
document.querySelectorAll('.signature-pad').forEach(canvas => {
    new SignaturePad(canvas);
});

const signaturePadEvaluator = new SignaturePad(document.getElementById('signature-pad-evaluator'));
const signaturePadCollaborator = new SignaturePad(document.getElementById('signature-pad-collaborator'));

document.querySelectorAll('.clear-signature').forEach(button => {
    button.addEventListener('click', function() {
        const target = this.getAttribute('data-target');
        if (target === 'signature-pad-evaluator') {
            signaturePadEvaluator.clear();
        } else if (target === 'signature-pad-collaborator') {
            signaturePadCollaborator.clear();
        }
    });
});

// Función para categorizar las puntuaciones
function categorizePuntuacion(puntuacion) {
    if (puntuacion < 2.5) {
        return 'Malo';
    } else if (puntuacion >= 2.5 && puntuacion <= 3.4) {
        return 'Regular';
    } else if (puntuacion >= 3.5 && puntuacion <= 4.4) {
        return 'Bueno';
    } else if (puntuacion >= 4.5 && puntuacion <= 5.0) {
        return 'Muy Bueno';
    }
}

// Ejemplo de uso de la función de categorización
document.querySelectorAll('select').forEach(select => {
    select.addEventListener('change', function() {
        const puntuacion = parseFloat(this.value);
        const categoria = categorizePuntuacion(puntuacion);
        console.log(`Puntuación: ${puntuacion}, Categoría: ${categoria}`);
    });
});


function enviarCorreo() {
    $.ajax({
        url: 'evaluacionFuncionesYResponsabilidades.php',
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
// Función para limpiar el canvas y reiniciar SignaturePad
function clearSignature(canvasIndex) {
    const canvases = document.querySelectorAll('.signature-pad');
    if (canvasIndex < 1 || canvasIndex > canvases.length) {
        console.error('Índice de canvas fuera de rango.');
        return;
    }

    const canvas = canvases[canvasIndex - 1];
    const context = canvas.getContext('2d');

    // Limpiar el canvas
    context.clearRect(0, 0, canvas.width, canvas.height);

    // Si existe un objeto SignaturePad, reiniciarlo
    if (canvas.signaturePad) {
        canvas.signaturePad.clear(); // Limpiar la firma
    }

    // Re-inicializar el objeto SignaturePad en el canvas
    canvas.signaturePad = new SignaturePad(canvas);
}

// Función para cargar una imagen en el canvas
function loadSignature(event, canvasIndex) {
    const file = event.target.files[0];
    if (!file) {
        console.warn('No se seleccionó ningún archivo.');
        return;
    }

    const reader = new FileReader();
    reader.onload = function (e) {
        const canvases = document.querySelectorAll('.signature-pad');
        if (canvasIndex < 1 || canvasIndex > canvases.length) {
            console.error('Índice de canvas fuera de rango.');
            return;
        }

        const canvas = canvases[canvasIndex - 1];
        const context = canvas.getContext('2d');
        const img = new Image();

        img.onload = function () {
            // Limpiar el canvas antes de dibujar la imagen
            context.clearRect(0, 0, canvas.width, canvas.height);

            // Calcular escala y posición para mantener proporciones
            const scale = Math.min(canvas.width / img.width, canvas.height / img.height);
            const x = (canvas.width - img.width * scale) / 2;
            const y = (canvas.height - img.height * scale) / 2;

            // Dibujar la imagen escalada y centrada
            context.drawImage(img, 0, 0, img.width, img.height, x, y, img.width * scale, img.height * scale);
        };

        img.src = e.target.result;
    };

    reader.readAsDataURL(file);
}

// Función para guardar la firma en base64
function saveSignature(canvasIndex) {
    const canvases = document.querySelectorAll('.signature-pad');
    if (canvasIndex < 1 || canvasIndex > canvases.length) {
        console.error('Índice de canvas fuera de rango.');
        return;
    }

    const canvas = canvases[canvasIndex - 1];

    // Verificar si la firma está disponible
    if (canvas.signaturePad.isEmpty()) {
        console.warn('No hay firma en el canvas.');
        return;
    }

    // Obtener la firma en formato base64
    const signatureDataUrl = canvas.signaturePad.toDataURL();

    // Mostrar la firma en un elemento <img>
    const imgElement = document.createElement('img');
    imgElement.src = signatureDataUrl;
    imgElement.alt = 'Firma';

    // Agregar la imagen a un contenedor (puedes personalizarlo como desees)
    const signatureContainer = document.getElementById('signature-container');
    signatureContainer.innerHTML = ''; // Limpiar el contenedor
    signatureContainer.appendChild(imgElement);

    console.log('Firma guardada: ', signatureDataUrl); // Imprimir la firma en base64
}


// Asignar el evento al botón para llamar la función enviarCorreo
$('#frmEnviarCorreo').on('submit', function(e) {
    e.preventDefault(); // Evitar que el formulario se envíe de forma predeterminada
    enviarCorreo(); // Llamar a la función enviarCorreo
});
// Función para limpiar el canvas
document.querySelector('.clear-signature').addEventListener('click', function() {
    const canvas = document.querySelector('.signature-pad');
    const context = canvas.getContext('2d');
    context.clearRect(0, 0, canvas.width, canvas.height);
});

function validarRango(input) {
    // Convertir el valor a número
    let valor = parseFloat(input.value);
    
    // Verificar si el valor está fuera del rango [1, 5]
    if (valor < 0.5) {
        input.value = 0.5;
    } else if (valor > 5) {
        input.value = 5;
    }
}
function sumarValores() {
    const inputs = document.querySelectorAll('input[id^="cero"]');
    let suma = 0;
    inputs.forEach(input => {
        const valor = parseFloat(input.value);
        if (!isNaN(valor)) {
            suma += valor;
        }
    });
    document.getElementById('sumacero').value = parseFloat(suma.toFixed(2)).toString();
    sumarTotales();
}
function sumarValores1() {
    const inputs = document.querySelectorAll('input[id^="uno"]');
    let suma = 0;
    inputs.forEach(input => {
        const valor = parseFloat(input.value);
        if (!isNaN(valor)) {
            suma += valor;
        }
    });
    document.getElementById('sumauno').value = parseFloat(suma.toFixed(2)).toString();
    sumarTotales();
}
function sumarValores2() {
    const inputs = document.querySelectorAll('input[id^="dos"]');
    let suma = 0;
    inputs.forEach(input => {
        const valor = parseFloat(input.value);
        if (!isNaN(valor)) { 
            suma += valor;
        }
    });
    document.getElementById('sumados').value = parseFloat(suma.toFixed(2)).toString();
    sumarTotales();
}
function sumarValores3() {
    const inputs = document.querySelectorAll('input[id^="tres"]');
    let suma = 0;
    inputs.forEach(input => {
        const valor = parseFloat(input.value);
        if (!isNaN(valor)) { 
            suma += valor;
        }
    });
    document.getElementById('sumatres').value = parseFloat(suma.toFixed(2)).toString();
    sumarTotales();
}
function sumarValores3_1() {
    const inputs = document.querySelectorAll('input[id^="tres_uno"]');
    let suma = 0;
    inputs.forEach(input => {
        const valor = parseFloat(input.value);
        if (!isNaN(valor)) { 
            suma += valor;
        }
    });
    document.getElementById('sumatres_uno').value = parseFloat(suma.toFixed(2)).toString();
    sumarTotales();
}
function sumarValores4() {
    const inputs = document.querySelectorAll('input[id^="cuatro"]');
    let suma = 0;
    inputs.forEach(input => {
        const valor = parseFloat(input.value);
        if (!isNaN(valor)) { 
            suma += valor;
        }
    });
    document.getElementById('sumacuatro').value = parseFloat(suma.toFixed(2)).toString();
    sumarTotales();
}
function sumarValores5() {
    const inputs = document.querySelectorAll('input[id^="cinco"]');
    let suma = 0;
    inputs.forEach(input => {
        const valor = parseFloat(input.value);
        if (!isNaN(valor)) {
            suma += valor;
        }
    });
    document.getElementById('sumacinco').value = parseFloat(suma.toFixed(2)).toString();
    sumarTotales();
}
function sumarValores6() {
    const inputs = document.querySelectorAll('input[id^="seis"]');
    let suma = 0;
    inputs.forEach(input => {
        const valor = parseFloat(input.value);
        if (!isNaN(valor)) { 
            suma += valor;
        }
    });
    document.getElementById('sumaseis').value = parseFloat(suma.toFixed(2)).toString();
    sumarTotales();
}
function sumarValores7() {
    const inputs = document.querySelectorAll('input[id^="siete"]');
    let suma = 0;
    inputs.forEach(input => {
        const valor = parseFloat(input.value);
        if (!isNaN(valor)) { 
            suma += valor;
        }
    });
    document.getElementById('sumasiete').value = parseFloat(suma.toFixed(2)).toString();
    sumarTotales();
}
function sumarValores8() {
    const inputs = document.querySelectorAll('input[id^="ocho"]');
    let suma = 0;
    inputs.forEach(input => {
        const valor = parseFloat(input.value);
        if (!isNaN(valor)) { 
            suma += valor;
        }
    });
    document.getElementById('sumaocho').value = parseFloat(suma.toFixed(2)).toString();
    sumarTotales();
}
function sumarValores9() {
    const inputs = document.querySelectorAll('input[id^="nueve"]');
    let suma = 0;
    inputs.forEach(input => {
        const valor = parseFloat(input.value);
        if (!isNaN(valor)) { 
            suma += valor;
        }
    });
    document.getElementById('sumanueve').value = parseFloat(suma.toFixed(2)).toString();
    sumarTotales();
}
function sumarValores10() {
    const inputs = document.querySelectorAll('input[id^="diez"]');
    let suma = 0;
    inputs.forEach(input => {
        const valor = parseFloat(input.value);
        if (!isNaN(valor)) { 
            suma += valor;
        }
    });
    document.getElementById('sumadiez').value = parseFloat(suma.toFixed(2)).toString();
    sumarTotales();
}
function sumarValores11() {
    const inputs = document.querySelectorAll('input[id^="once"]');
    let suma = 0;
    inputs.forEach(input => {
        const valor = parseFloat(input.value);
        if (!isNaN(valor)) { 
            suma += valor;
        }
    });
    document.getElementById('sumaonce').value = parseFloat(suma.toFixed(2)).toString();
    sumarTotales();
}
function sumarValores12() {
    const inputs = document.querySelectorAll('input[id^="doce"]');
    let suma = 0;
    inputs.forEach(input => {
        const valor = parseFloat(input.value);
        if (!isNaN(valor)) { 
            suma += valor;
        }
    });
    document.getElementById('sumadoce').value = parseFloat(suma.toFixed(2)).toString();
    sumarTotales();
}
function sumarValores13() {
    const inputs = document.querySelectorAll('input[id^="trece"]');
    let suma = 0;
    inputs.forEach(input => {
        const valor = parseFloat(input.value);
        if (!isNaN(valor)) { 
            suma += valor;
        }
    });
    document.getElementById('sumatrece').value = parseFloat(suma.toFixed(2)).toString();
    sumarTotales();
}
function sumarTotales() {
    // Obtener los valores de sumacero y sumauno, y sumarlos
    const totalFila1 = parseFloat(document.getElementById("sumacero").value) || 0;
    const totalFila2 = parseFloat(document.getElementById("sumauno").value) || 0;
    const totalFila3 = parseFloat(document.getElementById("sumados").value) || 0;
    const totalFila4 = parseFloat(document.getElementById("sumatres").value) || 0;
    const totalFila4_1 = parseFloat(document.getElementById("sumatres_uno").value) || 0;
    const totalFila5 = parseFloat(document.getElementById("sumacuatro").value) || 0;
    const totalFila6 = parseFloat(document.getElementById("sumacinco").value) || 0;
    const totalFila7 = parseFloat(document.getElementById("sumaseis").value) || 0;
    const totalFila8 = parseFloat(document.getElementById("sumasiete").value) || 0;
    const totalFila9 = parseFloat(document.getElementById("sumaocho").value) || 0;
    const totalFila10 = parseFloat(document.getElementById("sumanueve").value) || 0;
    const totalFila11 = parseFloat(document.getElementById("sumadiez").value) || 0;
    const totalFila12 = parseFloat(document.getElementById("sumaonce").value) || 0;
    const totalFila13 = parseFloat(document.getElementById("sumadoce").value) || 0;
    const totalFila14 = parseFloat(document.getElementById("sumatrece").value) || 0;

    const sumaTotal = totalFila1 + totalFila2 + totalFila3 + totalFila4 + totalFila4_1 + totalFila5 + totalFila6 + totalFila7 + totalFila8 + totalFila9 + totalFila10 + totalFila11 + totalFila12 + totalFila13 + totalFila14;
    
    document.getElementById("sumaTotal").value = parseFloat(sumaTotal.toFixed(2)).toString();

    const promedio = sumaTotal / 30; 

    document.getElementById("promedio").value = parseFloat(promedio.toFixed(2)).toString();
}   