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
.col-sm-6 {
    width: 53%;
    }
</style>
{!! Form::open(array('route' => 'bookSave')) !!}
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
            <h3>Book Add</h3>
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
                <input type="text" class="form-control" name="book_name" value="" id="book_name" placeholder="Enter Book Name" required>
                <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk"></span></span>
            </div>
        </div>
        <div class="form-group">
            <label for="InputName">Book Title</label>
            <div class="input-group">
                <input type="text" class="form-control" name="book_title" value="" id="book_title" placeholder="Enter Book Title" required>
                <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk"></span></span>
            </div>
        </div>
        <div class="form-group">
            <label for="InputName">Publisher Name</label>
            <div class="input-group">
                <select name="fk_publisher_id" id="fk_publisher_id" class="form-control">
                    <option disabled="" selected="">Please Select</option>
                    @if(!empty($publishers))
                    @foreach($publishers as $publisher)
                    <option value="{{$publisher->id}}">{{$publisher->publisher_name}}</option>
                    @endforeach
                    @endif
                </select>
                  <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk"></span></span>
            </div>
        </div>
        <div class="form-group">
            <label for="InputName">Author Name</label>
            <div class="input-group">
                <select name="fk_author_id" id="fk_author_id" class="form-control">
                    <option disabled="" selected="">Please Select</option>
                    @if(!empty($authors))
                    @foreach($authors as $author)
                    <option value="{{$author->id}}">{{$author->author_name}}</option>
                    @endforeach
                    @endif
                </select>
                  <span class="input-group-addon"><span class="glyphicon glyphicon-asterisk"></span></span>
            </div>
        </div>
         </div> <!-- .widget-content -->
          <input type="submit" name="submit" id="submit" value="{{ trans('common.save_record') }}" class="btn btn-info pull-right">
     </div>
      </div> 
    {!! Form::close() !!}
    @include('ajax.ajaxGlobalVar')
<script>
    $('#fk_publisher_id').chosen();
    $('#fk_author_id').chosen();
</script>
@endsection


