/**
 * Pico's Default Theme - JavaScript helper
 *
 * Pico is a stupidly simple, blazing fast, flat file CMS.
 *
 * @author  Daniel Rudolf
 * @link    http://picocms.org
 * @license http://opensource.org/licenses/MIT The MIT License
 * @version 1.1
 */

function main() {
    // capability CSS classes
    document.documentElement.classList.remove('no-js');
    document.documentElement.classList.add('js');

    // wrap tables
    utils.forEach(document.querySelectorAll('main table'), function (_, table) {
        if (!table.parentElement.classList.contains('table-responsive')) {
            var tableWrapper = document.createElement('div');
            tableWrapper.classList.add('table-responsive');

            table.parentElement.insertBefore(tableWrapper, table);
            tableWrapper.appendChild(table);
        }
    });

    // responsive menu
    var menu = document.getElementById('page-menu'),
        menuToggle = document.getElementById('page-menu-toggle'),
        toggleMenuEvent = function (event) {
            if (event.type === 'keydown') {
                if ((event.keyCode != 13) && (event.keyCode != 32)) {
                    return;
                }
            }

            event.preventDefault();

            if (menuToggle.getAttribute('aria-expanded') === 'false') {
                menuToggle.setAttribute('aria-expanded', 'true');
                utils.slideDown(menu, null, function () {
                    if (event.type === 'keydown') menu.focus();
                });
            } else {
                menuToggle.setAttribute('aria-expanded', 'false');
                utils.slideUp(menu);
            }
        },
        onResizeEvent = function () {
            if (utils.isElementVisible(menuToggle)) {
                menu.classList.add('hidden');
                menuToggle.addEventListener('click', toggleMenuEvent);
                menuToggle.addEventListener('keydown', toggleMenuEvent);
            } else {
                menuToggle.removeEventListener('keydown', toggleMenuEvent);
                menuToggle.removeEventListener('click', toggleMenuEvent);
                menu.classList.remove('hidden', 'slide', 'up');
                delete menu.dataset.slideId;
            }
        };

    window.addEventListener('resize', onResizeEvent);
    onResizeEvent();
}

main();
