<script>
$(document).ready(function(){

    // view data
    var dataTable = $('.datatable').DataTable({
        processing: true,
        serverSide: true,
        autoWidth: false,
        pageLength: 5,
        "order": [[ 0, "asc" ]],
        ajax: '{{ route('get-employee') }}',
        columns: [
            { data: 'id', name: 'id'},
            { data: 'name', name: 'name'},
            { data: 'email', name: 'email'},
            { data: 'designation', name: 'designation'},
            { data: 'Action', name: 'Actions',orderable:false,serachable:false,sClass:'text-center'},
        ]
    });

    // add employee
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
            url: "{{ route('employee.store') }}",
            method: 'post',
            data: empData,
            success: function(responce){
                if(responce.error){
                    console.log('afd');
                }else{
                    $('.alert-danger').hide();
                    $('.alert-success').show();
                    $('.datatable').DataTable().ajax.reload();
                    setInterval(function(){
                        $('.alert-success').hide();
                        $('#CreateEmployeeModal').modal('hide');
                        location.reload();
                    }, 2000);
                }
            }
        });
    });

    // edit employee
    $('.modelClose').on('click', function(){
        $('#EditEmployeeModal').hide();
    });

    $('body').on('click', '#getEditEmployeeModal', function(){
        $('.alert-danger').html('');
        $('.alert-danger').hide();
        id = $(this).data('id');

        $.ajax({
            url: 'employee/'+id+'/edit',
            method: 'GET',
            success: function(responce){
                $('#EditEmployeeModalBody').html(responce.html);
                $('#EditEmployeeModal').show();
            }
        });
    });

    // update employee
    $('#UpdateEmployeeForm').click(function(e){
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var editEmpData = {
            'name': $('#nameId').val(),
            'email': $('#emailId').val(),
            'designation': $('#designationId').val(),
        }

        $.ajax({
            url: 'employee/'+id,
            method: 'PUT',
            data: editEmpData,
            success: function(responce){
                if(responce.error){
                    console.log('afd');
                }else{
                    $('.alert-danger').hide();
                    $('.alert-success').show();
                    $('.datatable').DataTable().ajax.reload();
                    setInterval(function(){ 
                        $('.alert-success').hide();
                        $('#EditEmployeeModal').hide();
                    }, 2000);
                }
            }
        });
    })

    // delete employee
    var deleteId
    $('body').on('click', '#getEmployeeDeleteId', function(){
        deleteId = $(this).data('id');
    });
    $('#deleteEmployeeForm').click(function(e){
        e.preventDefault();
        var id = deleteId;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: 'employee/'+id,
            method: 'DELETE',
            success: function(responce){
                setInterval(function(){ 
                    $('.datatable').DataTable().ajax.reload();
                    $('#DeleteEmployeeModal').hide();
                }, 1000);
            }
        });
    });
});
</script>