<?php 
require 'lib/ShapeFile.inc.php';

$shp = new ShapeFile("packages/Zillow/ZillowNeighborhoods-WI/ZillowNeighborhoods-WI.shp", array('noparts' => false));
$out = fopen ("out/csv/WI-Regions.csv", "w");
$i=0;
while ($record = $shp->getNext()) {
	

	$dbf_data = $record->getDbfData();
	 
	$data = array();
	$data[] = trim($dbf_data["STATE"]);
	$data[] = trim($dbf_data["COUNTY"]);
	$data[] = trim($dbf_data["CITY"]);
	$data[] = trim($dbf_data["NAME"]);
	$data[] = trim($dbf_data["REGIONID"]);

	$shp_data = $record->getShpData();
 
 	if(! isset($shp_data['parts'] )) { 
 		continue;
 	}

 	$data[] = $shp_data['numpoints'];

 	$parts = array();
	foreach ($shp_data['parts'] as $part) {
		$coords = array();
		foreach ($part['points'] as $pt) { 
			$coords[] = trim($pt['x']) . ';' . trim($pt['y']);
		}
		$santisize = str_replace(array(" ","\t","\n") , "" ,implode(',', $coords) );
		$parts[] = $santisize;
	}

	$data[] = implode("::", $parts);

	fputs($out, implode("\t", $data) . "\n");
	$i++;
}
fclose($out);
echo $i;