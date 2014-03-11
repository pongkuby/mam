<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>คู่มือการใช้งานระบบ M@M</title>
    <link rel="stylesheet" href="../mam/css/themes/default/jquery.mobile-1.3.1.min.css">
    <link rel="stylesheet" href="../mam/_assets/css/jqm-demos.css">
    <script src="../mam/js/jquery.js"></script>
    <script src="../mam/_assets/js/index.js"></script>
    <script src="../mam/js/jquery.mobile-1.3.1.min.js"></script>
    <script type="text/javascript" src="jwplayer/jwplayer.js"></script>
	<?
		if($_GET["VDO"]){
		
	
   /* echo "<script type='text/javascript'>";
    echo    "window.onload = function () {";
    echo        "jwplayer('mediaplayer1').setup({";
	echo			"events:";
	echo			"{";
	echo				"onPlay: function () {$jw('mediaplayer1').setFullscreen(true)},";
	echo				"onPause: function() {$jw('div1').setFullscreen(false)},";
	echo				"onComplete:function()";
	echo				"{";
	echo					"$jw('div1').setFullscreen(false),";
	echo					"$jw('div1').setup(options)";
	echo				"}";                       
	echo			"},";
    echo            "flashplayer: 'jwplayer/player.swf',";
    echo            "file: 'vdo/".$_GET["VDO"].".mp4',";
    echo            "image: 'vdo/".$_GET["VDO"].".png'";
	//echo            "width: '100%',";
	//echo            "height: '100%'";
    echo        "});";
    echo    "};";
    echo "</script>";
	*/

	?>
	<script type='text/javascript'>
		window.onload = function () {
			jwplayer('mediaplayer1').setup({
				autostart: true,
				//autoplay: true,
				events:
				{
					onPlay: function () {jwplayer('mediaplayer1').setFullscreen(true)},
					onPause: function() {jwplayer('mediaplayer1').setFullscreen(false)},
					onComplete:function()
					{
						jwplayer('mediaplayer1').setFullscreen(false),
						jwplayer('mediaplayer1').setup(options)
					}
				},
				width : '100%',
				flashplayer: 'jwplayer/player.swf',
				file: 'vdo/<?=$_GET["VDO"]?>.mp4',
				image: 'vdo/<?=$_GET["VDO"]?>.png'
			});
		};
	</script>
	
	<?
		
		}
	?>
</head>

<body>

<!-- Start of first page: #one -->
<div data-role="page" id="one">

   <!-- <div data-role="header" data-theme="b">
        <h1>คู่มือการใช้งานระบบ M@M</h1>
    </div>-->
    <!-- /header -->

    <div data-role="content">

        <p align="center"><img src="mam_icon.png" width="200"></p>

        <CENTER><div id="mediaplayer1">JW Player goes here</div></CENTER>

        <h3>โปรดเลือกหัวข้อ :-</h3>

        <p><a href="User Manual.pdf" target="_blank" data-role="button">คู่มือการใช้งานระบบการนัดหมายบนมือถือ (M@M : My
                Appointment on Mobile)</a></p>

        <p><a href="index.php?VDO=use_by_pc" target="_self" data-role="button">VDO สอนการเข้าใช้งานผ่าน Web Browser บน PC</a></p>

        <p><a href="index.php?VDO=add_event" target="_self" data-role="button">VDO สอนการสร้างการนัดหมาย</a></p>

        <p><a href="index.php?VDO=edit_del_event" target="_self" data-role="button">VDO สอนการ แก้ไข/ลบ การนัดหมาย</a></p>

        <p><a href="index.php?VDO=accept_decline_event" target="_self" data-role="button">VDO สอนการ เข้าร่วม/ปฏิเสธ
                การนัดหมาย</a></p>

        <p><a href="index.php?VDO=search_calendar" target="_self" data-role="button">VDO สอนการดูปฏิทินการนัดหมายของพนักงาน</a>
        </p>

        <p><a href="index.php?VDO=search_tel" target="_self" data-role="button">VDO สอนการด้นหาเบอร์โทรศัพท์ของพนักงาน</a></p>

        <p><a href="index.php?VDO=shortcut_pc" target="_self" data-role="button">VDO สอนการสร้าง Shortcut เมื่อเรียกใช้งานผ่าน
                Web Browser บน PC</a></p>
    </div>
    <!-- /content -->

    <div data-role="footer" data-theme="a">
        <h4>พัฒนาโดย กองพัฒนาระบบงานบริหาร ฝ่ายพัฒนาและสนับสนุนเทคโนโลยี การประปานครหลวง</h4>
    </div>
    <!-- /footer -->
</div>
<!-- /page one -->


</body>
</html>
