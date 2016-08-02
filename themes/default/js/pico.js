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
    document.documentElement.className = 'js';

    // wrap tables
    utils.forEach(document.querySelectorAll('main table'), function (_, table) {
        if (!/\btable-responsive\b/.test(table.parentElement.className)) {
            var tableWrapper = document.createElement('div');
            tableWrapper.className = 'table-responsive';

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
                menu.className = 'hidden';
                menuToggle.addEventListener('click', toggleMenuEvent);
                menuToggle.addEventListener('keydown', toggleMenuEvent);
            } else {
                menu.className = '';
                menu.removeAttribute('data-slide-id');
                menuToggle.removeEventListener('click', toggleMenuEvent);
                menuToggle.removeEventListener('keydown', toggleMenuEvent);
            }
        };

    window.addEventListener('resize', onResizeEvent);
    onResizeEvent();
}

main();
