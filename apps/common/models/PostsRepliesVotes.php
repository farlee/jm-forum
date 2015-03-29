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

namespace Jimi\Models;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Behavior\Timestampable;

/**
 * Class PostsRepliesVotes
 *
 * @property \Jimi\Models\PostsReplies postReply
 * @property \Jimi\Models\Users        user
 *
 * @package Jimi\Models
 */
class PostsRepliesVotes extends Model
{

    public $id;

    public $posts_replies_id;

    public $users_id;

    public $vote;

    public $created_at;

    const VOTE_UP = 1;

    const VOTE_DOWN = 1;

    public function initialize()
    {
        $this->belongsTo(
            'posts_replies_id',
            'Jimi\Models\PostsReplies',
            'id',
            array(
                'alias' => 'postReply'
            )
        );

        $this->belongsTo(
            'users_id',
            'Jimi\Models\Users',
            'id',
            array(
                'alias' => 'user'
            )
        );

        $this->addBehavior(
            new Timestampable(array(
                'beforeValidationOnCreate' => array(
                    'field' => 'created_at'
                )
            ))
        );
    }

    public function afterSave()
    {
        if ($this->id) {
            $this->postReply->clearCache();
        }
    }
}
