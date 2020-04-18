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
        <div class="widget stacked">
            <div class="widget-header" id="printPreviewNone">
                <i class="icon-plus-sign"></i>
                <h3>Library Member Register Form</h3>
            </div>
            <!-- /widget-header -->
                {!! Form::open(['route' => 'libraryMemberSave','id' => 'studentPaymentForm']) !!}
                <div class="widget-content" id="wrp-bg">
                     <div class="col-md-7" style="margin: 0; padding: 0;">
                    <div class="form-group printNone">
                        <label class="col-sm-4">Select Desire Session</label>
                        <div class="col-sm-6">
                           <select class="form-control" name="session" id="session_select">
                            @if($sessions)
                            @foreach($sessions as $session)
                               <option value="{{$session->id}}">{{$session->session_name}}</option>
                            @endforeach
                            @endif
                           </select>
                        </div>
                        <span id="loader"></span>
                    </div>
                </div>
                <br><br>
                <div class="col-md-7" style="margin: 0; padding: 0;">
                    <div class="form-group printNone">
                        <label class="col-sm-4">Select Desire Class </label>
                        <div class="col-sm-6">
                           <select class="form-control" name="class" id="class_select">
                            <option disabled selected="">Please Select</option>
                            @if($classNames)
                            @foreach($classNames as $class)
                               <option value="{{$class->id}}">{{$class->class_name}}</option>
                            @endforeach
                            @endif
                           </select>
                        </div>
                        <span id="loader"></span>
                    </div>
                </div>
                <br><br>
                <div class="col-md-7" style="margin: 0; padding: 0;">
                    <div class="form-group printNone">
                        <label class="col-sm-4">Select Desire Section</label>
                        <div class="col-sm-6">
                           <select class="form-control" name="section" id="section_select">
                           </select>
                        </div>
                        <span id="loader"></span>
                    </div>
                </div>
                <br><br>
                <div class="col-md-7" style="margin: 0; padding: 0;">
                    <div class="form-group printNone">
                        <label class="col-sm-4">Select Desire Roll</label>
                        <div class="col-sm-6">
                           <select class="form-control" name="sarid" id="roll_select" select2>
                              
                           </select>
                        </div>
                        <span id="loader"></span>
                    </div>
                </div>
                <br><br>
                <div class="col-md-7" style="margin: 0; padding: 0;">
                    <div class="form-group printNone">
                        <label class="col-sm-4">Selected Id</label>
                        <div class="col-sm-6">
                           <input type="text" name="fk_custom_student_id" class="form-control fk_custom_student_id" id="fk_custom_student_id" readonly="" value="">
                        </div>
                        <span id="loader"></span>
                    </div>
                </div>
                <div class="col-md-7" style="margin: 0; padding: 0;">
                    <div class="form-group printNone">
                        <label class="col-sm-4"></label>
                        <div class="col-sm-6">
                            <br>
                            <button type="Submit" id="submitBtn" class="btn btn-success" disabled>Register</button>
                        </div>
                        <span id="loader"></span>
                    </div>
                </div>
                </div>

                {!! Form::close() !!}
        </div>
    </div>
    @include('ajax.ajaxGlobalVar')
    <script>
        $("#class_select").on('change',function(e){
            var classId=$("#class_select option:selected").val();
            var sessionId=$("#session_select option:selected").val();
            $.ajax({
                type:"GET",
                dataType: "json",
                url:"{{URL::to('getSessionNameByClassId')}}",
                data:{'classId':classId,'sessionId':sessionId},
                success:function(data)
                {
                    $("#section_select").empty();
                        $('#section_select').append('<option value="" selected disabled>please select</option>');
                    $.each(data, function(index, value){
                        $('#section_select').append('<option value="'+ value.sectionId +'">'+ value.section_name +'</option>');
                    });
                },
                error:function(data)
                {
                    console.log(data);
                }
            });
        })
    $("#section_select").on('change',function(e){
        var classId=$("#class_select option:selected").val();
        var sessionId=$("#session_select option:selected").val();
        var sectionId=$("#section_select option:selected").val();
        $.ajax({
            type:"GET",
            dataType: "json",
            url:"{{URL::to('getRollBySection')}}",
            data:{'sectionId':sectionId},
            success:function(data)
            {
                $("#roll_select").empty();
                $('#roll_select').append('<option value="" selected disabled>please select</option>');
                $.each(data, function(index, value){
                    $('#roll_select').append('<option value="'+ value.sarId +'">'+ value.roll_no +'</option>');
                });
            },
            error:function(data)
            {
                console.log(data);
            }
        });
    })

    $("#roll_select").on('change',function(){
      var sarId=$("#roll_select option:selected").val();
      $.ajax({
            type:"GET",
            dataType: "json",
            url:"{{URL::to('getCustomIdBySarId')}}",
            data:{'sarId':sarId},
            success:function(data)
            {
                $("#fk_custom_student_id").empty();
                $('#fk_custom_student_id').val(data.data);
                $("#submitBtn").prop("disabled", false); 
            },
            error:function(data)
            {
                console.log(data);
            }
        });
    })

 </script>
@endsection


