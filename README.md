## comando para iniciar el proyecto

### Crear las migraciones
- php spark make:migration CreateCiSessionsTable
- php spark make:migration CreateUsuariosTable

### Ejecutar las migraciones
- php spark migrate

### Crear un seeder:
- php spark make:seeder UsuarioSeeder

### Ejecutar un seeder:
- php spark db:seed DatabaseSeeder


### Revertir migraciones

- con el comando `php spark migrate:status` podemos verificar en que paso se creó cada migración
```
+-----------+-------------------+--------------------------------+---------+---------------------+-------+
| Namespace | Version           | Filename                       | Group   | Migrated On         | Batch |
+-----------+-------------------+--------------------------------+---------+---------------------+-------+
| App       | 2025-10-17-050650 | CreateCiSessionsTable          | default | 2025-10-19 23:23:58 | 1     |
| App       | 2025-10-17-051806 | CreateEstadosCivilesTable      | default | 2025-10-19 23:23:58 | 1     |
| App       | 2025-10-17-065219 | CreateViewDerivacionesFullInfo | default | 2025-10-19 23:23:58 | 1     |
| App       | 2025-10-17-065304 | CreateViewUsuarioFullInfo      | default | 2025-10-19 23:23:58 | 1     |
| App       | 2025-10-22-040619 | CreateConfiguracionesTable     | default | 2025-10-22 04:08:00 | 2     |
| App       | 2025-10-23-040607 | Add2faFieldsToUsuariosTable    | ---     | ---                 | ---   |
+-----------+-------------------+--------------------------------+---------+---------------------+-------+
```

Por ejemplo, aqui podemos ver que cuatro migraciones se hicieron en el paso 1 y una migración que se hizo en el paso 2,
si quisieramos revetir solo la migración del paso 2, basta con retroceder un paso, podemos hacer eso con el comando:
```
php spark migrate:rollback --step=1
```
Podemos indicar la cantidad de pasos.