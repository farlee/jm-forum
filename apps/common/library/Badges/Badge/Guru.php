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
use Jimi\Badges\BadgeBase;

/**
 * Jimi\Badges\Badge\Guru
 *
 * Reach 15000 or more of Karma
 */
class Guru extends BadgeBase
{

    protected $name = 'Guru';

    protected $description = 'Reached 15000 or more of Karma';

    /**
     * Check whether the user can have the badge
     *
     * @param Users $user
     * @return boolean
     */
    public function canHave(Users $user)
    {
        return $user->karma >= 15000;
    }
}
