<head><title><?=$header;?> | <?=$this->config->item('system_name_long');?> (<?=$this->config->item('system_name_short');?>)</title></head>

<div class="page-content-wrapper">
  <div class="page-content">
    <h3 class="page-title">Job Order <small>samples receiving</small></h3>
    <div class="page-bar">
      <ul class="page-breadcrumb">
        <li><a href="javascript:history.back();"><i class="btn-xl fa fa-arrow-circle-o-left"></i></a></li>
        <li>
          <i class="fa fa-home"></i>
          <a href="<?=base_url('admin');?>">Home</a>
          <i class="fa fa-angle-right"></i>
        </li>
        <li>
          <a href="#"><?=$header;?></a>
        </li>
      </ul>
    </div>

    <!-- BEGIN PAGE CONTENT-->
    <div class="row">
      <div class="col-md-12">
        <div class="portlet box blue-hoki" id="form_wizard_1">
          <div class="portlet-title">
            <div class="caption">
              <i class="fa fa-gift"></i> Form Wizard - <span class="step-title">
              Step 1 of 4 </span>
            </div>
            <div class="tools hidden-xs">
              <a id="newJO" href="javascript:;" class="expand"> </a>
            </div>
          </div>
          <div id="newJOform" class="portlet-body form" style="display:none;">
            <form action="#" class="form-horizontal" id="submit_form" method="POST">
              <div class="form-wizard">
                <div class="form-body">
                  <input type="text" class="hidden" required id="jo_id" name="jo_id" value="0" />
                  <input type="text" class="hidden" required id="jo_status" name="jo_status" value="active" />
                  <ul class="nav nav-pills nav-justified steps">
                    <li>
                      <a href="#tab1" data-toggle="tab" class="step" id="first_tab">
                        <span class="number"> 1 </span>
                        <span class="desc"> <i class="fa fa-check"></i> Customer Info </span>
                      </a>
                    </li>
                    <li>
                      <a href="#tab2" data-toggle="tab" class="step">
                      <span class="number"> 2 </span>
                      <span class="desc"> <i class="fa fa-check"></i> Application Details </span>
                      </a>
                    </li>
                    <li>
                      <a href="#tab3" data-toggle="tab" class="step">
                        <span class="number"> 3 </span>
                        <span class="desc"> <i class="fa fa-check"></i> Terms and Conditions </span>
                      </a>
                    </li>
                    <li>
                      <a href="#tab4" data-toggle="tab" class="step">
                        <span class="number"> 4 </span>
                        <span class="desc"> <i class="fa fa-check"></i> Confirm </span>
                      </a>
                    </li>
                  </ul>
                  <div id="bar" class="progress progress-striped" role="progressbar">
                    <div class="progress-bar progress-bar-success"> </div>
                  </div>
                  <div class="tab-content">
                    <div class="alert alert-danger display-none">
                      <button class="close" data-dismiss="alert"></button> You have some form errors. Please check below.
                    </div>
                    <div class="alert alert-success display-none">
                      <button class="close" data-dismiss="alert"></button> Your form validation is successful!
                    </div>

                    <div class="tab-pane active" id="tab1">
                      <h3 class="block">Provide customer details</h3>

                      <div class="form-group">
                        <label class="control-label col-md-3">Date <span class="required"> * </span> </label>
                        <div class="col-md-4">
                          <input type="date" required class="form-control" name="date_submitted" id="date_submitted" value="<?=date("Y-m-d");?>" onchange="date_converter('date_submitted');">
                          <input type="text" class="hidden" id="show_date_submitted" name="show_date_submitted" />
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3">Job Order No. <span class="required"> * </span> </label>
                        <div class="col-md-4">
                          <input type="text" required class="form-control" id="jo_no" name="jo_no" onkeyup="check_duplicate_JO()" placeholder="JOF-BMRS-" value="JOF-BMRS-"><!-- <?=date('y');?> -->
                          <span class="help-block help-block-error font-red hidden" id="deJO_no">Duplicate entry! Please change.</span>
                        </div>
                        <script>
                        function check_duplicate_JO() {
                          $.ajax ({
                            type:"POST", async: true, data:{ jo_no:$('#jo_no').val() }, dataType: 'json', cache: false,
                            url:"<?=site_url('joborder/check_duplicate_jo'); ?>",
                            success: function(data) {
                              if(data) {
                                $("#deJO_no").removeClass("hidden");
                                $("#actionButtons").addClass("hidden");
                                $('#jo_no').focus();
                              } else {
                                $("#deJO_no").addClass("hidden");
                                $("#actionButtons").removeClass("hidden");
                                $('#jo_no').focus();
                              }
                            },
                            error: function(data) {
                              $("#deJO_no").addClass("hidden");
                              $("#actionButtons").removeClass("hidden");
                              $('#jo_no').focus();
                            }
                          });
                        }
                        </script>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3">Company <span class="required"> * </span></label>
                        <div class="col-md-4">
                          <input type="text" required class="form-control" id="company" name="company" list="company_list" onchange="get_company_details();">
                          <datalist id="company_list"></datalist>
                          <script>
                          $(function() {
                            $.post("<?=base_url('joborder/get_companies');?>")
                            .done(function(data) {
                              for (var i = 0; i < data.length; i++) {
                                $('#company_list').append("<option value='" + data[i]['company'] + "'>");
                              }
                            });
                          });
                          </script>
                        </div>
                      </div>

                      <script>
                        function get_company_details() {

                          $.post("<?=base_url('joborder/get_specific_address');?>", {company: $('#company').val()} )
                          .done(function(data) {
                            $('#address_list').empty();
                            for (var i = 0; i < data.length; i++) {
                              $('#address_list').append("<option value='" + data[i]['address'] + "'>");
                            }
                          });

                          $.post("<?=base_url('joborder/get_specific_address');?>", {company: $('#company').val()} )
                          .done(function(data) {
                            $('#address_list').empty();
                            for (var i = 0; i < data.length; i++) {
                              $('#address_list').append("<option value='" + data[i]['address'] + "'>");
                            }
                          });

                          $.post("<?=base_url('joborder/get_specific_applicant');?>", {company: $('#company').val()} )
                          .done(function(data) {
                            $('#applicant_list').empty();
                            for (var i = 0; i < data.length; i++) {
                              $('#applicant_list').append("<option value='" + data[i]['applicant'] + "'>");
                            }
                          });

                          $.post("<?=base_url('joborder/get_specific_designation');?>", {company: $('#company').val()} )
                          .done(function(data) {
                            $('#designation_list').empty();
                            for (var i = 0; i < data.length; i++) {
                              $('#designation_list').append("<option value='" + data[i]['designation'] + "'>");
                            }
                          });

                          $.post("<?=base_url('joborder/get_specific_contact_number');?>", {company: $('#company').val()} )
                          .done(function(data) {
                            $('#contact_number_list').empty();
                            for (var i = 0; i < data.length; i++) {
                              $('#contact_number_list').append("<option value='" + data[i]['contact_number'] + "'>");
                            }
                          });

                          $.post("<?=base_url('joborder/get_specific_email_address');?>", {company: $('#company').val()} )
                          .done(function(data) {
                            $('#email_address_list').empty();
                            for (var i = 0; i < data.length; i++) {
                              $('#email_address_list').append("<option value='" + data[i]['email_address'] + "'>");
                            }
                          });

                          $.post("<?=base_url('joborder/get_specific_contact_person');?>", {company: $('#company').val()} )
                          .done(function(data) {
                            $('#contact_person_list').empty();
                            for (var i = 0; i < data.length; i++) {
                              $('#contact_person_list').append("<option value='" + data[i]['contact_person'] + "'>");
                            }
                          });

                        }
                      </script>

                      <div class="form-group">
                        <label class="control-label col-md-3">Address <span class="required"> * </span></label>
                        <div class="col-md-4">
                          <input type="text" required class="form-control" id="address" name="address" list="address_list">
                          <datalist id="address_list"></datalist>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3">Applicant <span class="required"> * </span></label>
                        <div class="col-md-4">
                          <input type="text" required class="form-control" id="applicant" name="applicant" list="applicant_list">
                          <datalist id="applicant_list"></datalist>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3">Designation <span class="required"> * </span></label>
                        <div class="col-md-4">
                          <input type="text" required class="form-control" id="designation" name="designation" list="designation_list">
                          <datalist id="designation_list"></datalist>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3">Phone/Fax Number</label>
                        <div class="col-md-4">
                          <input type="text" class="form-control" id="contact_number" name="contact_number" list="contact_number_list">
                          <datalist id="contact_number_list"></datalist>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3">Email address</label>
                        <div class="col-md-4">
                          <input type="text" class="form-control" id="email_address" name="email_address" list="email_address_list">
                          <datalist id="email_address_list"></datalist>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3">Contact person in case of question regarding analysis:</label>
                        <div class="col-md-4">
                          <input type="text" class="form-control" id="contact_person" name="contact_person" list="contact_person_list">
                          <datalist id="contact_person_list"></datalist>
                        </div>
                      </div>

                    </div>

                    <div class="tab-pane" id="tab2">
                      <h3 class="block">Provide application details</h3>

                      <div class="form-group">
                        <label class="control-label col-md-3">Sample Type <span class="required"> * </span></label>
                        <div class="col-md-4">
                          <input type="text" required class="form-control" id="sample_type" name="sample_type">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3">Packaging Type <span class="required"> * </span></label>
                        <div class="col-md-4">
                          <input type="text" required class="form-control" id="packaging_type" name="packaging_type">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3">Sample Description</label>
                        <div class="col-md-4">
                          <input type="text" class="form-control" id="sample_description" name="sample_description">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3">Analysis Requested <span class="required"> * </span></label>
                        <div class="col-md-4">
                          <div class="radio-list">
                            <label> <input type="radio" required id="analysis_requested_APC" name="analysis_requested" value="APC" onclick="change_analysis('APC');"> Aerobic Plate Count </label>
                            <label> <input type="radio" required id="analysis_requested_MYC" name="analysis_requested" value="MYC" onclick="change_analysis('MYC');"> Molds and Yeasts Count </label>
                            <label> <input type="radio" required id="analysis_requested_BIO" name="analysis_requested" value="BIO" onclick="change_analysis('BIO');"> Bioburden </label>
                              <div class="radio-list BIO-types" style="display:none;">
                                <label style="padding-left: 15px;"> <input type="radio" id="analysis_requested_BIO_big" name="analysis_requested_two" value="big" onclick="change_fee();"> Big sample </label>
                                <label style="padding-left: 15px;"> <input type="radio" id="analysis_requested_BIO_small" name="analysis_requested_two" value="small" onclick="change_fee();"> Small sample </label>
                              </div>
                            <label> <input type="radio" required id="analysis_requested_STT" name="analysis_requested" value="STT" onclick="change_analysis('STT');"> Sterility Testing </label>
                              <div class="radio-list STT-types" style="display:none;">
                                <label style="padding-left: 15px;"> <input type="radio" id="analysis_requested_STT_big" name="analysis_requested_two" value="big" onclick="change_fee();"> Big sample </label>
                                <label style="padding-left: 15px;"> <input type="radio" id="analysis_requested_STT_small" name="analysis_requested_two" value="small" onclick="change_fee();"> Small sample </label>
                              </div>
                            <label> <input type="radio" required id="analysis_requested_PTC" name="analysis_requested" value="PTC" onclick="change_analysis('PTC');"> MPN-Presumtive Test for Coliforms </label>
                            <label> <input type="radio" required id="analysis_requested_OTH" name="analysis_requested" value="OTH" onclick="change_analysis('OTH');"> Others </label>
                            <table>
                              <tr>
                                <td style="width: 150px !important"><input style="display:none;" required name="custom_analysis_requested" id="custom_analysis_requested" type="text" class="form-control col-md-6" placeholder="Please specify" onkeyup="validate_analysis();" onchange="validate_analysis();"></td>
                                <td style="width: 10px !important"></td>
                                <td style="width: 150px !important"><input min="0" style="display:none;" name="fee_per_sample" id="fee_per_sample" type="number" class="form-control col-md-3" placeholder="Fee Per Sample" onkeyup="change_fee();" onchange="change_fee();" /></td>
                              </tr>
                            </table>
                          </div>
                        </div>
                        <script>

                          function change_analysis(ar) {
                            if(ar == 'APC' || ar == 'MYC' || ar == 'BIO' || ar == 'STT' || ar == 'PTC') {

                              if (ar == 'BIO') {
                                $('.BIO-types').show(); $('.STT-types').hide();
                              } else if ( ar == 'STT') {
                                $('.STT-types').show(); $('.BIO-types').hide();
                              } else {
                                $('.BIO-types, .STT-types').hide();
                                $('input[name="analysis_requested_two"]').prop('checked', false); $.uniform.update();
                              }

                              $('#custom_analysis_requested').val(ar).hide(); $('#fee_per_sample').val('').hide();
                            } else {
                              $('.BIO-types, .STT-types').hide();
                              $('#custom_analysis_requested').val('').show(); $('#fee_per_sample').val('').show();

                            }

                            change_fee();
                          }

                          function validate_analysis() {
                            var ar = $('#custom_analysis_requested').val();
                            if( (ar == 'APC' || ar == 'MYC' || ar == 'BIO' || ar == 'STT' || ar == 'PTC') && $('input[name=analysis_requested]:checked').val() == 'OTH' ) {
                              alert("Invalid Analysis"); $('#custom_analysis_requested').val('').focus();
                            }
                          }
                        </script>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-2"></label>
                        <div class="col-md-6">
                          <table class="table table-striped table-bordered datatables" align="center">
                            <thead>
                              <tr>
                                <th width="130px">PNRI Code <span class="required"> * </span></th>
                                <th>Lot Number(s)/Batch Number(s) <span class="required"> * </span></th>
                                <th>Amount <span class="required"> * </span></th>
                                <th><button type="button" id="addItemBtn" onclick="addline();" class="btn btn-default blue btn-sm"><i class="fa fa-plus"></i> Add</button></th>
                              </tr>
                            </thead>
                            <tbody id="addlinehere">

                            </tbody>
                            <tfoot>
                              <tr>
                                <th colspan="2">Cost of Analysis:</th>
                                <th colspan="2"><input type="number" readonly class="form-control" id="cost_of_analysis" name="cost_of_analysis" value="0" /></th>
                              </tr>
                              <tr>
                                <th colspan="2">Additional Costs:</th>
                                <th colspan="2"><input type="number" class="form-control" id="additional_costs" name="additional_costs" value="0" onkeyup="compute_total();" onchange="compute_total();" /></th>
                              </tr>
                              <tr>
                                <th colspan="2">Total Cost:</th>
                                <th colspan="2"><input type="number" readonly class="form-control" id="total_cost" name="total_cost" value="0" /></th>
                              </tr>
                            </tfoot>
                          </table>
                          <script>
                            var ln = 0;

                            function addline() {
                              $('#addlinehere').append(
                                '<tr class="otherAddedLines line-'+ln+'">' +
                                  '<td><input type="text" required id="pnri_code_'+ln+'"        name="pnri_code[]"        class="form-control" onkeyup="check_duplicate_pnri_code('+ln+');" />' +
                                    '<span class="help-block help-block-error font-red hidden" id="duplicate_pnri_code_'+ln+'">Duplicate entry! Please change.</span>'+
                                  '</td>' +
                                  '<td><input type="text" required id="item_description_'+ln+'" name="item_description[]" class="form-control"></td>' +
                                  '<td><input type="text" required id="amount_'+ln+'" readonly  name="amount[]"           class="form-control"></td>' +
                                  '<td>' +
                                    '<button type="button" class="btn red deletor" name="btn_exit[]" onclick="removethisline('+ln+')"><i class="fa fa-times"></i></button>' +
                                    '<input type="text" id="jo_item_id_'+ln+'" name="jo_item_id[]" value="0">' +
                                  '</td>' +
                                '</tr>');

                              change_fee(ln);

                              ln++;
                            }

                            function removeallines() {
                              $('#addlinehere').empty();
                              ln = 0;
                            }

                            function removethisline(num) {
                              if ($('#jo_item_id_'+num).val() == '0') {
                                $('.line-'+num).remove();
                              } else {

                                action = confirm('Are you sure you want to delete this line?');
                                if (action) {
                                  var item_id = $('#jo_item_id_'+num).val();
                                  $.ajax({ url: "<?=base_url('joborder/remove_this_line');?>", async: false, type:'post',
                                    data:{ jo_item_id : item_id },
                                    success: function(data) {
                                      if(data['result']) {
                                        $('.line-'+num).remove();
                                      } else {
                                        $.pnotify({ title: "We encountered a problem!", type: "error",
                                          text: "Please reload the page and try again." });
                                      }
                                    },
                                    error: function(data) {
                                      $.pnotify({ title: "We encountered a problem!", type: "error",
                                        text: "Please reload the page and try again." });
                                    }
                                  });

                                }

                              } // else end

                              change_fee();
                            } // removethisline end

                            function check_duplicate_pnri_code(num = ln) {

                              if ( !$('#pnri_code_'+num).val() ) { // Check if not empty
                                $("#pnri_code_"+num).attr("style", "border: 1px solid #922323 !important; color:#922323!important;")
                                $("#actionButtons").addClass("hidden");
                              } else { // Check for duplicates

                                $.ajax ({
                                  type:"POST", async: true, data:{ pnri_code:$('#pnri_code_'+num).val() }, dataType: 'json', cache: false,
                                  url:"<?php echo site_url('joborder/check_duplicate_pnri_code'); ?>",
                                  success: function(data) {
                                    if(data) {
                                      $("#duplicate_pnri_code_"+num).removeClass("hidden").show();
                                      $("#pnri_code_"+num).attr("style", "border: 1px solid #922323 !important; color:#922323!important;")
                                      //$("#actionButtons").addClass("hidden");

                                    } else {
                                      $("#duplicate_pnri_code_"+num).addClass("hidden").hide();
                                      $("#pnri_code_"+num).attr("style", "border: 1px solid #e5e5e5 !important; color:#3c763d!important;")
                                      $("#actionButtons").removeClass("hidden");
                                    }
                                  },
                                  error: function(data) {
                                    $("#duplicate_pnri_code_"+num).addClass("hidden").hide();
                                    $("#pnri_code_"+num).attr("style", "border: 1px solid #e5e5e5 !important; color:#3c763d!important;")
                                    $("#actionButtons").removeClass("hidden");
                                  }
                                });

                              }

                            }

                            function change_fee (num = -1) {
                              var ar = $('input[name=analysis_requested]:checked').val();
                              var ar2 = $('input[name=analysis_requested_two]:checked').val()
                              var poa = $('input[name=purpose_of_analysis]:checked').val();

                              if(ar == "OTH") {

                                if (num > -1) {
                                  $('#amount_'+num).val( $('#fee_per_sample').val() );
                                } else {
                                  $('input[name=amount\\[\\]]').val( $('#fee_per_sample').val() );
                                }

                              } else {

                                $.ajax ({ type:"POST", async: false, data:{ar:ar,ar2:ar2,poa:poa,num:num}, dataType: 'json', cache: false,
                                  url:"<?=site_url('joborder/change_fee'); ?>",
                                  success: function(data) {
                                    if (num > -1) { // specific
                                      $('#amount_'+num).val(data);
                                    } else { // all
                                      $('input[name=amount\\[\\]]').val(data);
                                    }
                                  },
                                });

                              }

                              compute_total()
                            } // function change_fee end

                            function compute_total() {
                              var cost_of_analysis = 0;
                              $('input[name="amount[]"]').each(function() {
                                cost_of_analysis += parseFloat( $(this).val() );
                              });

                              $('#cost_of_analysis').val(cost_of_analysis);
                              var additional_costs = parseFloat( $('#additional_costs').val() );
                              $('#total_cost').val(cost_of_analysis + additional_costs);
                            } // function compute_total end

                          </script>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3">Purpose of Analysis <span class="required"> * </span></label>
                        <div class="col-md-4">
                          <div class="radio-list">
                            <label> <input type="radio" required id="purpose_of_analysis_export" name="purpose_of_analysis" value="export" onclick="change_purpose('export');"> Export </label>
                            <label> <input type="radio" required id="purpose_of_analysis_regulatory" name="purpose_of_analysis" value="regulatory" onclick="change_purpose('regulatory');"> Regulatory </label>
                            <label> <input type="radio" required id="purpose_of_analysis_research" name="purpose_of_analysis" value="research" onclick="change_purpose('research');"> Research </label>
                            <label> <input type="radio" required id="purpose_of_analysis_local_market" name="purpose_of_analysis" value="local market" onclick="change_purpose('local market');"> Local Market </label>
                            <label> <input type="radio" required id="purpose_of_analysis_OTH" name="purpose_of_analysis" value="OTH" onclick="change_purpose('OTH');"> Others </label>
                            <table>
                              <tr>
                                <td style="width: 150px !important"><input type="text" required style="display:none;" name="custom_purpose_of_analysis" id="custom_purpose_of_analysis" class="form-control col-md-6" placeholder="Please specify" onkeyup="validate_purpose();" onchange="validate_purpose();"></td>
                              </tr>
                            </table>
                          </div>
                        </div>
                        <script>
                          function change_purpose(poa) {
                            if(poa == 'export' || poa == 'regulatory' || poa == 'research' || poa == 'local market') {
                              $('#custom_purpose_of_analysis').val(poa).hide();
                            } else {
                              $('#custom_purpose_of_analysis').val('').show();
                            }

                          }

                          function validate_purpose() {
                            var poa = $('#custom_purpose_of_analysis').val();
                            if( (poa == 'export' || poa == 'regulatory' || poa == 'research' || poa == 'local market') && $('input[name=purpose_of_analysis]:checked').val() == 'OTH' ) {
                              alert("Invalid Purpose of Analysis"); $('#custom_purpose_of_analysis').val('').focus();
                            }
                          }
                        </script>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3">Sample(s) to be returned? <span class="required"> * </span></label>
                        <div class="col-md-4">
                          <div class="radio-list">
                            <label> <input type="radio" required id="samples_returned_1" name="samples_returned" value="1" onclick="change_returned(1);" />Yes</label>
                            <label> <input type="radio" required id="samples_returned_0" name="samples_returned" value="0" onclick="change_returned(0);" />No</label>
                            <input type="text" class="hidden" id="show_change_returned" name="show_change_returned">
                          </div>
                        </div>
                      </div>
                      <script>
                        function change_returned(num) {
                          if(num == 1) $('#show_change_returned').val('Yes');
                          else if (num == 0) $('#show_change_returned').val('No');
                        }
                      </script>
                    </div>

                    <div class="tab-pane" id="tab3">
                      <h3 class="block">Read and Accept Terms and Conditions</h3>

                      <div class="form-group">
                        <div class="col-md-12">
                          <div class="note note-info">
                            <p>1) Results of analysis will be released on
                              <input type="date" required class="form-control" id="release_date" name="release_date" onchange="date_converter('release_date');" />
                              <input type="text" class="hidden" id="show_release_date" name="show_release_date" />
                            </p>

                          </div>
                        </div>
                      </div>


                      <div class="form-group">
                        <div class="col-md-12">
                          <div class="note note-info">
                            <p>2) Results will be released only to the customer who entered the job or to an authorized representative upon presentation of written authorization (see reverse side of this form), valid ID, and the official receipt.</p>
                          </div>
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="col-md-12">
                          <div class="note note-info">
                            <p>3) If no complaints regarding the results of the analysis are received within one (1) week after release of analysis report, these shall be considered acceptable and smaples can be disposed off.</p>
                          </div>
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="col-md-12">
                          <div class="note note-info">
                            <p>4) Analysis report not claimed after 30 days will be disposed off.</p>
                          </div>
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="col-md-12">
                          <div class="note note-info">
                            <p>5) The Institute is implementing CASH PAYMENT POLICY. The services being requested will be provided only upon presentation of the official receipt.</p>
                          </div>
                        </div>
                      </div>

                      <div class="form-group">
                        <div class="col-md-12">
                          <div class="note note-danger">
                            <p> <input type="checkbox" required name="agree_terms" id="agree_terms"/> I have read and agreed with all the terms and conditions stated upon and other supplementary provisions regarding special conditions and/or agreements.</p>
                          </div>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3">Date Approved: <span class="required"> * </span> </label>
                        <div class="col-md-4">
                          <input type="date" required class="form-control" name="date_approved" id="date_approved" value="<?=date("Y-m-d");?>" onchange="date_converter('date_approved');">
                          <input type="text" class="hidden" id="show_date_approved" name="show_date_approved" />
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3">Approved by <span class="required"> * </span></label>
                        <div class="col-md-4">
                          <select id="approved_by_id" name="approved_by_id" class="form-control select2me" onchange="change_analyst('approved');">
                          </select>
                          <input type="text" class="hidden" id="approved_by_name" name="approved_by_name" />
                          <input type="text" required class="form-control" id="approved_by_position" name="approved_by_position" />
                        </div>
                      </div>


                      <div class="form-group">
                        <label class="control-label col-md-3">Received by <span class="required"> * </span></label>
                        <div class="col-md-4">
                          <select id="received_by_id" name="received_by_id" class="form-control select2me" onchange="change_analyst('received');">
                          </select>
                          <input type="text" class="hidden" id="received_by_name" name="received_by_name" />
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3">Encoded by <span class="required"> * </span></label>
                        <div class="col-md-4">
                          <select id="encoded_by_id" name="encoded_by_id" class="form-control select2me" onchange="change_analyst('encoded');">
                          </select>
                          <input type="text" class="hidden" id="encoded_by_name" name="encoded_by_name" />
                        </div>
                      </div>

                      <script>
                        var usersdata = '';
                        $.ajax({
                           url: "<?=base_url("access/get_all_personnel");?>", async: false,
                           success: function(data) {
                              usersdata = '<option disabled selected> </option>\n';
                              for (var i = 0; i < data.length; i++) {
                                usersdata += '<option value="'+data[i]['id']+'">'+data[i]['full_name']+'</option>\n';
                              }
                              $('#received_by_id, #encoded_by_id, #approved_by_id').html(usersdata);
                           }
                         });

                         function change_analyst(type) {
                           $('#'+type+'_by_name').val( $("#"+type+"_by_id option:selected").html() );

                           if (type == 'approved') {
                             $.post("<?=base_url('access/get_personnel_details_via_id');?>", {id: $('#'+type+'_by_id').val()} )
                             .done(function(data) {
                               $('#'+type+'_by_position').val(data['position']);
                             });
                           }

                         }
                      </script>

                    </div>

                    <div class="tab-pane" id="tab4">
                      <h3 class="block">Confirm Job Order Details</h3>
                      <h4 class="form-section">Customer Information</h4>
                      <div class="form-group">
                        <label class="control-label col-md-3">Date Submitted:</label>
                        <div class="col-md-4">
                          <p class="form-control-static" data-display="show_date_submitted">
                          </p>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3">Job Order Number:</label>
                        <div class="col-md-4">
                          <p class="form-control-static" data-display="jo_no">
                          </p>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3">Company:</label>
                        <div class="col-md-4">
                          <p class="form-control-static" data-display="company">
                          </p>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3">Address:</label>
                        <div class="col-md-4">
                          <p class="form-control-static" data-display="address">
                          </p>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3">Applicant:</label>
                        <div class="col-md-4">
                          <p class="form-control-static" data-display="applicant">
                          </p>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3">Designation:</label>
                        <div class="col-md-4">
                          <p class="form-control-static" data-display="designation">
                          </p>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3">Phone/Fax Number:</label>
                        <div class="col-md-4">
                          <p class="form-control-static" data-display="contact_number">
                          </p>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3">Email Address:</label>
                        <div class="col-md-4">
                          <p class="form-control-static" data-display="email_address">
                          </p>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3">Contact person in case of question regarding analysis:</label>
                        <div class="col-md-4">
                          <p class="form-control-static" data-display="contact_person">
                          </p>
                        </div>
                      </div>

                      <h4 class="form-section">Application Information</h4>
                      <div class="form-group">
                        <label class="control-label col-md-3">Sample Type:</label>
                        <div class="col-md-4">
                          <p class="form-control-static" data-display="sample_type">
                          </p>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3">Packaging Type:</label>
                        <div class="col-md-4">
                          <p class="form-control-static" data-display="packaging_type">
                          </p>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3">Sample Description:</label>
                        <div class="col-md-4">
                          <p class="form-control-static" data-display="sample_description">
                          </p>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3">Analysis Requested:</label>
                        <div class="col-md-4">
                          <p class="form-control-static" data-display="custom_analysis_requested">
                          </p>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3">Purpose of Analysis:</label>
                        <div class="col-md-4">
                          <p class="form-control-static" data-display="custom_purpose_of_analysis">
                          </p>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3">Sampes to be Returned:</label>
                        <div class="col-md-4">
                          <p class="form-control-static" data-display="show_change_returned">
                          </p>
                        </div>
                      </div>

                      <h4 class="form-section">Other Details</h4>

                      <div class="form-group">
                        <label class="control-label col-md-3">Date to be Released:</label>
                        <div class="col-md-4">
                          <p class="form-control-static" data-display="show_release_date">
                          </p>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3">Date Approved:</label>
                        <div class="col-md-4">
                          <p class="form-control-static" data-display="show_date_approved">
                          </p>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3">Approved By:</label>
                        <div class="col-md-4">
                          <p class="form-control-static" data-display="approved_by_name">
                          </p>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3">Received By:</label>
                        <div class="col-md-4">
                          <p class="form-control-static" data-display="received_by_name">
                          </p>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3">Encoded By:</label>
                        <div class="col-md-4">
                          <p class="form-control-static" data-display="encoded_by_name">
                          </p>
                        </div>
                      </div>

                    </div>
                  </div>
                </div>
                <div class="form-actions" id="actionButtons">
                  <div class="row">
                    <div class="col-md-offset-3 col-md-9">
                      <!-- REJECT BUTTON <a id="rejectBtn" href="javascript:;" class="btn red button-next">
                      Reject <i class="m-icon-swapdown m-icon-white"></i>
                    </a>-->
                      <a href="javascript:;" class="btn default button-previous">
                        <i class="m-icon-swapleft"></i> Back
                      </a>
                      <a id="continueBtn" href="javascript:;" class="btn blue button-next">
                        Continue <i class="m-icon-swapright m-icon-white"></i>
                      </a>
                      <button type="submit" class="btn green button-submit">
                        Submit <i class="m-icon-swapright m-icon-white"></i>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    <script>

    function date_converter(name) {
      $.post("<?=base_url('joborder/date_converter');?>", {date: $('#'+name).val()} )
      .done(function(data) {
        $('#show_'+name).val(data);
      });
    }
    /* Bug Fix for Bootstrap Checkboxes */
    var bugFix001a = 1;
    var bugFix001b;
    function fixBugCheckBox() {
      $("span[for='analysis_requested'], span[for='purpose_of_analysis'], span[for='samples_returned']").remove();
    } /* Unused*/ function fixBugCheckBoxStop() { clearInterval(bugFix001b); }

    $('#continueBtn').on('click', (function(e) {
      if (bugFix001a == 1) { bugFix001b = setInterval(fixBugCheckBox, 500); } bugFix001a = 0;
    }));

    $('#submit_form').on('submit', (function(e) {
      e.preventDefault();
      if($("#submit_form").valid()) {
        $('#actionButtons').hide();

        $.ajax({ type:"POST", async: false, contentType: false, cache: false, processData:false, data: new FormData(this),
          url:"<?=site_url('joborder/create_update');?>",
          success: function(data) {
            if (data['jo']) {
              $.pnotify({ title: "Succes!", type: "success",
                text: "Job Order successfully added!" });
              loadTables(); reset_JO_UI(); clear_JO_form();
            } else {
              $.pnotify({ title: "We encountered a problem!", type: "info",
                text: "Please check your application and try again." });
            }
          },
          error: function(data) {
            $.pnotify({ title: "We encountered a problem!", type: "error",
              text: "Please reload the page and try again." });
          }

        });

        $('#alertvalidation, #infovalidation, #successvalidation').hide();
        $('#actionButtons').show();
      } else { // if invalid submit form
        $.pnotify({ title: "We encountered a problem!", type: "error",
          text: "Please check form and try again." });
      }

    }));
    </script>
    <!-- END PAGE CONTENT-->

    <div class="row">
      <div class="col-md-12">
        <div class="portlet light bordered">
          <div class="portlet-title">
            <div class="caption">
              <i class="fa fa-edit font-blue-hoki"></i>
              <span class="caption-subject font-blue-hoki bold uppercase">List of JOs</span>
            </div>
            <div class="actions">
              <a href="#" onclick="show_JO_creation();" class="btn btn-circle blue-hoki btn-sm">
              <i class="fa fa-plus"></i> New JO</a>
            </div>
          </div><!-- portlet-title -->
          <div class="portlet-body">
            <div class="row">
              <div class="btn-group btn-group-circle btn-group-solid pull-right" role="group">
                <button type="button" id="pendingBtn" class="btn grey reqtype" onclick="loadTables('pending')">For Approval JOs <span class="badge pending-jo" style="background-color: #f3565d !important;"></span></button>
                <button type="button" id="activeBtn" class="btn grey reqtype" onclick="loadTables('active');">Active JOs</button>
              </div>
            </div>
            <br>
            <div class="row">
              <div class="table-responsive table-pending">
                <table class="table table-bordered datatables" id="table">
                  <thead>
                    <tr>
                      <th>JO No</th>
                      <th>Company</th>
                      <th>Applicant</th>
                      <th>Analysis Requested</th>
                      <th>Samples</th>
                      <th>Release Date</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div><!-- /table-responsive -->
              <div class="table-responsive table-approval">
                <table class="table table-bordered datatables" id="approval">
                  <thead>
                    <tr>
                      <th>Company</th>
                      <th>Applicant</th>
                      <th>Analysis Requested</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
            </div><!-- /row -->
          </div><!-- /portlet-body -->
        </div><!-- portlet -->
      </div><!-- col-md-12 -->
    </div><!-- row -->

