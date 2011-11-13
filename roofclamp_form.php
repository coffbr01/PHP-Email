<?php
// Configuration: Modify these variables

$thankyou_url = "thankyou.html";
$to = "philj21@yahoo.com, jason@snobar.com, dorian@snobar.com, lisa@snobar.com";
$subject = "RoofClamp SNOBAR System Form";                                                    

// End Configuration                              

$body = "The following info has been received:
-------------------------------------
Contact Name: " . $_POST['name'] . "
Company:      " . $_POST['company'] . "
Company Address:      " . $_POST['address'] . "
City:      " . $_POST['city'] . "
State:      " . $_POST['state'] . "
Zip:      " . $_POST['zip'] . "
Phone:      " . $_POST['areacode'] . " " . $_POST['phone1'] . " " . $_POST['phone2'] . "
Fax:  " . $_POST['faxareacode'] ."  " . $_POST['fax1'] ."  " . $_POST['fax2']."
Email:      " . $_POST['email'] . "
Contact Type:      " . $_POST['contacttype'] . "
Project Name:      " . $_POST['project'] . "
Project Location
City:      " . $_POST['city2'] . "
State:      " . $_POST['state2'] . "
Zip:      " . $_POST['zip2'] . "
County:      " . $_POST['county2'] . "
Comments:      " . $_POST['comments1'] . "
Manufacturer of Metal Roof Systems:      " . $_POST['roofmanufacturer'] . "
Panel Seam Type:      " . $_POST['panelseam'] . "
Roof Clamp:      " . $_POST['rc'] . "  " . $_POST['rct'] . "
Seams O.C.:      " . $_POST['panelwidth'] . "
Seam Height:      " . $_POST['seamheight'] . "
Gauge:      " . $_POST['gauge'] . "
Finish:      " . $_POST['noncorosive'] . "  " . $_POST['colorbar'] . "  " . $_POST['painted'] . "  " . $_POST['stainless'] . "
If Colorbar is selected:      " . $_POST['colorbarquote'] . "
Quote Optional Ice Stoppers:      " . $_POST['yes'] . "  " . $_POST['no'] . "
Color of Roof System:      " . $_POST['color'] . "
Project Ground Snow Load:      " . $_POST['snowload'] . "
Is This Placed in Isolated Areas:      " . $_POST['yes2'] . "  " . $_POST['no2'] . "
Area 1 	Pitch: " . $_POST['slope1'] . "
			Length: " . $_POST['length1'] . "
			LF: " . $_POST['linealfeet1'] . "
Area 2 	Pitch: " . $_POST['slope2'] . "
			Length: " . $_POST['length2'] . "
			LF: " . $_POST['linealfeet2'] . "
Area 3 	Pitch: " . $_POST['slope3'] . "
			Length: " . $_POST['length3'] . "
			LF: " . $_POST['linealfeet3'] . "
Area 4 	Pitch: " . $_POST['slope4'] . "
			Length: " . $_POST['length4'] . "
			LF: " . $_POST['linealfeet4'] . "
Area 5 	Pitch: " . $_POST['slope5'] . "
			Length: " . $_POST['length5'] . "
			LF: " . $_POST['linealfeet5'] . "
Area 6 	Pitch: " . $_POST['slope6'] . "
			Length: " . $_POST['length6'] . "
			LF: " . $_POST['linealfeet6'] . "
Area 7 	Pitch: " . $_POST['slope7'] . "
			Length: " . $_POST['length7'] . "
			LF: " . $_POST['linealfeet7'] . "
Area 8 	Pitch: " . $_POST['slope8'] . "
			Length: " . $_POST['length8'] . "
			LF: " . $_POST['linealfeet8'] . "
I Have Read the Design Considerations:      " . $_POST['agree'] . "\n";

$from = "From: " . $_POST['email'];

if (eregi("^From: .+$",$from)) {
	mail($to,$subject,$body,$from); 
}                      
header("HTTP/1.1 302 Found");
header ("Location: $thankyou_url");
exit;
?>