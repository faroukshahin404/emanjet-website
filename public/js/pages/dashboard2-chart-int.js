//[Dashboard Javascript]

//Project:	CrmX Admin - Responsive Admin Template
//Primary use:   Used only for the main dashboard (index.html)


$(function () {

  'use strict';
	
	
	
	
	am4core.ready(function() {

	// Themes begin
	am4core.useTheme(am4themes_kelly);
	am4core.useTheme(am4themes_animated);
	// Themes end

	// Create chart instance
	var chart = am4core.create("bitcoin-timeline", am4charts.XYChart);

	// Add data
	chart.data = [{
	  "x": "1",
	  "y": 1,
	  "text": "[bold]2018 Q1[/]\nThere seems to be some furry animal living in the neighborhood.",
	  "center": "bottom"
	}, {
	  "x": "2",
	  "y": 1,
	  "text": "[bold]2018 Q2[/]\nWe're now mostly certain it's a fox.",
	  "center": "top"
	}, {
	  "x": "3",
	  "y": 1,
	  "text": "[bold]2018 Q3[/]\nOur dog does not seem to mind the newcomer at all.",
	  "center": "bottom"
	}, {
	  "x": "4",
	  "y": 1,
	  "text": "[bold]2018 Q4[/]\nThe quick brown fox jumps over the lazy dog.",
	  "center": "top"
	}];

	// Create axes
	var xAxis = chart.xAxes.push(new am4charts.CategoryAxis());
	xAxis.dataFields.category = "x";
	xAxis.renderer.grid.template.disabled = true;
	xAxis.renderer.labels.template.disabled = true;
	xAxis.tooltip.disabled = true;

	var yAxis = chart.yAxes.push(new am4charts.ValueAxis());
	yAxis.min = 0;
	yAxis.max = 1.99;
	yAxis.renderer.grid.template.disabled = true;
	yAxis.renderer.labels.template.disabled = true;
	yAxis.renderer.baseGrid.disabled = true;
	yAxis.tooltip.disabled = true;


	// Create series
	var series = chart.series.push(new am4charts.LineSeries());
	series.dataFields.categoryX = "x";
	series.dataFields.valueY = "y";
	series.strokeWidth = 4;
	series.sequencedInterpolation = true;

	var bullet = series.bullets.push(new am4charts.CircleBullet());
	bullet.setStateOnChildren = true;
	bullet.states.create("hover");
	bullet.circle.radius = 10;
	bullet.circle.states.create("hover").properties.radius = 15;

	var labelBullet = series.bullets.push(new am4charts.LabelBullet());
	labelBullet.setStateOnChildren = true;
	labelBullet.states.create("hover").properties.scale = 1.2;
	labelBullet.label.text = "{text}";
	labelBullet.label.maxWidth = 150;
	labelBullet.label.wrap = true;
	labelBullet.label.truncate = false;
	labelBullet.label.textAlign = "middle";
	labelBullet.label.paddingTop = 20;
	labelBullet.label.paddingBottom = 20;
	labelBullet.label.fill = am4core.color("#999");
	labelBullet.label.states.create("hover").properties.fill = am4core.color("#000");

	labelBullet.label.propertyFields.verticalCenter = "center";


	chart.cursor = new am4charts.XYCursor();
	chart.cursor.lineX.disabled = true;
	chart.cursor.lineY.disabled = true;

	}); // end am4core.ready()
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	am4core.ready(function() {

	// Themes begin
	am4core.useTheme(am4themes_kelly);
	am4core.useTheme(am4themes_animated);
	// Themes end

	var chart = am4core.create("stock-cart", am4charts.XYChart);
	chart.paddingRight = 20;

	chart.dateFormatter.inputDateFormat = "yyyy-MM-dd";

	var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
	dateAxis.renderer.grid.template.location = 0;

	var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
	valueAxis.tooltip.disabled = true;

	var series = chart.series.push(new am4charts.CandlestickSeries());
	series.dataFields.dateX = "date";
	series.dataFields.valueY = "close";
	series.dataFields.openValueY = "open";
	series.dataFields.lowValueY = "low";
	series.dataFields.highValueY = "high";
	series.simplifiedProcessing = true;
	series.tooltipText = "Open:${openValueY.value}\nLow:${lowValueY.value}\nHigh:${highValueY.value}\nClose:${valueY.value}";

	chart.cursor = new am4charts.XYCursor();

	// a separate series for scrollbar
	var lineSeries = chart.series.push(new am4charts.LineSeries());
	lineSeries.dataFields.dateX = "date";
	lineSeries.dataFields.valueY = "close";
	// need to set on default state, as initially series is "show"
	lineSeries.defaultState.properties.visible = false;

	// hide from legend too (in case there is one)
	lineSeries.hiddenInLegend = true;
	lineSeries.fillOpacity = 0.5;
	lineSeries.strokeOpacity = 0.5;

	var scrollbarX = new am4charts.XYChartScrollbar();
	scrollbarX.series.push(lineSeries);
	chart.scrollbarX = scrollbarX;

	chart.data = [ {
		"date": "2011-08-01",
		"open": "136.65",
		"high": "136.96",
		"low": "134.15",
		"close": "136.49"
	  }, {
		"date": "2011-08-02",
		"open": "135.26",
		"high": "135.95",
		"low": "131.50",
		"close": "131.85"
	  }, {
		"date": "2011-08-05",
		"open": "132.90",
		"high": "135.27",
		"low": "128.30",
		"close": "135.25"
	  }, {
		"date": "2011-08-06",
		"open": "134.94",
		"high": "137.24",
		"low": "132.63",
		"close": "135.03"
	  }, {
		"date": "2011-08-07",
		"open": "136.76",
		"high": "136.86",
		"low": "132.00",
		"close": "134.01"
	  }, {
		"date": "2011-08-08",
		"open": "131.11",
		"high": "133.00",
		"low": "125.09",
		"close": "126.39"
	  }, {
		"date": "2011-08-09",
		"open": "123.12",
		"high": "127.75",
		"low": "120.30",
		"close": "125.00"
	  }, {
		"date": "2011-08-12",
		"open": "128.32",
		"high": "129.35",
		"low": "126.50",
		"close": "127.79"
	  }, {
		"date": "2011-08-13",
		"open": "128.29",
		"high": "128.30",
		"low": "123.71",
		"close": "124.03"
	  }, {
		"date": "2011-08-14",
		"open": "122.74",
		"high": "124.86",
		"low": "119.65",
		"close": "119.90"
	  }, {
		"date": "2011-08-15",
		"open": "117.01",
		"high": "118.50",
		"low": "111.62",
		"close": "117.05"
	  }, {
		"date": "2011-08-16",
		"open": "122.01",
		"high": "123.50",
		"low": "119.82",
		"close": "122.06"
	  }, {
		"date": "2011-08-19",
		"open": "123.96",
		"high": "124.50",
		"low": "120.50",
		"close": "122.22"
	  }, {
		"date": "2011-08-20",
		"open": "122.21",
		"high": "128.96",
		"low": "121.00",
		"close": "127.57"
	  }, {
		"date": "2011-08-21",
		"open": "131.22",
		"high": "132.75",
		"low": "130.33",
		"close": "132.51"
	  }, {
		"date": "2011-08-22",
		"open": "133.09",
		"high": "133.34",
		"low": "129.76",
		"close": "131.07"
	  }, {
		"date": "2011-08-23",
		"open": "130.53",
		"high": "135.37",
		"low": "129.81",
		"close": "135.30"
	  }, {
		"date": "2011-08-26",
		"open": "133.39",
		"high": "134.66",
		"low": "132.10",
		"close": "132.25"
	  }, {
		"date": "2011-08-27",
		"open": "130.99",
		"high": "132.41",
		"low": "126.63",
		"close": "126.82"
	  }, {
		"date": "2011-08-28",
		"open": "129.88",
		"high": "134.18",
		"low": "129.54",
		"close": "134.08"
	  }, {
		"date": "2011-08-29",
		"open": "132.67",
		"high": "138.25",
		"low": "132.30",
		"close": "136.25"
	  }, {
		"date": "2011-08-30",
		"open": "139.49",
		"high": "139.65",
		"low": "137.41",
		"close": "138.48"
	  }, {
		"date": "2011-09-03",
		"open": "139.94",
		"high": "145.73",
		"low": "139.84",
		"close": "144.16"
	  }, {
		"date": "2011-09-04",
		"open": "144.97",
		"high": "145.84",
		"low": "136.10",
		"close": "136.76"
	  }, {
		"date": "2011-09-05",
		"open": "135.56",
		"high": "137.57",
		"low": "132.71",
		"close": "135.01"
	  }, {
		"date": "2011-09-06",
		"open": "132.01",
		"high": "132.30",
		"low": "130.00",
		"close": "131.77"
	  }, {
		"date": "2011-09-09",
		"open": "136.99",
		"high": "138.04",
		"low": "133.95",
		"close": "136.71"
	  }, {
		"date": "2011-09-10",
		"open": "137.90",
		"high": "138.30",
		"low": "133.75",
		"close": "135.49"
	  }, {
		"date": "2011-09-11",
		"open": "135.99",
		"high": "139.40",
		"low": "135.75",
		"close": "136.85"
	  }, {
		"date": "2011-09-12",
		"open": "138.83",
		"high": "139.00",
		"low": "136.65",
		"close": "137.20"
	  }, {
		"date": "2011-09-13",
		"open": "136.57",
		"high": "138.98",
		"low": "136.20",
		"close": "138.81"
	  }, {
		"date": "2011-09-16",
		"open": "138.99",
		"high": "140.59",
		"low": "137.60",
		"close": "138.41"
	  }, {
		"date": "2011-09-17",
		"open": "139.06",
		"high": "142.85",
		"low": "137.83",
		"close": "140.92"
	  }, {
		"date": "2011-09-18",
		"open": "143.02",
		"high": "143.16",
		"low": "139.40",
		"close": "140.77"
	  }, {
		"date": "2011-09-19",
		"open": "140.15",
		"high": "141.79",
		"low": "139.32",
		"close": "140.31"
	  }, {
		"date": "2011-09-20",
		"open": "141.14",
		"high": "144.65",
		"low": "140.31",
		"close": "144.15"
	  }, {
		"date": "2011-09-23",
		"open": "146.73",
		"high": "149.85",
		"low": "146.65",
		"close": "148.28"
	  }, {
		"date": "2011-09-24",
		"open": "146.84",
		"high": "153.22",
		"low": "146.82",
		"close": "153.18"
	  }, {
		"date": "2011-09-25",
		"open": "154.47",
		"high": "155.00",
		"low": "151.25",
		"close": "152.77"
	  }, {
		"date": "2011-09-26",
		"open": "153.77",
		"high": "154.52",
		"low": "152.32",
		"close": "154.50"
	  }, {
		"date": "2011-09-27",
		"open": "153.44",
		"high": "154.60",
		"low": "152.75",
		"close": "153.47"
	  }, {
		"date": "2011-09-30",
		"open": "154.63",
		"high": "157.41",
		"low": "152.93",
		"close": "156.34"
	  }, {
		"date": "2011-10-01",
		"open": "156.55",
		"high": "158.59",
		"low": "155.89",
		"close": "158.45"
	  }, {
		"date": "2011-10-02",
		"open": "157.78",
		"high": "159.18",
		"low": "157.01",
		"close": "157.92"
	  }, {
		"date": "2011-10-03",
		"open": "158.00",
		"high": "158.08",
		"low": "153.50",
		"close": "156.24"
	  }, {
		"date": "2011-10-04",
		"open": "158.37",
		"high": "161.58",
		"low": "157.70",
		"close": "161.45"
	  }, {
		"date": "2011-10-07",
		"open": "163.49",
		"high": "167.91",
		"low": "162.97",
		"close": "167.91"
	  }, {
		"date": "2011-10-08",
		"open": "170.20",
		"high": "171.11",
		"low": "166.68",
		"close": "167.86"
	  }, {
		"date": "2011-10-09",
		"open": "167.55",
		"high": "167.88",
		"low": "165.60",
		"close": "166.79"
	  }, {
		"date": "2011-10-10",
		"open": "169.49",
		"high": "171.88",
		"low": "153.21",
		"close": "162.23"
	  }, {
		"date": "2011-10-11",
		"open": "163.01",
		"high": "167.28",
		"low": "161.80",
		"close": "167.25"
	  }, {
		"date": "2011-10-14",
		"open": "167.98",
		"high": "169.57",
		"low": "163.50",
		"close": "166.98"
	  }, {
		"date": "2011-10-15",
		"open": "165.54",
		"high": "170.18",
		"low": "165.15",
		"close": "169.58"
	  }, {
		"date": "2011-10-16",
		"open": "172.69",
		"high": "173.04",
		"low": "169.18",
		"close": "172.75"
	  }];

	}); // end am4core.ready()
	
	
	
	
	am4core.ready(function() {

	// Themes begin
	am4core.useTheme(am4themes_animated);
	// Themes end

	// create chart
	var chart = am4core.create("userflow", am4charts.GaugeChart);
	chart.innerRadius = am4core.percent(82);

	/**
	 * Normal axis
	 */

	var axis = chart.xAxes.push(new am4charts.ValueAxis());
	axis.min = 0;
	axis.max = 100;
	axis.strictMinMax = true;
	axis.renderer.radius = am4core.percent(80);
	axis.renderer.inside = false;
	axis.renderer.line.strokeOpacity = 1;
	axis.renderer.ticks.template.strokeOpacity = 1;
	axis.renderer.ticks.template.length = 10;
	axis.renderer.grid.template.disabled = true;
	axis.renderer.labels.template.radius = 50;
	axis.renderer.labels.template.adapter.add("text", function(text) {
	  return text + "%";
	})

	/**
	 * Axis for ranges
	 */

	var colorSet = new am4core.ColorSet();

	var axis2 = chart.xAxes.push(new am4charts.ValueAxis());
	axis2.min = 0;
	axis2.max = 100;
	axis2.renderer.innerRadius = 10
	axis2.strictMinMax = true;
	axis2.renderer.labels.template.disabled = true;
	axis2.renderer.ticks.template.disabled = true;
	axis2.renderer.grid.template.disabled = true;

	var range0 = axis2.axisRanges.create();
	range0.value = 0;
	range0.endValue = 50;
	range0.axisFill.fillOpacity = 1;
	range0.axisFill.fill = colorSet.getIndex(0);

	var range1 = axis2.axisRanges.create();
	range1.value = 50;
	range1.endValue = 100;
	range1.axisFill.fillOpacity = 1;
	range1.axisFill.fill = colorSet.getIndex(2);

	/**
	 * Label
	 */

	var label = chart.radarContainer.createChild(am4core.Label);
	label.isMeasured = false;
	label.fontSize = 24;
	label.x = am4core.percent(50);
	label.y = am4core.percent(100);
	label.horizontalCenter = "middle";
	label.verticalCenter = "bottom";
	label.text = "30%";


	/**
	 * Hand
	 */

	var hand = chart.hands.push(new am4charts.ClockHand());
	hand.axis = axis2;
	hand.innerRadius = am4core.percent(20);
	hand.startWidth = 10;
	hand.pin.disabled = true;
	hand.value = 50;

	hand.events.on("propertychanged", function(ev) {
	  range0.endValue = ev.target.value;
	  range1.value = ev.target.value;
	  axis2.invalidate();
	});

	setInterval(() => {
	  var value = Math.round(Math.random() * 100);
	  label.text = value + "%";
	  var animation = new am4core.Animation(hand, {
		property: "value",
		to: value
	  }, 1000, am4core.ease.cubicOut).start();
	}, 2000);

	}); // end am4core.ready()
	
	
	
	
	
	
	
	var ts2 = 1484418600000;
    var dates = [];
    var spikes = [5, -5, 3, -3, 8, -8]
    for (var i = 0; i < 120; i++) {
      ts2 = ts2 + 86400000;
      var innerArr = [ts2, dataSeries[1][i].value];
      dates.push(innerArr)
    }

    var options = {
      chart: {
        type: 'area',
        stacked: false,
        height: 485,
        zoom: {
          type: 'x',
          enabled: true
        },
        toolbar: {
          autoSelected: 'zoom'
        }
      },
      dataLabels: {
        enabled: false
      },
      series: [{
        name: 'XYZ MOTORS',
        data: dates
      }],
      markers: {
        size: 0,
      },
      title: {
        text: 'Stock Price Movement',
        align: 'left'
      },
	  colors: ['#e2bb33'],
      fill: {
        type: 'gradient',
        gradient: {
          shadeIntensity: 1,
          inverseColors: false,
          opacityFrom: 0.5,
          opacityTo: 0,
          stops: [0, 90, 100]
        },
      },
      yaxis: {
        min: 20000000,
        max: 250000000,
        labels: {
          formatter: function (val) {
            return (val / 1000000).toFixed(0);
          },
        },
        title: {
          text: 'Price'
        },
      },
      xaxis: {
        type: 'datetime',
      },

      tooltip: {
        shared: false,
        y: {
          formatter: function (val) {
            return (val / 1000000).toFixed(0)
          }
        }
      }
    }

    var chart = new ApexCharts(
      document.querySelector("#bitcoin-chart"),
      options
    );

    chart.render();
  
	
}); // End of use strict

