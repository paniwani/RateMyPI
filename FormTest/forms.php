<!DOCTYPE HTML PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xml:lang="en" xmlns="http://www.w3.org/1999/xhtml" lang="en"><head>


    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <title>Accessible Forms</title>
    <link rel="stylesheet" type="text/css" media="screen" href="css/screen.css">
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/cmxform.js"></script>
</head><body>
<form style="display: block;" action="#" class="cmxform">
	<p>Please complete the form below. Mandatory fields marked <em>*</em></p>
	<fieldset>
		<legend>Delivery Details</legend>
		<ol>
			<li><label style="display: -moz-inline-box;" for="name"><span style="display: block; width: 120px;">Name <em>*</em></span></label> <input id="name"></li>
			<li><label style="display: -moz-inline-box;" for="address1"><span style="display: block; width: 120px;">Address <em>*</em></span></label> <input id="address1"></li>
			<li><label style="display: -moz-inline-box;" for="town-city"><span style="display: block; width: 120px;">Town/City</span></label> <input id="town-city"></li>
			<li><label style="display: -moz-inline-box;" for="county"><span style="display: block; width: 120px;">County <em>*</em></span></label> <input id="county"></li>
			<li><label style="display: -moz-inline-box;" for="postcode"><span style="display: block; width: 120px;">Postcode <em>*</em></span></label> <input id="postcode"></li>
			<li>
				<fieldset>
					<legend>Is this address also your invoice address? <em>*</em></legend>
					<label><input name="invoice-address" type="radio"> Yes</label>
					<label><input name="invoice-address" type="radio"> No</label>
				</fieldset>
			</li>
		</ol>
	</fieldset>
	<fieldset>
		<legend>Other Information</legend>
		<ol>
			<li><label style="display: -moz-inline-box;" for="dob"><span style="display: block; width: 120px;">Date of Birth <span class="sr">(Day)</span> <em>*</em></span></label> <select id="dob"><option selected="selected" value="1">1</option><option value="2">2</option></select> <label style="display: -moz-inline-box;" for="dob-m" class="sr"><span style="display: block; width: 120px;">Date of Birth (Month) <em>*</em></span></label> <select id="dob-m"><option selected="selected" value="1">Jan</option><option value="2">Feb</option></select> <label style="display: -moz-inline-box;" for="dob-y" class="sr"><span style="display: block; width: 120px;">Date of Birth (Year) <em>*</em></span></label> <select id="dob-y"><option selected="selected" value="1979">1979</option><option value="1980">1980</option></select></li>
			<li><label style="display: -moz-inline-box;" for="sex"><span style="display: block; width: 120px;">Sex <em>*</em></span></label> <select id="sex"><option selected="selected" value="female">Female</option><option value="male">Male</option></select></li>
			<li>
				<fieldset>
					<legend>Which of the following sports do you enjoy?</legend>
					<label for="football"><input id="football" type="checkbox"> Football</label>
					<label for="golf"><input id="golf" type="checkbox"> Golf</label>
					<label for="rugby"><input id="rugby" type="checkbox"> Rugby</label>
					<label for="tennis"><input id="tennis" type="checkbox"> Tennis</label>
					<label for="basketball"><input id="basketball" type="checkbox"> Basketball</label>
					<label for="boxing"><input id="boxing" type="checkbox"> Boxing</label>
				</fieldset>
			</li>
			<li><label style="display: -moz-inline-box;" for="comments"><span style="display: block; width: 120px;">Comments</span></label> <textarea id="comments" rows="7" cols="25"></textarea></li>
		</ol>
	</fieldset>
	<p><input value="Submit order" type="submit"></p>
</form>
</body></html>