$("#add-new-batch").submit(function(e) {
    e.preventDefault();
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    let form = $("#add-new-batch").serialize();
    $.ajax({
        type: "POST",
        url: $(this).attr("action"),
        data: form,
        beforeSend: function() {
            $("#submit-new-batch").attr("disabled", true);
            $("#submit-new-batch").css("opacity", 0.3);
            $("#submit-new-batch").html("processing...");
        },
        success: function(data) {
            $("#submit-new-batch").attr("disabled", false);
            $("#submit-new-batch").html("submit");
            $("#submit-new-batch").css("opacity", 1);
            $("#new-batch-feedback").addClass("alert alert-success");
            $("#new-batch-feedback").html(
                data.message + ",  Batch No : " + data.batch_no
            );
            setTimeout(() => {
                location.reload();
            }, 3000);
        },
    });
});

$("#change-batch").submit(function(e) {
    e.preventDefault();
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    let form = $("#change-batch").serialize();
    $.ajax({
        type: "POST",
        url: $(this).attr("action"),
        data: form,
        beforeSend: function() {
            $("#change-batch-button").attr("disabled", true);
            $("#change-batch-button").css("opacity", 0.3);
            $("#change-batch-button").html("processing...");
        },
        success: function(data) {
            $("#change-batch-button").attr("disabled", false);
            $("#change-batch-button").html("submit");
            $("#change-batch-button").css("opacity", 1);
            $("#change-batch-feedback").addClass("alert alert-success");
            $("#change-batch-feedback").html(data.message);
            setTimeout(() => {
                location.reload();
            }, 3000);
        },
    });
});

$("#assign-warehouse").submit(function(e) {
    e.preventDefault();
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    let form = $("#assign-warehouse").serialize();
    $.ajax({
        type: "POST",
        url: $(this).attr("action"),
        data: form,
        beforeSend: function() {
            $("#assign-warehouse-button").attr("disabled", true);
            $("#assign-warehouse-button").css("opacity", 0.3);
            $("#assign-warehouse-button").html("processing...");
        },
        success: function(data) {
            $("#assign-warehouse-button").attr("disabled", false);
            $("#assign-warehouse-button").html("submit");
            $("#assign-warehouse-button").css("opacity", 1);
            $.toast({
                text: data.message,
                hideAfter: false,
                bgColor: "#00c292",
                position: "bottom-right",
            });
            setTimeout(() => {
                location.reload();
            }, 1000);
        },
    });
});

$("#change-partnership-status").submit(function(e) {
    e.preventDefault();
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    let form = $("#change-partnership-status").serialize();
    $.ajax({
        type: "POST",
        url: $(this).attr("action"),
        data: form,
        beforeSend: function() {
            $("#change-partnership-status-button").attr("disabled", true);
            $("#change-partnership-status-button").css("opacity", 0.3);
            $("#change-partnership-status-button").html("processing...");
        },
        success: function(data) {
            $("#change-partnership-status-button").attr("disabled", false);
            $("#change-partnership-status-button").html("submit");
            $("#change-partnership-status-button").css("opacity", 1);
            $.toast({
                text: data.message,
                hideAfter: false,
                bgColor: "#00c292",
                position: "bottom-right",
            });
            setTimeout(() => {
                location.reload();
            }, 1000);
        },
    });
});

$("#authorize_price").submit(function(e) {
    e.preventDefault();
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    let form = $("#authorize_price").serialize();
    $.ajax({
        type: "POST",
        url: $(this).attr("action"),
        data: form,
        beforeSend: function() {
            $("#authorize_price-button").attr("disabled", true);
            $("#authorize_price-button").css("opacity", 0.3);
            $("#authorize_price-button").html("processing...");
        },
        success: function(data) {
            $("#authorize_price-button").attr("disabled", false);
            $("#authorize_price-button").html("Authorize");
            $("#authorize_price-button").css("opacity", 1);

            $.toast({
                text: data.message,
                hideAfter: false,
                bgColor: "#00c292",
                position: "bottom-right",
            });
            setTimeout(() => {
                location.reload();
            }, 3000);
        },
    });
});

