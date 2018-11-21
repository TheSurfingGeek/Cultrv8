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
							  
								  <h2>Car selected: </h2>
										<h3><div class="alert alert-success" role="alert">
												<?php echo $carSelectedName; ?>
										</div></h3>
								  
								  <h2>Car association results: </h2>
						
							<table class="table-sm table-bordered">
								  <thead>
									<tr>
									  <th scope="col">Associated word</th>
									  <th scope="col">Agree/Disagree</th>
									  <th scope="col">Alternative word</th>
									</tr>
								  </thead>
								  <tbody>
									
											<?php
													//------   Get car name from the selected id ----------------------------------------------/
															require('./dbscripts/cultrv8_mysql_PDO_connect.php'); 
															
																//Get user_id and first name
																	$dbh = new PDO('mysql:host='. DB_HOST .';dbname=' .DB_NAME, DB_USER, DB_PASSWORD);
																
																			$car_response_select = $dbh->prepare("
																				SELECT 	
																						car_word_response_id,
																						session_id,
																						car_id,
																						response_word1, 
																						word1_response, 
																						response1_alternative,
																						response_word2,
																						word2_response,
																						response2_alternative,
																						response_word3,
																						word3_response,
																						response3_alternative,
																						response_word4,
																						word4_response,
																						response4_alternative,
																						response_word5,
																						word5_response,
																						response5_alternative
																						FROM car_response_word_association_response
																						WHERE session_id = '$mySession';
																			
																			");
																			$car_response_select->execute();
																		
																				// Fetch all the rows in the result set
																					$rowset = $car_response_select->fetchAll(PDO::FETCH_NUM);
																						if ($rowset) { // A record was successfully retrieved
																									foreach ($rowset as $row) {
																											//Loop through the results and create the radio button list
																													print '
																														<tr>
																														  <td>'.$row[3].'</th>
																														  <td>'.$row[4].'</td>
																														  <td>'.$row[5].'</td>
																														</tr>
																														<tr>
																														  <td>'.$row[6].'</td>
																														  <td>'.$row[7].'</td>
																														  <td>'.$row[8].'</td>
																														</tr> 
																														<tr>
																														  <td>'.$row[9].'</td>
																														  <td>'.$row[10].'</td>
																														  <td>'.$row[11].'</td>
																														</tr>
																														<tr>	
																														  <td>'.$row[12].'</td>
																														  <td>'.$row[13].'</td>
																														  <td>'.$row[14].'</td>
																														</tr>
																														<tr>
																														  <td>'.$row[15].'</td>
																														  <td>'.$row[16].'</td>
																														  <td>'.$row[17].'</td>
																														</tr>
																							 							';
																									}
																						} else {
																							$carSelectedName ='Nothing was found';
																						}
																					
																				//Release the PDO connection
																					$dbh = null;	

													//------    End of car name selection -----------------------------------------------------/
											?>
										</tbody>
						</table>
								  
							  
						</div><!-- End of column 1-->
						
						<div class="col-sm"><!-- Column 2 -->
							<div class="text-center">
								<img src="img/Crab_home_big_logo.jpg" class="img-fluid float-right" alt="Cultrv8 Crab Logo">
							</div>
						</div><!-- End of column 2 -->
						    
				</div><!-- end of row 1 --->
				
				<div class="row"><!-- Start of row 2 -->
					<div class="col"><!-- Start of column 1 -->
					
						<h2>Anchors & Oars Responses: </h2>
						
						<table class="table-sm table-bordered">
								  <thead>
									<tr>
									  <th scope="col">Anchor Response 1</th>
									  <th scope="col">Anchor Response 2</th>
									  <th scope="col">Anchor Response 3</th>
									  <th scope="col">Oars Response 1</th>
									  <th scope="col">Oars Response 2</th>
									  <th scope="col">Oars Response 3</th>
									</tr>
								  </thead>
								  <tbody>
									<tr>
						
																<?php
																							//------   Get car name from the selected id ----------------------------------------------/
																									require('./dbscripts/cultrv8_mysql_PDO_connect.php'); 
																									
																										//Get user_id and first name
																											$dbh = new PDO('mysql:host='. DB_HOST .';dbname=' .DB_NAME, DB_USER, DB_PASSWORD);
																										
																													$anchor_oar_responses_select = $dbh->prepare("
																														SELECT 
																															anchors_response1, 
																															anchors_response2, 
																															anchors_response3,
																															oars_response1,
																															oars_response2, 
																															oars_response3
																															FROM anchors_oars_response
																															WHERE session_id = '$mySession';
																													");
																													$anchor_oar_responses_select->execute();
																												
																														// Fetch all the rows in the result set
																															$rowset = $anchor_oar_responses_select->fetchAll(PDO::FETCH_NUM);
																																if ($rowset) { // A record was successfully retrieved
																																			foreach ($rowset as $row) {
																																					//Loop through the results and create the radio button list
																																							print '
																																								<tr>
																																								  <td>'.$row[0].'</th>
																																								  <td>'.$row[1].'</td>
																																								  <td>'.$row[2].'</td>
																																								  <td>'.$row[3].'</td>
																																								  <td>'.$row[4].'</td>
																																								  <td>'.$row[5].'</td>
																																								</tr>
																																								';
																																			}
																																} else {
																																	$carSelectedName ='Nothing was found';
																																}
																															
																														//Release the PDO connection
																															$dbh = null;	

																							//------    End of car name selection -----------------------------------------------------/
																					?>
										</tbody>
						</table>
						
						
				 
					</div><!-- End of column 1-->
					
				</div><!-- End of row 2 -->
					  
					
				<div class="row"><!-- Start of row 3 -->
				
					<div class="col"><!-- Start of column 1 -->
						<h2>Anchors & Oars Association Responses: </h2>
						
						<table class="table-sm table-bordered">
								  <thead>
									<tr>
									  <th scope="col">Selected Anchor</th>
									  <th scope="col">Selected Anchor Theme</th>
									  <th scope="col">Selected Oar</th>
									  <th scope="col">Selected Oar Theme</th>
									</tr>
								  </thead>
								  <tbody>
									<tr>
						
																<?php
																							//------   Get car name from the selected id ----------------------------------------------/
																									require('./dbscripts/cultrv8_mysql_PDO_connect.php'); 
																									
																										//Get user_id and first name
																											$dbh = new PDO('mysql:host='. DB_HOST .';dbname=' .DB_NAME, DB_USER, DB_PASSWORD);
																										
																													$anchor_oar_response_select = $dbh->prepare("
																														SELECT 
																															selected_anchor,
																															selected_anchor_theme,
																															selected_oar,
																															selected_oar_theme 
																															FROM anchors_oars_theme_selection
																															WHERE session_id = '$mySession';
																													");
																													$anchor_oar_response_select->execute();
																												
																														// Fetch all the rows in the result set
																															$rowset = $anchor_oar_response_select->fetchAll(PDO::FETCH_NUM);
																																if ($rowset) { // A record was successfully retrieved
																																			foreach ($rowset as $row) {
																																					//Loop through the results and create the radio button list
																																							print '
																																								<tr>
																																								  <td>'.$row[0].'</th>
																																								  <td>'.$row[1].'</td>
																																								  <td>'.$row[2].'</td>
																																								  <td>'.$row[3].'</td>
																																								</tr>
																																								';
																																			}
																																} else {
																																	$carSelectedName ='Nothing was found';
																																}
																															
																														//Release the PDO connection
																															$dbh = null;	

																							//------    End of car name selection -----------------------------------------------------/
																					?>
										</tbody>
						</table>
					</div> <!-- end of column 1 -->
				
					<div class="col"><!-- Start of column 2 -->
						<a class="btn btn-success btn-lg" href="join_movement.php">Next</a>
					</div>
						
				</div><!-- end of row 3 -->
				
			</div><!-- End of the container -->
			
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
  </body>
</html>