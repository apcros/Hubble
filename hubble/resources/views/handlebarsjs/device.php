<script id="device-template" type="text/x-handlebars-template">
	<div class="col s12 m6">
		<div class="card">
		    <div class="card-content">
		        <span class="card-title black-text" id="devicename_{{uuid}}"></span>
		        <br>
		       	<div class="card-panel" id="info_{{uuid}}"></div>
		       	<div class="divider"></div>
		       	<b>Drives :</b>
		       	<div id="drives_{{uuid}}"></div>
		       	<div class="divider"></div>
		        <br>
		        <p>
					<b>CPU Usage (<b id="cpu_{{uuid}}">0%</b>)</b>
					<div class="progress blue lighten-3">
						<div id="cpubar_{{uuid}}"class="determinate blue" style="width: 0%"></div>
			  		</div>
		        </p>
		        <p>
					<b>RAM Usage (<b id="ram_{{uuid}}">0%</b>)</b>
					<i id="ramfree_{{uuid}}">0</i> MB free on <i id="ramtotal_{{uuid}}">0</i> MB
					<div class="progress blue lighten-3">
					<div id="rambar_{{uuid}}" class="determinate blue" style="width: 0%"></div>
			  		</div>
		        </p>
		        <br>
		        <ul class="collection ">
		        		 <li class="collection-item">
		        		 	<i class="fa fa-barcode left"></i><b>Computer Name :</b><i id="name_{{uuid}}"></i>
		        		 </li>
		        		 <li class="collection-item">
		        		 	<i class="fa fa-laptop left"></i><b>OS :</b><i id="os_{{uuid}}"></i>
		        		 </li>
					     <li class="collection-item">
					     	<i class="fa fa-clock-o left"></i><b>Last Updated :</b><i id="lastupdated_{{uuid}}"></i>
					     </li>
					     <li class="collection-item">
					     	<i class="fa fa-bolt left"></i><b>Client version :</b> <i id="clientversion_{{uuid}}"></i>
					     </li>
				</ul>
		    </div>
			<div class="card-action">
		        <a class="red-text btn-flat waves-red waves-effect" href="#">DELETE</a>
			</div>
		</div>
	</div>
</script>