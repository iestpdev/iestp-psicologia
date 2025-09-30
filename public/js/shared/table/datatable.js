// Defaults globales para todas las tablas
$.extend(true, $.fn.dataTable.defaults, {
    processing: true,
    serverSide: true,
    pageLength: 5,
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
function initDataTable(selector, ajaxUrl, columns, extraOptions = {}) {
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

    return $(selector).DataTable($.extend(true, {
        ajax: {
            url: ajaxUrl,
            type: "GET"
        },
        columns: columns
    }, extraOptions));
}
