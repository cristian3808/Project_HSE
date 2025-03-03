function uploadSignature(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            const img = new Image();
            img.onload = function () {
                const td = event.target.closest('td'); // Celda contenedora
                const canvas = td.querySelector('.signature-pad');
                const ctx = canvas.getContext("2d");

                // 📌 Definir un tamaño fijo para el canvas
                const maxWidth = 150;  // Ancho fijo del canvas
                const maxHeight = 50;  // Altura fija del canvas

                // 📌 Aplicar estilos al canvas para evitar que se expanda
                canvas.width = maxWidth;
                canvas.height = maxHeight;
                canvas.style.border = "1px solid #ccc";  // Borde para mejor visualización
                canvas.style.background = "#fff";        // Fondo blanco para más claridad
                canvas.style.display = "block";          // Evita desbordes inesperados

                // 📌 Limpiar el canvas antes de dibujar
                ctx.clearRect(0, 0, maxWidth, maxHeight);

                // 📌 Obtener tamaño original de la imagen
                let imgWidth = img.width;
                let imgHeight = img.height;

                // 📌 Calcular la escala manteniendo la proporción
                let scale = Math.min(maxWidth / imgWidth, maxHeight / imgHeight);
                let newWidth = imgWidth * scale;
                let newHeight = imgHeight * scale;

                // 📌 Centrar la imagen dentro del canvas
                let xOffset = (maxWidth - newWidth) / 2;
                let yOffset = (maxHeight - newHeight) / 2;

                ctx.drawImage(img, xOffset, yOffset, newWidth, newHeight);

                // 📌 Evitar que la celda crezca descontroladamente
                td.style.height = `${maxHeight + 30}px`; // Ajustar margen si es necesario
                td.style.overflow = "hidden"; // Evitar desbordamiento

                // 📌 Asegurar que los botones no se desplacen
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
}

// Función para limpiar la firma en el canvas
function clearSignature(event) {
    const canvas = event.target.closest('td').querySelector('.signature-pad');
    const signaturePad = new SignaturePad(canvas);
    signaturePad.clear();
}
// Agregar una nueva fila a la tabla
document.getElementById('add-row').addEventListener('click', function() {
    const tableBody = document.getElementById('table-body');
    
    if (tableBody.rows.length >= 25) {
        const toast = document.createElement('div');
        toast.classList.add(
            'fixed', 'top-20', 'left-1/2', '-translate-x-1/2', '-translate-y-1/2', 
            'bg-orange-300', 'text-black', 'px-6', 'py-3', 'rounded-lg', 
            'shadow-lg', 'transition-all', 'duration-300', 'ease-in-out', 
            'text-center'
        );
        toast.textContent = 'Solo puedes agregar un máximo de 25 registros, envía y crea otro archivo para poder seguir registrando. Gracias.';
        
        document.body.appendChild(toast);
    
        setTimeout(() => {
            toast.classList.add('opacity-0');
            setTimeout(() => toast.remove(), 300);
        }, 3000); // El toast desaparecerá después de 3 segundos
    
        return; // Detener la ejecución si ya hay 20 filas
    }
       
    const newRow = document.createElement('tr');
    newRow.innerHTML = `
        <td class="border border-gray-400 p-2"><input type="text" class="w-full border-none p-1 text-base" minlength="6" maxlength="10" placeholder="-"></td>
                    <td class="border border-gray-400 p-2"><input type="text" class="w-full border-none p-1 text-base" minlength="4" maxlength="30" placeholder="-"></td>
                    <td class="border border-gray-400 p-2"><input type="text" class="w-full border-none p-1 text-base" minlength="4" maxlength="30" placeholder="-"></td>
                    <td class="border border-gray-400 p-2"><input type="text" class="w-full border-none p-1 text-base" minlength="4" maxlength="30" placeholder="-"></td>
                    <td class="border border-gray-300 p-1 flex flex-col items-center justify-center">
                        <canvas class="signature-pad border border-gray-400" width="200" height="40"></canvas>
                        <div class="flex space-x-2 mt-2">
                        <button type="button" class="bg-red-500 text-white px-2 py-1 rounded clear-signature flex items-center h-5">
                            <svg class="w-4 h-4 mr-2 text-red-200" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                <path d="M3 6h18v2H3V6zm3 3h12v13H6V9zm4-5h4v2h-4V4zM5 6h14v16a2 2 0 01-2 2H7a2 2 0 01-2-2V6zm6 5v3h3V11h-3z"/>
                            </svg>
                            Limpiar
                        </button>
                                <label class="bg-blue-500 text-white px-2 py-1 rounded cursor-pointer flex items-center h-5 hide-on-pdf">
                                <input type="file" class="hidden" accept="image/*" id="upload-signature" onchange="uploadSignature(event)">
                                <svg class="w-4 h-4 mr-2 text-blue-200" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <path d="M12 2L8.59 5.41 13.17 10H4v2h9.17l-4.58 4.59L12 18l8-8-8-8zm0 4v3h-1v4h1v3h4v-3h1V9h-1V6h-4z"/>
                                </svg>
                                Subir firma
                            </label>
                        </div>
                    </td>
                    <td class="border border-gray-400 p-2 text-center">
                        <button class="bg-red-500 text-white px-2 py-1 rounded remove-row">X</button>
                    </td>
    `;
    newRow.querySelector('.remove-row').addEventListener('click', function() {
        newRow.remove();
    });
    tableBody.appendChild(newRow);
    
    // Inicializar el signaturePad en el nuevo canvas
    const newSignaturePad = new SignaturePad(newRow.querySelector('.signature-pad'));
    
    // Agregar funcionalidad para limpiar la firma
    newRow.querySelector('.clear-signature').addEventListener('click', clearSignature);
});


// Delegar el evento de limpieza para filas existentes
document.querySelectorAll('.clear-signature').forEach(button => {
    button.addEventListener('click', clearSignature);
});

// Verificar campos obligatorios antes de descargar PDF
const temaInput = document.getElementById('tema');
const exponenteInput = document.getElementById('exponente');
const fechaInput = document.getElementById('fecha');
const downloadButton = document.getElementById('download-pdf');

function showAlertIfMissingFields(event) {
    let missingFields = [];
    if (!temaInput.value) missingFields.push("tema");
    if (!exponenteInput.value) missingFields.push("exponente");
    if (!fechaInput.value) missingFields.push("fecha");
    if (missingFields.length > 0) {
        event.preventDefault();
        alert(`Te falta : ${missingFields.join(', ')} para poder descargar el PDF.`);
        return false;
    }
    return true;
}

downloadButton.addEventListener('click', function(event) {
    const isFormValid = showAlertIfMissingFields(event);
    if (!isFormValid) {
        event.stopImmediatePropagation();
    }
});
async function enviarCorreoConPDF(pdf) {
    const pdfData = pdf.output('datauristring').split(',')[1];

    if (pdfData) {
        try {
            await fetch('listadoAsistencia.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `btnEnviarCorreo=true&pdfData=${encodeURIComponent(pdfData)}`
            });
        } catch (error) {
            console.error('Error al enviar el correo:', error);
        }
    }
}

