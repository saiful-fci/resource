    <style type="text/css">
        .modal-body {
        position: relative;
        padding: 20px;
        }
        .del{
            color: red;
        }
    </style>
    <div class="form-group">
        <label for="InputName" class="book_details">Books Details</label>
        <h4 style="display: none;" id="succesMsg" class="text-success">Book Issue Successfully!!</h4>
        <h4 style="display: none;" id="ErrorMsg" class="text-danger">Please Return Old Book First!!</h4>
        <div class="input-group form-control">
            <table class="table table-striped">
                <tr>
                    <td>Student ID</td>
                    <td><input type="text" name="custom_id" class="form-control" id="stdId"></td>
                </tr>
                <tr>
                    <td>Member ID</td>
                    <td><input type="text" name="member_id" class="form-control member_id" readonly="" value=""></td>
                </tr>
                <tr>
                    <td>Return Date</td>
                    <td><input value="<?php echo date('d-m-Y'); ?>" name="date" class="form-control date" placeholder="Enter Today date"></td>
                </tr>
                <tr>
                    <td>Sl</td>
                    <td>Book Name</td>
                </tr>
                @if(!empty($books))
                @foreach($books as $key=>$book)
                <tr>
                    <td>{{$key+1}}</td>
                    <td>{{$book->book_name}}</td>
                </tr>
                @endforeach
                @endif
            </table>
            <div>
                <input type="submit" name="submit" id="submit" value="{{ trans('common.save_record') }}" class="btn btn-info pull-right">
            </div>
        </div>
    </div>
<script>
    $(document).ready( function (){
        $('.modal-title').html('Book Assign Form');
        $('.modal-content').removeClass('modal-big');
        $('.modal-content').addClass('modal-small');
    $("#stdId").on('keyup',function(){
        var studentId=$(this).val();
        if(studentId.length>=8){
            $.ajax({
            type: "GET",
            dataType:'json',
            url:"{{URL::to('getMemberId')}}/",
            data:{studentId:studentId},
            success: function(data) {
                if(!data==0){
                    $.each(data, function (index, value) {
                    $(".member_id").attr("value",value.id);
                });
                }else{
                    $(".member_id").empty().attr("value",'');
                    $(".book_details").empty().append("<h4 style='color:red;'>Student Not Found</h4>").slideDown(3000,function(){
                        $(this).slideUp(900);
                    });
                }            
            },
            error: function(data) {
                console.log(data); 
            }
        });

        }else{
            return false;
        }
    })
    $("#submit").on('click',function(){
        var studentId=$("#stdId").val();
        var memberId=$(".member_id").val();
        var date=$(".date").val();
        if(studentId && memberId && date){
            $.ajax({
            type: "GET",
            dataType:'json',
            url:"{{URL::to('bookIssue')}}/",
            data:{studentId:studentId,memberId:memberId,date:date},
            success: function(data) {
                if(data[0]=='return'){
                  $("#ErrorMsg").show(2000,function(){location.reload();
                  });
                }else{
                   $("#succesMsg").show(2000,function(){location.reload();
                  }); 
                }                     
            },
            error: function(data) {
                console.log(5); 
            }
        });
        }else{   
            $(".book_details").empty().append("<h4 style='color:red;'>Student Not Found</h4>").slideDown(3000,function(){
                $(this).slideUp(900);
            });
        }
       
    })
    })   
</script>
