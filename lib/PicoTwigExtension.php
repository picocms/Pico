<?php

/**
 * Pico's Twig extension to implement additional filters
 *
 * @author  Daniel Rudolf
 * @link    http://picocms.org
 * @license http://opensource.org/licenses/MIT The MIT License
 * @version 1.0
 */
class PicoTwigExtension extends Twig_Extension
{
    /**
     * Current instance of Pico
     *
     * @see PicoTwigExtension::getPico()
     * @var Pico
     */
    private $pico;

    /**
     * Constructs a new instance of this Twig extension
     *
     * @param Pico $pico current instance of Pico
     */
    public function __construct(Pico $pico)
    {
        $this->pico = $pico;
    }

    /**
     * Returns the extensions instance of Pico
     *
     * @see    Pico
     * @return Pico the extensions instance of Pico
     */
    public function getPico()
    {
        return $this->pico;
    }

    /**
     * Returns the name of the extension
     *
     * @see    Twig_ExtensionInterface::getName()
     * @return string the extension name
     */
    public function getName()
    {
        return 'PicoTwigExtension';
    }

    /**
     * Returns the Twig filters markdown, map and sort_by
     *
     * @see    Twig_ExtensionInterface::getFilters()
     * @return Twig_SimpleFilter[] array of Pico's Twig filters
     */
    public function getFilters()
    {
        return array(
            'markdown' => new Twig_SimpleFilter('markdown', array($this, 'markdownFilter')),
            'map' => new Twig_SimpleFilter('map', array($this, 'mapFilter')),
            'sort_by' => new Twig_SimpleFilter('sort_by', array($this, 'sortByFilter')),
        );
    }

    /**
     * Parses a markdown string to HTML
     *
     * This method is registered as the Twig `markdown` filter. You can use it
     * to e.g. parse a meta variable (`{{ meta.description|markdown }}`).
     * Don't use it to parse the contents of a page, use the `content` filter
     * instead, what ensures the proper preparation of the contents.
     *
     * @param  string $markdown markdown to parse
     * @return string           parsed HTML
     */
    public function markdownFilter($markdown)
    {
        if ($this->getPico()->getParsedown() === null) {
            throw new LogicException(
                'Unable to apply Twig "markdown" filter: '
                . 'Parsedown instance wasn\'t registered yet'
            );
        }

        return $this->getPico()->getParsedown()->text($markdown);
    }

    /**
     * Returns a array with the values of the given key or key path
     *
     * This method is registered as the Twig `map` filter. You can use this
     * filter to e.g. get all page titles (`{{ pages|map("title") }}`).
     *
     * @param  array|Traversable $var        variable to map
     * @param  mixed             $mapKeyPath key to map; either a scalar or a
     *     array interpreted as key path (i.e. ['foo', 'bar'] will return all
     *     $item['foo']['bar'] values)
     * @return array                         mapped values
     */
    public function mapFilter($var, $mapKeyPath)
    {
        if (!is_array($var) && (!is_object($var) || !is_a($var, 'Traversable'))) {
            throw new Twig_Error_Runtime(sprintf(
                'The map filter only works with arrays or "Traversable", got "%s"',
                is_object($var) ? get_class($var) : gettype($var)
            ));
        }

        $result = array();
        foreach ($var as $key => $value) {
            $mapValue = $this->getKeyOfVar($value, $mapKeyPath);
            $result[$key] = ($mapValue !== null) ? $mapValue : $value;
        }
        return $result;
    }

