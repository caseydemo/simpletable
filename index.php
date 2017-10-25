</<?php 

<!DOCTYPE html>
	<html>
		<head>
		  <title>PHP Used Car Website</title>
		  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
		  <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
		  <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
		  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
		</head>
		<body class="container">

		<?php 
		  function getDb() {
		    if (file_exists('.env')) {
		      require __DIR__ . '/vendor/autoload.php';
		      $dotenv = new Dotenv\Dotenv(__DIR__);
		      $dotenv->load();
		    }
		    $url = parse_url(getenv("DATABASE_URL"));
		    // var_dump($url);
		    $db_port = $url['port'];
		    $db_host = $url['host'];
		    $db_user = $url['user'];
		    $db_pass = $url['pass'];
		    $db_name = substr($url['path'], 1);
		    $db = pg_connect(
		      "host=" . $db_host .
		      " port=" . $db_port .
		      " dbname=" . $db_name .
		      " user=" . $db_user .
		      " password=" . $db_pass);
		    return $db;
		  }
		  function getInventory() {
		    $request = pg_query(getDb(), "
		        SELECT i.id, i.year, i.mileage, mo.name as model, mo.doors, ma.name as make, c.name as color
		        FROM inventory i
		        JOIN models mo ON i.model_id = mo.id
		        JOIN makes ma ON mo.make_id = ma.id
		        JOIN colors c ON i.color_id = c.id;
		    ");
		    return pg_fetch_all($request);
		  }
		?>

		  <h1>PHP Used Car Website</h1>
		  <h2>Quality Pre-Owned Vehicles...powered by PHP!</h2>

		  <div style="padding: 10px;"></div>

		  <table class="table">
		    <tr>
		      <th>ID</th>
		      <th>Year</th>
		      <th>Make</th>
		      <th>Model</th>
		      <th>Color</th>
		      <th>Doors</th>
		      <th>Mileage</th>
		    </tr>

		<?php
		  foreach (getInventory() as $car) {
		    echo "<tr>";    
		    echo "<td>" . $car['id'] . "</td>";
		    echo "<td>" . $car['year'] . "</td>";
		    echo "<td>" . $car['make'] . "</td>";
		    echo "<td>" . $car['model'] . "</td>";
		    echo "<td>" . $car['color'] . "</td>";
		    echo "<td>" . $car['doors'] . "</td>";
		    echo "<td>" . $car['mileage'] . "</td>";
		    echo "</tr>\n";
		  }
		?>

		</table>

		</body>
		</html>



 ?>