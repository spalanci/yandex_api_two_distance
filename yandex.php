
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Examples. Analyzing the route by segment and outputting a text description of the route.</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <script src="http://api-maps.yandex.ru/2.1/?load=package.full&lang=en-US&apikey=<key>" type="text/javascript"></script>
    <script src="http://yandex.st/jquery/1.6.4/jquery.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        ymaps.ready(init);

			<?php 
			//list = lat#long
				$x1  = $list[0];
				$xy1 = explode("#",$x1);
				$x2  = $list[1];
				$xy2 = explode("#",$x2);
			?>
        function init () {
            var myMap = new ymaps.Map("map", {
                center: [<?=$xy1[0];?>,<?=$xy1[1];?>],
                zoom: 12
            });

            ymaps.route(['<?=$xy1[0];?>,<?=$xy1[1];?>', '<?=$xy2[0];?>,<?=$xy2[1];?>'], {
                mapStateAutoApply: true
            }).then(function (route) {
                  myMap.geoObjects.add(route);
                  var way = route.getPaths().get(0),
                      segments = way.getSegments(),
                      moveList = '';
					  var distance = 0;
					  var time = 0;
                  for (var i = 0; i < segments.length; i++) {
                      var street = segments[i].getStreet(),
                          direction = segments[i].getHumanAction();
                      /*moveList += ((((direction == 'right') || (direction == 'left')) ? 'turn ' + direction + ' onto ' :
                                   (direction == 'straight' ? 'go ' + direction + ' to ' :
                                   (((direction == 'bear right') || (direction == 'bear left')) ? direction +
                                   ' onto ': (direction == 'merge' ? direction + ' with ' :
                                   (direction == 'back' ? 'turn around onto ' : 'board ferry'))))) +
                                   street  + ' (continue for ' + segments[i].getLength() + ' m.),');*/
					  distance 	= (distance+segments[i].getLength());
					  time 	= (time+segments[i].getTime());
                  }
                  moveList += distance+', '+time;
                  // Output the router's directions
                  $('#list').append(moveList);
				 query = '(\'<?php echo $list[4];?>\',\'<?php echo $list[4];?>_G_D0\', \'<?php echo $list[2];?>\',\'<?php echo $list[3];?>\','+distance+','+time+',1,\'<?php echo date("Y-m-d H:i:s");?>\');';
                      $('#query').append(query);
				  
				window.location.href='?<?php echo "i=$i&";?>query=' + query;
            }, function (error) {
                alert('An error occurred: ' + error.message);
            });
        }
    </script>
</head>

<body>
<table style = 'border: solid; border-color: #423189;'>
    <tr>
        <td style = "border: solid; border-color: #423189;">
            <div id="map" style="width: 700px; height: 450px"> </div>
        </td>
        <td style="padding-left: 10px; padding-top: 10px" valign = "top">
            <div id="list"></div>
            <div id="query"></div>
        </td>
    </tr>
</table>

</html>
