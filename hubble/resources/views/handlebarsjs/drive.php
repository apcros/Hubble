<script id="drive-template" type="text/x-handlebars-template">
      <div><i class="fa fa-hdd-o left"></i>
            <p><i id="hdd_{{uuid}}_{{hddid}}"></i> <b id="hddname_{{uuid}}_{{hddid}}"></b> (<b id="hddformat_{{uuid}}_{{hddid}}"></b>)</p>
            <p><b id="freespace_{{uuid}}_{{hddid}}"></b> MB Free out of <b id="totalspace_{{uuid}}_{{hddid}}"></b> MB</p>
            <div class="progress blue lighten-3">
                  <div id="hddbar_{{uuid}}_{{hddid}}" class="determinate blue" style="width: 0%"></div>
            </div>
      </div>
</script>
