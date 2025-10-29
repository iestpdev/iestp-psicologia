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

  <?php
  // Array con nombres de meses en español
  $meses = [
    '01' => 'ENERO',
    '02' => 'FEBRERO',
    '03' => 'MARZO',
    '04' => 'ABRIL',
    '05' => 'MAYO',
    '06' => 'JUNIO',
    '07' => 'JULIO',
    '08' => 'AGOSTO',
    '09' => 'SETIEMBRE',
    '10' => 'OCTUBRE',
    '11' => 'NOVIEMBRE',
    '12' => 'DICIEMBRE'
  ];

  $nombreMes = $meses[str_pad($month, 2, '0', STR_PAD_LEFT)] ?? $month;
  ?>

  <div style="display:flex; align-items:center; justify-content:center; margin-bottom:10px;">
    <div style="position:absolute; left:40px; top:50px;">
      <img src="<?= FCPATH ?>assets/images/logo-con-fondo.jpg" alt="Logo" style="width:70px; height:auto;">
    </div>
    <h3 class="mt-2 text-center title" style="margin:0;">
      REGISTRO DE ATENCIÓN DEL SERVICIO DE PSICOLOGÍA EN EL MES DE
      <?= $nombreMes ?> - <?= $year ?>
    </h3>
  </div>

  <table class="tabla mt-2" style="font-size:11px;">
    <colgroup>
      <col style="width:3%;"> <!-- N° -->
      <col style="width:14%;"> <!-- Apellidos y nombres -->
      <col style="width:5%;"> <!-- Edad -->
      <col style="width:12%;"> <!-- Programa de estudio -->
      <col style="width:5%;"> <!-- Semestre -->
      <col style="width:25%;"> <!-- Problema actual -->
      <col style="width:25%;"> <!-- TTO -->
      <col style="width:10%;"> <!-- Fecha y horario -->
    </colgroup>
    <thead>
      <tr class="bg-primary text-light header-row">
        <th class="text-center">N°</th>
        <th class="text-left">Apellidos y nombres</th>
        <th class="text-center">Edad</th>
        <th class="text-left">Programa</th>
        <th class="text-center">Ciclo</th>
        <th class="text-left">Problema actual</th>
        <th class="text-left">TTO</th>
        <th class="text-center">Fecha y Hora</th>
      </tr>
    </thead>
    <tbody>
      <?php if (empty($rows)): ?>
        <tr>
          <td colspan="8" class="text-center no-records">No hay registros de citas asistidas para este período.</td>
        </tr>
      <?php else: ?>
        <?php foreach ($rows as $index => $row): ?>
          <?php
          // Calcular edad
          $edad = '';
          if (!empty($row['alumno_fecha_nacimiento'])) {
            $nacimiento = new DateTime($row['alumno_fecha_nacimiento']);
            $hoy = new DateTime();
            $edad = $hoy->diff($nacimiento)->y;
          }

          // Ciclos del 1 al 6 en romano
          $romanos = [1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 6 => 'VI'];
          $cicloRomano = $romanos[(int) $row['alumno_ciclo']] ?? '-';
          ?>
          <tr>
            <td class="text-center"><?= $index + 1 ?></td>
            <td class="text-left name-col"><?= esc($row['alumno_nombres_completos']) ?></td>
            <td class="text-center"><?= $edad ?></td>
            <td><?= esc($row['alumno_programa_estudio']) ?></td>
            <td class="text-center"><?= $cicloRomano ?></td>
            <td class="text-justify detail-col"><?= esc($row['problema']) ?></td>
            <td class="text-justify detail-col"><?= esc($row['recomendacion']) ?></td>
            <td class="text-center text-nowrap">
              <?= date('d/m/Y', strtotime($row['atencion_fech'])) ?><br>
              <?= substr($row['hora_inicio'], 0, 5) . ' - ' . substr($row['hora_fin'], 0, 5) ?>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php endif; ?>
    </tbody>
  </table>
</page>