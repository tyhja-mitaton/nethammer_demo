if (typeof Chat == "undefined" || !Chat)
{
    var Chat = {};
}
var ChatTemplates = function ()
{
    var chatCreateDialog =
        '<div class="create-dialog-container">\
            <form class="create-dialog-block" id="create-dialog-form" method="post">\
                <div class="create-dialog-block__form-group form-group field-question">\
                    <input maxlength="32" id="question" name="CreateDialog[question]" type="text" class="form-control create-dialog-block__input create-dialog-block__input_first" placeholder="${Chat.translation.get("type_you_question")}">\
                    <div class="help-block"></div>\
                </div>\
                <button type="submit" class="btn w-100 create-dialog-block__submit">${Chat.translation.get("new_conversation")}</button>\
            </form>\
        </div>';

    var chatWindow =
        '<div class="chat-dialogs">\
            <div class="dialogs-container__close"></div>\
            <div class="chat-dialogs__block">\
                {{tmpl($data) "chatDialogsListHeader"}}\
                {{tmpl "chatDialogsList"}}\
            </div>\
        </div>';

    var chatDialogsListHeader =
        '<div class="chat-dialogs__header">${dialogs_header}</div>';

    var chatDialogsList =
        '<div class="chat-dialogs__list"></div>';

    var chatListSingleRoom =
        '<div class="chat-dialogs__room" data-room-id="${id}" data-rights="${rights}" data-last-message="{{if lastMessage}}${lastMessage.update_time}{{else}}0{{/if}}">\
            {{tmpl($data) "chatListSingleRoomTitle"}}\
            {{tmpl(lastMessage) "chatListSingleRoomLastMsg"}}\
            <div class="chat-dialogs__new-message{{if has_unread && has_unread == true}} chat-dialogs__new-message_shown{{/if}}"></div>\
            {{if rights > 0}}\
                <div class="chat-actions" data-type="room">\
                    <div class="chat-actions__action chat-actions__toggle"></div>\
                    <div class="chat-actions__action chat-actions__delete"><i class="fa fa-trash" aria-hidden="true"></i></div>\
                </div>\
            {{/if}}\
        </div>';

    var chatListSingleRoomTitle =
        '<div class="chat-dialogs__room-title">\
            {{if !!userTitle}}\
                <div class="chat-dialogs__room-title-self">${userTitle}</div>\
            {{/if}}\
            <div class="chat-dialogs__room-subject">${Chat.translation.get("chat.subject")}: ${title}</div>\
        </div>';

    var chatListSingleRoomLastMsg =
        '<div class="chat-dialogs__last-message">\
            <div class="chat-dialogs__last-message-text">\
                {{if $data && $data.plain_text}}\
                    {{if $data.self}}${Chat.translation.get("chat.self")}: {{else}}{{/if}}\
                    <span>${plain_text}</span>\
                {{else}}\
                    ${Chat.translation.get("chat.empty_history")}\
                {{/if}}\
            </div>\
            {{if $data && $data.plain_text}}\
                <div class="from_now chat-dialogs__last-message-time" data-time="${$data.update_time}">\
                    ${moment.unix($data.update_time).fromNow()}\
                </div>\
            {{/if}}\
        </div>';

    var chatDialog =
        '<div class="chat-dialog" data-id="${id}" data-rights="${rights}">\
            {{tmpl($data) "chatDialogHeader"}}\
            <div class="chat-dialog__messages-container">{{tmpl "chatDialogMessages"}}</div>\
            <div class="chat-dialog__input-wrapper">{{tmpl "chatDialogInput"}}</div>\
        </div>';

    var chatDialogHeader =
        '<div class="chat-dialog__header">\
            <div class="chat-dialog__header-top">\
                <div class="chat-dialog__header-back-button"><i class="fa fa-chevron-left" aria-hidden="true"></i></div>\
                <span class="">${Chat.translation.get("chat.dialog_header_back")}</span>\
                <div class="dialogs-container__close"></div>\
            </div>\
            <div class="chat-dialog__header-info">\
                <div class="chat-dialog__header-avatar"></div>\
                <div class="chat-dialog__header-title">${title}</div>\
            </div>\
        </div>';

    var chatDialogMessages =
        '<div class="chat-dialog__messages"></div>';

    var chatDialogInput =
        '<div class="chat-input">\
            <pre class="chat-input__pre"><br></pre>\
            <input type="file" name="file" class="chat-input__attachment" />\
            <textarea class="chat-input__textarea" name="message" \
                placeholder="${Chat.translation.get("chat.write_you_message_here")}"\
                tabindex="0"></textarea>\
            <div class="chat-input__buttons">\
                <div class="chat-input__button chat-input__button-file"><div class="counter"></div></div>\
                <div class="chat-input__button chat-input__button-ok"></div>\
                <div class="chat-input__button chat-input__button-send"></div>\
            </div>\
        </div>';

    var chatDialogMessageAttachments =
        '<div class="chat-message__attachments">\
            {{each $data}}\
                {{tmpl($value) "chatDialogMessageAttachment"}}\
            {{/each}}\
        </div>';

    var chatDialogMessageAttachment =
        '<div class="chat-message__attachment" data-id="${id}">\
            <a href="${Chat.options.schema["download"]}?token=${token}" target="_blank">\
                <div class="chat-message__attachment-name">${display_name}</div>\
                <div class="chat-message__attachment-info">${Chat.fileSize(size)}</div>\
            </a>\
        </div>';

    var chatDialogMessage =
        '<div data-id="${id}" data-roomId="${roomId}" class="chat-message{{if !!self}} chat-message_self{{/if}}">\
            {{if fromName}}\
                <div class="chat-message__name">${fromName}</div>\
            {{/if}}\
            <div class="chat-message__text">${plain_text}</div>\
            {{if attachments && Object.keys(attachments).length > 0}}\
                {{tmpl(attachments) "chatDialogMessageAttachments"}}\
            {{/if}}\
            <div class="chat-message__time from_now" data-time="${moment(at).unix()}">${moment(at).fromNow()}</div>\
            <div class="chat-actions" data-type="room">\
                <div class="chat-actions__action chat-actions__toggle"></div>\
                <div class="chat-actions__action chat-actions__delete"><i class="fa fa-trash" aria-hidden="true"></i></div>\
            </div>\
        </div>';

    this.init = function ()
    {
        $.template('chatWindow', chatWindow);
        $.template('chatDialogsList', chatDialogsList);
        $.template('chatCreateDialog', chatCreateDialog);
        $.template('chatListSingleRoom', chatListSingleRoom);
        $.template('chatDialogsListHeader', chatDialogsListHeader);
        $.template('chatListSingleRoomTitle', chatListSingleRoomTitle);
        $.template('chatListSingleRoomLastMsg', chatListSingleRoomLastMsg);

        $.template('chatDialog', chatDialog);
        $.template('chatDialogInput', chatDialogInput);
        $.template('chatDialogHeader', chatDialogHeader);
        $.template('chatDialogMessage', chatDialogMessage);
        $.template('chatDialogMessages', chatDialogMessages);
        $.template('chatDialogMessageAttachment', chatDialogMessageAttachment);
        $.template('chatDialogMessageAttachments', chatDialogMessageAttachments);
    };
};

