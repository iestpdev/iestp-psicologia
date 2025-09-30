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
