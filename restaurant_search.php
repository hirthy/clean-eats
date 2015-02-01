<?
  include 'db_connect.php';

  $cuisine = $_REQUEST["cuisine"];
  $grades = $_REQUEST["grades"];
  $grade_string = implode(",",$grades);
  //use find_in_set which works for small comma delimited strings, otherwise would have defined a MySQL function
  $ratings_query = $db->prepare('select dba, building, street, cuisine_description, score, grade 
                                  from restaurant_health_rating where find_in_set(grade, :grades) 
                                  and cuisine_description = :cuisine 
                                  group by dba, building, street, cuisine_description, score, grade 
                                  having max(inspection_date) 
                                  order by grade, score asc 
                                  limit 10');

  $ratings_query->execute(array(':cuisine' => $cuisine, ':grades' => $grade_string));
  $ratings = $ratings_query->fetchAll(PDO::FETCH_OBJ);

  exit(json_encode($ratings));
?>