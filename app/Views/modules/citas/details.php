<?= $this->extend('layouts/master') ?>
<?= $this->section('content') ?>

<?= $this->include('messages/msg-success') ?>
<?= $this->include('messages/msg-error') ?>

<div class="form-container py-3">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-xl-11">
        <div class="form-card">
          <!-- Header -->
          <?= view('shared/forms/formHeader', [
              'title' => 'Información de la Consulta',
              'backUrl' => base_url('citas')
          ]) ?>

          <form action="<?= base_url('api/citas/update/' . $cita['id']) ?>" method="POST" data-confirm
              data-title="Editar Consulta" data-text="¿Desea actualizar esta consulta?" data-icon="question">
            <?= csrf_field() ?>

            <!-- Información General -->
            <div class="card border-0 shadow-sm mb-4">
              <div class="card-header bg-light border-bottom">
                <h6 class="mb-0 fw-semibold text-primary">
                  <i class="bi bi-info-circle me-2"></i>Información General
                </h6>
              </div>
              <div class="card-body">
                <div class="row g-4">
                  <div class="col-md-6">
                    <div class="info-item">
                      <label class="text-muted small fw-semibold mb-2 d-block">
                        <i class="bi bi-arrow-right-circle me-1"></i>Tipo de derivación
                      </label>
                      <span class="badge bg-primary-subtle text-primary fs-6 px-3 py-2">
                        <?= esc($cita['tipo_derivacion']) ?>
                      </span>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="info-item">
                      <label class="text-muted small fw-semibold mb-2 d-block">
                        <i class="bi bi-person-badge me-1"></i>Psicólogo asignado
                      </label>
                      <span class="badge bg-success-subtle text-success fs-6 px-3 py-2">
                        <?= esc($usuario['nombres'] . ' ' . $usuario['apellidos']) ?>
                      </span>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Información del Alumno -->
            <?php if ($cita['tipo_derivacion'] === 'AUTONOMO' || $cita['tipo_derivacion'] === 'FAMILIAR'): ?>
              <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-light border-bottom">
                  <h6 class="mb-0 fw-semibold text-primary">
                    <i class="bi bi-person me-2"></i>Datos del Alumno
                  </h6>
                </div>
                <div class="card-body">
                  <div id="alumnoInfo"
                    data-nombres="<?= esc($alumno['nombres']) ?>"
                    data-apellidos="<?= esc($alumno['apellidos']) ?>"
                    data-dni="<?= esc($alumno['dni']) ?>"
                    data-programa="<?= esc($alumno['programa_estudio']) ?>"
                    data-turno="<?= esc($alumno['turno']) ?>"
                    data-ciclo="<?= esc($alumno['ciclo']) ?>">
                  </div>
                </div>
              </div>
            <?php endif; ?>

            <!-- Derivación Docente -->
            <?php if ($cita['tipo_derivacion'] === 'DOCENTE'): ?>
              <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-light border-bottom">
                  <h6 class="mb-0 fw-semibold text-primary">
                    <i class="bi bi-file-earmark-text me-2"></i>Detalles de Derivación Docente
                  </h6>
                </div>
                <div class="card-body">
                  <div class="row g-3">
                    <div class="col-md-4">
                      <div class="detail-item">
                        <span class="detail-label">Alumno</span>
                        <p class="detail-value"><?= esc($derivacion['alumno_nombres_completos']) ?></p>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="detail-item">
                        <span class="detail-label">Docente</span>
                        <p class="detail-value"><?= esc($derivacion['docente_nombres_completos']) ?></p>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="detail-item">
                        <span class="detail-label">Urgencia</span>
                        <span class="badge <?= $derivacion['urgencia'] === 'ALTA' ? 'bg-danger' : ($derivacion['urgencia'] === 'MEDIA' ? 'bg-warning text-dark' : 'bg-success') ?>">
                          <?= esc($derivacion['urgencia']) ?>
                        </span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            <?php endif; ?>

            <!-- Familiar -->
            <?php if ($cita['tipo_derivacion'] === 'FAMILIAR'): ?>
              <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-light border-bottom">
                  <h6 class="mb-0 fw-semibold text-primary">
                    <i class="bi bi-people me-2"></i>Información del Familiar
                  </h6>
                </div>
                <div class="card-body">
                  <div class="info-item">
                    <label class="text-muted small fw-semibold mb-2 d-block">Familiar</label>
                    <span class="badge bg-secondary-subtle text-secondary fs-6 px-3 py-2">
                      <?= esc($familiar['pariente_nombres'] . ' ' . $familiar['pariente_apellidos']) ?>
                    </span>
                  </div>
                </div>
              </div>
            <?php endif ?>

            <!-- Motivo -->
            <div class="card border-0 shadow-sm mb-4">
              <div class="card-header bg-light border-bottom">
                <h6 class="mb-0 fw-semibold text-primary">
                  <i class="bi bi-chat-left-text me-2"></i>Motivo de Consulta
                </h6>
              </div>
              <div class="card-body">
                <div class="motivo-content">
                  <?= nl2br(esc($cita['motivo'])) ?>
                </div>
              </div>
            </div>

            <!-- Datos de Atención -->
            <div class="card border-0 shadow-sm mb-4">
              <div class="card-header bg-light border-bottom">
                <h6 class="mb-0 fw-semibold text-primary">
                  <i class="bi bi-calendar-check me-2"></i>Datos de Atención
                </h6>
              </div>
              <div class="card-body">
                <div class="row g-3">
                  <div class="col-md-4">
                    <div class="detail-item">
                      <span class="detail-label"><i class="bi bi-calendar3 me-1"></i>Fecha de atención</span>
                      <p class="detail-value"><?= esc($cita['atencion_fech']) ?></p>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="detail-item">
                      <span class="detail-label"><i class="bi bi-clock me-1"></i>Hora inicio</span>
                      <p class="detail-value"><?= substr($cita['hora_inicio'], 0, 5) ?></p>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="detail-item">
                      <span class="detail-label"><i class="bi bi-clock-history me-1"></i>Hora fin</span>
                      <p class="detail-value"><?= substr($cita['hora_fin'], 0, 5) ?></p>
                    </div>
                  </div>
                </div>

                <hr class="my-3">

                <div class="row">
                  <div class="col-md-12">
                    <div class="info-item">
                      <label class="text-muted small fw-semibold mb-2 d-block">
                        <i class="bi bi-check-circle me-1"></i>Estado de Asistencia
                      </label>
                      <span class="badge <?= $cita['asistencia'] === 'ASISTIDO' ? 'bg-success' : 'bg-danger' ?> fs-6 px-3 py-2">
                        <?= esc($cita['asistencia']) ?>
                      </span>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Detalles de la Consulta -->
            <?php if ($cita['asistencia'] === 'ASISTIDO'): ?>
              <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-light border-bottom">
                  <h6 class="mb-0 fw-semibold text-primary">
                    <i class="bi bi-clipboard-check me-2"></i>Detalles de la Consulta
                  </h6>
                </div>
                <div class="card-body">
                  <?php
                  $detalles = [
                      'problema' => ['label' => 'Problema', 'icon' => 'exclamation-triangle'],
                      'recomendacion' => ['label' => 'Recomendación', 'icon' => 'lightbulb'],
                      'aspecto_fisico' => ['label' => 'Aspecto físico', 'icon' => 'person-standing'],
                      'aseo_personal' => ['label' => 'Aseo personal', 'icon' => 'droplet'],
                      'conducta' => ['label' => 'Conducta', 'icon' => 'emoji-smile']
                  ];
                  $hasContent = false;
                  foreach ($detalles as $name => $data):
                      if ($detalleCita[$name]):
                          $hasContent = true;
                          break;
                      endif;
                  endforeach;
                  ?>
                  <?php if ($hasContent): ?>
                    <?php foreach ($detalles as $name => $data): ?>
                      <?php if ($detalleCita[$name]): ?>
                        <div class="detalle-section mb-4">
                          <div class="detalle-header">
                            <i class="bi bi-<?= $data['icon'] ?> me-2 text-primary"></i>
                            <strong><?= $data['label'] ?></strong>
                          </div>
                          <div class="detalle-content">
                            <?= nl2br(esc($detalleCita[$name])) ?>
                          </div>
                        </div>
                      <?php endif ?>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <p class="text-muted mb-0">No hay detalles adicionales registrados.</p>
                  <?php endif; ?>
                </div>
              </div>
            <?php endif ?>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
  .detail-item {
    background-color: var(--gray);
    border-radius: 6px;
    padding: 0.75rem 1rem;
    border-left: 3px solid var(--blue);
  }

  .detail-label {
    font-size: 0.875rem;
    color: var(--black2);
    font-weight: 600;
  }

  .detail-value {
    font-weight: 500;
    color: var(--black1);
  }

  .motivo-content,
  .detalle-section {
    background-color: var(--gray);
    border-left: 4px solid var(--blue);
    border-radius: 6px;
    padding: 1rem 1.25rem;
    line-height: 1.6;
    color: var(--black1);
  }

  .detalle-header i {
    color: var(--blue);
  }
