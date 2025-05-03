<?php

declare(strict_types=1);

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Weather\EnvHelper;

require_once __DIR__ . '/vendor/autoload.php';

header('content-type: application/json');
header('Access-Control-Allow-Origin: *');

const WORDS_COUNT = 12;

$translation_file = __DIR__ . '/translations.json';
$translations = json_decode(file_get_contents($translation_file), true);
function hasWordTranslation(array $translations, string $word): bool
{
    foreach ($translations as $data) {
        if ($data['word'] === $word) {
            return true;
        }
    }
    return false;
}

$envs = glob(__DIR__ . "/.env*");
// Загрузка переменных окружения проекта
EnvHelper::loadEnvironmentData(__DIR__ . '/', array_map(fn($env) => basename($env), $envs), true);
$client = new Client();
$words = [];
$lines = file(__DIR__ . '/words_alpha.txt');

try {
    for ($i = 0; $i < WORDS_COUNT; $i++) {
        $word = rtrim($lines[array_rand($lines)]);
        $has_translation = hasWordTranslation($translations, $word);
        if (!$has_translation) {
            $params = ['sl' => 'en', 'dl' => 'ru', 'text' => $word];
            $response = $client->request(
                'GET',
                $_ENV['API_TRANSLATION_ENDPOINT'] . '/translate?' . http_build_query($params),
                ['verify' => false]
            );
            $translation = json_decode($response->getBody()->getContents(), true)['destination-text'];
        }
        $words[] = ['word' => $word, 'translation' => $translation];
    }
} catch (ClientException  $e) {
    http_response_code(400);
    echo $e->getResponse()->getBody()->getContents();
    die;
}

foreach ($words as $data) {
    $has_translation = hasWordTranslation($translations, $data['word']);
    if (!$has_translation) {
        $translations[] = $data;
    }
}

file_put_contents($translation_file, json_encode($translations, JSON_PRETTY_PRINT));

echo json_encode($words);