// messages to server
Chat.CLIENT_GET_CHAT_LIST          = 1;
Chat.CLIENT_CHAT_CONNECT           = 3;
Chat.CLIENT_CHAT_DISCONNECT        = 4;
Chat.CLIENT_CHAT_MESSAGE           = 5;
Chat.CLIENT_CHAT_HISTORY           = 6;
Chat.CLIENT_CHAT_DELETE            = 7;
Chat.CLIENT_CHAT_DELETE_MESSAGE    = 8;
Chat.CLIENT_SET_INFO               = 9;
Chat.CLIENT_CHAT_CREATE            = 10;
Chat.CLIENT_CHAT_ATTACHMENTS       = 11;

// messages from server
Chat.SERVER_SUCCESS_AUTH           = 100;
Chat.SERVER_CHAT_DELETE            = 101;
Chat.SERVER_CHAT_LIST              = 102;
Chat.SERVER_CHAT_CONNECT_ERROR     = 103;
Chat.SERVER_CHAT_CONNECTED         = 104;
Chat.SERVER_CHAT_HISTORY           = 105;
Chat.SERVER_CHAT_DISCONNECTED      = 106;
Chat.SERVER_CHAT_MESSAGE_ERROR     = 107;
Chat.SERVER_CHAT_MESSAGE           = 108;
Chat.SERVER_CHAT_DELETE_ERROR      = 109;
Chat.SERVER_CHAT_DELETE_MESSAGE    = 110;
Chat.SERVER_SET_INFO_ERROR         = 111;
Chat.SERVER_SET_INFO_SUCCESS       = 112;
Chat.SERVER_CHAT_CREATE_ERROR      = 113;
Chat.SERVER_CHAT_CREATE_SUCCESS    = 114;
Chat.SERVER_CHAT_ATTACHMENT_ERROR  = 115;

Chat.translation = $.extend(true, {messages: {}}, Chat.translation);
Chat.options = $.extend(true, {}, Chat.options);
Chat.instances = $.extend(true, {}, Chat.instances);
Chat.protocol = {};

Chat.protocol[Chat.SERVER_SUCCESS_AUTH] = {
    required: ['chatUserId', 'isGuest', 'profile']
};

Chat.rights = {};
Chat.rights.NONE = 0;
Chat.rights.DELETE_MESSAGE = 1 << 0;
Chat.rights.DELETE_ROOM = 1 << 1;
Chat.rights.OWNER = Chat.rights.DELETE_MESSAGE | Chat.rights.DELETE_ROOM;

Chat.translation.get = function (key)
{
    if (Chat.translation.messages.hasOwnProperty(key))
        return Chat.translation.messages[key];
    return key;
}

Chat.getQueryParam = function (key)
{
    key = key.replace(/[*+?^$.\[\]{}()|\\\/]/g, "\\$&"); // escape RegEx control chars
    var match = location.search.match(new RegExp("[?&]" + key + "=([^&]+)(&|$)"));
    return match && decodeURIComponent(match[1].replace(/\+/g, " "));
}

Chat.isMobile = function ()
{
    return window.matchMedia("only screen and (max-width: 760px)").matches;
}