$("#decline_price").submit(function(e) {
    e.preventDefault();
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    let form = $("#decline_price").serialize();
    $.ajax({
        type: "POST",
        url: $(this).attr("action"),
        data: form,
        beforeSend: function() {
            $("#decline_price-button").attr("disabled", true);
            $("#decline_price-button").css("opacity", 0.3);
            $("#decline_price-button").html("processing...");
        },
        success: function(data) {
            $("#decline_price-button").attr("disabled", false);
            $("#decline_price-button").html("Decline");
            $("#decline_price-button").css("opacity", 1);

            $.toast({
                text: data.message,
                hideAfter: false,
                bgColor: "#00c292",
                position: "bottom-right",
            });
            setTimeout(() => {
                location.reload();
            }, 3000);
        },
    });
});

$("#authorize_checkout").submit(function(e) {
    e.preventDefault();
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    let form = $("#authorize_checkout").serialize();
    $.ajax({
        type: "POST",
        url: $(this).attr("action"),
        data: form,
        beforeSend: function() {
            $("#authorize_checkout-button").attr("disabled", true);
            $("#authorize_checkout-button").css("opacity", 0.3);
            $("#authorize_checkout-button").html("processing...");
        },
        success: function(data) {
            $("#authorize_checkout-button").attr("disabled", false);
            $("#authorize_checkout-button").html("Authorize");
            $("#authorize_checkout-button").css("opacity", 1);

            $.toast({
                text: data.message,
                hideAfter: false,
                bgColor: "#00c292",
                position: "bottom-right",
            });
            setTimeout(() => {
                location.reload();
            }, 3000);
        },
    });
});

$("#decline_checkout").submit(function(e) {
    e.preventDefault();
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    let form = $("#decline_checkout").serialize();
    $.ajax({
        type: "POST",
        url: $(this).attr("action"),
        data: form,
        beforeSend: function() {
            $("#decline_checkout-button").attr("disabled", true);
            $("#decline_checkout-button").css("opacity", 0.3);
            $("#decline_checkout-button").html("processing...");
        },
        success: function(data) {
            $("#decline_checkout-button").attr("disabled", false);
            $("#decline_checkout-button").html("Decline");
            $("#decline_checkout-button").css("opacity", 1);

            $.toast({
                text: data.message,
                hideAfter: false,
                bgColor: "#00c292",
                position: "bottom-right",
            });
            setTimeout(() => {
                location.reload();
            }, 3000);
        },
    });
});

$("#status").change(function(e) {
    e.preventDefault();
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    let form = new FormData($("#update_batch")[0]);
    form.append("type", "deal_status_change");
    //  form = form.serialize();
    $.ajax({
        type: "POST",
        url: $("#update_batch").attr("action"),
        data: form,
        processData: false,
        contentType: false,
        beforeSend: function() {},
        success: function(data) {
            console.log(data);
            $.toast({
                text: data.message,
                hideAfter: false,
                bgColor: "#00c292",
                position: "bottom-right",
            });
            setTimeout(() => {
                location.reload();
            }, 3000);
        },
    });
});

$("#warehouse").change(function(e) {
    e.preventDefault();
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    let form = new FormData($("#update_batch")[0]);
    form.append("type", "deal_to_warehouse");
    //  form = form.serialize();
    $.ajax({
        type: "POST",
        url: $("#update_batch").attr("action"),
        data: form,
        processData: false,
        contentType: false,
        beforeSend: function() {},
        success: function(data) {
            console.log(data);
            $.toast({
                text: data.message,
                hideAfter: false,
                bgColor: "#00c292",
                position: "bottom-right",
            });
            setTimeout(() => {
                location.reload();
            }, 3000);
        },
    });
});

