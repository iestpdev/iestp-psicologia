<?php

if (!function_exists('runValidation')) {
    /**
     * Ejecuta la validación correspondiente según la entidad especificada.
     *
     * @param string $entity Nombre de la entidad (por ejemplo: 'usuario_create', 'cita_update').
     * @param \CodeIgniter\HTTP\IncomingRequest $request Objeto de solicitud HTTP con los datos a validar.
     * @return array Lista de errores de validación (vacía si todo es válido).
     *
     * @throws \Exception Si la entidad no tiene una validación definida.
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

            //profile
            case 'profile_update':
                $validationClass = new \App\Validations\Profile\ProfileUpdate();
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

            //citas
            case 'cita_create':
                $validationClass = new \App\Validations\Citas\CitaCreate();
                break;
            case 'cita_update':
                $validationClass = new \App\Validations\Citas\CitaUpdate();
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
