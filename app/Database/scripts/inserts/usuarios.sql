-- =========================
-- ADMINISTRADORES
-- =========================
INSERT INTO administradores (id, nombres, apellidos, dni, telefono, created_at, updated_at)
VALUES
(NULL, 'Carlos', 'Ramirez Lopez', '12345678', '987654321', '2025-09-27 08:00:00', '2025-09-27 08:00:00'),
(NULL, 'Ana', 'Torres Vega', '23456789', '912345678', '2025-09-27 09:00:00', '2025-09-27 09:00:00'),
(NULL, 'Luis', 'Fernandez Ruiz', '34567890', '934567890', '2025-09-27 10:00:00', '2025-09-27 10:00:00'),
(NULL, 'Maria', 'Gomez Paredes', '45678901', '956789012', '2025-09-27 11:00:00', '2025-09-27 11:00:00'),
(NULL, 'Jorge', 'Sanchez Diaz', '56789012', '978901234', '2025-09-27 12:00:00', '2025-09-27 12:00:00');

-- =========================
-- PSICÓLOGOS
-- =========================
INSERT INTO psicologos (id, nombres, apellidos, dni, telefono, created_at, updated_at)
VALUES
(NULL, 'Carmen', 'Valdez Soto', '67890123', '945612378', '2025-09-27 13:00:00', '2025-09-27 13:00:00'),
(NULL, 'Ricardo', 'Mendoza Torres', '78901234', '956123789', '2025-09-27 14:00:00', '2025-09-27 14:00:00'),
(NULL, 'Elena', 'Morales Rivas', '89012345', '967834561', '2025-09-27 15:00:00', '2025-09-27 15:00:00'),
(NULL, 'Gabriel', 'Chavez Flores', '90123456', '978345612', '2025-09-27 16:00:00', '2025-09-27 16:00:00'),
(NULL, 'Patricia', 'Cruz Salas', '01234567', '989456123', '2025-09-27 17:00:00', '2025-09-27 17:00:00');

-- =========================
-- DOCENTES
-- =========================
INSERT INTO docentes (id, nombres, apellidos, dni, telefono, created_at, updated_at)
VALUES
(NULL, 'Oscar', 'Huaman Peña', '11223344', '912398765', '2025-09-27 18:00:00', '2025-09-27 18:00:00'),
(NULL, 'Rosa', 'Carrillo Vela', '22334455', '923987651', '2025-09-27 19:00:00', '2025-09-27 19:00:00'),
(NULL, 'Pedro', 'Lopez Medina', '33445566', '934126589', '2025-09-27 20:00:00', '2025-09-27 20:00:00'),
(NULL, 'Lucia', 'Salazar Rojas', '44556677', '945612398', '2025-09-27 21:00:00', '2025-09-27 21:00:00'),
(NULL, 'Diego', 'Reyes Campos', '55667788', '956781234', '2025-09-27 22:00:00', '2025-09-27 22:00:00');

-- =========================
-- USUARIOS
-- =========================
INSERT INTO usuarios (correo_institucional, username, userpass, docente_id, psicologo_id, administrador_id, rol, created_at, updated_at)
VALUES
-- ADMINISTRADORES
('carlos.ramirez@instituto.edu', 'carlosr', '$2y$10$Uq9O19j3wGY0dS6fU6gC0u/8K7aWZCkFYHAcJIkAMhafqWpOSBdO.', NULL, NULL, 1, 'ADMIN', '2025-09-27 08:00:00', '2025-09-27 08:00:00'),
('ana.torres@instituto.edu', 'anatorres', '$2y$10$Uq9O19j3wGY0dS6fU6gC0u/8K7aWZCkFYHAcJIkAMhafqWpOSBdO.', NULL, NULL, 2, 'ADMIN', '2025-09-27 09:00:00', '2025-09-27 09:00:00'),
('luis.fernandez@instituto.edu', 'luisf', '$2y$10$Uq9O19j3wGY0dS6fU6gC0u/8K7aWZCkFYHAcJIkAMhafqWpOSBdO.', NULL, NULL, 3, 'ADMIN', '2025-09-27 10:00:00', '2025-09-27 10:00:00'),
('maria.gomez@instituto.edu', 'mariag', '$2y$10$Uq9O19j3wGY0dS6fU6gC0u/8K7aWZCkFYHAcJIkAMhafqWpOSBdO.', NULL, NULL, 4, 'ADMIN', '2025-09-27 11:00:00', '2025-09-27 11:00:00'),
('jorge.sanchez@instituto.edu', 'jorges', '$2y$10$Uq9O19j3wGY0dS6fU6gC0u/8K7aWZCkFYHAcJIkAMhafqWpOSBdO.', NULL, NULL, 5, 'ADMIN', '2025-09-27 12:00:00', '2025-09-27 12:00:00'),

