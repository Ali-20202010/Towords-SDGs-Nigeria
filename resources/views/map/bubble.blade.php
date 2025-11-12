<!-------------Heat chart start here----------------------------------------->
<script src="https://code.highcharts.com/maps/highmaps.js"></script>
<script src="https://code.highcharts.com/maps/modules/exporting.js"></script>
<script src="https://code.highcharts.com/maps/modules/offline-exporting.js"></script>
<script src="https://code.highcharts.com/maps/modules/accessibility.js"></script>

<div id="container" style="height:600px;width:100%;"></div> 
<script type="text/javascript">var bubble_data =<?php  echo $mapvalue; ?>;

</script>
<script>

(async () => {

const topology = await fetch(
    'https://code.highcharts.com/mapdata/countries/ng/ng-all.topo.json'
).then(response => response.json()); 

    const nigeriaStates = 
    { 'Abia':'ng-ab',
    'Adamawa':'ng-ad',
    'Akwa Ibom': 'ng-ak' ,
    'Anambra': 'ng-an' ,
    'Bauchi': 'ng-ba' ,
    'Bayelsa': 'ng-by' ,
    'Benue': 'ng-be' ,
    'Borno': 'ng-bo' ,
    'Cross River': 'ng-cr',
    'Delta': 'ng-de',
    'Ebonyi': 'ng-eb',
    'Edo': 'ng-ed',
    'Ekiti': 'ng-ek',
    'Enugu': 'ng-en',
    'Federal Capital Territory': 'ng-fc',
    'Gombe': 'ng-gm' ,
    'Imo': 'ng-im' ,
    'Jigawa': 'ng-ji' ,
    'Kaduna': 'ng-kd' ,
    'Kano': 'ng-kn' ,
    'Katsina': 'ng-kt' ,
    'Kebbi': 'ng-ke' ,
    'Kogi': 'ng-ko' ,
    'Kwara': 'ng-kw' ,
    'Lagos': 'ng-la' ,
    'Nasarawa': 'ng-na' ,
    'Niger': 'ng-ni' ,
    'Ogun': 'ng-og' ,
    'Ondo': 'ng-on' ,
    'Osun': 'ng-os' ,
    'Oyo': 'ng-oy' ,
    'Plateau': 'ng-pl' ,
    'Rivers': 'ng-ri' ,
    'Sokoto': 'ng-so' ,
    'Taraba': 'ng-ta' ,
    'Yobe': 'ng-yo' ,
    'Zamfara': 'ng-za' }
;

    const newArray = [];
    let value;
    for (const item of bubble_data) {

    const statename = item['StateName'];
    if(Number(item['value']) === parseInt(Number(item['value']), 10))
    {  
   
    value =  Number(item['value']); 
    }else

    {   
     
        value = Number(item['value']).toFixed(2);
    }

    const code = getCountryCodeForState(statename);
    const res=[code,value];
    newArray.push(res);
 
}

const data =newArray;

// Function to get the ISO country code for a state
function getCountryCodeForState(stateName) {
    const countryCode = nigeriaStates[stateName];
    return countryCode || "Unknown"; // Return "Unknown" if state name not found
}

Highcharts.setOptions({
    lang: {
       
        downloadJPEG: 'JPEG',
        // downloadPDF: 'PDF',
        downloadPNG: 'PNG',
        printChart: 'Print',
   
    }
});

Highcharts.mapChart('container', {
    chart: {
        map: topology
      
    },

    exporting: {
        enabled: true, // Enable exporting module
        filename: 'Map Chart-'+'<?php echo $indicatorname?>',
        buttons: {
            contextButton: {
                // menuItems: ["downloadPNG", "downloadJPEG", "downloadPDF","printChart"],
                menuItems: ["downloadJPEG","downloadPNG","printChart"],
                symbol: 'menuball',
                symbolStroke: 'black', // Set the symbol (three dots) color
                symbolStrokeWidth: 2, 
                //enabled: false, // Disable the default export button
            },
            // downloadChart: {
            //     text: 'Download Chart',
            //     onclick: function () {
            //         this.exportChart(); // Trigger the download action
            //     },
            // },
            // printChart: {
            //     text: 'Print Chart',
            //     onclick: function () {
            //         this.print(); // Trigger the print action
            //     },
            // },
        },
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
    tooltip: {
        style: {
            fontSize: '16px', // Adjust the font size as needed
        },
    },

    colorAxis: {
        min: 0.25,
        max:1, // Adjust this value as needed
        stops: [
             [0.5, '#916400'],
     
    ]
    },
    series: [
      
      {
        name: 'Countries',
        color: '#f1b202',
        enableMouseTracking: false
    },
  {
   
     
        name: 'Series',
        data: data, 
        dataLabels: {
                enabled: true,
                style: {
                    fontSize: '14px', // Adjust the font size as needed
                },
                format: '{point.name}'
            },
      
     
        states: {
                hover: {
                    color: '#f3c546'
                }
            },
        minSize: 4,
        maxSize: '12%',
   
    }]
});
})();
// document.getElementById('downloadButton').addEventListener('click', function () {
//     Highcharts.charts[0].options.exporting.filename = 'Map Chart-'+'<?php echo $indicatorname?>';
//     Highcharts.charts[0].exportChart(); // Trigger the download action
// });

// document.getElementById('printButton').addEventListener('click', function () {
//     Highcharts.charts[0].print(); // Trigger the print action
// });



 </script>

<!---Heat chart end here--->


