<?
  //get all cuisines in db
  $cuisines_query = $db->query('select distinct cuisine_description 
                                from restaurant_health_rating 
                                where cuisine_description is not null 
                                order by cuisine_description asc');
  $cuisines = $cuisines_query->fetchAll(PDO::FETCH_OBJ);
  //get all grades in db
  $grades_query = $db->query('select distinct grade 
                              from restaurant_health_rating 
                              where grade is not null 
                              order by grade asc');
  $grades = $grades_query->fetchAll(PDO::FETCH_OBJ);
  //group ratings by restaurant and take the most recent inspection score
  $ratings_query = $db->query('select dba, building, street, cuisine_description, score, grade 
                                from restaurant_health_rating where (grade = "A" or grade = "B") 
                                and cuisine_description = "Thai" 
                                group by dba, building, street, cuisine_description, score, grade 
                                having max(inspection_date) 
                                order by grade, score asc 
                                limit 10');
  $ratings = $ratings_query->fetchAll(PDO::FETCH_OBJ);
?>