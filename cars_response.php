<?php 
#----------------------------------------------------------------------------------------
# Car response page - expecting the selected car id to be passed within the session
# Created 14/10/2018
#------------------------------	----------------------------------------------------------
	
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

			//has arrived with session so now get the car id
				$carSelectedIdPassed  = (int) $_SESSION['carSelectedId'];
				$capturedSession = $_SESSION['yourVisitID'];
				
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
					  if (empty($_POST['selectionAgreeDisagree1'])) {
							$errors[] = 'Please agree or disagree - question 1.';
						 } else {
								 $selectedAgreeDisagree1 = htmlspecialchars( strip_tags($_POST['selectionAgreeDisagree1']) );	
								}
								
									 if (empty($_POST['inputWords1'])) {
											$inputWords1 = NULL;
										} else {
												$inputWords1 = htmlspecialchars( strip_tags($_POST['inputWords1']) );	
										}
										
											if (empty($_POST['inputResponseWord1'])) {
													$errors[] = 'No response word was selected.';
												} else {
													$responseWord1 = htmlspecialchars( strip_tags($_POST['inputResponseWord1']) );	
												}
											
						 // ------------------------------------------------------------------------------------------------------------------------ //
														if (empty($_POST['selectionAgreeDisagree2'])) {
																$errors[] = 'Please agree or disagree - question 2.';
															 } else {
																$selectedAgreeDisagree2 = htmlspecialchars( strip_tags($_POST['selectionAgreeDisagree2']) );
															 }
									 
																 if (empty($_POST['inputWords2'])) {
																		$inputWords2 = NULL;
																	} else {
																			$inputWords2 = htmlspecialchars( strip_tags($_POST['inputWords2']) );	
																	}	

																		if (empty($_POST['inputResponseWord2'])) {
																				$errors[] = 'No response word was selected.';
																			} else {
																					$responseWord2 = htmlspecialchars( strip_tags($_POST['inputResponseWord2']) );	
																			}
						// -------------------------------------------------------------------------------------------------------------------------- //
																						if (empty($_POST['selectionAgreeDisagree3'])) {
																								$errors[] = 'Please agree or disagree - question 3.';
																							} else {
																								$selectedAgreeDisagree3 = htmlspecialchars( strip_tags($_POST['selectionAgreeDisagree3']) );
																							}
																				 
																								if (empty($_POST['inputWords3'])) {
																										$inputWords3 = NULL;
																									} else {
																										$inputWords3 = htmlspecialchars( strip_tags($_POST['inputWords3']) );	
																									}	
																									
																										if (empty($_POST['inputResponseWord3'])) {
																												$errors[] = 'No response word was selected.';
																											} else {
																												$responseWord3 = htmlspecialchars( strip_tags($_POST['inputResponseWord3']) );	
																											}
						// -------------------------------------------------------------------------------------------------------------------------- //							 
														 if (empty($_POST['selectionAgreeDisagree4'])) {
																$errors[] = 'Please agree or disagree - question 4.';
															} else {
																$selectedAgreeDisagree4 = htmlspecialchars( strip_tags($_POST['selectionAgreeDisagree4']) );
															}
									 
																if (empty($_POST['inputWords4'])) {
																		$inputWords4 = NULL;
																	} else {
																		$inputWords4 = htmlspecialchars( strip_tags($_POST['inputWords4']) );	
																	}

																		if (empty($_POST['inputResponseWord4'])) {
																				$errors[] = 'No response word was selected.';
																			} else {
																					$responseWord4 = htmlspecialchars( strip_tags($_POST['inputResponseWord4']) );	
																			}
						// -------------------------------------------------------------------------------------------------------------------------- //							 
							 if (empty($_POST['selectionAgreeDisagree5'])) {
									$errors[] = 'Please agree or disagree - question 5.';
								} else {
									$selectedAgreeDisagree5 = htmlspecialchars( strip_tags($_POST['selectionAgreeDisagree5']) );
								}
								
									if (empty($_POST['inputWords5'])) {
											$inputWords5 = NULL;
										} else {
											$inputWords5 = htmlspecialchars( strip_tags($_POST['inputWords5']) );	
										}	
										
										if (empty($_POST['inputResponseWord5'])) {
													$errors[] = 'No response word was selected.';
												} else {
													$responseWord5 = htmlspecialchars( strip_tags($_POST['inputResponseWord5']) );	
												}
						// -------------------------------------------------------------------------------------------------------------------------- //																	 
						 
		
					if (empty($errors)) {   // No errors so sweet to carry on
					
						
						// Output variables for debugging purposes         // 
						      $mySession = session_id();
						//	   print $mySession;
								
						//		print $carSelectedIdPassed;
						//			print $responseWord1;
						//				print $selectedAgreeDisagree1;
						//					print $inputWords1;
											
						//			print $responseWord2;
						//				print $selectedAgreeDisagree2;
						//					print $inputWords2;
										
						//			print $responseWord3;	
						//				print $selectedAgreeDisagree3;
						//					print $inputWords3;
											
						//			print $responseWord4;		
						//				print $selectedAgreeDisagree4;
						//					print $inputWords4;
									
						//			print $responseWord5;
						//				print $selectedAgreeDisagree5;
						//					print $inputWords5;
											
						// Do insert into database record                         //					
						//Connect to the database using the PDO conection method  //
						try {
							require('./dbscripts/cultrv8_mysql_PDO_connect.php'); 
				
							//Get user_id and first name
								$dbh = new PDO('mysql:host='. DB_HOST .';dbname=' .DB_NAME, DB_USER, DB_PASSWORD);
								$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
									$carInsertStmt = $dbh->prepare("INSERT INTO car_response_word_association_response 
																	(
																		session_id,
																		car_id,
																		response_word1,
																		response_word2,
																		response_word3,
																		response_word4,
																		response_word5,
																		response1_alternative,
																		response2_alternative,
																		response3_alternative,
																		response4_alternative,
																		response5_alternative,
																		word1_response,
																		word2_response,
																		word3_response,
																		word4_response,
																		word5_response,
																		time_stamp
																	)
																	VALUES (
																				:v_session_id,
																				:v_car_id,
																				:v_response_word1,
																				:v_response_word2,
																				:v_response_word3,
																				:v_response_word4,
																				:v_response_word5,
																				:v_response1_alternative,
																				:v_response2_alternative,
																				:v_response3_alternative,
																				:v_response4_alternative,
																				:v_response5_alternative,
																				:v_word1_response,
																				:v_word2_response,
																				:v_word3_response,
																				:v_word4_response,
																				:v_word5_response,
																				NOW()
																			)");
																				
																				$carInsertStmt->bindParam(':v_session_id', $mySession);
																				$carInsertStmt->bindParam(':v_car_id', $carSelectedIdPassed);
																				$carInsertStmt->bindParam(':v_response_word1', $responseWord1);
																				$carInsertStmt->bindParam(':v_response_word2', $responseWord2);
																				$carInsertStmt->bindParam(':v_response_word3', $responseWord3);
																				$carInsertStmt->bindParam(':v_response_word4', $responseWord4);
																				$carInsertStmt->bindParam(':v_response_word5', $responseWord5);
																				$carInsertStmt->bindParam(':v_response1_alternative', $inputWords1);
																				$carInsertStmt->bindParam(':v_response2_alternative', $inputWords2);
																				$carInsertStmt->bindParam(':v_response3_alternative', $inputWords3);
																				$carInsertStmt->bindParam(':v_response4_alternative', $inputWords4);
																				$carInsertStmt->bindParam(':v_response5_alternative', $inputWords5);
																				$carInsertStmt->bindParam(':v_word1_response', $selectedAgreeDisagree1);
																				$carInsertStmt->bindParam(':v_word2_response', $selectedAgreeDisagree2);
																				$carInsertStmt->bindParam(':v_word3_response', $selectedAgreeDisagree3);
																				$carInsertStmt->bindParam(':v_word4_response', $selectedAgreeDisagree4);
																				$carInsertStmt->bindParam(':v_word5_response', $selectedAgreeDisagree5);
											
																					// Now run the insert query
																						$carInsertStmt->execute();
							}
								catch(PDOException $e)   {
										Print ' <div class="alert alert-danger" role="alert">
													SQL Error: '  . $e->getMessage();
										print '</div>';
										 exit();
							}
																																			
									//Release the PDO connection
										$dbh = null;
										Print ' <div class="alert alert-danger" role="alert">
													Database insert was succesful! 
												</div>';
												
													//Defining the URL for redirecting to (using absolute URLS)
														//TODO: Live site is HTTPS? 
															$url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']);
															
																//Now add page with car selected parameter to URL
																	$url .= '/anchors_oars.php';
																		// now actually do the redirect and exit page
																			header("Location: $url");
																				exit();  
																				
														
					} else  { // there was an error - display it
								print ' <div class="alert alert-danger" role="alert">
										 Ops! No Words have been selected.
										</div>';
					
					} //End of if (empty($errors))
		
	} //End of submit php
	
