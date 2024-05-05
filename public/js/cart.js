$(".cart_update").change(function (e) {
    e.preventDefault();

    var ele = $(this);

    $.ajax({
        url: '/update_cart',
        method: "patch",
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            id: ele.parents("tr").attr("data-id"),
            quantity: ele.parents("tr").find(".quantity").val()
        },
        success: function (response) {
            window.location.reload();
        }
    });
});

$(".cart_remove").click(function (e) {
    e.preventDefault();

    var ele = $(this);

    if(confirm("Do you really want to remove?")) {
        $.ajax({
            url: '/remove_from_cart',
            method: "DELETE",
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                id: ele.parents("tr").attr("data-id")
            },
            success: function (response) {
                window.location.reload();
            }
        });
    }
});