<!-- View Job Orders -->
<script>
  var last_type = 'active';
  function loadTables (type = last_type) {
    last_type = type;

    $('.reqtype').removeClass('active');
    $('#'+type+'Btn').addClass('active');

    var table = "";
    if(type == "active") {
      table = "table";
      $(".table-pending").show(); $('.table-approval').hide();
    } else if (type == "pending") {
      table = "approval";
      $(".table-pending").hide(); $('.table-approval').show();
    }

    $('#'+table).dataTable().fnClearTable();
    $('#'+table).dataTable().fnDraw();
    $('#'+table).dataTable().fnDestroy();

    $('#'+table).dataTable({
        "serverSide"  : true,
        "sAjaxSource" : "<?=site_url('joborder/read');?>"+"/"+type,
        "aoColumnDefs": [
                          //{ "bSearchable": false, "bVisible": false, "aTargets": [ 1 ] }, // Sample
                          //{ "bVisible": false, "aTargets": [ 0, 9, 10 ] }, //
                          //{ "iDataSort": 2, "aTargets": [ 1 ] }, //Sort Date, but Real Sorting is by Job Order No
                          //{ "iDataSort":10, "aTargets": [ 11 ] },
                          //{ /*"sType": "numeric",*/ "sClass" : "text-right", "aTargets": [ 7 ] },
                          //{ "bSortable": false, "aTargets": [ 0, 9 ] } // Disable sorting of SOA Check Box and Due Date
                        ],
        //"aaSorting"   : [[2,'desc']] // [[0,'desc'],[1,'desc']] // Sorting via Job Order
    });

    $('.dataTables_filter input').addClass('form-control').attr('placeholder','Search...');
    $('.dataTables_length select').addClass('form-control');

    setTimeout(function () { $('#'+table).css({"width": "100%"}); }, 550);
  }

  $(document).ready(function() {
    loadTables();
  });

  function show_JO_creation() {
    $("#newJO").removeClass('expand').addClass('collapse');
    $("#first_tab")[0].click();
    $("#newJOform").show(); clear_JO_form();
    $("#date_submitted").focus();

    removeallines();
    addline();
  }

  function clear_JO_form () {
    $('#submit_form')[0].reset(); $('#agree_terms').attr('checked', false);
    date_converter('date_submitted'); date_converter('date_approved'); date_converter('release_date');
    $.uniform.update();
  }

  function reset_JO_UI() {
    $("#first_tab").click(); $("#newJO").click();
  }

  function retrieve_JO(jo_retrieve_id) {
    $("#newJO").removeClass('expand').addClass('collapse');
    $("#newJOform").show(); clear_JO_form();

    $('#jo_id').val(jo_retrieve_id);

    $.ajax({ type:"POST", async: true, data:{selected_jo_id:jo_retrieve_id}, dataType: 'json', cache: false,
      url:"<?=site_url('joborder/read_selected_id'); ?>",
      success: function(data) {
        if(data) {
          console.log(data);
          $('#jo_id').val( data['jo_data']['id'] );
          $('#date_submitted').val( data['jo_data']['date_submitted'] ); date_converter('date_submitted');
          $('#jo_no').val( data['jo_data']['jo_no'] );
          $('#company').val( data['jo_data']['company'] );
          $('#address').val( data['jo_data']['address'] );
          $('#applicant').val( data['jo_data']['applicant'] );
          $('#designation').val( data['jo_data']['designation'] );
          $('#contact_number').val( data['jo_data']['contact_number'] );
          $('#email_address').val( data['jo_data']['email_address'] );
          $('#contact_person').val( data['jo_data']['contact_person'] );

          // Tab2

          $('#sample_type').val( data['jo_data']['sample_type'] );
          $('#packaging_type').val( data['jo_data']['packaging_type'] );
          $('#sample_description').val( data['jo_data']['sample_description'] );

          if (data['jo_data']['analysis_requested'] == 'APC' ||
              data['jo_data']['analysis_requested'] == 'MYC' ||
              data['jo_data']['analysis_requested'] == 'BIO' ||
              data['jo_data']['analysis_requested'] == 'STT' ||
              data['jo_data']['analysis_requested'] == 'PTC'  ) {
            $('#analysis_requested_'+data['jo_data']['analysis_requested']).attr('checked', true); change_analysis(data['jo_data']['analysis_requested']);
          }
          else {
            $('#analysis_requested_OTH').attr('checked', true); change_analysis('OTH');
            $('#custom_analysis_requested').val( data['jo_data']['analysis_requested'] );
            //$('#fee_per_sample').val( data['jo_item_data'][0]['amount'] ); // NOTE (ZZ) Might Cause error if no samples were created
          }
          if (data['jo_data']['analysis_requested'] == 'BIO' ||
              data['jo_data']['analysis_requested'] == 'STT' ) {
            $('#analysis_requested_'+data['jo_data']['analysis_requested']+'_'+data['jo_data']['analysis_requested_two']).attr('checked', true);
          }
          // TODO (AAA) JS Function Here
          removeallines();
          for(var x=0; x < data['jo_item_data'].length; x++) {
            addline();
            $('#jo_item_id_'+x).val( data['jo_item_data'][x]['id'] );
            $('#pnri_code_'+x).val( data['jo_item_data'][x]['pnri_code'] );
            $('#item_description_'+x).val( data['jo_item_data'][x]['item_description'] );
            $('#amount_'+x).val( data['jo_item_data'][x]['amount'] );

            $('#fee_per_sample').val( data['jo_item_data'][x]['amount'] );
          }

          $('#additional_costs').val( data['jo_data']['additional_costs'] );

          if (data['jo_data']['purpose_of_analysis'] == 'export' ||
              data['jo_data']['purpose_of_analysis'] == 'regulatory' ||
              data['jo_data']['purpose_of_analysis'] == 'research' ||
              data['jo_data']['purpose_of_analysis'] == 'local market' ) {
            $('input[name="purpose_of_analysis"][value="'+data['jo_data']['purpose_of_analysis']+'"]').attr('checked', true); change_purpose(data['jo_data']['purpose_of_analysis']);
          } else {
            $('#purpose_of_analysis_OTH').attr('checked', true); change_purpose('OTH');
            $('#custom_purpose_of_analysis').val( data['jo_data']['purpose_of_analysis'] );
          }

          $('#samples_returned_'+data['jo_data']['samples_returned']).attr('checked', true); change_returned(data['jo_data']['samples_returned']);

          compute_total();

          // Tab3

          $('#release_date').val(data['jo_data']['release_date']); date_converter('date_submitted');
          $('#agree_terms').attr('checked', true);
          $('#approved_by_id').val(data['jo_data']['approved_by_id']); change_analyst('approved');
          $('#encoded_by_id').val(data['jo_data']['encoded_by_id']); change_analyst('encoded');
          $('#received_by_id').val(data['jo_data']['received_by_id']); change_analyst('received');
          $('#approved_by_id, #encoded_by_id, #received_by_id').select2().trigger('change');

          //$('#').val( data[''][''] );
          $.uniform.update();
          $("html, body").animate({scrollTop: 200}, 500);
        } else {
          $.pnotify({ title: "Data not found", type: "info",
            text: "Please reload the page and try again." });
        }
      },
      error: function(data) {
        $.pnotify({ title: "We encountered a problem!", type: "error",
          text: "Please reload the page and try again." });
      }
    });

  }

  function reject_JO(jo_reject_id) {
    $.ajax({ type:"POST", async: true, data:{jo_reject_id:jo_reject_id}, dataType: 'json', cache: false,
      url:"<?=site_url('joborder/reject_selected_jo_id'); ?>",
      success: function(data) {
        if(data["operation"]) {
          $.pnotify({ title: "Notification", type: "success",
            text: "Request successfuly rejected" });
          loadTables();
        } else {
          $.pnotify({ tite: "Error", type: "error",
            text: "Request failed to reject" });
        }
      },
      error: function(data) {
        $.pnotify({ title: "We encountered a problem!", type: "error",
          text: "Please reload the page and try again!" });
      }
    });

  }

</script>

<!-- JO Form via Modal Start -->
<div class="modal bs-modal-lg fade" id="previewJOmodal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="true">
  <div class="modal-dialog modal-lg"> <!-- modal-full -->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-xs-12">
            <iframe id="containerPreviewJO" class="col-xs-12" height="700" src=""></iframe>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
function preview_JO(joidform) {
  $('#previewJOmodal').modal();
  $('#containerPreviewJO').prop('src', '<?=base_url('export/jo');?>/' + joidform);
}
</script>
<!-- JO Form via Modal End -->
