<?php
require 'vendor/autoload.php';

use GuzzleHttp\Client;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

// Skapa en HTTP-client
$client = new Client(["headers" => ["Accept" => "application/json"]]);

// Anropa URL: http://unicorns.idioti.se/
$res = $client->request('GET', 'http://unicorns.idioti.se/');

// Omvandla JSON-svar till datatyper
$data = json_decode($res->getBody());

$log = new Logger("LoggerTest");
$log->pushHandler(new StreamHandler('UnicornLog.log', Logger::INFO));

$log->info("index.php visited page");

?>
<!DOCTYPE html>
<html>
  <head>
    <title>Assignment 1</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  </head>
  <body>
    <div class="container">
      <h1>Enhörningar:</h1>
      <form action="UnicornDetails.php" method="get">
        <div class="form-group">
          <label for="id-field">Sök på ID</label>
          <input type="number" id="id-field" name="id" class="form-control" required>
        </div>
        <div class="form-group">
          <input type="submit" value="Visa enhörning" class="btn btn-success">
        </div>
      </form>
    </div>
<div>

<div class="container">
  <h3>Alla enhörningar</h3>
    <div class="col-md-6 anyClass">
      <ul class="nav ">
        <?php
        foreach($data as $unicorn) { ?>
          <li class="list-group">
            <div class="list-group-item">
              <div class="container">
                <label><?= $unicorn->id?>.</label>
                <label><?= $unicorn->name?></label>
                <a class="nav-link btn" href="/UnicornDetails.php/?id=<?= $unicorn->id?>">Läs mer...</a>

              </div>
            </div>
          </li>
        <?php } ?>
      </ul>
    </div>
  </div>
</div>
</body>
</html>
