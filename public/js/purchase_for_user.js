$("#user").change(function() {
    $.get(
        `/admin/commodity-mgt/purchase-for-user/${$(
      "#user"
    ).val()}/fetch_user_balance`,
        function(data) {
            $("#user_balance").val(data.wallet_details.wallet_balance);
        }
    );
});

// $("#quantity").blur(function() {
//     console.log("test");
// });

function checkPrice(e) {
    e.preventDefault();
    $.ajax({
        method: "GET",
        url: `/admin/commodity-mgt/purchase-for-user/${$(
      "#commodity_id"
    ).val()}/${$("#quantity").val()}/fetch-commodity-price`,
        success: function(data) {
            $("#qty_error_message").html("");
            var htmlData = `
                 <span>Commodity price : ₦${data.price_break_down.commodity_cost}</span><br>
                    <span>Expected return: ₦${data.price_break_down.expected_return} </span> 
                    <br>
                    <span>Other costs: ₦${data.price_break_down.other_costs} </span> <br>
                    <span>State tax: ₦${data.price_break_down.state_tax} </span> <br>
                    <span>Transportation: ₦${data.price_break_down.transportation}  </span><br>
                    <span>Warehousing: ₦${data.price_break_down.warehousing} </span> <br>
                    <span>total deal cost:  ₦${data.price_break_down.total_deal_cost}</span>
            `;
            $("#price_check").css("display", "block");
            $("#price_check").html(htmlData);
        },
        error: function(xhr, ajaxOptions, thrownError) {
            switch (xhr.status) {
                case 400:
                    $("#price_check").css("display", "none");
                    $("#qty_error_message").html(xhr.responseJSON.title);
                    // Take action, referencing xhr.responseText as needed.
            }
        },
    });
}