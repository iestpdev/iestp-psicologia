<?php

if (!function_exists('runValidation')) {
    /**
     * Ejecuta las validaciones de una entidad
     *
     * @param string $entity   Nombre de la entidad
     * @param \CodeIgniter\HTTP\IncomingRequest $request
     * @return array           Devuelve array de errores (vacío si no hay)
     */
    function runValidation(string $entity, $request): array
    {
        $validation = \Config\Services::validation();

        switch ($entity) {
            //usuarios
            case 'usuario_create':
                $validationClass = new \App\Validations\Usuarios\UsuarioCreate();
                break;
            case 'usuario_update':
                $validationClass = new \App\Validations\Usuarios\UsuarioUpdate();
                break;

            //personas
            case 'persona_create':
                $validationClass = new \App\Validations\Personas\PersonaCreate();
                break;
            case 'persona_update':
                $validationClass = new \App\Validations\Personas\PersonaUpdate();
                break;

            //parientes
            case 'pariente_create':
                $validationClass = new \App\Validations\Parientes\ParienteCreate();
                break;
            case 'pariente_update':
                $validationClass = new \App\Validations\Parientes\ParienteUpdate();
                break;

            //alumnos
            case 'alumno_create':
                $validationClass = new \App\Validations\Alumnos\AlumnoCreate();
                break;
            case 'alumno_update':
                $validationClass = new \App\Validations\Alumnos\AlumnoUpdate();
                break;
                
            //derivaciones
            case 'derivacion_create':
                $validationClass = new \App\Validations\Derivaciones\DerivacionCreate();
                break;
            case 'derivacion_update':
                $validationClass = new \App\Validations\Derivaciones\DerivacionUpdate();
                break;
                
            default:
                throw new \Exception("No hay validación definida para la entidad: {$entity}");
        }

        $validation->setRules($validationClass->rules, $validationClass->errors);
        if (!$validation->withRequest($request)->run())
            return $validation->getErrors();

        return [];
    }
}