$("#real_return_sold").submit(function(e) {
    e.preventDefault();

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    let form = $("#real_return_sold").serialize();
    $.ajax({
        type: "POST",
        url: $(this).attr("action"),
        data: form,
        beforeSend: function() {
            $("#real-return-sold-button").attr("disabled", true);
            $("#real-return-sold-button").css("opacity", 0.3);
            $("#real-return-sold-button").html("processing...");
        },
        success: function(data) {
            $("#real-return-sold-button").attr("disabled", false);
            $("#real-return-sold-button").html("submit");
            $("#real-return-sold-button").css("opacity", 1);
            $.toast({
                text: data.message,
                hideAfter: false,
                bgColor: "#00c292",
                position: "bottom-right",
            });
            setTimeout(() => {
                location.reload();
            }, 3000);
        },
    });
});

$("#team_member").submit(function(e) {
    e.preventDefault();

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    let form = new FormData(this);

    $.ajax({
        type: "POST",
        url: $(this).attr("action"),
        data: form,
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function() {
            $("#team-member-button").attr("disabled", true);
            $("#team-member-button").css("opacity", 0.3);
            $("#team-member-button").html("processing...");
        },
        success: function(data) {
            $("#team-member-button").attr("disabled", false);
            $("#team-member-button").html("submit");
            $("#team-member-button").css("opacity", 1);
            $.toast({
                text: data.message,
                hideAfter: false,
                bgColor: "#00c292",
                position: "bottom-right",
            });
            setTimeout(() => {
                location.reload();
            }, 3000);
        },
    });
});

$(".delete_team_member").click(function(e) {
    e.preventDefault();
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    form = new FormData();
    $.ajax({
        type: "POST",
        url: $(this).attr("href"),
        data: form,
        processData: false,
        contentType: false,
        beforeSend: function() {
            $(this).attr("disabled", true);
            $(this).css("opacity", 0.3);
            $(this).html("processing...");
        },
        success: function(data) {
            console.log(data);
            $.toast({
                text: data.message,
                hideAfter: false,
                bgColor: "#00c292",
                position: "bottom-right",
            });
            setTimeout(() => {
                location.reload();
            }, 3000);
        },
    });
});
$("#faq").submit(function(e) {
    e.preventDefault();

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    let form = new FormData(this);

    $.ajax({
        type: "POST",
        url: $(this).attr("action"),
        data: form,
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function() {
            $("#faq-button").attr("disabled", true);
            $("#faq-button").css("opacity", 0.3);
            $("#faq-button").html("processing...");
        },
        success: function(data) {
            $("#faq-button").attr("disabled", false);
            $("#faq-button").html("submit");
            $("#faq-button").css("opacity", 1);
            $.toast({
                text: data.message,
                hideAfter: false,
                bgColor: "#00c292",
                position: "bottom-right",
            });
            setTimeout(() => {
                location.reload();
            }, 3000);
        },
    });
});

$(".delete_faq").click(function(e) {
    e.preventDefault();
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    form = new FormData();
    $.ajax({
        type: "POST",
        url: $(this).attr("href"),
        data: form,
        processData: false,
        contentType: false,
        beforeSend: function() {
            $(this).attr("disabled", true);
            $(this).css("opacity", 0.3);
            $(this).html("processing...");
        },
        success: function(data) {
            console.log(data);
            $.toast({
                text: data.message,
                hideAfter: false,
                bgColor: "#00c292",
                position: "bottom-right",
            });
            setTimeout(() => {
                location.reload();
            }, 3000);
        },
    });
});

$("#review").submit(function(e) {
    e.preventDefault();

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    let form = new FormData(this);

    $.ajax({
        type: "POST",
        url: $(this).attr("action"),
        data: form,
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function() {
            $("#review-button").attr("disabled", true);
            $("#review-button").css("opacity", 0.3);
            $("#review-button").html("processing...");
        },
        success: function(data) {
            $("#review-button").attr("disabled", false);
            $("#review-button").html("submit");
            $("#review-button").css("opacity", 1);
            $.toast({
                text: data.message,
                hideAfter: false,
                bgColor: "#00c292",
                position: "bottom-right",
            });
            setTimeout(() => {
                location.reload();
            }, 3000);
        },
    });
});

