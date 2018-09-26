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
            if (typeof data !== "object") {
                JSON.parse(data);
            }
        } catch (e) {
            $("#messages").html(data);
            $("#messages").addClass("alert alert-warning");
            return;
        }

        if (data["errors"].length !== 0)
            createHTMLMessages(data["errors"]);
        else {
            var table = $("#admin-book-table").find('tbody');
            table.empty();
            for (let i = 0; i < data["books"].length; i++) {
                var icon = "<img  class='icon' src='" + data["books"][i]["image"] + "'/>";
                var link = "";
                if (data["books"][i]["buy_link"])
                    link = "<a href='" + data["books"][i]["buy_link"] + "'>Buy link</a>";
                var id = data["books"][i]["id"];
                var editLink = "<a href='/admin/book/edit/" + id + "?destination=/admin'' >Edit</a>";
                var deleteLink = "<a href='/admin/book/delete/" + id + "'>Delete</a>";
                table.append($('<tr>')
                    .append('<td>' + icon + '</td>')
                    .append('<td>' + data["books"][i]["title"] + '</td>')
                    .append('<td>' + link + '</td>')
                    .append('<td>' + data["books"][i]["authors"].join(", ") + '</td>')
                    .append('<td>' + data["books"][i]["price"] + '</td>')
                    .append('<td>' + data["books"][i]["currency"] + '</td>')
                    .append('<td>' + data["books"][i]["language"] + '</td>')
                    .append('<td>' + editLink + " | " + deleteLink + '</td>'));

            }
        }

    }

    function validatePrice() {
        var priceFrom = $("input[name='price-from']").val();
        var priceTo = $("input[name='price-to']").val();
        var messages = [];
        if (priceFrom !== "" && !isNumeric(priceFrom))
            messages.push("From price is not numeric");
        if (priceTo !== "" && !isNumeric(priceTo))
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