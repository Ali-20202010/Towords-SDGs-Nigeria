<div id="maindiv" style="height:600px;width:100%; " ></div>
<!-- <button id="playButton">Play</button> -->
<script src="https://cdn.amcharts.com/lib/4/core.js"></script>
<script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
<script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript"></script>
<script>
// Create a chart instance
var line_data = [<?php echo json_encode($new_line_value);; ?>];

am4core.useTheme(am4themes_animated);

var chart = am4core.create("maindiv", am4charts.XYChart);
var seriesData = [];
var NigeriaData = [];
var OtherState = [];
var stateData = line_data[0];

$.each(stateData, function(index, value) {

  var data = [];
   $.each(value, function(data0 , data1) {
 
    data.push({
      date: new Date(data1.year, 0, 1),
      value: parseFloat(data1.value).toFixed(2),
    });
   
    
  });

  if(index == 'Nigeria'){
    NigeriaData.push({
        name:index,
        data:data,
    });
  }
  else if(index == "Abia")
  {
    NigeriaData.push({
        name:index,
        data:data,
    });
  }
  else{
    OtherState.push({
        name:index,
        data:data,
    });
  }
});


// Create axes

var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
dateAxis.baseInterval = { count: 0, timeUnit: "year" };
var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

// Create series using a function
function createSeries(dataObj) {
    var series = chart.series.push(new am4charts.LineSeries());
    series.dataFields.valueY = "value";
    series.dataFields.dateX = "date";
    series.name = dataObj.name;
    series.data = dataObj.data;
    var bullet = series.bullets.push(new am4charts.CircleBullet());
      bullet.circle.strokeWidth = 2;
    //   bullet.showTooltipOn = "always";
      bullet.tooltipText = "{dateX}: [bold]{valueY}[/]";
    return series;
}
// var playButton = document.getElementById("playButton");
    // var animationInterval;
    // var playing = false;

    // function togglePlay() {
    //   if (playing) {
    //     clearInterval(animationInterval);
    //     playButton.textContent = "Play";
    //     playing = false;
    //   } else {
    //     playButton.textContent = "Stop";
    //     playing = true;
    //     var currentIndex = 0;

    //     animationInterval = setInterval(function () {
    //       if (currentIndex < NigeriaData.length) {
    //         for (var i = 0; i < NigeriaData.length; i++) {
    //           NigeriaData[i].data = createZigzagData(NigeriaData[i].data, currentIndex);
    //           chart.series.values[i].data = NigeriaData[i].data; // Update the series data
    //         }
    //         // chart.invalidateData()
    //         currentIndex++;
    //       } else {
    //         clearInterval(animationInterval);
    //         playButton.textContent = "Play";
    //         playing = true;
    //       }
    //     }, 2000); // Adjust the interval for your desired animation speed (in milliseconds)
    //   }
    // }

    // playButton.addEventListener("click", togglePlay);


    // function createZigzagData(data, index) {
    //   var zigzagData = [];
    //   for (var i = 0; i <= index; i++) {
    //     zigzagData.push(data[i]);
    //   }
    //   if (index % 2 === 1) {
    //     zigzagData = zigzagData.reverse();
    //   }
    //   return zigzagData;
    // }
// Loop through the seriesData array and create series for each data object
for (var i = 0; i < NigeriaData.length; i++) {
    createSeries(NigeriaData[i]);
}
// Add legend
chart.cursor = new am4charts.XYCursor();
chart.scrollbarX = new am4charts.XYChartScrollbar();
// chart.scrollbarX.series.push(lineSeries);
chart.legend = new am4charts.Legend();
chart.legend.spacing = 10; // Adjust the value as needed


chart.invalidateData();
chart.exporting.menu = new am4core.ExportMenu();
chart.exporting.filePrefix = 'Line Chart-'+'<?php echo $indicatorname?>'; 
chart.exporting.menu.items = [{
  "label": "...",
  "menu": [
    { "type": "jpg", "label": "JPG" },
    { "type": "png", "label": "PNG" },
   
    // { "type": "pdf", "label": "PDF" },
    { "label": "Print", "type": "print" }
  ]
}];
$(document).ready(function() {
  var activeSeries = {}; // Keep track of active series by name
  // $(".other-states").addClass("btn btn-success");
  $(".other-states").click(function() {
    // console.log("Button clicked!");
    var buttonText = $(this).text();
    // console.log(buttonText);
    var id  = $(this).attr('id');
    //  console.log($("#" + id).hasClass("btn btn-success"));
    if ($("#" + id).hasClass("btn btn-link")== true) {
          // Button was already clicked, remove the class to revert the color
          // alert('here');
          $("#" + id).removeClass("btn btn-link");
          $("#" + id).addClass("btn btn-success");
        } else {
          // Button was not clicked, add the class to change the color
          $("#" + id).removeClass("btn btn-success");
          $("#" + id).addClass("btn btn-link");
 
        }
  

    // Check if the data with the same name already exists in NigeriaData
    var existingData = NigeriaData.find(function(item) {
      return item.name === buttonText;
    });

    if (!existingData) {
      var abc = [];
      // $(this).addClass('active');
      
      $.each(OtherState, function(index, stateData) {
        if (stateData.name === buttonText) {
          $.each(stateData.data, function(data2, data3) {
            abc.push({
              date: data3.date,
              value: parseFloat(data3.value),
            });
          });
        }
      });

      NigeriaData.push({
        name: buttonText,
        data: abc,
      });

      // console.log(NigeriaData);

      // Create a series for the newly added data
      var newSeries = createSeries(NigeriaData[NigeriaData.length - 1]);

      // Keep track of active series by name
      activeSeries[buttonText] = newSeries;
    } else {
      // If the series already exists, remove it from the chart and delete it from activeSeries
      var seriesToRemove = activeSeries[buttonText];
     

      if (seriesToRemove) {
        
        chart.series.removeValue(seriesToRemove);
        delete activeSeries[buttonText];
      } else {
        // If the series was removed, add it back to the chart and add it to activeSeries
        // $(this).css('background-color' , '#3e8e41');
        // 
        var abc = [];
         
        $.each(OtherState, function(index, stateData) {
          if (stateData.name === buttonText) {
            $.each(stateData.data, function(data2, data3) {
              abc.push({
                date: data3.date,
                value: parseFloat(data3.value),
              });
            });
          }
        });

        NigeriaData.push({
          name: buttonText,
          data: abc,
        });

        var newSeries = createSeries(NigeriaData[NigeriaData.length - 1]);
        activeSeries[buttonText] = newSeries;
        
      }
    }
   
  });
});
</script>

