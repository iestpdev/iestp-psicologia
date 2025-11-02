<?php

namespace App\Controllers;

use App\Libraries\ExcelImporter;
use App\Models\Alumno;
use App\Models\Cita;
use App\Models\Familiar;
use App\Models\Mantenimiento\EstadoCivil;
use App\Models\Mantenimiento\Parentesco;
use App\Models\Mantenimiento\ProgramaEstudio;
use App\Models\Mantenimiento\Religion;

class AlumnoController extends BaseController
{
    public function index(): string
    {
        return view('modules/alumnos/index');
    }

    public function info($alumnoId): string
    {
        $session = session();
        $user = $session->get('user');

        $alumnoModel = new Alumno();
        $alumno = $alumnoModel->obtenerPorId($alumnoId);
        if (!$alumno) {
            return view('errors/html/error_404', [
                'message' => 'Alumno no encontrado'
            ]);
        }

        $familiarModel = new Familiar();
        $familiares = $familiarModel->listarPorAlumnoId($alumnoId);

        $parentescoModel = new Parentesco();
        $parentescos = $parentescoModel->listar();

        $citaModel = new Cita();
        if ($user && $user['rol'] === 'PSICOLOGO') {
            $citas = $citaModel->listarPorAlumnoId($alumnoId);
        } else {
            $citas = $citaModel->listarPorAlumnoId($alumnoId, $user['id']);
        }

        return view('modules/alumnos/details/index', [
            'alumno' => $alumno,
            'familiares' => $familiares,
            'parentescos' => $parentescos,
            'citas' => $citas
        ]);
    }

    public function crear(): string
    {
        $programaEstudioModel = new ProgramaEstudio();
        $data['programas_estudios'] = $programaEstudioModel->listar();

        $religionModel = new Religion();
        $data['religiones'] = $religionModel->listar();

        $estadoCivilModel = new EstadoCivil();
        $data['estados_civiles'] = $estadoCivilModel->listar();

        return view('modules/alumnos/crear', $data);
    }

    public function editar($alumnoId): string
    {
        $alumnoModel = new Alumno();
        $alumno = $alumnoModel->find($alumnoId);

        if (!$alumno) {
            return view('errors/html/error_404', [
                'message' => 'Alumno no encontrado'
            ]);
        }

        $programaEstudioModel = new ProgramaEstudio();
        $religionModel = new Religion();
        $estadoCivilModel = new EstadoCivil();

        return view('modules/alumnos/editar', [
            'alumno' => $alumno,
            'programas_estudios' => $programaEstudioModel->listar(),
            'religiones' => $religionModel->listar(),
            'estados_civiles' => $estadoCivilModel->listar(),
        ]);
    }

    public function deleteAlumno($id)
    {
        $alumnoModel = new Alumno();
        try {
            $alumno = $alumnoModel->obtenerPorId($id);
            if (!$alumno)
                throw new \Exception("Alumno no encontrado");
            if (!$alumnoModel->eliminar($id))
                throw new \Exception("Error al eliminar alumno");

            return redirect()->to('/alumnos')->with('success', 'Alumno eliminado correctamente');
        } catch (\Throwable $e) {
            return redirect()->to('/alumnos')->with('error', 'Hubo un error: ' . $e->getMessage());
        }
    }

    public function saveAlumno()
    {
        helper(['validation', 'input']);
        $errors = runValidation('alumno_create', $this->request);
        if (!empty($errors))
            return redirect()->to('/alumnos/crear')->withInput()->with('errors', $errors);

        $db = \Config\Database::connect();
        $db->transBegin();
        try {
            $alumnoData = normalize_input([
                'dni' => $this->request->getPost('dni'),
                'email' => $this->request->getPost('correo'),
                'nombres' => $this->request->getPost('nombres'),
                'apellidos' => $this->request->getPost('apellidos'),
                'programa_estudio_id' => $this->request->getPost('programa_estudio'),
                'ciclo' => $this->request->getPost('ciclo'),
                'turno' => $this->request->getPost('turno'),
                'telefono' => $this->request->getPost('telefono'),
                'domicilio' => $this->request->getPost('domicilio'),
                'sexo' => $this->request->getPost('sexo'),
                'direccion_nac' => $this->request->getPost('direccion_nac'),
                'fecha_nac' => $this->request->getPost('fecha_nac'),
                'religion_id' => $this->request->getPost('religion'),
                'estado_civil_id' => $this->request->getPost('estado_civil'),
            ]);
            $alumnoModel = new Alumno();
            $alumnoId = $alumnoModel->crear($alumnoData);
            if (!$alumnoId)
                throw new \Exception("Error al crear Alumno");

            $db->transCommit();
            return redirect()->to('/alumnos')->with('success', 'Alumno registrado con éxito');
        } catch (\Throwable $e) {
            $db->transRollback();
            return redirect()->back()->withInput()->with('error', 'Hubo un error: ' . $e->getMessage());
        }
    }

