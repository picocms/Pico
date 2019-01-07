---
Title: Bienvenido
Description: Pico es un CMS de archivos sencillos, estúpidamente simple y brillantemente rápido.
---

## Bienvenido a Pico

Felicitaciones, ha instalado [Pico][] %version% satisfatoriamente.
%meta.description% <!-- esto se reemplaza por la descripción del encabezado anterior -->

## Creación de contenidos

Pico es un CMS de archivos planos. Esto significa que no hay un panel de administración o una base de datos con la que tratar. Solo crea los archivos `.md` en la carpeta `content` y esos archivos se convertirán en sus páginas. Por ejemplo, al crear un archivo llamado `index.md`, el mismo será mostrado como su página de inicio principal.

Cuando instale Pico, éste viene con algunos contenidos de muestra que se visualizarán hasta que agregue el suyo propio. De forma sencilla, añada algunos archivos `.md` a su carpeta `content` en el directorio raíz de Pico. No se requiere ninguna configuración, por lo que Pico usará automáticamente la carpeta `content` tan pronto como haya creado su propio `index.md`. ¡Sólo eche un vistazo a los [contenidos de muestra de Pico][SampleContents] para un ejemplo!

Si usted crea una carpeta dentro del directorio de contenidos (por ejemplo: `content/sub`) y  coloca un `index.md` dentro de ella, entonces podrá acceder a esa carpeta en la URL `%base_url%?sub`. Si además, desea tener otra página dentro de esa subcarpeta, pues sencillamente haga un archivo de texto con el nombre correspondiente y tendrá acceso a él (por ejemplo: se puede acceder a `content/sub/page.md` desde la URL `%base_url%?sub/page`). A continuación le mostramos algunos ejemplos de diferentes ubicaciones y sus correspondientes URLs:

<table style="width: 100%; max-width: 40em;">
    <thead>
        <tr>
            <th style="width: 50%;">Ubicación física</th>
            <th style="width: 50%;">URL</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>content/index.md</td>
            <td><a href="%base_url%">/</a></td>
        </tr>
        <tr>
            <td>content/sub.md</td>
            <td><del>?sub</del> (no es accesible, vea más abajo)</td>
        </tr>
        <tr>
            <td>content/sub/index.md</td>
            <td><a href="%base_url%?sub">?sub</a> (igual que el anterior)</td>
        </tr>
        <tr>
            <td>content/sub/page.md</td>
            <td><a href="%base_url%?sub/page">?sub/page</a></td>
        </tr>
        <tr>
            <td>content/una/muy/larga/url.md</td>
            <td>
              <a href="%base_url%?una/muy/larga/url">?una/muy/larga/url</a>
              (no existe)
            </td>
        </tr>
    </tbody>
</table>

Si no se puede encontrar el archivo, entonces se mostrará el contenido del archivo `content/404.md`. Puede añadir archivos `404.md` a cualquier directorio. Así que, por ejemplo, si desea usar una página de error especial para su blog, sencillamente puede crear `content/blog/404.md`.

Pico separa estrictamente los contenidos de su sitio web (es decir, los archivos Markdown en su directorio `content`) y cómo deben visualizarse dichos contenidos (las plantillas Twig en su directorio `themes`). Sin embargo, no todos los archivos de su directorio `content` tienen que ser una página diferente. Por ejemplo, algunos temas (incluido el tema predeterminado de Pico) usan algunos archivos "ocultos" especiales para administrar los metadatos (como el `_meta.md` en los contenidos de muestra de Pico). Algunos otros temas usan un `_footer.md` para representar los contenidos del pie de página. El punto común sería `_`: todos los archivos y directorios con el prefijo `_` de su caprpeta `content` estarán ocultos. No se podrá acceder a estas páginas desde un navegador web, por lo que Pico mostrará en su lugar una página de error 404.

Como una práctica habitual, le recomendamos que examine los contenidos y activos (como las imágenes, descargas, etc.). Incluso le denegamos el acceso al directorio predefinido `content`. Si desea usar algunos recursos (como por ejemplo una imagen) en uno de sus archivos de contenido, debe agregar una carpeta `assets` en el directorio raíz de Pico y ubicarlos allí. Luego podrá acceder a ellos desde su Markdown usando <code>&#37;base_url&#37;/assets/</code>, por ejemplo: <code>!\[Título de la imagen\](&#37;base_url&#37;/assets/image.png)</code>

