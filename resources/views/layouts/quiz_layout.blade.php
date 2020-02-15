<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>{{$title}} | Quiz</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.quilljs.com/1.3.6/quill.snow.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.2/animate.min.css">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" ></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>

    <!-- Main Quill library -->
    <script src="//cdn.quilljs.com/1.3.6/quill.js"></script>
    <script src="{{asset('js/root.js')}}"></script>
    {{-- <script src="//cdn.quilljs.com/1.3.6/quill.min.js"></script> --}}
    {{-- <script src="//cdn.quilljs.com/1.3.6/quill.core.js"></script> --}}

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
  </head>
  <body>
    @include('components.header')
    @yield("content")
  </body>
  <script type="text/javascript">
    (function(){



      var   btnOption = $("#btn-options"),
            csrf = $('meta[name="csrf-token"]').attr('content'),
            questCont = $(".question-container"),
            questItem = $(".question-item"),
            questSet = $(".question-settings"),
            questNumber = 0,
            quizData = {
                  type:"guess",
                  completed: 0,
                  correct: 0,
                  timed: 0,
                  minutes:0,
                  questions:{},
                  ids:[],
                  answers:[]
                };

          questItem.on("click",function(e){
              let tag = e.target.localName,
                  span = "span.chevron",
                  toggleDown = false,
                  data = e.currentTarget.dataset,
                  chartId = "chart-"+data.id,
                  className = "dropdown-btn",
                  btnPressed = e.target.classList.contains(className)? true:false,
                  target = $(e.target);
                  // console.log(className)

                if (btnPressed) {
                  if(tag === "button"){
                    toggleDown = target.find(span).hasClass("chevron-up")? true : false;
                    target = target.find(span);

                  }else if (tag === "span" && target.hasClass("chevron")) {
                     // toggle = target.hasClass("fa-chevron-down")? false : true;
                     toggleDown = target.hasClass("chevron-up")? true : false;
                    // target.removeClass("fa-chevron-down").addClass("fa-chevron-up")
                  }

                  if (toggleDown) {
                    // target.removeClass("fa-chevron-up").addClass("fa-chevron-down")
                    // target.removeClass("chevron-up")
                    target.removeClass("chevron-up").addClass("chevron-down")
                    $(this).find(".question-container").slideUp(300)

                  }else{
                    // target.removeClass("fa-chevron-down").addClass("chevron-up")
                    // target.addClass("chevron-up")
                    target.removeClass("chevron-down").addClass("chevron-up")
                    $(this).find(".question-container").slideDown(300)
                  }


                }

             const obj ={
               data:data,
               id: data.id,
               loader: $(this).find("div.loader"),
               answer: $(this).find("div.answer"),
               chart:$(this).find("div.chart"),
               meta:$(this).find("div.answer-info"),
               csrf: csrf,
               chartId:chartId
             }

             if(!obj.loader.hasClass("loaded"))  getQuestData(obj);



          });//questItem click

          function initQuestions(){
             // console.log("foo")
            let btnIcon = document.querySelector(".btn-answer span"),
                questBlock = $(".question-block"),
                answerCont = $(".answer-container"),
                btnResult = $(".btn-result"),
                questCount = $(".question-block").length,
                btnAnswer = $(".btn-answer");

                //questBlock.hide();
                answerCont.hide();
                //questBlock.first().show();
                btnAnswer.on("click", function(){
                      let span =   $(this).find("span"),
                        ac = $(this).closest(".question-block").find(".answer-container"),
                        text =  decode(ac.html());
                        ac.html(text);



                  btnIcon.className = span.hasClass("fa-plus")? "fa fa-minus":"fa fa-plus";
                  // console.log(this)
                  // this.find("span").css("background-color", "red")

                  ac.toggle(500)
                })


            btnResult.on("click", function(){
              let result  = $(this).data("result"),
                  question = $(this).closest(".question-block").find(".question-name").text(),
                  id = $(this).closest(".question-block").find(".question-name").attr("data-id"),
                  parent = $(this).closest(".question-block"),
                  sibling = parent.next();
                   ++questNumber;

                quizData.completed =  questNumber;
                quizData.correct +=  parseInt(result);
                quizData.questions[questNumber] = {question:question, correct:result};
                quizData.ids.push(id);
                quizData.answers.push(result);

                // console.log(quizData)
                parent.addClass("animated fadeOutRight").delay(300).hide()
                //console.log(sibling)
                sibling.removeClass("d-none").addClass("animated fadeInLeft").show()
                console.log(questNumber+" out of "+questCount)
                parent.hide();
                if(questNumber >= questCount){
                  console.log("quiz done")
                  quizData.questions = JSON.stringify(quizData.questions);
                  submitQuiz(quizData);
              }
            })// btnResult on
          }// initQuestions

            btnOption.on("click", function(e){
              e.preventDefault();
              let inptTimed = $("input[name='timed']").val(),
                  inptSect = $("select[name='section'] option:selected").val(),
                  inptNum = $("input[name='number']").val(),
                  data = {
                    timed: inptTimed,
                    section: inptSect,
                    number:inptNum
                  };

                  console.log(inptTimed)

                csrf = $('meta[name="csrf-token"]').attr('content')

                $.ajax({
                  method:"get",
                  data:data,
                  url:"/quiz/get",
                  headers:{
                      "X-CSRF-TOKEN":csrf
                  },
                  success:(e) =>{

                    let html = "";
                    console.log(e)
                    for (let prop in e){

                      html +=e[prop];
                    }
                    questCont.html(html);
                    initQuestions();
                    questSet.slideUp(300);
                  },
                  error:(e)=>{
                    console.log(e)
                  }
                })
            });



      function submitQuiz(data){

        csrf = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
          method: "post",
          data: data,
          headers:{
            "X-CSRF-TOKEN":csrf
          },
          url:"quiz/store",
          success: (res)=>{
            console.log(res)
            questCont.html(res.success)
          },
          error:(res)=>{
              console.log(res)
          }
        })
      }
      function decode(html){
        var txt = document.createElement('textarea');
      	txt.innerHTML = html;
      	return txt.value;
      }



    })()
  </script>
</html>
