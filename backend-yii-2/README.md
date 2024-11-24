# Configuración

## Dependencias
Luego de descargar el proyecto es indispensable instalar las dependencias
```
composer install
```

## Base de datos

Renombrar el archivo `config/db.example.php` como `config/db.php` y modificarlo con datos reales:

```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=blog_yii_2',
    'username' => 'admin',
    'password' => 'Admin.123456',
    'charset' => 'utf8',
];
```

## Ejecutar el servidor

Una vez hecho esto, dentro del directorio podemos ejecutar el servidor de PHP.
```
php yii serve --port=8888
```



# Endpoints

```
GET /categorias: una lista de todos los categorías página por página;
POST /categorias: crea un nuevo categoría;
GET /categorias/123: devuelve los detalles del categoría 123;
PATCH /categorias/123 y PUT /categorias/123: actualiza el categoría 123;
DELETE /categorias/123: elimina el categoría 123;
```

## Json Endpoints

Crear/Actualizar Categoría

```json
{
    "nombre": "Categoría 2 actualizada"
}
```

Crear/Actualizar Noticia

```json
{
    "titulo": "Noticia 1",
    "detalle": "nueva noticia",
    "categoria_id": 1
}
```

# Notas importantes

Para que funcione cada endpoint debe definirse la ruta en el archivo `config/web.php`

````php
'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                ['class' => 'yii\rest\UrlRule', 'controller' => 'categoria'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'noticia'],
            ],
        ]
        ```
````

También es importante dentro del mismo archivo permitir peticiones tipo json

```php
'request' => [
    // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
    'cookieValidationKey' => 'I2zaS-tiy069Mi6geizcZ3iAcA75GC2B',
    'parsers' => [
        'application/json' => 'yii\web\JsonParser',
    ]
],
```

### Crear migraciones

```
php yii migrate/create create_categorias_table
php yii migrate/create create_noticias_table
```

### Ejecutar las migraciones

```
php yii migrate
```