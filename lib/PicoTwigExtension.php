<?php
/**
 * This file is part of Pico. It's copyrighted by the contributors recorded
 * in the version control history of the file, available from the following
 * original location:
 *
 * <https://github.com/picocms/Pico/blob/master/lib/PicoTwigExtension.php>
 *
 * SPDX-License-Identifier: MIT
 * License-Filename: LICENSE
 */

declare(strict_types=1);

use Twig\Error\RuntimeError as TwigRuntimeError;
use Twig\Extension\AbstractExtension as AbstractTwigExtension;
use Twig\Extension\ExtensionInterface as TwigExtensionInterface;
use Twig\TwigFilter;
use Twig\TwigFunction;

/**
 * Pico's Twig extension to implement additional filters
 *
 * @author  Daniel Rudolf
 * @link    https://picocms.org
 * @license https://opensource.org/licenses/MIT The MIT License
 * @version 3.0
 */
class PicoTwigExtension extends AbstractTwigExtension
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
     * @see Pico
     *
     * @return Pico the extension's instance of Pico
     */
    public function getPico(): Pico
    {
        return $this->pico;
    }

    /**
     * Returns the name of the extension
     *
     * @see TwigExtensionInterface::getName()
     *
     * @return string the extension name
     */
    public function getName(): string
    {
        return 'PicoTwigExtension';
    }

    /**
     * Returns a list of Pico-specific Twig filters
     *
     * @see TwigExtensionInterface::getFilters()
     *
     * @return TwigFilter[] array of Pico's Twig filters
     */
    public function getFilters(): array
    {
        return [
            'markdown' => new TwigFilter('markdown', [ $this, 'markdownFilter' ], [ 'is_safe' => [ 'html' ] ]),
            'sort_by' => new TwigFilter('sort_by', [ $this, 'sortByFilter' ]),
            'link' => new TwigFilter('link', [ $this->pico, 'getPageUrl' ]),
            'url' => new TwigFilter('url', [ $this->pico, 'substituteUrl' ]),
        ];
    }

    /**
     * Returns a list of Pico-specific Twig functions
     *
     * @see TwigExtensionInterface::getFunctions()
     *
     * @return TwigFunction[] array of Pico's Twig functions
     */
    public function getFunctions(): array
    {
        return [
            'url_param' => new TwigFunction('url_param', [ $this, 'urlParamFunction' ]),
            'form_param' => new TwigFunction('form_param', [ $this, 'formParamFunction' ]),
            'page' => new TwigFunction('page', [ $this, 'pageFunction' ]),
            'pages' => new TwigFunction('pages', [ $this, 'pagesFunction' ]),
        ];
    }

    /**
     * Parses a markdown string to HTML
     *
     * This method is registered as the Twig `markdown` filter. You can use it
     * to e.g. parse a meta variable (`{{ meta.description|markdown }}`).
     * Don't use it to parse the contents of a page, use the `content` filter
     * instead, what ensures the proper preparation of the contents.
     *
     * @see Pico::substituteFileContent()
     * @see Pico::parseFileContent()
     *
     * @param string|null $markdown   markdown to parse
     * @param array       $meta       meta data to use for %meta.*% replacement
     * @param bool        $singleLine whether to parse a single line of markup
     *
     * @return string parsed HTML
     */
    public function markdownFilter(?string $markdown, array $meta = [], bool $singleLine = false): string
    {
        $markdown = $this->getPico()->substituteFileContent($markdown ?? '', $meta);
        return $this->getPico()->parseFileContent($markdown, $singleLine);
    }

    /**
     * Sorts an array by one of its keys or a arbitrary deep sub-key
     *
     * This method is registered as the Twig `sort_by` filter. You can use this
     * filter to e.g. sort the pages array by a arbitrary meta value. Calling
     * `{{ pages|sort_by([ "meta", "nav" ]) }}` returns all pages sorted by the
     * meta value `nav`. The sorting algorithm will never assume equality of
     * two values, it will then fall back to the original order. The result is
     * always sorted in ascending order, apply Twigs `reverse` filter to
     * achieve a descending order.
     *
     * @param array|Traversable $var         variable to sort
     * @param mixed             $sortKeyPath key to use for sorting; either
     *     a scalar or a array interpreted as key path (i.e. ['foo', 'bar']
     *     will sort $var by $item['foo']['bar'])
     * @param string            $fallback    specify what to do with items
     *     which don't contain the specified sort key; use "bottom" (default)
     *     to move these items to the end of the sorted array, "top" to rank
     *     them first, "keep" to keep the original order, or "remove" to remove
     *     these items
     *
     * @return array sorted array
     *
     * @throws TwigRuntimeError
     */
    public function sortByFilter($var, $sortKeyPath, string $fallback = 'bottom'): array
    {
        if (is_object($var) && ($var instanceof Traversable)) {
            $var = iterator_to_array($var, true);
        } elseif (!is_array($var)) {
            throw new TwigRuntimeError(sprintf(
                'The sort_by filter only works with arrays or "Traversable", got "%s"',
                is_object($var) ? get_class($var) : gettype($var)
            ));
        }
        if (($fallback !== 'top') && ($fallback !== 'bottom') && ($fallback !== 'keep') && ($fallback !== "remove")) {
            throw new TwigRuntimeError(
                'The sort_by filter only supports the "top", "bottom", "keep" and "remove" fallbacks'
            );
        }

        $twigExtension = $this;
        $varKeys = array_keys($var);
        $removeItems = [];
        uksort($var, function ($a, $b) use ($twigExtension, $var, $varKeys, $sortKeyPath, $fallback, &$removeItems) {
            $aSortValue = $twigExtension->getKeyOfVar($var[$a], $sortKeyPath);
            $aSortValueNull = ($aSortValue === null);

            $bSortValue = $twigExtension->getKeyOfVar($var[$b], $sortKeyPath);
            $bSortValueNull = ($bSortValue === null);

            if (($fallback === 'remove') && ($aSortValueNull || $bSortValueNull)) {
                if ($aSortValueNull) {
                    $removeItems[$a] = $var[$a];
                }
                if ($bSortValueNull) {
                    $removeItems[$b] = $var[$b];
                }
                return ($aSortValueNull - $bSortValueNull);
            } elseif ($aSortValueNull xor $bSortValueNull) {
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

        if ($removeItems) {
            $var = array_diff_key($var, $removeItems);
        }

        return $var;
    }

    /**
     * Returns the value of a variable item specified by a scalar key or a
     * arbitrary deep sub-key using a key path
     *
     * @param array|Traversable|ArrayAccess|object $var     base variable
     * @param mixed                                $keyPath scalar key or a
     *     array interpreted as key path (when passing e.g. ['foo', 'bar'], the
     *     method will return $var['foo']['bar']) specifying the value
     *
     * @return mixed the requested value or NULL when the given key or key path
     *     didn't match
     */
    public static function getKeyOfVar($var, $keyPath)
    {
        if (!$keyPath) {
            return null;
        } elseif (!is_array($keyPath)) {
            $keyPath = [ $keyPath ];
        }

        foreach ($keyPath as $key) {
            if (is_object($var)) {
                if ($var instanceof ArrayAccess) {
                    // use ArrayAccess, see below
                } elseif ($var instanceof Traversable) {
                    $var = iterator_to_array($var);
                } elseif (isset($var->{$key})) {
                    $var = $var->{$key};
                    continue;
                } elseif (is_callable([ $var, 'get' . ucfirst($key) ])) {
                    try {
                        $var = call_user_func([ $var, 'get' . ucfirst($key) ]);
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

    /**
     * Filters a URL GET parameter with a specified filter
     *
     * The Twig function disallows the use of the `callback` filter.
     *
     * @see Pico::getUrlParameter()
     *
     * @param string                    $name    name of the URL GET parameter
     *     to filter
     * @param int|string                $filter  the filter to apply
     * @param mixed|array               $options either a associative options
     *     array to be used by the filter or a scalar default value
     * @param int|string|int[]|string[] $flags   flags and flag strings to be
     *     used by the filter
     *
     * @return mixed either the filtered data, FALSE if the filter fails, or
     *     NULL if the URL GET parameter doesn't exist and no default value is
     *     given
     */
    public function urlParamFunction(string $name, $filter = '', $options = null, $flags = null)
    {
        $filter = $filter ? (is_string($filter) ? filter_id($filter) : (int) $filter) : false;
        if (!$filter || ($filter === FILTER_CALLBACK)) {
            return false;
        }

        return $this->pico->getUrlParameter($name, $filter, $options, $flags);
    }

    /**
     * Filters a HTTP POST parameter with a specified filter
     *
     * The Twig function disallows the use of the `callback` filter.
     *
     * @see Pico::getFormParameter()
     *
     * @param string                    $name    name of the HTTP POST
     *     parameter to filter
     * @param int|string                $filter  the filter to apply
     * @param mixed|array               $options either a associative options
     *     array to be used by the filter or a scalar default value
     * @param int|string|int[]|string[] $flags   flags and flag strings to be
     *     used by the filter
     *
     * @return mixed either the filtered data, FALSE if the filter fails, or
     *     NULL if the HTTP POST parameter doesn't exist and no default value
     *     is given
     */
    public function formParamFunction(string $name, $filter = '', $options = null, $flags = null)
    {
        $filter = $filter ? (is_string($filter) ? filter_id($filter) : (int) $filter) : false;
        if (!$filter || ($filter === FILTER_CALLBACK)) {
            return false;
        }

        return $this->pico->getFormParameter($name, $filter, $options, $flags);
    }

    /**
     * Returns the data of a single page
     *
     * @param string $id identifier of the page to return
     *
     * @return array|null the data of the page, or NULL
     */
    public function pageFunction(string $id): ?array
    {
        $pages = $this->getPico()->getPages();
        return $pages[$id] ?? null;
    }

    /**
     * Returns all pages within a particular branch of Pico's page tree
     *
     * This function should be used most of the time when dealing with Pico's
     * pages array, as it allows one to easily traverse Pico's pages tree
     * ({@see Pico::getPageTree()}) to retrieve a subset of Pico's pages array
     * in a very convenient and performant way.
     *
     * The function's default parameters are `$start = ""`, `$depth = 0`,
     * `$depthOffset = 0` and `$offset = 1`. A positive `$offset` is equivalent
     * to `$depth = $depth + $offset`, `$depthOffset = $depthOffset + $offset`
     * and `$offset = 0`.
     *
     * Consequently the default `$start = ""`, `$depth = 0`, `$depthOffset = 0`
     * and `$offset = 1` is equivalent to `$depth = 1`, `$depthOffset = 1` and
     * `$offset = 0`. `$start = ""` instruct the function to start from the
     * root node (i.e. the node of Pico's main index page at `index.md`).
     * `$depth` tells the function what pages to return. In this example,
     * `$depth = 1` matches the start node (i.e. the zeroth generation) and all
     * its descendant pages until the first generation (i.e. the start node's
     * children). `$depthOffset` instructs the function to exclude some of the
     * older generations. `$depthOffset = 1` specifically tells the function
     * to exclude the zeroth generation, so that the function returns all of
     * Pico's main index page's direct child pages (like `sub/index.md` and
     * `page.md`, but not `sub/page.md`) only.
     *
     * Passing `$depthOffset = -1` only is the same as passing `$start = ""`,
     * `$depth = 1`, `$depthOffset = 0` and `$offset = 0`. The only difference
     * is that `$depthOffset` won't exclude the zeroth generation, so that the
     * function returns Pico's main index page as well as all of its direct
     * child pages.
     *
     * Passing `$depth = 0`, `$depthOffset = -2` and `$offset = 2` is the same
     * as passing `$depth = 2`, `$depthOffset = 0` and `$offset = 0`. Both will
     * return the zeroth, first and second generation of pages. For Pico's main
     * index page this would be `index.md` (0th gen), `sub/index.md` (1st gen),
     * `sub/page.md` (2nd gen) and `page.md` (1st gen). If you want to return
     * 2nd gen pages only, pass `$offset = 2` only (with implicit `$depth = 0`
     * and `$depthOffset = 0` it's the same as `$depth = 2`, `$depthOffset = 2`
     * and `$offset = 0`).
     *
     * Instead of an integer you can also pass `$depth = null`. This is the
     * same as passing an infinitely large number as `$depth`, so that this
     * function simply returns all descendant pages. Consequently passing
     * `$start = ""`, `$depth = null`, `$depthOffset = 0` and `$offset = 0`
     * returns Pico's full pages array.
     *
     * If `$depth` is negative after taking `$offset` into consideration, the
     * function will throw a {@see TwigRuntimeError} exception, since this
     * would simply make no sense and is likely an error. Passing a negative
     * `$depthOffset` is equivalent to passing `$depthOffset = 0`.
     *
     * But what about a negative `$offset`? Passing `$offset = -1` instructs
     * the function not to start from the given `$start` node, but its parent
     * node. Consequently `$offset = -2` instructs the function to use the
     * `$start` node's grandparent node. Obviously this won't make any sense
     * for Pico's root node, but just image `$start = "sub/index"`. Passing
     * this together with `$offset = -1` is equivalent to `$start = ""` and
     * `$offset = 0`.
     *
     * @param string   $start       name of the node to start from
     * @param int|null $depth       return pages until the given maximum depth;
     *     pass NULL to return all descendant pages; defaults to 0
     * @param int      $depthOffset start returning pages from the given
     *     minimum depth; defaults to 0
     * @param int      $offset      ascend (positive) or descend (negative) the
     *     given number of branches before returning pages; defaults to 1
     *
     * @return array[] the data of the matched pages
     *
     * @throws TwigRuntimeError
     */
    public function pagesFunction(string $start = '', ?int $depth = 0, int $depthOffset = 0, int $offset = 1): array
    {
        $start = (string) $start;
        if (basename($start) === 'index') {
            $start = dirname($start);
        }

        for (; $offset < 0; $offset++) {
            if (in_array($start, [ '', '.', '/' ], true)) {
                $offset = 0;
                break;
            }

            $start = dirname($start);
        }

        $depth = ($depth !== null) ? $depth + $offset : null;
        $depthOffset = $depthOffset + $offset;

        if (($depth !== null) && ($depth < 0)) {
            throw new TwigRuntimeError('The pages function doesn\'t support negative depths');
        }

        $pageTree = $this->getPico()->getPageTree();
        if (in_array($start, [ '', '.', '/' ], true)) {
            if (($depth === null) && ($depthOffset <= 0)) {
                return $this->getPico()->getPages();
            }

            $startNode = isset($pageTree['']['/']) ? $pageTree['']['/'] : null;
        } else {
            $branch = dirname($start);
            $branch = ($branch !== '.') ? $branch : '/';
            $node = (($branch !== '/') ? $branch . '/' : '') . basename($start);
            $startNode = isset($pageTree[$branch][$node]) ? $pageTree[$branch][$node] : null;
        }

        if (!$startNode) {
            return [];
        }

        $getPagesClosure = function ($nodes, $depth, $depthOffset) use (&$getPagesClosure) {
            $pages = [];
            foreach ($nodes as $node) {
                if (isset($node['page']) && ($depthOffset <= 0)) {
                    $pages[$node['page']['id']] = &$node['page'];
                }
                if (isset($node['children']) && ($depth > 0)) {
                    $pages += $getPagesClosure($node['children'], $depth - 1, $depthOffset - 1);
                }
            }

            return $pages;
        };

        return $getPagesClosure(
            [ $startNode ],
            ($depth !== null) ? $depth : INF,
            $depthOffset
        );
    }
}
