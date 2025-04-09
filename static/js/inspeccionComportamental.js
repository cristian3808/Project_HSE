// Función para mover al siguiente input
function moveToNext(event, nextInput) {
    const input = event.target;
    if (input.value.length === input.maxLength && nextInput) {
        nextInput.focus();
    }
}

// Función para mover al input anterior al presionar Backspace
function moveToPrevious(event, currentInput) {
    if (event.key === "Backspace" && currentInput.value === "") {
        let previousInput = currentInput.previousElementSibling;
        while (previousInput && previousInput.value === "") {
            previousInput = previousInput.previousElementSibling;
        }
        if (previousInput) previousInput.focus();
    }
}

// Inicializar eventos de navegación entre inputs
document.querySelectorAll('input, textarea').forEach((field, index, fields) => {
    field.addEventListener('input', (event) => moveToNext(event, fields[index + 1]));
    field.addEventListener('keydown', (event) => moveToPrevious(event, field));
});

document.addEventListener("DOMContentLoaded", function () {
    // Inicializar SignaturePad en todos los canvas existentes
    document.querySelectorAll('.signature-pad').forEach(canvas => {
        new SignaturePad(canvas);
    });

    // Función para subir imagen de firma al canvas
    function uploadSignature(event) {
        const file = event.target.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = function (e) {
            const img = new Image();
            img.onload = function () {
                const td = event.target.closest('td');
                const canvas = td.querySelector('.signature-pad');
                const ctx = canvas.getContext("2d");

                const maxWidth = 150;
                const maxHeight = 50;

                canvas.width = maxWidth;
                canvas.height = maxHeight;
                canvas.style.border = "1px solid #ccc";
                canvas.style.background = "#fff";
                canvas.style.display = "block";

                ctx.clearRect(0, 0, maxWidth, maxHeight);

                const scale = Math.min(maxWidth / img.width, maxHeight / img.height);
                const newWidth = img.width * scale;
                const newHeight = img.height * scale;
                const xOffset = (maxWidth - newWidth) / 2;
                const yOffset = (maxHeight - newHeight) / 2;

                ctx.drawImage(img, xOffset, yOffset, newWidth, newHeight);

                td.style.height = `${maxHeight + 30}px`;
                td.style.overflow = "hidden";

                const buttonsContainer = td.querySelector(".buttons-container");
                if (buttonsContainer) {
                    buttonsContainer.style.display = "flex";
                    buttonsContainer.style.justifyContent = "center";
                    buttonsContainer.style.marginTop = "5px";
                }
            };
            img.src = e.target.result;
        };
        reader.readAsDataURL(file);
    }

    // Función para limpiar la firma
    function clearSignature(event) {
        const canvas = event.target.closest('td').querySelector('.signature-pad');
        const signaturePad = new SignaturePad(canvas);
        signaturePad.clear();
    }

    // Asignar evento a los botones existentes para limpiar firma
    document.querySelectorAll('.clear-signature').forEach(button => {
        button.addEventListener('click', clearSignature);
    });

    // Evento para agregar una nueva fila
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
                <textarea rows="2" cols="15" wrap="hard"></textarea>
            </td>
            <td class="border border-gray-300 p-1 flex flex-col items-center justify-center">
                <canvas class="signature-pad border border-gray-400" width="200" height="40"></canvas>
                <div class="buttons-container flex space-x-2 mt-2">
                    <button type="button" class="bg-red-500 text-white px-2 py-1 rounded clear-signature flex items-center h-5">
                        <svg class="w-4 h-4 mr-2 text-red-200" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path d="M3 6h18v2H3V6zm3 3h12v13H6V9zm4-5h4v2h-4V4zM5 6h14v16a2 2 0 01-2 2H7a2 2 0 01-2-2V6zm6 5v3h3V11h-3z"/>
                        </svg>
                        Limpiar
                    </button>
                    <label class="bg-blue-500 text-white px-2 py-1 rounded cursor-pointer flex items-center h-5 hide-on-pdf">
                        <input type="file" class="upload-signature hidden" accept="image/*">
                        <svg class="w-4 h-4 mr-2 text-blue-200" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path d="M12 2L8.59 5.41 13.17 10H4v2h9.17l-4.58 4.59L12 18l8-8-8-8zm0 4v3h-1v4h1v3h4v-3h1V9h-1V6h-4z"/>
                        </svg>
                        Subir firma
                    </label>
                </div>
            </td>
            <td class="border border-gray-400 p-2 w-24 text-xs">
                ${[1, 2, 3, 4, 5].map(i => `
                    <label><strong>${i}.</strong> SI <input type="radio" name="comportamiento${i}-${tableBody.rows.length + 1}"> NO <input type="radio" name="comportamiento${i}-${tableBody.rows.length + 1}"></label><br>
                `).join('')}
            </td>
            <td class="border border-gray-400 p-2 w-24"><textarea class="w-full border-none p-1 text-xs" rows="2"></textarea></td>
            <td class="border border-gray-400 p-2 w-24"><textarea class="w-full border-none p-1 text-xs" rows="2"></textarea></td>
            <td class="border border-gray-400 p-2 w-24"><textarea class="w-full border-none p-1 text-xs" rows="2"></textarea></td>
            <td class="border border-gray-400 p-2 w-24"><input type="date" class="w-full border-none p-1 text-xs transparent-input"></td>
            <td class="border border-gray-400 p-2 w-16 text-center">
                <button class="bg-red-500 text-white px-2 py-1 rounded remove-row">X</button>
            </td>
        `;

        tableBody.appendChild(newRow);

        const canvas = newRow.querySelector('.signature-pad');
        const signaturePad = new SignaturePad(canvas);

        newRow.querySelector('.clear-signature').addEventListener('click', () => signaturePad.clear());
        newRow.querySelector('.upload-signature').addEventListener('change', uploadSignature);
        newRow.querySelector('.remove-row').addEventListener('click', () => newRow.remove());
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

downloadButton.addEventListener('click', async function (event) {
    const isFormValid = showAlertIfMissingFields(event);
    if (!isFormValid) {
        event.stopImmediatePropagation();
        return;
    }

    this.disabled = true;

    const formContent = document.getElementById('form-content');
    const clearButtons = formContent.querySelectorAll('.clear-signature');
    const actionColumns = formContent.querySelectorAll('.hide-on-pdf');
    const deleteColumn = document.querySelectorAll('td:last-child, th:last-child');

    // Ocultar botones y columnas no deseadas
    clearButtons.forEach(btn => btn.style.display = 'none');
    actionColumns.forEach(col => col.style.display = 'none');
    deleteColumn.forEach(col => col.style.display = 'none');

    // Reemplazar textarea por contenido plano
    document.querySelectorAll("textarea").forEach(textarea => {
        const div = document.createElement("div");
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

    try {
        const canvas = await html2canvas(formContent, {
            backgroundColor: null,
            scale: 2,
            width: formContent.scrollWidth,
            height: formContent.scrollHeight,
            useCORS: true
        });

        const { jsPDF } = window.jspdf;
        const imgData = canvas.toDataURL('image/png');
        const pdf = new jsPDF('portrait', 'mm', 'a4');
        const imgProps = pdf.getImageProperties(imgData);
        const pdfWidth = pdf.internal.pageSize.getWidth();
        const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;

        pdf.addImage(imgData, 'PNG', 0, 0, pdfWidth, pdfHeight);

        // Descargar el PDF
        pdf.save('inspeccion_comportamental.pdf');

        // Codificar en base64 y enviar al servidor
        const pdfBase64 = btoa(pdf.output());

        const response = await fetch('inspeccionComportamental.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: `btnEnviarCorreo=true&pdfData=${encodeURIComponent(pdfBase64)}`
        });

        const result = await response.text();
        console.log("Correo enviado correctamente:", result);

        // Mostrar notificación
        const toast = document.getElementById('toast-simple');
        if (toast) {
            toast.classList.remove('hidden');
            $(toast).fadeIn();
        }

        // Redireccionar después de 1 segundo
        setTimeout(() => {
            window.location.href = 'index.php';
        }, 1000);

    } catch (error) {
        console.error("Error al generar o enviar el PDF:", error);
        alert("Ocurrió un error al generar o enviar el PDF.");
    } finally {
        // Restaurar interfaz
        clearButtons.forEach(btn => btn.style.display = 'block');
        actionColumns.forEach(col => col.style.display = 'table-cell');
        deleteColumn.forEach(col => col.style.display = 'table-cell');
        this.disabled = false;
    }
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