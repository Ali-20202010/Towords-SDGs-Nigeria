@extends('layout.layout')
@section('content')
   <!-- Banner -->
   
   @section('page_css')
   <style>
  
    .other-states {
    margin-bottom: 5px;
    min-width: 137px;
    border-radius:20px;
}
.select-state {
    /* background: #E52240; */
    margin-bottom: -27px;
    margin-top: 45px;
    background: #E52240;
    color: #fff;
    /* position: absolute; */
    /* right: 0; */
    padding: 14px;
    border-radius: 4px;
    font-size: 16px;
    text-decoration: none;
    transition: all .30s ease-in-out;

}
.next_button {
	display: flex;
	margin-left: 94%;
	margin-top: -99px;
}
.previous_button {
	display: flex;
	margin-left: -11%;
}
/* .other-states:hover,.other-states.active {
    background: #000;
} */
   </style>
   @endsection

   
   @php
   $str = str_replace( '_' , ' ' , $tablename);
   $goal_name = ucfirst($str);
    if($tablename == 'goal_1')
    {
      $image = asset('/images/icons/sd-1.png');
    }elseif($tablename == 'goal_2'){
      $image = asset('/images/icons/sd-2.png');

    }
    elseif($tablename == 'goal_3'){
      $image = asset('/images/icons/sd-3.png');

    }elseif($tablename == 'goal_4'){
      $image = asset('/images/icons/sd-4.png');

    }
    elseif($tablename == 'goal_5'){
      $image = asset('/images/icons/sd-5.png');

    }elseif($tablename == 'goal_6'){
      $image = asset('/images/icons/sd-6.png');

    }elseif($tablename == 'goal_7'){
      $image = asset('/images/icons/sd-7.png');

    }elseif($tablename == 'goal_8'){
      $image = asset('/images/icons/sd-8.png');

    }elseif($tablename == 'goal_9'){
      $image = asset('/images/icons/sd-9.png');

    }elseif($tablename == 'goal_10'){
      $image = asset('/images/icons/sd-10.png');

    }
    elseif($tablename == 'goal_11'){
      $image = asset('/images/icons/sd-11.png');

    }elseif($tablename == 'goal_12'){
      $image = asset('/images/icons/sd-12.png');

    }elseif($tablename == 'goal_13'){
      $image = asset('/images/icons/sd-13.png');

    }elseif($tablename == 'goal_14'){
      $image = asset('/images/icons/sd-14.png');

    }elseif($tablename == 'goal_15'){
      $image = asset('/images/icons/sd-15.png');

    }elseif($tablename == 'goal_16'){
      $image = asset('/images/icons/sd-16.png');

    }elseif($tablename == 'goal_17'){
      $image = asset('/images/icons/sd-17.png');

    }

    // ----- Safe URL params for prev/next -----
    $prevNameRaw   = $back_goal['data'] ?? '';
    $prevTable     = $back_goal['pervious_table'] ?? '';
    $nextNameRaw   = $next_goal['data'] ?? '';
    $nextTable     = $next_goal['next_table'] ?? '';

    // Convert spaces to underscores like before, then rawurlencode to keep dots/utf safe
    $prevParam = $prevNameRaw !== '' ? rawurlencode(str_replace(' ', '_', $prevNameRaw)) : null;
    $nextParam = $nextNameRaw !== '' ? rawurlencode(str_replace(' ', '_', $nextNameRaw)) : null;

   @endphp

   <section class="sdgbanner" style="background: url({{asset('images/sdg2.jpg')}}) no-repeat;">
        <div class="container">
            <div class="bannerContent">
          <div class="bannerGoal">
            <span>
              <img src="{{$image}}" alt="img" width="45px" />
          </span>
          <div class="bannerGoal__caption">
              <h3>{{$goal_name}}</h3>
              <h1 class="sdheading">End poverty in all its forms everywhere</h1>
            <div class="goalBtn"> 
                @if($prevParam && $prevTable)
                 <a class="prevBtn"  href="{{ route('DetailIndicator', ['name'=> $prevParam ,'table_name'=>$prevTable])}}">Previous Goal</a>
                @endif
                @if($nextParam && $nextTable)
                <a class="nextBtn"  href="{{ route('DetailIndicator', ['name'=> $nextParam ,'table_name'=>$nextTable])}}">Next Goal</a>
                @endif
               
          </div>
      </div>
          </div>
            
      </div>
        </div>
          
    </section>
    <!-- //banner -->


    <!-- tabs Indicatoe -->
    <div class="indicatorTabWrapper">
        <div class="container">
            <section class="tabs-content">
                <div class="tab" id="tab2">
                    <div class="indicator__inner">
                        <div class="indicator__block">
                            <span class="indicator__icon">
                                <img src="{{$image}}" alt="img" width="45px"/>
                            </span>
                            <div class="indicator__text">
                                <h3>@php echo str_replace('_',' ',$indicatorname)@endphp</h3>
                                <p>The indicator Proportion of population below the international poverty line is
                                    defined as
                                    the percentage of the population living on less than $1.90 a day at 2011
                                    international
                                    prices. The international poverty line is currently set at $1.90 a day at 2011
                                    international prices.</p>
                            </div>
                            <a href="{{route('indicators')}}" class="backGoal">Back to goals</a>
                        </div>
                    </div>

                    <div class="indicator__btm">
                     <div class="tabInner">
                        <div class="tabInnernav__block">
                        <ul class="tabInner__nav">
                            <li class="active chartdiv" ><a href="#chartdiv">Bar Chart</a></li>
                            <li><a href="#tabInner2">Definition</a></li>
                            <li><a href="#tabInner3">Footnotes</a></li>
                        </ul>

                        <ul class="rightBtns">
                            <!-- <li><a href="javascript:void(0)" id="barchartbutton" onclick="downloadChart('chartdiv',2,'<?php echo $indicatorname;?>','Bar Chart-')">Download</a></li> -->
                            <!-- <li><a href="javascript:void(0)" onclick="printChart('chartdiv')">Print</a></li> -->

                        </ul>
                    </div>

                        <div class="tabinner__content">
                            <div class="tabinnr tab2" id="chartdiv" style="background-color:white;">
                                
                            </div>
                            <div class="tabinnr" id="tabInner2">
                                Definition
                            </div>
                            <div class="tabinnr" id="tabInner3">
                                Footnotes
                            </div>
                        </div>
                     </div>

                     </div>
                    
                </div>

                <div class="tab" id="tab3">
                <div class="indicator__inner">
                        <div class="indicator__block">
                            <span class="indicator__icon">
                            <img src="{{$image}}" alt="img" width="45px"/>
                            </span>
                            <div class="indicator__text">
                                <h3>@php echo str_replace('_',' ',$indicatorname)@endphp</h3>
                                <p>The indicator Proportion of population below the international poverty line is
                                    defined as
                                    the percentage of the population living on less than $1.90 a day at 2011
                                    international
                                    prices. The international poverty line is currently set at $1.90 a day at 2011
                                    international prices.
                                </p>
                            </div>
                            <a href="{{route('indicators')}}" class="backGoal">Back to goals</a>
                        </div>
                    </div>
                   
                    <div class="indicator__btm">
