<!--

Form design based on:
http://articles.sitepoint.com/article/fancy-form-design-css

Gradient generator:
http://www.allcrunchy.com/Web_Stuff/Gradient_Generator/?color1=FFFFFF&color2=EEEEEE&gradientHeight=220&gradType=sinusoidal

-->

<html>
<head>
	<link rel="stylesheet" type="text/css" href="css/default-styling.css" />
	
    <!--[if lte IE 7]>
	<style type="text/css" media="all">
	@import "css/default-styling-ie.css";
	</style>
	<![endif]-->

</head>
<body>
	<form action="example.php">  
		<fieldset>  
			<legend><span>Contact Details</span></legend>  
			<ol>  
				<li>  
					<label for="name">Name:</label>  
					<input id="name" name="name" class="text" type="text" />  
				</li> 
				<li>  
					<label for="email">Email address:</label>  
					<input id="email" name="email" class="text" type="text" />  
				</li> 
				<li>  
					<label for="phone">Telephone:</label>  
					<input id="phone" name="phone" class="text" type="text" />  
				</li>  
			</ol>  
		</fieldset>
		
		<fieldset>  
			<legend><span>Delivery Address</span></legend>  
			<ol>  
				<li>  
					<label for="address1">Address 1:</label>  
					<input id="address1" name="address1" class="text"  
					type="text" />  
				</li>  
				<li>  
					<label for="address2">Address 2:</label>  
					<input id="address2" name="address2" class="text"  
					type="text" />  
				</li>  
				<li>  
					<label for="suburb">Suburb/Town:</label>  
					<input id="suburb" name="suburb" class="text"  
					type="text" />  
				</li>  
				<li>  
					<label for="postcode">Postcode:</label>  
					<input id="postcode" name="postcode"  
					class="text textSmall" type="text" />  
				</li>  
				<li>  
					<label for="country">Country:</label>  
					<input id="country" name="country" class="text"  
					type="text" />  
				</li>  
			</ol>  
		</fieldset>  
		
		<fieldset class="submit">  
			<input class="submit" type="submit" value="Begin download" />  
		</fieldset>  
	</form>
</body>
</html>