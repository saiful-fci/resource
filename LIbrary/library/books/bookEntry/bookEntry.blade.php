@extends('app')
@section('content')
<style type="text/css">
    .btn-sm, .btn-xs {
    padding: 5px 10px;
    font-size: 9px;
    line-height: 1.5;
    border-radius: 142px;
    width: 100px;
    margin-left: 5px;
}
.remove{
    title:remove;
    color:red;
}
.glyphicon-trash:before {
    content: "\e020";
    color: red !important;
}
.col-sm-6 {
    width: 53%;
    }
</style>
{!! Form::open(array('route' => 'bookEntry')) !!}
  <div class="col-md-12">
      <div class="row" style="margin-left: 5px;">
        @if (\Session::has('msg'))
          <div class="alert alert-success">
              <ul>
                  <li style="list-style: none;"><h4>{!! \Session::get('msg') !!}</h4></li>
              </ul>
          </div>
        @endif
        @if(count($errors) > 0)
     <div>
         <ul>
             @foreach($errors->all() as $error)
                 {{ $error }}
             @endforeach
         </ul>
     </div>
    @endif
      </div>
    <div class="widget stacked printPreviewNone">             
       <div class="widget-header">
          <i class="icon-plus-sign"></i> 
          <h3>Book Cart</h3>
       </div> <!-- /widget-header -->
       <div class="widget-content form-horizontal form-wrp" id="wrp-bg">
          <span id="loader1"></span>
       </div> <!-- /widget-content -->     
    </div>
    <div class="col-md-8"> 
       <div class="widget-content">
         <div class="form-group">
          <label for="InputName">Book Name</label>
          <div class="input-group">
             <select name="fk_book_id" id="fk_book_id" class="form-control">
                  <option disabled="" selected="">Please Select</option>
                  @if($allBookNames)
                  @foreach($allBookNames as $bookName)
                  <option value="{{$bookName->id}}">{{$bookName->book_name}}</option>
                  @endforeach
                  @else
                  Data Not Found
                  @endif
              </select>
                <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk"></span></span>
          </div>
          <br>
          <div class="input-group">
     <table class="table">
      <tr>
        <th>Sl</th>
        <th>Book Name</th>
        <th></th>
        <th>Qty</th>
        <th>Price</th>
        <th>Total</th>
      </tr>
        @if(Session::has('booknames'))
        <?php $sl=1; ?>
        @foreach(Session::get('booknames') as $key=> $book)
        <tr>
          <td class="form-control">{{$sl++}}</td>
          <td class="form-control" id="book_name-{{$book['book_id']}}">{{$book['book_name']}}</td>
          <td class="form-control"><input type="hidden" name="book_id[]" value="{{$book['book_id']}}" class="form-control book_id"/></td>
          <td class="form-control"><input type="text" name="qty[]" value="{{$book['qty']}}" id="qty-{{$book['book_id']}}" autocomplete="off" class="qty"></td>
          <td class="form-control"><input type="text" name="price[]" value="{{$book['book_price']}}" id="book_price-{{$book['book_id']}}" class="price" autocomplete="off"></td>
          <td class="form-control"><input type="text" name="total" value="{{$book['allAmount']}}" autocomplete="off" class="total"></td>
          <td class="form-control"><button type="button" class="btn btn-success btn-sm" onclick="editbtn({{$book['book_id']}})" name="editDelete" value="edit">
        <span class="glyphicon glyphicon-edit"></span> Update
      </button></td>
          <td class="form-control">
          <a href="#" id="del" onclick="delItem({{$book['book_id']}})"><span class="glyphicon glyphicon-trash"></span></a></td>
        @endforeach
        </tr>
        @endif
     </table>
          </div>
      </div>
     
       </div> <!-- .widget-content -->
        <input type="submit" name="submit" id="submit" value="{{ trans('common.save_record') }}" class="btn btn-info pull-right">
   </div>
    </div> 
  {!! Form::close() !!}
<script>
  $( document ).ready(function() {
    tableContent=$('#dynamic');
    $('#fk_book_id').on('change',function(){
      var bookId=$(this).val();
      $.ajax({
       type: "GET",
       dataType:'json',
       url:"{{URL::to('bookShow')}}/",
       data:{bookId:bookId},
       beforeSend: function() {
           return "error";
           },
       success: function(data) {
           location.reload();
           },
       error: function(data) {
              
           }
       });

    })
  });
  $('#fk_book_id').chosen();

function delItem(id)
{
  var book_id=id;
  $.ajax({
    url:"deleteField",
    type:"GET",
    dataType:'json',
    data:{'book_id':book_id,'editDelete':'del'},
    success: function(data){
      console.log(book_id);
       location.reload();  
      },
      error: function(data){
        alert('error occurred! Please Check');
      }
  });
}
//====================Edit=======================
function editbtn(id)
{
    var book_id=id;
    var qty=$("#qty-"+book_id).val();
    var book_price = $("#book_price-"+book_id).val();
    var book_name=$("#book_name-"+book_id).html();

    $.ajax({
      url:"updateField",
      type:"GET",
      dataType:'json',
      data:{'book_name':book_name,'book_id':book_id,'book_price':book_price,'qty':qty,'editDelete' : 'edit'},
      success: function(data){
       location.reload();  
      },
      error: function(data){
        alert('error occurred! Please Check');
      }
    });
}
//======================================
$('.price, .qty, .total').on('keydown',function(e){
    if (e.keyCode == 13) {
        e.preventDefault();
        var id=$('.book_id').val();
        editbtn(id);
        return false;
    };
})
</script>
@endsection


