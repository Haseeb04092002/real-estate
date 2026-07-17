<script type="text/javascript">

$(document).ready(function(){
    var base_url = "<?php echo base_url();?>" ;

    $(document).off('click', '.actSubmitForm');
    $(document).on('click', '.actSubmitForm', function(e) {
        e.preventDefault();
        $(this).attr('disabled',true);

        var href = $(this).attr('href');
        var frm = $(this).attr('frm');
        var Ref = $(this).attr('ref');
        var btn = $(this);
       // Execute Parsley Validation Safely
       var isValid = false;
       try {
           var formInstance = $('#'+frm).parsley();
           formInstance.validate(); // Explicitly trigger UI messages
           
           // In Parsley 2.x, isValid() returns true/false or null
           var validResult = formInstance.isValid();
           if (validResult === null || validResult === true) {
               isValid = true;
           } else {
               isValid = false;
           }
       } catch (e) {
           console.error("Parsley validation error: ", e);
           isValid = false; // Fallback to invalid to show modal and prevent submission
       }
       
       if(isValid)
       {
            $("#divContent").hide();
            //$('#loadSpin').show().removeClass('d-none');
            var formData = new FormData($("#"+frm)[0]);
            $.ajax({
                type        : 'POST',
                url         : base_url+href,
                data        : formData,
                dataType    : 'json',
                cache       : false,
                contentType : false,
                processData : false,
                success: function(data) {
                    btn.attr('disabled', false);
                    if (data.Status == true) 
                    {
                     // $('#loadSpin').hide().addClass('d-none');
                      //$('#ModalDialog').modal('hide');
                      $("#divContent").show();

                      if (data.Message) 
                      {
                        toastr['success'](data.Message,'',{
                            'positionClass': 'toast-center-center',
                        });
                      }
                      else
                      {
                        toastr['success']("Request processed successfully.",'',{
                            'positionClass': 'toast-center-center',
                        });
                      }

                      $.each($(".actLoadLink"), function () 
                      {
                          var linkURL = $(this).attr('loadlink');
                          linkURL = linkURL.replace("/0", "/"+data.PropertyId);
                          $(this).attr('loadlink',linkURL);
                      });

                      var formToTabMap = {
                          'frmAddProperty': 'btnInformation',
                          'frmAddPrice': 'btnPricing',
                          'frmAddFeatures': 'btnFeatures',
                          'frmUploadMedia': 'btnImages',
                          'frmUploadDocuments': 'btnDocuments'
                      };
                      var tabId = formToTabMap[frm];
                      if (tabId) {
                          var tab = $('#' + tabId);
                          if (tab.find('.fa-check-circle').length === 0) {
                              tab.append('<i class="fa fa-check-circle ms-auto text-success fs-4"></i>');
                          }
                      }

                      var NextTab = data.NextTab;
                      console.log('NextTab = '+NextTab);
                      if(NextTab) {
                          $('#'+NextTab).prop('disabled',false);
                          if(NextTab == 'btnDashboard')
                          {
                            window.location.href = base_url + "Properties/dashboard";
                          }
                          else
                          {
                            $('#'+NextTab).trigger('click');
                          }
                      }





                    }
                    else if (data.Status == false) 
                    {
                        $("#divContent").show();
                        $('#loadSpin').hide().addClass('d-none');
                        
                        if (data.Message) 
                        {
                          toastr['error'](data.Message,'',{
                              'positionClass': 'toast-center-center',
                          });
                        }
                        else
                        {
                          toastr['error']("Please contact System Administrator",'',{
                              'positionClass': 'toast-center-center',
                          });
                        }
                    }
                },
                error: function(xhr, status, error) {
                    btn.attr('disabled', false);
                    $("#divContent").show();
                    $('#loadSpin').hide().addClass('d-none');
                    toastr['error']("A server error occurred. Please try again.",'',{
                        'positionClass': 'toast-center-center',
                    });
                }
              });
       }
       else
       {
           btn.attr('disabled', false);
           if ($('#validationModal').length > 0) {
               $('#validationModal').modal('show');
           }
       }
       $('#'+frm).removeClass('apply_parsley');
        
    });
    // 

$(document).off('keyup','.actGetAddresses');
$(document).on('keyup','.actGetAddresses',function(e)
{
  var formId  = "#"+$(this).closest('form').attr('id');
  var Ref = 'Home/LoadAddress';
  $(this).autocomplete({

    source: function(request, response) {
    $.ajax({
    url: base_url+Ref,
    dataType: "jsonp",
    data: {
    str: request.term
    },
    
    success: function(data) {
    response(data);
    }
    });
    },
   focus: function( event, ui ) {
return false;
},
    minLength: 3,
    select: function( event, ui ) {
      if(ui.item.label == 'No Record Found')
      {

      }
      else
      {
        $("#txtPropertyAddress").val(ui.item.label);
        $("#numZipCode").val(ui.item.postcode);
        $("#txtStreetName").val(ui.item.streetName);
        $("#txtStreetNumber").val(ui.item.streetNumber);
        $("#txtUnitNumber").val(ui.item.lotNumber);
        return false;
      }
    }
  }).autocomplete( "instance" )._renderItem = function( ul, item ) {
return $( "<li>" )
.append( "<a>" + item.label +"</a>" )
.appendTo( ul );
};

});


jQuery.fn.apply_parsley = function(validate){
    if ($('.apply_parsley').length == 1) {
        $('#' + $('.apply_parsley').attr('id')).parsley();
        if (validate) {
            $('#' + $('.apply_parsley').attr('id')).parsley().validate();
        }
    }
};

});

</script>