<script id="device-list-template" type="text/x-handlebars-template">
    <li class="collection-item" id="{{uuid}}">
        <h5>
            <i class="fa {{device-icon}} darken-1 left"></i>
            <b>{{name}}</b>
        </h5>
        <p><i>{{status}}</i></p>
        <button class="modal-trigger waves-effect indigo waves-light btn" onclick='$("#identity_{{uuid}}").openModal();'><i class="fa fa-lock left" aria-hidden="true"></i>Show identity</button>
        <button class="red waves-effect waves-light btn" onclick="delDevice('{{uuid}}');"><i class="fa fa-trash left" aria-hidden="true"></i>Delete</button>
    </li>
    <div id="identity_{{uuid}}" class="modal bottom-sheet">
        <div class="modal-content">
          <h4>Identity of {{name}}</h4>
            <p>
                <b>UUID : </b>
                <br>
                {{uuid}}
            </p>
            <p>
                <b>Access Key </b>
                <br>
                {{key}}
            </p>
        </div>
    </div>
</script>
