# Clean Eats

Clean Eats displays the top 10 restaurants based on the score of their last inspection. You can choose the type of cuisine and grades for the search, and clicking on each result will show the location on an embedded google map.

## Data Loading

Data is taken from the [DOHMH New York City Restaurant Inspection Results](https://nycopendata.socrata.com/api/views/xx67-kt59/rows.csv?accessType=DOWNLOAD) available on NYC Open Data.

The python script to load in the data is in the ETL directory and can be called with a corresponding MySQL database as follows:

`python load_restaurant_health_ratings.py host user passwd db table csvfile mapfile`

This script takes columns in the mapping file and maps them to columns in the database. The mapping file also includes the data type, used for handling data formats in the python loader.

## Data Viewing

The database connection is set up in db_connect.php and the queries executed on the initial page load are in db_initial_load.php. The file restaurant_search.php is then used for subsequent AJAX calls.