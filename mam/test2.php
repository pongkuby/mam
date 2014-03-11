<?
error_reporting (E_ALL ^ E_NOTICE);
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Remote Autocomplete - jQuery Mobile Demos</title>
	<link rel="stylesheet"  href="css/themes/default/jquery.mobile-1.3.1.min.css">
	<link rel="stylesheet" href="_assets/css/jqm-demos.css">

	<script src="js/jquery.js"></script>
	<script src="_assets/js/index.js"></script>
	<script src="js/jquery.mobile-1.3.1.min.js"></script>
    <script>
		$( document ).on( "pageinit", "#myPage", function() {
			$( "#autocomplete" ).on( "listviewbeforefilter", function ( e, data ) {
				var $ul = $( this ),
					$input = $( data.input ),
					value = $input.val(),
					html = "";
				$ul.html( "" );
				if ( value && value.length > 2 ) {
					$ul.html( "<li><div class='ui-loader'><span class='ui-icon ui-icon-loading'></span></div></li>" );
					$ul.listview( "refresh" );
					$.ajax({
						url: "data.php",
						dataType: "json",
						async:false,
						data: {
							q: $input.val()
						}
					})
					.then( function ( response ) {
						$.each( response, function ( i, val ) {
							html += "<li>" + val + "</li>";
						});
						$ul.html( html );
						$ul.listview( "refresh" );
						$ul.trigger( "updatelayout");
					});
				}
			});
		});
    </script>
	<style>
		.ui-listview-filter-inset {
			margin-top: 0;
		}
    </style>
</head>
<body>
<div data-role="page" class="jqm-demos" id="myPage">

				<ul id="autocomplete" data-role="listview" data-inset="true" data-filter="true" data-filter-placeholder="Find a city..." data-filter-theme="d"></ul>

</div><!-- /page -->
</body>
</html>
