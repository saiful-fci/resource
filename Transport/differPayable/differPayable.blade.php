@extends('app')

@section('content')
    <style>
        @media print {
            .no-show-print{display: none}
            .widget-header{display: none}
            .table-bordered thead tr th{padding-left: 20px !important; font-size: 22px !important; border: 1px solid #000 !important;}
            .table-bordered tbody tr td{padding-left: 20px !important; font-size: 20px !important; border: 1px solid #000 !important;}
            .school_name{font-size: 28px;}
            #back-to-top{display: none !important; visibility: hidden;}
        }
    </style>
    {!! Form::open(array('class' => 'form-horizontal form-wrp no-show-print','id'=>'stdAttnForm')) !!}
    <div class="col-md-12">
        <div class="widget stacked">
            <div class="widget-header">
                <i class="icon-plus-sign"></i>
                <h3>Differ Payable Setup</h3>
            </div> <!-- /widget-header -->
            @if(\Session::has('success'))
            <p class="widget-header alert alert-success">
                {!!\Session::get('success')!!}
            </p>
            @elseif(\Session::has('error'))
            <p class="widget-header alert alert-success">
                {!!\Session::get('error')!!}</p>
            @endif
            <div class="widget-content" id="wrp-bg">
                <div class="form-group">
                    <label for="" class="col-sm-2">Select Session <span style="color:red;">*</span> </label>
                    <div class="col-sm-3">
                        <select class="form-control input-sm" name="academic_session_id" id="academicSession_elect"
                                required data-placeholder="select" class="chosen-select">
                            @foreach($getSessions as $session)
                                <option value="{{$session->id}}">{{$session->session_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <label for="" class="col-sm-2">Select Class<span style="color:red;">*</span> </label>
                    <div class="col-sm-3">
                        <select class="form-control input-sm" name="class_name_id" id="class_select" required>
                            <option value="" selected disabled>Select Class</option>
                            @foreach($getClass as $classValue)
                                <option value="{{$classValue->class_name_id}}">{{$classValue->class_name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="" class="col-sm-2">Select Group<span style="color:red;">*</span> </label>
                    <div class="col-sm-3">
                        <span class='loader2' style="display:none;"><img src="public/icons/ajax-loader.gif"
                                                                         alt="loading"></span>
                        <select class="form-control input-sm group_name" name="group_name_id" id='group_select'
                                required></select>
                    </div>
                    <label for="" class="col-sm-2">Select Batch<span style="color:red;">*</span> </label>
                    <div class="col-sm-3">
                        <span class='loader3' style="display:none;"><img src="public/icons/ajax-loader.gif"
                                                                         alt="loading"></span>
                        <select class="form-control input-sm batch_name" name="batch_name_id" id='batch_select'
                                required></select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="" class="col-sm-2">Select Shift<span style="color:red;">*</span> </label>
                    <div class="col-sm-3">
                        <span class='loader4' style="display:none;"><img src="public/icons/ajax-loader.gif"
                                                                         alt="loading"></span>
                        <select class="form-control input-sm shift_name" name="shift_name_id" id='shift_select'
                                required></select>
                    </div>
                    <label for="" class="col-sm-2">Select Section<span style="color:red;">*</span> </label>
                    <div class="col-sm-3">
                        <span class='loader5' style="display:none;"><img src="public/icons/ajax-loader.gif"
                                                                         alt="loading"></span>
                        <select class="form-control input-sm section_name" name="section_setup_id" id='section_select'
                                required></select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-2">Select Head<span style="color:red;">*</span> </label>
                    <div class="col-sm-3">
                        <select class="form-control input-sm pay_head" name="pay_head" id='pay_head' required>
                        </select>
                    </div>
                    <label for="" class="col-sm-2">Select Month<span style="color:red;">*</span> </label>
                    <div class="col-sm-3">
                        <select class="form-control input-sm select_month" name="select_month" id='select_month' required>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-offset-2 col-md-2">
                        <button type="submit" class="btn btn-success btn-xs" id="submit-button" style="display:none"><i class="icon-save"></i> Save </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {!! Form::close() !!}

    <div class="col-md-12">
        <div class="widget stacked">
            <div class="widget-header class_for_print_media_two">
            </div> <!-- /widget-header -->
            <div class="widget-content progressReportDiv" id="wrp-bg">
                <div style="padding: 20px;text-align:center; color: #5E6C4B; font-size: 24px; line-height:25px;" class="row title_heading" id="heading">
                    <span style="float:left; margin-left:25px;">
                        {!! HTML::image("public/images/msc-logo.pngg", "Logo", ['class'=> 'logo']) !!}
                    </span>
                    <span class="school_name">{{Session::get('user.current_branch_name_english')}}</span><br>
                    <span style="font-size: 22px;" class="class-info"></span><br>
                    <span style="font-size: 22px;" class="branch-name"></span>
                </div>
                <form action="{{URL::to('differPayableAssign')}}" method="POST">
                    {{csrf_field()}}
                    <button type="submit" class="btn btn-success btn-xs pull-right" style="margin-bottom:10px;">Submit</button>
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th width="130px">SL No.</th>
                        <th>ID</th>
                        <th>Student Name</th>
                        <th>Roll No</th>
                        <th>Mobile Number</th>
                        <th>Route</th>
                        <th>Amount</th>
                    </tr>
                    </thead>
                    <tbody id="tableContent">

                    </tbody>
                </table>
                <div id="nullStd" class="text-center text-danger" style="font-weight: bolder;font-size: 18px"></div>
            </form>
            </div>
        </div>
    </div>
    @include('fees.differPayable.ajaxRequest')
<script type="text/javascript">
    $(document).ready(function(){
        $('#select_month').on('change',function(e){
            var sectionId = $("#section_select option:selected").val();
            var pay_head=$("#pay_head option:selected").val();
            var monthId=e.target.value;
            var row=$('<tr><td><input type="hidden" class="form-control" name="pay_head" value="'+pay_head+'"/></td><td><input type="hidden" class="form-control" name="sectionId" value="'+sectionId+'"/></td><td><input type="hidden" class="form-control" name="monthId" value="'+monthId+'"/></td></tr>');
            row.appendTo('#tableContent');

        })
    })
</script>
@endsection
