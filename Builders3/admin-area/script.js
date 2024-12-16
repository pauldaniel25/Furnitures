var barChartOptions = {
    series: [{
    data: [50,50,50,50,50,50]
  }],
    chart: {
    type: 'bar',
    height: 350,
    toolbar:{
        show:false
    },
  },
  colors:[
"#246dec",
"#cc3c43",
"#367952",
"#f5b74f",
"#4f35a1",
"#378370"
  ],
  plotOptions: {
    bar: {
        distributed:true,
      borderRadius: 4,
      borderRadiusApplication: 'end',
      horizontal: false,
      columnWidth:'40%',
    }
  },
  dataLabels: {
    enabled: false
  },
  legend:{
    show:false
  },
  xaxis: {
    categories: ['Monday', 'Tuesday', 'Wendesday', 'Thursday', 'Friday',  'Saturday'
    ],
  },
  yaxis:{
    title:{
        text:"Count"
    }
  }
  };

  var barChart = new ApexCharts(document.querySelector("#bar-chart"),barChartOptions);
  barChart.render();

  var areaChartsOption = {
    series: [{
    name: 'Orders',
  
    data: [44, 55, 31, 47, 31, 43, 33]
  }, {
    name: 'Revenue',
  
    data: [55, 69, 45, 61, 43, 54, 43]
  }],
    chart: {
    height: 350,
    type: 'area',
    toolbar:{
        show:false,
    },
  },
  colors:["#378370","#367952",],
  dataLabels:{
    enabled:false,
  },
  stroke: {
    curve: 'smooth'
  },
 
  labels: ['jan', 'feb','mar'],
  markers: {
    size: 0
  },
  yaxis: [
    {
      title: {
        text: 'Orders',
      },
    },
    {
      opposite: true,
      title: {
        text: 'Revenue',
      },
    },
  ],
  tooltip: {
    shared: true,
    intersect: false,
    
  }
  };

  var areaChart = new ApexCharts(document.querySelector("#area-chart"), areaChartsOption);
  areaChart.render();

document.getElementById('menu-btn').addEventListener('click', function() {
    document.getElementById('menu').classList.toggle('collapsed');
    document.getElementById('interface').classList.toggle('expanded');
});