    /**
     * Sorts an array by one of its keys or a arbitrary deep sub-key
     *
     * This method is registered as the Twig `sort_by` filter. You can use this
     * filter to e.g. sort the pages array by a arbitrary meta value. Calling
     * `{{ pages|sort_by("meta:nav"|split(":")) }}` returns all pages sorted by
     * the meta value `nav`. Please note the `"meta:nav"|split(":")` part of
     * the example. The sorting algorithm will never assume equality of two
     * values, it will then fall back to the original order. The result is
     * always sorted in ascending order, apply Twigs `reverse` filter to
     * achieve a descending order.
     *
     * @param  array|Traversable $var         variable to sort
     * @param  mixed             $sortKeyPath key to use for sorting; either
     *     a scalar or a array interpreted as key path (i.e. ['foo', 'bar']
     *     will sort $var by $item['foo']['bar'])
     * @param  string            $fallback    specify what to do with items
     *     which don't contain the specified sort key; use "bottom" (default)
     *     to move those items to the end of the sorted array, "top" to rank
     *     them first, or "keep" to keep the original order of those items
     * @return array                          sorted array
     */
    public function sortByFilter($var, $sortKeyPath, $fallback = 'bottom')
    {
        if (is_object($var) && is_a($var, 'Traversable')) {
            $var = iterator_to_array($var, true);
        } elseif (!is_array($var)) {
            throw new Twig_Error_Runtime(sprintf(
                'The sort_by filter only works with arrays or "Traversable", got "%s"',
                is_object($var) ? get_class($var) : gettype($var)
            ));
        }
        if (($fallback !== 'top') && ($fallback !== 'bottom') && ($fallback !== 'keep')) {
            throw new Twig_Error_Runtime('The sort_by filter only supports the "top", "bottom" and "keep" fallbacks');
        }

        $twigExtension = $this;
        $varKeys = array_keys($var);
        uksort($var, function ($a, $b) use ($twigExtension, $var, $varKeys, $sortKeyPath, $fallback, &$removeItems) {
            $aSortValue = $twigExtension->getKeyOfVar($var[$a], $sortKeyPath);
            $aSortValueNull = ($aSortValue === null);

            $bSortValue = $twigExtension->getKeyOfVar($var[$b], $sortKeyPath);
            $bSortValueNull = ($bSortValue === null);

            if ($aSortValueNull xor $bSortValueNull) {
                if ($fallback === 'top') {
                    return ($aSortValueNull - $bSortValueNull) * -1;
                } elseif ($fallback === 'bottom') {
                    return ($aSortValueNull - $bSortValueNull);
                }
            } elseif (!$aSortValueNull && !$bSortValueNull) {
                if ($aSortValue != $bSortValue) {
                    return ($aSortValue > $bSortValue) ? 1 : -1;
                }
            }

            // never assume equality; fallback to original order
            $aIndex = array_search($a, $varKeys);
            $bIndex = array_search($b, $varKeys);
            return ($aIndex > $bIndex) ? 1 : -1;
        });

        return $var;
    }

    /**
     * Returns the value of a variable item specified by a scalar key or a
     * arbitrary deep sub-key using a key path
     *
     * @param  array|Traversable|ArrayAccess|object $var     base variable
     * @param  mixed                                $keyPath scalar key or a
     *     array interpreted as key path (when passing e.g. ['foo', 'bar'],
     *     the method will return $var['foo']['bar']) specifying the value
     * @return mixed                                         the requested
     *     value or NULL when the given key or key path didn't match
     */
    public static function getKeyOfVar($var, $keyPath)
    {
        if (empty($keyPath)) {
            return null;
        } elseif (!is_array($keyPath)) {
            $keyPath = array($keyPath);
        }

        foreach ($keyPath as $key) {
            if (is_object($var)) {
                if (is_a($var, 'ArrayAccess')) {
                    // use ArrayAccess, see below
                } elseif (is_a($var, 'Traversable')) {
                    $var = iterator_to_array($var);
                } elseif (isset($var->{$key})) {
                    $var = $var->{$key};
                    continue;
                } elseif (is_callable(array($var, 'get' . ucfirst($key)))) {
                    try {
                        $var = call_user_func(array($var, 'get' . ucfirst($key)));
                        continue;
                    } catch (BadMethodCallException $e) {
                        return null;
                    }
                } else {
                    return null;
                }
            } elseif (!is_array($var)) {
                return null;
            }

            if (isset($var[$key])) {
                $var = $var[$key];
                continue;
            }

            return null;
        }

        return $var;
    }
}
