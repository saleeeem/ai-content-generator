(function( $ ) {
	'use strict';

	/**
	 * Ajax Call for devnetix content genrator..
	 */

  $(document).on("click", "#dev-ntx-btn", function(){
    $.ajax({
      type : "post",
      dataType : "json",
      url : chatbot.ajaxurl,
      data : {
          action: "myaction" ,
          request:  $('#dev-ntx-title').val()
           },
          beforeSend: function(){
          $('.dev-ntx-loader').show();
          $('.dev-ntx-main.dev-ntx-metaboxs').addClass('loading')
          
          },
          complete: function(){
          $('.dev-ntx-loader').hide();
          $('.dev-ntx-main.dev-ntx-metaboxs').removeClass('loading')
          },
          success: function(response) {
            if(response){
              const result = response
              $('#dev-ntx-res-container').append( response )
            }      
          }
    });
  });

  // TAGS BOX
  $("#dev-ntx-tags input").on({
    focusout() {
      var txt = this.value.replace(/[^a-z0-9\+\-\.\#]/ig,''); // allowed characters
      if(txt) $("<span/>", {text:txt.toLowerCase(), insertBefore:this});
      this.value = "";
    },
    keyup(ev) {
      if(/(,|Enter)/.test(ev.key)) $(this).focusout(); 
    }
  });
  $("#dev-ntx-tags").on("click", "span", function() {
    $(this).remove(); 
  });

})( jQuery );