downloadButton.addEventListener('click', async function () {
    const { jsPDF } = window.jspdf;
    const formContent = document.getElementById('form-content');

    // Deshabilitar el botón para evitar múltiples clics
    this.disabled = true;

    // **Ocultar elementos antes de capturar**
    const elementsToHide = document.querySelectorAll(".clear-signature, .hide-on-pdf, td:last-child, th:last-child");
    elementsToHide.forEach(el => el.style.display = "none");

    // **Transformar inputs en texto antes de capturar**
    const inputs = document.querySelectorAll("input");
    inputs.forEach(input => {
        input.setAttribute("data-original-value", input.value);
        input.insertAdjacentHTML('afterend', `<span class="text-sm p-1 temp-text">${input.value || "-"} </span>`);
        input.style.display = "none";
    });

    // **Reemplazar firmas en canvas por imágenes más pequeñas**
    const canvases = document.querySelectorAll(".signature-pad");
    canvases.forEach(canvas => {
        if (canvas.toDataURL) {
            const imgURL = canvas.toDataURL("image/png");

            // **Crear imagen**
            const img = document.createElement('img');
            img.src = imgURL;
            img.classList.add("signature-img");
            img.style.width = canvas.width + "px";  // Mantener mismo tamaño que el canvas
            img.style.height = canvas.height + "px";

            canvas.insertAdjacentElement('afterend', img);
            canvas.style.display = "none";
        }
    });

    try {
        // **Capturar como imagen con más calidad**
        const canvas = await html2canvas(formContent, {
            backgroundColor: "#ffffff",
            scale: 3,  // Aumentamos la escala para mejor calidad
            useCORS: true,
            scrollY: 0
        });

        const imgData = canvas.toDataURL("image/jpeg", 0.7); // **Reducir tamaño con compresión**

        // **Crear el PDF en tamaño A1**
        const pdf = new jsPDF('portrait', 'mm', 'a1');

        // **Obtener tamaño de la página**
        const pageWidth = pdf.internal.pageSize.getWidth();
        const margin = 20; // 20mm de margen en todos los lados
        const imgWidth = pageWidth - (margin * 2);
        const imgHeight = (canvas.height * imgWidth) / canvas.width;

        pdf.addImage(imgData, 'JPEG', margin, margin, imgWidth, imgHeight);

        // **Iniciar el envío del correo en segundo plano**
        enviarCorreoConPDF(pdf);

        // **Permitir la descarga sin esperar el envío**
        pdf.save('listado_asistencia.pdf');

    } catch (error) {
        console.error("Error al generar el PDF:", error);
        alert("Hubo un problema al generar el PDF. Inténtalo de nuevo.");
    } finally {
        // **Restaurar inputs**
        inputs.forEach(input => input.style.display = "");
        document.querySelectorAll(".temp-text").forEach(span => span.remove());

        // **Restaurar firmas en canvas**
        canvases.forEach(canvas => canvas.style.display = "");
        document.querySelectorAll(".signature-img").forEach(img => img.remove());

        // **Restaurar elementos ocultos**
        elementsToHide.forEach(el => el.style.display = "");

        // **Habilitar el botón nuevamente**
        this.disabled = false;

        // **Redirigir después de un breve retraso**
        setTimeout(() => {
            window.location.href = 'index.php';
        }, 300);
    }
});


document.querySelectorAll('.signature-pad').forEach(canvas => {
    // **Reducimos un poco más**
    canvas.width = 300;  // Antes 350
    canvas.height = 120; // Antes 140
});
async function enviarCorreo() {
    try {
        await fetch('listadoAsistencia.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'btnEnviarCorreo=true'
        });

        $('#toast-simple').removeClass('hidden').fadeIn();

        setTimeout(() => {
            window.location.href = 'index.php';
        }, 500);
    } catch (error) {
        alert("Hubo un error al enviar el correo.");
    }
}

// Asignar el evento al formulario para llamar la función enviarCorreo
$('#frmEnviarCorreo').on('submit', function(e) {
    e.preventDefault();
    enviarCorreo();
});
