
/*================
  Functions
=================*/

function log(log){
  console.log(log)
}

function foo(){
  console.log("foo")
}


function createP(text , classes = null, ids = null, styles = null){
   let cl = classes ? `class='${classes}'`: '',
       id = ids ? `id='${ids}'` :'',
       style = styles ? `style='${styles}'` : '';

  return `<p ${cl} ${id} ${style}> ${text} </p>`;
}


function booty(){
  return "foo";
}

/*================
  Charts
=================*/

function createChart(_id = null, correct, wrong){
  let id = _id || "there is no id";
  let total = Number(correct) + Number(wrong);

  var ctx = document.getElementById(id).getContext('2d');
  var myChart = new Chart(ctx, {
      type: 'pie',
      data: {
          labels: [ 'Correct','Wrong'],
          datasets: [{
              label: '# of Questions',
              data: [correct, wrong],
              backgroundColor: [
                'rgba(0, 153, 51,0.4)',
                  'rgba(255, 99, 132, 0.4)',
              ],
              // borderColor: [
              //   'rgba(0, 153, 51,1)',
              //     'rgba(255, 99, 132, 1)',
              // ],
              // borderWidth: 1
          }]
      },
      options: {
        responsive:true,
        cutoutPercentage:25,
        tooltips: {
            callbacks: {
              label: function(tooltipItem, data) {
                 let percentage = ((data['datasets'][0]['data'][tooltipItem['index']] / total) * 100);
                 console.log(total)
                return data['labels'][tooltipItem['index']] + ': ' + percentage.toFixed(1) + '%';
              }
            }
          }
          // scales: {
          //     yAxes: [{
          //         ticks: {
          //             beginAtZero: false
          //         }
          //     }]
          // }
      },
    //   plugins: {
    //     datalabels: {
    //         formatter: (value, ctx) => {
    //             let sum = 0;
    //             let dataArr = ctx.chart.data.datasets[0].data;
    //             dataArr.map(data => {
    //                 sum += data;
    //             });
    //             let percentage = (value*100 / sum).toFixed(2)+"%";
    //             log("foo")
    //             return percentage;
    //         },
    //         color: '#fff',
    //     }
    // }
  });
}

function runChart(){

  var ctx = document.getElementById('myChart').getContext('2d');
  // var ctx = document.getElementById('myChart').getContext('2d');
  var myChart = new Chart(ctx, {
      type: 'pie',
      data: {
          labels: ['Wrong', 'Correct'],
          datasets: [{
              label: '# of Questions',
              data: [12, 19],
              backgroundColor: [
                  'rgba(255, 99, 132, 0.2)',
                  'rgba(54, 162, 235, 0.2)',
              ],
              borderColor: [
                  'rgba(255, 99, 132, 1)',
                  'rgba(54, 162, 235, 1)',
              ],
              borderWidth: 1
          }]
      },
      options: {
          scales: {
              yAxes: [{
                  ticks: {
                      beginAtZero: true
                  }
              }]
          }
      }
  });
}

/*================
  Ajax
=================*/

const getQuestData = (o) => {
   if(getQuestData.fired) return;

   $.ajax({
     method:"get",
     data:o.data,
     url:"/api/question/"+o.id,
     headers:{
         "X-CSRF-TOKEN":o.csrf
     },
     error:(e)=>{
       console.log(e)
     },
     success:(e)=>{
       o.loader.slideUp(300).addClass("loaded")
      o.answer.html(e.answer)
      o.meta.append(e.meta)
       createChart(o.chartId,e.correct,e.wrong)
       o.chart.slideDown(300)
       console.log(e)
     }
   });

   // getQuestData.fired = true;
}
