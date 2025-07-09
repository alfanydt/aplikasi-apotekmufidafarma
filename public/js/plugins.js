// Fungsi untuk menginisialisasi plugin
$(document).ready(function () {
    // tooltip
    $("tbody").tooltip({
        selector: '[data-bs-tooltip="tooltip"]'
    });

    flatpickr(".datepicker", {
        altInput: true,
        altFormat: "F j, Y",
        dateFormat: "Y-m-d",
        disableMobile: "true"
    });
    /* Documentation : https://flatpickr.js.org/ */
    
    // select2
    $('.select2-single').each(function () {
        $(this).select2({
            // fix select2 search input focus bug
            dropdownParent: $(this).parent(),
        })
    })

    // fix select2 bootstrap modal scroll bug
    $(document).on('select2:close', '.select2-single', function (e) {
        var evt = "scroll.select2"
        $(e.target).parents().off(evt)
        $(window).off(evt)
    })

    // jquery mask plugin
    // format currency
    $('.mask-number').mask('#.##0', { reverse: true });
    /* Documentation : https://igorescobar.github.io/jQuery-Mask-Plugin/docs.html */
});