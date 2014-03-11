<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Multi-page template</title>
	<link rel="stylesheet"  href="css/themes/default/jquery.mobile-1.3.1.min.css">
	<link rel="stylesheet" href="_assets/css/jqm-demos.css">
	<script src="js/jquery.js"></script>
	<script src="_assets/js/index.js"></script>
	<script src="js/jquery.mobile-1.3.1.min.js"></script>
</head>

<body>

<!-- Start of first page: #one -->
<div data-role="page" id="one">

	<div data-role="header" data-theme="b">
		<h1>ยินดีต้อนรับเข้าสู่ระบบ M@M</h1>
	</div><!-- /header -->

	<div data-role="content" >
		
		<p align="center"><img src="images/user.png" width="100"></p>
		
		<div align="center"><h2>นายทดสอบ ดูครับ<br>สพพ.กพบ.ฝพท.<br>เบอร์โทรศัพท์ : 084-019-0142</h2></div>
		
		  <div data-role=content>
    <span> Latitude : </span> <span id=lat></span> <br />
    <span> Longitude : </span> <span id=lng></span> <br />
  </div>
		
		<h3>โปรดเลือกเมนู :-</h3>
		<!-- <p><a href="#two" data-role="button">ระบบปฏิทินนัดหมายการประชุม</a></p>-->
		<p><a href="index2.php" data-role="button">ระบบปฏิทินนัดหมายการประชุม</a></p>
		<p><a href="#popup" data-role="button" data-rel="dialog" data-transition="pop">ระบบค้นหาเบอร์โทรศัพท์</a></p>
	</div><!-- /content -->

	<div data-role="footer" data-theme="a">
		<h4>พัฒนาโดย กองพัฒนาระบบงานบริหาร ฝ่ายพัฒนาและสนับสนุนเทคโนโลยี การประปานครหลวง</h4>
	</div><!-- /footer -->
</div><!-- /page one -->

<!-- Start of second page: #two -->
<div data-role="page" id="two" data-theme="a">

	<div data-role="header">
		<h1>Two</h1>
	</div><!-- /header -->

	<div data-role="content" data-theme="a">
		<h2>Two</h2>
		<p>I have an id of "two" on my page container. I'm the second page container in this multi-page template.</p>
		<p>Notice that the theme is different for this page because we've added a few <code>data-theme</code> swatch assigments here to show off how flexible it is. You can add any content or widget to these pages, but we're keeping these simple.</p>
		<p><a href="#one" data-direction="reverse" data-role="button" data-theme="b">Back to page "one"</a></p>

	</div><!-- /content -->

	<div data-role="footer">
		<h4>Page Footer</h4>
	</div><!-- /footer -->
</div><!-- /page two -->

<!-- Start of third page: #popup -->
<div data-role="page" id="popup">

	<div data-role="header" data-theme="e">
		<h1>Dialog</h1>
	</div><!-- /header -->

	<div data-role="content" data-theme="d">
		<h2>Popup</h2>
		<p>I have an id of "popup" on my page container and only look like a dialog because the link to me had a <code>data-rel="dialog"</code> attribute which gives me this inset look and a <code>data-transition="pop"</code> attribute to change the transition to pop. Without this, I'd be styled as a normal page.</p>
		<p><a href="#one" data-rel="back" data-role="button" data-inline="true" data-icon="back">Back to page "one"</a></p>
	</div><!-- /content -->

	<div data-role="footer">
		<h4>Page Footer</h4>
	</div><!-- /footer -->
</div><!-- /page popup -->

</body>
</html>
<script>

navigator.geolocation.getCurrentPosition (function (pos)
{
  var lat = pos.coords.latitude;
  var lng = pos.coords.longitude;
  $("#lat").text (lat);
  $("#lng").text (lng);
});

</script>
