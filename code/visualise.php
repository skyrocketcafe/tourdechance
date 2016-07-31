<?php require("php/imports.php"); ?>
<html>
    <head>	
		    <title>Tour de Chance - Whats on</title>
		    <?php require("structure/header.php"); ?>
    </head>
    <body onload="load()">
        <?php require("structure/navbar.php"); ?>
        <div id="mainJumbo">
            <div class="jumbotron">
                <div class="container">
                    <span class="white">
                        <h2 style="font-size:38px;">Take a chance, explore the Unexpected!</h2>
                        <p>There's more to do in Canberra than you ever imagined...</p>
                    </span>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div id="map"></div>
                    <!-- Code Credit Google Maps API (JS) -->
                    <script>
                        var customIcons = {
      restaurant: {
        icon: 'http://labs.google.com/ridefinder/images/mm_20_blue.png'
      },
      bar: {
        icon: 'http://labs.google.com/ridefinder/images/mm_20_red.png'
      }
    };

    function load() {
      var map = new google.maps.Map(document.getElementById("map"), {
        center: new google.maps.LatLng(-35.2809, 149.1300),
        zoom: 13,
        mapTypeId: 'roadmap'
      });
      var infoWindow = new google.maps.InfoWindow;

      // Change this depending on the name of your PHP file
      downloadUrl("https://canberra.tourdechance.net/php/plot.php", function(data) {
        var xml = data.responseXML;
        var markers = xml.documentElement.getElementsByTagName("marker");
        for (var i = 0; i < markers.length; i++) {
          var name = markers[i].getAttribute("name");
          var id = markers[i].getAttribute("id");
          var type = markers[i].getAttribute("type");
          var point = new google.maps.LatLng(
              parseFloat(markers[i].getAttribute("lat")),
              parseFloat(markers[i].getAttribute("lng")));
          var html = '<a href="details.php?id=' + id + '"><b>' + name + "</b></a> <br/>";
          var icon = customIcons[type] || {};
          var marker = new google.maps.Marker({
            map: map,
            position: point,
            icon: icon.icon
          });
          bindInfoWindow(marker, map, infoWindow, html);
        }
      });
    }

    function bindInfoWindow(marker, map, infoWindow, html) {
      google.maps.event.addListener(marker, 'click', function() {
        infoWindow.setContent(html);
        infoWindow.open(map, marker);
      });
    }

    function downloadUrl(url, callback) {
      var request = window.ActiveXObject ?
          new ActiveXObject('Microsoft.XMLHTTP') :
          new XMLHttpRequest;

      request.onreadystatechange = function() {
        if (request.readyState == 4) {
          request.onreadystatechange = doNothing;
          callback(request, request.status);
        }
      };

      request.open('GET', url, true);
      request.send(null);
    }

    function doNothing() {}
  </script>
                    </script>
                    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBV5VSXH5YEUdrMZhGdVNc1C2objtjJTxk&callback=load" async defer></script>
                </div>
                <div class="col-md-4">
                    <h2>Who said there is nothing to see in Canberra?</h2>
                    <div class="panel panel-default" style="margin-top:20px">
                        <div class="panel-heading">Some Statistics</div>

                        <!-- Table -->
                        <table class="table">
                            <tr>
                                <td>Historical Sites</td>
                                <td><?php echo stats_for_category("Historical");?></td>
                            <tr>
                            <tr>
                                <td>Zoo/Aquariums</td>
                                <td><?php echo stats_for_category("Zoos and Aquariums"); ?></td>
                            <tr>
                            <tr>
                                <td>Public Art Installations</td>
                                <td><?php

                                $g1 = stats_for_category("Public Art (1)");
                                $g2 = stats_for_category("Public Art (2)");
                                $g3 = stats_for_category("Public Art (3)");
                                $g4 = stats_for_category("Public Art (4)");

                                echo ($g1 + $g2 + $g3 + $g4);

                                ?></td>
                            <tr>
                            <tr>
                                <td>Graffiti Walls</td>
                                <td><?php echo stats_for_category("Graffiti Wall");?></td>
                            <tr>
                            <tr>
                                <td>Museums and Galleries</td>
                                <td><?php echo stats_for_category("Museums and Galleries");?></td>
                            <tr>
                            <tr>
                                <td>Family Fun</td>
                                <td><?php echo stats_for_category("Family Fun");?></td>
                            <tr>
                            <tr>
                                <td>National Attractions</td>
                                <td><?php echo stats_for_category("National Attraction");?></td>
                            <tr>
                            <tr>
                                <td>Sports and Rec</td>
                                <td><?php echo stats_for_category("Sports and Rec");?></td>
                            <tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>


    </body>
    <?php require("structure/footer.php"); ?>
</html>