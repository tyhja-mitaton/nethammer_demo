<?php

namespace matodor\chat\core;

class ChatRights
{
    const NONE           = 0;
    const DELETE_MESSAGE = 1 << 0;
    const DELETE_ROOM    = 1 << 1;

    const OWNER =
        self::DELETE_MESSAGE |
        self::DELETE_ROOM;
}

?>