    public function updateAlumno($id)
    {
        helper(['validation', 'input']);
        $errors = runValidation('alumno_update', $this->request);

        if (!empty($errors))
            return redirect()->back()->withInput()->with('errors', $errors);

        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            $alumnoModel = new Alumno();
            $alumnoActual = $alumnoModel->obtenerPorId($id);

            if (!$alumnoActual)
                throw new \Exception("Alumno no encontrado");

            $alumnoData = normalize_input([
                'dni' => $this->request->getPost('dni'),
                'email' => $this->request->getPost('correo'),
                'nombres' => $this->request->getPost('nombres'),
                'apellidos' => $this->request->getPost('apellidos'),
                'programa_estudio_id' => $this->request->getPost('programa_estudio'),
                'ciclo' => $this->request->getPost('ciclo'),
                'turno' => $this->request->getPost('turno'),
                'telefono' => $this->request->getPost('telefono'),
                'domicilio' => $this->request->getPost('domicilio'),
                'sexo' => $this->request->getPost('sexo'),
                'direccion_nac' => $this->request->getPost('direccion_nac'),
                'fecha_nac' => $this->request->getPost('fecha_nac'),
                'religion_id' => $this->request->getPost('religion'),
                'estado_civil_id' => $this->request->getPost('estado_civil'),
            ]);

            $alumnoModel->actualizar($id, $alumnoData);

            $db->transCommit();
            return redirect()->to('/alumnos')->with('success', 'Alumno actualizado correctamente');
        } catch (\Throwable $e) {
            $db->transRollback();
            return redirect()->back()->withInput()->with('error', 'Error al actualizar: ' . $e->getMessage());
        }
    }

    public function obtenerAlumnos()
    {
        $dni = $this->request->getGet('dni');
        $programa_estudio_id = $this->request->getGet('programa_estudio_id');
        $ciclo = $this->request->getGet('ciclo');
        $turno = $this->request->getGet('turno');

        $alumnoModel = new Alumno();
        $alumnos = $alumnoModel->obtenerAlumnos($dni, $programa_estudio_id, $ciclo, $turno);

        return $this->response->setJSON([
            'status' => 'success',
            'data' => $alumnos
        ]);
    }

    public function importarDataExcel()
    {
        $file = $this->request->getFile('archivo_excel');

        if (!$file || !$file->isValid() || $file->hasMoved()) {
            return redirect()->back()->with('error', 'Error al subir el archivo Excel. Selecciona un archivo válido.');
        }

        $allowedMimeTypes = [
            'application/vnd.ms-excel',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        ];

        if (!in_array($file->getMimeType(), $allowedMimeTypes)) {
            return redirect()->back()->with('error', 'Formato de archivo no válido. Solo se permiten archivos .xls o .xlsx.');
        }

        $db = \Config\Database::connect();
        $db->transBegin(); // *** INICIO DE LA TRANSACCIÓN ***

        try {
            $filePath = $file->getTempName();
            $importer = new ExcelImporter();
            $alumnosData = $importer->importAlumnosData($filePath);

            // Manejar errores de lectura/formato
            if (isset($alumnosData['error'])) {
                throw new \Exception($alumnosData['error']);
            }

            if (empty($alumnosData)) {
                throw new \Exception('El archivo Excel no contiene datos de alumnos válidos para importar.');
            }

            $alumnoModel = new Alumno();
            $insertCount = 0;
            $updateCount = 0;
            $now = date('Y-m-d H:i:s');

            // 2. Iteración y Lógica UPSERT
            foreach ($alumnosData as $data) {
                $dni = $data['dni'];

                // Buscar si existe un alumno activo con ese DNI
                $alumnoExistente = $alumnoModel->obtenerActivoPorDni($dni);

                if ($alumnoExistente) {
                    // Si existe, es un UPDATE
                    $data['updated_at'] = $now;
                    // Se usa el ID del alumno existente para actualizarlo
                    if ($alumnoModel->actualizar($alumnoExistente['id'], $data)) {
                        $updateCount++;
                    } else {
                        // Error específico si el update falla (e.g., violación de unicidad en email/teléfono)
                        throw new \Exception("Error al actualizar alumno con DNI: {$dni}. Verifique que email y teléfono no estén duplicados en otros alumnos activos.");
                    }
                } else {
                    // Si no existe, es un INSERT
                    $data['created_at'] = $now;
                    $data['updated_at'] = $now;
                    // Se crea el nuevo registro
                    if ($alumnoModel->crear($data)) {
                        $insertCount++;
                    } else {
                        // Error específico si el insert falla
                        throw new \Exception("Error al insertar nuevo alumno con DNI: {$dni}. Verifique que el DNI, email y teléfono no estén duplicados.");
                    }
                }
            }

            $db->transCommit(); // *** CONFIRMAR TRANSACCIÓN ***

            return redirect()->to('/alumnos')->with('success', "Carga masiva completada con éxito. Se insertaron {$insertCount} alumnos y se actualizaron {$updateCount} alumnos.");

        } catch (\Throwable $e) {
            $db->transRollback(); // *** REVERTIR TRANSACCIÓN EN CASO DE ERROR ***

            // Logueamos el error para debugging
            log_message('error', 'Error en carga masiva de alumnos (UPSERT): ' . $e->getMessage());

            // Devolvemos el mensaje de error al usuario
            return redirect()->back()->withInput()->with('error', 'Hubo un error durante la carga masiva. Se revirtieron todos los cambios. Detalle: ' . $e->getMessage());
        }
    }
}
