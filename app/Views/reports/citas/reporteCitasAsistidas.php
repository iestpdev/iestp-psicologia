<page backtop="10mm" backbottom="10mm">
  <page_header>
    <div style="text-align:right; font-size:12px;">
      Reporte de Citas Asistidas - <?= $month ?>/<?= $year ?>
    </div>
  </page_header>

  <page_footer>
    <div style="text-align:center; font-size:10px;">
      Página [[page_cu]] / [[page_nb]]
    </div>
  </page_footer>

  <?= $estilos ?>

  <h3 class="mt-2 text-center">Citas Asistidas - <?= $month ?>/<?= $year ?></h3>

  <table class="tabla mt-2" style="font-size:12px;">
    <colgroup>
      <col style="width:5%;">
      <col style="width:20%;">
      <col style="width:12%;">
      <col style="width:25%;">
      <col style="width:10%;">
      <col style="width:10%;">
      <col style="width:18%;">
    </colgroup>
    <thead>
      <tr class="bg-primary text-light">
        <th>ID</th>
        <th>Psicólogo (DNI)</th>
        <th>Tipo</th>
        <th>Alumno (DNI)</th>
        <th>Fecha</th>
        <th>Horario</th>
        <th>Motivo / Recomendación</th>
      </tr>
    </thead>
    <tbody>
      <?php if (empty($rows)): ?>
        <tr>
          <td colspan="7" class="text-center">No hay registros</td>
        </tr>
      <?php else: ?>
        <?php foreach ($rows as $row): ?>
          <tr>
            <td><?= esc($row['id']) ?></td>
            <td><?= esc($row['usuario_nombres_completos']) ?> <br><small><?= esc($row['usuario_dni']) ?></small></td>
            <td><?= esc($row['tipo_derivacion']) ?></td>
            <td><?= esc($row['alumno_nombres_completos']) ?> <br><small><?= esc($row['alumno_dni']) ?></small></td>
            <td><?= esc($row['atencion_fech']) ?></td>
            <td><?= esc($row['hora_inicio']) ?> - <?= esc($row['hora_fin']) ?></td>
            <td>
              <strong>Motivo:</strong> <?= esc($row['motivo']) ?><br>
              <?php if (!empty($row['recomendacion'])): ?>
                <strong>Recomendacion:</strong> <?= esc($row['recomendacion']) ?>
              <?php endif; ?>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php endif; ?>
    </tbody>
  </table>
</page>
