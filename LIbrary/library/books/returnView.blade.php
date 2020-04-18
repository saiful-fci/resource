    <style type="text/css">
        .modal-body {
        position: relative;
        padding: 20px;
        /*margin-left: 103px !important;*/
        }
        .glyphicon-trash:before {
            color: red !important;
        }
        #stdId{
            margin-bottom:15px;
        }
    </style>
    <div class="form-group">
        <label for="InputName">Books Details</label>
        <h4 style="display: none;" id="succesMsg" class="text-danger"></h4>
        <div class="input-group form-control">
    <form action="{{URL::to('returnConfirm')}}" method="POST">
        {{csrf_field()}}
        <table class="table table-bordered">
                    <label>Student ID</label>
                    <span colspan="2"><input type="text" name="custom_id" class="form-control" id="stdId"></span>
                    <tr></tr>
                    <thead>
                    <tr>
                        <th>SL</th>
                        <th>Book Name</th>
                        <th>Provide Date</th>
                        <th>Return Date</th>
                        <th>Day</th>
                        <th>Fine</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody id="tableContent" style="display: none;">

                    </tbody>
                </table>
            <div>
                <input type="submit" name="Return" id="clear" value="Return" class="btn btn-info pull-right" style="border-radius: 30px;">
            </div>
        </form>
        </div>
    </div>
<script>
    $(document).ready( function (){
        $('.modal-title').html('Book Return Form');
        $('.modal-content').removeClass('modal-big');
        $('.modal-content').addClass('modal-small');
    $("#stdId").on('keyup',function(){
        $("#tableContent").empty();
        var studentId=$(this).val();
        if(studentId.length>=8){
            $.ajax({
            type: "GET",
            dataType:'json',
            url:"{{URL::to('getBookForReturn')}}/",
            data:{stdId:studentId},
            success: function(data) {
                var provideDate='';
                var return_date='';
                if(data!=1 && data[0].length>0){
                    $.each(data[1],function (key,val) {
                        provideDate=val.provide_date;
                        return_date=val.return_date;
                    });
                var provideDate1=Date.parse(provideDate);
                var return_date2=Date.parse(return_date);
                var distance=return_date2-provideDate1;
                var day=Math.round(distance/3600/24/1000);
                var content='';
                var i = 1;
                $.each(data[0],function (key,val) {
                    if(day>10){
                        var fineCount=day-10;
                    }else{
                        var fineCount=0;
                    }
                content += '<tr>'+
                        '<td>'+(i++)+'</td>'+
                        '<td>'+val.book_name+'</td>'+
                        '<td>'+provideDate+'</td>'+
                        '<td>'+return_date+'</td>'+
                        '<td>'+day+'</td>'+
                        '<td><input type="text" name="fine" class="form-control" value="'+fineCount*10+'" readonly/></td>'+
                        '<td><input type="hidden" name="fk_book_names_id[]" value="'+val.id+'"/></td>'+
                    '</tr>';
                });
                $("#dynamic").append(content);
                }else{
                    alert("No Student Found");
                }
                
                $("#tableContent").empty().append(content).show().slideDown(500);                  
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
        if(studentId && memberId){
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
            url:"{{URL::to('getBookForReturn')}}/",
            data:{'multiple':'multiple'},
            success: function(data) {
                var content = '';
                var i = 1;
                $.each(data,function (key,val) {
                content += '<tr>'+
                        '<td>'+(i++)+'</td>'+
                        '<td>'+val.book_name+'</td>'+
                    '</tr>';
                });
                $("#dynamic").append(content);                     
            },
            error: function(data) {
                console.log(data); 
            }
        });  
        })
    })   
</script>
