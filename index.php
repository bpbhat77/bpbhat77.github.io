<div class="content">
<style>
#drop{
	border:2px dashed #bbb;
	-moz-border-radius:5px;
	-webkit-border-radius:5px;
	border-radius:5px;
	padding:25px;
	text-align:center;
	font:20pt bold,"Vollkorn";color:#bbb
}
#msg{
	
	padding:25px;
	text-align:center;
	font:20pt bold,"Vollkorn";color:#D90000
}
#b64data{
	width:100%;
}
</style>
    <h1>Upload execel file</h1>

    <?php 

    

    ?>
    
    <form action="" enctype="multipart/form-data">
		<div id="drop">Drop an XLSX file here to see sheet data.
		<br>
		1. Place header as in sample.xlsx 
		<br>
		2.check channel-name and channel-id has no space
		<br>
		3.check sheet name as sheet1
		<br>
		4.no &  should be present
		<br>
		5. directors,cast etc should be separated by ,
		
		
		</div>
		<div id="msg"></div>
		<script type="text/javascript" src="<?php echo URL; ?>public/js/jszip.js"></script>

		<script type="text/javascript" src="<?php echo URL; ?>public/js/xlsx.js"></script>

		<script>
		function to_json(workbook) {
	var result = {};
	workbook.SheetNames.forEach(function(sheetName) {
		var roa = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[sheetName]);
		if(roa.length > 0){
			result[sheetName] = roa;
		}
	});
	return result;
}
function process_wb(wb) {
	var output = "";

		output = JSON.stringify(to_json(wb), 2, 2);
	
	console.log(output);
	var obj = jQuery.parseJSON(output);
	var inputs=[];
	$.each(obj.sheet1, function( index, value ) {
		//console.log( index + ": " + JSON.stringify( value) );
		inputs.push(value);
		
	});
	console.log(JSON.stringify(inputs));
	//var retval = jQuery.toJSON(inputs);
	$.ajax({
              url: siteURL+'dashboard/ajaxcreate/',
              type: 'POST',
              data: 'jsoninput=' + JSON.stringify(inputs).replace('&','%26'),
              success: function(data) {
                $('#msg').text("uploaded succusfully --- if it is not coming in view means error in excel format");
				
				
              }
            });
	
	//if(out.innerText === undefined) out.textContent = output;
	//else out.innerText = output;
}
var drop = document.getElementById('drop');
function handleDrop(e) {
	e.stopPropagation();
	e.preventDefault();
	var files = e.dataTransfer.files;
	var i,f;
	for (i = 0, f = files[i]; i != files.length; ++i) {
		var reader = new FileReader();
		var name = f.name;
		reader.onload = function(e) {
			var data = e.target.result;
			//var wb = XLSX.read(data, {type: 'binary'});
			var arr = String.fromCharCode.apply(null, new Uint8Array(data));
			var wb = XLSX.read(btoa(arr), {type: 'base64'});
			process_wb(wb);
		};
		//reader.readAsBinaryString(f);
		reader.readAsArrayBuffer(f);
	}
}
function handleDragover(e) {
	e.stopPropagation();
	e.preventDefault();
	e.dataTransfer.dropEffect = 'copy';
}

if(drop.addEventListener) {
	drop.addEventListener('dragenter', handleDragover, false);
	drop.addEventListener('dragover', handleDragover, false);
	drop.addEventListener('drop', handleDrop, false);
}

		</script>
       <!--<input type="file" name="excel_file" required />
      
        <input name="submit" type="submit" value="Upload" />-->
    </form>
    
	<script>
	$('input[type=file]').change(function(e){
 
	var i,f;
	
		var reader = new FileReader();
		var name = 'a.xlsx';
		reader.onload = function(e) {
			var data = e.target.result;
			//var wb = XLSX.read(data, {type: 'binary'});
			var arr = String.fromCharCode.apply(null, new Uint8Array(data));
			var wb = XLSX.read(btoa(arr), {type: 'base64'});
			process_wb(wb);
		};
		//reader.readAsBinaryString(f);
		reader.readAsArrayBuffer(f);
		
	
});
</script>
</div>