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
        data = {query:searchField}
        filter = $("select[name='filter']"),
        loadCont = $(".load-container"),
        selectSect = $("select[name='section']");

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