<div class="tabInner">
<div class="tabInnernav__block">
   <ul class="tabInner__nav">
      <li class="active chartdiv"><a href="#divchart">Country Chart</a></li>
      <li><a href="#tabInner4">Definition</a></li>
      <li><a href="#tabInner5">Footnotes</a></li>
   </ul>
</div>
<div class="tabinner__content">
   <div class="tabinnr" id="divchart" style="background-color:white;">

<div class="custom_switch">
<span><b>Heat Map</b></span>
<input type="checkbox" value="1" class="switch">
<span><b>Bubble Map</b></span>
  </div>

<div class="map_2">
   @include('map.bubble')
  </div>

  <div class="tab_content " style="display:none;">
  @include('map.bubble2')
  </div>

   </div>
   <div class="tabinnr" id="tabInner4">
      Definition
      <h3>Fourth Tab</h3>
      <p>Just go out and talk to a tree. Make friends with it. For the lack of a better word I call them
         hangy
         downs. There's nothing wrong with having a tree as a friend. Maybe there's a happy little
         waterfall
         happening over here. I think there's an artist hidden in the bottom of every single one of us.
         So
         often we avoid running water, and running water is a lot of fun.
      </p>
   </div>
   <div class="tabinnr" id="tabInner5">
      Footnotes
   </div>
