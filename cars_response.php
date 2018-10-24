<?php 
#----------------------------------------------------------------------------------------
# Car response page - expecting the selected car id to be passed within the session
# Created 14/10/2018
#------------------------------	----------------------------------------------------------
	
//------- start of session handling looking for car selected id to be passed------------//
// Send nothing to the browser prior to the
// session_start() line
	session_start();

			if (!isset($_SESSION['carSelectedId'])) { //you've arrived with no session set
					
					print ' <div class="alert alert-danger" role="alert">
							 Ops! This page has been loaded incorrectly.
					        </div>';
					exit();
				}	

			//has arrived with session so now get the logon id
				$carSelectedIdPassed  = (int) $_SESSION['carSelectedId'];
				
//-------  End of session handling --------------------------------------------------------/

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
												$carSelectedName ='Nothhing was found';
											}
										
									//Release the PDO connection
										$dbh = null;	

//------    End of car name selection -----------------------------------------------------/										
										

//-----    Check if the form has been submitted -------------------------------------------/
	if (isset($_POST['submitted'])) {
		
		//Initialise errors array
		  $errors = array();
		
			//Check for required fields
		
		
		if (empty($errors)) {   // No errors so sweet to carry on
		
		
		
		
		//Defining the URL for redirecting to (using absolute URLS)
									//TODO: Live site is HTTPS? 
										$url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
										
											//Now add page with car selected parameter to URL
										 		$url .= '/anchors_oars.php';
													// now actually do the redirect and exit page
														header("Location: $url");
															exit();  
		
		} //End of if (empty($errors))
		
	} //End of submit php
	
