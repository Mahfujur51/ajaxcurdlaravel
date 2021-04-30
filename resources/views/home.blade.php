@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">
            AJAX CURD
        </div>
        <div class="card-body">
    <div class="row justify-content-center">
        <div class="col-md-8">
        <div class="card">
            <div class="card-header">Teachers Information</div>
            <div class="card-body">
                <table class="table">
                <thead>
                    <tr>
                        <th width="5%">Sl</th>
                        <th width="15%">Name</th>
                        <th width="20%">Title</th>
                        <th width="40%">Institute</th>
                        <th width="20%">Action</th>
                    </tr>
                </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
       </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <span id="addheader">Add new Teacher </span>

                    <span id="upheader">Update Teacher</span></div>
                <div class="card-body">

                        <div class="form-group">
                            <label for="">Name</label>
                            <input type="text" class="form-control" id="name" placeholder="Enter YOur Name">
                            <span class="text-danger" id="nameError"></span>
                        </div>

                        <div class="form-group">
                            <label for="">Title</label>
                            <input type="text" class="form-control" id="title" placeholder="Enter YOur Title">
                            <span class="text-danger" id="titleError"></span>
                        </div>

                        <div class="form-group">
                            <label for="">Institue</label>
                            <input type="text" class="form-control" id="institute" placeholder="Enter YOur Institute">
                            <span class="text-danger" id="instituteError"></span>
                        </div>
                    <input type="hidden" id="id">
                        <button type="submit" onclick="addData()" id="addbuton" class="btn btn-success btn-sm float-right ">Save</button>
                        <button type="submit" id="upbutton" onclick="updateData()" class="btn btn-primary btn-sm float-right mr-2">Update</button>


                </div>
            </div>
        </div>
          </div>
      </div>
    </div>
</div>
@endsection
@section('script')
    <script src="http://code.jquery.com/jquery-1.11.0.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>


    <script>
        $('#addbuton').show();
        $('#addheader').show();

        $('#upbutton').hide();
        $('#upheader').hide();
         /*header csrf token*/
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })
         /*End Header*/

        /*get All Data */
        function  allData(){
            $.ajax({
                type:"GET",
                dataType:'json',
                url:"/teacher/all",
                success:function(response){
                    var data=""
                   $.each(response ,function (key,value){
                       data=data+"<tr>"
                       data=data+"<td>"+ value.id+"</td>"
                       data=data+"<td>"+ value.name+"</td>"
                       data=data+"<td>"+ value.title+"</td>"
                       data=data+"<td>"+ value.institute+"</td>"
                       data=data+"<td>"
                       data=data+"<button class='btn btn-sm btn-success  mr-2' onclick='editData("+value.id+")'>Edit</button>"
                       data=data+"<button class='btn btn-sm btn-danger ' onclick='deleteData("+value.id+")'>Delete</button>"
                       data=data+"</td>"
                       data=data+"</tr>"
                   })
                    $('tbody').html(data);

            }

            })
        }
        allData();
        /*End Get ALl data*/
        /*Start Clear Data*/
        function  clearData(){
            $('#name').val('');
            $('#title').val('');
            $('#institute').val('');
            $('#nameError').text('');
            $('#titleError').text('');
            $('#instituteError').text('');
        }
        /*End Clear Data*/
        /*Add Data*/
        function  addData(){
            var name= $('#name').val();
            var title=$('#title').val();
            var institute=$('#institute').val();
            $.ajax({
                type:"POST",
                dataType:"json",
                data:{name:name,title:title,institute:institute},
                url:'/teacher/store/'+'?_token=' + '{{ csrf_token() }}',
                success:function (data){

                    clearData();
                    allData();


                    Swal.fire({
                        toast:true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Data Added Success',
                        showConfirmButton: false,
                        timer: 1500
                    })
                },
                error:function (error){
                    $('#nameError').text(error.responseJSON.errors.name);
                    $('#titleError').text(error.responseJSON.errors.title);
                    $('#instituteError').text(error.responseJSON.errors.institute);
                }
            })


        }
        /*End Add data*/
        /*Start Edit data*/
        function  editData(id){
            $.ajax({
                type:"GET",
                dataType:"json",
                url:"/teacher/edit/"+id,
                success:function (data){
                    $('#addbuton').hide();
                    $('#addheader').hide();

                    $('#upbutton').show();
                    $('#upheader').show();
                    $('#name').val(data.name);
                    $('#title').val(data.title);
                    $('#institute').val(data.institute);
                    $('#id').val(data.id);
                }
            })
        }
        /*End Edit Section*/
        /*Start Update*/
        function  updateData(){
            var id= $('#id').val();
            var name= $('#name').val();
            var title=$('#title').val();
            var institute=$('#institute').val();
            $.ajax({
                type:"POST",
                dataType:"json",
                data:{name:name,title:title,institute:institute},
                url:"/teacher/update/"+id+'?_token=' + '{{ csrf_token() }}',
                success:function (data){
                    $('#addbuton').show();
                    $('#addheader').show();

                    $('#upbutton').hide();
                    $('#upheader').hide();
                    clearData();
                    allData();
                    Swal.fire({
                        toast:true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Data Added Success',
                        showConfirmButton: false,
                        timer: 1500
                    })

                },
                error:function (error){
                    $('#nameError').text(error.responseJSON.errors.name);
                    $('#titleError').text(error.responseJSON.errors.title);
                    $('#instituteError').text(error.responseJSON.errors.institute);
                }
            })
        }



        /*End  Update*/

        /*Start Delete*/
        function  deleteData(id){

            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            })

            swalWithBootstrapButtons.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type:"GET",
                        dataType:"json",
                        url:"/teacher/delete/"+id,
                        success:function (data){
                            $('#addbuton').show();
                            $('#addheader').show();

                            $('#upbutton').hide();
                            $('#upheader').hide();
                            clearData();
                            allData();
                        }
                    })
                    swalWithBootstrapButtons.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                    )
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons.fire(
                        'Cancelled',
                        'Your imaginary file is safe :)',
                        'error'
                    )
                }
            })
        }
    </script>
@endsection
