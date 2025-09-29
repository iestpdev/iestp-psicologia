  function toggleSidebar(){
    const s = document.getElementById('sidebar');
    const m = document.getElementById('main');
    s.classList.toggle('activado');
    m.classList.toggle('activado');

    // Si hay DataTables visibles, reajusta columnas al cambiar ancho
    if (window.jQuery && $.fn.dataTable) {
      $('.dataTable').each(function(){
        if ($.fn.dataTable.isDataTable(this)) {
          const api = $(this).DataTable();
          api.columns.adjust();
          if (api.responsive && api.responsive.recalc) {
            api.responsive.recalc();
          }
        }
      });
    }
  }