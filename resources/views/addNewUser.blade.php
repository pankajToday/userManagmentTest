<!--Add new  Model View-->

<style>
    .cust_checkbox_label {
        float: left;
        margin-right: 10px;
        padding-top: 5px;
    }
    .cust_checkbox{
        width: 21px;
        float: left;
    }
</style>


<div class = "modal fade bd-example-modal-lg" tabindex = "-1"  role ="dialog"
     aria-labelledby =" myLargeModalLabel" aria-hidden = "true">

    <div class = "modal-dialog modal-lg">
        <div class = "modal-content">
             <form method="post" role="form" id="addUserForm" enctype="multipart/form-data" >
                {{csrf_field()}}

                <div class = "modal-header">
                    <h5 class = "modal-title" id = "exampleModalLabel">Add New User</h5>
                    <button type = "button" class = "close" data-dismiss = "modal" aria-label = "Close">
                    </button>
                </div>

                <div class = "modal-body">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="email" class="required">Email</label>
                            </div>
                        </div>
                        <div class="col-sm-9">
                            <div class="form-group">
                                <input type="email" name="email" id="email" maxlength="50"
                                    class="form-control" placeholder="user@example.com"/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                 <label for="fullName">Full Name</label>
                            </div>
                        </div>
                        <div class="col-sm-9">
                            <div class="form-group">
                                <input type="text" name="full_name" id="fullName" maxlength="50"
                                        class="form-control" placeholder="user name"/>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="joinDate" >Join Date</label>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <input type="text" name="joinDate" id="joinDate"  class="form-control"  />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="leaveDate">Leave Date</label>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <input type="text" name="leaveDate" id="leaveDate"  class="form-control"/>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="workStatus" class="cust_checkbox_label"> Still Working</label>
                                <input type="hidden" name="workStatus" id="workStatusTxt" value="0"/>
                                <input type="checkbox"  id="workStatus"  class="form-control cust_checkbox"  />
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-sm-3">User Image</div>
                        <div class="col-sm-4">
                            <input type="file" name="userImage" id="userImage"  class="form-control"
                            accept="image/jpeg,image/jpg,image/png"/>
                        </div>
                    </div>

                </div>

                <div class = "modal-footer">
                    <button type = "button" class = "btn btn-danger" data-dismiss = "modal">
                        <i class="fa fa-close"></i> Close</button>
                    <button type = "submit"  id="dataBtm" class = "btn btn-success" onclick="">
                        <i class="fa fa-save"></i> Save</button>
                </div>

            </form>
        </div>
    </div>
</div>
<!-- Model View end -->

<script>

    $('#workStatus').change(function(e){
        if ($(this).is(':checked')) {
            $('#leaveDate').prop('disabled',true);
            $('#workStatusTxt').val(1);

        } else {
            $('#leaveDate').prop('disabled',false);
            $('#workStatusTxt').val(0);
        }
    });

      $('#addUserForm').on('submit', function(e){
            e.preventDefault();
            $.ajax({
                url: "{{ route('storeUser') }}",
                type: 'POST',
                data:  new FormData($('#addUserForm')[0]),
                headers: { 'X-CSRF-TOKEN': '{{csrf_token()}}' },
                processData: false, // Required Field
                contentType: false, // Required Field
                cache: false,
                success: function(data){
                    if( data.status == 'success')
                    {
                        toastr.success(data.message);
                        window.location="{{route('index')}}";
                    }
                    else
                    {
                        toastr.error(data.message);
                    }
                },
                error: function(data)
                {
                    if( data.status == 422)
                    {
                        var  errArray = data.responseJSON.errors ;
                        var errMsg='';
                        for (var key in errArray) {

                            toastr.error("<i class='fa fa-warning'></i> <i>"+errArray[key]+"</i><br><br>");
                        }
                    }

                }
            });
        });

</script>