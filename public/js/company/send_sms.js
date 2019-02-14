var SendSMS = function () {
    
    var handleList = function () {

        var form = $('#sendSMS');
        var rules = {
          // emp_id: {required: true},
          message: {required: true}
        };
        handleFormValidate(form, rules, function (form) {
            handleAjaxFormSubmit(form, true);
        });

        $('body').on('click','.sendSMS',function(){
            /*$('.emp_id').css('border','1px solid #e5e6e7');
            $('.message').css('border','1px solid #e5e6e7');*/
            var emp_id = $('.emp_id').val();
            var dept_id = $('.dept_id').val();
            var message = $('.message').val();
            
            if(!emp_id && !dept_id) {
                /*$('.emp_id').css('border','1px solid red');
                $('.message').css('border','1px solid red');*/
                alert('Please select any Employee OR Department!');
                return false;
            } 
            /*else {
              if(emp_id == '') {
                $('.emp_id').css('border','1px solid red');
              }*/
              if(message == '') {
                $('.message').css('border','1px solid red');
              }
            // }
            if(emp_id && dept_id) {
                alert('Please select any one from Employee and Department!');
                return false;
            }
        });

        var dataArr = {};
        var columnWidth = {"width": "10%", "targets": 0};

        var arrList = {
            'tableID': '#dataTables-sendSMS',
            'ajaxURL': baseurl + "company/sendSMS-ajaxAction",
            'ajaxAction': 'getdatatable',
            'postData': dataArr,
            'hideColumnList': [],
            'noSearchApply': [0],
            'noSortingApply': [1],
            'defaultSortColumn': 0,
            'defaultSortOrder': 'desc',
            'setColumnWidth': columnWidth
        };
        getDataTable(arrList);
    }
    return {
        init: function () {
            handleList();
        }
    }
}();