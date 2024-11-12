<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## Acerca de este proyecto

Este proyecto trata de cumplir todos los requerimientos iniciales de un proyecto Laravel para realizar reservas de salas en un Cowork.

Algunos puntos a tener en cuenta:
- Actualmente cuenta con 2 roles: Admin y cliente.
- Cuenta con seeds para agregar 3 usuarios: 1 admin, y 2 users de pruebas.
- Usuarios: admin@example.com, test@example.com, test2@example.com
- El password de todos los usuarios es: password
- Abajo paso algunas instrucciones para levantar el proyecto con Sail.

## Instrucciones

- Tener instalado y corriendo docker. Si tienes windows debes tener wsl2 con distro(Ej.: Ubuntu)
- En la raíz del proyecto ejecutar: ./vendor/bin/sail up
- Importante: Migrar con seeds: ./vendor/bin/sail artisan migrate --seed
- npm install
- npm run dev
