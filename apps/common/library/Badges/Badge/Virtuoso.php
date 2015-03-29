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
 * Jimi\Badges\Badge\Virtuoso
 *
 * More than 5 accepted answers in specific categories
 */
class Virtuoso extends BadgeBase
{

    protected $name = 'Virtuoso';

    protected $description = 'More than 5 accepted answers in specific categories';

    protected $query;

    public function getExpertQuery(Users $user)
    {
        if (!$this->query) {
            $this->query = $user->getModelsManager()->createBuilder()
                ->columns(array('p.categories_id', 'COUNT(*)'))
                ->from(array('r' => 'Jimi\Models\PostsReplies'))
                ->join('Jimi\Models\Posts', null, 'p')
                ->where('r.users_id = ?0 AND r.accepted = "Y"')
                ->notInWhere('p.categories_id', $this->getNoBountyCategories())
                ->groupBy('p.categories_id')
                ->having('COUNT(*) >= 5')
                ->getQuery();
        }
        return $this->query;
    }

    /**
     * Check whether the user already have this badge
     *
     * @param Users $user
     * @return boolean
     */
    public function has(Users $user)
    {
        $has = false;
        $categories = $this->getExpertQuery($user)->execute(array($user->id));
        foreach ($categories as $categoryRow) {
            $category = Categories::findFirstById($categoryRow->categories_id);
            if ($category) {
                $badgeName = $category->name . ' / ' . $this->getName();
                $has |= (UsersBadges::count(array(
                    'users_id = ?0 AND badge = ?1',
                    'bind' => array($user->id, $badgeName)
                )) == 0);
            }
        }
        return (boolean) !$has;
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
        $categories = $this->getExpertQuery($user)->execute(array($user->id));
        foreach ($categories as $categoryRow) {
            $category = Categories::findFirstById($categoryRow->categories_id);
            if ($category) {
                $ids[] = $category;
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
        foreach ($extra as $category) {
            $userBadge = new UsersBadges();
            $userBadge->users_id = $user->id;
            $userBadge->badge    = $category->name . ' / ' . $this->getName();
            var_dump($userBadge->save());
        }
    }
}
