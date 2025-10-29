<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>

<script>
    let selectedDerivacionId = null;
    const modalInfo = new bootstrap.Modal(document.getElementById("modalInfo"));

    // Al hacer clic en el botón con id key-#
    $(document).on("click", "button[id^='key-']", async function () {
        selectedDerivacionId = this.id.replace("key-", "");

        try {
            const response = await fetch(`<?= base_url('api/derivaciones/obtener-por-id/') ?>${selectedDerivacionId}`);
            const data = await response.json();

            const derivacion = data.derivacion || {};
            const cita = data.cita || null;

            // --- DOCENTE ---
            document.getElementById("docente-nombre").textContent = derivacion.docente_nombres_completos || '---------';
            document.getElementById("docente-dni").textContent = derivacion.docente_dni || '---------';
            document.getElementById("docente-correo").textContent = derivacion.usuario_correo || '---------';

            // --- ALUMNO ---
            document.getElementById("alumno-nombre").textContent = derivacion.alumno_nombres_completos || '---------';
            document.getElementById("alumno-dni").textContent = derivacion.alumno_dni || '---------';
            document.getElementById("alumno-programa-estudio").textContent = derivacion.alumno_programa_estudio || '---------';

            // --- URGENCIA ---
            let urgenciaBadge = '';
            switch ((derivacion.urgencia || '').toLowerCase()) {
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

            // --- ESTADO ---
            const estadoBadge = derivacion.estado == 1
                ? '<span class="badge bg-success">Recibido</span>'
                : '<span class="badge bg-warning">En espera</span>';
            document.getElementById("estado").innerHTML = estadoBadge;

            // --- MOTIVO ---
            document.getElementById("motivo").textContent = derivacion.motivo || '---------';

            // --- FECHA DE CREACIÓN ---
            if (derivacion.created_at) {
                const utcDate = new Date(derivacion.created_at.replace(' ', 'T') + 'Z');
                const localDate = new Date(derivacion.created_at.replace(' ', 'T') + 'Z');

                const formatted = localDate.toLocaleString('es-PE', {
                    year: 'numeric',
                    month: '2-digit',
                    day: '2-digit',
                    hour: '2-digit',
                    minute: '2-digit',
                    hour12: false
                });

                document.getElementById("created-at").textContent = formatted;
            } else {
                document.getElementById("created-at").textContent = '---------';
            }

            // --- INFO DE CITA (solo si existe) ---
            const existingCitaBlock = document.getElementById("cita-info-block");
            if (existingCitaBlock) existingCitaBlock.remove();

            if (cita) {
                const citaBlock = document.createElement("div");
                citaBlock.id = "cita-info-block";
                citaBlock.className = "section cita-section";
                citaBlock.innerHTML = `
                    <div class="cita-container">
                        <div class="cita-header">
                            <i class="fa fa-calendar-check"></i>
                            <strong>CITA ASIGNADA</strong>
                        </div>
                        <div class="cita-details">
                            <div class="cita-item">
                                <i class="fa fa-calendar"></i>
                                <div class="cita-item-content">
                                    <span class="cita-label">Fecha</span>
                                    <span class="cita-value">${cita.atencion_fech || '---------'}</span>
                                </div>
                            </div>
                            <div class="cita-item">
                                <i class="fa fa-clock"></i>
                                <div class="cita-item-content">
                                    <span class="cita-label">Hora inicio</span>
                                    <span class="cita-value">${cita.hora_inicio?.substring(0, 5) || '---------'}</span>
                                </div>
                            </div>
                            <div class="cita-item">
                                <i class="fa fa-clock"></i>
                                <div class="cita-item-content">
                                    <span class="cita-label">Hora fin</span>
                                    <span class="cita-value">${cita.hora_fin?.substring(0, 5) || '---------'}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                document.querySelector(".modal-body-custom").appendChild(citaBlock);
            }

            modalInfo.show();

        } catch (error) {
            console.error("Error al obtener la derivación:", error);
        }
    });
</script>