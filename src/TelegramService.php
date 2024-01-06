<?php

namespace RustemKaimolla\SimpleTelegramService;

class TelegramService
{
    private string $telegramApiBaseUrl = 'https://api.telegram.org/bot';
    private string $telegramApiSendMessageEndpoint;
    private \GuzzleHttp\Client $telegramApiClient;

    private static TelegramService $instance;

    private function __construct(
        private readonly string  $telegramBotToken,
        private readonly ?string $proxy = null
    )
    {
        $this->telegramApiSendMessageEndpoint = 'sendMessage';
        $this->telegramApiClient = new \GuzzleHttp\Client([
            'base_uri' => $this->telegramApiBaseUrl . $this->telegramBotToken . '/',
            'proxy'    => $this->proxy,
            'verify'   => false,
        ]);
    }

    public function sendMessage(
        string  $messageText,
        string  $chatId,
        ?string $threadId = null
    ): bool
    {
        $requestQueryData = $this->prepareRequestQuery($messageText, $chatId, $threadId);
        $response = $this->telegramApiClient->get($this->telegramApiSendMessageEndpoint, ['query' => $requestQueryData]);

        return $response->getStatusCode() === 200;
    }


    private function prepareRequestQuery(
        string  $messageText,
        string  $chatId,
        ?string $threadId = null
    ): array
    {
        $params = [
            'text'       => $this->escapeMarkdown($messageText),
            'chat_id'    => $chatId,
            'parse_mode' => 'html',
        ];

        if (strlen($threadId)) {
            $params['message_thread_id'] = $threadId;
        }

        return $params;
    }

    public static function getInstance(
        string $telegramBotToken,
        ?string $proxy = null
    ): TelegramService {
        if (isset(self::$instance)) {
            self::$instance = new self($telegramBotToken, $proxy);
        }

        return self::$instance;
    }

    public static function isInitialized(): bool
    {
        return isset(self::$instance);
    }

    private function escapeMarkdown(string $string): string
    {
        $string = str_replace('_', '\\_', $string);
        $string = str_replace('*', '\\*', $string);
        $string = str_replace('[', '\\[', $string);
        $string = str_replace(']', '\\]', $string);
        $string = str_replace("'", "\\'", $string);

        return str_replace(
            ['#', '_', '*', '[', ']', "'", '\\'],
            ['\\#', '\\_', '\\*', '\\[', '\\]', "\\'", '\\\\'],
            $string
        );
    }

    private function __clone() {}

    private function __wakeup() {}
}
