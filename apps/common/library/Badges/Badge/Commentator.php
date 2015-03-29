<?php


namespace Jimi\Badges\Badge;

use Jimi\Models\Users;
use Jimi\Models\UsersBadges;
use Jimi\Models\PostsVotes;
use Jimi\Models\PostsRepliesVotes;
use Jimi\Badges\BadgeBase;

/**
 * Jimi\Badges\Badge\Commentator
 *
 * More than 10 replies
 */
class Commentator extends BadgeBase
{

    protected $name = 'Commentator';

    protected $description = 'More than 10 replies on different threads';

    /**
     * Check whether the user can have the badge
     *
     * @param Users $user
     * @return boolean
     */
    public function canHave(Users $user)
    {
        return $user->countReplies() >= 10;
    }
}
