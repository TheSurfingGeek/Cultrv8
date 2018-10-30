<?php
#----------------------------------------------------------------------------------------
# Car selection page
# Created 13/10/2018
#----------------------------------------------------------------------------------------
	
//Check if the form has been submitted
	if (isset($_POST['submitted'])) {
		
		//Initialise errors array
		  $errors = array();
		
		//Check for required fields
		  if (empty($_POST['carSelectedInput'])) {
				$errors[] = 'No car selection was made.';
			 } else {
				$carSelected = htmlspecialchars( strip_tags($_POST['carSelectedInput']) );
			 }
			 
				if (empty($errors)) {   // No errors so sweet to carry on
				     print '<p>The car selected was: </p>' .$carSelected;
						//Now move to the next page and pass in the car selected value 
							
							//TODO: capture what car was selected and put into database?
							
								//Start a session and set the session variable for car id before loading the next page
									session_start();
										$_SESSION['carSelectedId'] = $carSelected;
								 
									//Defining the URL for redirecting to (using absolute URLS)
									//TODO: Live site is HTTPS? 
										$url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
										
											//Now add page with car selected parameter to URL
												$url .= '/cars_response.php?cs='.$carSelected;
													// now actually do the redirect and exit page
														header("Location: $url");
															exit();  
					 
				} else { // there was an error - display it
				    print ' <div class="alert alert-danger" role="alert">
							 Ops! No car selection was made. Please select a car to continue.
					        </div>';
				} //End of if (empty($errors))
		
	} //End of submit php

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

    <title>Question 1- Cultrv8</title>
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
										<a class="btn btn-success btn-lg" href="index.php">Back <span class="sr-only">(current)</span></a>
									  </li>
									  
									  <li class="nav-item ml-4 mr-2">
										<a class="btn btn-success btn-lg" href="cars_response.php">Next</a>
									  </li>
									</ul>
								</div>
			</nav>
	<!-- END OF NAV BAR SECTION ---------------------------------------------->
			
			  <!-- Content here -->
			<div class="container">
			
				
					<div class="row"><!-- row -->
							<div class="col-sm"><!-- Column 1-->
									
									<h1 class="mt-4">So, here's an easy game to start with, it's called Cars:</h1>
								  
									<h3>If you were to compare your organisation to a kind of vehicle, which of these would you choose:</h3>
									
											<form action="cars.php" method="post"  id="carQuestion1"><!-- start of form -->
											   <?php
												
												//Connect to the database using the PDO conection method
													require('./dbscripts/cultrv8_mysql_PDO_connect.php');  
				
												//Query the car list and loop through the results 
													$dbh = new PDO('mysql:host='. DB_HOST .';dbname=' .DB_NAME, DB_USER, DB_PASSWORD);
					
														$PDO_carNameQuery = $dbh->prepare("SELECT car_list_id,car_name FROM cultrv8_db.car_list
																							 WHERE car_name_display = 1");
															$PDO_carNameQuery->execute();
																	$rowset = $PDO_carNameQuery->fetchAll(PDO::FETCH_NUM);
																				if ($rowset) {
																					foreach ($rowset as $row) {
																						//Loop through the results and create the radio button list
																								//TODDO: Increment class id
																								print '<div class="form-check form-control-lg">
																									<input class="form-check-input" type="radio" name="carSelectedInput" id="exampleRadios1" value="'.$row[0].'">
																									<label class="form-check-label" for="exampleRadios1">
																										'.$row[1].'
																									</label>
																								</div>';
																					}
																				} else {  //No rowset was returned 
																					print ' <div class="alert alert-danger" role="alert">
																								Ops! We have an issue getting a list of cars for you.
																						    </div>';
																				}
													//Release the PDO connection
													$dbh = null;
																 
											 	?>
													 <!-- Submit form action -->
														<div class="float-right">
															 <button type="submit" name="submit" class="btn btn-success btn-lg" tabindex = "1">Next</button>
															 <input type="hidden" name="submitted" value="TRUE" />
														</div>
													 <!-- End of button submit -->
													
											 </form> <!-- End of form -->
											 
							 </div><!-- End of Column 1 -->
							 
							 <div class="col-sm"><!-- Column 2 -->
								<div class="text-center">
									<img src="img/Crab_home_big_logo.jpg" class="img-fluid float-right" alt="Cultrv8 Crab Logo">
								</div>
							</div><!-- End of column 2 -->
						  
							
					</div><!-- End of row -->
			
			</div><!-- End of container -->
	
	
	
	
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
  </body>
</html>