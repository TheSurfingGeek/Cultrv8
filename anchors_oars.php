<?php
#----------------------------------------------------------------------------------------
# Anchors Oars - expecting session to still be set
# Created 24/10/2018
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


//-----    Check if the form has been submitted -------------------------------------------/
	if (isset($_POST['submitted'])) {
		
		//Initialise errors array
		  $errors = array();
		
			//Check for required fields
			
					  if (empty($_POST['oarEntry1'])) {
							$errors[] = 'Sorry we\'re missing some Oar entrys - please put in 3 of them.';
						 } else {
								 $inputOarEntry1 = htmlspecialchars( strip_tags($_POST['oarEntry1']) );	
								}
					 // ------------------------------------------------------------------------------------------------------------------------------------------------ //

											 if (empty($_POST['oarEntry2'])) {
													$errors[] = 'Sorry we\'re missing some Oar entrys - please put in 3 of them.';
												 } else {
														 $inputOarEntry2 = htmlspecialchars( strip_tags($_POST['oarEntry2']) );	
												}
					 // ------------------------------------------------------------------------------------------------------------------------------------------------- //
								
																 if (empty($_POST['oarEntry3'])) {
																		$errors[] = 'Sorry we\'re missing some Oar entrys - please put in 3 of them.';
																	} else {
																		$inputOarEntry3 = htmlspecialchars( strip_tags($_POST['oarEntry3']) );	
																	}
					// -------------------------------------------------------------------------------------------------------------------------------------------------- //

																 if (empty($_POST['anchorEntry1'])) {
																	$errors[] = 'Sorry we\'re missing some Anchor entrys - please put in 3 of them.';
																 } else {
																		 $inputAnchorEntry1 = htmlspecialchars( strip_tags($_POST['anchorEntry1']) );	
																		}
					 // ------------------------------------------------------------------------------------------------------------------------------------------------- //
					 
											  if (empty($_POST['anchorEntry2'])) {
													$errors[] = 'Sorry we\'re missing some Anchor entrys - please put in 3 of them..';
												 } else {
														 $inputAnchorEntry2 = htmlspecialchars( strip_tags($_POST['anchorEntry2']) );	
														}
					 // ------------------------------------------------------------------------------------------------------------------------------------------------- //
					 
						  if (empty($_POST['anchorEntry3'])) {
								$errors[] = 'Sorry we\'re missing some Anchor entrys - please put in 3 of them..';
							 } else {
									 $inputAnchorEntry3 = htmlspecialchars( strip_tags($_POST['anchorEntry3']) );	
									}
					 // ------------------------------------------------------------------------------------------------------------------------------------------------- //
					 
		if (empty($errors)) {   // No errors so sweet to carry on
		
				// Output variables for debugging purposes         // 
						      $mySession = session_id();
							   
								print $mySession;
								print $inputOarEntry1;
								print $inputOarEntry2;
								print $inputOarEntry3;
								print $inputAnchorEntry1;
							    print $inputAnchorEntry2;
								print $inputAnchorEntry3;
								
						// Do insert into database record                         //					
						//Connect to the database using the PDO conection method  //
						
						try {
							require('./dbscripts/cultrv8_mysql_PDO_connect.php'); 
				
							//Get user_id and first name
								$dbh = new PDO('mysql:host='. DB_HOST .';dbname=' .DB_NAME, DB_USER, DB_PASSWORD);
								$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
									$anchors_Oars_InsertStmt = $dbh->prepare("INSERT INTO anchors_oars_response
																				(
																					session_id,
																					oars_response1,
																					oars_response2,
																					oars_response3,
																					anchors_response1,
																					anchors_response2,
																					anchors_response3,
																					time_stamp
																				)
																				VALUES
																				(
																					:v_session_id,
																					:v_oars_response1,
																					:v_oars_response2,
																					:v_oars_response3,
																					:v_anchors_response1,
																					:v_anchors_response2,
																					:v_anchors_response3,
																					NOW()
																				)");
																				
																					$anchors_Oars_InsertStmt->bindParam(':v_session_id', $mySession);
																					$anchors_Oars_InsertStmt->bindParam(':v_oars_response1', $inputOarEntry1);
																					$anchors_Oars_InsertStmt->bindParam(':v_oars_response2', $inputOarEntry2);
																					$anchors_Oars_InsertStmt->bindParam(':v_oars_response3', $inputOarEntry3);
																					$anchors_Oars_InsertStmt->bindParam(':v_anchors_response1', $inputAnchorEntry1);
																					$anchors_Oars_InsertStmt->bindParam(':v_anchors_response2', $inputAnchorEntry2);
																					$anchors_Oars_InsertStmt->bindParam(':v_anchors_response3', $inputAnchorEntry3);
											
																					// Now run the insert query
																						$anchors_Oars_InsertStmt->execute();
							}
								catch(PDOException $e)   {
										Print ' <div class="alert alert-danger" role="alert">
													SQL Error: '  . $e->getMessage();
										print '</div>';
										 exit();
							}
																																			
									//Release the PDO connection
										$dbh = null;		
				
		
										//Defining the URL for redirecting to (using absolute URLS)
																	//TODO: Live site is HTTPS? 
																		$url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
																		
																			//Now add page with car selected parameter to URL
																				$url .= '/anchors_oars_response.php';
																					// now actually do the redirect and exit page
																						header("Location: $url");
																							exit();  
																	
		} else  { // there was an error - display it
								echo ' <div class="alert alert-danger" role="alert">
										 Ops! It looks like something is missing!? </br>';
										 	foreach ($errors as $msg) {
											echo " - $msg <br />";
										}	
								echo '		</div>';
		
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

    <title>Question 3- Anchors & Oars questions</title>
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
													<a class="btn btn-success btn-lg" href="cars_response.php">Back <span class="sr-only">(current)</span></a>
												  </li>
									</ul>
								</div>
			</nav>
	<!-- END OF NAV BAR SECTION ---------------------------------------------->
			
			  <!-- Content here -->
			<div class="container">
			
				<div class="row"><!-- Start of row 1 -->
						
						<div class="col-sm"><!-- Column 1 -->
					
							  <h1 class="mt-4">OK, ready for the next game? This one's called Anchors and Oars.</h1>
							  <p>For you non nautical types, all you need to know is that Anchors hold us back, and Oars propel us forwards - got it?</p>
							  <p>What do you see are the cultural anchors and oars for your organisation?</p>
							  
						
						</div><!-- End of column 1-->
						
						<div class="col-sm"><!-- Column 2 -->
							<div class="text-center">
								<img src="img/Crab_home_big_logo.jpg" class="img-fluid float-right" alt="Cultrv8 Crab Logo">
							</div>
						</div><!-- End of column 2 -->
						  
						  
				</div><!-- end of row --->
					  
					
				<div class="row"><!-- Start of row 2 -->
				
					<div class="col"><!-- Form column -->
						<form action="anchors_oars.php" method="post"  id="car_response_selection">
									<div class="row">
										<div class="col">
											<div class="form-group">
												<label for="OarEntry1" class="form-control-lg">Oar Entries</label>
												<input type="text" class="form-control border-primary" id="OarEntry1" name="oarEntry1" placeholder="Oar entry 1" tabindex = "0">
											</div>
										</div>
									 
										<div class="col">
											<div class="form-group">
												<label for="AnchorEntry1" class="form-control-lg">Anchor Entries</label>
												<input type="text" class="form-control border-secondary" id="AnchorEntry1" name="anchorEntry1" placeholder="Anchor entry 1">
											</div>
										</div>
									</div>	
									
									<div class="row">
										<div class="col">
											<div class="form-group">
												<input type="text" class="form-control border-primary" id="OarEntry2" name="oarEntry2" placeholder="Oar entry 2" >
											</div>
										</div>
									 
										<div class="col">
											<div class="form-group">
												<input type="text" class="form-control border-secondary" id="AnchorEntry2" name="anchorEntry2" placeholder="Anchor entry 2" >
											</div>
										</div>
									</div>	 
									
									<div class="row">
										<div class="col">
											<div class="form-group">
												<input type="text" class="form-control border-primary" id="OarEntry3" name="oarEntry3" placeholder="Oar Entry 3" >
											</div>
										</div>
									 
										<div class="col">
											<div class="form-group">
												<input type="text" class="form-control border-secondary" id="AnchorEntry3" name="anchorEntry3" placeholder="Anchor entry 3" >
											</div>
										</div>
									</div>	
									
											
									<!-- Submit form action -->
										<div class="float-right">
											 <button type="submit" name="submit" class="btn btn-success btn-lg" >Next</button>
											 <input type="hidden" name="submitted" value="TRUE" />
										</div>
									<!-- End of button submit -->
						
										
							</form>
					</div><!-- End of form column -->
						
				</div><!-- end of row 2 -->
				
			</div><!-- End of the container -->
			
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
  </body>
</html>