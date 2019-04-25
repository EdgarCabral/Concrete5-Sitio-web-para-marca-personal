<?php

/**
 * -----------------------------------------------------------------------------
 * Generated 2019-03-25T01:15:25+00:00
 *
 * DO NOT EDIT THIS FILE DIRECTLY
 *
 * @item      files.allowed_types
 * @group     conversations
 * @namespace null
 * -----------------------------------------------------------------------------
 */
return [
    'attachments_enabled' => true,
    'subscription_enabled' => false,
    'files' => [
        'allowed_types' => '*.jpg;*.gif;*.jpeg;*.png;*.doc;*.docx;*.zip',
        'guest' => [
            'max_size' => 1,
            'max' => 3,
        ],
        'registered' => [
            'max_size' => 10,
            'max' => 5,
        ],
    ],
];