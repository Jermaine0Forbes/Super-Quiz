<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>{{$title}} | Questions</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    {{-- <link href="//cdn.quilljs.com/1.3.6/quill.core.css" rel="stylesheet"> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
    <link rel="stylesheet" href="//cdn.quilljs.com/1.3.6/quill.snow.css">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" ></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="{{asset('js/root.js')}}"></script>

    <!-- Main Quill library -->
    <script src="//cdn.quilljs.com/1.3.6/quill.js"></script>
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

      let remove = $("#btn-delete") || null,
          csrf = $('meta[name="csrf-token"]').attr('content'),
          questCont = $(".question-container"),
          section = $("input[name='section']") || null;



      @if( $title == "Create" || $title == "Edit" || $title == "AJAX")
        const container = document.getElementById("editor"),
              result = `{{$title}}`,
              select = $("#subsection-select"),
              answer = $("#answer"),
              toolbarOptions = [
                  ['bold', 'italic', 'underline', 'strike'],
                  [{"list":"ordered"},{"list":"bullet"}]
                ],
              options = {
                      // debug: 'info',
                      modules: {
                        toolbar:toolbarOptions
                      },
                      placeholder: 'Insert answer...',
                      theme: 'snow'
                };

          var editor = new Quill(container,options);


          editor.getHTML = () =>{
            return editor.root.innerHTML
          }
          editor.setHTML = (html) =>{
             editor.root.innerHTML = html;
          }

          if(result == "Edit"){
            @php
            $answer = empty($question->answer) ? "" : $question->answer;
            $answer =  html_entity_decode($answer);
            @endphp
            let html = `@php echo $answer; @endphp`;
            editor.setHTML(html);
          }
          editor.on("text-change",(delta, oldDelta, source)=>{
            // console.log("text-change");
            answer.text(editor.getHTML());

          })

          section.on("blur",function (e){
            console.log("in section")
             let num = $(this).val();

             csrf = $('meta[name="csrf-token"]').attr('content')
             $.ajax({
               method:"post",
               url:"/questions/getSubsects",
               data:{section:num},
               headers:{
                 "X-CSRF-TOKEN":csrf
               },
               success:(e) =>{
                 console.log(e)
                  let  result = e.result;
                  // let res = JSON.parse(e),
                  //     result = res.result;
                 select.html(result)
               },
               error:(e) =>{
                 console.log(e)
               }

             })//ajax

          });//section on blur

          if (result == "AJAX"){

            let btnSubmit = $("input[type='submit']");



            btnSubmit.on("click", function(e){
               e.preventDefault();
               e.stopPropagation();

               let form = document.querySelector("form"),
                   data ,
                   // data = new FormData(form),
                   quest = $("input[name='question']"),
                   sect = $("input[name='section']"),
                   subsect = $("select[name='subsection[]']"),
                   answerInpt = $("textarea[name='answer']");

                   csrf = $('meta[name="csrf-token"]').attr('content');

                   // data.append("question", quest)
                   // data.append("section", sect)
                   // data.append("subsection", subsect)
                   // data.append("answer", answer)

                   data = {
                     question: quest.val(),
                     section: sect.val(),
                     subsection: subsect.val(),
                     answer:answerInpt.text()
                   };
                console.log(answerInpt.text());
                $("#ajax-error").html("");
                $("#ajax-message").html("").hide();

               $.ajax({
                     method:"post",
                     url:"/question/store/ajax",
                     // processData:false,
                     data:data,
                     headers:{
                       "X-CSRF-TOKEN":csrf
                     },
                     success:(e) =>{
                       // console.log(e)
                        let data = e.data,
                            p = createP(`"${data.question}" has been successfully saved`,"position-absolute bg-success animated  w-100 text-center text-white py-2 h3","ajax-message"),
                            success = p;
                       // $("body").append(success)
                       editor.setHTML('');
                       $("#ajax-message").html(`"${data.question}" has been successfully saved`)
                       .addClass("position-absolute bg-success animated  w-100 text-center text-white py-2 h3")
                       .show();

                       quest.val('')
                       sect.val('')
                       subsect.val([])
                       answerInpt.val('')
                       // console.log(booty())
                     },
                     error:(e) =>{
                       // console.log(e)
                       let errors = e.responseJSON.errors,
                          msg = "";
                          for (let x in errors){
                            for(let i = 0; i < errors[x].length; i++){
                               msg += `<p class="text-danger animated bounceInLeft"><span class="fas fa-exclamation mr-2"> </span> ${errors[x][i]} </p>`;
                            }
                          }
                      $("#ajax-error").html(msg);
                       console.log(e.responseJSON)
                     }
                 })//ajax

              })//btnSubmit on submit
        }// result AJAX
        @elseif ($title == "List")
          const filter = $("select[name='filter']"),
              loadCont = $(".load-container"),
              selectSect = $("select[name='section']"),
              searchBtn = $("#ajax-search-btn");

              searchBtn.on("click", function(){

                const url = "api/question/search",
                      searchField = $("input[name='search']").val(),
                      data = {query:searchField};

                      // log(data)

                    $.ajax({
                      url:url,
                      data: data,
                      method: "POST",
                      headers:{
                        "X-CSRF-TOKEN":csrf
                      },
                      beforeSend:(res) =>{
                        loadCont.slideDown(300);
                      },
                      error: (res) =>{
                        console.log(res)
                      },
                      success: (res) =>{
                        console.log(res)
                        loadCont.slideUp(300);
                      }

                    });
              });

            function filterQuests(){
              let f = filter.val(),
                  s = selectSect.val(),
                  data = {
                    filter:f,
                    section:s
                  };

                // console.log(s)
                // console.log(f)
                loadCont.slideDown(300);
                csrf = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                  url:"/questions/filter",
                  method:"get",
                  data: data,
                  headers:{
                     "X-CSRF-TOKEN":csrf
                  },
                  success:(e) =>{
                    console.log(e)
                    questCont.html(e.data)
                    loadCont.slideUp(500);
                  },
                  error:(e)=>{
                    console.log(e)
                  }
                })
            }

          filter.on("change",filterQuests)
          selectSect.on("change",filterQuests)

        @endif



        remove.on("click", (e) => {
          e.stopPropagation();
          e.preventDefault();
          let res = confirm("Are you sure you want to delete this question?");
          if(res)window.location.replace(e.target.href);

        });



    })()
  </script>
</html>
