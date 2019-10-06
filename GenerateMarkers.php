<?php
require_once($_SERVER["DOCUMENT_ROOT"] . '../../../Inc/config.inc.php');

$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
// Check connection
if (mysqli_connect_errno())
{echo "Failed to connect to MySQL: " . mysqli_connect_error();}

function parseToXML($htmlStr)
{
$xmlStr=str_replace('<','&lt;',$htmlStr);
$xmlStr=str_replace('>','&gt;',$xmlStr);
$xmlStr=str_replace('"','&quot;',$xmlStr);
$xmlStr=str_replace("'",'&#39;',$xmlStr);
//$xmlStr=str_replace("&",'&amp;',$xmlStr);
return $xmlStr;
}

$choice = htmlspecialchars(html_entity_decode(mysqli_real_escape_string($conn, $_GET['type'])));

$town = htmlspecialchars(html_entity_decode(mysqli_real_escape_string($conn, $_GET['location'])));
if ($choice == "locale")
{$result = mysqli_query($conn,"SELECT PubID, Name, Street, Town, Postcode, RealAle, Longitude, Latitude, Town FROM pubdatabase WHERE RealAle = 'yes' AND PremisesStatus = 'O' AND LocAle = 'Yes' ORDER BY Town");}
else if ($choice == "area" && $town == "all")
{$result = mysqli_query($conn,"SELECT PubID, Name, Street, Town, Postcode, RealAle, Longitude, Latitude, Town FROM pubdatabase WHERE RealAle = 'yes' AND PremisesStatus = 'O' ORDER BY Town");}
elseif ($choice == "area" && $town <> "all")
{$result = mysqli_query($conn,"SELECT PubID, Name, Street, Town, Postcode, RealAle, Longitude, Latitude FROM pubdatabase WHERE RealAle = 'yes' AND PremisesStatus = 'O' AND Town='" . $town . "'");}

// Select all the rows in the markers table
if (!$result) {
  die('Invalid query: ' . mysqli_error());
}

header("Content-type: text/xml");

// Start XML file
echo "<?xml version='1.0' ?>";
echo '<markers>';
$ind=0;
// Iterate through the rows, printing XML nodes for each
while ($row = @mysqli_fetch_assoc($result)){
  // Add to XML document node
  echo '<marker ';
  echo 'pubid="' . parseToXML($row['PubID']) . '" ';
  echo 'name="' . parseToXML($row['Name']) . '" ';
  echo 'address="' . parseToXML($row['Street']) . '" ';
  echo 'town="' . parseToXML($row['Town']) . '" ';
  echo 'postcode="' . parseToXML($row['Postcode']) . '" ';
  echo 'lat="' . $row['Latitude'] . '" ';
  echo 'lng="' . $row['Longitude'] . '" ';
  echo 'type="' . $row['type'] . '" ';
  echo '/>';
  $ind = $ind + 1;
}

// End XML file
echo '</markers>';

?>
