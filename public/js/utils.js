function getCicloText(ciclo) {
    const ciclos = {
        1: 'PRIMERO',
        2: 'SEGUNDO',
        3: 'TERCERO',
        4: 'CUARTO',
        5: 'QUINTO',
        6: 'SEXTO'
    };
    return ciclos[ciclo] || 'No definido';
}

function getTurnoText(turno) {
    const turnos = {
        'M': 'Mañana',
        'T': 'Tarde'
    };
    return turnos[turno] || 'No definido';
}

function getSexoText(sexo) {
    const sexos = {
        'M': 'Masculino',
        'F': 'Femenino'
    };
    return sexos[sexo] || 'No definido';
}

function renderNullable(value) {
    return value && value.trim() !== "" ? value : "---------";
}

function dateFormat(data) {
    if (!data) return "---------";
    const date = new Date(data);
    const year = date.getFullYear();
    const month = String(date.getMonth() + 1).padStart(2, "0");
    const day = String(date.getDate()).padStart(2, "0");
    const hours = String(date.getHours()).padStart(2, "0");
    const minutes = String(date.getMinutes()).padStart(2, "0");
    return `${day}/${month}/${year} ${hours}:${minutes}`;
}