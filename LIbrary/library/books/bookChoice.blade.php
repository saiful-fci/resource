    <style type="text/css">
        .modal-body {
        position: relative;
        padding: 20px;
        /*margin-left: 103px !important;*/
        }
        .glyphicon-trash:before {
            color: red !important;
        }
    </style>
    <div class="form-group">
        <label for="InputName">Books Details</label>
        <h4 style="display: none;" id="succesMsg" class="text-danger">Cart Clear Successfully!!</h4>
        <h4 style="display: none;" id="succesMsgSingle" class="text-danger">Single Item Delete Successfully!!</h4>
        <div class="input-group form-control">
            <table class="table table-striped">
                <tr>
                    <td>Student ID</td>
                    <td colspan="2"><input type="text" name="custom_id" class="form-control" id="stdId"></td>
                </tr>
                <tr>
                    <td>Member ID</td>
                    <td colspan="2"><input type="text" name="member_id" class="form-control member_id" readonly="" value=""></td>
                </tr>
                <tr>
                    <td>Sl</td>
                    <td>Book Name</td>
                    <td>Action</td>
                </tr>
                @if(!empty($books))
                @foreach($books as $key=>$book)
                <tr id="deltr_{{$book->id}}">
                    <td>{{$key+1}}</td>
                    <td>{{$book->book_name}}</td>
                    <td><a id="del_{{$book->id}}" class="del" href="#"><span class="glyphicon glyphicon-trash"></span><a></td>
                </tr>
                @endforeach
                @endif
            </table>
            <div>
                <input type="submit" name="submit" id="clear" value="Clear Form" class="btn btn-danger pull-right" style="border-radius: 30px;">
            </div>
        </div>
    </div>
<script>
    $(document).ready( function (){
        $('.modal-title').html('Book Choice Form');
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
                $.each(data, function (index, value) {
                    $(".member_id").attr("value",value.id);
                });            
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
                console.log(data);
                $("#assign").modal('hide')                     
            },
            error: function(data) {
                console.log(data); 
            }
        });
        }else{
            return false;
        }
       
    })
    $(".del").on('click',function(){
            var book_id=$(this).attr('id').split('_')[1];
            $.ajax({
            type: "GET",
            dataType:'json',
            url:"{{URL::to('itemDelete')}}/",
            data:{book_id:book_id,'single':'single'},
            success: function(data) {
                $("#deltr_"+book_id).hide(600,function(){
                    $("#succesMsgSingle").show(600);
                });
                console.log(data);                     
            },
            error: function(data) {
                console.log(data); 
            }
        });
        })
    $("#clear").on('click',function(){
        $.ajax({
            type: "GET",
            dataType:'json',
            url:"{{URL::to('itemDelete')}}/",
            data:{'multiple':'multiple'},
            success: function(data) {
                if(data){
                $("#succesMsg").show(900,function(){
                    location.reload();
                    });
                }                     
            },
            error: function(data) {
                console.log(data); 
            }
        });  
        })
    })   
</script>
