<?php

namespace App\Middlewares;

use Symfony\Component\HttpFoundation\Request;

class Csrf
{
    private $formKey = "_csrf";

    private $sessionKey = "csrf";

    /**
     * Process middleware
     *
     * @return void
     */
    public function process(Request $request)
    {
        if( in_array($request->getMethod(), ["POST", "PUT", "DELETE"]) ) {
            $params = $request->request->all();

            if( !isset($params[$this->formKey]) || empty($params[$this->formKey]) )
                return $this->reject("CSRF token not found");

            if( !isset($_SESSION[$this->sessionKey]) || empty($_SESSION[$this->sessionKey]) )
                return $this->reject("CSRF token not found");

            if( $params[$this->formKey] !== $_SESSION[$this->sessionKey] )
                return $this->reject("CSRF token mismatch");
        } else {
            $this->generateToken();
        }
    }

    /**
     * Generate CSRF token
     *
     * @return string
     */
    public function generateToken()
    {
        $token = bin2hex(random_bytes(16));
        $_SESSION[$this->sessionKey] = $token;
        return $token;
    }

    /**
     * Reject request
     *
     * @param string $str
     * @return void
     */
    private function reject(string $str = "Invalid CSRF token")
    {
        alert("error", $str);
        return back();
    }
}
