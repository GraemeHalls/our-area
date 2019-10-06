<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<meta name="viewport" content="width=device-width, initial-scale=1">
<head>
	<title>South Bedfordshire CAMRA | Campaign for Real Ale</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, shrink-to-fit=no"/>
	<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
	<script src="/maps/markerclusterer.js"></script>
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
	<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="../css/style.css" type="text/css" />
	<link media="(max-width: 900px)" href="../css/mobile-style.css" type="text/css" rel="stylesheet" />
    <link rel="icon" type="image/ico" href="../images/ico/sbeds favicon.ico" />
	<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-19926804-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
<script type="text/javascript">
	$(function() {
		$('.show-details-area').click(
			function() {
				if (!$(this).hasClass('panel-collapsed')) {
					$(this).parent('tr').next().fadeIn(100);
					$(this).addClass('panel-collapsed');
					$(this).find('i').removeClass('fa fa-plus').addClass('fa fa-minus');
				} else {
					$(this).parent('tr').next().fadeOut(100);
					$(this).removeClass('panel-collapsed');
					$(this).find('i').removeClass('fa fa-minus').addClass('fa fa-plus');
				}
			}
		);
	});
</script>
<script>

function getQueryVariable(variable)
{
       var query = window.location.search.substring(1);
       var vars = query.split("&");
       for (var i=0;i<vars.length;i++) {
               var pair = vars[i].split("=");
               if(pair[0] == variable){return pair[1];}
       }
       return(false);
}

function initMap() {
var map = new google.maps.Map(document.getElementById('map'), {
    // center: new google.maps.LatLng(51.93916880428746, -0.504345273716126),
    maxZoom: 17
});
var infoWindow = new google.maps.InfoWindow;


var town = getQueryVariable("location");

downloadUrl('../maps/GenerateMarkers.php?type=area&location=' + town, function(data) {

		// Create markers array before the loop.
    var markersArray = new Array()
    var bounds = new google.maps.LatLngBounds();

    var xml = data.responseXML;
    var markers = xml.documentElement.getElementsByTagName('marker');

    Array.prototype.forEach.call(markers, function(markerElem) {
        // var id = markerElem.getAttribute('id');
				var pubid = markerElem.getAttribute('pubid');
        var name = markerElem.getAttribute('name');
        var address = markerElem.getAttribute('address');
				var town = markerElem.getAttribute('town');
				var postcode = markerElem.getAttribute('postcode');
        var type = markerElem.getAttribute('type');
        var point = new google.maps.LatLng(
                parseFloat(markerElem.getAttribute('lat')),
                parseFloat(markerElem.getAttribute('lng')));

        var infowincontent = document.createElement('div');
        var strong = document.createElement('strong');
        strong.textContent = name
        infowincontent.appendChild(strong);
        infowincontent.appendChild(document.createElement('br'));

				var pubpic = document.createElement('img');
				var pubpicpath = "/images/showimage.php?PubID=" + pubid + "&size=50&aspect=4by3";
				pubpic.setAttribute("src", pubpicpath );
				pubpic.setAttribute("style", "float:left; padding-right: 5px");
				// pubpic.setAttribute("style", "border:0.5px");
				infowincontent.appendChild(pubpic);

        var text = document.createElement('text');
        text.textContent = ' ' + address + ', ' + town + ', ' + postcode
        infowincontent.appendChild(text);
        // var icon = customLabel[type] || {};
        var marker = new google.maps.Marker({
            map: map,
            position: point,
            // label: icon.label
        });

				// Add marker listener
        marker.addListener('click', function() {
            infoWindow.setContent(infowincontent);
            infoWindow.open(map, marker);
        });

				// Add given marker to the array..
        markersArray.push(marker);

        // Extend the bounds of the Map..
        bounds.extend(point);

    });

		// Create marker cluster using the array of markers created above.
    var markerClusterer = new MarkerClusterer(map, markersArray, {
			imagePath: '../img/icons/markerclusterer/m',
			gridSize: 25,
			// maxZoom: 17
		});

    // Fit the bounds to the Map
    map.fitBounds(bounds);

    // Define the LatLng coordinates for the polygon's path. These are static, so dont need to be pulled from DB.
    var Area = [
        {lat: 51.9111974504221, lng:-0.700698528012367},
        {lat: 52.0351347507547, lng:-0.643706950863929},
        {lat: 52.018657752549, lng:-0.576415691098304},
        {lat: 52.0389, lng:-0.4951},
        {lat: 52.0258407801943, lng:-0.426726970395179},
        {lat: 52.0359795613826, lng:-0.350509319027992},
        {lat: 51.996039, lng: -0.355821},
        {lat: 51.9860834929546, lng:-0.366786908817971},
        {lat: 51.959586, lng:-0.368592},
        {lat: 51.9607039496942, lng:-0.391506147099221},
        {lat: 51.9426122542336, lng:-0.390132856083596},
        {lat: 51.9115396390844, lng:-0.385371899137112},
        {lat: 51.8756431849685, lng:-0.350498775159167},
        {lat: 51.8739474946844, lng:-0.357193568860338},
        {lat: 51.8613337917255, lng:-0.35015545240526},
        {lat: 51.8368163993317, lng:-0.394237032444834},
        {lat: 51.8547386835508, lng:-0.432860842259287},
        {lat: 51.840104453352, lng:-0.463244905979991},
        {lat: 51.8500732137816, lng:-0.4774928002671},
        {lat: 51.8262, lng:-0.5198},
				{lat: 51.8547, lng:-0.5713},
        {lat: 51.8775924472208, lng:-0.592407560093079},
        {lat: 51.891668332384, lng:-0.630516385776672},
        {lat: 51.8909267401722, lng:-0.642876004917297},
        {lat: 51.9003546441251, lng:-0.651630735141907},
        {lat: 51.9007783236945, lng:-0.675663327915344},
        {lat: 51.9110513299895, lng:-0.700725888950501}
    ];

    //Construct the polygon and set format.
    var AreaOutside = new google.maps.Polygon({
        paths: Area,
        strokeColor: '#000000',
        strokeOpacity: 0.8,
        strokeWeight: 1,
        fillColor: '#ffffff',
        fillOpacity: 0
    });

    AreaOutside.setMap(map);
});

google.maps.event.addDomListener(window, 'load', initMap);

}


