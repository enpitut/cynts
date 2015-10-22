$.fn.extend({
    toggleButtons : function(callback){
        var radios = this;
        radios.on("change", function(e){
            radios.closest("label").removeClass("selected");
            $(e.target).closest("label").addClass("selected");
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
