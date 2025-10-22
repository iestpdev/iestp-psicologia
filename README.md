## comando para iniciar el proyecto

### Crear las migraciones
- php spark make:migration CreateCiSessionsTable
- php spark make:migration CreateUsuariosTable

### Ejecutar las migraciones
- php spark migrate

### Crear un seeder:
- php spark make:seeder UsuarioSeeder

### Ejecutar un seeder:
- php spark db:seed UsuarioSeeder