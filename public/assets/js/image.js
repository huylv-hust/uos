var add_images = function(){
    var trigger_input_file = function(){
	$('[name=image_add_btn]').click(function(){
	    $('input[type=file]').trigger('click');
	});
    };
    var add_image = function(){
	$('.image').on('change', function(){

	    //get file and pull attributes
	    var input = $(this)[0], i, type, file,
	    length = input.files.length;
	    for (i = 0; i < length; i++)
	    {
		file = input.files[i];
		type = file.type;
                size = file.size;

		if (type === 'image/jpeg' || type === 'image/png' || type === 'image/gif'){
		    //load file into preview pane
                    if(size > 204800)
                    {
                        alert('画像のサイズ < 200 kbs');
                        return ;
                    }
                    var reader = new FileReader();
                    reader.onload = function(e)
                    {
                        var image = new Image();
                        image.src = e.target.result ;
                        image.onload = function()
                        {
                            var tmp = 'data:'+type+';base64,';
                            var result = e.target.result;
                            var html = '<li>'
                                + '<div class="img-area">'
                                + '<img src="'+ result +'" width="200px" height="160px">'
                                + '<div class="close-btn">'
                                + '<input value="×" type="button">'
                                + '</div></div>'
                                + '<input type="hidden" value="" name="alt[]">'
                                + '<input type="hidden" value="'+result.replace(tmp,'')+'" name="content[]">'
                                + '<input type="hidden" value="'+file.type+'" name="mine_type[]">'
                                + '<input type="hidden" value="" name="m_image_id[]">'
                                + '</li>';
                            $(html).appendTo($('.image').closest('tr').find('.img-contents'));
                            var count_image = $('.img-contents li').length;
                            if(count_image == 4) {
                                $('.plus').hide();
                            }
                        };
                    };
                    reader.readAsDataURL(file);

		} else
		    alert('画像を入力して下さい ！(.jpg .png .gif)');
	    }
	});
    };

    //remove image
    var delete_image = function(){
        $('ul.img-contents').on('click', 'div.close-btn', function() {
            $(this).parents('li:first').remove();
            $('.plus').show();
        });
    };
    return {
	init: function(){
	    trigger_input_file();
	    add_image();
	    delete_image();
	}
    };
}();
$(function(){
    add_images.init();
});
