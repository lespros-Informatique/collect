<?php
class Router 
{
    private $routes = [];

    public function addRoute($path, $callback)
    {
        $this->routes[$path] = $callback;
    }

    public function run($url)
    {
        foreach ($this->routes as $path => $callback) {
            // Transformer les paramètres optionnels : /{param}? devient (/param)?
            $pattern = preg_replace('/\/\{([a-zA-Z0-9_]+)\}/', '(?:/([a-zA-Z0-9_-]+))?', $path);
            $pattern = '#^' . $pattern . '$#';

            if (preg_match($pattern, $url, $matches)) {
                array_shift($matches); // Supprimer l'URL complète capturée
                return call_user_func_array($callback, $matches ?: []);
            }
            
        }
        // rediriger vers la page 404
        require_once '../core/errors/404.php';
        exit;
    }

    public function getRoutes()
    {
        return $this->routes;
    }
}