</div>
</div>
</div>
                </div>

                <div class="tab" id="tab4">
                <div class="indicator__inner">
                        <div class="indicator__block">
                            <span class="indicator__icon">
                            <img src="{{$image}}" alt="img" width="45px"/>
                            </span>
                            <div class="indicator__text">
                                <h3>@php echo str_replace('_',' ',$indicatorname)@endphp</h3>
                                <p>The indicator Proportion of population below the international poverty line is
                                    defined as
                                    the percentage of the population living on less than $1.90 a day at 2011
                                    international
                                    prices. The international poverty line is currently set at $1.90 a day at 2011
                                    international prices.</p>
                            </div>
                            <a href="{{route('indicators')}}" class="backGoal">Back to goals</a>
                        </div>
                    </div>
                   
                     <div class="indicator__btm">
                     <div class="tabInner">
                        <div class="tabInnernav__block">
                        <ul class="tabInner__nav">
                            <li class="active chartdiv"><a href="#divchart2">Line Chart</a></li>
                            <li><a href="#tabInner6">Definition</a></li>
                            <li><a href="#tabInner7">Footnotes</a></li>
                            
                        </ul>
                    </div>

                        <div class="tabinner__content">
                            <div class="tabinnr" id="divchart2">
                                  @include('map.line_chart')

                                  <a type="button" class="btn btn-primary select-state" data-toggle="modal" data-target="#exampleModal">
                                    Select States
                                  </a>

                                  <!-- Modal -->
                                  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <h5 class="modal-title" id="exampleModalLabel">Select States</h5>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                          </button>
                                        </div>
                                        <div class="modal-body">
                                          @foreach($new_table_value as  $key=>$state)
                                            @if($key == 'Nigeria')
                                              <button type="button" class="other-states2 btn btn-link" id="{{str_replace(' ', '',$key )}}" disable>{{$key}}</button>
                                            @elseif($key == 'Abia')
                                              <button type="button" class="other-states2 btn btn-link disable" id="{{str_replace(' ', '',$key )}}" >{{$key}}</button>
                                            @else
                                              <button type="button" class="other-states btn btn-success" id="{{str_replace(' ', '' ,$key )}}">{{$key}}</button>
                                            @endif
                                          @endforeach
                                        </div>
                                        <div class="modal-footer">
                                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                            </div>
                            <div class="tabinnr" id="tabInner6">
                                Definition
                                <h3>Fourth Tab</h3>
                    <p>Just go out and talk to a tree. Make friends with it. For the lack of a better word I call them
                        hangy
                        downs. There's nothing wrong with having a tree as a friend. Maybe there's a happy little
                        waterfall
                        happening over here. I think there's an artist hidden in the bottom of every single one of us.
                        So
                        often we avoid running water, and running water is a lot of fun.
                     </p>
                            </div>
                            <div class="tabinnr" id="tabInner7">
                                Footnotes
                            </div>
                        </div>
                      </div>
