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
 * Jimi\Badges\Badge\SelfLearner
 *
 * Awarded to one that answer his own question
 */
class SelfLearner extends BadgeBase
{

    protected $name = 'Self-Learner';

    protected $description = 'Asked a question and accepted his/her own answer';

    /**
     * Check whether the user can have the badge
     *
     * @param Users $user
     * @return boolean
     */
    public function canHave(Users $user)
    {
        $noBountyCategories = $this->getNoBountyCategories();
        $conditions = 'categories_id NOT IN (' . join(', ', $noBountyCategories) . ') AND accepted_answer = "Y"';
        $posts = $user->getPosts(array($conditions, 'order' => 'created_at DESC'));
        foreach ($posts as $post) {
            $ownReply = $post->countReplies(array(
                "accepted = 'Y' AND users_id = ?0",
                'bind' => array($user->id)
            ));
            if ($ownReply) {
                return true;
            }
        }
        return false;
    }
}
