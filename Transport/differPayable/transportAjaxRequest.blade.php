<script type="text/javascript">
    $("#datepicker").datepicker({dateFormat: 'yy-m-d'});
    var submitButton = $("#submit-button").hide();
    var loading      = $('.loading');
    var tableContent = $('#tableContent');
    var classInfo    = $('.class-info');
    $('#nullStd').html('');


    //===@@ Geting Class Wise Group @@=====

    $('#class_select').on('change', function (e) {
        var classId = e.target.value;
        var loader = $('.loader2');
        var groupOption = $('#group_select');
        $.ajax({
            url: "{{URL::to('branchWiseGroupName')}}/" + classId + '/groups',
            processData: false,
            contentType: false,
            beforeSend: function () {
                loader.show();
                classInfo.html('');
            },
            success: function (data) {
                groupOption.empty();
                groupOption.append('<option value="" selected disabled>Please select</option>');
                $.each(data, function (index, value) {
                    groupOption.append('<option value="' + value.group_name_id + '">' + value.group_name + '</option>');
                });
                $('#batch_select, #shift_select, #section_select').empty();
                submitButton.hide();
                tableContent.empty();
                $('#nullStd').html('');
                loader.hide();

            },
            error: function (data) {
                alert('error occurred! Please Check');
                loader.hide();
            }
        });

    });

    // ===@@ Getting Class&group  Wise Batch @@=====
    $('#group_select').on('change', function (e) {
        var sessionId = $('select[name=academic_session_id]').val();
        var classId = $('select[name=class_name_id]').val();
        var groupId = e.target.value;
        var loader = $('.loader3');
        var batchOption = $('#batch_select');
        $.ajax({
            url: "{{URL::to('classGroupWiseBatch')}}/" + sessionId + '/' + classId + '/' + groupId + '/batch',
            type: 'GET',
            dataType: 'json',
            beforeSend: function () {
                loader.show();
                classInfo.html('');
            },
            success: function (data) {
                batchOption.empty();
                batchOption.append('<option value="" selected disabled>Please select</option>');
                $.each(data, function (index, value) {
                    batchOption.append('<option value="' + value.batch_id + '">' + value.batch_name + '</option>');
                });
                $('#shift_select, #section_select').empty();
                submitButton.hide();
                tableContent.empty();
                $('#nullStd').html('');
                loader.hide();
            },
            error: function (data) {
                alert('error occurred! Please Check');
                loader.hide();
            }
        });

    });

    // ===@@ Getting Batch Wise Shift @@=====
    $('#batch_select').on('change', function (e) {
        var batchId = e.target.value;
        var loader = $('.loader4');
        var shiftOption = $('#shift_select');
        $.ajax({
            url: 'baseWiseShift/' + batchId + '/shift',
            type: 'GET',
            dataType: 'json',
            beforeSend: function () {
                loader.show();
                classInfo.html('');
            },
            success: function (data) {
                shiftOption.empty();
                shiftOption.append('<option value="" selected disabled>Please select</option>');
                $.each(data, function (index, value) {
                    shiftOption.append('<option value="' + value.shift_id + '">' + value.shift_name + '</option>');
                });
                $('#section_select').empty();
                submitButton.hide();
                tableContent.empty();
                $('#nullStd').html('');
                loader.hide();
            },
            error: function (data) {
                alert('error occurred! Please Check');
                loader.hide();
            }
        });

    });

    // ===@@ Getting Shift Wise Section @@=====
    $('#shift_select').on('change', function (e) {
        var shiftId = e.target.value;
        var loader = $('.loader5');
        var sectionOption = $('#section_select');
        $.ajax({
            url: 'shiftWiseSection/' + shiftId + '/section',
            type: 'GET',
            dataType: 'json',
            beforeSend: function () {
                loader.show();
                classInfo.html('');
            },
            success: function (data) {
                sectionOption.empty();
                sectionOption.append('<option value="" selected disabled>Please select</option>');
                $.each(data, function (index, value) {
                    sectionOption.append('<option value="' + value.section_id + '">' + value.section_name + '</option>');
                });
                submitButton.hide();
                tableContent.empty();
                $('#nullStd').html('');
                loader.hide();
            },
            error: function (data) {
                alert('error occurred! Please Check');
                loader.hide();
            }
        });

    });

    $('#section_select').on('change', function (e) {
        var sectionId = e.target.value;
        var batchWiseShiftId = $('#shift_select').val();
        var loader = $('.loader5');
        var sectionOption = $('#section_select');
        $.ajax({
            url: "{{URL::to('StudentsForTransportAssign')}}",
            type: 'GET',
            dataType: 'json',
            beforeSend: function () { classInfo.html(''); },
            data: {
                'section_setup_id':sectionId,
                'batch_wise_shift_id':batchWiseShiftId
            },
            beforeSend: function () {
                loading.show();
                $('#nullStd').html('');
                tableContent.empty();
            },
            success: function (data) {
                if (data.length < 1){
                    //submitButton.show();
                    submitButton.hide();
                    loading.hide();
                    $('#nullStd').html("No Student Found");
                    return false;
                }
                var content = '';
                var i = 1;
                $.each(data.result,function (key,val) {
                    var select='';
                $.each(data.transport,function (i,v) {
                    select+='<option value="'+v.id+'">'+v.route_name+'</option>'
                });
                    content += '<tr>'+
                            '<td>'+(i++)+'</td>'+
                            '<td>'+val.custom_student_id+'</td>'+
                            '<td>'+val.student_name_english+'</td>'+
                            '<td>'+val.roll_no+'</td>'+
                            '<td>'+((val.present_phone_mobile) ? val.present_phone_mobile : '')+'</td>'+
                            '<td><input type="hidden" name="sarId[]" value="'+val.academic_record_id+'"/></td>'+
                            '<td><select name="route_name[]" class="form-control">'+
                            '<option value="" selected>Please Select..</option>'+select+'</select></td>'+
                        '</tr>';
                });
                tableContent.append(content);
                loading.hide();
                var branch = "{{Session::get('user.current_branch_name')}}";
                var session = $('#academicSession_elect option:selected').text();
                var className = $('#class_select option:selected').text();
                var groupName = $('#group_select option:selected').text();
                var section = $('#section_select option:selected').text();
                $('.branch-name').html(branch+' - '+session);
                classInfo.html(className +' , '+ groupName +' , '+ section);
            },
            error: function (data) {
                //alert('error occurred! Please Check');
                loading.hide();
            }
        });

    });

    $(".checkAll").change(function () {
        $("input:checkbox").prop('checked', $(this).prop("checked"));
    });

</script>