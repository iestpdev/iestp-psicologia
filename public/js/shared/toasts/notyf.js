const notyf = new Notyf({
    duration: 3500,
    dismissible: true,
    ripple: true,
    position: { x: 'right', y: 'top' },
    types: [
        {
            type: 'success',
            background: '#22c55e',
            icon: false,
        },
        {
            type: 'warning',
            background: 'orange',
            icon: false,
        },
        {
            type: 'error',
            background: '#ef4444',
            icon: false,
        },
    ],
});

export function showToast(type, message) {
    if (!['success', 'warning', 'error'].includes(type)) {
        console.warn(`Tipo de toast no válido: ${type}`);
        return;
    }

    notyf.open({
        type,
        message,
    });
}
