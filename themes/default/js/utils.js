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

utils = {};

/**
 * Iterates through an iterable object (e.g. plain objects, arrays, NodeList)
 *
 * @param  object   object   the object to iterate through
 * @param  function callback function to call on every item; the key is passed
 *     as first, the value as second parameter; the callback may return FALSE
 *     to stop the iteration
 * @return void
 */
utils.forEach = function (object, callback) {
    var i = 0,
        keys = Object.keys(object),
        length = keys.length;
    for (; i < length; i++) {
        if (callback(keys[i], object[keys[i]]) === false) {
            return;
        }
    }
};

/**
 * Checks whether the client's browser is able to slide elements or not
 *
 * @return boolean TRUE when the browser supports sliding, FALSE otherwise
 */
utils.canSlide = function () {
    return (Modernizr.classlist && Modernizr.requestanimationframe && Modernizr.csstransitions);
};

/**
 * Slides a element up (i.e. hide a element by changing its height to 0px)
 *
 * @param  HTMLElement element        the element to slide up
 * @param  function    finishCallback function to call when the animation has
 *     been finished (i.e. the element is hidden)
 * @param  function    startCallback  function to call when the animation starts
 * @return void
 */
utils.slideUp = function (element, finishCallback, startCallback) {
    if (!utils.canSlide()) {
        if (startCallback) startCallback();
        element.className += (element.className !== '') ? ' hidden' : 'hidden';
        if (finishCallback) window.requestAnimationFrame(finishCallback);
        return;
    }

    element.style.height = element.clientHeight + 'px';

    var slideId = parseInt(element.getAttribute('data-slide-id')) || 0;
    element.setAttribute('data-slide-id', ++slideId);

    window.requestAnimationFrame(function () {
        element.classList.add('slide');

        window.requestAnimationFrame(function () {
            element.style.height = '0px';

            if (startCallback) {
                startCallback();
            }

            window.setTimeout(function () {
                if (parseInt(element.getAttribute('data-slide-id')) !== slideId) return;

                element.classList.add('hidden');
                element.classList.remove('slide');
                element.style.height = null;

                if (finishCallback) {
                    window.requestAnimationFrame(finishCallback);
                }
            }, 500);
        });
    });
};

/**
 * Slides a element down (i.e. show a hidden element)
 *
 * @param  HTMLElement element        the element to slide down
 * @param  function    finishCallback function to call when the animation has
 *     been finished (i.e. the element is visible)
 * @param  function    startCallback  function to call when the animation starts
 * @return void
 */
utils.slideDown = function (element, finishCallback, startCallback) {
    if (!utils.canSlide()) {
        if (startCallback) startCallback();
        element.className = element.className.replace(/\bhidden\b */g, '');
        if (finishCallback) window.requestAnimationFrame(finishCallback);
        return;
    }

    var cssRuleOriginalValue = element.clientHeight + 'px',
        slideId = parseInt(element.getAttribute('data-slide-id')) || 0;

    element.setAttribute('data-slide-id', ++slideId);

    element.style.height = null;
    element.classList.remove('hidden');
    element.classList.remove('slide');
    var cssRuleValue = element.clientHeight + 'px';

    element.style.height = cssRuleOriginalValue;

    window.requestAnimationFrame(function () {
        element.classList.add('slide');

        window.requestAnimationFrame(function () {
            element.style.height = cssRuleValue;

            if (startCallback) {
                startCallback();
            }

            window.setTimeout(function () {
                if (parseInt(element.getAttribute('data-slide-id')) !== slideId) return;

                element.classList.remove('slide');
                element.style.height = null;

                if (finishCallback) {
                    window.requestAnimationFrame(finishCallback);
                }
            }, 500);
        });
    });
};

/**
 * Checks whether a element is visible or not
 *
 * @param  HTMLElement element the element to check
 * @return boolean             TRUE when the element is visible, FALSE otherwise
 */
utils.isElementVisible = function (element) {
    return !!(element.offsetWidth || element.offsetHeight || element.getClientRects().length);
};
