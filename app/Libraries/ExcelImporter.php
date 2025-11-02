<?php

namespace App\Libraries;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use App\Models\Mantenimiento\ProgramaEstudio;
use App\Models\Mantenimiento\Religion;
use App\Models\Mantenimiento\EstadoCivil;

class ExcelImporter
{
    /**
     * Define el mapeo de los encabezados de columna amigables (Excel)
     * a los nombres de los campos de la base de datos (DB).
     */
    private $headerMapping = [
        'nombres'                 => 'nombres',
        'apellidos'               => 'apellidos',
        'dni'                     => 'dni',
        'email'                   => 'email',
        'telefono'                => 'telefono',
        'direccion de nacimiento' => 'direccion_nac',
        'fecha de nacimiento'     => 'fecha_nac',
        'domicilio'               => 'domicilio',
        'sexo'                    => 'sexo',
        'ciclo'                   => 'ciclo',
        'turno'                   => 'turno',
        'programa de estudio'     => 'programa_estudio_id', 
        'religion'                => 'religion_id',         
        'estado civil'            => 'estado_civil_id',     
    ];

    /**
     * Mapeos específicos de valores de Excel a valores de DB (no FK).
     */
    private $valueMapping = [
        'sexo' => [
            'masculino' => 'M',
            'femenino' => 'F',
        ],
        'ciclo' => [
            'primer' => 1,
            'segundo' => 2,
            'tercero' => 3,
            'cuarto' => 4,
            'quinto' => 5,
            'sexto' => 6,
        ],
        'turno' => [
            'mañana' => 'M',
            'tarde' => 'T',
            // Puedes agregar 'noche' => 'N' si aplica
        ],
    ];

    /**
     * Campos de la DB que son requeridos.
     */
    private $requiredDbFields = [
        'nombres', 'apellidos', 'dni', 'email', 'sexo', 'ciclo', 'turno', 'programa_estudio_id'
    ];

    // Propiedades para los Modelos
    private $programaEstudioModel;
    private $religionModel;
    private $estadoCivilModel;
    
    // Mapeo de campos de ID a sus modelos correspondientes
    private $modelMap = [];

    public function __construct()
    {
        // Inicializar los modelos de mantenimiento
        $this->programaEstudioModel = new ProgramaEstudio();
        $this->religionModel = new Religion();
        $this->estadoCivilModel = new EstadoCivil();
        
        // Configurar el mapa para obtener el ID en la iteración
        $this->modelMap = [
            'programa_estudio_id' => [
                'model' => $this->programaEstudioModel,
                'friendly_name' => 'Programa de Estudio',
            ],
            'religion_id' => [
                'model' => $this->religionModel,
                'friendly_name' => 'Religión',
            ],
            'estado_civil_id' => [
                'model' => $this->estadoCivilModel,
                'friendly_name' => 'Estado Civil',
            ],
        ];
    }

    /**
     * Realiza conversiones específicas de valores de Excel a DB (Sexo, Ciclo, Turno).
     * @param string $dbField El campo de la base de datos.
     * @param mixed $value El valor del Excel.
     * @return mixed El valor convertido o un array de error si no se encuentra.
     */
    private function processDbValue(string $dbField, $value)
    {
        // Si el valor está vacío, lo devolvemos como nulo (y será validado como requerido si aplica)
        if (empty($value) && $value !== 0) {
            return null;
        }

        // Convertir el valor a minúsculas y limpiar espacios
        $normalizedValue = strtolower(trim($value));

        // Verificar si el campo requiere mapeo
        if (isset($this->valueMapping[$dbField])) {
            $mapping = $this->valueMapping[$dbField];

            // Buscar el valor normalizado en el mapeo
            if (array_key_exists($normalizedValue, $mapping)) {
                return $mapping[$normalizedValue];
            } else {
                // Devolver un error si el valor no se pudo mapear
                $friendlyName = array_search($dbField, $this->headerMapping) ?: $dbField;
                return ['error' => "El valor '{$value}' para el campo '{$friendlyName}' no es válido o no está mapeado."];
            }
        }

        // Si no es un campo con mapeo especial, devolver el valor original
        return $value;
    }


