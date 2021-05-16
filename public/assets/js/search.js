
jQuery(document).ready(function($){

});

function changePage(page){
  callStacKExchangeEndpoint(page);
}

function callStacKExchangeEndpoint(currentPage){
  var formData = {
    "tag": jQuery('#tag').val(),
    "startDate": jQuery('#startDate').val(),
    "endDate": jQuery('#endDate').val(),
    "_token": jQuery("meta[name='csrf-token']").attr("content"),
    "currentPage": currentPage
  };
  $(".custom-error").slideUp();
  jQuery.ajax({
      type: "POST",
      url: '',
      data: formData,

      success: function (data) {
          var result = JSON.parse(data);
          console.log(result);
          var resultGrid = '<div class="row"><div class="col-xs-2 result-header">Tags</div><div class="col-xs-6 result-header">Title</div><div class="col-xs-2 result-header">Creation date</div><div class="col-xs-2 result-header">Is answered</div></div>';
          if(result.results !== null){
            for (let dataRow of result.results) {
              let tags = '';
              for(let tag of dataRow.tags){
                tags = tag+"<br/>";
              }
              var resultGrid = resultGrid + '<div class="row result-line">';
              var resultGrid = resultGrid + '<div class="col-xs-2 datafield">'+tags+'</div>';
              var resultGrid = resultGrid + '<div class="col-xs-6 datafield"><a href="'+dataRow.link+'" target="blank" ">'+dataRow.title+'</a></div>';
              var createdate = new Date(dataRow.creation_date * 1000);
              let ye = new Intl.DateTimeFormat('en', { year: 'numeric' }).format(createdate);
              let mo = new Intl.DateTimeFormat('en', { month: '2-digit' }).format(createdate);
              let da = new Intl.DateTimeFormat('en', { day: '2-digit' }).format(createdate);
              var formattedDate =  da + " / " + mo + " / " + ye;
              var answered = false;
              if(resultGrid.is_ansewered){
                answered = true;
              }
              var resultGrid = resultGrid + '<div class="col-xs-2 datafield">'+formattedDate+'</div>';
              var resultGrid = resultGrid + '<div class="col-xs-2 datafield">'+answered+'</div></div>';
            }

            $("#resultList").html(resultGrid);
            if(result.pages>1){
              if(result.pages <5){
                endpage = result.pages;
                startpage = 1;
              }else{
                endpage = result.pageact+5
                startpage = Math.floor(result.pageact/5)
              }
              console.log(startpage);
              console.log(endpage);
              var paginationHtml = '';
              for(var i=startpage;i < endpage+1; i++ ){
                console.log(i);
                if(i == result.pageAct){
                  paginationHtml = paginationHtml+'<div class="col-xs-2 pagination-container page-active"><span class="txt">'+i+'</span></div>';
                }else{
                  paginationHtml = paginationHtml+'<div class="col-xs-2  pagination-container" onclick="changePage('+i+')"><span class="txt">'+i+'<span></div>';
                }
              }
              console.log(paginationHtml);
              $("#paginationRow").html(paginationHtml);
            }
            $(".results-card").show();
          }else{
            if(result.errors !== null){
              $(".custom-error h3").html(result.errors);
              $(".results-card").hide();
              $(".custom-error").slideDown();
            }
          }

      },
      error: function (error) {
        $(".custom-error h3").html(error)
        $(".results-card").hide();
        $(".custom-error").slideDown();
      }
  });
}