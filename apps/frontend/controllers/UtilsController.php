<?php


namespace Jimi\Frontend;

use Phalcon\Mvc\Controller;
use Jimi\Models\Users;
use Jimi\Models\Posts;
use Jimi\Models\PostsReplies;
use Phalcon\Http\Response;

/**
 * Class UtilsController
 *
 * @package Jimi\Frontend
 */
class UtilsController extends Controller
{

    public function initialize()
    {
        $this->view->disable();
    }

    public function karmaAction()
    {
        foreach (Users::find() as $user) {

            if ($user->karma === null) {

                $parametersNumbersPost = array(
                    'users_id = ?0',
                    'bind' => array($user->id)
                );
                $numberPosts = Posts::count($parametersNumbersPost);

                $parametersNumberReplies = array(
                    'users_id = ?0',
                    'bind' => array($user->id)
                );
                $numberReplies = PostsReplies::count($parametersNumberReplies);

                $user->karma = ($numberReplies * 10 + $numberPosts * 5);
                $user->votes = intval($user->karma / 50);
                $user->save();
            }
        }
    }

    /**
     * @return Response
     */
    public function previewAction()
    {
        $response = new Response();
        if ($this->request->isPost()) {
            if ($this->session->get('identity')) {
                $content = $this->request->getPost('content');
                $response->setContent($this->markdown->render($this->escaper->escapeHtml($content)));
            }
        }
        return $response;
    }
}
