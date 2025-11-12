<!-- <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>

<div id="divchart"></div>

<script>
// Create root and chart
var root = am5.Root.new("divchart"); 
var chart = root.container.children.push( 
  am5xy.XYChart.new(root, {
    panY: false,
    layout: root.verticalLayout
  }) 
);
  chart.datasource.url = "";
// Define data
var data = [{ 
  category: "Research", 
  value1: 1000

}, { 
  category: "Marketing", 
  value1: 1200

}, { 
  category: "Sales", 
  value1: 850

}];

// Craete Y-axis
var yAxis = chart.yAxes.push( 
  am5xy.ValueAxis.new(root, { 
    renderer: am5xy.AxisRendererY.new(root, {}) 
  }) 
);

// Create X-Axis
var xAxis = chart.xAxes.push(
  am5xy.CategoryAxis.new(root, {
    renderer: am5xy.AxisRendererX.new(root, {}),
    categoryField: "category"
  })
);
xAxis.data.setAll(data);

// Create series
var series1 = chart.series.push( 
  am5xy.ColumnSeries.new(root, { 
    name: "Series", 
    xAxis: xAxis, 
    yAxis: yAxis, 
    valueYField: "value1", 
    categoryXField: "category" 
  }) 
);
series1.data.setAll(data);

var series2 = chart.series.push( 
    am5xy.ColumnSeries.new(root, { 
    name: "Series", 
    xAxis: xAxis, 
    yAxis: yAxis, 
    valueYField: "value2", 
    categoryXField: "category" 
  }) 
);
series2.data.setAll(data);

// Add legend
var legend = chart.children.push(am5.Legend.new(root, {})); 
legend.data.setAll(chart.series.values);

// Add cursor
chart.set("cursor", am5xy.XYCursor.new(root, {}));
</script> -->
<!-------------bubble chart start here----------------------------------------->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://code.highcharts.com/maps/highmaps.js"></script>
<script src="https://code.highcharts.com/maps/modules/exporting.js"></script>
<script src="https://code.highcharts.com/maps/modules/offline-exporting.js"></script>
<script src="https://code.highcharts.com/maps/modules/accessibility.js"></script>

<div id="container"></div>
<script>

(async () => {

const topology = await fetch(
    'https://code.highcharts.com/mapdata/countries/ng/ng-all.topo.json'
).then(response => response.json());

// const data =[{
//   "code3": "NG-AB", 
//   "z": 105, 
//   "code": "AB"
// },
// {
//   "code3": "NG-AD", 
//   "z": 34656, 
//   "code": "AD"
// },
// {
//   "code3": "NG-AK", 
//   "z": 28813, 
//   "code" : "AK"
// }
// ];

// const data = $.parseJSON(datas);
const data = [
        ['ng-ri', 10 , 'hi' ], ['ng-kt', 11 ], ['ng-so', 12], ['ng-za', 13],
        ['ng-yo', 14], ['ng-ke', 15], ['ng-ad', 16], ['ng-bo', 17],
        ['ng-ak', 18], ['ng-ab', 19], ['ng-im', 20], ['ng-by', 21],
        ['ng-be', 22], ['ng-cr', 23], ['ng-ta', 24], ['ng-kw', 25],
        ['ng-la', 26], ['ng-ni', 27], ['ng-fc', 28], ['ng-og', 29],
        ['ng-on', 30], ['ng-ek', 31], ['ng-os', 32], ['ng-oy', 33],
        ['ng-an', 34], ['ng-ba', 35], ['ng-go', 36], ['ng-de', 37],
        ['ng-ed', 38], ['ng-en', 39], ['ng-eb', 40], ['ng-kd', 41],
        ['ng-ko', 42], ['ng-pl', 43], ['ng-na', 44], ['ng-ji', 45],
        ['ng-kn', 46]
    ];
// const data = await fetch(
//         'https://cdn.jsdelivr.net/gh/highcharts/highcharts@v7.0.0/samples/data/world-population.json'
//     ).then(response => response.json());
    console.log(data);
Highcharts.mapChart('container', {
    chart: {
        map: topology
    },

    title: {
        text: 'World population 2016 by country'
    },

    subtitle: {
        text: 'Demo of Highcharts map with bubbles'
    },

    accessibility: {
        description: 'We see how China and India by far are the countries with the largest population.'
    },

    legend: {
        enabled: false
    },

    mapNavigation: {
        enabled: true,
        buttonOptions: {
            verticalAlign: 'bottom'
        }
    },

    // mapView: {
    //     fitToGeometry: {
    //         type: 'MultiPoint',
    //         coordinates: [
    //             // Alaska west
    //             [-164, 54],
    //             // Greenland north
    //             [-35, 84],
    //             // New Zealand east
    //             [179, -38],
    //             // Chile south
    //             [-68, -55]
    //         ]
    //     }
    // },

    series: [
      
      {
        name: 'Countries',
        color: '#E0E0E0',
        enableMouseTracking: false
    },
  {
   
        type: 'mapbubble',
        name: 'Population 2016',
        data: data, 
        dataLabels: {
                enabled: true,
                format: '{point.name}'
            },
        // joinBy: ['iso-a3', 'code3'],
     
        // states: {
        //         hover: {
        //             color: '#BADA55'
        //         }
        //     },
        minSize: 4,
        maxSize: '12%',
        tooltip: {
            pointFormat: '{point.x}: {point.y}'
        }
    }]
});
})();
</script>