### El marcado del archivo de texto

Los archivos de texto utilizan el marcado de [Markdown][] y [Markdown Extra][MarkdownExtra]. También pueden contener HTML regular.

En la parte superior de estos archivos, puede colocar un bloque de comentarios y especificar los atributos de algunos metadatos de la página utilizando [YAML][] (el "encabezado YAML"). Por ejemplo:

    ---
    Title: Bienvenido
    Description: Esta descripción irá en la etiqueta "meta description"
    Author: Joe Bloggs
    Date: 2001-04-25
    Robots: noindex,nofollow
    Template: index
    ---

Estos valores estarán contenidos en la variable `{{ meta }}` de los temas (vea más abajo). Los encabezados meta a veces tienen un significado especial, por ejemplo: Pico no solo pasa el encabezado meta `Date` (fecha), sino que lo evalúa para "entender" realmente cuando fue que se creó esta página. Esto entra en juego cuando se desea ordenar las páginas no solo alfabéticamente, sino también por fecha. Otro ejemplo es el encabezado meta `Template` (plantilla): el mismo controla qué plantilla Twig utilizará Pico para visualizar esta página (por ejemplo: si añade `Template:blog`, entonces Pico usará `blog.twig`).
	
También hay otras variables que puedes usar en tus archivos de texto:

* <code>&#37;site_title&#37;</code> - El título de tu sitio
* <code>&#37;base_url&#37;</code> - La URL de su sitio Pico; los enlaces internos se podrían especificar utilizando  <code>&#37;base_url&#37;?sub/page</code>
* <code>&#37;theme_url&#37;</code> - La URL del tema utilizado actualmente
* <code>&#37;version&#37;</code> - Una cadena de texto indicando la versión actual de Pico (por ejemplo: `2.0.0`)
* <code>&#37;meta.&#42;&#37;</code> - Permite acceder a cualquier variable meta de la página actual, por ejemplo, <code>&#37;meta.author&#37;</code> se reemplaza por `Joe Bloggs`

### Hacer "blogging"

Pico no es un software de blogs, pero hace que sea muy fácil usarlo como tal. Puede encontrar muchos complementos que implementan las características típicas de los blogs como la autenticación, etiquetado, paginación y algunos complementos sociales. Vea la sección de Complementos a continuación para más detalles.

Si desea utilizar Pico como un software de blogs, probablemente desee hacer algo como lo siguiente:

1. Coloque todos los artículos de su blog en una carpeta `blog` dentro de su directorio `content`. Todos estos artículos deben tener un encabezado meta `Date` (fecha).
2. Cree un archivo `blog.md` o `blog/index.md` en la carpeta `content`. Añada `Template: blog-index` al encabezado YAML de esta página. El mismo más adelante mostrará una lista de todos los artículos de su blog (vea el paso 3).
3. Añada una nueva plantilla Twig llamada `blog-post.twig` (la misma debe coincidir con el encabezado meta `Template` del paso 2) en su carpeta de temas. Es probable que esta plantilla no sea muy diferente de la plantilla predefinida `index.twig` (p. ej.: copie  `index.twig`), lo que creará una lista de todos los artículos de su blog. Añada el siguiente fragmento Twig al archivo `blog-index.twig` cerca de `{{ content }}`:
   ```
    {% for page in pages|sort_by("time")|reverse %}
        {% if page.id starts with "blog/" and not page.hidden %}
            <div class="post">
                <h3><a href="{{ page.url }}">{{ page.title }}</a></h3>
                <p class="date">{{ page.date_formatted }}</p>
                <p class="excerpt">{{ page.description }}</p>
            </div>
        {% endif %}
    {% endfor %}
   ```

## Personalización

Pico es altamente personalizable de dos maneras diferentes: Por un lado, puede cambiar la apariencia de Pico utilizando temas y por otro lado, puede añadir nuevas funcionalidades mediante el uso de complementos. Hacer lo primero incluye modificar el HTML, CSS y JavaScript de Pico, mientras que el último consiste principalmente en programación PHP.

