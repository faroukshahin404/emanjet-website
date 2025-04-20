//[Dashboard Javascript]

//Project:	CrmX Admin - Responsive Admin Template
//Primary use:   Used only for the main dashboard (index.html)


$(function () {

  'use strict';
	var options = {
      annotations: {
        yaxis: [{
          y: 30,
          borderColor: '#999',
          label: {
            show: true,
            text: 'Support',
            style: {
              color: "#fff",
              background: '#00E396'
            }
          }
        }],
        xaxis: [{
          x: new Date('14 Nov 2012').getTime(),
          borderColor: '#999',
          yAxisIndex: 0,
          label: {
            show: true,
            text: 'Rally',
            style: {
              color: "#fff",
              background: '#775DD0'
            }
          }
        }]
      },
      chart: {
        type: 'area',
        height: 400,
      },
      dataLabels: {
        enabled: false
      },
      series: [{
          data: [
            [1327359600000,30.95],
            [1327446000000,31.34],
            [1327532400000,31.18],
            [1327618800000,31.05],
            [1327878000000,31.00],
            [1327964400000,30.95],
            [1328050800000,31.24],
            [1328137200000,31.29],
            [1328223600000,31.85],
            [1328482800000,31.86],
            [1328569200000,32.28],
            [1328655600000,32.10],
            [1328742000000,32.65],
            [1328828400000,32.21],
            [1329087600000,32.35],
            [1329174000000,32.44],
            [1329260400000,32.46],
            [1329346800000,32.86],
            [1329433200000,32.75],
            [1329778800000,32.54],
            [1329865200000,32.33],
            [1329951600000,32.97],
            [1330038000000,33.41],
            [1330297200000,33.27],
            [1330383600000,33.27],
            [1330470000000,32.89],
            [1330556400000,33.10],
            [1330642800000,33.73],
            [1330902000000,33.22],
            [1330988400000,31.99],
            [1331074800000,32.41],
            [1331161200000,33.05],
            [1331247600000,33.64],
            [1331506800000,33.56],
            [1331593200000,34.22],
            [1331679600000,33.77],
            [1331766000000,34.17],
            [1331852400000,33.82],
            [1332111600000,34.51],
            [1332198000000,33.16],
            [1332284400000,33.56],
            [1332370800000,33.71],
            [1332457200000,33.81],
            [1332712800000,34.40],
            [1332799200000,34.63],
            [1332885600000,34.46],
            [1332972000000,34.48],
            [1333058400000,34.31],
            [1333317600000,34.70],
            [1333404000000,34.31],
            [1333490400000,33.46],
            [1333576800000,33.59],
            [1333922400000,33.22],
            [1334008800000,32.61],
            [1334095200000,33.01],
            [1334181600000,33.55],
            [1334268000000,33.18],
            [1334527200000,32.84],
            [1334613600000,33.84],
            [1334700000000,33.39],
            [1334786400000,32.91],
            [1334872800000,33.06],
            [1335132000000,32.62],
            [1335218400000,32.40],
            [1335304800000,33.13],
            [1335391200000,33.26],
            [1335477600000,33.58],
            [1335736800000,33.55],
            [1335823200000,33.77],
            [1335909600000,33.76],
            [1335996000000,33.32],
            [1336082400000,32.61],
            [1336341600000,32.52],
            [1336428000000,32.67],
            [1336514400000,32.52],
            [1336600800000,31.92],
            [1336687200000,32.20],
            [1336946400000,32.23],
            [1337032800000,32.33],
            [1337119200000,32.36],
            [1337205600000,32.01],
            [1337292000000,31.31],
            [1337551200000,32.01],
            [1337637600000,32.01],
            [1337724000000,32.18],
            [1337810400000,31.54],
            [1337896800000,31.60],
            [1338242400000,32.05],
            [1338328800000,31.29],
            [1338415200000,31.05],
            [1338501600000,29.82],
            [1338760800000,30.31],
            [1338847200000,30.70],
            [1338933600000,31.69],
            [1339020000000,31.32],
            [1339106400000,31.65],
            [1339365600000,31.13],
            [1339452000000,31.77],
            [1339538400000,31.79],
            [1339624800000,31.67],
            [1339711200000,32.39],
            [1339970400000,32.63],
            [1340056800000,32.89],
            [1340143200000,31.99],
            [1340229600000,31.23],
            [1340316000000,31.57],
            [1340575200000,30.84],
            [1340661600000,31.07],
            [1340748000000,31.41],
            [1340834400000,31.17],
            [1340920800000,32.37],
            [1341180000000,32.19],
            [1341266400000,32.51],
            [1341439200000,32.53],
            [1341525600000,31.37],
            [1341784800000,30.43],
            [1341871200000,30.44],
            [1341957600000,30.20],
            [1342044000000,30.14],
            [1342130400000,30.65],
            [1342389600000,30.40],
            [1342476000000,30.65],
            [1342562400000,31.43],
            [1342648800000,31.89],
            [1342735200000,31.38],
            [1342994400000,30.64],
            [1343080800000,30.02],
            [1343167200000,30.33],
            [1343253600000,30.95],
            [1343340000000,31.89],
            [1343599200000,31.01],
            [1343685600000,30.88],
            [1343772000000,30.69],
            [1343858400000,30.58],
            [1343944800000,32.02],
            [1344204000000,32.14],
            [1344290400000,32.37],
            [1344376800000,32.51],
            [1344463200000,32.65],
            [1344549600000,32.64],
            [1344808800000,32.27],
            [1344895200000,32.10],
            [1344981600000,32.91],
            [1345068000000,33.65],
            [1345154400000,33.80],
            [1345413600000,33.92],
            [1345500000000,33.75],
            [1345586400000,33.84],
            [1345672800000,33.50],
            [1345759200000,32.26],
            [1346018400000,32.32],
            [1346104800000,32.06],
            [1346191200000,31.96],
            [1346277600000,31.46],
            [1346364000000,31.27],
            [1346709600000,31.43],
            [1346796000000,32.26],
            [1346882400000,32.79],
            [1346968800000,32.46],
            [1347228000000,32.13],
            [1347314400000,32.43],
            [1347400800000,32.42],
            [1347487200000,32.81],
            [1347573600000,33.34],
            [1347832800000,33.41],
            [1347919200000,32.57],
            [1348005600000,33.12],
            [1348092000000,34.53],
            [1348178400000,33.83],
            [1348437600000,33.41],
            [1348524000000,32.90],
            [1348610400000,32.53],
            [1348696800000,32.80],
            [1348783200000,32.44],
            [1349042400000,32.62],
            [1349128800000,32.57],
            [1349215200000,32.60],
            [1349301600000,32.68],
            [1349388000000,32.47],
            [1349647200000,32.23],
            [1349733600000,31.68],
            [1349820000000,31.51],
            [1349906400000,31.78],
            [1349992800000,31.94],
            [1350252000000,32.33],
            [1350338400000,33.24],
            [1350424800000,33.44],
            [1350511200000,33.48],
            [1350597600000,33.24],
            [1350856800000,33.49],
            [1350943200000,33.31],
            [1351029600000,33.36],
            [1351116000000,33.40],
            [1351202400000,34.01],
            [1351638000000,34.02],
            [1351724400000,34.36],
            [1351810800000,34.39],
            [1352070000000,34.24],
            [1352156400000,34.39],
            [1352242800000,33.47],
            [1352329200000,32.98],
            [1352415600000,32.90],
            [1352674800000,32.70],
            [1352761200000,32.54],
            [1352847600000,32.23],
            [1352934000000,32.64],
            [1353020400000,32.65],
            [1353279600000,32.92],
            [1353366000000,32.64],
            [1353452400000,32.84],
            [1353625200000,33.40],
            [1353884400000,33.30],
            [1353970800000,33.18],
            [1354057200000,33.88],
            [1354143600000,34.09],
            [1354230000000,34.61],
            [1354489200000,34.70],
            [1354575600000,35.30],
            [1354662000000,35.40],
            [1354748400000,35.14],
            [1354834800000,35.48],
            [1355094000000,35.75],
            [1355180400000,35.54],
            [1355266800000,35.96],
            [1355353200000,35.53],
            [1355439600000,37.56],
            [1355698800000,37.42],
            [1355785200000,37.49],
            [1355871600000,38.09],
            [1355958000000,37.87],
            [1356044400000,37.71],
            [1356303600000,37.53],
            [1356476400000,37.55],
            [1356562800000,37.30],
            [1356649200000,36.90],
            [1356908400000,37.68],
            [1357081200000,38.34],
            [1357167600000,37.75],
            [1357254000000,38.13],
            [1357513200000,37.94],
            [1357599600000,38.14],
            [1357686000000,38.66],
            [1357772400000,38.62],
            [1357858800000,38.09],
            [1358118000000,38.16],
            [1358204400000,38.15],
            [1358290800000,37.88],
            [1358377200000,37.73],
            [1358463600000,37.98],
            [1358809200000,37.95],
            [1358895600000,38.25],
            [1358982000000,38.10],
            [1359068400000,38.32],
            [1359327600000,38.24],
            [1359414000000,38.52],
            [1359500400000,37.94],
            [1359586800000,37.83],
            [1359673200000,38.34],
            [1359932400000,38.10],
            [1360018800000,38.51],
            [1360105200000,38.40],
            [1360191600000,38.07],
            [1360278000000,39.12],
            [1360537200000,38.64],
            [1360623600000,38.89],
            [1360710000000,38.81],
            [1360796400000,38.61],
            [1360882800000,38.63],
            [1361228400000,38.99],
            [1361314800000,38.77],
            [1361401200000,38.34],
            [1361487600000,38.55],
            [1361746800000,38.11],
            [1361833200000,38.59],
            [1361919600000,39.60],
          ]
        },

      ],
	  colors: ['#e2bb33'],
      markers: {
        size: 0,
        style: 'hollow',
      },
      xaxis: {
        type: 'datetime',
        min: new Date('01 Mar 2012').getTime(),
        tickAmount: 6,
      },
      tooltip: {
        x: {
          format: 'dd MMM yyyy'
        }
      },
      fill: {
        type: 'gradient',
        gradient: {
          shadeIntensity: 1,
          opacityFrom: 0.7,
          opacityTo: 0.9,
          stops: [0, 100]
        }
      },

    }

    var chart = new ApexCharts(
      document.querySelector("#timeline-chart"),
      options
    );

    chart.render();

    var resetCssClasses = function (activeEl) {
      var els = document.querySelectorAll("button");
      Array.prototype.forEach.call(els, function (el) {
        el.classList.remove('active');
      });

      activeEl.target.classList.add('active')
    }

    document.querySelector("#one_month").addEventListener('click', function (e) {
      resetCssClasses(e)
      chart.updateOptions({
        xaxis: {
          min: new Date('28 Jan 2013').getTime(),
          max: new Date('27 Feb 2013').getTime(),
        }
      })
    })

    document.querySelector("#six_months").addEventListener('click', function (e) {
      resetCssClasses(e)
      chart.updateOptions({
        xaxis: {
          min: new Date('27 Sep 2012').getTime(),
          max: new Date('27 Feb 2013').getTime(),
        }
      })
    })

    document.querySelector("#one_year").addEventListener('click', function (e) {
      resetCssClasses(e)
      chart.updateOptions({
        xaxis: {
          min: new Date('27 Feb 2012').getTime(),
          max: new Date('27 Feb 2013').getTime(),
        }
      })
    })

    document.querySelector("#ytd").addEventListener('click', function (e) {
      resetCssClasses(e)
      chart.updateOptions({
        xaxis: {
          min: new Date('01 Jan 2013').getTime(),
          max: new Date('27 Feb 2013').getTime(),
        }
      })
    })

    document.querySelector("#all").addEventListener('click', function (e) {
      resetCssClasses(e)
      chart.updateOptions({
        xaxis: {
          min: undefined,
          max: undefined,
        }
      })
    })

    document.querySelector("#ytd").addEventListener('click', function () {

    })
	
	
	
	
	var options = {
      annotations: {
        yaxis: [{
          y: 8200,
          borderColor: '#00E396',
          label: {
            borderColor: '#00E396',
            style: {
              color: '#fff',
              background: '#00E396',
            },
            text: 'Support',
          }
        }, {
          y: 8600,
          y2: 9000,
          borderColor: '#000',
          fillColor: '#FEB019',
          opacity: 0.2,
          label: {
            borderColor: '#333',
            style: {
              fontSize: '10px',
              color: '#333',
              background: '#FEB019',
            },
            text: 'Y-axis range',
          }
        }],
        xaxis: [{
          x: new Date('23 Nov 2017').getTime(),
          strokeDashArray: 0,
          borderColor: '#775DD0',
          label: {
            borderColor: '#775DD0',
            style: {
              color: '#fff',
              background: '#775DD0',
            },
            text: 'Anno Test',
          }
        }, {
          x: new Date('26 Nov 2017').getTime(),
          x2: new Date('28 Nov 2017').getTime(),
          fillColor: '#B3F7CA',
          opacity: 0.4,
          label: {
            borderColor: '#B3F7CA',
            style: {
              fontSize: '10px',
              color: '#fff',
              background: '#00E396',
            },
            offsetY: -10,
            text: 'X-axis range',
          }
        }],
        points: [{
          x: new Date('01 Dec 2017').getTime(),
          y: 8607.55,
          marker: {
            size: 8,
            fillColor: '#fff',
            strokeColor: 'red',
            radius: 2,
            cssClass: 'apexcharts-custom-class'
          },
          label: {
            borderColor: '#FF4560',
            offsetY: 0,
            style: {
              color: '#fff',
              background: '#FF4560',
            },

            text: 'Point Annotation',
          }
        }]
      },
      chart: {
        height: 425,
        type: 'line',
        id: 'areachart-2'
      },
      dataLabels: {
        enabled: false
      },
      stroke: {
        curve: 'straight'
      },
      grid: {
        padding: {
          right: 30,
          left: 20
        }
      },
	  colors: ['#689f38', '#ff8f00'],
      series: [{
        data: series.monthDataSeries1.prices
      }],
      title: {
        text: 'Line with Annotations',
        align: 'left'
      },
      labels: series.monthDataSeries1.dates,
      xaxis: {
        type: 'datetime',
      },
    }

    var chart = new ApexCharts(
      document.querySelector("#crypto-anno"),
      options
    );

    chart.render();
	
	
	
	
	
	am4core.ready(function() {

	// Themes begin
	am4core.useTheme(am4themes_kelly);
	am4core.useTheme(am4themes_animated);
	// Themes end

	// Create chart instance
	var chart = am4core.create("market-chart", am4charts.XYChart);

	chart.colors.step = 2;
	chart.maskBullets = false;

	// Add data
	chart.data = [{
		"date": "2012-01-01",
		"distance": 227,
		"currency": "Bitcoin",
		"currency2": "Bitcoin",
		"currencySize": 12,
		"price": 40.71,
		"duration": 408
	}, {
		"date": "2012-01-02",
		"distance": 371,
		"currency": "Cardano",
		"currencySize": 7,
		"price": 38.89,
		"duration": 482
	}, {
		"date": "2012-01-03",
		"distance": 433,
		"currency": "Tether",
		"currencySize": 3,
		"price": 34.22,
		"duration": 562
	}, {
		"date": "2012-01-04",
		"distance": 345,
		"currency": "Binance Coin",
		"currencySize": 3.5,
		"price": 30.35,
		"duration": 379
	}, {
		"date": "2012-01-05",
		"distance": 480,
		"currency": "ZRX",
		"currency2": "ZRX",
		"currencySize": 5,
		"price": 25.83,
		"duration": 501
	}, {
		"date": "2012-01-06",
		"distance": 386,
		"currency": "Augur",
		"currencySize": 3.5,
		"price": 30.46,
		"duration": 443
	}, {
		"date": "2012-01-07",
		"distance": 348,
		"currency": "USD Coin",
		"currencySize": 5,
		"price": 29.94,
		"duration": 405
	}, {
		"date": "2012-01-08",
		"distance": 238,
		"currency": "Zcash",
		"currency2": "Zcash",
		"currencySize": 8,
		"price": 29.76,
		"duration": 309
	}, {
		"date": "2012-01-09",
		"distance": 218,
		"currency": "Basic Attention Token",
		"currencySize": 8,
		"price": 32.8,
		"duration": 287
	}, {
		"date": "2012-01-10",
		"distance": 349,
		"currency": "Ethereum Classic",
		"currencySize": 5,
		"price": 35.49,
		"duration": 485
	}, {
		"date": "2012-01-11",
		"distance": 603,
		"currency": "Stellar Lumens",
		"currencySize": 5,
		"price": 39.1,
		"duration": 890
	}, {
		"date": "2012-01-12",
		"distance": 534,
		"currency": "Litecoin",
		"currency2": "Litecoin",
		"currencySize": 9,
		"price": 39.74,
		"duration": 810
	}, {
		"date": "2012-01-13",
		"currency": "Bitcoin Cash",
		"currencySize": 6,
		"distance": 425,
		"duration": 670,
		"price": 40.75,
		"dashLength": 8,
		"alpha": 0.4
	}, {
		"date": "2012-01-14",
		"price": 36.1,
		"duration": 470,
		"currency": "Ethereum",
		"currency2": "Ethereum"
	}, {
		"date": "2012-01-15"
	}, {
		"date": "2012-01-16"
	}, {
		"date": "2012-01-17"
	}];

	// Create axes
	var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
	dateAxis.renderer.grid.template.location = 0;
	dateAxis.renderer.minGridDistance = 50;
	dateAxis.renderer.grid.template.disabled = true;
	dateAxis.renderer.fullWidthTooltip = true;

	var distanceAxis = chart.yAxes.push(new am4charts.ValueAxis());
	distanceAxis.title.text = "Distance";
	distanceAxis.renderer.grid.template.disabled = true;

	var durationAxis = chart.yAxes.push(new am4charts.DurationAxis());
	durationAxis.title.text = "Duration";
	durationAxis.baseUnit = "minute";
	durationAxis.renderer.grid.template.disabled = true;
	durationAxis.renderer.opposite = true;

	durationAxis.durationFormatter.durationFormat = "hh'h' mm'min'";

	var latitudeAxis = chart.yAxes.push(new am4charts.ValueAxis());
	latitudeAxis.renderer.grid.template.disabled = true;
	latitudeAxis.renderer.labels.template.disabled = true;

	// Create series
	var distanceSeries = chart.series.push(new am4charts.ColumnSeries());
	distanceSeries.dataFields.valueY = "distance";
	distanceSeries.dataFields.dateX = "date";
	distanceSeries.yAxis = distanceAxis;
	distanceSeries.tooltipText = "{valueY} miles";
	distanceSeries.name = "Market";
	distanceSeries.columns.template.fillOpacity = 0.7;
	distanceSeries.columns.template.propertyFields.strokeDasharray = "dashLength";
	distanceSeries.columns.template.propertyFields.fillOpacity = "alpha";

	var disatnceState = distanceSeries.columns.template.states.create("hover");
	disatnceState.properties.fillOpacity = 0.9;

	var durationSeries = chart.series.push(new am4charts.LineSeries());
	durationSeries.dataFields.valueY = "duration";
	durationSeries.dataFields.dateX = "date";
	durationSeries.yAxis = durationAxis;
	durationSeries.name = "Duration";
	durationSeries.strokeWidth = 2;
	durationSeries.propertyFields.strokeDasharray = "dashLength";
	durationSeries.tooltipText = "{valueY.formatDuration()}";

	var durationBullet = durationSeries.bullets.push(new am4charts.Bullet());
	var durationRectangle = durationBullet.createChild(am4core.Rectangle);
	durationBullet.horizontalCenter = "middle";
	durationBullet.verticalCenter = "middle";
	durationBullet.width = 7;
	durationBullet.height = 7;
	durationRectangle.width = 7;
	durationRectangle.height = 7;

	var durationState = durationBullet.states.create("hover");
	durationState.properties.scale = 1.2;

	var latitudeSeries = chart.series.push(new am4charts.LineSeries());
	latitudeSeries.dataFields.valueY = "price";
	latitudeSeries.dataFields.dateX = "date";
	latitudeSeries.yAxis = latitudeAxis;
	latitudeSeries.name = "Duration";
	latitudeSeries.strokeWidth = 2;
	latitudeSeries.propertyFields.strokeDasharray = "dashLength";
	latitudeSeries.tooltipText = "Price: {valueY} ({currency})";

	var latitudeBullet = latitudeSeries.bullets.push(new am4charts.CircleBullet());
	latitudeBullet.circle.fill = am4core.color("#fff");
	latitudeBullet.circle.strokeWidth = 2;
	latitudeBullet.circle.propertyFields.radius = "currencySize";

	var latitudeState = latitudeBullet.states.create("hover");
	latitudeState.properties.scale = 1.2;

	var latitudeLabel = latitudeSeries.bullets.push(new am4charts.LabelBullet());
	latitudeLabel.label.text = "{currency2}";
	latitudeLabel.label.horizontalCenter = "left";
	latitudeLabel.label.dx = 14;

	// Add legend
	chart.legend = new am4charts.Legend();

	// Add cursor
	chart.cursor = new am4charts.XYCursor();
	chart.cursor.fullWidthLineX = true;
	chart.cursor.xAxis = dateAxis;
	chart.cursor.lineX.strokeOpacity = 0;
	chart.cursor.lineX.fill = am4core.color("#000");
	chart.cursor.lineX.fillOpacity = 0.1;

	}); // end am4core.ready()
	
	
	
	am4core.ready(function() {

	// Themes begin
	am4core.useTheme(am4themes_kelly);
	am4core.useTheme(am4themes_animated);
	// Themes end

	// Create chart instance
	var chart = am4core.create("topcity", am4charts.PieChart);

	// Add and configure Series
	var pieSeries = chart.series.push(new am4charts.PieSeries());
	pieSeries.dataFields.value = "litres";
	pieSeries.dataFields.category = "country";

	// Let's cut a hole in our Pie chart the size of 30% the radius
	chart.innerRadius = am4core.percent(30);

	// Put a thick white border around each Slice
	pieSeries.slices.template.stroke = am4core.color("#fff");
	pieSeries.slices.template.strokeWidth = 2;
	pieSeries.slices.template.strokeOpacity = 1;
	pieSeries.slices.template
	  // change the cursor on hover to make it apparent the object can be interacted with
	  .cursorOverStyle = [
		{
		  "property": "cursor",
		  "value": "pointer"
		}
	  ];

	pieSeries.alignLabels = false;
	pieSeries.labels.template.bent = true;
	pieSeries.labels.template.radius = 3;
	pieSeries.labels.template.padding(0,0,0,0);

	pieSeries.ticks.template.disabled = true;

	// Create a base filter effect (as if it's not there) for the hover to return to
	var shadow = pieSeries.slices.template.filters.push(new am4core.DropShadowFilter);
	shadow.opacity = 0;

	// Create hover state
	var hoverState = pieSeries.slices.template.states.getKey("hover"); // normally we have to create the hover state, in this case it already exists

	// Slightly shift the shadow and make it more prominent on hover
	var hoverShadow = hoverState.filters.push(new am4core.DropShadowFilter);
	hoverShadow.opacity = 0.7;
	hoverShadow.blur = 5;

	// Add a legend
	chart.legend = new am4charts.Legend();
	chart.legend.position = "right";
	chart.legend.valign = "bottom";

	chart.data = [{
	  "country": "ABC",
	  "litres": 501.9
	},{
	  "country": "DEF",
	  "litres": 165.8
	}, {
	  "country": "GHI",
	  "litres": 139.9
	}, {
	  "country": "JKL",
	  "litres": 128.3
	}, {
	  "country": "MNO",
	  "litres": 99
	}, {
	  "country": "PQR",
	  "litres": 60
	}];

	}); // end am4core.ready()
  
	
}); // End of use strict

