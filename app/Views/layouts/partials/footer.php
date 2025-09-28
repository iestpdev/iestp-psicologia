<!-- DataTables JS-->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- ionicons icons -->
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<!-- lucide icons -->
<script src="https://unpkg.com/lucide@latest"></script>
<script>
    lucide.createIcons();
</script>

<!-- custom scripts-->
<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const toggleBtn = document.querySelector('.toggle-btn');
        sidebar.classList.toggle('collapsed');
        toggleBtn.classList.toggle('collapsed');
    }
</script>

<script>
$(document).ready(function() {
    $('#tablaUsuarios').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "<?= base_url('api/usuarios') ?>",
            type: "GET"
        },
        columns: [
            { data: "id" },
            { data: "correo_institucional" },
            { data: "username" },
            { data: "rol" },
            { data: "created_at" },
            { data: "estado" },
            { 
                data: null,
                render: function(data, type, row) {
                    return `
                        <button class="btn btn-sm btn-warning">Editar</button>
                        <button class="btn btn-sm btn-danger">Eliminar</button>
                    `;
                }
            }
        ],
        order: [[0, 'desc']]
    });
});
</script>
</body>

</html>