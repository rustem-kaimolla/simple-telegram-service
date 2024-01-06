<?php

use RustemKaimolla\SimpleTelegramService\TelegramServiceException;

if (!function_exists('telegram_message')) {
    function telegram_message(string $messageText, string $chatId, ?string $threadId = null): bool
    {
        if (\RustemKaimolla\SimpleTelegramService\TelegramService::isInitialized() === false) {
            throw new TelegramServiceException(
                'TelegramService has not been initialized. Call TelegramService::getInstance() first.');
        }

        return \RustemKaimolla\SimpleTelegramService\TelegramService::getInstance('')
            ->sendMessage($messageText, $chatId, $threadId);
    }
}