//-------  End of the submit section ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------/

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
	
	<!-- NAV  BAR ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------>
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
									</ul>
								</div>
			</nav>
	<!-- END OF NAV BAR SECTION ------------------------------------------------------------------------------------------------------------------------------------------------------------------------->
			
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
											<select class="form-control form-control-lg" id="selectionAgreeDisagree" name="selectionAgreeDisagree1">
											  <option>Agree</option>
											  <option>Disagree</option>
											</select>
										</div>
									</div>
									
									<div class="col-2">
										<input type="text" readonly class="form-control-lg form-control-plaintext" id="staticEmail2" name="inputResponseWord1" value="<?php echo $responseWord1; ?>">
									</div>
									
									<div class=" col">
										<input type="text" class="form-control" id="EnteredWord1" name="inputWords1" placeholder="Enter other words you would use to describe your choice, and your organisation?">
									</div>	
							</div><!-- End of row -->		
									
									
									
							<div class="row">  
									<div class="col-2">
											<div class="form-group">
												 <select class="form-control form-control-lg" id="selectionAgreeDisagree" name="selectionAgreeDisagree2">
												  <option>Agree</option>
												  <option>Disagree</option>
												</select>
											</div>
									</div>
									
									<div class="col-2">
										<input type="text" readonly class="form-control-lg form-control-plaintext" id="staticEmail2" name="inputResponseWord2" value="<?php echo $responseWord2; ?>">
									</div>
							  
									<div class="col">
										<input type="text" class="form-control" id="EnteredWord2" name="inputWords2" placeholder="Enter other words you would use to describe your choice, and your organisation?">
									</div>	
							</div><!-- End of row -->	
							
							
							<div class="row">
									<div class="col-2">
										<div class="form-group">
											 <select class="form-control form-control-lg" id="selectionAgreeDisagree" name="selectionAgreeDisagree3">
											  <option>Agree</option>
											  <option>Disagree</option>
											</select>
										</div>
									</div>
									
									<div class="col-2">
										<input type="text" readonly class="form-control-lg form-control-plaintext" id="staticEmail2" name="inputResponseWord3" value="<?php echo $responseWord3; ?>">
									</div>
									
									<div class="col">
										<input type="text" class="form-control" id="EnteredWord3" name="inputWords3" placeholder="Enter other words you would use to describe your choice, and your organisation?">
									</div>	
							</div><!-- End of row -->	
									
									
							  
							<div class="row"> 
									<div class="col-2">
										<div class="form-group">
											 <select class="form-control form-control-lg" id="selectionAgreeDisagree" name="selectionAgreeDisagree4">
											  <option>Agree</option>
											  <option>Disagree</option>
											</select>
										</div>
									</div>
									
									<div class="col-2">
										<input type="text" readonly class="form-control-lg form-control-plaintext" id="staticEmail2" name="inputResponseWord4" value="<?php echo $responseWord4; ?>">
									</div>
									
									<div class="col">
										<input type="text" class="form-control" id="EnteredWord4" name="inputWords4" placeholder="Enter other words you would use to describe your choice, and your organisation?">
									</div>	
							</div><!-- End of row -->	
									
									
							<div class="row">
									<div class="col-2">
										<div class="form-group">
												<select class="form-control form-control-lg" id="selectionAgreeDisagree" name="selectionAgreeDisagree5">
												  <option>Agree</option>
												  <option>Disagree</option>
												</select>
										</div>
									</div>
									
									<div class="col-2">
										<input type="text" readonly class="form-control-lg form-control-plaintext" id="staticEmail2" name="inputResponseWord5" value="<?php echo $responseWord5; ?>">
									</div>
									
									<div class="col">
										<input type="text" class="form-control" id="EnteredWord5" name="inputWords5" placeholder="Enter other words you would use to describe your choice, and your organisation?">
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