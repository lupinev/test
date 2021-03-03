<!-- BEGIN JO SYNC ONLINE -->
<script>
var loop_sync = setInterval(checkNewApprovedJO, 6000);
var sync_jo_count = 99999;

function checkNewApprovedJO() {

  $.ajax({
  url: "<?=base_url("joborder/get_sync_approved_jo_count");?>", async: false,
  success: function(output) {
    if (sync_jo_count == 99999) {
      sync_jo_count = output;
    } else if (sync_jo_count < output) {
      var latest_jo = get_sync_latest_approved_jo();
      $.pnotify({ title:"JO Created", type: "info", delay: 2400000,
        text: "Reference Number "+latest_jo+" Approved, refresh the page to view changes", });
      // play_notif_sound();
      sync_jo_count = output;
    } else {
      sync_jo_count = output;
    }
  }
  });

}

function get_sync_latest_approved_jo() {
  var latest_jo;
  $.ajax({
  url: "<?=base_url("joborder/get_sync_latest_approved_jo");?>", async: false,
  success: function(output) {
    latest_jo = output;
  }
  });
  return latest_jo;
}

function stop_checkNewJO() {
  clearInterval(loop_sync);
}
</script>
<!-- END JO SYNC ONLINE -->
