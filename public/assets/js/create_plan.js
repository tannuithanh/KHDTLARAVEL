$(document).ready(function(){
    $("#add-form-create").click(function(){
     
      var numerDefault = parseInt($('#form-create-plan-default').attr('name'));
      var numberOfForm =  numerDefault + 1;
      $('#form-create-plan-default').attr('name', numberOfForm);
      $('#create-plan-title').text('Công việc ' + numberOfForm);
      var htmlFormDefault = $('#form-create-plan-default').html();
      if( htmlFormDefault.indexOf('works[0][category_work_id]') != -1 ){
        htmlFormDefault = htmlFormDefault.replace("works[0][category_work_id]", "works[" + numerDefault +"][category_work_id]");
      }
      if( htmlFormDefault.indexOf('works[0][detail]') != -1 ){
        htmlFormDefault = htmlFormDefault.replace("works[0][detail]", "works[" + numerDefault +"][detail]");
      }
      if( htmlFormDefault.indexOf('works[0][time]') != -1 ){
        htmlFormDefault = htmlFormDefault.replace("works[0][time]", "works[" + numerDefault +"][time]");
      }
      if( htmlFormDefault.indexOf('works[0][start_date]') != -1 ){
        htmlFormDefault = htmlFormDefault.replace("works[0][start_date]", "works[" + numerDefault +"][start_date]");
      }
      if( htmlFormDefault.indexOf('works[0][end_date]') != -1 ){
        htmlFormDefault = htmlFormDefault.replace("works[0][end_date]", "works[" + numerDefault +"][end_date]");
      }
      if( htmlFormDefault.indexOf('works[0][responsibility]') != -1 ){
        htmlFormDefault = htmlFormDefault.replace("works[0][responsibility]", "works[" + numerDefault +"][responsibility]");
      }
      if( htmlFormDefault.indexOf('works[0][result]') != -1 ){
        htmlFormDefault = htmlFormDefault.replace("works[0][result]", "works[" + numerDefault +"][result]");
      }
      if( htmlFormDefault.indexOf('works[0][support]') != -1 ){
        htmlFormDefault = htmlFormDefault.replace("works[0][support]", "works[" + numerDefault +"][support]");
      }
      if( htmlFormDefault.indexOf('works[0][difficult]') != -1 ){
        htmlFormDefault = htmlFormDefault.replace("works[0][difficult]", "works[" + numerDefault +"][difficult]");
      }

      var htmlFormAdd = $('#form-create-plan').html();
      
      var newHTML = htmlFormAdd + htmlFormDefault;

      console.log(htmlFormDefault);

      $('#form-create-plan').html(newHTML);
     
    });

});
