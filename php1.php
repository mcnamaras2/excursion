<?php
$Url=$_POST['web'];


$html = file_get_contents($Url); //get the html returned from the spotify share url

$music_doc = new DOMDocument(); //creates a new document to place scraped data into

libxml_use_internal_errors(TRUE); //disable libxml errors

if(!empty($html)){ //check if any html is actually returned

	$music_doc->loadHTML($html);
	libxml_clear_errors(); //remove errors for unusable html
	
	$music_xpath = new DOMXPath($music_doc);//creates new DOM path to search through
	//get all the title tags from HTML doc
	$music_row = $music_xpath->query('//title');

	// store all pulled title tags and echo back
	if($music_row->length > 0){
		foreach($music_row as $row){
			echo $row->nodeValue . "<br/>";
                          $text=$row->textContent;
		}
	}
}

$servername = 'uplifted-triode-168417:us-central:test';
$username = "test";
$password = "password";
$dbname = "test";

$conn = new mysqli($servername, $username, $password,$dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
echo "Connected successfully";

$sql = "INSERT INTO SpotifyInfo (Spotify1, Spotify2)
VALUES ('$Url', '$text')";

if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

?>