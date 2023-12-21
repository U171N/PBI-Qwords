const base_url = "http://127.0.0.1:8000/";

$("body").on("keyup", "#search", function() {
    let text = $("#search").val();

    if (text.length > 0) {
        $.ajax({
            data: { search: text },
            url: base_url + "search-product",
            method: 'post',
            beforeSend: function(request) {
                return request.setRequestHeader('X-CSRF-TOKEN', $("meta[name='csrf-token']").attr("content"));
            },
            success: function(result) {
                $("#searchProducts").html(result);
            }
        });
    }

    if (text.length < 1) {
        $("#searchProducts").html("");
    }
});


$("#search2").on("keyup", function() {
    let searchText = $(this).val().trim();
    if (searchText !== "") {
        $.ajax({
            url: "{{ route('product.search') }}",
            method: "POST",
            data: { search: searchText },
            success: function(data) {
                $("#searchProducts2").html(data);
            }
        });
    } else {
        $("#searchProducts2").html("");
    }
});