Chat.getForm = function (formName, success = null, error = null, complete = null)
{
    $.ajax({
        url: Chat.options.schema['get-form'],
        type: 'get',
        dataType: 'html',
        data: {
            formName: formName
        },
        complete: complete,
        success: success,
        error: error
    });
}

Chat.log = function (message, args)
{
    if (!window['CHAT_DEBUG'])
        return;

    if (args === undefined)
        console.log('[chat]', message);
    else
        console.log('[chat]', message, args);
}

Chat.fileSize = function (size)
{
    var i = Math.floor( Math.log(size) / Math.log(1024) );
    return ( size / Math.pow(1024, i) ).toFixed(2) * 1 + ' ' + ['B', 'kB', 'MB', 'GB', 'TB'][i];
};

Chat.error = function (message, args)
{
    if (!window['CHAT_DEBUG'])
        return;

    if (args === undefined)
        console.error('[chat]', message);
    else
        console.error('[chat]', message, args);
}

Chat.commandName = function (command)
{
    for(var objectKey in Chat)
    {
        if (Chat[objectKey] === command)
            return objectKey;
    }
    return null;
}

Chat.popup = function (options, selectors)
{
    // private fields
    var _opened = false;
    var _inTransition = false;
    var _$toggle = $(selectors.toggleSelector);
    var _$popupWrapper = $(selectors.popupWrapper);

    _$toggle.click((e) => this.toggle());

    this.dialogs = new Chat.dialogsWindow(options, selectors);
    this.destroy = function()
    {
        _$toggle.remove();
        _$popupWrapper.remove();
        this.dialogs.destroy();
        this.dialogs = null;
    }

    Object.defineProperty(this, 'isOpened', {
        get: function () { return _opened; },
    });

    this.toggle = function ()
    {
        if (_inTransition)
            return;

        _inTransition = true;
        _opened = _$popupWrapper.hasClass('dialogs-container_wrapper__shown');

        var bottom = parseFloat(_$toggle.css('bottom')) + parseFloat(_$toggle.css('height')) + 30;

        if (!_opened)
        {
            if (Chat.isMobile())
                _$popupWrapper.css({opacity: 0});
            else
                _$popupWrapper.css({bottom: bottom, opacity: 0});
            _$popupWrapper.addClass('dialogs-container_wrapper__shown');
        }

        var options = {
            bottom: (_opened ? bottom : bottom - 25),
            opacity: (_opened ? 0 : 1)
        };

        if (Chat.isMobile())
            delete options.bottom;

        _$popupWrapper.animate(options,
        {
            duration: 200,
            easing:'easeOutQuad',
            complete: () =>
            {
                if (_opened)
                    _$popupWrapper.removeClass('dialogs-container_wrapper__shown');

                _opened = !_opened;
                _inTransition = false;
                _$popupWrapper.css({
                    transform: 'rotate(0.000001deg)'
                });

                $('body').toggleClass('chat-shown');
            },
            step: function(now)
            {
                _$popupWrapper.css({
                    transform: 'rotate(' + 10 * (1 - now) + 'deg)'
                });
            }
        });
    }

    $(this.dialogs.chat.gui.container).on('click',
        '.dialogs-container__close', (e) => this.toggle());

    if (options.openIfClosed)
    {
        this.dialogs.chat.api.protocol.callbacks[Chat.SERVER_CHAT_MESSAGE] = (message) =>
        {
            if (!_opened)
                this.toggle();

            if (!this.dialogs.chat.inRoom)
            {
                this.dialogs.chat.gui.joinRoom(this.dialogs.chat.getRoom(message.room_id));
                setTimeout(() => {
                    this.dialogs.chat.gui.doHistoryScrollDown();
                }, 1100);
            }
        }
    }
}

Chat.dialogsWindow = function (options, selectors)
{
    /** @type {Chat.instance} this.chat */
    this.chat = new Chat.instance(options);
    this.chat.gui.init(selectors);
    this.chat.api.protocol.callbacks[Chat.SERVER_SUCCESS_AUTH] = (identity) =>
    {
        this.chat.api.send(Chat.CLIENT_GET_CHAT_LIST);
    }

    this.chat.api.connect();
    this.destroy = function()
    {
        this.chat.destroy();
        this.chat = null;
    }
};

