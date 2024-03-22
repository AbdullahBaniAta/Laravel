function buildDateRangePicker(selector, startDateInputSelector, endDateInputSelector, isMonthPicker = false, callback = null) {
    let dateFormat = 'Y-m-d H:i'
    let enableTime = true;
    let plugins = [];

    if (isMonthPicker) {
        dateFormat = 'Y-m';
        enableTime = false;
        plugins = [
            new monthSelectPlugin({
                shorthand: true,
            })
        ];
    }
    flatpickr(selector, {
        mode: 'range',
        enableTime: enableTime,
        dateFormat: dateFormat,
        plugins: plugins,
        onClose: async function (selectedDates) {
            if(selectedDates.length > 0 ) {
                const startDate = selectedDates[0].toLocaleString('en-JO', {timeZone: 'Asia/Amman'});
                let endDate = '';
                if (selectedDates[1]) {
                    endDate = selectedDates[1].toLocaleString('en-JO', {timeZone: 'Asia/Amman'});
                }
                $(startDateInputSelector).val(startDate);
                $(endDateInputSelector).val(endDate);
            }
            callback && callback();
        }
    });
}