<!---Bubble chart end here--->

<!-- Styles -->
<style>
#divchart {
  width: 100%;
  height: 500px;
max-width: 100%
}
</style>

<!-- Resources -->
<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>

<!-- Chart code -->
<script>
am5.ready(function() {

// Create root element
var root = am5.Root.new("divchart");

root.dateFormatter.set("dateFormat", "yyyy-MM-dd");

// Set themes
root.setThemes([
  am5themes_Animated.new(root)
]);

// Create chart
var chart = root.container.children.push(am5xy.XYChart.new(root, {
  // panX: true,
  // panY: true,
  // wheelX: "panX",
  // wheelY: "zoomX",
  // pinchZoomX:true
}));

// Add cursor
var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {
  behavior: "none"
}));
cursor.lineY.set("visible", false);



// Create axes
// https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
var xAxis = chart.xAxes.push(am5xy.DateAxis.new(root, {
  maxDeviation: 0.2,
  baseInterval: {
    timeUnit: "year",
    count: 1
  },
  renderer: am5xy.AxisRendererX.new(root, {}),
  tooltip: am5.Tooltip.new(root, {})
}));

var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
  renderer: am5xy.AxisRendererY.new(root, {
    pan:"zoom"
  })  
}));

// Add series
var series = chart.series.push(am5xy.LineSeries.new(root, {
  name: "Series",
  xAxis: xAxis,
  yAxis: yAxis,
  valueYField: "value",
  valueXField: "date",
  tooltip: am5.Tooltip.new(root, {
    labelText: "{valueY}"
  })
}));

series.data.processor = am5.DataProcessor.new(root, {
		
			dateFormat: "yyyy",
			dateFields: ["date"]
			});


      function createSeries(data,field,name,color) {
            var series = chart.series.push(
            am5xy.LineSeries.new(root, {
            name: "series",
            xAxis: xAxis,
            yAxis: yAxis,
            valueYField: field,
            valueXField: "date",
            // fill: am5.color(color),
            // stroke: am5.color(color),
            // calculateAggregates: true,
            // tooltip: am5.Tooltip.new(root, {
            // pointerOrientation: "horizontal",
            // labelText: "{valueY}"
            // }),
            // legendLabelText: "[bold {stroke}][/] {name}",
            })
            );
            series.data.processor = am5.DataProcessor.new(root, {
            numericFields: field,
            dateFormat: "yyyy-MM-dd",
            dateFields: ["date"]
            });
            series.data.setAll(data);
            series.strokes.template.setAll({
            strokeWidth: 3
            });
            }
            //console.log(r);
            createSeries(r,"data1","Las Vegas (NV)","#D63D4B");
            createSeries(r,"data2","Las Vegas MSA (NV)","#6BA2B9");
            root.numberFormatter.setAll({
            numberFormat: "$#.a",
            numericFields: ["data1","data2"]
            });


// // Add scrollbar
// chart.set("scrollbarX", am5.Scrollbar.new(root, {
//   orientation: "horizontal"
// }));


// Set data
var data =
[
{
date:'2021',
value:20
},
{
date:'2022',
value: 40},
{
date:'2023',
value: 80}
];


// generateDatas(1200);
series.data.setAll(data);


// Make stuff animate on load
// https://www.amcharts.com/docs/v5/concepts/animations/
series.appear(1000);
chart.appear(1000, 100);

}); // end am5.ready()
</script>

<!-- HTML -->
<div id="divchart"></div>


