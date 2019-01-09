Pico
====

[![Licencia](https://picocms.github.io/badges/pico-license.svg)](https://github.com/picocms/Pico/blob/master/LICENSE.md)
[![Versión](https://picocms.github.io/badges/pico-version.svg)](https://github.com/picocms/Pico/releases/latest)
[![Estado de la compilación](https://api.travis-ci.org/picocms/Pico.svg?branch=master)](https://travis-ci.org/picocms/Pico)
[![Freenode IRC Webchat](https://picocms.github.io/badges/pico-chat.svg)](https://webchat.freenode.net/?channels=%23picocms)
[![Obtenga recompensas en Bountysource](https://www.bountysource.com/badge/team?team_id=198139&style=bounties_received)](https://www.bountysource.com/teams/picocms)

Pico es un CMS de archivos sencillos, estúpidamente simple y brillantemente rápido.

Visítenos en http://picocms.org/ y para mas información consulte http://picocms.org/about/.

Captura de pantalla
----------

![Captura de pantalla de Pico](https://picocms.github.io/screenshots/pico-20.png)

Instalación
-------

Instalar Pico es extramadamente sencillo, ¡y listo para usar en segundos! Si tiene acceso a un intérprete de órdenes (shell) en su servidor (es decir, acceso SSH), le recomendamos que utilice [Composer][]. If not, use a pre-bundled release.Si no, utilice una versión empaquetada. Si desconoce lo que es un "acceso SSH", pues vaya también a la versión empaquetada.

Pico requiere PHP 5.3.6+

### Quiero usar Composer

Comenzando con Pico 2.0, recomendamos instalarlo utilizando Composer siempre que le sea posible. ¡Confíe en nosotros, no se arrepentirá cuando se trate de actualizar Pico! De todos modos, si no desea utilizar Composer, o simplemente no puede usarlo, no se desespere, la instalación de Pico con una versión empaquetada es todavía ¡más fácil que todo lo que conoce!

###### Paso 1

Abra un intérprete de órdenes (shell) y navegue hasta el directorio `httpdocs` (p. ej.: `/var/www/html`) de su servidor. Descargue Composer y ejecútelo con la opción `create-project` para instalarlo en la carpeta deseada (p. ej.: `/var/www/html/pico`):

```shell
$ curl -sSL https://getcomposer.org/installer | php
$ php composer.phar create-project picocms/pico-composer .
```

###### Paso 2

¿Cuál es el segundo paso? Pues, no hay un segundo paso. ¡Eso es todo! Abra su navegador web favorito y navegue a su nuevo, estúpidamente sencillo, asombroso y rápido ¡CMS de archivos planos! Los contenidos predeterminados de Pico le explicarán cómo crear sus propios contenidos.

### Quiero usar una versión empaquetada

¿Conoce esa sensación de que quiere instalar un nuevo sitio web, así que sube todos los archivos de su CMS favorito y al ejecutar el código de configuración, descubre que se le olvidó crear la base de datos SQL primero? Más tarde, dicho código de configuración le dice que los permisos de los archivos son incorrectos. Demonios, ¿qué significa esto? Pues olvídelo, ¡Pico es diferente!

###### Paso 1

[Descargue la última versión de Pico][LatestRelease] y suba todos los archivos al directorio de instalación deseado dentro de  `httpdocs` (p. ej.:  `/var/www/html/pico`) de su servidor.

###### Paso 2

Bien, aquí está la trampa: no hay trampa. ¡Eso es todo! Abra su navegador web favorito y navegue a su nuevo ¡CMS de archivos sencillos, estúpidamente simple y brillantemente rápido! Los contenidos predeterminados de Pico le explicarán cómo crear los suyos  propios.

### Soy un desarrollador

Entonces, ¿eres una de esas personas increíbles que hacen todo esto posible? ¡Pues, los amamos chicos! Como desarrollador, le recomendamos que clone el [repositorio Git de Pico][PicoGit], así como los repositorios de el [tema predefinido de Pico][PicoThemeGit] y el [complemento `PicoDeprecated`][PicoDeprecatedGit]. Puede configurar su espacio de trabajo utilizando el  [proyecto inicial de Composer para Pico][PicoComposerGit] e incluir todos los componentes de Pico usando paquetes locales.

Usar el repositorio Git de Pico es diferente a los métodos de instalación explicados anteriormente. El mismo le ofrece la versión de desarrollo actual de Pico, ¡lo que probablemente sea *inestable* y *no esté listo para su uso en producción*!

1. Abra un intérprete de órdenes (shell) y navegue hasta el directorio de instalación deseado de Pico dentro de `httpdocs`  (p. ej.: `/var/www/html/pico`) de su servidor. Descargue y extraiga el proyecto inicial de Composer para Pico dentro de la carpeta `workspace`:

    ```shell
    $ curl -sSL https://github.com/picocms/pico-composer/archive/master.tar.gz | tar xz
    $ mv pico-composer-master workspace
    ```

2. Clone todos los repositorios Git de todos los componentes de Pico (el núcleo (core), el tema predefinido y el complemento `PicoDeprecated`) dentro de la carpeta `components`:

    ```shell
    $ mkdir components
    $ git clone https://github.com/picocms/Pico.git components/pico
    $ git clone https://github.com/picocms/pico-theme.git components/pico-theme
    $ git clone https://github.com/picocms/pico-deprecated.git components/pico-deprecated
    ```

3. Indique a Composer que utilice los repositorios locales como sustituto de los paquetes `picocms/pico` (el núcleo de Pico), `picocms/pico-theme` (el tema predefinido) y `picocms/pico-deprecated` el (complemento `PicoDeprecated`). Actualice el `composer.json` de su espacio de trabajo de desarrollo (es decir: `workspace/composer.json`):

    ```json
    {
        "repositories": [
            {
                "type": "path",
                "url": "../components/pico",
                "options": { "symlink": true }
            },
            {
                "type": "path",
                "url": "../components/pico-theme",
                "options": { "symlink": true }
            },
            {
                "type": "path",
                "url": "../components/pico-deprecated",
                "options": { "symlink": true }
            }
        ],
        "require": {
            "picocms/pico": "dev-master",
            "picocms/pico-theme": "dev-master",
            "picocms/pico-deprecated": "dev-master",
            "picocms/composer-installer": "^1.0"
        }
    }
    ```

4. Descargue Composer e instálelo con la opción `install`:

    ```shell
    $ curl -sSL https://getcomposer.org/installer | php
    $ php composer.phar --working-dir=workspace install
    ```

Ahora puede abrir su navegador web y navegar al espacio de trabajo de desarrollo de Pico. Todos los cambios que realice en los componentes de Pico se reflejarán automáticamente en este espacio de trabajo.

Por cierto, puede también encontrar todos los componentes de Pico en [Packagist.org][Packagist]: [el núcleo de Pico][PicoPackagist], [el tema predefinido][PicoThemePackagist], el [complemento `PicoDeprecated`][PicoDeprecatedPackagist] y el [proyecto inicial de Composer para Pico][PicoComposerPackagist].

Actualizar
-------

¿Recuerda cuando instaló Pico? Era ingeniosamente sencillo, ¿verdad? Pues, la actualización de Pico ¡no tiene ninguna diferencia! El proceso de actualización depende de si utilizó [Composer][] o una versión empaquetada para instalar Pico. Tenga en cuenta que ¡*siempre* debe hacer una copia de seguridad de su instalación antes de actualizar!.

Pico sigue las [Versiones Semánticas 2.0][SemVer] y utiliza números de versión como `MAJOR`.`MINOR`.`PATCH`. Cuando actualizamos la versión `PATCH` (como de `2.0.0` a `2.0.1`), realizamos correcciones de errores compatibles con versiones anteriores. Si cambiamos la versión `MINOR` (como de `2.0` a `2.1`), hemos agregado una funcionalidad de manera compatible también con las versiones anteriores. La actualización de Pico es completamente sencilla en ambos casos. Solo necesita ir a la sección de actualización apropiada a continuación.

Pero espere, olvidamos mencionarle lo que sucede cuando actualizamos la versión `MAJOR` (p. ej.: de `2.0` a `3.0`). En este caso realizamos cambios incompatibles en la API. Por lo que le proporcionaremos un tutorial de actualización apropiado, así que diríjase a la [página "Actualizar" de nuestro sitio][HelpUpgrade].

### He usado Composer para instalar Pico

La actualización de Pico es extremadamente sencilla si ha utilizado Composer para instalarlo. Solo debe abrir un intérprete de órdenes (shell) y navegar hasta el directorio `httpdocs` (p. ej.: `/var/www/html/pico`) de su servidor. Ahora puede actualizar Pico con tan solo una orden:

```shell
$ php composer.phar update
```

¡Eso es todo! Composer actualizará automáticamente Pico y todos los complementos y temas que haya instalado con él. Asegúrese de actualizar manualmente todos los demás  complementos y temas que haya instalado manualmente.

### He usado una versión empaquetada para instalar Pico

Bueno, instalar Pico fue fácil, pero actualizar Pico seguro va a ser difícil, ¿no es así? Pues, me temo que tengo que decepcionarle... ¡Es tan sencillo como instalar el mismo Pico!

Primero tendrá que eliminar el directorio `vendor` de su instalación (p. ej.: si ha instalado Pico en `/var/www/html/pico`, elimine la carpeta `/var/www/html/pico/vendor`). Luego [descargue la última versión de Pico][LatestRelease] y suba todos los archivos a su directorio de instalación existente. Se le preguntará si desea sobrescribir los archivos como `index.php`, `.htaccess`,... - simplemente presione "Sí".

¡Eso es todo! Ahora que Pico está actualizado, debe actualizar todos los complementos y temas que haya instalado.

#### Soy un desarrollador

Como desarrollador, ya debería estar actualizado... Pero por el bien de la integridad, si quiere actualizar Pico, sencillamente abra el intérprete de órdenes y navegue hasta el espacio de trabajo (p. ej.: `/var/www/html/pico`). A continuación, recupere las últimas actualizaciones de los repositorios Git: [el núcleo de Pico][PicoGit], [el tema predefinido][PicoThemeGit] y el [complemento `PicoDeprecated`][PicoDeprecatedGit]. Deje que Composer actualice sus dependencias y ya estará listo:

```shell
$ git -C components/pico pull
$ git -C components/pico-theme pull
$ git -C components/pico-deprecated pull
$ php composer.phar --working-dir=workspace update
```

Obtener ayuda
------------

#### Obtener ayuda como usuario

Si desea comenzar a utilizar Pico, consulte la [documentación del usuario][HelpUserDocs] (¡la está leyendo en este momento!). Por favor, lea las [notas de actualización][HelpUpgrade] si desea actualizar de Pico 1.0 a Pico 2.0. Puede encontrar los [complementos][OfficialPlugins] y [temas][OfficialThemes] oficiales y compatibles aquí en nuestro sitio web. Además, podrá encontrar una variedad de complementos y temas en nuestra [Wiki][] en sus respectivas páginas de  [complementos][WikiPlugins] y [temas][WikiThemes]. Si desea crear su propio complemento o tema, consulte la sección  ["Obtener ayuda como desarrollador"][HelpDevOverview] a continuación.

#### Obtener ayuda como desarrollador

Si es un desarrollador, consulte la sección ["Contribuciones"][HelpDevContribute] más adelante y nuestras [pautas para contribuir][ContributionGuidelines]. Para comenzar a crear un complemento o tema, lea la [documentación del desarrollador][HelpDevDocs] en nuestro sitio web.

#### ¿Todavía necesita ayuda o alguna experiencia en algún problema con Pico?

Cuando la documentación no pueda responder a su pregunta, puede obtener ayuda de nosotros desde [#picocms en Freenode IRC](https://webchat.freenode.net/?channels=%23picocms). Cada vez que tenga problemas con Pico, no dude en crear un nuevo [ticket][Issues] en GitHub. En cuanto a los problemas con los complementos o temas, consulte el sitio web del desarrollador que lo ha creado.

**Antes de crear un nuevo ticket**, asegúrese de que el mismo no se haya informado antes utilizando el [motor de búsquedas de GitHubs][IssuesSearch]. Describa su problema lo más claro posible e incluya siempre la *versión de Pico* que esté utilizando. Siempre que esté usando *complementos*, incluya una lista de ellos también. Necesitamos información sobre el *comportamiento real y esperado*, los *pasos para reproducir* el problema y los pasos que ha seguido para resolverlo usted mismo (es decir, *su propia solución del problema*).

Contribuir
------------

¿Quiere contribuir con Pico? ¡Realmente lo apreciamos! Puede ayudar a mejorar Pico [contribuyendo con código][PullRequests] o [reportando problemas][Issues], pero tome nota de nuestras [pautas para contribuir][ContributionGuidelines]. En general, puede contribuir en tres áreas diferentes:

1. Complementos y temas: ¿Eres un desarrollador de complementos o un diseñador de temas? ¡Los amamos chicos! Puede encontrar toneladas de información sobre cómo desarrollar complementos y temas en http://picocms.org/development/. Si ha creado un complemento o tema, por favor, agréguelo a nuestra [Wiki][Wiki], o en la página de [complementos][WikiPlugins] o [temas][WikiThemes]. Puede también [enviarlo][Submit] a nuestro sitio web, ¡donde se mostrará en la página oficial de [complementos][OfficialPlugins] o [temas][OfficialThemes]!.

2. Documentación: Siempre apreciamos a las personas que mejoran nuestra documentación. Puede mejorar los [documentos del usuario en línea][EditInlineDocs] o los mas extensos [documentos del usuario en nuestro sitio web][EditUserDocs]. Puede también mejorar la [documentación para los desarrolladores de plugins y temas][EditDevDocs]. Sencillamente haga una bifurcación del repositorio Git desde https://github.com/picocms/picocms.github.io, haga las modificaciones deseadas a los archivos Markdown y abra una [solicitud de fusión][PullRequestsWebsite].

3. El núcleo de Pico: la disciplina suprema es trabajar en el núcleo de Pico. Su contribución debería ayudar a *cada* usuario de Pico a tener una mejor experiencia con él. Si este es el caso, bifurque Pico desde https://github.com/picocms/Pico y abra una [solicitud de fusión][PullRequestsWebsite]. ¡Esperamos sus contribuciones!

Al contribuir con Pico, usted acepta y está de acuerdo con el *Certificado de origen del desarrollador* para sus contribuciones presentes y futuras que se envíen a Pico. Por favor, consulte la sección ["Certificado de origen del desarrollador" en nuestro `CONTRIBUTING.md`][ContributionGuidelinesDCO].

¿No tiene tiempo para contribuir con Pico, pero todavía desea "invitar a un café" a aquellos que lo hacen? Pues, puede contribuir monetariamente con Pico utilizando [Bountysource][], un sitio web de financiación colectiva que se centra en problemas concretos y solicitudes de funcionalidades. Para obtener más información, consulte la sección "Recompensas y recaudadores de fondos" a continuación.

Recompensas y recaudadores de fondos
------------------------

Pico utiliza [Bountysource][] para permitir las contribuciones monetarias al proyecto. Bountysource es un sitio web de financiación colectiva que se centra en problemas concretos y solicitudes de funcionalidades en proyectos de código abierto mediante el uso de micropagos. Los usuarios, o "patrocinadores", pueden prometer dinero por solucionar un problema específico, implementar nuevas funciones o desarrollar un nuevo complemento o tema. Los desarrolladores de software de código abierto, o "cazadores de recompensas", pueden entonces tomar y resolver estas tareas para ganar ese dinero.

Obviamente, este no es un trabajo a tiempo completo, es más bien como "invitar a un café". Sin embargo, ayuda a acercar a los usuarios y los desarrolladores, y les muestra a éstos lo que los usuarios quieren y cuánto les importan ciertas cosas. No obstante, puede todavía donar dinero para el proyecto en sí, como una forma de decir "Gracias" y apoyar a Pico.

Si desea animar a los desarrolladores a [resolver un problema en específico][Issues] o implementar una funcionalidad, sencillamente prometa una nueva recompensa o respalde una existente.

Como desarrollador, puede obtener una recompensa sencillamente contribuyendo con Pico (por favor, consulte la sección "Contribuir" más arriba). ¡No tiene que ser un colaborador oficial de Pico! Pico es un proyecto de código abierto, cualquiera puede abrir [solicitudes de fusión][PullRequests] y reclamar sus recompensas.

Los contribuyentes oficiales de Pico no harán ningún reclamo de recompensas en su propio nombre, Pico nunca tomará dinero alguno de Bountysource. Todos los dineros recolectados por Pico se usarán para promover nuevas recompesas o para apoyar a los projectos de los cuales depende.

[Composer]: https://getcomposer.org/
[LatestRelease]: https://github.com/picocms/Pico/releases/latest
[PicoGit]: https://github.com/picocms/Pico
[PicoThemeGit]: https://github.com/picocms/pico-theme
[PicoDeprecatedGit]: https://github.com/picocms/pico-deprecated
[PicoComposerGit]: https://github.com/picocms/pico-composer
[Packagist]: https://packagist.org/
[PicoPackagist]: https://packagist.org/packages/picocms/pico
[PicoThemePackagist]: https://packagist.org/packages/picocms/pico-theme
[PicoDeprecatedPackagist]: https://packagist.org/packages/picocms/pico-deprecated
[PicoComposerPackagist]: https://packagist.org/packages/picocms/pico-composer
[SemVer]: http://semver.org
[HelpUpgrade]: http://picocms.org/in-depth/upgrade/
[HelpUserDocs]: http://picocms.org/docs/
[HelpDevDocs]: http://picocms.org/development/
[Submit]: http://picocms.org/in-depth/submission_guidelines
[OfficialPlugins]: http://picocms.org/plugins/
[OfficialThemes]: http://picocms.org/themes/
[Wiki]: https://github.com/picocms/Pico/wiki
[WikiPlugins]: https://github.com/picocms/Pico/wiki/Pico-Plugins
[WikiThemes]: https://github.com/picocms/Pico/wiki/Pico-Themes
[Issues]: https://github.com/picocms/Pico/issues
[IssuesSearch]: https://github.com/picocms/Pico/search?type=Issues
[Freenode]: https://webchat.freenode.net/?channels=%23picocms
[FreenodeLogs]: http://picocms.org/irc-logs
[PullRequests]: https://github.com/picocms/Pico/pulls
[PullRequestsWebsite]: https://github.com/picocms/picocms.github.io/pulls
[ContributionGuidelines]: https://github.com/picocms/Pico/blob/master/CONTRIBUTING.md
[ContributionGuidelinesDCO]: https://github.com/picocms/Pico/blob/master/CONTRIBUTING.md#developer-certificate-of-origin
[EditInlineDocs]: https://github.com/picocms/Pico/edit/master/content-sample/index.md
[EditUserDocs]: https://github.com/picocms/picocms.github.io/tree/master/_docs
[EditDevDocs]: https://github.com/picocms/picocms.github.io/tree/master/_development
[Bountysource]: https://www.bountysource.com/teams/picocms