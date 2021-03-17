<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class Auth implements FilterInterface
{

    public function before(RequestInterface $request, $arguments = null)
    {
        $this->session = \Config\Services::session();
        if (!$this->session->has('isLoggedIn')) {
            return redirect()->to('/login');
        }
    }


    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {

        //to do
    }
}
