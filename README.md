# NASA DONKI API Integration

Este proyecto es una integración con la API de DONKI de la NASA, desarrollada en Laravel. Proporciona varias rutas RESTful para consultar instrumentos y actividades relacionadas.

## Requisitos del sistema

- PHP >= 8.1
- Laravel 11.3.3
- Composer >= 2.0
- PostgreSQL o MySQL
- cURL habilitado

## Instalación

1. Clona el repositorio:
   ```bash
   git clone https://github.com/tu-usuario/nasa-donki-api.git
   cd nasa-donki-api
   ```
2. Instala las dependencias con Composer:
      ```bash
         composer install
      ```

3. Configura el archivo .env: Copia el archivo .env.example y configúralo:
      ```bash
         cp .env.example .env
      ```
4. Genera la clave de la aplicación:
     ```bash
         php artisan key:generate
      ```
5. Levanta el servidor local:
     ```bash
         php artisan serve --port=8080
      ```
 
## Arquitectura del proyecto
- Controladores: Manejan las solicitudes de las rutas REST.
- Servicios: Encapsulan la lógica para conectarse a la API de NASA.
- Interfaces: Aseguran que los servicios cumplan con la arquitectura definida.

## Colección de Postman
El archivo thunder-collection_postman_NASA API PROJECT.json contiene las consultas para probar el proyecto. Importa este archivo en Postman para facilitar las pruebas.
