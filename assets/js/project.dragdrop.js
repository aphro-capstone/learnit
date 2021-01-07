
	


 
	var myDropzone = new Dropzone("#drop-item-box", { 
		url: "capstone_project/student/postAttachment",
	    parallelUploads: 2,
	    thumbnailHeight: 120,
	    thumbnailWidth: 120,
	    maxFilesize: 3,
	    filesizeBase: 1000,
	    thumbnail: function(file, dataUrl) {
	      if (file.previewElement) {
	        file.previewElement.classList.remove("dz-file-preview");
	        var images = file.previewElement.querySelectorAll("[data-dz-thumbnail]");

	        
	        for (var i = 0; i < images.length; i++) {
	          var thumbnailElement = images[i];
	          thumbnailElement.alt = file.name;
	          thumbnailElement.src = dataUrl;
	        }
	        setTimeout(function() { file.previewElement.classList.add("dz-image-preview"); }, 1);
	      }
	    }
	});

	var minSteps = 6,
      maxSteps = 60,
      timeBetweenSteps = 100,
      bytesPerStep = 100000;

	myDropzone.uploadFiles = function(files) {
		console.log('uploadFiles');
	    var self = this;

	    for (var i = 0; i < files.length; i++) {

	      var file = files[i];
	          totalSteps = Math.round(Math.min(maxSteps, Math.max(minSteps, file.size / bytesPerStep)));

	      for (var step = 0; step < totalSteps; step++) {
	        var duration = timeBetweenSteps * (step + 1);
	        setTimeout(function(file, totalSteps, step) {
	          return function() {
	            file.upload = {
	              progress: 100 * (step + 1) / totalSteps,
	              total: file.size,
	              bytesSent: (step + 1) * file.size / totalSteps
	            };

	            self.emit('uploadprogress', file, file.upload.progress, file.upload.bytesSent);
	            if (file.upload.progress == 100) {
	              file.status = Dropzone.SUCCESS;
	              self.emit("success", file, 'success', null);
	              self.emit("complete", file);
	              self.processQueue();
	            }
	          };
	        }(file, totalSteps, step), duration);
	      }
	    }
	  }
 