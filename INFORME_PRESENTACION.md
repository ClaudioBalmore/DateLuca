# Informe De Presentacion - DateLuca

## 1. Resumen ejecutivo

DateLuca es una plataforma web donde creadores publican un perfil publico y reciben apoyo en "Lucas" por parte de su comunidad.

Objetivo de negocio del MVP:

- Permitir registro y autenticacion.
- Entregar una URL publica por creador (`/@slug`).
- Permitir gestion de links del creador.
- Permitir donaciones desde perfil publico con validaciones y pago simulado.
- Guardar y mostrar donaciones en el panel del creador.

## 2. Alcance implementado

- Landing comercial en pagina inicial.
- Registro/login de usuarios.
- Perfil con nombre, slug, foto y bio.
- Manejo de links (crear, editar, eliminar) desde modal.
- Sistema de donaciones en perfil publico:
  - Solo disponible para visitantes no dueños del perfil.
  - Flujo en 2 pasos: datos de donacion y pago simulado.
  - Reglas de validacion de formulario y backend.
  - Persistencia en base de datos.
  - Actualizacion de panel con historico de donaciones.

## 3. Arquitectura tecnica

**Backend:**

- Laravel 12 como framework principal.
- Rutas web con Inertia para render de vistas Vue.
- Controladores dedicados para links y donaciones.
- Request object para validaciones del flujo publico de donacion.

**Frontend:**

- Vue 3 con componentes por responsabilidad.
- Inertia para navegacion y formularios server-driven.
- Modal reusable para consistencia UX en links y donaciones.
- Componentes separados para pasos del flujo de pago simulado.

**Datos:**

- Tabla `users` para cuentas.
- Tabla `links` asociada al usuario.
- Tabla `donations` asociada al usuario receptor.

## 4. Reglas de negocio relevantes

- Cada Luca equivale a CLP$1.000.
- Rango permitido: 1 a 100 Lucas por donacion.
- Mensaje opcional de maximo 50 caracteres.
- Si el donante esta autenticado, se usa su nombre de cuenta.
- Si es invitado, debe ingresar nombre manualmente.
- El dueño del perfil no puede donarse a si mismo.

Validaciones de pago simulado:

- Numero de tarjeta: 16 digitos numericos.
- Vencimiento: formato MM/AA.
- CVV: 3 digitos.

