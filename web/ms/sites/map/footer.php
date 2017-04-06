		<!-- Scripts! -->
		<?php include($_SERVER['DOCUMENT_ROOT'].'/footreq.php'); ?>
		<script type="text/javascript" src="//maps.google.com/maps/api/js?sensor=true"></script>
		<script src="/js/gmaps.js" type="text/javascript"></script>
		<!-- Live map section -->
	
  <script type="text/javascript">
    var map;

    function loadResults (data) {
      var items, markers_data = [];
      if (data.sites.length > 0) {
        items = data.sites;

        for (var i = 0; i < items.length; i++) {
          var item = items[i];

          if (item.lat != undefined && item.lng != undefined) {
            var act_icon = '../../images/active.png';
			var dwn_icon = '../../images/down.png';
			var lst_icon = '../../images/lost.png';
			var icon = '';
			
			if (item.status == 'active') {
				icon = act_icon;
			} else if (item.status == 'down') {
				icon = dwn_icon;
			} else {
				icon = lst_icon;
			}

            markers_data.push({
				lat : item.lat,
				lng : item.lng,
				title : item.name,
				icon : {
					size : new google.maps.Size(32, 32),
					url : icon
					},
				infoWindow: {
					content: '<p><b>' + item.name + '</b></p> Owner: ' + item.owner + '<br> Num of device'
					}
            });
          }
        }
      }

      map.addMarkers(markers_data);
    }
 

    $(document).on('click', '.pan-to-marker', function(e) {
      e.preventDefault();

      var position, lat, lng, $index;

      $index = $(this).data('marker-index');

      position = map.markers[$index].getPosition();

      lat = position.lat();
      lng = position.lng();

      map.setCenter(lat, lng);
    });

    $(document).ready(function(){
 
      map = new GMaps({
        div: '#map',
        lat: -26.1084186,
        lng: 28.0342036
      });

      map.on('marker_added', function (marker) {
        var index = map.markers.indexOf(marker);
        $('#results').append('<li><a href="#" class="pan-to-marker" data-marker-index="' + index + '">' + marker.title + '</a></li>');

        if (index == map.markers.length - 1) {
          map.fitZoom();
        }
      });

      var xhr = $.getJSON('../../content/wugms.user.live.map.php');

 
      xhr.done(loadResults);
    });
  </script>		
	</body>
</html>
