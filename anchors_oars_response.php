<?php
#----------------------------------------------------------------------------------------
# Anchors Oars response- expecting session to still be set
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

			$mySession = session_id();

//-----    Check if the form has been submitted -------------------------------------------/
	if (isset($_POST['submitted'])) {
		
		//Initialise errors array
		  $errors = array();
		
			//Check for required fields
				 if (empty($_POST['anchorMultipleSelection'])) {
							$errors[] = 'Sorry we\'re missing an anchor entry - please select one of the anchors from the list.';
						 } else {
								 $anchorSelection = htmlspecialchars( strip_tags($_POST['anchorMultipleSelection']) );	
								}
					 // ------------------------------------------------------------------------------------------------------------------------------------------------ //
				
									 if (empty($_POST['oarMultipleSelection'])) {
											$errors[] = 'Sorry we\'re missing an Oar entry - please select one of the oars from the list.';
										 } else {
												 $oarSelection = htmlspecialchars( strip_tags($_POST['oarMultipleSelection']) );	
												}
					 // ------------------------------------------------------------------------------------------------------------------------------------------------ //
				
													 if (empty($_POST['anchorThemeSelect'])) {
															$errors[] = 'Sorry we\'re missing an theme selection - please select one of the Anchor themes from the list.';
														 } else {
																 $anchorThemeSelect = htmlspecialchars( strip_tags($_POST['anchorThemeSelect']) );	
																}
					 // ------------------------------------------------------------------------------------------------------------------------------------------------ //
					
									 if (empty($_POST['oarThemeSelect'])) {
											$errors[] = 'Sorry we\'re missing an theme selectio - please select one of the oar themes from the list.';
										 } else {
												 $oarThemeSelect = htmlspecialchars( strip_tags($_POST['oarThemeSelect']) );	
												}
					 // ------------------------------------------------------------------------------------------------------------------------------------------------ //
					
													if (empty($errors)) {   // No errors so sweet to carry on
																	//Debug section 
																	/*	print 'Anchor selection ' .$anchorSelection;
																		print '<br/>';
																		print 'Oar selection ' .$oarSelection;
																		print '<br/>';
																		print 'Anchor theme selection ' . $anchorThemeSelect;
																		print '<br/>';
																		print 'Oar theme selection ' . $oarThemeSelect;
																		print '<br/>';
																	*/
																		
																		
																		// Do insert into database record                         //					
																		//Connect to the database using the PDO conection method  //
																	
																				try {
																					require('./dbscripts/cultrv8_mysql_PDO_connect.php'); 
																		
																					//Get user_id and first name
																						$dbh = new PDO('mysql:host='. DB_HOST .';dbname=' .DB_NAME, DB_USER, DB_PASSWORD);
																						$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
															
																							$anchors_oars_theme_insert_stmt = $dbh->prepare("INSERT INTO anchors_oars_theme_selection
																																		(
																																			session_id,
																																			selected_anchor,
																																			selected_anchor_theme,
																																			selected_oar,
																																			selected_oar_theme,
																																			time_stamp
																																		)
																																		VALUES
																																		(
																																			:v_session_id ,
																																			:v_selected_anchor,
																																			:v_selected_anchor_theme,
																																			:v_selected_oar,
																																			:v_selected_oar_theme,
																																			NOW()
																																		)");
																																		
																																			$anchors_oars_theme_insert_stmt->bindParam(':v_session_id', $mySession);
																																			$anchors_oars_theme_insert_stmt->bindParam(':v_selected_anchor', $anchorSelection);
																																			$anchors_oars_theme_insert_stmt->bindParam(':v_selected_anchor_theme', $anchorThemeSelect);
																																			$anchors_oars_theme_insert_stmt->bindParam(':v_selected_oar', $oarSelection);
																																			$anchors_oars_theme_insert_stmt->bindParam(':v_selected_oar_theme', $oarThemeSelect);
																																			
																																			// Now run the insert query
																																				$anchors_oars_theme_insert_stmt->execute();
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
																			$url .= '/share_results.php';
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

    <title>Question 3- Anchors & Oars Response</title>
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
										<a class="btn btn-success btn-lg" href="anchors_oars.php">Back <span class="sr-only">(current)</span></a>
									  </li>
									  
									</ul>
								</div>
			</nav>
	<!-- END OF NAV BAR SECTION ---------------------------------------------->
	
	
			
			  <!-- Content here -->
			<div class="container">
			
				<div class="row"><!-- Start of row 1 -->
						
						<div class="col-sm"><!-- Column 1 -->
					
							  <h1 class="mt-4">Love your work! I thought I was deep, but you are waaaay deeper! </h1>
							  <p>So I'm curious, what is the most important anchor to fix, and what is the most important oar to strengthen from your list? And which theme category would you attach these to?</p>
							  
						</div><!-- End of column 1-->
						
						<div class="col-sm"><!-- Column 2 -->
							<div class="text-center">
								<img src="img/Crab_home_big_logo.jpg" class="img-fluid float-right" alt="Cultrv8 Crab Logo">
							</div>
						</div><!-- End of column 2 -->
						  
						  
				</div><!-- end of row --->
					  
					
				<div class="row"><!-- Start of row 2 -->
				
					<div class="col"><!-- Form column -->
							<form action="anchors_oars_response.php" method="post"  id="car_response_selection">
									
									<div class="row"><!-- Row 1 -->
												<div class="col">		   
																<div class="form-group">
																	<label for="anchorMultipleSelect" class="form-control-lg">Select the anchor</label>
																		<select multiple class="form-control" id="anchorMultipleSelect" name="anchorMultipleSelection">
																						<?php	
																							//Connect to the database using the PDO conection method
																								require('./dbscripts/cultrv8_mysql_PDO_connect.php'); 
															
																							//Get the anchor responses from the database
																								$dbh = new PDO('mysql:host='. DB_HOST .';dbname=' .DB_NAME, DB_USER, DB_PASSWORD);
																
																									$PDO_anchorlist_Query = $dbh->prepare("SELECT anchors_response1, anchors_response2, anchors_response3
																																		   FROM anchors_oars_response
																																		   WHERE session_id = '$mySession'");
																										$PDO_anchorlist_Query->execute();
																												$rowset = $PDO_anchorlist_Query->fetchAll(PDO::FETCH_NUM);
																															if ($rowset) {
																																	foreach ($rowset as $row) {
																																	  print '<option value="'.$row[0].'">' .$row[0] . '</option>';
																																	  print '<option value="'.$row[1].'">' .$row[1] . '</option>';
																																	  print '<option value="'.$row[2].'">' .$row[2] . '</option>';
																																	}
																																
																															} else {  //No rowset was returned 
																																print 'Sorry - no anchor words have been found!';
																															}
																									//Release the PDO connection
																									$dbh = null;
																						?>
																		</select>
																</div>
												</div><!-- End of column -->
																					<div class="col">
																						<div class="form-group">
																								<label for="anchorTheme" class="form-control-lg">Select theme category</label>
																								<select class="form-control border-secondary" id="anchorTheme" name="anchorThemeSelect">
																									  <option value="Theme1">Theme 1</option>
																									  <option value="Theme2">Theme 2</option>
																									  <option value="Theme3">Theme 3</option>
																									  <option value="Theme4">Theme 4</option>
																								</select>
																						</div>
																					</div>
									</div><!-- End of row 1 -->
									
									<div class="row"><!-- Row 2 -->
													<div class="col">		   
																<div class="form-group">
																	<label for="oarMultipleSelect" class="form-control-lg">Select the Oar</label>
																		<select multiple class="form-control" id="oarMultipleSelect" name="oarMultipleSelection">
																			 <?php	
																							//Connect to the database using the PDO conection method
																								require('./dbscripts/cultrv8_mysql_PDO_connect.php'); 
															
																							//Get the anchor responses from the database
																								$dbh = new PDO('mysql:host='. DB_HOST .';dbname=' .DB_NAME, DB_USER, DB_PASSWORD);
																
																									$PDO_anchorlist_Query = $dbh->prepare("SELECT oars_response1,oars_response2, oars_response3
																																		   FROM anchors_oars_response
																																		   WHERE session_id = '$mySession'");
																										$PDO_anchorlist_Query->execute();
																												$rowset = $PDO_anchorlist_Query->fetchAll(PDO::FETCH_NUM);
																															if ($rowset) {
																																	foreach ($rowset as $row) {
																																	  print '<option value="'.$row[0].'">' .$row[0] . '</option>';
																																	  print '<option value="'.$row[1].'">' .$row[1] . '</option>';
																																	  print '<option value="'.$row[2].'">' .$row[2] . '</option>';
																																	}
																																
																															} else {  //No rowset was returned 
																																print 'Sorry - no anchor words have been found!';
																															}
																									//Release the PDO connection
																									$dbh = null;
																						?>
																		</select>
																</div>
													</div><!-- End of column -->
									 
													<div class="col">
														<div class="form-group">
																<label for="oarTheme" class="form-control-lg">Select theme category</label>
																<select class="form-control border-primary" id="oarTheme" name="oarThemeSelect">
																	  <option value="Theme1">Theme 1</option>
																	  <option value="Theme2">Theme 2</option>
																	  <option value="Theme3">Theme 3</option>
																	  <option value="Theme4">Theme 4</option>
																</select>
														</div>
													</div>
									</div><!-- End of row 2 -->
									
									
									<!-- <div class="float-right"><a class="btn btn-success btn-lg" href="share_results.php">Next</a></div> -->
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