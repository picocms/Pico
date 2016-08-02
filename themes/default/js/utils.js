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
 *     as first, the value as second parameter
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
 * Slides a element up (i.e. hide a element by changing its height to 0)
 *
 * @param  HTMLElement element        the element to slide up
 * @param  function    finishCallback function to call when the animation has
 *     been finished (i.e. the element is hidden)
 * @param  function    startCallback  function to call when the animation starts
 * @return void
 */
utils.slideUp = function (element, finishCallback, startCallback) {
    utils.slideOut(element, {
        cssRule: 'height',
        cssRuleRef: 'clientHeight',
        cssClass: 'up',
        startCallback: startCallback,
        finishCallback: finishCallback
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
    utils.slideIn(element, {
        cssRule: 'height',
        cssRuleRef: 'clientHeight',
        cssClass: 'up',
        startCallback: startCallback,
        finishCallback: finishCallback
    });
};

/**
 * Slides a element out (i.e. hide the element)
 *
 * @param  HTMLElement element the element to slide out
 * @param  object      options the settings of the sliding process
 * @return void
 */
utils.slideOut = function (element, options) {
    element.style[options.cssRule] = element[options.cssRuleRef] + 'px';

    var slideId = parseInt(element.dataset.slideId) || 0;
    element.dataset.slideId = ++slideId;

    window.requestAnimationFrame(function () {
        element.classList.add('slide');

        window.requestAnimationFrame(function () {
            element.classList.add(options.cssClass);

            if (options.startCallback) {
                options.startCallback();
            }

            window.setTimeout(function () {
                if (parseInt(element.dataset.slideId) !== slideId) return;

                element.classList.add('hidden');
                element.classList.remove('slide');
                element.classList.remove(options.cssClass);
                element.style[options.cssRule] = null;

                if (options.finishCallback) {
                    window.requestAnimationFrame(options.finishCallback);
                }
            }, 500);
        });
    });
};

/**
 * Slides a element in (i.e. make the element visible)
 *
 * @param  HTMLElement element the element to slide in
 * @param  object      options the settings of the sliding process
 * @return void
 */
utils.slideIn = function (element, options) {
    var cssRuleOriginalValue = element[options.cssRuleRef] + 'px',
        slideId = parseInt(element.dataset.slideId) || 0;

    element.dataset.slideId = ++slideId;

    element.style[options.cssRule] = null;
    element.classList.remove('hidden', 'slide', options.cssClass);
    var cssRuleValue = element[options.cssRuleRef] + 'px';

    element.classList.add('slide');

    window.requestAnimationFrame(function () {
        element.style[options.cssRule] = cssRuleOriginalValue;

        window.requestAnimationFrame(function () {
            element.style[options.cssRule] = cssRuleValue;

            if (options.startCallback) {
                options.startCallback();
            }

            window.setTimeout(function () {
                if (parseInt(element.dataset.slideId) !== slideId) return;

                element.classList.remove('slide');
                element.style[options.cssRule] = null;

                if (options.finishCallback) {
                    window.requestAnimationFrame(options.finishCallback);
                }
            }, 500);
        });
    });
};

/**
 * Check whether a element is visible or not
 *
 * @param  HTMLElement element the element to test
 * @return boolean             TRUE when the element is visible, FALSE otherwise
 */
utils.isElementVisible = function (element) {
    return !!(element.offsetWidth || element.offsetHeight || element.getClientRects().length);
};