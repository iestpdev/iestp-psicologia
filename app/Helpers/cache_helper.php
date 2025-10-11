<?php

if (!function_exists('clear_datatable_cache')) {
    /**
     * Limpia todas las caches relacionadas con un modelo DataTable específico.
     *
     * @param string $modelName Nombre del modelo de vista (por ejemplo: 'UsuarioFullInfo')
     */
    function clear_datatable_cache(string $modelName): void
    {
        $cache = cache();

        // Si el handler soporta getCacheInfo() (como file o redis)
        if (method_exists($cache, 'getCacheInfo')) {
            $allKeys = array_keys($cache->getCacheInfo());
            foreach ($allKeys as $key) {
                if (str_starts_with($key, "datatable_{$modelName}_")) {
                    $cache->delete($key);
                }
            }
        } else {
            // Si el driver no soporta getCacheInfo, limpiamos todo
            $cache->clean();
        }
    }
}
