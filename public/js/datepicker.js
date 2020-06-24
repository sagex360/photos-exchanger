$(function () {
    let $datePicker = $('[data-datepicker]');
    let $dateGateway = $($datePicker.attr('data-pass-to') || '<input>');

    $datePicker.datepicker({
        format: "dd.mm.yyyy",
        clearBtn: true,
        multidate: false,
    }).on('changeDate', function (e) {
        console.log('changed')
    }).on('hide', function (e) {
        console.log(e);

        try {
            let dateInUTC = new Date(e.date.getTime() - (e.date.getTimezoneOffset() * 60000));

            // format date Y-m-d for back end
            var formatted = dateInUTC.toISOString().split('T')['0'];
        } catch (e) {
            formatted = '';
        }

        $dateGateway.val(formatted);

    }).datepicker('setDate', new Date($dateGateway.val()))
});
