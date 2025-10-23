function showPassInput(toggleBtnId, inputId) {
    const togglePassword = document.getElementById(toggleBtnId);
    const passwordInput = document.getElementById(inputId);

    if (!togglePassword || !passwordInput) return;

    let visible = false;

    togglePassword.addEventListener("click", () => {
        visible = !visible;
        passwordInput.type = visible ? "text" : "password";

        togglePassword.innerHTML = visible
            ? '<i data-lucide="eye-off"></i>'
            : '<i data-lucide="eye"></i>';

        lucide.createIcons();
    });
}

document.addEventListener("DOMContentLoaded", () => {
    showPassInput("togglePassword", "password");
    showPassInput("toggleCurrentPassword", "currentPassword");
    showPassInput("toggleNewPassword", "newPassword");
    showPassInput("toggleConfirmPassword", "confirmPassword");
});
