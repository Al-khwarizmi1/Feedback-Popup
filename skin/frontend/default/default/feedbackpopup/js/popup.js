function openFeedbackWindow(ele,upd_ele,id)
{  if(popupShow)
        {
    Effect.Appear(ele);
    var back1 = document.getElementById ('backgroundpopup');
    back1.style.display = "block";
    popupShow = false;
        }
}
function closeFeedbackWindow(ele1){
    
    var val1=document.getElementById(ele1);    
    var background=document.getElementById('backgroundpopup');
    Effect.Fade(val1);
    Effect.Fade(background);
    $$('div.error-massage').each(function(ele){
        ele.hide();
    });
   // var divId = val1.id;
     popupShow = true;
//var parts = divId.split('feedback_information');
   //alert(parts[1]);
   $$('.trigger').each(function(ele){
   
    ele.setStyle({
    display: 'block'
  
    });
});
$$('.popuptrigger').each(function(ele){
   
    ele.setStyle({
    display: 'block'
  
    });
});
        }
    

function sendFeedback(feedback_form,url,divid,formid,buttonId,loderId,sucessMessage){
    
    if(feedback_form && feedback_form.validate()){
       
        $(loderId).show();
        $(buttonId).setAttribute('disabled', true);
        var parameters=$(formid).serialize(true);
        new Ajax.Request(url, {
                method: 'post',
                dataType: 'json',
                parameters: parameters,
                onSuccess: function(transport) {
                    if(transport.status == 200) {
                        var response=transport.responseText.evalJSON();
                        $(sucessMessage).innerHTML=response.message;
                        if(response.result=='success'){
                            $(sucessMessage).removeClassName('feedback-error-msg');
                            $(sucessMessage).addClassName('feedback-success-msg');
                        }
                        else{
                            $(sucessMessage).removeClassName('feedback-success-msg');
                            $(sucessMessage).addClassName('feedback-error-msg');
                        }
                        $(loderId).hide();
                        $(sucessMessage).show();
                        Effect.toggle(sucessMessage, 'appear',{ duration: 5.0});
                        setTimeout(function (){
                                closeFeedbackWindow(divid);
                                $(formid).reset();
                                $(buttonId).removeAttribute('disabled');
                            },6000);
                        return false;
                    }
                }
        });
        return false;
    }
}