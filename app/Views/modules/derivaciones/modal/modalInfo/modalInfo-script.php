<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
<script>
    let selectedDerivacionId = null;
    const modalInfo = new bootstrap.Modal(document.getElementById("modalInfo"));

    // Cuando se hace clic en el botón key-outline
    $(document).on("click", "button[id^='key-']", async function () {
        selectedDerivacionId = this.id.replace("key-", "");
        try {
            const response = await fetch(`<?= base_url('api/derivaciones/obtener-por-id/') ?>${selectedDerivacionId}`);
            const data = await response.json();

            // Llenar los datos del modal
            document.getElementById("docente-nombre").textContent = data.docente_nombres_completos;
            document.getElementById("docente-dni").textContent = data.docente_dni;
            document.getElementById("docente-correo").textContent = data.usuario_correo;

            document.getElementById("alumno-nombre").textContent = data.alumno_nombres_completos;
            document.getElementById("alumno-dni").textContent = data.alumno_dni;
            document.getElementById("alumno-programa-estudio").textContent = data.alumno_programa_estudio;

            // Urgencia
            let urgenciaBadge = '';
            switch (data.urgencia?.toLowerCase()) {
                case 'alta':
                    urgenciaBadge = '<span class="badge bg-danger">Alta</span>';
                    break;
                case 'media':
                    urgenciaBadge = '<span class="badge bg-warning text-dark">Media</span>';
                    break;
                case 'baja':
                    urgenciaBadge = '<span class="badge bg-info text-dark">Baja</span>';
                    break;
                default:
                    urgenciaBadge = '<span class="badge bg-secondary">Sin urgencia</span>';
            }
            document.getElementById("urgencia").innerHTML = urgenciaBadge;

            // Badge de estado
            const estadoBadge = data.estado == 1
                ? '<span class="badge bg-success">Recibido</span>'
                : '<span class="badge bg-warning">En espera</span>';
            document.getElementById("estado").innerHTML = estadoBadge;

            document.getElementById("motivo").textContent = data.motivo;

            document.getElementById("created-at").textContent = data.created_at;

            modalInfo.show();
        } catch (error) {
            console.log("Error al obtener la derivación:", error);
        }
    });
</script>