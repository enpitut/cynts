$.fn.extend({
    toggleButtons : function(callback){
        var radios = this;
        radios.on("change", function(e){
            $(e.target).parent().parent().children(".selected").removeClass("selected");   //���łɉ�����Ă郉�W�I�{�^��
            $(e.target).closest("label").addClass("selected");                             //�����牟����郉�W�I�{�^��
            callback.call(this, e);
        });
        radios.closest("label").on("click", function(e){
            var input = $(this).find("input");
            if(! input.prop("checked")){
                input.prop("checked", true).trigger("change");
            }
        });
        radios.filter(":checked").trigger("change");
    }
});

$("input[type='radio']").toggleButtons(function(e){
   });
