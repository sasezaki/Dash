<?php
/**
 * Dash
 *
 * @link      http://github.com/DASPRiD/Dash For the canonical source repository
 * @copyright 2013 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace Dash\Router\Http;

use Dash\Router\Http\Parser\ParseResult;
use Dash\Router\RouteMatchInterface;

/**
 * HTTP router specific route match.
 */
class RouteMatch implements RouteMatchInterface
{
    /**
     * @var null|string
     */
    protected $routeName;

    /**
     * @var array
     */
    protected $params = [];

    /**
     * Creates a new route match, optionally initialized with parameters.
     *
     * @param array $params
     */
    public function __construct(array $params = [])
    {
        $this->params = $params;
    }

    /**
     * @param string $routeName
     */
    public function prependRouteName($routeName)
    {
        if ($this->routeName === null) {
            $this->routeName = $routeName;
        } else {
            $this->routeName = $routeName . '/' . $this->routeName;
        }
    }

    /**
     * Gets the name of the matched route.
     *
     * @return string
     */
    public function getRouteName()
    {
        return $this->routeName;
    }

    /**
     * Adds the parameters of a parse result to the match.
     *
     * @param ParseResult $parseResult
     */
    public function addParseResult(ParseResult $parseResult)
    {
        $this->params = $parseResult->getParams() + $this->params;
    }

    /**
     * Merges another route match with this one.
     *
     * @param RouteMatch $routeMatch
     */
    public function merge(RouteMatch $routeMatch)
    {
        $this->params = $routeMatch->getParams() + $this->params;
        $this->prependRouteName($routeMatch->getRouteName());
    }

    public function setParam($name, $value)
    {
        $this->params[$name] = $value;
    }

    public function getParam($name, $default = null)
    {
        if (isset($this->params[$name]) || array_key_exists($name, $this->params)) {
            return $this->params[$name];
        }

        return $default;
    }

    public function getParams()
    {
        return $this->params;
    }
}