@extends('app')
@section('content')
<style type="text/css">
   @media print {
      .print{display: block !important;}
      .not-print{display: none !important;}
   }
</style>
    <div class="col-md-12"> 
      <div class="widget stacked printPreviewNone">             
         <div class="widget-header">
            <i class="icon-plus-sign"></i> 
            <h3>Books Name</h3>
         </div> <!-- /widget-header -->
         <h2 style="display: none; color: green;" id="deleteMsg">Book Deleted Successfully</h2>
         <h2 style="display: none; color: green;" id="updatedMsg">Book updated Successfully</h2>
         <h2 style="display: none; color: green;" id="activeMsg">Book Active Successfully</h2>
         <h2 style="display: none; color: green;" id="inactiveMsg">Book Inactive Successfully</h2>
         <div class="widget-content form-horizontal form-wrp" id="wrp-bg">
            <span id="loader1"></span>
         </div> <!-- /widget-content -->     
      </div>
         <div class="widget-content">
            <table class="table table-bordered" id="myTable" style="">            
               <thead>
                  <tr>
                     <th width="05%">SL</th>                       
                     <th width="20%">Book Name</th>           
                     <th width="20%">Book Title</th>
                     <th width="15%">Publisher Name</th>
                     <th width="15%">Author Name</th>
                     <th width="10%">Status</th>
                     <th width="15%">Action</th>
                  </tr>
               </thead>
               <tbody id="tbody">
                  <?php $i=0; ?>
                  @if(!empty($datas))
                     @foreach($datas as $key=>$value)
                     <tr id="deleteTr">
                        <td>{{++$i}}</td>
                        <td>
                           <span>{{$value->book_name}}</span>
                           <input type="text" name="book_name" id="book_name-{{$value->id}}" class="form-control" style="display: none;" value="{{$value->book_name}}">
                        </td>
                        <td>
                           <span>{{$value->book_title}}</span>
                           <input type="text" name="book_title" id="book_title-{{$value->id}}" class="form-control" style="display: none;" value="{{$value->book_title}}">
                        </td>
                        <td>
                          <span>{{$value->publishers->publisher_name}}</span>
                          <select name="publisher_name" id="publisher_name-{{$value->id}}" class="form-control publisher_name" style="display: none;">
                            @foreach($publishers as $publisher)
                            <option  value="{{$publisher->id}}" {{$publisher->id==$value->publishers->id ? 'selected':''}}>{{$publisher->publisher_name}}-{{$publisher->id}}</option>
                            @endforeach
                          </select>
                        </td>
                        <td>
                          <span>{{$value->authors->author_name}}</span>
                          <select name="author_name" id="author_name-{{$value->id}}" class="form-control" style="display: none;">
                            @foreach($authors as $author)
                            <option value="{{$author->id}}" {{$author->id==$value->authors->id ? 'selected':''}}>{{$author->author_name}}-{{$author->id}}</option>
                            @endforeach
                          </select>
                        </td>
                        <td>
                          @if($value->status!=0)
                          <label class="label label-success">Active</label>
                          @endif
                          @if($value->status==0)
                          <label class="label label-danger">Inactive</label>
                          @endif
                        </td>
                        <td>
                           <a class="btn btn-primary btn-xs edit-btn" href="javascript:;" data-id="{{$value->id}}"><i class="fa fa-edit"></i> Edit</a>
                                 <a class="btn btn-success btn-xs save-btn" href="javascript:;" style="display: none;" data-id="{{$value->id}}"><i class="fa fa-save"></i> Save</a>
                                 <a class="btn btn-warning btn-xs btn-reset" href="javascript:;" style="display: none;" data-id="{{$value->id}}"><i class="fa fa-refresh fa-spin"></i> Reset</a>
                                 <a class="btn btn-danger btn-xs delete_book" data-id="{{$value->id}}" href="javascript:;"><i class="icon_close_alt2"></i> Delete</a>
                                 @if($value->status==0)
                                 <a class="btn btn-success btn-xs bookActive" data-id="{{$value->id}}" href="javascript:;"><i class="icon_close_alt2"></i>Active</a>
                                 @endif
                                 @if($value->status!=0)
                                 <a class="btn btn-danger btn-xs bookInactive" data-id="{{$value->id}}" href="javascript:;"><i class="icon_close_alt2"></i>Inactive</a>
                                 @endif
                        </td>
                     @endforeach
                  @endif
                  </tr> 
               </tbody>
            </table>
         </div> <!-- .widget-content -->
         
      </div> 
   </div>   
   
   <script type="text/javascript">
      //=====================Edit Section Start====================  
      $('.edit-btn').on('click',function(){
         var thisProf=$(this);
         var bookId=thisProf.attr('data-id');
         thisProf.hide().next().show().next().show();
         $('#book_name-'+bookId).show().prev().hide();
         $('#book_title-'+bookId).show().prev().hide();
         $('#publisher_name-'+bookId).show().prev().hide();
         $('#author_name-'+bookId).show().prev().hide();

      })
   //=====================Edit Section End====================
   //=====================update section start================
      $('.save-btn').on('click',function(){
         var thisProf=$(this);
         var bookId=thisProf.attr('data-id');
         var book_name=$('#book_name-'+bookId).val();
         var book_title=$('#book_title-'+bookId).val();
         var author_name=$('#author_name-'+bookId).val();
         var publisher_name=$("#publisher_name-"+bookId+" option:selected" ).text();
         var author_name=$("#author_name-"+bookId+" option:selected" ).text();
         var fk_publisher_arr=publisher_name.split('-');
         var fk_author_arr=author_name.split('-');
         var fk_publisher_id=fk_publisher_arr[1];
         var fk_author_id=fk_author_arr[1];
         $.ajax({
           type: "GET",
           dataType:'json',
           url:"{{URL::to('updateBook')}}/",
           data:{bookId:bookId,book_name:book_name,book_title:book_title,fk_publisher_id:fk_publisher_id,fk_author_id:fk_author_id},
           beforeSend: function() {
               return "error";
               },
           success: function(data) {
               if(data.status==true){   
                     thisProf.hide().prev().show().next().next().hide();
                     $('#book_name-'+bookId).hide().prev().show().html(book_name);
                     $('#book_title-'+bookId).hide().prev().show().html(book_title);
                     $('#publisher_name-'+bookId).hide().prev().show().html(fk_publisher_arr[0]);
                     $('#author_name-'+bookId).hide().prev().show().html(fk_author_arr[0]);
                     $('#updatedMsg').show(3000,function(){
                        $(this).hide(3000)
                     })
               }
               
               },
           error: function(data) {
                  alert("somthing went wrong");
               }
           });

      });   

   //===========update section end================   

   //=====================Reset Section Start==================== 
      $('.btn-reset').on('click',function(){
         var thisProf=$(this);
         var bookId=thisProf.attr('data-id');
         thisProf.hide().prev().hide().prev().show();
         $('#book_name-'+bookId).hide().prev().show();
         $('#book_title-'+bookId).hide().prev().show();
         $('#publisher_name-'+bookId).hide().prev().show();
         $('#author_name-'+bookId).hide().prev().show();
      });
   //=====================Reset Section End====================   

   //=====================DELETE Section Start====================   
      $('.delete_book').on('click',function(){
         if(confirm("are u sure?")){
            var thisProf=$(this);
            var bookId=$(this).attr('data-id');
      $.ajax({
        type: "GET",
        dataType:'json',
        url:"{{URL::to('deleteBook')}}/",
        data:{"bookId":bookId},
        beforeSend: function() {
            return "error";
            },
        success: function(data) {
          // console.log(data);
          // return false;
               if(data.status==true){
                  thisProf.parent().parent().hide(3000);
                  $('#deleteMsg').show(3000,function(){
                     $(this).hide(3000,function(){
                     })
                  });
               }else{
                  alert("wrong");
               }
            
            },
        error: function(data) {
               $(".printPreviewNone").slideDown(3000,function(){
                    $(this).empty().append("<h4 style='color:white; background-color:red; padding:10px;'>Already Used!!</h4>").slideUp(3000);
                 })
            }
        });
      }
      });

$(".bookActive, .bookInactive").on('click',function(){
      var id=$(this).attr("data-id");
      var cls=$(this).attr("class");
      // alert(cls);
      $.ajax({
        type: "GET",
        dataType:'json',
        url:"{{URL::to('activeInactive')}}/",
        data:{id:id,cls:cls},
        beforeSend: function() {
            return "error";
            },
        success: function(data) {
               if(data==true){
                  $("#inactiveMsg").show(900,function(){
                    $(this).hide(900,function(){
                      location.reload();
                    });
                  });
                  
               }else{
                  $("#activeMsg").show(900,function(){
                    $(this).hide(900,function(){
                      location.reload();
                    });
                  });
               }
            
            },
        error: function(data) {
               alert("somthing went wrong");
            }
        });
  })
 
 $(document).ready( function () {
    $('#myTable').DataTable();
} );
   //=====================DELETE Section End====================
   </script>
@endsection