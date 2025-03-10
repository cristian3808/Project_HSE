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
document.querySelectorAll('input, textarea').forEach((field, index, fields) => {
    field.addEventListener('input', (event) => moveToNext(event, fields[index + 1]));
});

document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll('.signature-pad').forEach(canvas => {
        new SignaturePad(canvas);
    });

     function uploadSignature(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                const img = new Image();
                img.onload = function () {
                    const td = event.target.closest('td');
                    const canvas = td.querySelector('.signature-pad');
                    const ctx = canvas.getContext("2d");

                    // Definir dimensiones fijas del canvas
                    const maxWidth = 150;
                    const maxHeight = 50;

                    canvas.width = maxWidth;
                    canvas.height = maxHeight;

                    // Limpiar el canvas antes de dibujar
                    ctx.clearRect(0, 0, maxWidth, maxHeight);

                    // Calcular escala proporcional
                    let scale = Math.min(maxWidth / img.width, maxHeight / img.height);
                    let newWidth = img.width * scale;
                    let newHeight = img.height * scale;

                    // Centrar la imagen en el canvas
                    let xOffset = (maxWidth - newWidth) / 2;
                    let yOffset = (maxHeight - newHeight) / 2;

                    ctx.drawImage(img, xOffset, yOffset, newWidth, newHeight);
                };
                img.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    }

    function clearSignature(event) {
        const canvas = event.target.closest('td').querySelector('.signature-pad');
        const signaturePad = new SignaturePad(canvas);
        signaturePad.clear();
    }

    document.querySelectorAll('.clear-signature').forEach(button => {
        button.addEventListener('click', clearSignature);
    });

    document.getElementById('add-row').addEventListener('click', function () {
        const tableBody = document.getElementById('table-body');

        if (tableBody.rows.length >= 17) {
            alert("Solo puedes agregar un máximo de 17 registros.");
            return;
        }

        const newRow = document.createElement('tr');
        newRow.innerHTML = `
            <td class="border border-gray-400 p-2 w-24">
                <input type="date" class="w-full border-none p-1 text-xs transparent-input">
            </td>
            <td class="border border-gray-400 p-2 w-24">
                <input type="time" class="w-full border-none p-1 text-xs transparent-input">
            </td>
            <td class="border border-gray-400 p-2 w-24">
                <textarea id="nombre" rows="2" cols="15" wrap="hard"></textarea>
            </td>
           <td class="border border-gray-400 p-2 w-24 text-center">
                <div class="flex flex-col items-center">
                    <canvas class="border border-gray-400 signature-pad w-full h-12"></canvas>
                    <div class="mt-2 flex space-x-2 justify-center hide-on-pdf">
                        <button class="bg-red-500 text-white px-2 py-1 rounded text-xs clear-signature">Limpiar</button>
                        <label class="bg-blue-500 text-white px-2 py-1 rounded cursor-pointer text-xs">
                            <input type="file" class="hidden upload-signature" accept="image/*">
                            Subir
                        </label>
                    </div>
                </div>
            </td>
            <td class="border border-gray-400 p-2 w-24 text-xs">
                <label><strong>1.</strong> SI <input type="radio" name="comportamiento1-${tableBody.rows.length + 1}"> NO <input type="radio" name="comportamiento1-${tableBody.rows.length + 1}"></label><br>
                <label><strong>2.</strong> SI <input type="radio" name="comportamiento2-${tableBody.rows.length + 1}"> NO <input type="radio" name="comportamiento2-${tableBody.rows.length + 1}"></label><br>
                <label><strong>3.</strong> SI <input type="radio" name="comportamiento3-${tableBody.rows.length + 1}"> NO <input type="radio" name="comportamiento3-${tableBody.rows.length + 1}"></label><br>
                <label><strong>4.</strong> SI <input type="radio" name="comportamiento4-${tableBody.rows.length + 1}"> NO <input type="radio" name="comportamiento4-${tableBody.rows.length + 1}"></label><br>
                <label><strong>5.</strong> SI <input type="radio" name="comportamiento5-${tableBody.rows.length + 1}"> NO <input type="radio" name="comportamiento5-${tableBody.rows.length + 1}"></label>
            </td>
            <td class="border border-gray-400 p-2 w-24">
                <textarea class="w-full border-none p-1 text-xs" rows="2"></textarea>
            </td>
            <td class="border border-gray-400 p-2 w-24">
                <textarea class="w-full border-none p-1 text-xs" rows="2"></textarea>
            </td>
            <td class="border border-gray-400 p-2 w-24">
                <textarea class="w-full border-none p-1 text-xs" rows="2"></textarea>
            </td>
            <td class="border border-gray-400 p-2 w-24">
                <input type="date" class="w-full border-none p-1 text-xs transparent-input">
            </td>
            <td class="border border-gray-400 p-2 w-16 text-center">
                <button class="bg-red-500 text-white px-2 py-1 rounded remove-row">X</button>
            </td>
        `;


        // Agregar la nueva fila a la tabla
        tableBody.appendChild(newRow);

        // Inicializar SignaturePad en el nuevo canvas
        const newCanvas = newRow.querySelector('.signature-pad');
        const newSignaturePad = new SignaturePad(newCanvas);

        // Asignar eventos a los botones de limpiar firma
        newRow.querySelector('.clear-signature').addEventListener('click', function () {
            newSignaturePad.clear();
        });

        // Asignar evento a la carga de imágenes
        newRow.querySelector('.upload-signature').addEventListener('change', uploadSignature);

        // Asignar evento para eliminar la fila
        newRow.querySelector('.remove-row').addEventListener('click', function () {
            newRow.remove();
        });
    });
});

