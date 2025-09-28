function initDataTable(selector, ajaxUrl, columns, orderCol = 0, orderDir = 'desc') {
    return $(selector).DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: ajaxUrl,
            type: "GET"
        },
        columns: columns,
        order: [[orderCol, orderDir]]
    });
}
