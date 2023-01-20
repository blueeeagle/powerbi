$(document).ready(function () {

    //Company or Profile Fields hide/show 
    $('#type').on('change', function(e){        
        if(e.target.value == 1) {
            $(".profileFields").hide();
            $(".companyFields").show();
        }
        else {
            $(".companyFields").hide();
            $(".profileFields").show();
        }
    });
    //get state by country
    $('#country').on('change', function(e){  
        var country = e.target.value;
        $.ajax({
            url: 'getState?country='+country,
            type: 'get',
            dataType: 'json',           
            success: function(response){ 
                console.log(response);
                var resultData = response;
                var stateData = '';
                $.each(resultData,function(index,row){ 
                    stateData+="<option value="+row.idref_state+">"+ row.name +"</option>";
                })
                console.log(stateData);
                $("#state").html(stateData);
            }
        });    
    })

});