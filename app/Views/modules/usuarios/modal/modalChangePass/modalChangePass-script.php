<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
<script>
    let selectedUserId = null;
    const modalPassword = new bootstrap.Modal(document.getElementById("modalPassword"));
    const passwordInput = document.getElementById("newPassword");
    const generateBtn = document.getElementById("generatePassword");
    const confirmBtn = document.getElementById("confirmPasswordChange");

    // Generar contraseña aleatoria
    generateBtn.addEventListener("click", () => {
        const charset = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789!@#$%^&*()";
        let password = "";
        for (let i = 0; i < 10; i++) {
            password += charset.charAt(Math.floor(Math.random() * charset.length));
        }
        passwordInput.value = password;
    });

    // Cuando se hace clic en el botón key-outline
    $(document).on("click", "button[id^='key-']", function () {
        selectedUserId = this.id.replace("key-", "");
        passwordInput.value = "";
        modalPassword.show();
    });

    // Confirmar cambio
    confirmBtn.addEventListener("click", async () => {
        const newPass = passwordInput.value.trim();
        if (!newPass) {
            Swal.fire("Advertencia", "Debe ingresar o generar una contraseña", "warning");
            return;
        }

        const confirm = await Swal.fire({
            title: "¿Confirmar cambio?",
            text: "¿Desea actualizar la contraseña de este usuario?",
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Sí, actualizar",
            cancelButtonText: "Cancelar",
        });

        if (!confirm.isConfirmed) return;

        try {
            const response = await fetch(`<?= base_url('api/usuarios/update-password/') ?>${selectedUserId}`, {
                method: "PATCH",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ password: newPass }),
            });

            const data = await response.json();

            if (response.ok) {
                Swal.fire("Éxito", "Contraseña actualizada correctamente", "success");
                modalPassword.hide();
            } else {
                Swal.fire("Error", data.message || "Error al actualizar la contraseña", "error");
            }
        } catch (error) {
            Swal.fire("Error", "Ocurrió un error inesperado", "error");
        }
    });
</script>
