<!DOCTYPE html>
<html>
<head>
<link class="jsbin" href="http://code.jquery.com/mobile/1.0b2/jquery.mobile-1.0b2.min.css" rel="stylesheet" type="text/css" />
<script class="jsbin" src="http://code.jquery.com/jquery-1.6.2.min.js"></script>
<script class="jsbin" src="https://github.com/downloads/aliok/jquery-mobile/jquery.mobile_selectmenu_filter_01.js"></script>
<title>JS Bin</title>
</head>
<body>

  <div data-role="page">
    <div data-role="content">
  
  <h2>Select menu options filtering</h2>

            <p>The mobile browsers are limited and sometimes it is annoying to scroll a long list. For this kind of selects, you can use <code>data-filter</code> attribute alongside with <code>data-force-dialog</code> and <code>data-native</code> attributes to have a select menu with search bar filtering its options.</p>


            <a href="#" onclick="$('#select-choice-12').selectmenu('refresh', true); return false;">Refresh the selectmenu (forcerebuild) with clearing the filter value</a>

                    <div data-role="fieldcontain">
                        <label for="select-choice-12" class="select">Your state:</label>
						<select name="mam_co[]" id="mam_co" multiple="multiple" data-native-menu="false" data-force-dialog="true" data-native-menu="false" data-filter="true">

                            <option value="AL">Alabama</option>
                            <option value="AK">Alaska</option>
                            <option value="AZ">Arizona</option>
                            <option value="AR">Arkansas</option>
                            <option value="CA">California</option>
                            <option value="CO">Colorado</option>
                            <option value="CT">Connecticut</option>
                            <option value="DE">Delaware</option>
                            <option value="FL">Florida</option>
                            <option value="GA">Georgia</option>
                            <option value="HI">Hawaii</option>
                            <option value="ID">Idaho</option>
                            <option value="IL">Illinois</option>
                            <option value="IN">Indiana</option>
                            <option value="IA">Iowa</option>
                            <option value="KS">Kansas</option>
                            <option value="KY">Kentucky</option>
                            <option value="LA">Louisiana</option>
                            <option value="ME">Maine</option>
                            <option value="MD">Maryland</option>
                            <option value="MA">Massachusetts</option>
                            <option value="MI">Michigan</option>
                            <option value="MN">Minnesota</option>
                            <option value="MS">Mississippi</option>
                            <option value="MO">Missouri</option>
                            <option value="MT">Montana</option>
                            <option value="NE">Nebraska</option>
                            <option value="NV">Nevada</option>
                            <option value="NH">New Hampshire</option>
                            <option value="NJ">New Jersey</option>
                            <option value="NM">New Mexico</option>
                            <option value="NY">New York</option>
                            <option value="NC">North Carolina</option>
                            <option value="ND">North Dakota</option>
                            <option value="OH">Ohio</option>
                            <option value="OK">Oklahoma</option>
                            <option value="OR">Oregon</option>
                            <option value="PA">Pennsylvania</option>
                            <option value="RI">Rhode Island</option>
                            <option value="SC">South Carolina</option>
                            <option value="SD">South Dakota</option>
                            <option value="TN">Tennessee</option>
                            <option value="TX">Texas</option>
                            <option value="UT">Utah</option>
                            <option value="VT">Vermont</option>
                            <option value="VA">Virginia</option>
                            <option value="WA">Washington</option>
                            <option value="WV">West Virginia</option>
                            <option value="WI">Wisconsin</option>
                            <option value="WY">Wyoming</option>
                        </select>
                    </div>
        You can see the source code at <a href="https://github.com/aliok/jquery-mobile/commits/selectmenu-forceDialog/">https://github.com/aliok/jquery-mobile/commits/selectmenu-forceDialog/</a>
        <br/>
        <br/>
        Developed by <a href="http://twitter.com/aliok_tr">Ali Ok - @aliok_tr</a> 
        
  </div>
</div>
  
</body>
</html>