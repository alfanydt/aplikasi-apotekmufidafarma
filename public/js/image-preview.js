// preview image sebelum diunggah
if (document.getElementById('image') !== null) {
    document.getElementById('image').onchange = function() {
        var reader = new FileReader();

        reader.onload = function(e) {
            // preview image
            document.getElementById("imagePreview").src = e.target.result;
        };

        reader.readAsDataURL(this.files[0]);
    };
}