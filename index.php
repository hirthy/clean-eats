<!DOCTYPE html>
<? include 'db_connect.php' ?>
<? include 'db_initial_load.php' ?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Clean Eats</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
  </head>
  <body>
    <div class="container">
      <div class="row">
        <div class="col-md-8">
          <h1>Clean Eats</h1><h4>Search New York City Restaurants by Cuisine and Health Rating</h4>
        </div>
      </div>
      <div class="row">
        <div class="col-md-2">
          <div class="dropdown">
            <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
              Cuisine: Thai
              <span class="caret"></span>
            </button>
            <ul class="dropdown-menu scrollable-menu" role="menu" aria-labelledby="dropdownMenu1">
              <? foreach ($cuisines as $cuisine) { ?>
                <li role="presentation"><a role="menuitem" class="cuisine" tabindex="-1" href="#"><?= $cuisine->cuisine_description ?></a></li>
              <? } ?>
            </ul>
          </div>
          <input type="hidden" id="cuisine-input" name="cuisine" value="Thai">
        </div>
        <div class="col-md-10">
          <div id="grade-panel" class="panel panel-default">
            <div class="panel-body">
              <div id="grades">
                Recent Health Grade:
                <? foreach ($grades as $grade) { ?>
                  <? if($grade->grade == "A" or $grade->grade == "B") { ?>
                    <label class="grade-label"><input type="checkbox" name="grade" value="<?=$grade->grade?>" checked><?=$grade->grade?></label>
                  <? } else { ?>
                    <label class="grade-label"><input type="checkbox" name="grade" value="<?=$grade->grade?>"><?=$grade->grade?></label>
                  <? } ?>
                <? } ?>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-8">
          <table class="table">
            <thead>
              <th>Restaurant</th>
              <th>Cuisine</th>
              <th>Grade</th>
              <th>Score</th>
              <th>Address</th>
            </thead>
            <tbody id="ratings-body">
              <? foreach ($ratings as $rating) { ?>
                <tr class="rating">
                  <?= "<td class='restaurant'>" . $rating->dba . "</td>" ?>
                  <?= "<td class='cuisine'>" . $rating->cuisine_description . "</td>" ?>
                  <?= "<td class='grade'>" . $rating->grade . "</td>" ?>
                  <?= "<td class='score'>" . $rating->score . "</td>" ?>
                  <?= "<td class='address'>" . $rating->building . " " .$rating->street . "</td>" ?>
                </tr>
              <? } ?>
            </tbody>
          </table>
        </div>
         <div class="col-md-4">
          <iframe id="map" width="400" height="400" frameborder="0" style="border:0"></iframe>
        </div>
      </div>
    </div>

    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/script.js"></script>
  </body>
</html>