<script id="drive-template" type="text/x-handlebars-template">
      <li>
            <div class="collapsible-header"><i class="fa fa-hdd-o left"></i><i id="hdd_{{uuid}}_{{hddid}}"></i></div>
            <div class="collapsible-body">
                  <p>
                        Name : <b id="hddname_{{uuid}}_{{hddid}}"></b>
                        <br>
                        Format : <b id="hddformat_{{uuid}}_{{hddid}}"></b>
                        <br>
                        <b id="freespace_{{uuid}}_{{hddid}}"></b> MB Free out of <b id="totalspace_{{uuid}}_{{hddid}}"></b>MB
                        <br>
                        <div class="progress blue lighten-3">
                              <div id="hddbar_{{uuid}}_{{hddid}}" class="determinate blue" style="width: 0%"></div>
                        </div>
                  </p>
            </div>
      </li>
</script>