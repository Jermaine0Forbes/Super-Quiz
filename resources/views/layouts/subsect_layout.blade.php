<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>{{$title}} | Subsections</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" ></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
  </head>
  <body>
    @include('components.header')
    @yield("content")
  </body>
  @if ($title == "AJAX")
    <script type="text/javascript">
      (function(){
        console.log("foo")
        let result = "{{$title}}",
            csrf = $('meta[name="csrf-token"]').attr('content')
            btnSubmit = $("input[type='submit']");

        btnSubmit.on("click", function(e){
           e.preventDefault();
           e.stopPropagation();

           let form = document.querySelector("form"),
               data ,
               number = $("input[name='number']"),
               name = $("input[name='name']");


               data = {
                 number: number.val(),
                 name: name.val(),
               };


            $("#ajax-error").html("");
            $("#ajax-message").html("").hide();

           $.ajax({
                 method:"post",
                 url:"/subsections/store/ajax",
                 // processData:false,
                 data:data,
                 headers:{
                   "X-CSRF-TOKEN":csrf
                 },
                 success:(e) =>{
                   console.log(e)
                    let data = e.data;
                        // p = createP(`"${data.question}" has been successfully saved`,"position-absolute bg-success animated  w-100 text-center text-white py-2 h3","ajax-message"),
                        // success = p;
                   // $("body").append(success)

                   $("#ajax-message").html(`"${data.name}" has been successfully saved`)
                   .addClass("position-absolute bg-success w-100 text-center text-white py-2 h3")
                   .slideDown(500);

                   number.val('')
                   name.val('')
                 },
                 error:(e) =>{
                   // console.log(e)
                   let errors = e.responseJSON.errors,
                      msg = "";
                      for (let x in errors){
                        for(let i = 0; i < errors[x].length; i++){
                           msg += `<p class="text-danger"><span class="fas fa-exclamation mr-2"> </span> ${errors[x][i]} </p>`;
                        }
                      }
                  $("#ajax-error").html(msg);
                   console.log(e.responseJSON)
                 }
             })//ajax

          })//btnSubmit on submit
      })()
    </script>

  @endif
</html>
