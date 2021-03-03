<!doctype html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <title>Login | <?=$this->config->item('system_name_long');?> (<?=$this->config->item('system_name_short');?>)</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/peach/css/960gs/fluid.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/peach/css/h5bp/normalize.css"> <!-- RECOMMENDED: H5BP reset styles -->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/peach/css/h5bp/non-semantic.helper.classes.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/peach/css/h5bp/print.styles.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/peach/css/special-page.css"> <!-- REQUIRED: Special page styling -->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/peach/css/sprites.css"> <!-- REQUIRED: Basic sprites (e.g. buttons, jGrowl) -->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/peach/css/typographics.css"> <!-- REQUIRED: Typographics -->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/peach/css/content.css"> <!-- REQUIRED: Content (we need the boxes) -->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/peach/css/sprite.forms.css"> <!-- SPRITE: Forms -->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/peach/css/ie.fixes.css">
    <script src="<?php echo base_url();?>assets/peach/js/libs/modernizr-2.0.6.min.js"></script>
    <link rel="shortcut icon" href="<?php echo base_url();?>assets/fav.png">
  </head>
  <body class="special_page">
    <div class="top">
      <div class="gradient"></div>
      <div class="white"></div>
      <div class="shadow"></div>
    </div>
    <div class="content">
      <h1><?=$this->config->item('system_name_long');?></h1>
      <div class="background"></div>
      <div class="wrapper">
        <div class="box">
          <div class="header grey">
            <img src="<?php echo base_url();?>assets/peach/img/icons/packs/fugue/16x16/lock.png" width="16" height="16">
            <h3>Login : <?=$this->config->item('system_name_short');?></h3>
          </div>

           <form method="post" id="jvalidate" role="form">
            <div class="content no-padding">
              <div class="alert success" id="successmessage" hidden>
                <span>
                  <img src='<?php echo base_url('assets/peach/spinner.gif');?>'/>  <strong>Well done!</strong>
                  Now redirecting...
                </span>
              </div>
              <div class="alert error" id="errormessage" hidden>
                <span class="icon"></span> Incorrect Username/Password.
              </div>
              <div class="alert warning" id="intrudermessage" hidden>
                <strong>Warning!</strong>
                <span> You must be logged in to access the Admin side. </span>
              </div>
              <div id="message"></div>
               <?php
               //if(validation_errors() != "")
               // echo"<div class='alert error'><span class='icon'></span><span class='hide'>x</span>".validation_errors()."</div>";
              ?>
              <div class="section _100">
                <label>Username:</label>
                <div>
                  <input name="username" id="username" class="required">
                </div>
              </div>
              <div class="section _100">
                <label>Password:</label>
                <div>
                  <input name="password" id="password" type="password" class="required">
                </div>
              </div>
            </div>
            <div class="actions" id="actionButtons">
                <div class="actions-left">
                  <input type="reset" value="Reset"/>
                </div>
                <div class="actions-right">
                  <input type="submit" value="Login"/>
                </div>
                <div class="actions-right">
                  <button type="button" onclick="toCustomer();" >Customer</button>
                </div>
            </div>
          </form>
        </div><!-- /box -->
        <div class="shadow"></div>
      </div><!-- /wrapper -->
    </div>

  <script src="<?=base_url();?>assets/peach/js/libs/jquery.min.js"></script>
  <script>window.jQuery || document.write('<script src="<?=base_url();?>assets/peach/js/libs/jquery-1.7.1.js"><\/script>')</script>
  <script src="<?=base_url();?>assets/peach/js/libs/jquery-ui.min.js"></script>
  <script>window.jQuery.ui || document.write('<script src="<?=base_url();?>assets/peach/js/libs/jquery-ui-1.8.16.min.js"><\/script>')</script>
  <script defer src="<?=base_url();?>assets/peach/js/plugins.js"></script> <!-- REQUIRED: Different own jQuery plugnis -->
  <script defer src="<?=base_url();?>assets/peach/js/mylibs/jquery.validate.js"></script>
  <script defer src="<?=base_url();?>assets/peach/js/mylibs/jquery.jgrowl.js"></script>
  <script defer src="<?=base_url();?>assets/peach/js/mylibs/jquery.checkbox.js"></script>
  <script defer src="<?=base_url();?>assets/peach/js/mylibs/jquery.validate.js"></script>
  <script defer src="<?=base_url();?>assets/peach/js/script.js"></script> <!-- REQUIRED: Generic scripts -->

  <script>
  function toCustomer() {
    window.location.replace("<?=base_url('customer');?>");
  }

  $(document).ready(function () {
    $("#jvalidate").on('submit',(function(e) {
      $('#errormessage').hide();
      $('#successmessage').hide();
      $('#intrudermessage').hide();
      e.preventDefault();
      if($("#jvalidate").valid()) {
        var formdata = $("#jvalidate").serialize();
        document.getElementById('actionButtons').style.display = "none";
        $('#message').append("<div id='message2'></div>");
        $('#message2').append("<div class='alert info'><img src='<?=base_url('assets/peach/spinner.gif');?>'/>     <strong>Heads up!</strong> Please wait while we check your credentials...</div>");
        setTimeout(function(){
          $.ajax({ url: "<?=site_url('access/validatecredentials'); ?>",
            type: "POST", async: true, data: formdata, dataType: 'json', cache: false,
            success: function(data) {
              if (data['IsError'] == 0) {
                $('#successmessage').show();
                $('#errormessage').hide();

                setTimeout(function(){
                  window.location.replace("<?=base_url('admin');?>")
                }, 600);
              } else {
                $('#errormessage').show();
              }
            },
            error: function(data) { }
          });
          $('#message2').empty();
          document.getElementById('actionButtons').style.display = "block";
        }, 600)
      }
    }));

  })
  $(function(){
    $("#username").focus();
    $('#errormessage').hide();
    $('#successmessage').hide();
    $('#intrudermessage').hide();
  });
  </script>

  </body>
</html>
<?php
$sess = $this->session->userdata("IsIntruder");
if ($this->session->userdata("IsIntruder") == 'True')
{
  echo "<script>
          jQuery(document).ready(function()
            { $('#intrudermessage').show();
          });
        </script>";
}
?>
