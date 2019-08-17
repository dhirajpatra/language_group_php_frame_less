<?php
declare(strict_types=1);

use Curl\Curl;
use DI\ContainerBuilder;
use LanguageApp\Language;
use function DI\create;
use function DI\get;

require_once dirname(__DIR__) . '/vendor/autoload.php';

// DI container 
$containerBuilder = new ContainerBuilder();
$containerBuilder->useAutowiring(false);
$containerBuilder->useAnnotations(false);

// pussing DI to our main class
$containerBuilder->addDefinitions([
    Language::class => create(Language::class) -> constructor( get('Curl') ),
    'Curl' => function() {
        return new Curl;
    }
]);

$container = $containerBuilder->build();

// building Language class object
$language = $container->get(Language::class);

// check command line arguments with input validation
if ($argc > 1 && $argc < 3) {
    // eg. php public/index.php India
    echo $result = $language->getLanguageDetails($argv[1]);    

} elseif ($argc > 2 && $argc < 4) { 
    // eg. php public/index.php "India" "United Kingdom of Great Britain and Northern Ireland"
    echo $result = $language->getSimilarity($argv[1], $argv[2]);    

} else {
    echo "correct number of argument required\n";
}