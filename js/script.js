(function() {
  //search the embedded google maps for selected restaurant based on restaurant name and address
  loadMap = function(rating) {
      var iframe = $('#map');
      var search = $(rating).find('.restaurant').html() + ' ' + $(rating).find('.address').html() + ' New York, NY';
      //leaving the API key since I can restrict domain usage in Google API console
      var base_url = 'https://www.google.com/maps/embed/v1/search?q=' + search + '&key=AIzaSyDkJ6rZoVOfn-uC213YaYNlQ9bPwnLaJUM';
      iframe.attr('src', base_url);
      $('.rating').removeClass('highlight');
      $(rating).addClass('highlight');
    }
  //AJAX calls used to update the results when the cuisine or grade filters are changed
  search = function() {
    var grades = $("#grades input:checkbox:checked").map(function(){
      return $(this).val();
    }).get();
    var cuisine = $('#cuisine-input').val();
    $.ajax({
      url: "restaurant_search.php",
      data: {cuisine: cuisine, grades: grades}
    }).done(function(data) {
      var results = jQuery.parseJSON(data);
      var html = '';
      for (var i = 0; i < results.length; i++) { 
        html += '<tr class="rating" style="cursor:pointer;">';
        html += '<td class="restaurant">' + results[i].dba + '</td>';
        html += '<td class="cuisine">' + results[i].cuisine_description + '</td>';
        html += '<td class="grade">' + results[i].grade + '</td>';
        html += '<td class="score">' + results[i].score + '</td>';
        html += '<td class="address">' + results[i].building + ' ' + results[i].street + '</td>';
        html += '</tr>';
      }
      $('#ratings-body').html(html);
      $('.rating').click(function() {
        loadMap(this);
      });
      $('#dropdownMenu1').html('Cuisine: ' + cuisine + ' <span class="caret"></span>');
      $('.rating').first().click();
    });
  }

  $(document).ready(function() {
    $('#grades').click(function(event){
      search();
    });
    $('.rating').click(function() {
      loadMap(this);
    });
    $('.cuisine').click(function() {
      $('#cuisine-input').val($(this).html());
      search();
    });     
    $('.rating').first().click(); //select first restaurant on load
  });
})();