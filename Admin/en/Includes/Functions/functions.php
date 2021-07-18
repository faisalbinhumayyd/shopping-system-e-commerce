 <?php
	function redirectHome($theMsg, $url = null, $seconds = 3) {

		if ($url === null) {
            
			$url = 'index.php';
			$link = 'Homepage';
            
		} else {

			if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !== '') {

				$url = $_SERVER['HTTP_REFERER'];
				$link = 'Previous Page';

			} else {

				$url = 'index.php';
				$link = 'Home Page';

			}

		}

		echo $theMsg;
        
		echo "<div class='container '>
        <img style='margin: 0 auto;width: 100%;' src='../load.gif'/>
            <div style='color: #2882e7;
background-color: #fff;
border-color: #fff;
font-size: 22px;
text-align: center;
background: -webkit-linear-gradient(#2882e7, #ee59ef);
background-clip: border-box;
-webkit-background-clip: text;
-webkit-text-fill-color: transparent;
font-weight: bold;' class='alert alert-info'>
                we will redrict you after $seconds Seconds To $link.
            </div>
            
        </div>";
		header("refresh:$seconds;url=$url");
		exit();

	}


	function checkItem($select, $from, $value) {

		global $con;

		$statement = $con->prepare("SELECT $select FROM $from WHERE $select = ?");

		$statement->execute(array($value));

		$count = $statement->rowCount();

		return $count;

	}
