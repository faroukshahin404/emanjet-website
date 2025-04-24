
function changeQuantity(id) {
    var value = document.getElementById('qty_'+ id).value;
    console.log(value);    
    $.ajax({
        url: '/change-stock-value',
        method: 'POST',
        data: {
            
            _token: $('meta[name="csrf-token"]').attr('content'),

            id: id,
            
            value: value
        },
        success: function (response) {
            console.log(response);
        },
        error: function (xhr, status, error) {
        }
    });
}