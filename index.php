<?php

require __DIR__ . '/vendor/autoload.php';

use App\Classes\HttpState;
use App\Classes\DefaultConfig;
use App\Classes\HtmlDataGrid;
use App\Classes\Error;

$file = "files/data.json";
if(!file_exists($file)){
    $error = new Error();
    $tableHtml = $error->criticalError('Nie ma takiego pliku');
}else{
    $rows = json_decode(file_get_contents($file), true);
    $state = HttpState::create();
    $dataGrid = new HtmlDataGrid();
    $config = (new DefaultConfig())
            ->addIntColumn('id')
            ->addTextColumn('name')
            ->addIntColumn('age')
            ->addTextColumn('company')
            ->addCurrencyColumn('balance', 'USD')
            ->addTextColumn('phone')
            ->addTextColumn('email');
    $tableHtml = $dataGrid->withConfig($config)->render($rows, $state);
}
#echo $dataGrid->withConfig($config)->render($rows, $state);


function vardumper($html){
    echo '<pre>' , var_dump($html) , '</pre>';
}

?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">

    <title>eengine - zadanie testowe</title>
  </head>
  <body>
      <div class="example">
        <?= $tableHtml; ?>
      </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>

  </body>
</html>