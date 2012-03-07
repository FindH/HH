$(function () {


    $('#addMe').click(function () {
        //alert('test');
        var pick = $('.as-values');
        //alert(pick.first().val());
        $('#tagValue').val(pick.first().val());
        //return false;
    });

    $('#searchBox').keydown(function (e) {
        if ($(this).val().length >= 2) {
            //var test = $(this).val();
            //var test2 = $(this).val().length;
            var search = $(this).val();
            var city = $('#selectLocation option:selected').text();
            var url = '/api.php/getadvertslatest/' + search + '/' + city;

            $.getJSON(url, function (data) {
                var items = [];
                if (data.list.length > 0) {
                    $.each(data.list, function (key, val) {
                        var tags = [];
                        var match = (val.ad_text.indexOf(search) != -1);
                        $.each(val.tags, function (x, y) {
                            tags.push('<li><a href="/?search=' + y.tag + '&id=' + y.value + '">' + y.tag + '</a></li>');
                            if (!match)
                                match = (y.tag.indexOf(search) != -1);
                        });
                        var img = '/images/neutral.png';
                        if (parseFloat(val.rate[0].rate) > 0.0) {
                            img = '/images/happy.png';
                        } else if (parseFloat(val.rate[0].rate) < 0.0) {
                            img = '/images/angry.png';
                        }
                        if (match)
                            items.push('<div class="helperContainer"><a href="/eachHelper.php?user_id=' + val.u_id + '&tag_id=' + val.ad_id + '"><h3>' + val.ad_text + '</h3></a><p>I Stockholm av ' + val.u_name + '</p><ul>' + tags.join("") + '</ul><div class="commentsAndLikes"><img src="' + img + '" alt="smiley" /><a href="/eachHelper.php/' + val.u_id + '">' + val.rate[0].rate + ' kommentarer</a></div></div>');
                    });
                }

                $('#results').html('');
                $('<div>', {
                    'class': 'my-new-list',
                    html: items.join('')
                }).appendTo('#results');
            });
        } else {
            $('#results').html('');
        };

        switch (e.keyCode) {
            //            case 8:  // Backspace                
            //                //console.log('backspace');                
            //            case 9:  // Tab                
            case 13: // Enter
                return false;
                //            case 37: // Left
                //            case 38: // Up
                //            case 39: // Right
                //            case 40: // Down
                //                break;

            default:

        }
    });

    $.getJSON('/api.php/gettags', function (json) {
        $('#tagPicker').autoSuggest(json.list,
        {
            minChars: 1,
            matchCase: false,
            selectedItemProp: "name",
            searchObjProps: "name",
            selectedValuesProp: "name",
            startText: "T ex gräsklippning, barnpassning",
            emptyText: "Tryck enter för att spara"
        }
        );

    });

    $('#findHelpers').click(function () {
        $.getJSON('/api.php/getadvertslatest/', function (data) {
            var items = [];

            $.each(data.list, function (key, val) {
                var tags = [];
                $.each(val.tags, function (x, y) {
                    tags.push('<li><a href="/?search=' + y.tag + '&id=' + y.value + '">' + y.tag + '</a></li>');
                });
                var img = '/images/neutral.png';
                if (parseFloat(val.rate[0].rate) > 0.0) {
                    img = '/images/happy.png';
                } else if (parseFloat(val.rate[0].rate) < 0.0) {
                    img = '/images/angry.png';
                }
                items.push('<div class="helperContainer"><a href="/eachHelper.php?user_id=' + val.u_id + '&tag_id=' + val.ad_id + '"><h3>' + val.ad_text + '</h3></a><p>I Stockholm av ' + val.u_name + '</p><ul>' + tags.join("") + '</ul><div class="commentsAndLikes"><img src="' + img + '" alt="smiley" /><a href="/eachHelper.php/' + val.u_id + '">' + val.rate[0].rate + ' kommentarer</a></div></div>');
            });

            $('#results').html('');
            $('<div>', {
                'class': 'my-new-list',
                html: items.join('')
            }).appendTo('#results');
        });

        return false;
    });

    //    $('#addMe').click(function () {
    //        var pick = $('.as-values');
    //        alert(pick.first().val());
    //        // Skicka dessa värden till nästa sida eller något
    //    });

    SetDefaultLocation();
    FindLocation();

    function SetLocation(lat, long) {
        $.getJSON('/api.php/getcities/' + lat + '/' + long, function (data) {
            // /api.php/getcities/59.3666667/16.5
            var items = [];
            var count = 0;

            $.each(data.list, function (key, val) {
                items.push('<option value="' + val.id + '">' + val.name + '</option>');

                count++;
                if (count >= 10) {
                    return false;
                }
            });

            $('#selectLocation')
                .find('option')
                .remove()
                .end()
            //                .append('<option value="whatever">text</option>')
            //                .val('whatever')
            ;
            $(items.join()).appendTo('#selectLocation');
            //$(items.join()).appendTo('#selectLocationForm');
        });
    }

    function SetDefaultLocation() {
        //alert("Tyvärr kan vi inte hitta din plats automatiskt, vänligen välj en plats i listan för bättre sökresultat.");
        $.getJSON('/api.php/getcities', function (data) {
            // /api.php/getcities/59.3666667/16.5
            var items = [];
            var count = 0;

            $.each(data.list, function (key, val) {
                items.push('<option value="' + val.id + '">' + val.name + '</option>');
                //                count++;
                //                if (count >= 10) {
                //                    return false;
                //                }
            });

            $(items.join()).appendTo('#selectLocation');
            //$(items.join()).appendTo('#selectLocationForm');
        });
    }

    function FindLocation() {

        if (navigator.geolocation) {

            navigator.geolocation.getCurrentPosition(function (position) {
                SetLocation(position.coords.latitude, position.coords.longitude);
            },
            // next function is the error callback
		    function (error) {
		        switch (error.code) {
		            case error.TIMEOUT:
		                //alert ('Timeout');
		                SetDefaultLocation();
		                break;
		            case error.POSITION_UNAVAILABLE:
		                //					alert ('Position unavailable');
		                SetDefaultLocation();
		                break;
		            case error.PERMISSION_DENIED:
		                //					alert ('Permission denied');
		                SetDefaultLocation();
		                break;
		            case error.UNKNOWN_ERROR:
		                //					alert ('Unknown error');
		                SetDefaultLocation();
		                break;
		        }
		    });
        }
    }

});