function clearSignature(event) {
    const canvas = event.target.closest('td').querySelector('.signature-pad');
    const signaturePad = new SignaturePad(canvas);
    signaturePad.clear();
}

document.querySelectorAll('.clear-signature').forEach(button => {
    button.addEventListener('click', clearSignature);
});

document.querySelectorAll('.signature-pad').forEach(canvas => {
    new SignaturePad(canvas);
});

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
    console.log("Botón de descarga clickeado");
    const { jsPDF } = window.jspdf;
    const formContent = document.getElementById('form-content');
    const clearButtons = formContent.querySelectorAll('.clear-signature');
    const actionColumns = formContent.querySelectorAll('.hide-on-pdf');
    const deleteColumn = document.querySelectorAll('td:last-child, th:last-child');

    this.disabled = true;
    
    clearButtons.forEach(button => button.style.display = 'none');
    actionColumns.forEach(column => column.style.display = 'none');
    deleteColumn.forEach(column => column.style.display = 'none');

    document.body.style.width = `${formContent.scrollWidth}px`;
    document.body.style.height = `${formContent.scrollHeight}px`;
    document.querySelectorAll("textarea").forEach(textarea => {
        let div = document.createElement("div");
        div.textContent = textarea.value;
        div.style.cssText = `
            white-space: pre-wrap; 
            word-wrap: break-word; 
            width: ${textarea.offsetWidth}px; 
            height: ${textarea.offsetHeight}px;
            font-family: inherit; 
            font-size: inherit;
        `;
        textarea.parentNode.replaceChild(div, textarea);
    });
    
    console.log("Capturando contenido con html2canvas...");
    html2canvas(formContent, {
        backgroundColor: null,
        scale: 2,
        width: formContent.scrollWidth,
        height: formContent.scrollHeight,
        useCORS: true
    }).then(canvas => {
        console.log("Canvas convertido a imagen");

        document.body.style.width = '';
        document.body.style.height = '';
    
        const imgData = canvas.toDataURL('image/png');
        const pdf = new jsPDF('portrait', 'mm', 'a4');
        const imgProps = pdf.getImageProperties(imgData);
        const pdfWidth = pdf.internal.pageSize.getWidth();
        const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;
        pdf.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);
        
        console.log("PDF generado correctamente");
        pdf.save('inspeccion_comportamental.pdf');
    
        clearButtons.forEach(button => button.style.display = 'block');
        actionColumns.forEach(column => column.style.display = 'table-cell');
        deleteColumn.forEach(column => column.style.display = 'table-cell');

        // Convertir PDF a base64 y enviarlo al servidor
        const pdfData = pdf.output('datauristring').split(',')[1];

        if (pdfData) {
            console.log("Enviando PDF al servidor...");
            fetch('inspeccionComportamental.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `btnEnviarCorreo=true&pdfData=${encodeURIComponent(pdfData)}`
            })
            .then(response => response.text())
            .then(result => {
                console.log("Respuesta del servidor:", result);
                // Redirigir solo después de recibir la respuesta del servidor
                window.location.href = 'index.php';
            })
            .catch(error => {
                console.error('Error en la petición:', error);
                // Redirigir también en caso de error, si lo deseas
                window.location.href = 'index.php';
            });
        }
        
        downloadButton.disabled = false;
    });
});

function enviarCorreo() {
    console.log("Enviando correo...");
    $.ajax({
        url: 'inspeccionComportamental.php',
        method: 'POST',
        data: { btnEnviarCorreo: true },
        success: function(response) {
            console.log("Correo enviado, respuesta del servidor:", response);
            $('#toast-simple').removeClass('hidden').fadeIn();
            setTimeout(function() {
                window.location.href = 'index.php';
            }, 500);
        },
        error: function() {
            console.error("Hubo un error al enviar el correo.");
            alert("Hubo un error al enviar el correo.");
        }
    });
}

$('#frmEnviarCorreo').on('submit', function(e) {
    e.preventDefault();
    enviarCorreo();
});