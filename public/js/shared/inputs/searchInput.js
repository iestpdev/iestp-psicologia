function attachSearchInput(table, inputId) {
    $(document).on('keyup', '#' + inputId, function () {
        table.search(this.value).draw();
    });
}
