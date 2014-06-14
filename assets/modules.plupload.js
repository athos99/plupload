;
var modules = modules || {};
modules.plupload = modules.plupload || {};
(function ($) {
    var self = this;

    function resizeImageWithAspectRatio($img, maxWidth, maxHeight) {
        var w, h, ratio = 0;  // Used for aspect ratio
//        var width = $img[0].width;    // Current image width
//        var height = $img[0].height;  // Current image height
        var width = $img.width();    // Current image width
        var height = $img.height();  // Current image height

        // Check if the current width is larger than the max
        if (width > maxWidth) {
            ratio = maxWidth / width;   // get ratio for scaling image
            w = maxWidth; // Set new width
            h = height * ratio;  // Scale height based on ratio
            height = height * ratio;    // Reset height to match scaled image
            width = width * ratio;    // Reset width to match scaled image
        }

        // Check if current height is larger than max
        if (height > maxHeight) {
            ratio = maxHeight / height; // get ratio for scaling image
            h = maxHeight;   // Set new height
            w = width * ratio;    // Scale width based on ratio
            // Reset width to match scaled image
        }

//        $img.attr('height',h);   // Set new height
//        $img.attr('width',w);    // Scale width based on ratio
        $img.height(h);   // Set new height
        $img.width(w);    // Scale width based on ratio

    }

    (function () {
        $(document).ready(function () {

//            document.getElementById("toto").onchange = function (e) {
//                loadImage(
//                    e.target.files[0],
//                    function (img) {
//                        document.body.appendChild(img);
//                    },
//                    {maxWidth: 100, maxHigh: 100} // Options
//                );
//            };
            $plupload_transfer_zone = $(".plupload-transfer-zone");
            self.counter = 0;
            self.uploader = new plupload.Uploader(self.options.plupload);
            self.uploader.init();
            self.uploader.bind("FilesAdded", function (up, files) {
                $.each(files, function (i, file) {
                    self.counter++;
                    if ( self.counter < 4) {
                        $plupload_transfer_zone.attr('class','plupload-transfer-zone plupload-transfer-size1');
                    } else if ( self.counter < 7) {
                        $plupload_transfer_zone.attr('class','plupload-transfer-zone plupload-transfer-size2');
                    } else {
                        $plupload_transfer_zone.attr('class','plupload-transfer-zone plupload-transfer-size3');
                    }
                    var $divTrans = $(".plupload-transfer").first().clone();
                    $divTrans.attr("id", file.id);
                    $plupload_transfer_zone.append($divTrans);


                    var $img = $divTrans.find("img");
                    $img.hide();
                    $divTrans.find(".plupload-name").text(file.name);
                    $divTrans.find(".plupload-size").text(plupload.formatSize(file.size));
                    $divTrans.show();

                    var fr = new mOxie.FileReader();
                    fr.onload = function () {
                        $img.attr("src", this.result);
                        $img.on("load", function () {
                            resizeImageWithAspectRatio($img, 70, 70);
                            $img.show();
                        });
                    };
                    fr.readAsDataURL(file.getSource());

                });
                up.refresh(); // Reposition Flash/Silverlight
                self.uploader.start();
            });




            self.uploader.bind("UploadProgress", function (up, file) {
                $("#" + file.id + " .plupload-bar").css({width: file.percent + "%" });
            });



            self.uploader.bind("FileUploaded", function (up, file) {
//                self.counter--;
                $("#" + file.id  ).addClass("plupload-ok");
                $("#" + file.id + " .plupload-input-name").val(file.name);
                $("#" + file.id + " .plupload-progress").attr("class",self.options.transfer.progressOkClass);



                window.setTimeout(function () {
//                    $("#" + file.id).hide(500);
                }, 1000);

            });
            self.uploader.bind("Error", function (up, err) {
                $("#" + err.file.id  ).addClass("plupload-error");
                $("#" + err.file.id + " .plupload-progress" ).attr("class",self.options.transfer.progressErrorClass);
                $("#" + err.file.id + " .plupload-error-msg").text(err.message);
            });
        });
    })();

}).call(modules.plupload, jQuery); // hand in implicit parameter "this";
