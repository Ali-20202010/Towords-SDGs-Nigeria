<!-- HTML -->
<div id="maindiv" style="height:600px;width:100%;"></div>
<script src="https://cdn.amcharts.com/lib/4/core.js"></script>
<script src="https://cdn.amcharts.com/lib/4/charts.js"></script>
<script src="https://cdn.amcharts.com/lib/4/themes/animated.js"></script>
<script type="text/javascript"></script>

<script>
// Create a chart instance
var line_data = <?php  echo $newlinevalue; ?>;
// console.log(line_data);
am4core.useTheme(am4themes_animated);
var chart = am4core.create("maindiv", am4charts.XYChart);
// var chart = root.container.children.push(
//     am4charts.XYChart.new(root, {
//     focusable: true,
//     panX: true,
//     panY: true,
//     wheelX: "panX",
//     wheelY: "zoomX",
//   pinchZoomX:true
//   })
// );
// Data
var seriesData = [
    {
        // for (const item of line_data) {
        //  console.log(item);
         name: "Line 1",
          data: [
            { date: new Date(2023, 0, 0), value: 100 },
            { date: new Date(2022, 0, 0), value: 150 },
            { date: new Date(2021, 0, 0), value: 200 }
            
        ],
        //  }
    },
    {
        name: "Line 2",
        data: [
            { date: new Date(2023, 0, 0), value: 200 },
            { date: new Date(2022, 0, 0), value: 250 },
            { date: new Date(2021, 0, 0), value: 300 }
        ]
    }
  
];

// Create axes
var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
dateAxis.baseInterval = { count: 1, timeUnit: "year" };
var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());

// Create series using a function
function createSeries(dataObj) {
    var series = chart.series.push(new am4charts.LineSeries());
    series.dataFields.valueY = "value";
    series.dataFields.dateX = "date";
    series.name = dataObj.name;
    series.data = dataObj.data;

    return series;
}

// Loop through the seriesData array and create series for each data object
for (var i = 0; i < seriesData.length; i++) {
    createSeries(seriesData[i]);
}

// Add legend
chart.legend = new am4charts.Legend();
</script>