    /**
     * Procesa un archivo Excel y devuelve un array con los datos de los alumnos.
     * @param string $filePath La ruta al archivo temporal subido.
     * @return array Array de datos de alumnos o un array con clave 'error'.
     */
    public function importAlumnosData(string $filePath): array
    {
        try {
            // 1. Cargar el archivo con PhpSpreadsheet
            $reader = IOFactory::createReaderForFile($filePath);
            $spreadsheet = $reader->load($filePath);
        } catch (\Throwable $e) {
            return ['error' => 'Error al leer el archivo Excel: ' . $e->getMessage()];
        }

        $sheet = $spreadsheet->getActiveSheet();
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();

        // 2. Mapear encabezados de columna
        $headerRow = $sheet->rangeToArray('A1:' . $highestColumn . '1', null, true, true, true)[1];
        $columnMap = [];
        $mappedDbFields = [];

        foreach ($headerRow as $colIndex => $headerName) {
            // Normalizamos el encabezado del Excel para buscar en el mapeo
            $normalizedHeader = strtolower(trim($headerName)); 
            
            // Si el encabezado normalizado existe en nuestro mapeo:
            if (array_key_exists($normalizedHeader, $this->headerMapping)) {
                $dbField = $this->headerMapping[$normalizedHeader];
                $columnMap[$colIndex] = $dbField;
                $mappedDbFields[] = $dbField;
            }
        }

        // 3. Validación de que todas las columnas *requeridas de la DB* existen
        $missing = array_diff($this->requiredDbFields, $mappedDbFields);
        if (!empty($missing)) {
             $missingFriendlyNames = [];
             // Intentamos obtener el nombre amigable que corresponde al campo de DB faltante
             foreach ($missing as $dbField) {
                 $friendlyName = array_search($dbField, $this->headerMapping);
                 if ($friendlyName) {
                     $missingFriendlyNames[] = $friendlyName;
                 } else {
                     $missingFriendlyNames[] = $dbField; // Por si acaso
                 }
             }
            return ['error' => 'Faltan columnas requeridas en el archivo Excel. Verifique los nombres: ' . implode(', ', $missingFriendlyNames)];
        }


        $alumnosData = [];
        $errors = [];

        // 4. Iterar sobre las filas de datos (empezando por la fila 2)
        for ($row = 2; $row <= $highestRow; $row++) {
            $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, null, true, true, true)[$row];
            $alumno = [];
            $hasData = false;
            $rowErrors = []; // Almacena errores específicos de la fila

            foreach ($columnMap as $colIndex => $dbField) {
                $value = trim((string)$rowData[$colIndex]);

                // Conversión de Fecha
                if ($dbField === 'fecha_nac' && !empty($value)) {
                    // Caso 1: La celda fue leída como un número de serie de Excel (formato nativo)
                    if (is_numeric($value) && $value > 1) {
                        try {
                            $value = Date::excelToDateTimeObject($value)->format('Y-m-d');
                        } catch (\Exception $e) {
                            $rowErrors[] = "La fecha en la fila {$row} es numérica pero no es un valor Excel válido.";
                            $value = null; 
                        }
                    // Caso 2: La celda fue leída como una cadena de texto (formato D/M/AAAA)
                    } elseif (is_string($value)) {
                        $timestamp = strtotime(str_replace('/', '-', $value));
                        if ($timestamp !== false) {
                            $value = date('Y-m-d', $timestamp);
                        } else {
                            $rowErrors[] = "El formato de fecha en la fila {$row} ('{$value}') no es reconocido. Use D/M/AAAA o formato nativo de Excel.";
                            $value = null;
                        }
                    } else {
                         // Si no es numérico ni cadena, y no está vacío, algo anda mal
                         $rowErrors[] = "Tipo de dato inesperado para la fecha de nacimiento en la fila {$row}.";
                         $value = null;
                    }
                } 
                
                // Mapeo de valores no FKs (sexo, ciclo, turno)
                elseif (in_array($dbField, array_keys($this->valueMapping))) {
                    $result = $this->processDbValue($dbField, $value);
                    if (is_array($result) && isset($result['error'])) {
                        $rowErrors[] = $result['error'];
                        $value = null; // Marcar como nulo para que la validación obligatoria falle si aplica
                    } else {
                        $value = $result;
                    }
                }

                // CONVERSIÓN DE TEXTO A ID USANDO LOS MODELOS (para campos FK)
                elseif (array_key_exists($dbField, $this->modelMap)) {
                    if (!empty($value)) {
                        $model = $this->modelMap[$dbField]['model'];
                        $friendlyName = $this->modelMap[$dbField]['friendly_name'];
                        
                        // Llamamos al nuevo método para obtener el ID por nombre
                        // Nota: El modelo debe manejar la normalización (minusculas) internamente.
                        $id = $model->obtenerPorNombre($value); 

                        if ($id === null) {
                            $rowErrors[] = "El valor '{$value}' para el campo '{$friendlyName}' no se encontró en la base de datos.";
                            $value = null; 
                        } else {
                            $value = $id;
                        }
                    } else {
                        $value = null; // Si el campo de texto está vacío
                    }
                }

                $alumno[$dbField] = $value === '' ? null : $value;
                if (!empty($value) || $value === 0) { // El 0 cuenta como dato (e.g., ciclo 0)
                    $hasData = true;
                }
            }

            if (!$hasData) continue; // Saltar filas completamente vacías

            // Si hubo errores de mapeo (texto no encontrado o valor no válido), agregarlos y saltar la fila
            if (!empty($rowErrors)) {
                $errors[] = "Fila {$row}: " . implode('; ', $rowErrors);
                continue; 
            }

            // 5. Validar campos obligatorios a nivel de fila (usando los nombres de DB)
            $isValid = true;
            foreach ($this->requiredDbFields as $field) {
                 // La validación chequear si está vacío después de todas las conversiones
                // IMPORTANTE: Se verifica si es empty Y no es el entero 0 (que es un valor válido para ciclo).
                if (empty($alumno[$field]) && $alumno[$field] !== 0) {
                     // Buscamos el nombre amigable para el error
                    $friendlyName = array_search($field, $this->headerMapping) ?: $field;
                    $errors[] = "Fila {$row}: El campo '{$friendlyName}' es obligatorio y está vacío.";
                    $isValid = false;
                    break;
                }
            }

            if ($isValid) {
                $alumnosData[] = $alumno;
            }
        }

        if (!empty($errors)) {
            // Devolver errores de validación de filas si existen
            return ['error' => 'Errores de validación en las filas: ' . implode('; ', array_slice($errors, 0, 5)) . (count($errors) > 5 ? ' y ' . (count($errors) - 5) . ' más.' : '')];
        }

        return $alumnosData;
    }
}