¿Todo esto es griego para usted? Pues, no se preocupe, no tiene que dedicar tiempo a estas charlas técnicas; es muy fácil utilizar uno de los temas diseñados o complementos desarrollados y liberados al público. Por favor, consulte las siguientes secciones para más detalles.

### Temas

Puede crear temas para su instalación de Pico en la carpeta `themes`. Eche un vistazo al tema predefinido para ver un ejemplo. Pico utiliza [Twig][] para renderizar las plantillas. Puede seleccionar su tema configurando la opción `theme` en `config/config.yml` con el nombre de su carpeta de tema.

Todos los temas deben incluir un archivo `index.twig` para definir la estructura HTML del mismo. A continuación se muestran las variables Twig que están disponibles para que puedan ser utilizadas en su tema. Tenga en cuenta que las rutas (p. ej.: `{{ base_dir }}`) y las URL (por ejemplo: `{{ base_url }}` no tienen una barra diagonal.

* `{{ site_title }}` - Acceso directo al título del sitio (vea `config/config.yml`)
* `{{ config }}` - Contiene los valores que configuró en `config/config.yml` (por ejemplo: `{{ config.theme }}` sería `default` - predefinido)
* `{{ base_dir }}` - La ruta al directorio raíz de Pico
* `{{ base_url }}` - La URL de su sitio; utilice el filtro de `link` para especificar los enlaces internos (por ejemplo: `{{ "sub/page"|link }}`), esto garantiza que su enlace funcionará no importa si la URL de reescritura esté habilitada o no
* `{{ theme_dir }}` - La ruta al tema activo actualmente 
* `{{ theme_url }}` - La URL del tema activo actualmente
* `{{ version }}` - Una cadena de texto de la versión actual de Pico (por ejemplo: `2.0.0`)
* `{{ meta }}` - Contiene los valores meta de la página actual
    * `{{ meta.title }}`
    * `{{ meta.description }}`
    * `{{ meta.author }}`
    * `{{ meta.date }}`
    * `{{ meta.date_formatted }}`
    * `{{ meta.time }}`
    * `{{ meta.robots }}`
    * ...
* `{{ content }}` - El contenido de la página actual después de que se haya procesado a través de Markdown
* `{{ pages }}` - Una colección de todas las páginas de contenido de su sitio
    * `{{ page.id }}` - La ruta relativa al archivo de contenido (ID único)
    * `{{ page.url }}` - La URL de la página
    * `{{ page.title }}` - El título de la página (encabezado YAML)
    * `{{ page.description }}` - La descripción de la página (encabezado YAML)
    * `{{ page.author }}` - El autor de la página (encabezado YAML)
    * `{{ page.time }}` - La [La marca de tiempo Unix][UnixTimestamp] derivada del encabezado de fecha `Date`
    * `{{ page.date }}` - La fecha de la página (encabezado YAML)
    * `{{ page.date_formatted }}` - La fecha formateada de la página según lo especificado por el parámetro `date_format` en `config/config.yml`
    * `{{ page.raw_content }}` - El contenido sin procesar y aún no analizado de la página; utilice el filtro de Twig `content` para obtener el contenido analizado de una página al pasarle su ID único (por ejemplo: `{{ "sub/page"|content }}`)
    * `{{ page.meta }}`- Los valores meta de la página (vea `{{ meta }}` más arriba)
    * `{{ page.previous_page }}` - Los datos de la página anterior correspondiente
    * `{{ page.next_page }}` - Los datos de la página siguiente correspondiente
    * `{{ page.tree_node }}` - El nodo de la página en el árbol de páginas de Pico
* `{{ prev_page }}` - Los datos de la página anterior (relativos a `current_page`)
* `{{ current_page }}` - Los datos de la página actual (vea `{{ pages }}` más arriba)
* `{{ next_page }}` - Los datos de la página siguiente (relativos a `current_page`)

Las páginas se pueden utilizar de la siguiente forma:

    <ul class="nav">
        {% for page in pages if not page.hidden %}
            <li><a href="{{ page.url }}">{{ page.title }}</a></li>
        {% endfor %}
    </ul>

Además de utilizar la lista `{{ pages }}`, también puede acceder a las mismas usando el árbol de páginas de Pico. El árbol de páginas le permite recorrer en iteración las páginas del sitio utilizando una estructura de árbol, por lo que puede, por ejemplo, iterar directamente con sólo las páginas hijas. También le permite construir menús recursivos y filtrar páginas más fácilmente. Para ello, consulte la [documentación del árbol de páginas de Pico][FeaturesPageTree] para más detalles.

Para llamar a los recursos (assets) desde su tema, utilice `{{theme_url}}`. Por ejemplo, para incluir un archivo CSS `themes/my_theme/example.css`, añada `<link rel="stylesheet" href="{{ theme_url }}/example.css" type="text/css" />` a su `index.twig`. Esto funciona para cualquier archivo dentro de la carpeta de su tema, incluyendo imágenes y archivos JavaScript.

Además de la extensa lista de filtros, funciones y etiquetas de Twigs, Pico también proporciona filtros adicionales y útiles para facilitar la tematización.

* Pasar un ID único de la página al filtro `link` para devolver la URL de las páginas (por ejemplo: `{{ "sub/page"|link }}` obtiene `%base_url%?sub/page`).
* Obtener el contenido analizado de una página, para esto, pase el ID único al filtro `content` (por ejemplo: `{{ "sub/page"|content }}`).
* Pasar cualquier cadena de texto de Markdown usando el filtro `markdown` (por ejemplo: podría utilizar Markdown en la variable meta `description` y luego pasarla a su tema con `{{ meta.description|markdown }}`). Así mismo puede pasar los metadatos como parámetros para reemplazar los marcadores `%meta.*%` (por ejemplo: `{{ "Escrito *por %meta.author%*"|markdown(meta) }}` producirá "Escrito por *John Doe*").
* Las matrices (arrays) se pueden ordenar por una de sus claves utilizando el filtro `sort_by` filter (por ejemplo: `{% for page in pages|sort_by([ 'meta', 'nav' ]) %}...{% endfor %}` hace una iteración a través de todas las páginas, ordenándolas por el encabezado meta `nav`; tenga en cuenta que la parte `[ 'meta', 'nav' ]` del ejemplo, le indica a Pico que ordene por `page.meta.nav`). Los elementos que no se pudieron ordenar se mueven a la parte inferior de la matriz; puede especificar `bottom` (mover los elementos a la parte inferior; valor predeterminado), `top` (mover los elementos a la parte superior), `keep` (mantener el orden sin cambios) o `remove` (eliminar los elementos) como el segundo parámetro para cambiar este comportamiento.
* Devolver todos los valores claves de la matriz dada utilizando el filtro `map` (por ejemplo: `{{ pages|map("title") }}` devuelve todos los títulos de las páginas).
* Use las funciones `url_param` and `form_param` de Twig para acceder a los parámetros HTTP GET (es decir, a una cadena de texto de consulta a una URL como `?some-variable=my-value`) y HTTP POST (los datos de un formulario enviado). Esto le permite implementar funcionalidades como la paginación, etiquetas y categorías, páginas dinámicas y mucho más, ¡todo con Twig puro! Sencillamente diríjase a nuesra [página de introducción a los parámetros de acceso HTTP][FeaturesHttpParams] para más detalles.

Puede utilizar diferentes plantillas para diferentes archivos de contenido especificando en la mismas el encabezado meta `Template`. Para ello, añada por ejemplo `Template: blog` al encabezado YAML de un archivo de contenido y Pico usará la plantilla `blog.twig` de su carpeta de temas para mostrar la página.

El tema predeterminado de Pico en realidad no está destinado a ser utilizado para un sitio web en producción, sino es más bien un punto de partida para crear su propio tema. Si dicho tema predefinido no es suficiente para usted, y no desea crear el suyo propio, entonces puede usar cualquiera de los temas fabulosos creados por desarrolladores y diseñadores de terceros en el pasado. Al igual que con los complementos, puede encontrar temas en nuestra [Wiki][WikiThemes] y en nuestro [sitio web][OfficialThemes].

### Complementos (plugins)

#### Complementos para los usuarios

Los complementos oficialmente probados se pueden encontrar en http://picocms.org/plugins/, ¡pero hay muchos complementos increíbles de terceros por ahí! Un buen punto de partida para descubrirlos es nuestra [Wiki][WikiPlugins].

Pico hace que sea muy fácil agregar nuevas funciones a su sitio web mediante el uso de complementos. Al igual que Pico, puede instalar complementos utilizando [Composer][] (por ejemplo: `composer require phrozenbyte/pico-file-prefixes`), o manualmente cargando el archivo del complemento (esto solo para complementos pequeños de un solo archivo, por ejemplo: `PicoFilePrefixes.php`) o al directorio de complementos `plugins` (por ejemplo: `PicoFilePrefixes`). Siempre le recomendamos que use Composer cada vez que sea posible, ya que le facilita la actualización de Pico y sus complementos. De todos modos, dependiendo del complemento que desee instalar, es posible que tenga que completar varios pasos (por ejemplo: las variables de configuración para que el complemento funcione). Por lo tanto, siempre debe revisar el archivo `README.md` del complemento para conocer los pasos necesarios.

Los complementos que se escribieron para funcionar con Pico 1.0 y versiones posteriores se pueden habilitar y deshabilitar a través de `config/config.yml`. Si quiere por ejemplo, deshabilitar el complemento `PicoDeprecated` agregue la siguiente línea a su `config/config.yml`: `PicoDeprecated.enabled: false`. Para forzar la activación del complemento, reemplace `false` (falso) por `true` (verdadero).

#### Complementos para los desarrolladores

¿Es un desarrollador de complementos? ¡Pues, los amamos chicos! Puede encontrar toneladas de información sobre cómo desarrollar complementos en http://picocms.org/development/. Si ha desarrollado un complemento anteriormente y desea actualizarlo a Pico 2.0, consulte la [sección de actualización en la documentación][PluginUpgrade].

## Configuración

Configurar Pico realmente es estúpidamente simple: solo cree un `config/config.yml` para anular la configuración predeterminada (y agregue sus propias configuraciones personalizadas). Eche un vistazo a `config/config.yml.template` para conocer los ajustes disponibles y sus valores predefinidos. Para sobreescribir una configuración, sencillamente copie la línea desde `config/config.yml.template` a `config/config.yml` y establezca su valor personalizado.

Pero no nos detengamos allí. En lugar de tener un solo archivo de configuración, puede utilizar un número arbitrario de archivos de configuración. Sencillamente cree un archivo `.yml` en la carpeta `config` de Pico y listo. Esto le permitirá agregar algo de estructura a su configuración, como un archivo de ajustes separado solo para su tema (`config/my_theme.yml`).

Tenga en cuenta que Pico carga estos archivos de una forma especial que deberá conocer. Primero, cargue el archivo de configuración principal `config/config.yml`, y luego cualquier otro archivo `*.yml` en el directorio `config` de Pico en orden alfabético. Este orden de los archivos es crucial, pues los valores de configuración que ya se han establecido, no pueden ser sobrescritos por un archivo subsiguiente. Por ejemplo, si configura `site_title: Pico` en `config/a.yml` y `site_title: ¡Mi grandioso sitio!` en `config/b.yml`, el título de su sitio será "Pico".

Ya que que los archivos YAML son archivos sencillos de texto, los usuarios pueden leer su configuración de Pico navegando a `%base_url%/config/config.yml`. Esto no es un problema en primer lugar, pero podría serlo si se utilizan complementos que requieren que almacene datos de seguridad en la configuración (como las credenciales). Por lo tanto, *siempre* debe asegurarse de configurar su servidor web para denegar el acceso al directorio `config`. Para ello consulte la [sección "Reescritura de URLs"] a continuación. Al seguir dichas instrucciones, no solo habilitará la reescritura de URLs, sino que también denegará el acceso al directorio `config` de Pico.

### Reescritura de URLs

Las URLs predefinidas de Pico (por ejemplo: %base_url%/?sub/page) ya son muy amistosas al usuario. Además, Pico le ofrece una función de reescritura de URLs que las hace aún más amistosas de usar (por ejemplo: %base_url%/sub/page). A continuación, encontrará información básica sobre cómo configurar su servidor web para habilitar la reescritura de URLs.

#### Apache

Si está utilizando un servidor web Apache, la reescritura de URLs debe estar habilutada - pruébelo usted mismo, haga click en la [segunda URL](%base_url%/sub/page). Si dicha reescritura no funciona (recibe un mensaje de error de Apache `404 Not Found`), asegúrese de habilitar el [módulo `mod_rewrite`][ModRewrite] y de habilitar la opción de sobreescribir `.htaccess`. Debe ajustar la [directiva `AllowOverride`][AllowOverride] a `AllowOverride All` en el archivo de configuración de su host virtual o de forma global en `httpd.conf`/`apache.conf`. Asumiendo que la reescritura de URLs funcione y Pico aún no muestre dichas URLs, deberá forzar la reescritura de URLs configurando `rewrite_url: true` en `config/config.yml`. Si luego de ello, sigue obteniendo un `500 Internal Server Error` sin importar lo que haga, intente eliminar la directiva `Options` del archivo `.htaccess` de Pico (en la última línea).

#### Nginx

Si está utilizando Nginx, puede usar la siguiente configuración para habilitar la reescritura de URLs (líneas `5` a `8`) y denegar el acceso a los archivos internos de Pico (líneas `1` a `3`). Deberá ajustar la ruta (`/pico` en las líneas `1`, `2`, `5` y `7`) para que coincida con su directorio de instalación. Además, deberá habilitar `rewriting_url: true` en su `config/config.yml`. La configuración de Nginx debe proporcionar el *mínimo necesario* para utilizar Pico. Nginx es un tema muy extenso, por lo que si tiene algún problema, consulte la [documentación de configuración de Nginx][NginxConfig].

```
location ~ ^/pico/((config|content|vendor|composer\.(json|lock|phar))(/|$)|(.+/)?\.(?!well-known(/|$))) {
    try_files /pico/index.php$is_args$args =404;
}

location /pico/ {
    index index.php;
    try_files $uri $uri/ /pico/index.php$is_args$args;
}
```

#### Lighttpd

Pico se ejecuta sin problemas en Lighttpd. Puede usar la siguiente configuración para habilitar la reescritura de URLs (líneas `6` a `9`) y denegar el acceso a los archivos internos de Pico (líneas `1` a `4`). Asegúrese de ajustar la ruta (`/pico` en las líneas `2`, `3` y `7`) para que coincida con su directorio de instalación, e informe a Pico sobre la reescritura de URLs disponible configurando `rewrite_url: true` en su `config/config.yml`. La siguiente configuración debe proporcionar el *mínimo que necesita* para usar Pico.

```
url.rewrite-once = (
    "^/pico/(config|content|vendor|composer\.(json|lock|phar))(/|$)" => "/pico/index.php",
    "^/pico/(.+/)?\.(?!well-known(/|$))" => "/pico/index.php"
)

url.rewrite-if-not-file = (
    "^/pico(/|$)" => "/pico/index.php"
)
```

## Documentación

Para obtener más ayuda eche un vistazo a la documentación de Pico en http://picocms.org/docs.

[Pico]: http://picocms.org/
[SampleContents]: https://github.com/picocms/Pico/tree/master/content-sample
[Markdown]: http://daringfireball.net/projects/markdown/syntax
[MarkdownExtra]: https://michelf.ca/projects/php-markdown/extra/
[YAML]: https://en.wikipedia.org/wiki/YAML
[Twig]: http://twig.sensiolabs.org/documentation
[UnixTimestamp]: https://en.wikipedia.org/wiki/Unix_timestamp
[Composer]: https://getcomposer.org/
[FeaturesHttpParams]: http://picocms.org/in-depth/features/http-params/
[FeaturesPageTree]: http://picocms.org/in-depth/features/page-tree/
[WikiThemes]: https://github.com/picocms/Pico/wiki/Pico-Themes
[WikiPlugins]: https://github.com/picocms/Pico/wiki/Pico-Plugins
[OfficialThemes]: http://picocms.org/themes/
[PluginUpgrade]: http://picocms.org/development/#upgrade
[ModRewrite]: https://httpd.apache.org/docs/current/mod/mod_rewrite.html
[AllowOverride]: https://httpd.apache.org/docs/current/mod/core.html#allowoverride
[NginxConfig]: http://picocms.org/in-depth/nginx/
