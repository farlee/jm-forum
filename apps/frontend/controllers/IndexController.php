<?php


namespace Jimi\Frontend;

use Phalcon\Mvc\Controller;

/**
 * Class IndexController
 *
 * @package Jimi\Controllers
 */
class IndexController extends ControllerBase
{

    /**
     * @return \Phalcon\Http\ResponseInterface
     */
    public function indexAction()
    {
        $this->flashSession->error('Page not found: ' . $this->escaper->escapeHtml($this->router->getRewriteUri()));
        return $this->response->redirect('categories');
    }
}