</style>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const infoEl = document.getElementById('alumnoInfo');
        if (!infoEl) return;

        const nombres = infoEl.dataset.nombres;
        const apellidos = infoEl.dataset.apellidos;
        const dni = infoEl.dataset.dni;
        const programa = infoEl.dataset.programa;
        const turno = infoEl.dataset.turno;
        const ciclo = infoEl.dataset.ciclo;

        const turnoText = getTurnoText(turno);
        const cicloText = getCicloText(ciclo);

        infoEl.innerHTML = `
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="detail-item">
                        <span class="detail-label">
                            <i class="bi bi-person me-1"></i>Nombre Completo
                        </span>
                        <p class="detail-value">${nombres} ${apellidos}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="detail-item">
                        <span class="detail-label">
                            <i class="bi bi-card-text me-1"></i>DNI
                        </span>
                        <p class="detail-value">${dni}</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="detail-item">
                        <span class="detail-label">
                            <i class="bi bi-book me-1"></i>Programa
                        </span>
                        <p class="detail-value">${programa}</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="detail-item">
                        <span class="detail-label">
                            <i class="bi bi-sun me-1"></i>Turno
                        </span>
                        <p class="detail-value">${turnoText}</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="detail-item">
                        <span class="detail-label">
                            <i class="bi bi-layers me-1"></i>Ciclo
                        </span>
                        <p class="detail-value">${cicloText}</p>
                    </div>
                </div>
            </div>
        `;
    });
</script>

<?= $this->endSection() ?>
