
    $( "input[name*='zip']" ).on( "blur ", function() {
        let input=this;
        if (input.value)
        {
            $( "#save" ).prop('disabled',true)
            $( "input[name*='city'],input[name*='state']" ).val('')
            let url='/autocomplete/state/city'
            let body = {"query": input.value};

            $.get(url, body, function (data) {
                $( "input[name*='city']" ).val(data.city)
                $( "input[name*='state']" ).val(data.state)
            }).done(function(data) {
                $( "#save" ).prop('disabled',false)
                if(typeof(data.city)  === "undefined")
                    input.value='';
            });
        }
    });