-- PSICÓLOGOS
('carmen.valdez@instituto.edu', 'cvaldez', '$2y$10$Uq9O19j3wGY0dS6fU6gC0u/8K7aWZCkFYHAcJIkAMhafqWpOSBdO.', NULL, 1, NULL, 'PSICOLOGO', '2025-09-27 13:00:00', '2025-09-27 13:00:00'),
('ricardo.mendoza@instituto.edu', 'rmendoza', '$2y$10$Uq9O19j3wGY0dS6fU6gC0u/8K7aWZCkFYHAcJIkAMhafqWpOSBdO.', NULL, 2, NULL, 'PSICOLOGO', '2025-09-27 14:00:00', '2025-09-27 14:00:00'),
('elena.morales@instituto.edu', 'emorales', '$2y$10$Uq9O19j3wGY0dS6fU6gC0u/8K7aWZCkFYHAcJIkAMhafqWpOSBdO.', NULL, 3, NULL, 'PSICOLOGO', '2025-09-27 15:00:00', '2025-09-27 15:00:00'),
('gabriel.chavez@instituto.edu', 'gchavez', '$2y$10$Uq9O19j3wGY0dS6fU6gC0u/8K7aWZCkFYHAcJIkAMhafqWpOSBdO.', NULL, 4, NULL, 'PSICOLOGO', '2025-09-27 16:00:00', '2025-09-27 16:00:00'),
('patricia.cruz@instituto.edu', 'pcruz', '$2y$10$Uq9O19j3wGY0dS6fU6gC0u/8K7aWZCkFYHAcJIkAMhafqWpOSBdO.', NULL, 5, NULL, 'PSICOLOGO', '2025-09-27 17:00:00', '2025-09-27 17:00:00'),

-- DOCENTES
('oscar.huaman@instituto.edu', 'ohuaman', '$2y$10$Uq9O19j3wGY0dS6fU6gC0u/8K7aWZCkFYHAcJIkAMhafqWpOSBdO.', 1, NULL, NULL, 'DOCENTE', '2025-09-27 18:00:00', '2025-09-27 18:00:00'),
('rosa.carrillo@instituto.edu', 'rcarrillo', '$2y$10$Uq9O19j3wGY0dS6fU6gC0u/8K7aWZCkFYHAcJIkAMhafqWpOSBdO.', 2, NULL, NULL, 'DOCENTE', '2025-09-27 19:00:00', '2025-09-27 19:00:00'),
('pedro.lopez@instituto.edu', 'plopez', '$2y$10$Uq9O19j3wGY0dS6fU6gC0u/8K7aWZCkFYHAcJIkAMhafqWpOSBdO.', 3, NULL, NULL, 'DOCENTE', '2025-09-27 20:00:00', '2025-09-27 20:00:00'),
('lucia.salazar@instituto.edu', 'lsalazar', '$2y$10$Uq9O19j3wGY0dS6fU6gC0u/8K7aWZCkFYHAcJIkAMhafqWpOSBdO.', 4, NULL, NULL, 'DOCENTE', '2025-09-27 21:00:00', '2025-09-27 21:00:00'),
('diego.reyes@instituto.edu', 'dreyes', '$2y$10$Uq9O19j3wGY0dS6fU6gC0u/8K7aWZCkFYHAcJIkAMhafqWpOSBdO.', 5, NULL, NULL, 'DOCENTE', '2025-09-27 22:00:00', '2025-09-27 22:00:00');
