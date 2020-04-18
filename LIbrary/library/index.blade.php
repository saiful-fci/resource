@extends('app')
@section('content')
<h3> # Library Manage  </h3>
<div class="col-md-12">
   <div class="widget stacked setup">
      <div class="widget-header">
         <i class="icon-cogs"></i>
         <h3>Online Library</h3>
      </div>
      <!-- /widget-header -->
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
      <div class="widget-content setup-content">
         <div class="setup-items">
            <div class="setup-item item-overlay">
               <i class="icon-list-alt setup-icon overlay-bg"></i>
               <span class="setup-label overlay-bg">Publishers</span>
               <div class="item-overlay-body">
                  <p><a title="Add Publisher" class="btn btn-primary btn-sm"  data-toggle="modal" href="#modal" onclick="loadModal('loadPublisherModal')"><i class="icon-plus-sign"></i>&nbsp; {{ trans('common.add') }}</a></p>
                  <p><a title="View Publisher" class="btn btn-info btn-sm"     data-toggle="modal" href="{{URL::to('publisherView')}}"><i class="icon-zoom-in"></i> {{ trans('common.view') }}</a></p>
               </div>
            </div>
            <div class="setup-item item-overlay">
               <i class="icon-bar-chart setup-icon overlay-bg"></i>
               <span class="setup-label overlay-bg">Members</span>
               <div class="item-overlay-body">
                  <p><a title="{{ trans('Add Members') }}" class="btn btn-primary btn-sm"  data-toggle="modal" href="{{URL::to('addMember')}}"><i class="icon-plus-sign"></i>&nbsp; {{ trans('common.add') }}</a></p>
                  <p><a title="{{ trans('View Members') }}" class="btn btn-info btn-sm"  data-toggle="modal" href="{{URL::to('/viewMembers')}}"><i class="icon-plus-sign"></i>&nbsp; {{ trans('common.view') }}</a></p>
               </div>
            </div>
            <div class="setup-item item-overlay">
               <i class="icon-tasks setup-icon overlay-bg"></i>
               <span class="setup-label overlay-bg">Author</span>
               <div class="item-overlay-body">
                  <p><a title="Add Author" class="btn btn-primary btn-sm"  data-toggle="modal" href="#modal" onclick="loadModal('authorAdd')"><i class="icon-plus-sign"></i>&nbsp; {{ trans('common.add') }}</a></p>
                  <p><a title="Author View" class="btn btn-info btn-sm" data-toggle="modal" href="{{URL::to('authorView')}}"><i class="icon-zoom-in"></i> {{ trans('common.view') }}</a></p>
               </div>
            </div>
            <div class="setup-item item-overlay">
               <i class=" icon-road setup-icon overlay-bg"></i>
               <span class="setup-label overlay-bg">Books Name Entry</span>
               <div class="item-overlay-body">
                  <p><a title="Add Books" class="btn btn-primary btn-sm"  data-toggle="modal" href="{{URL::to('addBook')}}"><i class="icon-plus-sign"></i>&nbsp; {{ trans('common.add') }}</a></p>
                  <p><a title="Book View" class="btn btn-info btn-sm" data-toggle="modal" href="{{URL::to('bookView')}}"><i class="icon-zoom-in"></i> {{ trans('common.view') }}</a></p>
               </div>
            </div>
            <div class="setup-item item-overlay">
               <i class="icon-tasks setup-icon overlay-bg"></i>
               <span class="setup-label overlay-bg">Books</span>
               <div class="item-overlay-body">
                  <p><a title="Add Book" class="btn btn-primary btn-sm"  data-toggle="modal" href="{{URL::to('bookEntry')}}"><i class="icon-plus-sign"></i>&nbsp; {{ trans('common.add') }}</a></p>
                  <p><a title="Book Show" class="btn btn-info btn-sm" data-toggle="modal" href="{{URL::to('bookList')}}"><i class="icon-zoom-in"></i> {{ trans('common.view') }}</a></p>
               </div>
            </div>
            <div class="setup-item item-overlay">
               <i class="icon-tasks setup-icon overlay-bg"></i>
               <span class="setup-label overlay-bg">Return</span>
               <div class="item-overlay-body">
                  <p><a title="{{ trans('return book') }}" class="btn btn-primary btn-sm"  data-toggle="modal" href="#modal" onclick="loadModal('returnBook')"><i class="icon-plus-sign"></i>&nbsp;Return</a></p>
                  <p><a title="{{ trans('frontEndTitle.view_class_wise_group_setup') }}" class="btn btn-info btn-sm"     data-toggle="modal" href="#modal" onclick="loadModal('loadViewGroupSetupModal')"><i class="icon-zoom-in"></i> {{ trans('common.view') }}</a></p>
               </div>
            </div>
           

         </div>
      </div>
      <!-- /widget-content -->            
   </div>
   <!-- /widget -->
</div>
<!-- /span6 -->
@endsection