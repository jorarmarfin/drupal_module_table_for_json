
# Table to Json

## Descripción
El módulo "Table to Json" usa una tabla de la db de drupal y la expone en json paginado por la ruta /table_from_json/data/{page}.
## Requisitos
Este módulo ha sido desarrollado para Drupal 9.x. y 10.x. Asegúrate de que tu sistema cumpla con los siguientes requisitos:
- Drupal 9.x o 10.x
- PHP 7.3 o superior

## Instalación
1. Descarga el módulo desde la página de Drupal o clona este repositorio en tu directorio de módulos (`/modules`):
   ```
   require jorarmarfin/table_from_json
   ```
2. Activa el módulo a través de la interfaz de usuario de Drupal en Extend, o utilizando Drush:
   ```
   drush en table_from_json
   ```

## Uso
Para convertir una tabla HTML a JSON:
1. Asegúrate de registrar la tabla en configuración.
2. Ve a la configuración del módulo en la sección de configuraciones de Drupal y especifica el selector CSS de la tabla que deseas convertir.
3. Utiliza la función proporcionada por el módulo para obtener el JSON o accede a través de una URL específica si se configura de esta manera.


## Contribución
Las contribuciones son bienvenidas. Si deseas contribuir al proyecto, por favor clona el repositorio y envía tus pull requests, o reporta problemas en el tracker de issues.

## Licencia
Este proyecto está licenciado bajo la Licencia Pública General de GNU, versión 2.