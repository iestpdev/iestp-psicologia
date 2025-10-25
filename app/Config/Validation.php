<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Validation\StrictRules\CreditCardRules;
use CodeIgniter\Validation\StrictRules\FileRules;
use CodeIgniter\Validation\StrictRules\FormatRules;
use CodeIgniter\Validation\StrictRules\Rules;
use App\Rules\CustomRules;

/**
 * Configuración de validación del sistema.
 *
 * Define los conjuntos de reglas y las plantillas para mostrar errores
 * utilizados por el servicio de validación de CodeIgniter.
 *
 * @package Config
 */
class Validation extends BaseConfig
{
    /**
     * Clases que contienen las reglas de validación disponibles.
     *
     * @var list<string>
     */
    public array $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
        CustomRules::class, // Reglas personalizadas
    ];

    /**
     * Vistas utilizadas para mostrar los errores de validación.
     *
     * @var array<string, string>
     */
    public array $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];
}