<?php

use yii\db\Migration;

/**
 * Class m200912_102025_add_chat_translations
 */
class m200912_102025_add_chat_translations extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $sql = <<<SQL
            INSERT INTO `source_message` (`id`, `category`, `message`) VALUES
            (147, 'matodor.chat', 'chat.setinfo.firstName'),
            (148, 'matodor.chat', 'chat.setinfo.lastName'),
            (149, 'matodor.chat', 'chat.setinfo.email'),
            (150, 'matodor.chat', 'chat.createdialog.question'),
            (151, 'matodor.chat', 'chat.write_you_message_here'),
            (152, 'matodor.chat', 'chat.new_conversation'),
            (153, 'matodor.chat', 'chat.subject'),
            (154, 'matodor.chat', 'chat.submit'),
            (155, 'matodor.chat', 'chat.chat_header'),
            (156, 'matodor.chat', 'chat.dialog_header_back'),
            (157, 'matodor.chat', 'chat.conversation_yourself'),
            (158, 'matodor.chat', 'chat.setinfo.header'),
            (159, 'matodor.chat', 'chat.attachment_message_header');


            INSERT INTO `message` (`id`, `language`, `translation`) VALUES
            (147, 'de-DE', 'Vorname'),
            (147, 'en-US', 'First name'),
            (147, 'ru-RU', 'Имя'),
            (148, 'de-DE', 'Nachname'),
            (148, 'en-US', 'Last name'),
            (148, 'ru-RU', 'Фамилия'),
            (149, 'de-DE', 'Email'),
            (149, 'en-US', 'Email'),
            (149, 'ru-RU', 'Email'),
            (150, 'de-DE', 'Thema der Berufung'),
            (150, 'en-US', 'Theme of appeal'),
            (150, 'ru-RU', 'Тема обращения'),
            (151, 'de-DE', 'Gib deine Nachricht ein...'),
            (151, 'en-US', 'Enter your message...'),
            (151, 'ru-RU', 'Введите сообщение...'),
            (152, 'de-DE', 'Neues Gespräch'),
            (152, 'en-US', 'New conversation'),
            (152, 'ru-RU', 'Новый диалог'),
            (153, 'de-DE', 'Gegenstand'),
            (153, 'en-US', 'Subject'),
            (153, 'ru-RU', 'Тема'),
            (154, 'de-DE', 'Einreichen'),
            (154, 'en-US', 'Submit'),
            (154, 'ru-RU', 'Отправить'),
            (155, 'de-DE', 'Plaudern'),
            (155, 'en-US', 'Chat'),
            (155, 'ru-RU', 'Чат'),
            (156, 'de-DE', 'Zurück'),
            (156, 'en-US', 'Back'),
            (156, 'ru-RU', 'Назад'),
            (157, 'de-DE', 'Korrespondenz mit Ihnen'),
            (157, 'en-US', 'Correspondence with you'),
            (157, 'ru-RU', 'Переписка с собой'),
            (158, 'de-DE', 'Stell dich im Chat vor'),
            (158, 'en-US', 'Introduce yourself in chat'),
            (158, 'ru-RU', 'Представьтесь в чате'),
            (159, 'de-DE', 'Beigefügte Anhänge:'),
            (159, 'en-US', 'Attached files:'),
            (159, 'ru-RU', 'Прикрепленные файлы:');
SQL;

        Yii::$app->db->createCommand($sql)->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200912_102025_add_chat_translations cannot be reverted.\n";
        return false;
    }
}
