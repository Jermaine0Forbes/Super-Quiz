/*================
  Ajax
=================*/

/* Variables  */
  let csrf = $('meta[name="csrf-token"]').attr('content');
  

/* Functions  */
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
