/**
 * Retorna una versión "debounceada" de una función
 * @param {Function} func - función a ejecutar
 * @param {number} delay - tiempo en milisegundos
 * @returns {Function}
 */
function debounce(func, delay) {
    let timer;
    return function (...args) {
        clearTimeout(timer);
        timer = setTimeout(() => func.apply(this, args), delay);
    };
}

/**
 * Conecta un input de búsqueda personalizado con una tabla DataTable.
 * Incluye debounce para evitar múltiples requests por cada tecla.
 */
function attachSearchInput(table, inputId) {
    const $input = $('#' + inputId);

    // función "debounceada" que ejecuta la búsqueda
    const debouncedSearch = debounce(function () {
        table.search($input.val()).draw();
    }, 700); // <-- espera 0.7 segundos después de dejar de escribir

    // evento keyup
    $input.on('keyup', debouncedSearch);
}
