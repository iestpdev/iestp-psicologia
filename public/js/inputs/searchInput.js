function attachSearchInput(table, inputId) {
    console.log("Attaching search input with ID:", inputId);
    // Escucha a nivel de document para cuando el input aparezca
    $(document).on('keyup', '#' + inputId, function () {
        console.log("searchInput value:", this.value);
        table.search(this.value).draw();
    });
}
