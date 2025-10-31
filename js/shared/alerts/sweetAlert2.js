document.addEventListener("DOMContentLoaded", () => {
  // === Confirmaciones para formularios ===
  document.querySelectorAll("form[data-confirm]").forEach((form) => {
    form.addEventListener("submit", (e) => {
      e.preventDefault();

      const title = form.getAttribute("data-title") || "¿Está seguro?";
      const text = form.getAttribute("data-text") || "Esta acción no se puede deshacer.";
      const icon = form.getAttribute("data-icon") || "question";

      Swal.fire({
        title,
        text,
        icon,
        footer: "Área de Psicología - IESTP Chincha",
        confirmButtonText: "Aceptar",
        confirmButtonColor: "#0358CB",
        showCancelButton: true,
        cancelButtonText: "Cancelar",
        cancelButtonColor: "#c0392b",
      }).then((result) => {
        if (result.isConfirmed) {
          form.submit();
        }
      });
    });
  });

  // === Confirmaciones para enlaces ===
  document.addEventListener("click", (e) => {
    const link = e.target.closest("a[data-confirm]");
    if (!link) return;

    e.preventDefault();

    const title = link.getAttribute("data-title") || "¿Está seguro?";
    const text = link.getAttribute("data-text") || "Esta acción no se puede deshacer.";
    const icon = link.getAttribute("data-icon") || "warning";

    Swal.fire({
      title,
      text,
      icon,
      footer: "Área de Psicología - IESTP Chincha",
      confirmButtonText: "Aceptar",
      confirmButtonColor: "#0358CB",
      showCancelButton: true,
      cancelButtonText: "Cancelar",
      cancelButtonColor: "#c0392b",
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = link.href;
      }
    });
  });
});
