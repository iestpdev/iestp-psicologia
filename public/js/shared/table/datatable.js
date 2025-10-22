// Defaults globales para todas las tablas
$.extend(true, $.fn.dataTable.defaults, {
    processing: true,
    serverSide: true,
    pageLength: 10,
    lengthChange: false,
    ordering: false,
    language: {
        url: 'https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
    }
});

/**
 * Inicializa un DataTable con índice inverso por defecto
 *
 * @param {string} selector - Selector de la tabla (ej: '#tablaUsuarios')
 * @param {string} ajaxUrl - Endpoint que devuelve el JSON
 * @param {Array} columns - Columnas DataTables (sin el índice, se agrega solo)
 * @param {Object} extraOptions - Opciones adicionales de DataTables (opcional)
 */
function initDataTable(ajaxUrl, columns, extraOptions = {}) {
    // Siempre agregamos la columna de índice inverso al inicio
    columns.unshift({
        data: null,
        orderable: false,
        searchable: false,
        render: function (data, type, row, meta) {
            var total = meta.settings.fnRecordsDisplay();
            return total - (meta.row + meta.settings._iDisplayStart);
        }
    });

    // Extraemos ajax.data si viene en extraOptions
    const extraAjaxData = extraOptions.ajax?.data || null;

    // Eliminamos extraOptions.ajax para evitar sobreescribir por completo el bloque
    if (extraOptions.ajax) delete extraOptions.ajax;

    return $('#datatable').DataTable($.extend(true, {
        ajax: {
            url: ajaxUrl,
            type: "GET",
            // combinamos ajax.data solo si fue pasado
            data: function (d) {
                if (typeof extraAjaxData === 'function') {
                    extraAjaxData(d); // inyectamos parámetros personalizados
                }
            }
        },
        columns: columns
    }, extraOptions));
}