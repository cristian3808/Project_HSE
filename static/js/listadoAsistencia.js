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
        <td class="border border-gray-400 p-2"><input type="text"  class="w-full border-none p-1 text-base" minlength="4" maxlength="30" placeholder="-"></td>
        <td class="border border-gray-400 p-2"><input type="text"  class="w-full border-none p-1 text-base" minlength="4" maxlength="30" placeholder="-"></td>
        <td class="border border-gray-400 p-2"><input type="text"  class="w-full border-none p-1 text-base" minlength="4" maxlength="30" placeholder="-"></td>
        <td class="border border-gray-400 p-2"><input type="text"  class="w-full border-none p-1 text-base" minlength="4" maxlength="30" placeholder="-"></td>    
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
            <button class="bg-red-500 text-white px-2 py-1 rounded remove-row flex items-center justify-center mx-auto">
                X
            </button>
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
});downloadButton.addEventListener('click', function () {
    const { jsPDF } = window.jspdf;
    const formContent = document.getElementById('form-content');

    // **Ocultar elementos antes de capturar**
    const elementsToHide = document.querySelectorAll(".clear-signature, .hide-on-pdf, td:last-child, th:last-child");
    elementsToHide.forEach(el => el.style.display = "none");

    // **Transformar inputs en texto antes de capturar**
    const inputs = document.querySelectorAll("input");
    inputs.forEach(input => {
        input.setAttribute("data-original-value", input.value);
        input.insertAdjacentHTML('afterend', `<span class="text-sm p-1 temp-text">${input.value || "-"}</span>`);
        input.style.display = "none";
    });

    // **Reemplazar firmas en canvas por imágenes**
    const canvases = document.querySelectorAll(".signature-pad");
    canvases.forEach(canvas => {
        if (canvas.toDataURL) {
            const imgURL = canvas.toDataURL("image/png");
            canvas.setAttribute("data-original-canvas", canvas.outerHTML);
            canvas.insertAdjacentHTML('afterend', `<img src="${imgURL}" class="signature-img" style="max-width:200px; max-height:40px;">`);
            canvas.style.display = "none";
        }
    });

    // **Capturar como imagen**
    html2canvas(formContent, {
        backgroundColor: "#ffffff",
        scale: 2,
        useCORS: true
    }).then(canvas => {
        const imgData = canvas.toDataURL("image/png");
        const pdf = new jsPDF('portrait', 'mm', 'a4');
        const imgWidth = 190;
        const imgHeight = (canvas.height * imgWidth) / canvas.width;

        pdf.addImage(imgData, 'PNG', 10, 10, imgWidth, imgHeight);
        pdf.save('listado_asistencia.pdf');

        // **Restaurar inputs**
        inputs.forEach(input => {
            input.style.display = "";
        });
        document.querySelectorAll(".temp-text").forEach(span => span.remove());

        // **Restaurar firmas en canvas**
        canvases.forEach(canvas => {
            canvas.style.display = "";
        });
        document.querySelectorAll(".signature-img").forEach(img => img.remove());

        // **Restaurar elementos ocultos**
        elementsToHide.forEach(el => el.style.display = "");
    });
});

// Inicializar signaturePads al cargar la página
document.querySelectorAll('.signature-pad').forEach(canvas => {
    new SignaturePad(canvas);
});
