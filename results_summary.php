<?php
#----------------------------------------------------------------------------------------
# Results Summary- expecting session to be set
# Created 13/11/2018
#-----------------------------------------------------------------------------------------

//------- start of session handling looking for car selected id to be passed------------//

// Send nothing to the browser prior to the
// session_start() line
		session_name ('yourVisitID');
		session_start();
					if (!isset($_SESSION['carSelectedId'])) { //you've arrived with no session set
						
						print ' <div class="alert alert-danger" role="alert">
								 Ops! This page has been loaded incorrectly.
								</div>';
						exit(); 
					}	
					
					$carSelectedIdPassed  = (int) $_SESSION['carSelectedId'];
				
//-------  End of session handling --------------------------------------------------------/

			$mySession = session_id();
			
//------   Get car name from the selected id ----------------------------------------------/
				require('./dbscripts/cultrv8_mysql_PDO_connect.php'); 
				
					//Get user_id and first name
						$dbh = new PDO('mysql:host='. DB_HOST .';dbname=' .DB_NAME, DB_USER, DB_PASSWORD);
					
								$PDO_carSelect = $dbh->prepare("SELECT car_name
																FROM car_list
																WHERE car_list_id = '$carSelectedIdPassed'");
								$PDO_carSelect->execute();
							
									// Fetch all the rows in the result set
										$result = $PDO_carSelect->fetch(PDO::FETCH_NUM);
											if ($result) { // A record was successfully retrieved
												 $carSelectedName = $result[0];
											} else {
												$carSelectedName ='Nothing was found';
											}
										
									//Release the PDO connection
										$dbh = null;	

//------    End of car name selection -----------------------------------------------------/										
										

?>


<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
	<meta name="robots" content="noindex">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">

    <title>Results Summary</title>
  </head>
  
  <body>
	
	<!-- NAV  BAR ------------------------------------------------------------>
			<nav class="navbar navbar-expand-lg navbar-light">
				  <a class="navbar-brand" href="index.php">
					<img src="img/Cultrv8_logo.jpg" width="250" height="179" class="d-inline-block align-top" alt="">
				  </a>
						<!-- MOBILE HAMBURGER -->
						<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
							<span class="navbar-toggler-icon"></span>
						</button>
						<!-- END OF MOBILE HAMBURGER SECTION -->
			  
								 <div class="collapse navbar-collapse" id="navbarNav">
									<ul class="navbar-nav">
									  
									  <li class="nav-item ml-4 mr-2">
										<a class="btn btn-success btn-lg" href="share_results.php">Back <span class="sr-only">(current)</span></a>
									  </li>
									  
									  <li class="nav-item ml-4 mr-2">
										<a class="btn btn-success btn-lg" href="join_movement.php">Next</a>
									  </li>
									</ul>
								</div>
			</nav>
	<!-- END OF NAV BAR SECTION ---------------------------------------------->
	
	
			
			  <!-- Content here -->
			<div class="container">
			
				<div class="row"><!-- Start of row 1 -->
						
						<div class="col-sm"><!-- Column 1 -->
					
							  <h1 class="mt-4">Results Summary</h1>
							  <h2>Break down of results...</h2>
							  
								  <h3>Car selected: 
										<div class="alert alert-success" role="alert">
											<?php echo $carSelectedName; ?></h2>
										</div>
								  </h3>
							  
							  <h3>Car association: </h3>
							  
						</div><!-- End of column 1-->
						
						<div class="col-sm"><!-- Column 2 -->
							<div class="text-center">
								<img src="img/Crab_home_big_logo.jpg" class="img-fluid float-right" alt="Cultrv8 Crab Logo">
							</div>
						</div><!-- End of column 2 -->
						    
				</div><!-- end of row 1 --->
				
				<div class="row"><!-- Start of row 2 -->
					<div class="col-sm"><!-- Start of column 1 -->
				
						<a class="btn btn-success btn-lg" href="join_movement.php">Next</a>
						
					</div><!-- End of column 1-->
					
				</div><!-- End of row 2 -->
					  
					
				<div class="row"><!-- Start of row 3 -->
				
						
				</div><!-- end of row 3 -->
				
			</div><!-- End of the container -->
			
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
  </body>
</html>