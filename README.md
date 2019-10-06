# our-area
Our Area Page - Using Google Maps Clusterer

An example page that retrieves Pub locations from a MySQL Database, and shows them in a list and also creates a Cluster Map using Google Maps. Maps Clustering shows maps with a large amount of pins in a clean way. More information can be found here:

https://developers.google.com/maps/documentation/javascript/marker-clustering

The processing of the actual Map Pins is done by a separate PHP page - GenerateMarkers.php and then passed back to JavaScript by way of an XML feed. 

Updating of the pub list via the provided dropdown list updates the Map with the pubs in that location. Clicking of the "+" button gives you the information about that pub as retrieved from the database.

Upon clicking of the Pins on the map, the Pub Name, address and photo is displayed by Google. The area covered is also shown by a polygon.
