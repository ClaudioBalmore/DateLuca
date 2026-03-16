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

## 5. Como explicar el codigo en la grabacion

**Seccion rutas** (`routes/web.php`):

- Mostrar que `GET /@{slug}` carga el perfil publico y su informacion.
- Mostrar que `POST /@{slug}/donations` recibe la donacion publica.

**Seccion backend:**

- Explicar `DonationsController@storeFromPublicProfile`:
  - Busca dueño del perfil por slug.
  - Bloquea autodonacion.
  - Calcula monto con regla 1 Luca = CLP$1.000.
  - Guarda donacion y redirige al perfil.
- Explicar `StorePublicDonationRequest` y sus validaciones.

**Seccion frontend:**

- Explicar `Dashboard.vue` como orquestador de panel y modales.
- Explicar `DonateLucasModal.vue` y estados de pasos (details / payment / success).
- Explicar `DonationDetailsStep.vue` y `DonationPaymentStep.vue`.
- Explicar `Modal.vue` como componente reutilizable de transiciones.

**Seccion testing:**

- Mostrar `PublicDonationTest` con 4 escenarios:
  - Donacion invitado.
  - Donacion usuario autenticado (nombre tomado de la cuenta).
  - Bloqueo de autodonacion.
  - Validaciones de pago y limites de campos.

## 6. Guion sugerido para video (12-15 min)

### 0:00 - 0:45 | Intro

- Presentarte brevemente.
- Explicar objetivo del proyecto y stack (Laravel + Vue + Inertia).

### 0:45 - 2:00 | Instalacion y puesta en marcha

- Mostrar README con pasos de instalacion.
- Ejecutar en vivo: `composer setup` y `composer dev`.
- Mencionar SQLite por defecto, sin necesidad de configurar base de datos externa.

### 2:00 - 4:30 | Arquitectura

- Mostrar estructura general:
  - `app/Http/Controllers`
  - `app/Http/Requests`
  - `resources/js/Pages`
  - `resources/js/Components`
  - `database/migrations`
- Explicar por que se separaron modal y pasos de donacion en componentes distintos.

### 4:30 - 9:30 | Demo funcional de punta a punta

Orden sugerido:

1. Entrar a la landing.
2. Registrar usuario creador.
3. Ir al perfil publico (`/@slug`).
4. Abrir modal de links y crear un link.
5. Abrir perfil como visitante y ejecutar donacion completa.
6. Mostrar panel actualizado con nueva donacion.
7. Intentar donar desde el propio perfil y mostrar el bloqueo.

### 9:30 - 11:00 | Validaciones

- Probar errores de formulario:
  - Lucas fuera de rango (0 o mas de 100).
  - Tarjeta invalida.
  - CVV invalido.
  - Mensaje con mas de 50 caracteres.

### 11:00 - 12:30 | Testing automatizado

- Ejecutar en terminal:

```bash
php artisan test --filter=PublicDonationTest
```

- Mostrar los 4 tests en verde.

### 12:30 - 14:00 | Cierre

- Resumir decisiones tecnicas tomadas.
- Mencionar mejoras futuras: pagos reales, dashboard con estadisticas, notificaciones al creador.

## 7. Checklist antes de grabar

- `php artisan test` en verde.
- `npm run build` sin errores.
- Base de datos limpia con `php artisan migrate:fresh`.
- Tener un usuario creador registrado para la demo.
- README visible y correcto en el repositorio.

## 8. Checklist de envio final

- Link del repositorio: https://github.com/ClaudioBalmore/DateLuca
- Link del video en YouTube: _(pegar URL final aqui antes de enviar)_

## 9. Preguntas tipicas del evaluador

**¿Por que separar validaciones en frontend y backend?**
Frontend entrega feedback inmediato al usuario. Backend garantiza la integridad y seguridad de los datos independientemente del cliente.

**¿Como aseguras las reglas de negocio criticas?**
Con un Request object tipado en Laravel, restricciones adicionales en el controller y tests feature que cubren los cases limite.

**¿Como escalarias este MVP?**
Integrando una pasarela de pago real, agregando un dashboard con estadisticas de donaciones y notificaciones por email al creador cuando recibe una Luca.
