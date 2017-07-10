<?php
$file = fopen("usaddress.csv","r");
$all_rows = array();
$header = null;
$request = null; 
while ($row = fgetcsv($file)) {
    if ($header === null) {
        $header = $row;
        continue;
    }
    $all_rows[] = array_combine($header, $row);
}
$max = 0;
if(count($all_rows) != 0){
	$max = count($all_rows)-1;
}
$index = rand(0,$max);
if(isset($_REQUEST['id'])){
	$request = (int)$_REQUEST['id'];
}
if($request && $request >=0 && $request <= $max)
{
	$index = $request;
}
$current = $all_rows[$index];
$currentState = extandState($current["state"]);
?>
<style>
	table{
		margin: 50px auto;
	}
	td{
		padding :10px;
	}
	tr{
		cursor: copy;
	}
</style>
<table border="1">
	<tr>
		<td colspan="2" align="center">
			<?php echo $index; ?>
		</td>
	</tr>
	<tr onClick='copyToClipboard(document.getElementById("street"))'>
		<td>
			Street
		</td>
		<td id="street">
			<?php echo $current["street"]; ?>
		</td>
	</tr>
	<tr  onClick='copyToClipboard(document.getElementById("city"))'>
		<td>
			City
		</td>
		<td id="city">
			<?php echo $current["city"]; ?>
		</td>
	</tr>
	<tr  onClick='copyToClipboard(document.getElementById("state"))'>
		<td>
			State
		</td>
		<td id="state">
			<?php echo $currentState; ?>
		</td>
	</tr>
	<tr  onClick='copyToClipboard(document.getElementById("zip"))'>
		<td>
			Zip
		</td>
		<td id="zip">
			<?php echo $current["zip"]; ?>
		</td>
	</tr>
</table>
<script>

function copyToClipboard(elem) {
	  // create hidden text element, if it doesn't already exist
    var targetId = "_hiddenCopyText_";
    var isInput = elem.tagName === "INPUT" || elem.tagName === "TEXTAREA";
    var origSelectionStart, origSelectionEnd;
    if (isInput) {
        // can just use the original source element for the selection and copy
        target = elem;
        origSelectionStart = elem.selectionStart;
        origSelectionEnd = elem.selectionEnd;
    } else {
        // must use a temporary form element for the selection and copy
        target = document.getElementById(targetId);
        if (!target) {
            var target = document.createElement("textarea");
            target.style.position = "absolute";
            target.style.left = "-9999px";
            target.style.top = "0";
            target.id = targetId;
            document.body.appendChild(target);
        }
        target.textContent = elem.textContent;
    }
    // select the content
    var currentFocus = document.activeElement;
    target.focus();
    target.setSelectionRange(0, target.value.length);
    
    // copy the selection
    var succeed;
    try {
    	  succeed = document.execCommand("copy");
		  elem.style.backgroundColor = "rgba(0, 128, 0, 0.19)";
    } catch(e) {
        succeed = false;
    }
    // restore original focus
    if (currentFocus && typeof currentFocus.focus === "function") {
        currentFocus.focus();
    }
    
    if (isInput) {
        // restore prior selection
        elem.setSelectionRange(origSelectionStart, origSelectionEnd);
    } else {
        // clear temporary content
        target.textContent = "";
    }
    return succeed;
}
</script>
<?php
function extandState($state){
	$stateArray = array(
		"AL"=>"Alabama",
		"AK"=>"Alaska",
		"AZ"=>"Arizona",
		"AR"=>"Arkansas",
		"CA"=>"California",
		"CO"=>"Colorado",
		"CT"=>"Connecticut",
		"DE"=>"Delaware",
		"FL"=>"Florida",
		"GA"=>"Georgia",
		"HI"=>"Hawaii",
		"ID"=>"Idaho",
		"IL"=>"Illinois",
		"IN"=>"Indiana",
		"IA"=>"Iowa",
		"KS"=>"Kansas",
		"KY"=>"Kentucky",
		"LA"=>"Louisiana",
		"ME"=>"Maine",
		"MD"=>"Maryland",
		"MA"=>"Massachusetts",
		"MI"=>"Michigan",
		"MN"=>"Minnesota",
		"MS"=>"Mississippi",
		"MO"=>"Missouri",
		"MT"=>"Montana",
		"NE"=>"Nebraska",
		"NV"=>"Nevada",
		"NH"=>"New Hampshire",
		"NJ"=>"New Jersey",
		"NM"=>"New Mexico",
		"NY"=>"New York",
		"NC"=>"North Carolina",
		"ND"=>"North Dakota",
		"OH"=>"Ohio",
		"OK"=>"Oklahoma",
		"OR"=>"Oregon",
		"PA"=>"Pennsylvania",
		"RI"=>"Rhode Island",
		"SC"=>"South Carolina",
		"SD"=>"South Dakota",
		"TN"=>"Tennessee",
		"TX"=>"Texas",
		"UT"=>"Utah",
		"VT"=>"Vermont",
		"VA"=>"Virginia",
		"WA"=>"Washington",
		"WV"=>"West Virginia",
		"WI"=>"Wisconsin",
		"WY"=>"Wyoming"
	);
	if(isset($stateArray[$state])){
		return $stateArray[$state];
	}
	return $state;
}
?>