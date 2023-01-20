$(document).ready(function () {
    var zoneList = "";
    //var host = window.location.origin + '/services/admin/';
    var host = window.location.origin + '/admin/';
    localStorage.setItem("host", host);
    
    //Company or Profile Fields hide/show  - create
    $('#type').on('change', function(e){        
        if(e.target.value == 1) {
            $(".profileFields").hide();
            $(".companyFields").show();
        }
        else {
            $(".companyFields").hide();
            $(".profileFields").show();
        }
        var provider = e.target.value;
        $.ajax({
            url: host + 'agencies/getCountry?provider='+provider,
            type: 'get',
            dataType: 'json',           
            success: function(response){ 
                console.log(response);
                var resultData = response;
                var countryData = '<option value="">Please select</option>';
                $.each(resultData,function(index,row){ 
                    countryData+="<option value="+row.idref_country+">"+ row.name +"</option>";
                })
                console.log(countryData);
                $("#country").html(countryData);
            }
        });
    });

    //Company or Profile Fields hide/show - update
    var compType = $('#edit_agencies #type').val();
    if(compType == 1) {
        $("#edit_agencies .profileFields").hide();
        $("#edit_agencies .companyFields").show();
    }
    else {
        $("#edit_agencies .companyFields").hide();
        $("#edit_agencies .profileFields").show();
    }

    //get state by country
    $('#country').on('change', function(e){  
        var country = e.target.value;
        $.ajax({
            url: host + 'agencies/getState?country='+country,
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

    //service tree 
    serviceUpdateLoad();   
    $('#service_update').on('click', function(e){  
        serviceUpdateLoad();      
    });

    function serviceUpdateLoad() {
        var selectedServiceList = [];
        var servSelc = document.querySelectorAll('#service_tree input[type="checkbox"]')
        for(var i = 0; i < servSelc.length; i++) { 
            if(servSelc[i].checked && servSelc[i].dataset.isleaf == 1) {
                var serv = {"id": servSelc[i].dataset.serviceid, "name": servSelc[i].dataset.caption, "is_leaf": servSelc[i].dataset.isleaf, "price": servSelc[i].dataset.price}  
                selectedServiceList.push(serv);
            }   
            else { 
                $.each(selectedServiceList, function(j){
                    if(selectedServiceList[j].id == servSelc[i].dataset.serviceid) {
                        selectedServiceList.splice(j,1);
                        return false;
                    }
                });
            }         
        }
        
        var stringified = selectedServiceList.map(i=>JSON.stringify(i));
        var selectedService =  stringified.filter((k, idx)=> stringified.indexOf(k) === idx).map(j=> JSON.parse(j));
        console.log(selectedService);    
        getZone(selectedService); 
    }
    
    function serviceSupport(serviceData, zoneData) {
        var serviceFields =  '';       
        $.each(serviceData, function(i){ 
            var fields = '<tr><td><input type="hidden" name="serviceFields[['+i+'][service_id]" value="'+ serviceData[i].id +'" class="form-control" /><input type="text" name="serviceFields[['+i+'][service]" value="'+ serviceData[i].name +'" class="form-control" readonly /></td><td><select name="serviceFields[['+i+'][zone]" class="form-control">'+ zoneData +'</select></td><td><select name="serviceFields[['+i+'][status]" class="form-control"><option value="1">Enable</option><option value="0">Disable</option></select></td><td><input type="text" name="serviceFields[['+i+'][price]" value="'+ serviceData[i].price +'" class="form-control" required /></td><td><select name="serviceFields[['+i+'][priceType]" class="form-control"><option value="1">Fixed</option><option value="0">Negotiate</option></select></td></tr>';
            serviceFields+=fields;
        })
        $('#dynamicAddRemove tbody').html(serviceFields);
    }

    function getZone(serviceData) {
        $.ajax({
            url:  host + 'agencies/getZone',
            type: 'get',
            dataType: 'json',           
            success: function(response){ 
               // console.log(response);
                var resultData = response;
                var zoneData = '';
                $.each(resultData,function(index,row){ 
                    zoneData+="<option value="+row.idzone+">"+ row.name +"</option>";
                })
                zoneCallback(zoneData, serviceData);
                // console.log(zoneData);
                // $("#state").html(stateData);
            }
        }); 
    } 
    
    function zoneCallback(zoneData, serviceData) {
        serviceSupport(serviceData, zoneData);
    }

    //get service by agency
    $('#agency').on('change', function(e){  
        var provider_id = e.target.value;
        $.ajax({
            url: host + 'products/getServiceByAgency?provider_id='+provider_id,
            type: 'get',
            dataType: 'json',           
            success: function(response){ 
                console.log(response);
                var resultData = response;
                var servicesData = "<option value=''>Please select</option>";
                $.each(resultData,function(index,row){ 
                    servicesData+="<option value="+row.idservices+"_"+row.idservice_by_provider +">"+ row.name +"</option>";
                })
                $("#service").html(servicesData);
            }
        });    
    })

     //get service by agency
    $('#service').on('change', function(e){   
        var service_id = e.target.value.split('_');

        $.ajax({
            url: host + 'products/getAttributesByService?service_id='+service_id[0],
            type: 'get',
            dataType: 'text',           
            success: function(response){ 
                console.log(response);
                $("#service_attributes").html(response);
            }
        }); 
    })

    $('#add_contact').on('click', function(e){
        var cont = $( "#contact_list" ).val();
        var contArray = cont.split('_');
        var contactId = contArray[0];
        var contactName = contArray[1];

        var fields = '<tr><td><input type="text" name="contactFields[]['+ contactId +']" value="'+ contactName +'" class="form-control" readonly></td><td><input type="text" name="contactFields[][]" placeholder="" class="form-control"></td><td><button type="button" class="btn btn-danger"><i class="fa fa-minus nav-icon"></i> </button> </td></tr>';

        alert(cont);
    })

    $('#replyButton').on('click', function(e){ 
        var replyId = $(e.target).data("id");  
        $('#request_reply_id').val(replyId);  
    });

    $('#serviceReplyForm').submit(function (e) {
        e.preventDefault();
        var formData = $(this).serializeArray();
        console.log(formData);
        $.ajax({
            url: host + 'service-request/addreply',
            type: 'POST',
            headers: {
                Accept: "application/json"
            },
            //dataType: 'text',   
            data: formData,        
            success: function(response){ 
                console.log(response);
                window.location.reload();
            },
            error: (response) => {   console.log(response);
               window.location.reload();
            }
        });
    });

    $('#serviceCloseForm').submit(function (e) {
        e.preventDefault();
        var formData = $(this).serializeArray();
        console.log(formData);
        $.ajax({
            url: host + 'service-request/close',
            type: 'POST',
            headers: {
                Accept: "application/json"
            },
            //dataType: 'text',   
            data: formData,        
            success: function(response){ 
                window.location.reload();
            },
            error: (response) => {
               //window.location.reload();
            }
        });
    });

    $('#serviceAgentReplyForm').submit(function (e) {
        e.preventDefault();
        var formData = $(this).serializeArray();
        console.log(formData);
        $.ajax({
            url: host + 'agent-product-request/addreply',
            type: 'POST',
            headers: {
                Accept: "application/json"
            },
            //dataType: 'text',   
            data: formData,        
            success: function(response){ 
                console.log(response);
                window.location.reload();
            },
            error: (response) => {   console.log(response);
               window.location.reload();
            }
        });
    });

    $('#serviceAgencyReplyForm').submit(function (e) {
        e.preventDefault();
        var formData = $(this).serializeArray();
        console.log(formData);
        $.ajax({
            url: host + 'agency-product-request/addreply',
            type: 'POST',
            headers: {
                Accept: "application/json"
            },
            //dataType: 'text',   
            data: formData,        
            success: function(response){ 
                console.log(response);
                window.location.reload();
            },
            error: (response) => {   console.log(response);
               window.location.reload();
            }
        });
    });    

    $('#productReadyToTransferForm').submit(function (e) {
        e.preventDefault();
        var formData = $(this).serializeArray();
        console.log(formData);
        $.ajax({
            url: host + 'agent-product-request/readytoTransfer',
            type: 'POST',
            headers: {
                Accept: "application/json"
            },
            //dataType: 'text',   
            data: formData,        
            success: function(response){ 
                window.location.reload();
            },
            error: (response) => {
               window.location.reload();
            }
        });
    });

    $('#transferMaidForm').submit(function (e) {
        e.preventDefault();
        var formData = $(this).serializeArray();
        console.log(formData);
        $.ajax({
            url: host + 'agency-product-request/transferMaid',
            type: 'POST',
            headers: {
                Accept: "application/json"
            },
            //dataType: 'text',   
            data: formData,        
            success: function(response){ 
                window.location.reload();
            },
            error: (response) => {
               window.location.reload();
            }
        });
    });

    $('#serviceAgentCloseForm').submit(function (e) {
        e.preventDefault();
        var formData = $(this).serializeArray();
        console.log(formData);
        $.ajax({
            url: host + 'agent-product-request/close',
            type: 'POST',
            headers: {
                Accept: "application/json"
            },
            //dataType: 'text',   
            data: formData,        
            success: function(response){ 
               window.location.reload();
            },
            error: (response) => {
               window.location.reload();
            }
        });
    });
       
    $('#serviceAgencyAcceptForm').submit(function (e) {
        e.preventDefault();
        var formData = $(this).serializeArray();
        console.log(formData);
        $.ajax({
            url: host + 'agency-product-request/accept',
            type: 'POST',
            headers: {
                Accept: "application/json"
            },
            //dataType: 'text',   
            data: formData,        
            success: function(response){ 
               window.location.reload();
            },
            error: (response) => {
               window.location.reload();
            }
        });
    });

    //add package
    $('#addPackage').submit(function (e) { 
        e.preventDefault();
        var formData = $(this).serializeArray();
        console.log(formData);
        $.ajax({
            url: host + 'agencies/packageAdd',
            type: 'POST',
            headers: {
                Accept: "application/json"
            },
            //dataType: 'text',   
            data: formData,        
            success: function(response){ 
                window.location.reload();
            },
            error: (response) => {
            //window.location.reload();
            }
        });
    });

    //add Testimonial
    $('#addTestimonial').submit(function (e) { 
        e.preventDefault();
        var formData = $(this).serializeArray();
        $.ajax({
            url: host + 'agencies/testimonialAdd',
            type: 'POST',
            headers: {
                Accept: "application/json"
            },
            //dataType: 'text',   
            data: formData,        
            success: function(response){ 
                window.location.reload();
            },
            error: (response) => {
            //window.location.reload();
            }
        });
    });

    //add Slider
    $('#addSlider').submit(function (e) { 
        e.preventDefault();
        //var formData = $(this).serializeArray();
        var formData = new FormData(this);
        $.ajax({
            url: host + 'agencies/sliderAdd',
            type: 'POST',
            headers: {
                Accept: "application/json"
            },
            cache:false,
            contentType: false,
            processData: false,
            //dataType: 'text',   
            data: formData,        
            success: function(response){ 
                window.location.reload();
            },
            error: (response) => {
            //window.location.reload();
            }
        });
    });

    // function setReplyId(replyId) {
    //     alert(replyId);
    // }

    $(".myswitch").bootstrapSwitch();
    $('.myswitch').on('switchChange.bootstrapSwitch', function (e, data) {
        var id = $(this).attr('rel');
        var controller = $(this).attr('rel-data');
        console.log(controller);
        $('.confirm_alert').attr('rel', id);
        $('.confirm_alert').attr('data-status', data);
        $('.myswitch_'+id).bootstrapSwitch('state', !data, true);
        $.ajax({
            url: host + controller+'/update?id='+id+'&status='+data,
            type: 'get',
                      
            success: function(response){ 
                console.log(response['status']);
                if (response['status'] == 'error') {
                    $('.delete_response').html('<div class="alert alert-danger"><a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>Unable to change status</div>');
                } else {
                    $('.delete_response').html('<div class="alert alert-success"><a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>Status changed successfully</div>');
                }                
            }
        });      
    });

    //request Agent
    $('.requestAgent').on('click', function (e, data) {
        //e.preventDefault();
        var agentId = $(this).attr('rel');
        //alert(agentId);
        $.ajax({
            url: host + 'agent/request?id='+agentId,
            type: 'GET',                          
            success: function(response){ 
                window.location.reload();
            },
            error: (response) => {
            //window.location.reload();
            }
        });
    });

    //request Agency
    $('.requestAgency').on('click', function (e, data) {
        //e.preventDefault();
        var agentId = $(this).attr('rel');
        //alert(agentId);
        $.ajax({
            url: host + 'agency/request?id='+agentId,
            type: 'GET',                          
            success: function(response){ 
                window.location.reload();
            },
            error: (response) => {
            //window.location.reload();
            }
        });
    });

    
});