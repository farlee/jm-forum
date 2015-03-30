<?php


namespace Jimi\Backend;

use Jimi\Models\Categories;
use Jimi\Models\Posts;
use Jimi\Models\PostsReplies;
use Jimi\Models\TopicTracking;
use Phalcon\Mvc\View;

/**
 * Class IndexController
 *
 * @package Jimi\Backend
 */
class IndexController extends ControllerBase
{

    /**
     * @return \Phalcon\Http\ResponseInterface
     */
    public function indexAction()
    {
        $this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);

        $this->tag->setTitle('后台管理');
        $userId = $this->session->get('identity');

        foreach (Categories::find() as $category) {
            if (count(Posts::find("categories_id=".$category->id)) > 0) {
                $last_author[$category->id] = $this
                ->modelsManager
                ->createBuilder()
                ->from(array('p' => 'Jimi\Models\Posts'))
                ->where('p.categories_id = "'.$category->id.'"')
                ->join('Jimi\Models\Users', "u.id = p.users_id", 'u')
                ->columns(array('p.users_id as users_id','u.name as name_user','p.title as post1_title','p.slug as post1_slug','p.id as post1_id'))
                ->orderBy('p.id DESC')
                ->limit(1)
                ->getQuery()
                ->execute();
            } else {
                $last_author[$category->id] = 0;
            }

          //SQL

            $sql[$category->id] = "SELECT * FROM `posts` JOIN topic_tracking ON topic_tracking.topic_id WHERE concat(posts.id) AND NOT(FIND_IN_SET(posts.id, topic_tracking.topic_id)) AND categories_id = '{$category->id}' AND topic_tracking.user_id = '{$userId}'";
            $not_read[$category->id] = $this->db->query($sql[$category->id]);

        }

        if ($userId !='') {
            $check_topic = new TopicTracking();
            $check_topic->user_id = ''.$this->session->get('identity').'';
            $check_topic->topic_id = '9999999';
            $check_topic->create();
        }

        $this->view->last_author = $last_author;
        $this->view->not_read = $not_read;
        $this->view->logged = $this->session->get('identity');
        $this->view->categories = Categories::find();
    }

    public function r404Action(){
        $this->response->setStatusCode(404, "Not Found");
        //OR
        //$this->response->setRawHeader("HTTP/1.1 404 Not Found");

        //$this->response->send();
        //die(print_r('404'));

        //render 404 view...

    }
}
