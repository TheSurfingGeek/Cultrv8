<?php
#----------------------------------------------------------------------------------------
# Share results- expecting session to still be set
# Created 12/11/2018
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
				
//-------  End of session handling --------------------------------------------------------/

			$mySession = session_id();

//-----    Check if the form has been submitted -------------------------------------------/
	if (isset($_POST['submitted'])) {
		
		//Initialise errors array
		  $errors = array();
		
			//Check for required fields
				 
					 // ------------------------------------------------------------------------------------------------------------------------------------------------ //
				
									 if (empty($_POST['inputName'])) {
											$errors[] = 'Sorry we\'re missing your name - please enter your name.';
										 } else {
												 $capturedName = htmlspecialchars( strip_tags($_POST['inputName']) );	
												}
					 // ------------------------------------------------------------------------------------------------------------------------------------------------ //
				
													 if (empty($_POST['inputEmail'])) {
															$errors[] = 'Sorry we\'re missing your email address - please enter your email address.';
														 } else {
																 $capturedEmail = htmlspecialchars( strip_tags($_POST['inputEmail']) );	
																}
					 // ------------------------------------------------------------------------------------------------------------------------------------------------ //
					 
																		 if (empty($_POST['inputValue'])) {
																				$errors[] = 'Sorry we\'re missing the value that the person represents - Please enter a value.';
																			 } else {
																					 $capturedValue = htmlspecialchars( strip_tags($_POST['inputValue']) );	
																					}
					 // ------------------------------------------------------------------------------------------------------------------------------------------------ //
					
					
													if (empty($errors)) {   // No errors so sweet to carry on
																	//Debug section 
																	/*	print 'Name ' .$capturedName;
																		print '<br/>';
																		print 'Email ' .$capturedEmail;
																		print '<br/>';
																		print 'value ' . $capturedValue;
																		print '<br/>';
																	*/
																	
																		// Do insert into database record                         //					
																		// Connect to the database using the PDO conection method  //
																	
																				try {
																					require('./dbscripts/cultrv8_mysql_PDO_connect.php'); 
																		
																					//Get user_id and first name
																						$dbh = new PDO('mysql:host='. DB_HOST .';dbname=' .DB_NAME, DB_USER, DB_PASSWORD);
																						$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
															
																							$anchors_oars_share_insert_stmt = $dbh->prepare("INSERT INTO anchors_oars_cars_share
																																		(
																																			session_id,
																																			share_name,
																																			share_email_address,
																																			represent_value,
																																			time_stamp
																																		)
																																		VALUES
																												 						(
																																			:v_session_id ,
																																			:v_share_name,
																																			:v_share_email_address,
																																			:v_represent_value,
																																			NOW()
																																		)");
																																		
																																			$anchors_oars_share_insert_stmt->bindParam(':v_session_id', $mySession);
																																			$anchors_oars_share_insert_stmt->bindParam(':v_share_name', $capturedName);
																																			$anchors_oars_share_insert_stmt->bindParam(':v_share_email_address', $capturedEmail);
																																			$anchors_oars_share_insert_stmt->bindParam(':v_represent_value', $capturedValue);
																																			
																																			// Now run the insert query
																																				$anchors_oars_share_insert_stmt->execute();
																					}
																						catch(PDOException $e)   {
																								Print ' <div class="alert alert-danger" role="alert">
																											SQL Error: '  . $e->getMessage();
																								print '</div>';
																								 exit();
																					}
																																																	
																							//Release the PDO connection
																								$dbh = null;	
																							//Debug						
																							//	Print 'Database insert successful.';
													
																//Defining the URL for redirecting to (using absolute URLS)
																//TODO: Live site is HTTPS? 
																	$url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
																	
																		//Now add page with car selected parameter to URL
																			$url .= '/results_summary.php';
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

    <title>Share Results</title>
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
										<a class="btn btn-success btn-lg" href="anchors_oars_response.php">Back <span class="sr-only">(current)</span></a>
									  </li>

									</ul>
								</div>
			</nav>
	<!-- END OF NAV BAR SECTION ---------------------------------------------->
	
	
			
			  <!-- Content here -->
			<div class="container">
			
				<div class="row"><!-- Start of row 1 -->
						
						<div class="col-sm"><!-- Column 1 -->
					
							  <h1 class="mt-4">So how do you reckon others have done in this game? Want to find out what others say?</h1>
							  <h4>Well, i'll share the results, but i need one more thing from you - a name!</h4>
							  
						</div><!-- End of column 1-->
						
						<div class="col-sm"><!-- Column 2 -->
							<div class="text-center">
								<img src="img/Crab_home_big_logo.jpg" class="img-fluid float-right" alt="Cultrv8 Crab Logo">
							</div>
						</div><!-- End of column 2 -->
						    
				</div><!-- end of row 1 --->
				
				<div class="row"><!-- Start of row 2 -->
					<div class="col-sm"><!-- Start of column 1 -->
				
							  <p>Nope, i'm not asking you to dob in any of your mates for stealing a paper clip or taking an extra 5 mins for lunch! </p>
								
							  <p>What i'd love to know is who do you reckon is someone in the organisation that personifies what this place is about - kind of a cultural role model. And what would you say is the value that they represent?</p>

							 <p>They will get a recognition for this, and am sure will be rapt!</p>
					</div><!-- End of column 1-->
				</div><!-- End of row 2 -->
					  
					
				<div class="row"><!-- Start of row 3 -->
				
					<div class="col"><!-- Form column -->
							<form  action="share_results.php" method="post"  id="share_results_form">
									<div class="row"><!-- Row 1 -->
										<div class="col">
											<input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Name" name="inputName">
										</div>
									 
										<div class="col">
											<input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Email" name="inputEmail">
										</div>
										
										<div class="col">
											<div class="form-group">
												<input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Value" name="inputValue">
											</div>
										</div>
									</div><!-- End of row 1 -->
									
									<!-- <div class="float-right"><a class="btn btn-success btn-lg" href="results_summary.php">Next</a></div>-->
										<!-- Submit form action -->
											<div class="float-right">
												 <button type="submit" name="submit" class="btn btn-success btn-lg" >Next</button>
												 <input type="hidden" name="submitted" value="TRUE" />
											</div>
										<!-- End of button submit -->

									
							</form>
					</div><!-- End of form column -->
						
				</div><!-- end of row 3 -->
				
			</div><!-- End of the container -->
			
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
  </body>
</html>