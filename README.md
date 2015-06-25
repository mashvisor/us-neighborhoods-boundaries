
1. Extracting "Zillow Neighborhoods" shapefiles folders
========================================================


First of all, you need to download the shape files for the states from:
<a href="http://www.zillow.com/howto/api/neighborhood-boundaries.htm">http://www.zillow.com/howto/api/
neighborhood-boundaries.htm</a>


Then, in "Packages/Zillo" folder you need to extract and put extracted "ZillowNeighborhoods-XX" folder here for each state,
where XX refers to the 2 chars represents the state name.


2. Exporting the CSV files
==========================


For each state, you need to edit the CSV.php file to change the 2 chars "XX" represents the state name in lines 4 and 5
for $shp and $out variables to the state you want to export its CSV file just like this:


```
$shp = new ShapeFile("packages/Zillow/ZillowNeighborhoods-XX/ZillowNeighborhoods-XX.shp", array('noparts' => false));
$out = fopen ("out/csv/XX-Regions.csv", "w");
```


And then, you can run the csv.php file via the command line for each state.


However, the exported file will be in "out/csv" folder with a name : "XX-Regions.csv"

```
php csv.php 
```

Finally, the CSV file have the format as following:



Where points are a combination of x-coordinate;y-coordinate,x-coordinate;y-coordinate,.. multiple-polygons are separated by '::'
    

Here's a sample of the resulted CSV file for IL state:
```
state county      city        Neighborhood    regionid   total_potins      coordinates
IL	Cook	      Chicago	Chatham	    273222	    218	         -87.597208915594;41.751072022231,-87.597240915594;41.75086402223
```

3. Exporting the GeoJSON files
===============================


For each state, you need to edit the geoJson.php file to change the 2 chars "XX" represents the state name in lines 3
for the $shp variables to the state you want to export its GeoJSON file just like this:


```
$shp = new ShapeFile("packages/Zillow/ZillowNeighborhoods-XX/ZillowNeighborhoods-XX.shp", array('noparts' => false));
```


And then, you can run the geoJson.php file via the command line for each state. However, this will create a GeoJSON file
for each neighborhood in XX state in "out/geoJSON/XX" folder, also, the file name will be the region ID.GeoJSON.

```
php geoJson.php
```

Finally, the GeoJson file have the format as following:


```
{ "type": "MultiPolygon",
    "coordinates": [
      [[[x-coordinate, y-coordinate], [x-coordinate, y-coordinate], [x-coordinate, y-coordinate]]]
      ]
}
```

Where: x-coordinate represents the longitude
       y-coordinate represents the latitude


Here's a sample of the resulted GeoJSON file named as 137304.GeoJSON for IL state:
```
{ "type":"MultiPolygon",
    "coordinates":[
      [[[-87.785746915769,41.916325022384],[-87.785118915769,41.916314022384]]]
      ]
}
```

4. License 
===============================


this repository code/content is licensed under a Creative Commons Attribution 1.0 Universal license.

5. Contributers 
===============================  

- Ahmad Hashlamoun <ahamd.hashlamoun@gmail.com>
- Mohammed Jebrini <mohd@mashvisor.com>
