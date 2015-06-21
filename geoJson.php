<?php 
require 'lib/ShapeFile.inc.php';
$shp = new ShapeFile("packages/Zillow/ZillowNeighborhoods-IL/ZillowNeighborhoods-IL.shp", array('noparts' => false));
$i=0;
while ($record = $shp->getNext()) {
	$dbf_data = $record->getDbfData();
	$out = fopen ("out/geoJSON/".trim($dbf_data["STATE"])."/".trim($dbf_data["REGIONID"]).".geoJSON", "w");
	$shp_data = $record->getShpData();
 	if(! isset($shp_data['parts'] )) { 
 		continue;
 	}
 	$data[] = $shp_data['numpoints'];
 	$parts = array();
	$x = [];
	foreach ($shp_data['parts'] as $part) {
	 	$x['type'] = "MultiPolygon";
	 	$x['coordinates'] = [];
	 	$y = [];
		foreach ($part['points'] as $pt) { 
			$y[] = [floatval(trim($pt['x'])) , floatval(trim($pt['y']))];
		}
		$x['coordinates'][0] = [$y];
	}
	$data = $x;
	fputs($out, json_encode($data));
	$i++;
	fclose($out);
}
echo $i;