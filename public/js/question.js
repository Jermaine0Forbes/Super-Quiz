/*================
  Question Page
=================*/

/* Variables  */

const searchBtn = $("#ajax-search-btn");

/* Functions  */

/* Events  */

searchBtn.on("click", function(){

  const url = "api/question/search",
        searchField = $("input[name='search']").val(),
        filter = $("select[name='filter']").val(),
        questCont = $(".question-container"),
        loadCont = $(".load-container"),
        section = $("select[name='section']").val(),
        data = {
          query:searchField,
          filter:filter,
          section:section
        };

        // log(data)

      $.ajax({
        url:url,
        data:data,
        dataType: "json",
        method: "POST",
        // processData: true,
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
          questCont.html(res.data)
          loadCont.slideUp(300);
        }

      });
});
