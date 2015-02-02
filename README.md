# Clean Eats

Clean Eats displays the top 10 restaurants based on the score of their last inspection. You can choose the type of cuisine and grades for the search, and clicking on each result will show the location on an embedded google map.

The hosted site can be seen [here](http://mikehirth.com/cleaneats)

## Data Loading

Data is taken from the [DOHMH New York City Restaurant Inspection Results](https://nycopendata.socrata.com/api/views/xx67-kt59/rows.csv?accessType=DOWNLOAD) available on NYC Open Data.

The python script to load in the data is in the ETL directory and can be called with a corresponding MySQL database as follows:

`python load_restaurant_health_ratings.py host user passwd db table csvfile mapfile loadtype`

The host, user, password, db and table are all for the MySQL database. The csvfile and mapfile are the file names for the health inspection data file and the mapping file. The loadtype should be 'remote' if the csvfile is a URL or 'local' if it's a local file. This script takes columns in the mapping file and maps them to columns in the database and then loads the data. The mapping file also includes the data type, used for handling data formats in the python loader.

## Data Fetching

The database connection is set up in db_connect.php and the queries executed on the initial page load are in db_initial_load.php. The file restaurant_search.php is then used for subsequent AJAX calls.