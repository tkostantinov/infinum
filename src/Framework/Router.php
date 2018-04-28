<?php

namespace Infinum\Framework;

use Exception;

/**
 * Router routes all incomming requests to a specific Controller::action
 *
 * @author developer
 */
class Router
{

    private $routes = [];

    /**
     *
     * @param string $method
     * @param string $url
     * @param string $action
     */
    public function addRoute($method, $url, $action)
    {
        $this->routes[] = array(
            'method' => $method,
            'url' => $url,
            'action' => $action
        );
    }

    /**
     *
     * @param routes array
     */
    public function addRoutes($routes)
    {
        foreach($routes as $route)
            $this->addRoute(...$route);
    }

    /**
     *
     *
     * @return Route
     * @throws Exception - throws Exception if no route is matched!
     */
    public function getMatchedRoute()
    {
        if (strlen($_SERVER['SCRIPT_NAME']) === strlen($_SERVER['REQUEST_URI'])) {
            $requestUri = '/';
        } else {
            $requestUri = substr($_SERVER['REQUEST_URI'], strlen($_SERVER['SCRIPT_NAME']));
        }

        if(strpos($requestUri, '?') !== false)
            $requestUri = substr($requestUri, 0, strpos($requestUri, '?'));

        $httpRequestMethod = $_SERVER['REQUEST_METHOD'];

        foreach ($this->routes as $route) {

            //convert route's parameters
            $pattern = sprintf(
                "@^%s$@D",
                preg_replace('/\\\:[a-zA-Z0-9\_\-]+/', '([a-zA-Z0-9\-\_]+)', preg_quote($route['url']))
            );

            $matches = array();
            if ($httpRequestMethod == $route['method'] && preg_match($pattern, $requestUri, $matches)) {

                // remove the first match and just keep the extracted parameters
                array_shift($matches);

                // call specified controller's actions with the paramaters
                list($controller, $action) = explode("::", $route['action']);
                return $this->createRoute($controller, $action, $matches);
            }
        }

        throw new Exception("No route matched!");
    }

    /**
     *
     * @param string $controller
     * @param string $action
     * @param array $arguments
     *
     * @return Route
     */
    private function createRoute($controller, $action, $arguments)
    {
        return new Route($controller, $action, $arguments);
    }
}