$(".delete_review").click(function(e) {
    e.preventDefault();
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    form = new FormData();
    $.ajax({
        type: "POST",
        url: $(this).attr("href"),
        data: form,
        processData: false,
        contentType: false,
        beforeSend: function() {
            $(this).attr("disabled", true);
            $(this).css("opacity", 0.3);
            $(this).html("processing...");
        },
        success: function(data) {
            console.log(data);
            $.toast({
                text: data.message,
                hideAfter: false,
                bgColor: "#00c292",
                position: "bottom-right",
            });
            setTimeout(() => {
                location.reload();
            }, 3000);
        },
    });
});

$("#privacy_and_policy").submit(function(e) {
    e.preventDefault();

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    // let form= new FormData(this)
    var myEditor = document.querySelector("#quillExample1");
    var html = myEditor.children[0].innerHTML;
    var form = new FormData();
    form.append("privacy_text", html);
    $.ajax({
        type: "POST",
        url: $(this).attr("action"),
        data: form,
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function() {
            $("#privacy_and_policy-button").attr("disabled", true);
            $("#privacy_and_policy-button").css("opacity", 0.3);
            $("#privacy_and_policy-button").html("processing...");
        },
        success: function(data) {
            $("#privacy_and_policy-button").attr("disabled", false);
            $("#privacy_and_policy-button").html("submit");
            $("#privacy_and_policy-button").css("opacity", 1);
            $.toast({
                text: data.message,
                hideAfter: false,
                bgColor: "#00c292",
                position: "bottom-right",
            });
            setTimeout(() => {
                location.reload();
            }, 3000);
        },
    });
});

$("#term_and_condition").submit(function(e) {
    e.preventDefault();

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    // let form= new FormData(this)
    var myEditor = document.querySelector("#quillExample2");
    var html = myEditor.children[0].innerHTML;
    var form = new FormData();
    form.append("term_text", html);
    $.ajax({
        type: "POST",
        url: $(this).attr("action"),
        data: form,
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function() {
            $("#term_and_condition-button").attr("disabled", true);
            $("#term_and_condition-button").css("opacity", 0.3);
            $("#term_and_condition-button").html("processing...");
        },
        success: function(data) {
            $("#term_and_condition-button").attr("disabled", false);
            $("#term_and_condition-button").html("submit");
            $("#term_and_condition-button").css("opacity", 1);
            $.toast({
                text: data.message,
                hideAfter: false,
                bgColor: "#00c292",
                position: "bottom-right",
            });
            setTimeout(() => {
                location.reload();
            }, 3000);
        },
    });
});

function changeWithdrawalStatus(e, status, obj, id) {
    e.preventDefault();
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    form = new FormData();
    form.append("status", status);
    $.ajax({
        type: "POST",
        url: "/admin/accounting/withdrwal_request/" + id + "/change-status",
        data: form,
        processData: false,
        contentType: false,
        beforeSend: function() {
            $(obj).attr("disabled", true);
            $(obj).css("opacity", 0.3);
            $(obj).html("processing...");
        },
        success: function(data) {
            console.log(data);
            $.toast({
                text: data.message,
                hideAfter: false,
                bgColor: "#00c292",
                position: "bottom-right",
            });
            setTimeout(() => {
                location.reload();
            }, 3000);
        },
    });
}

function ondelete(url, name) {
    const answer = confirm("Are you sure you want to delete this " + name);

    if (answer) {
        window.location.href = url;
    }
}

$("#fund-user-wallet").submit(function(e) {
    e.preventDefault();
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });
    let form = $("#fund-user-wallet").serialize();
    $.ajax({
        type: "POST",
        url: $(this).attr("action"),
        data: form,
        beforeSend: function() {
            $("#submit-new-batch").attr("disabled", true);
            $("#submit-new-batch").css("opacity", 0.3);
            $("#submit-new-batch").html("processing...");
        },
        success: function(data) {
            $("#submit-new-batch").attr("disabled", false);
            $("#submit-new-batch").html("submit");
            $("#submit-new-batch").css("opacity", 1);
            $("#fund-user-feedback").addClass("alert alert-success");
            $("#fund-user-feedback").html(data.message);
            setTimeout(() => {
                location.reload();
            }, 3000);
        },
    });
});