Chat.instance = (function ()
{
    // private static
    /** @type {Number} */
    var _GUID = 0;
    /** @type {ChatTemplates} */
    var _templates = new ChatTemplates();

    _templates.init();

    /**
     * @this {ChatInstance}
     */
    var ChatInstance = function (options)
    {
        // public
        /** @type {ChatRoom} */
        this.currentRoom = null;

        // private fields
        /** @type {Number} */
        var _guid = ++_GUID;

        /** @type {ChatGUI} */
        var _gui = new ChatGUI(this);
        /** @type {Object} */
        var _rooms = {};
        /** @type {Boolean} */
        var _openNextRoom = false;
        /** @type {{ip: String, port: Integer, realm: String, requestParams: String, schema: Object, isGuest: Boolean, chatUserId: Integer, profile: Object}} */
        var _options = options;

        Object.defineProperty(this, 'openNextRoom', {
            get: function () { return _openNextRoom; },
            set: function (v) { _openNextRoom = v; }
        });

        Object.defineProperty(this, 'options', {
            get: function () { return _options; }
        });

        Object.defineProperty(this, 'inRoom', {
            get: function () { return this.currentRoom != null; }
        });

        Object.defineProperty(this, 'isGuest', {
            get: function () { return _options.isGuest; }
        });

        Object.defineProperty(this, 'profileCreated', {
            get: function () { return !!_options.profile; }
        });

        Object.defineProperty(this, 'guid', {
            get: function () { return _guid; }
        });

        Object.defineProperty(this, 'api', {
            get: function () { return _api; }
        });

        Object.defineProperty(this, 'gui', {
            get: function () { return _gui; }
        });

        Object.defineProperty(this, 'rooms', {
            get: function () { return _rooms; }
        });

        Object.defineProperty(this, 'countUnread', {
            get: function ()
            {
                return $
                    .map(_rooms, function (room, index) { return +!!+room.data.has_unread; }) // +!!+ преобразует "1","0",0,1 в bool и потом в integer
                    .reduce(function(sum, v) { return sum + v; }, 0);
            }
        });

        this.destroy = function ()
        {
            _api.disconnect();
            _api.destroy();
            _gui.destroy();
            _api = null;
            _gui = null;
            _rooms = null;
        }

         /**
         * @param {Number} id
         * @return {ChatRoom}
         */
        this.getRoom = function (id)
        {
            return _rooms[parseInt(id)];
        }

        /**
         * @param {{users: Array}} props
         * @return {ChatRoom}
         */
        this.addRoom = function (props)
        {
            props.id = parseInt(props.id);

            if (this.getRoom(props.id))
                return;

            var extendedProps = {
                userTitle: null,
                rights: props.rights || props.users[_options.chatUserId].rights,
                has_unread: props.has_unread || props.users[_options.chatUserId].has_unread
            };

            if (Object.keys(props.users).length == 1)
            {
                extendedProps.userTitle = Chat.translation.get('chat.conversation_yourself');
            }

            $.extend(props, extendedProps);

            var room = new ChatRoom(this, props);
            _rooms[props.id] = room;
            _gui.displayRoom(room);
            _gui.sortRooms();

            if (_openNextRoom || Chat.getQueryParam('chatOpenId') == props.id)
            {
                _gui.joinRoom(room);
                _openNextRoom = false;
            }

            return room;
        }

        /**
         * @param {Number} roomId
         */
        this.onRoomDeleted = function (roomId)
        {
            roomId = parseInt(roomId);

            _gui.closeRoomIfCurrent(roomId);
            _gui.removeRoom(roomId);
            delete _rooms[roomId];
        }

        this.removeRooms = function ()
        {
            for(var roomId in _rooms)
                delete _rooms[roomId];
            _gui.removeRooms();
        }

        this.createRoom = function (data)
        {
            _openNextRoom = true;
            _api.send(Chat.CLIENT_CHAT_CREATE, data);
        }

        this.sendAttachments = function (attachments)
        {
            _api.send(Chat.CLIENT_CHAT_ATTACHMENTS, {
                roomId: parseInt(this.currentRoom.data.id),
                attachments: attachments
            });
        }

        this.sendMessage = function (text)
        {
            _api.send(Chat.CLIENT_CHAT_MESSAGE, {
                roomId: parseInt(this.currentRoom.data.id),
                text: text
            });
        }

        this.setInfo = function (data)
        {
            if (!_options.isGuest)
                return;

            _api.send(Chat.CLIENT_SET_INFO, data);
        }

        this.getHistory = function (roomId)
        {
            if (!this.inRoom)
                return;

            var room = this.getRoom(parseInt(roomId));
            if (!room)
                return;

            if (room.leftMessages <= 0 || room.data.lastMessage == null)
                return;

            _api.send(Chat.CLIENT_CHAT_HISTORY, {
                token: room.data.token,
                time: room.data.lastMessage ? room.data.lastMessage.create_time : null
            });
        }

        /** @type {ChatAPI} */
        var _api = new ChatAPI(this, options.ip, options.port, options.realm, options.requestParams);

        Chat.instances[_guid] = this;
        Chat.log('[ChatInstance][' + _guid + ']', options);

        $(document).trigger('chat_initialized', this);
    };

    return ChatInstance;
})();

/**
 * @this {ChatAPI}
 */
