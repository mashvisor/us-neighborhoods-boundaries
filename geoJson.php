<?php 
require 'lib/ShapeFile.inc.php';
$shp = new ShapeFile("packages/Zillow/ZillowNeighborhoods-WI/ZillowNeighborhoods-WI.shp", array('noparts' => false));
$i = 0;
while ($record = $shp->getNext()) {
	$j = 0;
	$dbf_data = $record->getDbfData();
	$out = fopen ("out/geoJSON/".trim($dbf_data["STATE"])."/".trim($dbf_data["REGIONID"]).".geoJSON", "w");
	$shp_data = $record->getShpData();
 	if(! isset($shp_data['parts'] )) { 
 		continue;
 	}
 	$data[] = $shp_data['numpoints'];
 	$parts = array();
	$object = [];
	$object['type'] = "FeatureCollection";
	$object['features'] = [];
	foreach ($shp_data['parts'] as $part) {
		$object['features'][$j] = [];
		$object['features'][$j]['type'] = 'Feature';
		$object['features'][$j]['properties'] = [];
		$object['features'][$j]['properties']['STATE'] = trim($dbf_data["STATE"]);
		$object['features'][$j]['properties']['COUNTY'] = trim($dbf_data["COUNTY"]);
		$object['features'][$j]['properties']['CITY'] = trim($dbf_data["CITY"]);
		$object['features'][$j]['properties']['NAME'] = trim($dbf_data["NAME"]);
		$object['features'][$j]['properties']['REGIONID'] = trim($dbf_data["REGIONID"]);
		$object['features'][$j]['geometry'] = [];
		$x = [];
	 	$x['type'] = "Polygon";
	 	$x['coordinates'] = [];
	 	$y = [];
		foreach ($part['points'] as $pt) { 
			$y[] = [floatval(trim($pt['x'])) , floatval(trim($pt['y']))];
		}
		$x['coordinates'] = [$y];
		$object['features'][$j]['geometry'] = $x;
		$j++;
	}
	$data = $object;
	fputs($out, json_encode($data));
	$i++;
	fclose($out);
} 