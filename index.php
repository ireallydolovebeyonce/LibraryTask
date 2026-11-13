<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use App\Enums\Status;
use App\Models\Book;
use App\Models\Magazine;
use App\Models\Reader;

echo 'Оцифровка библиотеки...' . PHP_EOL;

$book1 = new Book('Масло', Status::Available);
$book2 = new Book('Мечтают ли андроиды об электроовцах', Status::Available);
$book3 = new Book('Призрак оперы', Status::Available);
$book4 = new Book('Улисс', Status::InRepair); // На реставрации

$magazine1 = new Magazine('National Geographic', Status::Available);
$magazine2 = new Magazine('Science', Status::Available);

echo 'Оцифровка читателей...' . PHP_EOL;

$reader1 = new Reader('Вера');
$reader2 = new Reader('Анатолий');

echo 'Сценарий 1. Вера берет 2 книги и 1 журнал' . PHP_EOL;

try {
    $book1->borrowItem($reader1);
} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}

try {
    $book2->borrowItem($reader1);
} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}

try {
    $magazine1->borrowItem($reader1);
} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}

echo 'Сценарий 2. Вера пытается взять 4ое издание' . PHP_EOL;

try {
    $book3->borrowItem($reader1);
} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}

echo 'Сценарий 3. Анатолий пытается взять книгу, которую уже взяла Вера' . PHP_EOL;

try {
    $book2->borrowItem($reader2);
} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}

echo 'Сценарий 4. Анатолий пытается взять гнигу на реставрации' . PHP_EOL;

try {
    $book4->borrowItem($reader2);
} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}

echo 'Сценарий 5. Вера возвращает книгу' . PHP_EOL;

try {
    $book1->returnItem($reader1);
} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}

echo 'Сценарий 6. Вера пытается вернуть книгу, которую не брала' . PHP_EOL;

try {
    $book4->returnItem($reader1);
} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}