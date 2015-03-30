<?php


namespace Jimi\Frontend;

use Phalcon\Http\Response;
use Phalcon\Mvc\Controller;
use Jimi\Models\Posts;
use Jimi\Models\Users;
use Jimi\Models\Notifications;
use Jimi\Models\ActivityNotifications;
use Jimi\Models\IrcLog;
use Jimi\Badges\Manager as BadgeManager;

/**
 * Class HelpController
 *
 * @package Jimi\Frontend
 */
class HelpController extends ControllerBase
{

    public function initialize()
    {
        $this->tag->setTitle('Help');
        $this->view->setTemplateBefore(array('discussions'));
    }

    public function indexAction()
    {

    }

    public function karmaAction()
    {

    }

    public function markdownAction()
    {

    }

    public function votingAction()
    {

    }

    public function moderatorsAction()
    {

    }

    public function aboutAction()
    {

    }

    public function createAction()
    {

    }

    public function badgesAction()
    {
        $manager = new BadgeManager;
        $this->view->badges = $manager->getBadges();
    }

    public function statsAction()
    {
        $this->view->threads         = Posts::count();
        $this->view->replies         = Posts::sum(array('column' => 'number_replies'));
        $this->view->votes           = Posts::sum(array('column' => 'votes_up + votes_down'));
        $this->view->users           = Users::count();
        $this->view->karma           = Users::sum(array('column' => 'karma'));
        $this->view->notifications   = Notifications::count();
        $this->view->unotifications  = ActivityNotifications::count();
        $this->view->views           = Posts::sum(array('column' => 'number_views'));
        $this->view->irc             = IrcLog::count();
    }
}
