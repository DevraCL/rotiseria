(function () {
	jQuery(document).ready(function($) {

		$('body').delegate(".input_datetime", 'hover', function(e){
	            e.preventDefault();
	            $(this).datepicker({
		               defaultDate: "",
		               dateFormat: "yy-mm-dd",
		               numberOfMonths: 1,
		               showButtonPanel: true,
	            });
         });

		var hides = ['fresh_audio_link','fresh_link_link','fresh_link_text','fresh_video_link','fresh_gallery_files'];
		var shows = {
			audio:['fresh_audio_link'],
			video:['fresh_video_link','fresh_video_text'],
			link:['fresh_link_link'],
			gallery:['fresh_gallery_files']
		}
		$( '.post-type-post #post-formats-select input' ).click( function(){
			 $(hides).each( function( i, item ){
			 	$("[name="+item+']').parent().parent().hide();
			 } );
			 var s = $(this).val();
			 if( shows[s] != null ){
			 	$(shows[s]).each( function( i, is ){
			 		$("[name="+is+']').parent().parent().show();
				 } );
			 }
		} );


	/**
	* custom for nav menu
	* function remove icon
	*/

	$( '.btn-remove-icon' ).each( function(){
		$(this).click(function(){
			var $itemid = $(this).data('id');
			//console.log($itemid);
			$('.menu-item-icon-img-'+$itemid).attr('src',"");
			$('.menu-item-upload_icon-old-'+$itemid).val("");
		});
	}); // End $( '.btn-remove-icon' ).each
}); // End jQuery(document).ready
} )( jQuery );