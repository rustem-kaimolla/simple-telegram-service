# SimpleTelegramService

Telegram API-мен жұмыс істеуге арналған қарапайым пакет 🚀

## Орнату

Composer арқылы орнату пәрмені:

```bash
composer require rustemkaimolla/simple-telegram-service
```

## Қолдану
```php
use RustemKaimolla\SimpleTelegramService\TelegramService;

// Сервисті инициализациялау
$telegramService = TelegramService::getInstance('YOUR_BOT_TOKEN');

// Хабарлама жіберу
$chatId = '123456789';
$messageText = 'Сәлем, Әлем!';
$success = $telegramService->sendMessage($messageText, $chatId);

if ($success) {
    echo 'Хабарлама сәтті жіберілді! 😊';
} else {
    echo 'Хабарлама жіберу кезінде қателік шықты. 😞';
}
```

## Хабарлама жіберуге арналған жаһандық функция
Сіз `telegram_message()` жаһандық функциясын Сервисті инициализациялағаннан кейін қолдана аласыз, 
оны қолдану үшін төмендегі мысалға қараныз:
```php
use RustemKaimolla\SimpleTelegramService\TelegramService;
use RustemKaimolla\SimpleTelegramService\TelegramServiceException;

try {
    telegram_message('Сәлем, Әлем!', '123456789');
    echo 'Хабарлама сәтті жіберілді! 😊';
} catch (TelegramServiceException $e) {
    echo 'Хабарлама жіберу кезінде қателік шықты: ' . $e->getMessage() . ' 😞';
}

```

## Лицензия
Бұл пакет MIT шенберінде таратылады. Толығырақ LICENSE файлын қараныз.