</div></div>

 

   <div class="tab" id="tab5">
              <div class="indicator__inner">
                <div class="indicator__block">
                    <span class="indicator__icon">
                    <img src="{{$image}}" alt="img" width="45px"/>
                    </span>
                    <div class="indicator__text">
                      <h3>@php echo str_replace('_',' ',$indicatorname)@endphp</h3>
                      <p>The indicator Proportion of population below the international poverty line is
                          defined as
                          the percentage of the population living on less than $1.90 a day at 2011
                          international
                          prices. The international poverty line is currently set at $1.90 a day at 2011
                          international prices.
                      </p>
                    </div>
                    <a href="{{route('indicators')}}" class="backGoal">Back to goals</a>
                </div>
              </div>
      <div class="indicator__btm">
         <div class="tabInner">
            <div class="tabInnernav__block">
               <ul class="tabInner__nav">
                  <li class="active chartdiv"><a href="#tabInner1">Table</a></li>
                  <li><a href="#tabInner8">Definition</a></li>
                  <li><a href="#tabInner9">Footnotes</a></li>
               </ul>
              <div class="dropdown rightBtns">
              <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" style="font-weight:700;font-size:18px;border:0!important;outline:0!important;">
              ...
              </button>
              <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
              <li><a href="javascript:void(0)" onclick="downloadChart('tabInner1',2,'<?php echo $indicatorname;?>','Table Chart-','jpg')">JPG</a></li>
              <li><a href="javascript:void(0)" onclick="downloadChart('tabInner1',2,'<?php echo $indicatorname;?>','Table Chart-','png')">PNG</a></li>
              <li><a href="javascript:void(0)" onclick="printChartline()">Print</a></li>
              </ul>
              </div>
            </div>
            <div class="tabinner__content">
               <div class="tabinnr" id="tabInner1" style="background-color:white;">
                <table class="table-striped table-bordered w-100">
                <tr class="info">
                <th>States</th>
                @foreach($tableyear as $year)
                <th>{{$year->year}}</th>
                @endforeach
                </tr>
               
                @foreach($new_table_value as $key =>$value)
                <tr>
                <td>{{$key}}</td>
                @foreach($value as $month)
                @foreach($tableyear as $year)
                @if($year->year == $month->year)
                <td>
                {{round($month->value,2)}}
                </td>
                @endif
                @endforeach
                @endforeach
                </tr>
                @endforeach
            
                </table>
               </div>
               <div class="tabinnr" id="tabInner8">
                  Definition
                  <h3>Fourth Tab</h3>
                  <p>Just go out and talk to a tree. Make friends with it. For the lack of a better word I call them
                     hangy downs.There's nothing wrong with having a tree as a friend. Maybe there's a happy little
                     waterfall happening over here. I think there's an artist hidden in the bottom of every single one of us.
                     So often we avoid running water, and running water is a lot of fun.
                  </p>
               </div>
               <div class="tabinnr" id="tabInner9">
                  Footnotes
               </div>
            </div>
          </div>
          </div>
          </div>
               
       <div class="tab" id="tab6">
<div class="indicator__inner">
<div class="indicator__block">
<span class="indicator__icon">
<img src="{{$image}}" alt="img" width="45px"/>
</span>
<div class="indicator__text">
   <h3>@php echo str_replace('_',' ',$indicatorname)@endphp</h3>
   <p>The indicator Proportion of population below the international poverty line is
      defined as
      the percentage of the population living on less than $1.90 a day at 2011
      international
      prices. The international poverty line is currently set at $1.90 a day at 2011
      international prices.
   </p>
</div>
<a href="{{route('indicators')}}" class="backGoal">Back to goals</a>
</div>
</div>
<div class="indicator__btm">
<div class="tabInner">
<div class="tabInnernav__block">
   <ul class="tabInner__nav">
      <li class="active chartdiv"><a href="#tabInner22">Map</a></li>
      <li class="map"><a href="#tabInner10">Definition</a></li>
      <li><a href="#tabInner11">Footnotes</a></li>
   </ul>
   <ul class="rightBtns">
      <li><a href="javascript:void(0)">Download</a></li>
      <li><a href="javascript:void(0)">Print</a></li>
   </ul>
</div>
<div class="tabinner__content">
   <div class="tabinnr" id="tabInner22">
    mapp
   </div>
   <div class="tabinnr" id="tabInner10">
      Definition
      <h3>Sixth  Tab</h3>
      <p>Just go out and talk to a tree. Make friends with it. For the lack of a better word I call them
         hangy
         downs. There's nothing wrong with having a tree as a friend. Maybe there's a happy little
         waterfall
         happening over here. I think there's an artist hidden in the bottom of every single one of us.
         So
         often we avoid running water, and running water is a lot of fun.
      </p>
   </div>
   <div class="tabinnr" id="tabInner11">
      Footnotes
   </div>
</div>
</div>
</div>
</div>
    </section>
            <ul class="indicator__nav">
                <li class="active"><a href="#tab2" data-id="#chartdiv">Bar Chart</a></li>
                <li><a href="#tab3" data-id="#divchart">Map</a></li>
                <li><a href="#tab4" data-id="#divchart2">Line Chart</a></li>
                <li><a href="#tab5" data-id="#tabInner1">Table</a></li>
                <li><a href="#tab6" data-id="#tabInner22">Footnotes</a></li>
            </ul>
        </div>
    </div>

