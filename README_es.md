Pico
====

[![Licencia](https://picocms.github.io/badges/pico-license.svg)](https://github.com/picocms/Pico/blob/master/LICENSE.md)
[![Versi�n](https://picocms.github.io/badges/pico-version.svg)](https://github.com/picocms/Pico/releases/latest)
[![Estado de la compilaci�n](https://api.travis-ci.org/picocms/Pico.svg?branch=master)](https://travis-ci.org/picocms/Pico)
[![Freenode IRC Webchat](https://picocms.github.io/badges/pico-chat.svg)](https://webchat.freenode.net/?channels=%23picocms)
[![Obtenga recompensas en Bountysource](https://www.bountysource.com/badge/team?team_id=198139&style=bounties_received)](https://www.bountysource.com/teams/picocms)

Pico es un CMS de archivos sencillos, est�pidamente simple y brillantemente r�pido.

Vis�tenos en http://picocms.org/ y para mas informaci�n consulte http://picocms.org/about/.

Captura de pantalla
----------

![Captura de pantalla de Pico](https://picocms.github.io/screenshots/pico-20.png)

Instalaci�n
-------

Instalar Pico es extramadamente sencillo, �y listo para usar en segundos! Si tiene acceso a un int�rprete de �rdenes (shell) en su servidor (es decir, acceso SSH), le recomendamos que utilice [Composer][]. If not, use a pre-bundled release.Si no, utilice una versi�n empaquetada. Si desconoce lo que es un "acceso SSH", pues vaya tambi�n a la versi�n empaquetada.

Pico requiere PHP 5.3.6+

### Quiero usar Composer

Comenzando con Pico 2.0, recomendamos instalarlo utilizando Composer siempre que le sea posible. �Conf�e en nosotros, no se arrepentir� cuando se trate de actualizar Pico! De todos modos, si no desea utilizar Composer, o simplemente no puede usarlo, no se desespere, la instalaci�n de Pico con una versi�n empaquetada es todav�a �m�s f�cil que todo lo que conoce!

###### Paso 1

Abra un int�rprete de �rdenes (shell) y navegue hasta el directorio `httpdocs` (p. ej.: `/var/www/html`) de su servidor. Descargue Composer y ejec�telo con la opci�n `create-project` para instalarlo en la carpeta deseada (p. ej.: `/var/www/html/pico`):

```shell
$ curl -sSL https://getcomposer.org/installer | php
$ php composer.phar create-project picocms/pico-composer .
```

###### Paso 2

�Cu�l es el segundo paso? Pues, no hay un segundo paso. �Eso es todo! Abra su navegador web favorito y navegue a su nuevo, est�pidamente sencillo, asombroso y r�pido �CMS de archivos planos! Los contenidos predeterminados de Pico le explicar�n c�mo crear sus propios contenidos.

### Quiero usar una versi�n empaquetada

�Conoce esa sensaci�n de que quiere instalar un nuevo sitio web, as� que sube todos los archivos de su CMS favorito y al ejecutar el c�digo de configuraci�n, descubre que se le olvid� crear la base de datos SQL primero? M�s tarde, dicho c�digo de configuraci�n le dice que los permisos de los archivos son incorrectos. Demonios, �qu� significa esto? Pues olv�delo, �Pico es diferente!

###### Paso 1

[Descargue la �ltima versi�n de Pico][LatestRelease] y suba todos los archivos al directorio de instalaci�n deseado dentro de  `httpdocs` (p. ej.:  `/var/www/html/pico`) de su servidor.

###### Paso 2

Bien, aqu� est� la trampa: no hay trampa. �Eso es todo! Abra su navegador web favorito y navegue a su nuevo �CMS de archivos sencillos, est�pidamente simple y brillantemente r�pido! Los contenidos predeterminados de Pico le explicar�n c�mo crear los suyos  propios.

### Soy un desarrollador

Entonces, �eres una de esas personas incre�bles que hacen todo esto posible? �Pues, los amamos chicos! Como desarrollador, le recomendamos que clone el [repositorio Git de Pico][PicoGit], as� como los repositorios de el [tema predefinido de Pico][PicoThemeGit] y el [complemento `PicoDeprecated`][PicoDeprecatedGit]. Puede configurar su espacio de trabajo utilizando el  [proyecto inicial de Composer para Pico][PicoComposerGit] e incluir todos los componentes de Pico usando paquetes locales.

Usar el repositorio Git de Pico es diferente a los m�todos de instalaci�n explicados anteriormente. El mismo le ofrece la versi�n de desarrollo actual de Pico, �lo que probablemente sea *inestable* y *no est� listo para su uso en producci�n*!

1. Abra un int�rprete de �rdenes (shell) y navegue hasta el directorio de instalaci�n deseado de Pico dentro de `httpdocs`  (p. ej.: `/var/www/html/pico`) de su servidor. Descargue y extraiga el proyecto inicial de Composer para Pico dentro de la carpeta `workspace`:

    ```shell
    $ curl -sSL https://github.com/picocms/pico-composer/archive/master.tar.gz | tar xz
    $ mv pico-composer-master workspace
    ```

2. Clone todos los repositorios Git de todos los componentes de Pico (el n�cleo (core), el tema predefinido y el complemento `PicoDeprecated`) dentro de la carpeta `components`:

    ```shell
    $ mkdir components
    $ git clone https://github.com/picocms/Pico.git components/pico
    $ git clone https://github.com/picocms/pico-theme.git components/pico-theme
    $ git clone https://github.com/picocms/pico-deprecated.git components/pico-deprecated
    ```

3. Indique a Composer que utilice los repositorios locales como sustituto de los paquetes `picocms/pico` (el n�cleo de Pico), `picocms/pico-theme` (el tema predefinido) y `picocms/pico-deprecated` el (complemento `PicoDeprecated`). Actualice el `composer.json` de su espacio de trabajo de desarrollo (es decir: `workspace/composer.json`):

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

4. Descargue Composer e inst�lelo con la opci�n `install`:

    ```shell
    $ curl -sSL https://getcomposer.org/installer | php
    $ php composer.phar --working-dir=workspace install
    ```

Ahora puede abrir su navegador web y navegar al espacio de trabajo de desarrollo de Pico. Todos los cambios que realice en los componentes de Pico se reflejar�n autom�ticamente en este espacio de trabajo.

Por cierto, puede tambi�n encontrar todos los componentes de Pico en [Packagist.org][Packagist]: [el n�cleo de Pico][PicoPackagist], [el tema predefinido][PicoThemePackagist], el [complemento `PicoDeprecated`][PicoDeprecatedPackagist] y el [proyecto inicial de Composer para Pico][PicoComposerPackagist].

Actualizar
-------

�Recuerda cuando instal� Pico? Era ingeniosamente sencillo, �verdad? Pues, la actualizaci�n de Pico �no tiene ninguna diferencia! El proceso de actualizaci�n depende de si utiliz� [Composer][] o una versi�n empaquetada para instalar Pico. Tenga en cuenta que �*siempre* debe hacer una copia de seguridad de su instalaci�n antes de actualizar!.

Pico sigue las [Versiones Sem�nticas 2.0][SemVer] y utiliza n�meros de versi�n como `MAJOR`.`MINOR`.`PATCH`. Cuando actualizamos la versi�n `PATCH` (como de `2.0.0` a `2.0.1`), realizamos correcciones de errores compatibles con versiones anteriores. Si cambiamos la versi�n `MINOR` (como de `2.0` a `2.1`), hemos agregado una funcionalidad de manera compatible tambi�n con las versiones anteriores. La actualizaci�n de Pico es completamente sencilla en ambos casos. Solo necesita ir a la secci�n de actualizaci�n apropiada a continuaci�n.

Pero espere, olvidamos mencionarle lo que sucede cuando actualizamos la versi�n `MAJOR` (p. ej.: de `2.0` a `3.0`). En este caso realizamos cambios incompatibles en la API. Por lo que le proporcionaremos un tutorial de actualizaci�n apropiado, as� que dir�jase a la [p�gina "Actualizar" de nuestro sitio][HelpUpgrade].

### He usado Composer para instalar Pico

La actualizaci�n de Pico es extremadamente sencilla si ha utilizado Composer para instalarlo. Solo debe abrir un int�rprete de �rdenes (shell) y navegar hasta el directorio `httpdocs` (p. ej.: `/var/www/html/pico`) de su servidor. Ahora puede actualizar Pico con tan solo una orden:

```shell
$ php composer.phar update
```

�Eso es todo! Composer actualizar� autom�ticamente Pico y todos los complementos y temas que haya instalado con �l. Aseg�rese de actualizar manualmente todos los dem�s  complementos y temas que haya instalado manualmente.

### He usado una versi�n empaquetada para instalar Pico

Bueno, instalar Pico fue f�cil, pero actualizar Pico seguro va a ser dif�cil, �no es as�? Pues, me temo que tengo que decepcionarle... �Es tan sencillo como instalar el mismo Pico!

Primero tendr� que eliminar el directorio `vendor` de su instalaci�n (p. ej.: si ha instalado Pico en `/var/www/html/pico`, elimine la carpeta `/var/www/html/pico/vendor`). Luego [descargue la �ltima versi�n de Pico][LatestRelease] y suba todos los archivos a su directorio de instalaci�n existente. Se le preguntar� si desea sobrescribir los archivos como `index.php`, `.htaccess`,... - simplemente presione "S�".

�Eso es todo! Ahora que Pico est� actualizado, debe actualizar todos los complementos y temas que haya instalado.

#### Soy un desarrollador

Como desarrollador, ya deber�a estar actualizado... Pero por el bien de la integridad, si quiere actualizar Pico, sencillamente abra el int�rprete de �rdenes y navegue hasta el espacio de trabajo (p. ej.: `/var/www/html/pico`). A continuaci�n, recupere las �ltimas actualizaciones de los repositorios Git: [el n�cleo de Pico][PicoGit], [el tema predefinido][PicoThemeGit] y el [complemento `PicoDeprecated`][PicoDeprecatedGit]. Deje que Composer actualice sus dependencias y ya estar� listo:

```shell
$ git -C components/pico pull
$ git -C components/pico-theme pull
$ git -C components/pico-deprecated pull
$ php composer.phar --working-dir=workspace update
```

Obtener ayuda
------------

#### Obtener ayuda como usuario

Si desea comenzar a utilizar Pico, consulte la [documentaci�n del usuario][HelpUserDocs] (�la est� leyendo en este momento!). Por favor, lea las [notas de actualizaci�n][HelpUpgrade] si desea actualizar de Pico 1.0 a Pico 2.0. Puede encontrar los [complementos][OfficialPlugins] y [temas][OfficialThemes] oficiales y compatibles aqu� en nuestro sitio web. Adem�s, podr� encontrar una variedad de complementos y temas en nuestra [Wiki][] en sus respectivas p�ginas de  [complementos][WikiPlugins] y [temas][WikiThemes]. Si desea crear su propio complemento o tema, consulte la secci�n  "Obtener ayuda como desarrollador a continuaci�n.

#### Obtener ayuda como desarrollador

Si es un desarrollador, consulte la secci�n "Contribuciones" m�s adelante y nuestras [pautas para contribuir][ContributionGuidelines]. Para comenzar a crear un complemento o tema, lea la [documentaci�n del desarrollador][HelpDevDocs] en nuestro sitio web.

#### �Todav�a necesita ayuda o alguna experiencia en alg�n problema con Pico?

Cuando la documentaci�n no pueda responder a su pregunta, puede obtener ayuda de nosotros desde [#picocms en Freenode IRC](https://webchat.freenode.net/?channels=%23picocms). Cada vez que tenga problemas con Pico, no dude en crear un nuevo [ticket][Issues] en GitHub. En cuanto a los problemas con los complementos o temas, consulte el sitio web del desarrollador que lo ha creado.

**Antes de crear un nuevo ticket**, aseg�rese de que el mismo no se haya informado antes utilizando el [motor de b�squedas de GitHubs][IssuesSearch]. Describa su problema lo m�s claro posible e incluya siempre la *versi�n de Pico* que est� utilizando. Siempre que est� usando *complementos*, incluya una lista de ellos tambi�n. Necesitamos informaci�n sobre el *comportamiento real y esperado*, los *pasos para reproducir* el problema y los pasos que ha seguido para resolverlo usted mismo (es decir, *su propia soluci�n del problema*).

Contribuir
------------

�Quiere contribuir con Pico? �Realmente lo apreciamos! Puede ayudar a mejorar Pico [contribuyendo con c�digo][PullRequests] o [reportando problemas][Issues], pero tome nota de nuestras [pautas para contribuir][ContributionGuidelines]. En general, puede contribuir en tres �reas diferentes:

1. Complementos y temas: �Eres un desarrollador de complementos o un dise�ador de temas? �Los amamos chicos! Puede encontrar toneladas de informaci�n sobre c�mo desarrollar complementos y temas en http://picocms.org/development/. Si ha creado un complemento o tema, por favor, agr�guelo a nuestra [Wiki][Wiki], o en la p�gina de [complementos][WikiPlugins] o [temas][WikiThemes]. Puede tambi�n [enviarlo][Submit] a nuestro sitio web, �donde se mostrar� en la p�gina oficial de [complementos][OfficialPlugins] o [temas][OfficialThemes]!.

2. Documentaci�n: Siempre apreciamos a las personas que mejoran nuestra documentaci�n. Puede mejorar los [documentos del usuario en l�nea][EditInlineDocs] o los mas extensos [documentos del usuario en nuestro sitio web][EditUserDocs]. Puede tambi�n mejorar la [documentaci�n para los desarrolladores de plugins y temas][EditDevDocs]. Sencillamente haga una bifurcaci�n del repositorio Git desde https://github.com/picocms/picocms.github.io, haga las modificaciones deseadas a los archivos Markdown y abra una [solicitud de fusi�n][PullRequestsWebsite].

3. El n�cleo de Pico: la disciplina suprema es trabajar en el n�cleo de Pico. Su contribuci�n deber�a ayudar a *cada* usuario de Pico a tener una mejor experiencia con �l. Si este es el caso, bifurque Pico desde https://github.com/picocms/Pico y abra una [solicitud de fusi�n][PullRequestsWebsite]. �Esperamos sus contribuciones!

Al contribuir con Pico, usted acepta y est� de acuerdo con el *Certificado de origen del desarrollador* para sus contribuciones presentes y futuras que se env�en a Pico. Por favor, consulte la secci�n ["Certificado de origen del desarrollador" en nuestro `CONTRIBUTING.md`][ContributionGuidelinesDCO].

�No tiene tiempo para contribuir con Pico, pero todav�a desea "invitar a un caf�" a aquellos que lo hacen? Pues, puede contribuir monetariamente con Pico utilizando [Bountysource][], un sitio web de financiaci�n colectiva que se centra en problemas concretos y solicitudes de funcionalidades. Para obtener m�s informaci�n, consulte la secci�n "Recompensas y recaudadores de fondos" a continuaci�n.

Recompensas y recaudadores de fondos
------------------------

Pico utiliza [Bountysource][] para permitir las contribuciones monetarias al proyecto. Bountysource es un sitio web de financiaci�n colectiva que se centra en problemas concretos y solicitudes de funcionalidades en proyectos de c�digo abierto mediante el uso de micropagos. Los usuarios, o "patrocinadores", pueden prometer dinero por solucionar un problema espec�fico, implementar nuevas funciones o desarrollar un nuevo complemento o tema. Los desarrolladores de software de c�digo abierto, o "cazadores de recompensas", pueden entonces tomar y resolver estas tareas para ganar ese dinero.

Obviamente, este no es un trabajo a tiempo completo, es m�s bien como "invitar a un caf�". Sin embargo, ayuda a acercar a los usuarios y los desarrolladores, y les muestra a �stos lo que los usuarios quieren y cu�nto les importan ciertas cosas. No obstante, puede todav�a donar dinero para el proyecto en s�, como una forma de decir "Gracias" y apoyar a Pico.

Si desea animar a los desarrolladores a [resolver un problema en espec�fico][Issues] o implementar una funcionalidad, sencillamente prometa una nueva recompensa o respalde una existente.

Como desarrollador, puede obtener una recompensa sencillamente contribuyendo con Pico (por favor, consulte la secci�n "Contribuir" m�s arriba). �No tiene que ser un colaborador oficial de Pico! Pico es un proyecto de c�digo abierto, cualquiera puede abrir [solicitudes de fusi�n][PullRequests] y reclamar sus recompensas.

Los contribuyentes oficiales de Pico no har�n ning�n reclamo de recompensas en su propio nombre, Pico nunca tomar� dinero alguno de Bountysource. Todos los dineros recolectados por Pico se usar�n para promover nuevas recompesas o para apoyar a los projectos de los cuales depende.

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