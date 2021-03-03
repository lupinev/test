<script>
var bugFix002b;
$(function()
{
  setTimeout(function(){ fixBugRemoveSideBar(); }, 80);
  bugFix002b = setInterval(fixBugRemoveSideBar, 1500);
});

function fixBugRemoveSideBar() {
  $('.page-content, .page-content-wrapper').attr('style', 'margin-left: unset !important;');
} /* Unused*/ function fixBugRemoveSideBarStop() { clearInterval(bugFix001b); }

</script>

<div class="page-content-wrapper">
  <div class="page-content">

    <!-- BEGIN PAGE CONTENT -->
    <div class="row">
      <div class="col-md-12">
        <div class="portlet box blue-hoki">
          <div class="portlet-title">
            <div class="caption">
              <i class="fa fa-gift"></i> Job Order Form
            </div>
          </div><!-- /portlet-title -->
          <div class="portlet-body form">
            <form action="#" class="form-horizontal" id="submit_form" method="POST">
              <div class="form-wizard">
                <div class="form-body">
                  <div>
                    <input type="hidden" required id="jo_status" name="jo_status" value="pending">
                    <h3 class="block">Customer Information</h3>

                    <div class="form-group">
                      <label class="control-label col-md-3">Date <span class="required"> * </span> </label>
                      <div class="col-md-4">
                        <input type="date" required readonly class="form-control" name="date_submitted" id="date_submitted" value="<?=date("Y-m-d");?>">
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="control-label col-md-3">Company <span class="required"> * </span></label>
                      <div class="col-md-4">
                        <input type="text" required class="form-control" id="company" name="company" list="company_list" onchange="get_company_details();">
                        <datalist id="company_list"></datalist>
                        <script>
                        $(function() {
                          $.post("<?=base_url('customer/get_companies');?>")
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

                        $.post("<?=base_url('customer/get_specific_address');?>", {company: $('#company').val()} )
                        .done(function(data) {
                          $('#address_list').empty();
                          for (var i = 0; i < data.length; i++) {
                            $('#address_list').append("<option value='" + data[i]['address'] + "'>");
                          }
                        });

                        $.post("<?=base_url('customer/get_specific_address');?>", {company: $('#company').val()} )
                        .done(function(data) {
                          $('#address_list').empty();
                          for (var i = 0; i < data.length; i++) {
                            $('#address_list').append("<option value='" + data[i]['address'] + "'>");
                          }
                        });

                        $.post("<?=base_url('customer/get_specific_applicant');?>", {company: $('#company').val()} )
                        .done(function(data) {
                          $('#applicant_list').empty();
                          for (var i = 0; i < data.length; i++) {
                            $('#applicant_list').append("<option value='" + data[i]['applicant'] + "'>");
                          }
                        });

                        $.post("<?=base_url('customer/get_specific_designation');?>", {company: $('#company').val()} )
                        .done(function(data) {
                          $('#designation_list').empty();
                          for (var i = 0; i < data.length; i++) {
                            $('#designation_list').append("<option value='" + data[i]['designation'] + "'>");
                          }
                        });

                        $.post("<?=base_url('customer/get_specific_contact_number');?>", {company: $('#company').val()} )
                        .done(function(data) {
                          $('#contact_number_list').empty();
                          for (var i = 0; i < data.length; i++) {
                            $('#contact_number_list').append("<option value='" + data[i]['contact_number'] + "'>");
                          }
                        });

                        $.post("<?=base_url('customer/get_specific_email_address');?>", {company: $('#company').val()} )
                        .done(function(data) {
                          $('#email_address_list').empty();
                          for (var i = 0; i < data.length; i++) {
                            $('#email_address_list').append("<option value='" + data[i]['email_address'] + "'>");
                          }
                        });

                        $.post("<?=base_url('customer/get_specific_contact_person');?>", {company: $('#company').val()} )
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

                  </div><!-- /Customer Information -->

                  <div>
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
                              <th style="display:none;">PNRI Code <span class="required"> * </span></th>
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
                              <th colspan="2"><input type="number" readonly class="form-control" id="additional_costs" name="additional_costs" value="0" onkeyup="compute_total();" onchange="compute_total();" /></th>
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
                                '<td style="display:none;"><input type="text" id="pnri_code_'+ln+'" name="pnri_code[]"  class="form-control"></td>' +
                                '<td><input type="text" required id="item_description_'+ln+'" name="item_description[]" class="form-control"></td>' +
                                '<td><input type="text" required id="amount_'+ln+'" readonly  name="amount[]"           class="form-control"></td>' +
                                '<td>' +
                                  '<button type="button" class="btn red deletor" name="btn_exit[]" onclick="removethisline('+ln+')"><i class="fa fa-times"></i></button>' +
                                  '<input type="hidden" id="jo_item_id_'+ln+'" name="jo_item_id[]" value="0">' +
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

                                $.ajax({ url: "<?=base_url('analyst/remove_this_line');?>", async: false, type:'post',
                                  data:{ sar_item_id : sar_item_id },
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
                                url:"<?=site_url('customer/change_fee'); ?>",
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
                          <label> <input type="radio" required id="samples_returned_1" name="samples_returned" value="1"/>Yes</label>
                          <label> <input type="radio" required id="samples_returned_0" name="samples_returned" value="0"/>No</label>
                        </div>
                      </div>
                    </div>


                  </div><!-- /Application Details -->

                  <div>
                    <h3 class="block">Read and Accept Terms and Conditions</h3>

                    <div class="form-group">
                      <div class="col-md-12">
                        <div class="note note-info">
                          <p>1) Results of analysis will be released on {TBA}
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

                  </div><!-- /Terms and Conditions -->

                </div><!-- /form-body -->
                <div class="form-actions">
                  <div class="row">
                    <div class="col-md-offset-3 col-md-9">
                      <button type="submit" id="continueBtn" class="btn green button-submit">
                        Submit <i class="m-icon-swapright m-icon-white"></i>
                      </button>
                    </div>
                  </div>
                </div><!-- /form-actions -->
              </div><!-- /form-wizard -->
            </form>
          </div><!-- /portlet-body -->
        </div><!-- /portlet -->
      </div><!-- /col-md-12 -->
    </div><!-- /row -->

    <script>
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
          url:"<?=site_url('customer/create_update');?>",
          success: function(data) {
            if (data['jo']) {
              /* $.pnotify({ title: "Succes!", type: "success",
                text: "Job Order successfully added!" }); */
                $('#createanotherJO').modal();
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

    <!-- END PAGE CONTENT -->

    <!-- Create Another JO Modal START -->
    <div class="modal fade" id="createanotherJO" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    	<div class="modal-dialog modal-xs">
    		<div class="modal-content">
    			<div class="modal-body" align="center">
    				<table border="0px">
    					<tr><td><h3>Job Order Saved. Do you want to create another Job Order?</h3></tr>
    				</table>
    			</div>
    			<div class="modal-footer">
    				<button class="btn blue" onclick="clickedYes();"> YES </button>

    				<button class="btn blue" onclick="clickedNo();"> NO </button>
    			</div>
    		</div><!-- /modal-content -->
    	</div><!-- /modal-dialog -->
    </div><!-- /modal -->
    <script>
    $(function() {
      //$('#createanotherJO').modal();
    });

    function clickedYes() { // Almost same as clear_JO_form function in joborderrequests
      var temp_company = $('#company').val();
      var temp_address = $('#address').val();
      var temp_applicant = $('#applicant').val();
      var temp_designation = $('#designation').val();
      var temp_contact_number = $('#contact_number').val();
      var temp_email_address = $('#email_address').val();
      var temp_contact_person = $('#contact_person').val();
      $('#submit_form')[0].reset(); $('#agree_terms').attr('checked', false);
      $('#company').val(temp_company);
      $('#address').val(temp_address);
      $('#applicant').val(temp_applicant);
      $('#designation').val(temp_designation);
      $('#contact_number').val(temp_contact_number);
      $('#email_address').val(temp_email_address);
      $('#contact_person').val(temp_contact_person);
      $.uniform.update();
      $('#actionButtons').show();
      $('#createanotherJO').modal("hide");

      $("html, body").animate({scrollTop: 540 }, 350);
    }

    function clickedNo() {
      $('#createanotherJO').modal("hide");
      document.write('');
    }
    </script>
    <!-- Create Another JO Modal END -->

  <!-- /page-content at the footer -->
<!-- /page-content-wrapper at the footer -->
