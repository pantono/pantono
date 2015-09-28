Dropzone.autoDiscover = false;
$(function() {
    $(".image-upload").dropzone({ url: "/file/post" });
});