// Function for the retrieving of the markers using XML.
function downloadUrl(url, callback) {
var request = window.ActiveXObject ?
        new ActiveXObject('Microsoft.XMLHTTP') :
        new XMLHttpRequest;

request.onreadystatechange = function() {
    if (request.readyState == 4) {
        request.onreadystatechange = doNothing;
        callback(request, request.status);
    }
};



request.open('GET', url, true);
request.send(null);
}

function doNothing() {}


</script>
<script async defer
src="//maps.googleapis.com/maps/api/js?key=xx&callback=initMap&sensor=true">
</script>

 <script type="text/javascript">
	 $(document).ready(function (){
		 $("#town").change(function() {
				 $("#pubname").show();
				 $("#pubname-other").hide();
				 //console.log($("#town").val());
				 var url = encodeURIComponent($("#town").val());
				 $("#pubname").load("towngetter.php?town=" + url);
				 //$("#txt_in").val(url);
		 });
	 });
 </script>
</head>

<body>
	<div id="container">
		<div id="header">
			<?php include("../includes/header.html"); ?>
		</div>
		<div id="menu">
			<?php include("../includes/menu.html"); ?>
		</div>
		<div id="content" class="cushycms">
			<h2>Our Area</h2>
			<p>There are three CAMRA branches in Bedfordshire - North Beds, East Beds and South Beds. The South Beds branch area covers most of South Bedfordshire, delimited by the county boundary, the A600 in the east and Leighton Buzzard/Linslade in the west and including Aspley Guise, Ridgmont, Ampthill, Maulden and Campton in the north. Our Branch includes the larger towns of Luton, Dunstable, Leighton Buzzard and Houghton Regis, as well as many other smaller towns and villages.</p>
			<p>The websites for two adjoining Bedfordshire branches, North Bedfordshire & East Bedfordshire can be found here:</p>
			<p><a href="https://northbeds.camra.org.uk/" target="_blank">North Bedfordshire CAMRA </a>
			<p><a href="https://eastbeds.camra.org.uk/" target="_blank">East Bedfordshire CAMRA </a>
			<p>
		 	<div id="map"></div>
			<br />
			<p>We have over 170 pubs in our Region that serve Real-Ale, you can find a list of these below. Simply click on the pub image to find out more about the Pub on WhatPub. Alternatively, using the Google Map below, you can easily view where all our Real Ale Pubs are. <p>
			<p>
			<p>Alternatively, you can find your local Pub by selecting the town from this drop-down:</p>
			<form action='<?php echo $_SERVER['PHP_SELF'] . '?' . $_GET['location']; ?>' method='get' name='form_filter' >
					<select id='town' name='location' class='townselect'>
						<option selected='selected'>Please Select</option>
								<?php
								// get DB connection information..
								require_once($_SERVER["DOCUMENT_ROOT"] . '../../../Inc/config.inc.php');

								$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);
								// Check connection
								if (mysqli_connect_errno())
								{echo "Failed to connect to MySQL: " . mysqli_connect_error();}

								$towns = mysqli_query($conn,"SELECT Town FROM pubdatabase WHERE RealAle = 'yes' AND PremisesStatus = 'O' GROUP BY Town;");
								while ($row = mysqli_fetch_array($towns)) {
										echo "<option>" . $row['Town'] . "</option>";
								$town = $row['Town'];
								}

							echo "</select>";
							echo "<p>";
							echo "<p>";
							echo "<p>";
							echo "<input type='submit' value = 'Update' onclick=\"ga('send', 'event', 'AreaUpdate', 'UpdateList');\">";
					?>
			</form>
			<p>
			<p>
			<?php
			// Queries the location provided in Query string, and then pulls the relevant pubs from the DB..
				if($_SERVER['REQUEST_METHOD'] == "GET"){
					$choice = htmlspecialchars(html_entity_decode(mysqli_real_escape_string($conn, $_GET['location'])));
					if($_GET['location'] <> "all") {
						$sql = "SELECT pd.PubID, pd.Name, pd.Town, pd.Street, pd.Postcode, pu.PhotoID, pd.SurveyDate, pd.RealAle, pd.Description, pd.Longitude, pd.Latitude FROM pubdatabase pd LEFT JOIN photodatabase pu ON pd.PubID = pu.PubID WHERE pd.RealAle = 'yes' AND pd.Town='$choice' AND pd.PremisesStatus = 'O' GROUP BY pd.PubID ORDER BY Town";
					}
					elseif ($choice == "all"){
						$sql = "SELECT pd.PubID, pd.Name, pd.Town, pd.Street, pd.Postcode, pu.PhotoID, pd.SurveyDate, pd.RealAle, pd.Description, pd.Longitude, pd.Latitude FROM pubdatabase pd LEFT JOIN photodatabase pu ON pd.PubID = pu.PubID WHERE pd.RealAle = 'yes' AND pd.PremisesStatus = 'O' GROUP BY pd.PubID ORDER BY Town";
						echo "<p>Currently viewing all Pubs";
					}
				}
				else {
					$sql = "SELECT pd.PubID, pd.Name, pd.Town, pd.Street, pd.Postcode, pu.PhotoID, pd.SurveyDate, pd.RealAle, pd.Description, pd.Longitude, pd.Latitude FROM pubdatabase pd LEFT JOIN photodatabase pu ON pd.PubID = pu.PubID WHERE pd.RealAle = 'yes' AND pd.PremisesStatus = 'O' GROUP BY pd.PubID ORDER BY Town";
						echo "<p>Currently viewing all Pubs";
				}

					$result = mysqli_query($conn,$sql);
					$count = mysqli_num_rows($result);

					// Echo pub list on the page
					echo "<table class='table table-bordered table-sm ourarea'>";
					echo "<thead>";
					echo "<tr class='arearow'>";
					echo "<th class='pubarealeft'></th>";
					echo "<th>Pub Photo</th>";
					echo "<th>Name</th>";
					echo "<th>Address</th>";
					echo "<th>Town</th>";
					echo "<th class='maplink'>Google Maps Link</th>";
					echo "</tr>";
					echo "</thead>";

					echo "<tbody class='searchable'>";
					$prev_month = 0;
					// Echo pub information from DB one at a time..
					while($row = mysqli_fetch_array($result))
					{
							$pubid = $row['PubID'];
							$photoid = $row['PhotoID'];
							$long = $row['Longitude'];
							$lat = $row['Latitude'];
							$maplink = "//www.google.co.uk/maps/place/" . $lat . "," . $long;
							echo "<td class='arealeft'></td>";
							echo "<td class='show-details-area' onclick=\"ga('send', 'event', 'PubDescription', 'Show', '$pubid', 0);\"><i class='fa fa-plus' aria-hidden='true'></i></td>";
							echo "<td><a href='//whatpub.com/pubs/$pubid' target='_blank'><img class='pubpic' src='/images/showimage.php?PubID=$pubid&size=120&aspect=4by3'></a></td>";
							echo "<td>" . $row['Name'] . "</td>";
							echo "<td>" . $row['Street'] . ", " . $row['Postcode'] . "</td>";
							echo "<td>" . $row['Town'] . "</td>";
							echo "<td class='maplink'><a href='$maplink' target='_blank'><i class='far fa-map' aria-hidden='true'></i></td>";
							echo "</tr>";
							echo "<tr class='hideRow'>";
							$strreplace = array("&quot", "[", "]", ";");
							echo "<td colspan='6'>" . str_replace($strreplace,"", $row['Description']) . "</td>";
							echo "</tr>";
					}
					echo "</tbody>";
					echo "</table>";

					if ($count > 1)
					{echo "<p>Currently viewing all $count Pubs in <strong><i name='viewtown'>$choice</i></strong>. Click <a href=" . $_SERVER['PHP_SELF'] . "?" . "location=all> here </a> to reset. ";}
					else
					{echo "<p>Currently viewing $count Pub in <strong><i name='viewtown'>$choice</i></strong>. Click <a href=" . $_SERVER['PHP_SELF'] . "?" . "location=all> here </a> to reset. ";}

					mysqli_close($conn);
					?>
		</div>
		<div id="right">
			<?php include("../includes/right.html"); ?>
		</div>
		<div style="clear:both;"></div>
		<div id="footer"><?php include("../includes/footer.html"); ?> </div>
	</div>
</body>
</html>