//-------  End of the submit section -------------------------------------------------------/

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

    <title>Question 2 cars- Cultrv8</title>
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
										<a class="btn btn-success btn-lg" href="cars.php">Back <span class="sr-only">(current)</span></a>
									  </li>
									  
									  <li class="nav-item ml-4 mr-2">
										<a class="btn btn-success btn-lg" href="anchors_oars.php">Next</a>
									  </li>
									</ul>
								</div>
			</nav>
	<!-- END OF NAV BAR SECTION ---------------------------------------------->
			
		  <!-- Content here -->
			<div class="container">
			
				<div class="row"><!-- Start of row 1 -->
					<div class="col-sm"><!-- Column 1 -->
			
						<h1 class="mt-4">Hey, nice job!</h1>
						<h3> You chose:
							<div class="alert alert-success" role="alert">
									<?php echo $carSelectedName; ?>
							</div>
						</h3>

						<h3>Here's a list of words associated with this choice - what do you think of these? Agree/disagree? </h3>

					</div><!-- End of column 1-->
						
					<div class="col-sm"><!-- Column 2 -->
							<div class="text-center">
								<img src="img/Crab_home_big_logo.jpg" class="img-fluid float-right" alt="Cultrv8 Crab Logo">
							</div>
					</div><!-- End of column 2 -->
					
				</div><!-- end of row --->
				
				
				<div class="row"><!-- Start of row 2 -->
				
				<div class="col"><!-- Form column -->
				<form action="cars_response.php" method="post"  id="car_response_selection">
							
						<?php
												
							//Connect to the database using the PDO conection method
								require('./dbscripts/cultrv8_mysql_PDO_connect.php');  

							//Query the car list and loop through the results to get the list of assocaited names
								$dbh = new PDO('mysql:host='. DB_HOST .';dbname=' .DB_NAME, DB_USER, DB_PASSWORD);

									$PDO_carResponseQuery = $dbh->prepare("SELECT car_response_word1, car_response_word2,car_response_word3, car_response_word4,car_response_word5
																	       FROM car_response_list
																	       WHERE car_list_id = '$carSelectedIdPassed'");
										$PDO_carResponseQuery->execute();
												$rowset = $PDO_carResponseQuery->fetchAll(PDO::FETCH_NUM);
															if ($rowset) {
																foreach ($rowset as $row) {
																	//Loop through the results and create a list of words
																		$responseWord1 = $row[0];
																		$responseWord2 = $row[1];
																		$responseWord3 = $row[2];
																		$responseWord4 = $row[3];
																		$responseWord5 = $row[4];
																}
															} else {  //No rowset was returned 
																print ' <div class="alert alert-danger" role="alert">
																			Ops! We have an issue getting a list of associated words for you.
																		</div>';
															}
								//Release the PDO connection
								$dbh = null;
																 
						?>	
							
							<div class="row"><!-- start of row -->
									<div class="col-2">
										<div class="form-group">
											<select class="form-control form-control-lg" id="exampleFormControlSelect1">
											  <option>Agree</option>
											  <option>Disagree</option>
											</select>
										</div>
									</div>
									
									<div class="col-2">
										<input type="text" readonly class="form-control-lg form-control-plaintext" id="staticEmail2" value="<?php echo $responseWord1; ?>">
									</div>
									
									<div class="col">
										<input type="text" class="form-control" id="EnteredWord1" placeholder="Enter other words you would use to describe your choice, and your organisation?">
									</div>	
							</div><!-- End of row -->		
									
									
									
							<div class="row">  
									<div class="col-2">
											<div class="form-group">
												 <select class="form-control form-control-lg" id="exampleFormControlSelect1">
												  <option>Agree</option>
												  <option>Disagree</option>
												</select>
											</div>
									</div>
									
									<div class="col-2">
										<input type="text" readonly class="form-control-lg form-control-plaintext" id="staticEmail2" value="<?php echo $responseWord2; ?>">
									</div>
							  
									<div class="col">
										<input type="text" class="form-control" id="EnteredWord2" placeholder="Enter other words you would use to describe your choice, and your organisation?">
									</div>	
							</div><!-- End of row -->	
							
							
							<div class="row">
									<div class="col-2">
										<div class="form-group">
											 <select class="form-control form-control-lg" id="exampleFormControlSelect1">
											  <option>Agree</option>
											  <option>Disagree</option>
											</select>
										</div>
									</div>
									
									<div class="col-2">
										<input type="text" readonly class="form-control-lg form-control-plaintext" id="staticEmail2" value="<?php echo $responseWord3; ?>">
									</div>
									
									<div class="col">
										<input type="text" class="form-control" id="EnteredWord3" placeholder="Enter other words you would use to describe your choice, and your organisation?">
									</div>	
							</div><!-- End of row -->	
									
									
							  
							<div class="row"> 
									<div class="col-2">
										<div class="form-group">
											 <select class="form-control form-control-lg" id="exampleFormControlSelect1">
											  <option>Agree</option>
											  <option>Disagree</option>
											</select>
										</div>
									</div>
									
									<div class="col-2">
										<input type="text" readonly class="form-control-lg form-control-plaintext" id="staticEmail2" value="<?php echo $responseWord4; ?>">
									</div>
									
									<div class="col">
										<input type="text" class="form-control" id="EnteredWord4" placeholder="Enter other words you would use to describe your choice, and your organisation?">
									</div>	
							</div><!-- End of row -->	
									
									
							<div class="row">
									<div class="col-2">
										<div class="form-group">
												<select class="form-control form-control-lg" id="exampleFormControlSelect1">
												  <option>Agree</option>
												  <option>Disagree</option>
												</select>
										</div>
									</div>
									
									<div class="col-2">
										<input type="text" readonly class="form-control-lg form-control-plaintext" id="staticEmail2" value="<?php echo $responseWord5; ?>">
									</div>
									
									<div class="col">
										<input type="text" class="form-control" id="EnteredWord5" placeholder="Enter other words you would use to describe your choice, and your organisation?">
									</div>	
							</div><!-- End of row -->	
							
							<!-- <div class="float-right"><a class="btn btn-success btn-lg" href="anchors_oars.php">Next</a></div><br> -->
							
							
							 <!-- Submit form action -->
									<div class="float-right">
										 <button type="submit" name="submit" class="btn btn-success btn-lg" tabindex = "1">Next</button>
										 <input type="hidden" name="submitted" value="TRUE" />
									</div>
							<!-- End of button submit -->
										
						</form><!-- End of form -->
				
				
				</div><!-- End of form column -->
				
				</div><!-- end of row 2 -->
			
			</div><!-- End of container -->
	
	
	
	
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
  </body>
</html>