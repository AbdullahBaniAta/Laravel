function buildDateRangePicker(selector, startDateInputSelector, endDateInputSelector) {
    flatpickr(selector, {
        mode: 'range',
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        onClose: async function (selectedDates) {
            if(selectedDates.length > 0 ) {
                const startDate = selectedDates[0].toLocaleString('en-JO', {timeZone: 'Asia/Amman'});
                const endDate = selectedDates.length === 2
                    ? selectedDates[1].toLocaleString('en-JO', {timeZone: 'Asia/Amman'})
                    : startDate;
                $(startDateInputSelector).val(startDate);
                $(endDateInputSelector).val(endDate);
            }
        }
    });
}
