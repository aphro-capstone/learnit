$('.attachment-select-frst-trigger').on('click',function(){
	attachmentlist = [];
});



function Attachment(name,size,type,link,cbOnDel ){
	this.name = name;
	this.image = undefined;
	this.imagesTypes = {
					'jpg' 	: 'image',
					'png' 	: 'image',
					'gif' 	: '',
					'docx' 	: '',
					'doc' 	: '',
					'xml' 	: '',
					'ppt' 	: '',
					'pdf'	: '',
	};
	this.size = size;
	this.link = link;
	this.type = type;  

	this.setImage = (type) => {
		this.image = this.imagesTypes[type];
	};
	
	this.createAttachmentFrontend = () => {
		let i = this;
		let a = $('<div class="attachment-item"></div>');
			a.append('<div class="file-type-image pull-left mr-2"> <div class="attachment-image image-'+ this.type +'"></div></div>');
			a.append('<span class="text pull-left"> '+ this.name + '.' + this.type +' </span>');

		let delBtn = $('<span class="remove-icon text-danger ml-2 mr-0" data-toggle="tooltip" data-placement="bottom" data-origina-title="remove" data-original-title="Remove Attachment"> <i class="fa fa-times"></i> </span>');
			delBtn.tooltip();
			delBtn.click(function(){
				setTimeout( () => {
					a.remove();
					cbOnDel();
				},100);
			});

			a.click(function(){
				if(i.type == 'document'){
					window.open( i.link, 'Download' );
				}else if (i.type == 'link'){
					window.open(i.link, '_blank');
				}
			});
			
			a.append('<span class="size pull-right"> '+ this.size +'  </span>');
			a.append(delBtn);

		
		return a;
	}
}
