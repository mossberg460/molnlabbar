<?php
require 'vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\RequestException;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$client = new Client(["headers" => ["Accept" => "application/json"]]);

$log = new Logger("LoggerTest");
$log->pushHandler(new StreamHandler('UnicornLog.log', Logger::INFO));

$hasItem = false;

if (isset($_GET['id'])) {
  $id = ($_GET['id']);

  try {
    $res = $client->request('GET', "http://unicorns.idioti.se/{$id}");
    $data = json_decode($res->getBody());
    $hasItem = true;
    $log->info("Visited UnicornDetails.php with ID: {$id}");
  }
  catch (Exception $e) {
    $log->warning("Visited Unicorn.Details.php with invalid ID: {$id}");
  }
}
?>

<!doctype html>
  <html>
    <head>
      <title>FormEx</title>
      <link rel="stylesheet" type="text/css" href="/unicorns.css">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>
    <body>
      <?php
        if ($hasItem) {
      ?>
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
      <div class="centerContainer" >
        <div class="wrapper">
          <div class="box a">
            <h3><?php echo $data->name ?></h3>
            <h5>Reporter: <?php echo $data->reportedBy ?></h5>
          </div>
          <div class="box b">
            <img width="300px" src="<?php echo $data->image?>" alt="no image">
          </div>

          <div class="box c">
            <h4>Details</h4>
              <p><?php echo $data->description ?></p>
              <h5>Spotted </5>
              <p>
                <?php echo $data->spottedWhere->name ?> <br>
                Latitude <?php echo $data->spottedWhere->lat ?> <br>
                Longitude <?php echo $data->spottedWhere->lon?>
              </p>
            </div>

            <div class="box d">
              <a class="btn btn-primary" href="/index.php"> Back to list </a>
            </div>
          </div>
        </div>
      <?php }
      else {
      ?>
        <div class="centerContainer">
          <div>
            <h1> ID: <?php echo $id ?> not found </h1>
            <a class="btn btn-primary" href="/index.php"> Back to list </a>
          </div>
        </div>
      <?php } ?>
    </body>
</html>
