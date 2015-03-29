<?php

/*
 +------------------------------------------------------------------------+
 | Jimi                                                             |
 +------------------------------------------------------------------------+
 | Copyright (c) 2013-2014 Phalcon Team and contributors                  |
 +------------------------------------------------------------------------+
 | This source file is subject to the New BSD License that is bundled     |
 | with this package in the file docs/LICENSE.txt.                        |
 |                                                                        |
 | If you did not receive a copy of the license and are unable to         |
 | obtain it through the world-wide-web, please send an email             |
 | to license@phalconphp.com so we can send you a copy immediately.       |
 +------------------------------------------------------------------------+
*/

namespace Jimi\Badges\Badge;

use Jimi\Models\Users;
use Jimi\Models\UsersBadges;
use Jimi\Models\Categories;

use Jimi\Models\PostsVotes;
use Jimi\Models\PostsRepliesVotes;
use Jimi\Badges\BadgeBase;

/**
 * Jimi\Badges\Badge\Populist
 *
 * Asked a question with more than 15 replies
 */
class Populist extends BadgeBase
{

    protected $name = 'Populist';

    protected $description = 'Asked a question with more than 15 replies';

    /**
     * Check whether the user already have this badge
     *
     * @param Users $user
     * @return boolean
     */
    public function has(Users $user)
    {
        $has = false;
        $noBountyCategories = $this->getNoBountyCategories();
        $conditions = 'categories_id NOT IN (' . join(', ', $noBountyCategories) . ') AND number_replies >= 15';
        $posts = $user->getPosts(array($conditions, 'columns' => 'id', 'order' => 'created_at DESC'));
        foreach ($posts as $post) {
            $has |= (UsersBadges::count(array(
                'users_id = ?0 AND badge = ?1 AND type = "P" AND code1 = ?2',
                'bind' => array($user->id, $this->getName(), $post->id)
            )) == 0);
        }
        return !$has;
    }

    /**
     * Check whether the user can have the badge
     *
     * @param  Users $user
     * @return boolean
     */
    public function canHave(Users $user)
    {
        $ids = array();
        $noBountyCategories = $this->getNoBountyCategories();
        $conditions = 'categories_id NOT IN (' . join(', ', $noBountyCategories) . ') AND number_replies >= 15';
        $posts = $user->getPosts(array($conditions, 'columns' => 'id', 'order' => 'created_at DESC'));
        foreach ($posts as $post) {
            $have = UsersBadges::count(array(
                'users_id = ?0 AND badge = ?1 AND type = "P" AND code1 = ?2',
                'bind' => array($user->id, $this->getName(), $post->id)
            ));
            if (!$have) {
                $ids[] = $post->id;
            }
        }
        return $ids;
    }

    /**
     * Add the badge to ther user
     *
     * @param Users $user
     * @param array $extra
     */
    public function add(Users $user, $extra = null)
    {
        $name = $this->getName();
        foreach ($extra as $id) {
            $userBadge = new UsersBadges();
            $userBadge->users_id = $user->id;
            $userBadge->badge    = $name;
            $userBadge->type     = 'P';
            $userBadge->code1    = $id;
            var_dump($userBadge->save());
        }
    }
}