{{-- Indi-slider --}}
@if(count($pending_goals)!=1)
<section class="ind_Wrap py-5">
    <div class="container">

        <h2>Explore More Indicators For Goals</h2>
        <div class="indSlider">
          @if(isset($pending_goals))
          @foreach($pending_goals as $data)
            @php
              $label = $data->Global_SDG_indicators ?? '';
              // your old special-case alias:
              $isSpecial = ($label === '3.2.1 Under?5 mortality rate');
              $slug = $isSpecial ? '3.2.1_Under_5_mortality_rate'
                                 : str_replace(' ', '_', $label);
              $slug = rawurlencode($slug);
            @endphp

            @if($indicatorname != str_replace(' ','_',$label))
              <div class="ind_item">
                  <div class="ind_item_text">
                      <h4>
                        @if($label !== '')
                          <a href="{{ route('DetailIndicator', ['name' => $slug, 'table_name' => $tablename]) }}" target="_blank">
                            {{$label}}
                          </a>
                        @else
                          <span>{{$label}}</span>
                        @endif
                      </h4>
                      <p>End poverty in all its forms everywhere</p>
                  </div>
              </div>
            @endif
          @endforeach
          @endif

        </div>
    </div>
</section>
@endif
{{-- //Indi-slider --}}


    <!-- //tabs Indicator -->
    <!-- <script type="text/javascript" src="/js/jquery-3.7.1.min.js"></script> -->
	<!-- <script type="text/javascript" src="/js/slick.js"></script> -->

    <script>
        $(document).ready(function () {

            // header fix
			$(window).scroll(function () {
				var sticky = $('.sdgHeader'),
					scroll = $(window).scrollTop();

				if (scroll >= 100) sticky.addClass('fixed');
				else sticky.removeClass('fixed');
			});

            $('.indicator__nav a').click(function () {
                $('.indicator__nav li').removeClass('active');
                $(this).parent().addClass('active');
                let currentTab = $(this).attr('href');
                $('.tabs-content .tab').hide();
                var inntrtabs= $(this).attr('data-id');
                $('.tabinner__content .tabinnr').hide();
                $('.tabinner__content .tabinnr').removeClass('active');
                $('.tabInner__nav li').removeClass('active');
                $('.chartdiv').addClass('active');
                $(inntrtabs).show();
                $(currentTab).show();
                return false;
            });

            // InnerTab
            $('.tabInner__nav a').click(function () {
                $('.tabInner__nav li').removeClass('active');
                $(this).parent().addClass('active');
                let currentTab1 = $(this).attr('href');
                $('.tabinner__content .tabinnr').hide();
                $('.tabinner__content .tabinnr').removeClass('active');
                $(currentTab1).show();
                return false;
            });
             
            var tablename = "<?php echo $tablename;?>";
            var numberMatches = tablename.match(/\d+/);
            if (numberMatches) {
              var number = parseInt(numberMatches[0], 10);
            } else {
              console.log("No number found in the string.");
            }
            var mainclass = "detail-"+number;
            $("#main").addClass(mainclass);

        })
    </script>
   

   <!---Map Chart js-->
   <script src="//cdn.amcharts.com/lib/4/core.js"></script>
<script src="{{asset('js/amchart/html2canvas.min.js')}}"></script>
<script src="{{asset('js/amchart/index.js')}}" ></script>
<script src="{{asset('js/amchart/xy.js')}}"></script>
<script src="{{asset('js/amchart/Animated.js')}}"></script>
<script src="{{asset('js/amchart/map.js')}}"></script>
<script src="{{asset('js/amchart/worldLow.js')}}"></script>
<script src="https://cdn.amcharts.com/lib/5/plugins/exporting.js"></script>
<script type="text/javascript">
  // Use RAW JSON (numeric) sent by controller
  var chart_data = {!! $newgoalvalue !!};
</script>
<!-- Chart code  for bar chart-->
<script>
am5.ready(function() {

// Create root element
var root = am5.Root.new("chartdiv", { useSafeResolution: false });

// Set themes
root.setThemes([
  am5themes_Animated.new(root)
]);

// Create chart
var chart = root.container.children.push(am5xy.XYChart.new(root, {
  panX: false,
  panY: false,
  retina: true,
  layout: root.verticalLayout
}));

chart.setAll({
  exporting: {
    enabled: true,
    filename: "Monthly Report: 2"
  }
});

// Add legend
var legend = chart.children.push(am5.Legend.new(root, {
  centerX: am5.p50,
  x: am5.p50
}));

var data = chart_data;

// Create axes
var yAxis = chart.yAxes.push(am5xy.CategoryAxis.new(root, {
  categoryField: "StateName",
  renderer: am5xy.AxisRendererY.new(root, {
    inversed: false,
    cellStartLocation: 0.1,
    cellEndLocation: 0.9,
    label: { locationY: 0.5 },
    minGridDistance: 10
  })
}));
yAxis.data.setAll(data);

var xAxis = chart.xAxes.push(am5xy.ValueAxis.new(root, {
  renderer: am5xy.AxisRendererX.new(root, { strokeOpacity: 0.1 }),
  min: 0
}));

// Series
function createSeries(field, name) {
  var series = chart.series.push(am5xy.ColumnSeries.new(root, {
    name: name,
    xAxis: xAxis,
    yAxis: yAxis,
    valueXField: field,
    categoryYField: "StateName",
    sequencedInterpolation: true
  }));

  series.columns.template.setAll({
    tooltipText: "[bold]{categoryY}:{valueX}",
    width: am5.percent(90),
    tooltipY: 0,
    height: am5.p100,
    strokeOpacity: 0
  });

  series.columns.template.setAll({
    fill: am5.color('#a9a9a9')
  });

  // Ensure numeric coercion (extra safety)
  series.data.processor = am5.DataProcessor.new(root, { numericFields: field });

  series.data.setAll(data);
  series.appear();
  return series;
}

createSeries("value", "Value");

// Add legend
var legend = chart.children.push(am5.Legend.new(root, {
  centerX: am5.p50,
  x: am5.p50
}));
legend.data.setAll(chart.series.values);

// Cursor
var cursor = chart.set("cursor", am5xy.XYCursor.new(root, { behavior: "zoomY" }));
cursor.lineY.set("forceHidden", true);
cursor.lineX.set("forceHidden", true);

var indicatorname = 'Bar Chart-<?php echo $indicatorname; ?>';

// Exporting
chart.realWidth = 1240; 
chart.realHeight = 900;
chart.appear(1000, 100);

var exporting = am5plugins_exporting.Exporting.new(root, {
  menu: am5plugins_exporting.ExportingMenu.new(root, {}),
  filePrefix: indicatorname,
  button: { type: "export", label: "Download" },
  pngOptions: { quality: 1, maintainPixelRatio:true, minWidth: 1000, maxWidth: 2000 },
  jpgOptions: null,
  svgOptions: null,
  pdfOptions: null
});
exporting.get("menu").set("items", [
  { type: "format", format: "jpg", label: "JPG" },
  { type: "format", format: "png", label: "PNG" },
  { type: "format", format: "print", label: "Print" }
]);

}); // end am5.ready()
</script>

<script>

  function downloadChart(chartId, scaleFactor, indicatorname,chartname,type) {
    const chartContainer = document.getElementById(chartId);
    html2canvas(chartContainer).then((canvas) => {
      let dataURL;
      if(type==="png"){
        dataURL = canvas.toDataURL('image/png');
      }else if(type==="jpg"){
        dataURL = canvas.toDataURL('image/jpg');
      }else{
        dataURL = canvas.toDataURL('image/pdf');
      }
      const link = document.createElement('a');
      link.href = dataURL;
      link.download = ''+chartname+indicatorname+'.'+type+'';
      link.click();
    });
}

function printChart(chartId) {
  var printContents = document.getElementById(chartId).innerHTML;
  var originalContents = document.body.innerHTML;
  document.body.innerHTML = printContents;
  window.print();
  document.body.innerHTML = originalContents;
}
</script>
<script>

function printChartline() {
  var chartContainer = document.getElementById("tabInner1");
  var printWindow = window.open("", "_blank");
  printWindow.document.open();
  printWindow.document.write(chartContainer.innerHTML);
  printWindow.document.close();
  printWindow.print();
  printWindow.close();
}

function exportChart(indicatorname) {
  chart.exporting.filePrefix = 'Line Chart-'+indicatorname+'';
  chart.exporting.export("png");
}

</script>

<script type="text/javascript">
    $(document).ready(function() { 
        $('.indSlider').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: true,
            autoplay:true,
            adaptiveHeight: true,
            cssEase: 'linear',
            speed: 300,
        });
    });
</script>

<script>
$(document).ready(function(){
  $(".switch").click(function(){
    $(".map_2").toggleClass("hide");
    $(".tab_content").toggleClass("show");
  });
});
</script>

@stop