var ChatAPI = function (chatInstance, ip, port, realm, requestParams)
{
    if (!ip || !port || !realm || !requestParams)
        throw 'ChatAPI wrong end point';

    $.extend(true, requestParams, {
        csrfToken: yii.getCsrfToken(),
        csrfParam: yii.getCsrfParam(),
    });

    // private
    /** @type {WebSocket} */
    var _socket = null;
    /** @type {String} */
    var _endpoint = (chatInstance.options.useWss ? 'wss://' : 'ws://') + ip + ':' + port +'/' + realm + '?' + $.param(requestParams);
    /** @type {ChatProtocol} */
    var _protocol = new ChatProtocol(this);
    /** @type {Chat.instance} */
    var _chat = chatInstance;
    /** @type {Number} */
    var _reconnectTimeout = 0;

    this.onConnected = null;
    this.onDisconnected = null;

    Object.defineProperty(this, 'protocol', {
        get: function () { return _protocol; }
    });

    Object.defineProperty(this, 'chat', {
        get: function () { return _chat; }
    });

    this.destroy = function ()
    {
        if (_reconnectTimeout != null)
        {
            clearTimeout(_reconnectTimeout);
            _reconnectTimeout = null;
        }
    }

    this.isValidMessage = function (data)
    {
        return !!data.command && !!parseInt(data.command);
    }

    this.onOpen = function ()
    {
        _chat.gui.setLoading(false);
        _chat.removeRooms();

        $(document).trigger('chat_connected', _chat);

        if ($.isFunction(this.onConnected))
            this.onConnected(this);
    }

    this.onClose = function (closeEvent)
    {
        Chat.log('onClose', closeEvent);

        $(document).trigger('chat_disconnected', _chat);

        if ($.isFunction(this.onDisconnected))
            this.onDisconnected(this);

        _socket = undefined;
        _chat.gui.onConnectionClose();

        if (!closeEvent.wasClean)
        {
            Chat.log('Connection close, try reconnect in 10s');

            if (_reconnectTimeout != null)
                clearTimeout(_reconnectTimeout);
            _reconnectTimeout = setTimeout(() => { this.connect(); }, 10 * 1000);
        }
        else if (_reconnectTimeout != null)
        {
            clearTimeout(_reconnectTimeout);
            _reconnectTimeout = null;
        }
    }

    this.onMessage = function (event)
    {
        var message;
        try
        {
            message = JSON.parse(event.data);
        }
        catch (e)
        {
            Chat.log('JSON parse error', event.data);
            return;
        }

        if (this.isValidMessage(message) === false)
        {
            Chat.log('Skip invalid message', message);
            return;
        }

        _protocol.onMessage(message);
    }

    this.onError = function (event)
    {
        Chat.log('onError', event);
    }

    this.connected = function ()
    {
        return _socket && _socket.readyState == WebSocket.OPEN;
    }

    /**
     * @param {Number} command
     * @param {Object} payload
     */
    this.send = function (command, payload)
    {
        if (this.connected() === false)
            return;

        Chat.log('[out]', [Chat.commandName(command), payload]);

        _socket.send(JSON.stringify({
            command: command,
            payload: payload || {}
        }));
    }

    this.disconnect = function ()
    {
        if (this.connected())
        {
            _socket.close();
            _socket.onopen = null;
            _socket.onclose = null;
            _socket.onmessage = null;
            _socket.onerror = null;
            _socket = null;
        }
    }

    this.connect = function ()
    {
        try
        {
            _chat.gui.setLoading(true);
            _socket = new WebSocket(_endpoint);
            _socket.onopen = () => this.onOpen();
            _socket.onclose = (e) => this.onClose(e);
            _socket.onmessage = (e) => this.onMessage(e);
            _socket.onerror = (e) => this.onError(e);
        }
        catch (error)
        {
            _socket = null;
            Chat.log('Connection error (' + error + ')');
        }
    }
};

/**
 * @param {ChatAPI} api
 * @this {ChatProtocol}
 */
