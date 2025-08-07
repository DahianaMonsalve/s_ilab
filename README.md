# 🧪 Supplies iLab – Sistema de gestión de insumos de laboratorio 🧪

**Supplies iLab** es un proyecto web orientado a la gestión eficiente de insumos, inventarios, proveedores y alertas en entornos de laboratorio. Este sistema fue desarrollado como parte del componente de formación para adquirir el título de tecnóloga en análisis y desarrollo de software. Aquí, aplicamos principios de usabilidad, semántica HTML y diseño CSS responsivo, además de gestión de bases de datos con MySQL e integración con PHP para lograr una conexión entre el Frontend y Backend.

## ✔ Propósito del proyecto ✔

El objetivo principal del proyecto es facilitar el registro, consulta y control de insumos de laboratorio mediante un conjunto de vistas claras, organizadas y adaptadas a distintos dispositivos, donde el control y manejo de insumos sea lo más simple posible y se alinee con normativas como la ISO 17025: 2017. 

##  Vistas incluidas

- `1-login.php` → Acceso inicial al sistema
- `2-dashboard.php` → Dashboard del sistema
- `3-crear-usuario.php` → Registro de nuevos usuarios  
- `4-ver-usuario.php` → Visualización y edición de usuarios  
- `5-crear-inventario.php` → Creación de inventarios   
- `6-ver-inventario.php` → Listado de inventarios creados  
- `7-crear-insumo.php` → Captura completa de insumos  
- `8-ver-insumo.php` → Tabla de insumos   
- `9-crear-proveedor.php` → Registro de proveedores  
- `10-ver-proveedor.php` → Consulta de proveedores existentes  
- `11-ver-alertas.php` → Alertas por vencimiento o stock bajo  
- `12-reportes.php` → Filtros para reportes visuales o PDF
- `13-resultado-reporte.php` → Reportes visuales o PDF
- `14-acceso-denegado.php` → Pantalla de acceso denegado según rol

> Cada vista está acompañada por su respectivo archivo `.css` para un diseño visual coherente, limpio y responsivo.

##  Características visuales

- Diseño con colores suaves y tipografía legible  
- Organización modular por componentes PHP   
- Tablas y formularios organizados para claridad visual  
- Adaptación a móviles mediante media queries CSS 
- Emojis intuitivos para acciones como editar, eliminar o archivar

## Backend
Para cada una de las acciones que tuviese cada una de las pantallas, se desarrollo un controlador que permitiera realizar la acción, dichos controladores están nombrados según a la pantalla que corresponden, con su acción seguido de backend para dar mayor orden y coherencia al flujo de trabajo en la integración de cada uno de los módulos en el software. Ejemplo 
- `3-crear_usuario_backend.php` → Creación de nuevos usuarios en la vista 3
- `4-archivar_usuario_backend.php` → Archivado de usuarios en la vista 4
- `4-editar_usuario_backend.php` → Edición de usuarios en la vista 4
- `4-eliminar_usuario_backend.php` → Eliminación de usuarios en la vista 4

Adicionalmente, el sistema cuenta con validaciones básicas a la hora de ingresar al sistema, como verificación de usuario y contraseña, así mismo en el módulo de inventario valida componentes lógicos como cantidad de envases mayor a 1, stock mínimo mayor a 1, así como la fecha de vencimiento no puede ser anterior al día de registro del insumo.

También exise una validación por rol, en donde se redireccionan vistas cuando el usuario tiene cierto rol, esto permite proteger algunas funciones que son exclusivas por parte de la administración del software.

Este sistema fue desarrollado por mí, Dahiana Monsalve, como parte del proceso de formación en en análisis y desarrollo de software. Combina creatividad visual con lógica funcional, y sirve como base para futuras integraciones con diferentes tecnologías como JavaScript, React.

Si deseas probar cada vista, descarga el proyecto, abre los archivos .php en tu navegador y explora la navegación entre módulos. Supplies iLab está pensado para adaptarse a la realidad de un laboratorio y cada componente fue diseñado con precisión y mucho cariño técnico.

Para mayor información del software, puede ingresar al siguiente enlace: https://youtu.be/rFrY20JkCio?si=HcGZKerm-PMmVaNW donde explico las tecnologías usadas, el desarrollo backend, frontend, las falencias encontradas y futuras mejoras del software. 

Gracias por tu atención, espero sea de tu agrado mi proyecto.
