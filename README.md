# Nombre del Proyecto

Descripción corta del proyecto y su propósito.

## Tecnologías Utilizadas

- PHP v8.2
- Laravel Framework v10
- MySQL (o MariaDB)
- Guzzle HTTP para la integración con la API de Giphy
- Laravel Passport para la autenticación OAuth2.0
- PHPUnit para pruebas unitarias
- UML para la documentación de diseño
- Docker para la contenerización de la aplicación

## Requisitos del Sistema

Asegúrate de tener instalado lo siguiente antes de iniciar la configuración del proyecto:

- PHP >= 8.2
- Composer
- Docker
- Git

## Instalación y Configuración

1. Clona el repositorio:

```bash
git clone https://github.com/fkronhaus/giphy
```

2. Edita el archivo hosts
Windows
Linux/MacOs
127.0.0.1       giphyapi.com

2. Inicia el Contenedor
```
docker-compose up
```

La llave de Giphy está en version developer, por lo que tiene limitaciones de uso.
