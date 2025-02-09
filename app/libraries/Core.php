<?php
class Core {
    protected $currentController = 'CustomerController'; // Default controller
    protected $currentMethod = 'index'; // Default method
    protected $params = []; // Default params

    public function __construct() {
        $url = $this->getURL();

        // Check if the controller exists
        if (isset($url[0]) && file_exists('../app/controllers/' . ucwords($url[0]) . '.php')) {
            $this->currentController = ucwords($url[0]);
            unset($url[0]);
        }

        // Require the controller
        require_once '../app/controllers/' . $this->currentController . '.php';
        $this->currentController = new $this->currentController;

        // Check for a method
        if (isset($url[1]) && method_exists($this->currentController, $url[1])) {
            $this->currentMethod = $url[1];
            unset($url[1]);
        }

        // Get params
        $this->params = $url ? array_values($url) : [];

        // Call the method
        call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
    }

    public function getURL() {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            return explode('/', $url);
        }
        return [];
    }
}