var ChatProtocol = function (api)
{
    // private
    var _api = api;

    this.callbacks = {};
    this.onMessage = function (message)
    {
        if (this.validatePayload(message.command, message.payload) &&
            this.processCommand(message.command, message.payload))
        {
            this.executeCallback(message.command, message.payload);
        }
    }

    this.executeCallback = function (command, payload)
    {
        if ($.isFunction(this.callbacks[command]))
            this.callbacks[command](payload);
    }

    this.validatePayload = function (command, payload)
    {
        var command = Chat.protocol[command];
        if (command === undefined ||
            command.required === undefined)
        {
            return true;
        }

        for (var i = 0; i < command.required.length; i++)
        {
            if (payload[command.required[i]] === undefined)
            {
                Chat.log('Required payload not found', command.required[i]);
                return false;
            }
        }

        return true;
    };

    this.processCommand = function (command, payload)
    {
        Chat.log('[in]', [Chat.commandName(command), payload]); // TODO remove

        if ($.isFunction(this[command]))
            return this[command](payload) === true;

        Chat.log('[in] Command not found', Chat.commandName(command));
        return false;
    }

    /**
     * @param {{chatUserId: Integer, isGuest: Boolean, profile: Object}} identity
     */
    this[Chat.SERVER_SUCCESS_AUTH] = function (identity)
    {
        $.extend(_api.chat.options, identity);

        if (!identity.profile && identity.isGuest)
        {
            _api.chat.gui.displaySetInfo();
            return false;
        }

        return true;
    }

    this[Chat.SERVER_CHAT_LIST] = function (payload)
    {
        if ($.isArray(payload.chats))
        {
            $.each(payload.chats, function(index, room)
            {
                _api.chat.addRoom(room);
            });

            return true;
        }

        return false;
    }

    this[Chat.SERVER_CHAT_CONNECT_ERROR] = function (error)
    {
        _api.chat.gui.closeRoom(null, false);
        return true;
    }

    /**
     * @param {{id: number}} room
     */
    this[Chat.SERVER_CHAT_CONNECTED] = function (payload)
    {
        payload.id = parseInt(payload.id);

        var room = _api.chat.getRoom(payload.id);
        if (!room)
            return;

        $.extend(room.data, payload);
        return true;
    }

    /**
     * @param {{left: Number, messages: Array, roomId: Number}} payload
     */
    this[Chat.SERVER_CHAT_HISTORY] = function (payload)
    {
        var room = _api.chat.getRoom(payload.roomId);
        if (!room)
            return;

        room.leftMessages = payload.left;
        room.data.lastMessage = payload.messages[0];

        $.each(payload.messages, function(index, message)
        {
            room.extendMessage(message);
        });

        _api.chat.gui.handleHistory(payload);
        return true;
    }

    /**
     * @param {{roomId: Number}} payload
     */
    this[Chat.SERVER_CHAT_DELETE] = function (payload)
    {
        _api.chat.onRoomDeleted(payload.roomId);
        return true;
    }

    /**
     * @param {{roomId: Number, messageId: Number}} payload
     */
    this[Chat.SERVER_CHAT_DELETE_MESSAGE] = function (payload)
    {
        _api.chat.gui.onChatMessageDeleted(payload.messageId, payload.roomId);
        return true;
    }

    /**
     * @param {{roomId: Number}} payload
     */
    this[Chat.SERVER_CHAT_DISCONNECTED] = function (payload)
    {
        _api.chat.gui.closeRoomIfCurrent(payload.roomId);
        return true;
    }

    /**
     * @param {{create_time: Number, id: Number, plain_text: String, room_id: Number, update_time: Number, chat_user_id: Number}} message
     */
    this[Chat.SERVER_CHAT_MESSAGE] = function (message)
    {
        _api.chat.gui.onChatMessage(message);
        return true;
    }

    this[Chat.SERVER_SET_INFO_SUCCESS] = function (message)
    {
        _api.chat.gui.closeSetInfo();
        return true;
    }

    this[Chat.SERVER_CHAT_CREATE_ERROR] = function (payload)
    {
        _api.chat.gui.container.find('.create-dialog-container').removeClass('chat-loading');
        return true;
    }

    this[Chat.SERVER_CHAT_CREATE_SUCCESS] = function (payload)
    {
        _api.chat.gui.container.find('[name="CreateDialog[question]"]').val('');
        _api.chat.gui.container.find('.create-dialog-container').removeClass('chat-loading');
        return true;
    }
};

/**
 * @this ChatGUI
 */
