# DateLuca

Plataforma chilena donde los creadores de contenido reciben donaciones en "Lucas" de parte de su comunidad.

## Requisitos previos

- PHP 8.2 o superior
- Composer
- Node.js 18 o superior
- npm

## Instalación

### Opción A (recomendada): un solo comando

```bash
git clone https://github.com/ClaudioBalmore/DateLuca.git
cd DateLuca
composer setup
```

Este comando instala todas las dependencias PHP y Node, crea el archivo `.env`, genera la clave de la app, ejecuta las migraciones y compila el frontend.

### Opción B: paso a paso

**1. Clonar el repositorio:**

```bash
git clone https://github.com/ClaudioBalmore/DateLuca.git
cd DateLuca
```

**2. Instalar dependencias PHP:**

```bash
composer install
```

**3. Crear el archivo de entorno:**

Linux / macOS:
```bash
cp .env.example .env
```

Windows (PowerShell):
```powershell
Copy-Item .env.example .env
```

**4. Generar la clave de la aplicación:**

```bash
php artisan key:generate
```

**5. Instalar dependencias frontend:**

```bash
npm install
```

**6. Ejecutar las migraciones** (ver sección más abajo).

## Configuración del .env

El proyecto usa SQLite por defecto, no requiere instalar ningún motor de base de datos adicional.

Las únicas variables que necesitas revisar son:

```env
APP_NAME=DateLuca
APP_ENV=local
APP_KEY=        # Se genera automáticamente con php artisan key:generate
APP_DEBUG=true

# APP_URL debe coincidir con la dirección donde corre el servidor local.
# Si usas php artisan serve, el valor correcto es:
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=sqlite
# No se requieren más variables para SQLite.
```

> **Nota sobre APP_URL:** este valor no es fijo, depende del puerto que use tu servidor local. `php artisan serve` usa `127.0.0.1:8000` por defecto. Si cambias el puerto (por ejemplo con `--port=8080`), debes actualizar este valor en consecuencia.

Si prefieres usar MySQL en lugar de SQLite, reemplaza la sección de base de datos:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=dateluca
DB_USERNAME=root
DB_PASSWORD=
```

## Migraciones

Ejecutar todas las migraciones:

```bash
php artisan migrate
```

Revisar el estado de las migraciones:

```bash
php artisan migrate:status
```

Reiniciar la base de datos desde cero (solo desarrollo):

```bash
php artisan migrate:fresh
```

## Correr el servidor

Comando recomendado (levanta el servidor, la queue y Vite juntos):

```bash
composer dev
```

O en terminales separadas:

```bash
php artisan serve
```

```bash
npm run dev
```

## Entregables

- Repositorio: https://github.com/ClaudioBalmore/DateLuca
- Video demo en YouTube: _(agregar URL al momento de enviar)_
