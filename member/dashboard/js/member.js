var month = [
  'ม.ค.',
  'ก.พ.',
  'มี.ค.',
  'เม.ย',
  'พ.ค.',
  'มิ.ย.',
  'ก.ค.',
  'ส.ค.',
  'ก.ย.',
  'ต.ค.',
  'พ.ย.',
  'ธ.ค.',
]

function getgold_graph(){
  $.ajax({
    method: "POST",
    url: "functions/get-goldgraph.php",
    dataType: 'json',
    success:function(result){
      // let use_month = month.slice(0,result.length)
      let arr_label = []
      let result_arr = []
      result.forEach(ele => {
        let txt_label = ele['MONTH(create_date)']+"/"+ele['YEAR(create_date)']
        arr_label.push(txt_label)
        result_arr.push(ele['COUNT(create_date)'])
      });
         
      let areaChartData2 = {
        labels  : arr_label,
        datasets: [
          {
            label               : 'สมาชิกร้านทอง',
            backgroundColor     : '#ffc107',
            borderColor         : '#ffc107',
            pointRadius          : false,
            pointColor          : '#3b8bba',
            pointStrokeColor    : 'rgba(60,141,188,1)',
            pointHighlightFill  : '#fff',
            pointHighlightStroke: 'rgba(60,141,188,1)',
            data                : result_arr
          },
        ]
      }
      let stackedBarChartCanvas2 = $('#stackedBarChart2').get(0).getContext('2d')
      let stackedBarChartData2 = $.extend(true, {}, areaChartData2)

      let stackedBarChartOptions = {
        responsive              : true,
        maintainAspectRatio     : false,
        scales: {
          xAxes: [{
            stacked: true,
          }],
          yAxes: [{
            stacked: true
          }]
        }
      }

      new Chart(stackedBarChartCanvas2, {
        type: 'bar',
        data: stackedBarChartData2,
        options: stackedBarChartOptions
      })
    },
    error:function(textStatus){
      console.log(textStatus.responseText)
    }
  })
}

function getjewelry_graph(){
  $.ajax({
    method: "POST",
    url: "functions/get-jewelrygraph.php",
    dataType: 'json',
    success:function(result){
      // let use_month = month.slice(0,result.length)

      let arr_label = []
      let result_arr = []
      result.forEach(ele => {
        let txt_label = ele['MONTH(create_date)']+"/"+ele['YEAR(create_date)']
        arr_label.push(txt_label)
        result_arr.push(ele['COUNT(create_date)'])
      });
     
      let areaChartData3 = {
        labels  : arr_label,
        datasets: [
          {
            label               : 'สมาชิกร้านเพชร',
            backgroundColor     : '#dc3545',
            borderColor         : '#dc3545',
            pointRadius          : false,
            pointColor          : '#3b8bba',
            pointStrokeColor    : 'rgba(60,141,188,1)',
            pointHighlightFill  : '#fff',
            pointHighlightStroke: 'rgba(60,141,188,1)',
            data                : result_arr
          },
        ]
      }
      let stackedBarChartCanvas3 = $('#stackedBarChart3').get(0).getContext('2d')
      let stackedBarChartData3 = $.extend(true, {}, areaChartData3)

      let stackedBarChartOptions = {
        responsive              : true,
        maintainAspectRatio     : false,
        scales: {
          xAxes: [{
            stacked: true,
          }],
          yAxes: [{
            stacked: true
          }]
        }
      }

      new Chart(stackedBarChartCanvas3, {
        type: 'bar',
        data: stackedBarChartData3,
        options: stackedBarChartOptions
      })
    },
    error:function(textStatus){
      console.log(textStatus.responseText)
    }
  })
}