# Proyecto MACUIN Autopartes

Este proyecto contiene la infraestructura completa para los portales de MACUIN Autopartes, incluyendo:
- **Laravel (Frontend Extranet)** para clientes externos.
- **Flask (Dashboard Interno)** para el personal administrativo.
- **PostgreSQL** como base de datos centralizada y normalizada.

Todo el proyecto está orquestado con **Docker Compose** para asegurar que el entorno de desarrollo sea idéntico en cualquier computadora.

---

## 🚀 Requisitos Previos

Lo único que necesitas tener instalado en tu computadora es:
- **[Docker Desktop](https://www.docker.com/products/docker-desktop/)** (Asegúrate de que esté abierto y ejecutándose antes de iniciar).

---

## 🛠️ Instrucciones de Instalación y Ejecución

Sigue estos 3 sencillos pasos para levantar el proyecto:

1. **Abre una terminal** (Símbolo del sistema, PowerShell, o la terminal de VS Code) y navega hasta la carpeta principal del proyecto:
   ```bash
   cd ruta/hacia/Trabajo Proyecto Ivan
   ```

2. **Ejecuta el siguiente comando** para construir las imágenes y levantar los contenedores en segundo plano:
   ```bash
   docker compose up -d --build
   ```
   *(La primera vez que lo ejecutes puede tardar unos minutos en descargar las imágenes base de PHP, Python y PostgreSQL, así como en instalar las dependencias de los contenedores).*

3. ¡Listo! **Abre tu navegador web** y accede a las aplicaciones:

   - 🛒 **Portal de Clientes (Laravel):**  
     [http://localhost:8000](http://localhost:8000)
     
   - 📊 **Dashboard Administrativo (Flask):**  
     [http://localhost:5000](http://localhost:5000)

---

## 🔑 Credenciales de Acceso (Modo Desarrollo/Mockups)

Dado que las interfaces actualmente están en una fase de maquetación (Mockups estáticos):
- **Inicio de Sesión:** Puedes ingresar **cualquier correo y cualquier contraseña** en los formularios de login, ambos sistemas te permitirán el acceso para que puedas navegar por las vistas.

## 🗄️ Acceso a la Base de Datos

Si necesitas conectarte a la base de datos PostgreSQL utilizando algún cliente (como DBeaver, pgAdmin, o Datagrip), usa los siguientes datos:

- **Host:** `localhost`
- **Puerto:** `5432`
- **Base de Datos:** `proyectodb`
- **Usuario:** `proyectouser`
- **Contraseña:** `proyectopassword`

*(La base de datos se inicializa automáticamente con la estructura de tablas relacionales gracias al script `database/init.sql`).*

---

## 🛑 Detener el Proyecto

Cuando termines de trabajar y quieras detener los contenedores (para liberar recursos en tu computadora), ejecuta el siguiente comando en la misma carpeta del proyecto:

```bash
docker compose down
```
