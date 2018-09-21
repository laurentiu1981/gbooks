(function ($) {

    $("#admin-search-form").submit(function (e) {
        e.preventDefault();

        if (validatePrice()) {
            var url = "/services/search-books";
            var values = $(this).serialize();
            $.ajax({
                url: url,
                type: "post",
                data: values,
                success: successCallback,
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
        }

    });


    function successCallback(data) {
        try {
            data = JSON.parse(data);
        } catch (e) {
            $("body").append("ERRORS: " + data);
            return;
        }

        if (data["errors"].length !== 0)
            createHTMLMessages(data["errors"]);
        else {
            var table = $("#admin-book-table").find('tbody');
            table.empty();
            for (let i = 0; i < data["books"].length; i++) {
                var icon = "<img  class='icon' src='" + data["books"][i]["image"] + "'/>";
                var link = "<a href='" + data["books"][i]["link"] + "'>Download link</a>";
                table.append($('<tr>')
                    .append('<td>' + icon + '</td>')
                    .append('<td>' + data["books"][i]["title"] + '</td>')
                    .append('<td>' + link + '</td>')
                    .append('<td>' + data["books"][i]["authors"] + '</td>')
                    .append('<td></td>'));

            }
        }

    }

    function validatePrice() {
        var priceFrom = $("input[name='price-from']").val();
        var priceTo = $("input[name='price-to']").val();
        var messages = [];
        if (priceFrom !== "" && !isNumeric(priceFrom))
            messages.push("From price is not numeric");
        if (priceFrom !== "" && !isNumeric(priceTo))
            messages.push("To price is not numeric");
        if (messages.length === 0)
            return true;
        else {
            createHTMLMessages(messages);
        }


    }

    function createHTMLMessages(messages) {
        var htmlMess = "";
        for (let i = 0; i < messages.length; i++) {
            htmlMess += "<p class='alert alert-warning' >" + messages[i] + "</p>";
        }
        $("#alert-message").html(htmlMess);
        return false;
    }

    function isNumeric(n) {
        return !isNaN(parseFloat(n)) && isFinite(n);
    }


})(jQuery);