var ChatGUI = function (chatInstance)
{
    // private
    /** @type {Chat.instance} */
    var _chat = chatInstance;
    /** @type {number} */
    var _$container;
    var _$chatMarkup;
    var _$chatDialogsList;
    var _$roomContainer = null;
    var _$setInfoContainer = null;

    Object.defineProperty(this, 'container', {
        get: function () { return _$container; }
    });

    this.onConnectionClose = function ()
    {
        this.setLoading(true);
        this.closeRoom(null, false);
        this.closeSetInfo();
    }

    this.closeSetInfo = function ()
    {
        if (_$setInfoContainer)
        {
            _$setInfoContainer.remove();
            _$setInfoContainer = null;
            _$chatMarkup.show();
        }
    }

    /**
     * @param {Boolean} loading
     */
    this.setLoading = function (loading)
    {
        if (loading)
            _$container.addClass('chat-loading');
        else
            _$container.removeClass('chat-loading');
    }

    this.destroy = function ()
    {
        _$container.remove();
    }

    this.init = function (options)
    {
        _$container = $(options.container);
        _$chatMarkup = $.tmpl('chatWindow', {
            dialogs_header: options.dialogs_header || Chat.translation.get('chat.chat_header')
        });
        _$chatDialogsList = _$chatMarkup.find('.chat-dialogs__list');
        _$chatMarkup.appendTo(_$container);
        _$container.attr('data-guid', _chat.guid);

        $(_$container).on('click', '.chat-actions', function (e)
        {
            e.preventDefault();
            $(e.currentTarget).addClass('chat-actions_shown');
            return false;
        });

        $(_$container).on('mouseleave', '.chat-actions_shown', function (e)
        {
            $(e.currentTarget).removeClass('chat-actions_shown');
        });

        if (options.displayCreateDialog)
            this.displayCreateDialog();
    }

    this.displayCreateDialog = function ()
    {
        Chat.getForm('CreateDialog', function (html)
        {
            var $createDialog = $(html);
            $createDialog.appendTo(_$chatMarkup);

            var $form = $createDialog.find('form');
            $form.on('beforeSubmit', (e) =>
            {
                _$container.find('.create-dialog-container').addClass('chat-loading');
                _chat.createRoom($form.serializeObject());
                return false;
            });
        });
    }

    this.onChatMessageDeleted = function (messageId, roomId)
    {
        if (!_chat.inRoom || _chat.currentRoom.data.id != roomId)
            return;

        _$roomContainer
            .find('.chat-message[data-id="' + messageId + '"]')
            .remove();
    }

    /**
     * @param {{self: Boolean, create_time: Number, id: Number, plain_text: String, room_id: Number, update_time: Number, chat_user_id: Number}} message
     */
    this.onChatMessage = function (message)
    {
        var room = _chat.getRoom(message.room_id);
        if (!room)
            return;

        room.extendMessage(message);
        room.data.lastMessage = message;

        var $lastMsg = $.tmpl('chatListSingleRoomLastMsg', message);
        var $dialogsRoom = this.findChatDialogsRoom(message.room_id);

        $dialogsRoom
            .find('.chat-dialogs__last-message')
            .replaceWith($lastMsg);

        if (!message.self && (
            !_chat.inRoom || _chat.currentRoom.data.id != message.room_id))
        {
            room.data.has_unread = true;
            $dialogsRoom
                .find('.chat-dialogs__new-message')
                .addClass('chat-dialogs__new-message_shown');
        }

        $dialogsRoom.attr('data-last-message', message.create_time);
        this.sortRooms();

        if (_chat.inRoom && _chat.currentRoom.data.id == room.data.id)
        {
            var $message = $.tmpl('chatDialogMessage', message);
            var $container = _$roomContainer.find('.chat-dialog__messages');
            $message.appendTo($container);

            this.doHistoryScrollDown();
        }
    }

    this.doHistoryScrollDown = function(time = 1000)
    {
        if (!_chat.inRoom)
            return;

        var $element = _$roomContainer.find('.chat-dialog__messages-container');
        $element.stop();
        $element.animate({
            scrollTop: $element.get(0).scrollHeight
        }, time);
    }

    /**
     * Invoked if get SERVER_CHAT_DELETE or SERVER_CHAT_DISCONNECTED
     *
     * @param {Number} roomId
     */
    this.closeRoomIfCurrent = function (roomId)
    {
        if (!_chat.inRoom || _chat.currentRoom.data.id != roomId)
            return;

        this.closeRoom(null, false);
    }

    this.displaySetInfo = function ()
    {
        if (_$setInfoContainer)
            return;

        _$container.addClass('chat-loading');

        Chat.getForm('SetInfo', function (html)
        {
            _$chatMarkup.hide();
            _$setInfoContainer = $(html);
            _$setInfoContainer.prependTo(_$container);

            var $form = _$setInfoContainer.find('form');
            $form.on('beforeSubmit', (e) =>
            {
                _chat.setInfo($form.serializeObject());
                return false;
            });
        }, null, function () {
            _$container.removeClass('chat-loading');
        });
    }

    /**
     * @param {Boolean} sendClose
     */
    this.closeRoom = function (e, sendClose)
    {
        if (!_chat.inRoom)
            return;

        if (sendClose)
        {
            _chat.api.send(Chat.CLIENT_CHAT_DISCONNECT);
        }

        _$container.removeClass('dialogs-container__opened');
        _$chatMarkup.show();
        _$roomContainer.remove();
        _$roomContainer = null;

        _chat.currentRoom.data.lastMessage = null;
        _chat.currentRoom.leftMessages = 0;
        _chat.currentRoom = null;
    }

    this.joinRoom = function (chatRoom)
    {
        if (!chatRoom || _chat.inRoom)
            return;

        this
            .findChatDialogsRoom(chatRoom.data.id)
            .find('.chat-dialogs__new-message_shown')
            .removeClass('chat-dialogs__new-message_shown');

        _$chatMarkup.hide();
        _$container.addClass('dialogs-container__opened');
        _$roomContainer = $.tmpl('chatDialog', chatRoom.data);
        _$roomContainer.prependTo(_$container);

        _$roomContainer
            .find('.chat-dialog__header-back-button')
            .click((e) => this.closeRoom(e, true));

        _$roomContainer
            .find('.chat-dialog__messages-container')
            .scroll((e) => this.handleHistoryScroll(e, chatRoom.data.id));

        _$roomContainer.on('change', 'input.chat-input__attachment', (e) => this.handleAttachment(e));
        _$roomContainer.on('click', '.chat-input__button-file', (e) => this.showFileSelect(e));
        _$roomContainer.on('click', '.chat-input__button-ok', (e) => this.sendOkay(e));
        _$roomContainer.on('click', '.chat-input__button-send', (e) => this.sendMessage(e));
        _$roomContainer.on('click', '.chat-actions__delete', (e) => this.handleDeleteMessage(e));

        var $textarea = _$roomContainer.find('.chat-input__textarea');
        $textarea.keyup((e) => this.inputTextareaChanged(e));
        $textarea.keydown((e) => this.inputTextareaChanged(e));
        $textarea.change((e) => this.inputTextareaChanged(e));

        _chat.currentRoom = chatRoom;
        _chat.api.send(Chat.CLIENT_CHAT_CONNECT, {
            token: chatRoom.data.token
        });
    }

    /**
     * @param {ChatRoom} chatRoom
     */
    this.handleJoinRoom = function (e)
    {
        var roomId = $(e.currentTarget).data('room-id');
        var chatRoom = _chat.getRoom(roomId);

        if (!chatRoom || _chat.inRoom)
            return;

        var $target = $(e.target);
        if ($target.parents('.chat-actions').length > 0)
        {
            e.preventDefault();
            return true;
        }

        this.joinRoom(chatRoom);
    }

    this.handleHistoryScroll = function (e, roomId)
    {
        if (e.currentTarget.scrollTop < 60)
            _chat.getHistory(roomId);
    }

    this.handleHistory = function(payload)
    {
        var $element = $.tmpl('chatDialogMessage', payload.messages);
        var $container = _$roomContainer.find('.chat-dialog__messages-container');
        var div = $container.get(0);
        var scrollBottom = div.scrollHeight - div.scrollTop;

        $element.prependTo($container.find('.chat-dialog__messages'));
        div.scrollTo(0, div.scrollHeight - scrollBottom);
    }

    this.sendMessage = function()
    {
        var target = _$roomContainer.find('.chat-input__textarea');
        var evt = jQuery.Event("keydown");
        evt.which = 13;
        evt.keyCode = 13;
        evt.shiftKey = false;
        evt.currentTarget = target.get(0);
        target.trigger(evt);
    }

    this.showFileSelect = function (e)
    {
        var $button = $(e.currentTarget);
        var $input = $button
            .parents('.chat-input')
            .find('input.chat-input__attachment');

        $input.click();
    }

    this.handleAttachment = function (e)
    {
        e.preventDefault();

        var $input = $(e.currentTarget);
        var $button = _$roomContainer.find('.chat-input__button-file');
        var files = $input.get(0).files;

        if (files.length == 0 ||
            files.length > 1)
        {
            return;
        }

        var attachment = files[0];
        var formData = new FormData();

        formData.append('ChatAttachment[file]', attachment);
        formData.append('ChatAttachment[room_id]', _chat.currentRoom.data.id);

        $.ajax({
            url: _chat.options.schema['upload'],
            method: 'post',
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            uploadProgress: function(event, position, total, percentComplete)
            {
                console.log(event, position, total, percentComplete);
            },
            beforeSend: function()
            {
                $button.addClass('disabled');
                $button.addClass('loading');
            },
            success: function(data)
            {
                if (data.success && data.attachment)
                {
                    _chat.sendAttachments([data.attachment.token]);
                }
            },
            complete: function ()
            {
                $button.removeClass('disabled');
                $button.removeClass('loading');
            }
        });
    }

    this.sendOkay = function (e)
    {
        _chat.sendMessage('OK');
    }

    this.inputTextareaChanged = function (e)
    {
        var $textarea = $(e.currentTarget);
        var $pre = $textarea.parent().find('pre');
        var text = $textarea.val();

        if (e.type == 'keydown' && e.shiftKey == false && e.keyCode == 13)
        {
            text = text.trim();
            e.preventDefault();

            if (text == null || text === '' || text.length === 0)
            {
                e.preventDefault();
                return;
            }

            _chat.sendMessage(text);
            $pre.text('<br>');
            $textarea.val('');
            return;
        }

        $pre.text(text + '<br>');
    }

    /**
     * @param {ChatRoom} chatRoom
     */
    this.displayRoom = function (chatRoom)
    {
        var $roomMarkup = $.tmpl('chatListSingleRoom', chatRoom.data);
        $roomMarkup.click((e) => this.handleJoinRoom(e));
        $roomMarkup.on('click', '.chat-actions__delete',
            (e) => this.handleDeleteRoom(chatRoom.data.id));
        $roomMarkup.prependTo(_$chatDialogsList);
    }

    this.handleDeleteMessage = function(e)
    {
        $message = $(e.currentTarget).parents('.chat-message');
        _chat.api.send(Chat.CLIENT_CHAT_DELETE_MESSAGE, {
            messageId: parseInt($message.data('id'))
        });
    }

    this.handleDeleteRoom = function(roomId)
    {
        _chat.api.send(Chat.CLIENT_CHAT_DELETE, {
            roomId: parseInt(roomId)
        });
    }

    this.sortRooms = function ()
    {
        _$chatDialogsList
            .find('.chat-dialogs__room')
            .tsort({order:'desc', attr: 'data-last-message'});
    }

    /**
     * @param {Number} roomId
     */
    this.removeRoom = function (roomId)
    {
        this.findChatDialogsRoom(roomId).remove();
    }

    this.removeRooms = function ()
    {
        _$chatDialogsList
            .find('.chat-dialogs__room')
            .remove();
    }

    /**
     * @param {Number} roomId
     */
    this.findChatDialogsRoom = function (roomId)
    {
        return _$chatDialogsList
            .find('.chat-dialogs__room[data-room-id="' + roomId + '"]');
    }
};

/**
 * @param {{id: Number, business_id: Number, has_unread: Number, rights: Number, title: String, token: String, create_time: Number, update_time: Number, lastMessage: {id: Number, room_id: Number, create_time: Number, update_time: Number, plain_text: String, chat_user_id: Number, self: Boolean}}} props
 */
var ChatRoom = function (chatInstance, data)
{
    /** @type {Chat.instance} */
    var _chat = chatInstance;

    this.data = data;
    this.leftMessages = 0;

    this.extendMessage = function (message)
    {
        message.self = message.chat_user_id == _chat.options.chatUserId;
        message.at = moment.unix(message.create_time).format('YYYY-MM-DD HH:mm:ss');
        message.fromName = null;

        if (this.data.users[message.chat_user_id])
            message.fromName = this.data.users[message.chat_user_id].name;
    }
};

$(function() {
    setInterval(function ()
    {
        $('.from_now').each(function (index, element)
        {
            var element = $(element);
            var time = element.data('time');
            element.text(moment.unix(time).fromNow());
        });
    }, 1000 * 60);
});
