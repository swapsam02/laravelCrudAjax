$(document).ready(function(){
    $('#saveEmployeeId').click(function(e){
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var empData = {
            'name': $('#name').val(),
            'email': $('#email').val(),
            'designation': $('#designation').val(),
        }
        console.log(empData);
        $.ajax({
            url: "http://127.0.0.1:8000/employee.store",
            method: 'post',
            data: empData,
            success: function(responce){
                console.log(responce);
            }
        });
    });
});