"use strict";

let getYesWord = $("#message-yes-word").data("text");
let getNoWord = $("#message-no-word").data("text");
let messageAreYouSure = $("#message-are-you-sure").data("text");

$(window).on('load',function (){
    generateRandomString(12);
})
$(".search-bar-input").on("keyup", function () {
    $(".pos-search-card").removeClass("d-none").show();
    let name = $(".search-bar-input").val();
    let elementSearchResultBox = $(".search-result-box");
    if (name.length > 0) {
        $("#pos-search-box").removeClass("d-none").show();
        $.get({
            url: $("#route-admin-products-search-product").data("url"),
            dataType: "json",
            data: {
                name: name,
            },
            beforeSend: function () {
                $("#loading").fadeIn();
            },
            success: function (data) {
                elementSearchResultBox.empty().html(data.result);
                renderSelectProduct();
                renderQuickViewSearchFunctionality();
                // $("#quick-view").modal("show");
            },
            complete: function () {
                $("#loading").fadeOut();
            },
        });
    } else {
        elementSearchResultBox.empty().hide();
    }
});

function renderSelectProduct() {

    // let variationCount = $("#variation-count").val();
    // if(variationCount){
    //     $("#variation").addClass('d-none');
    // }
    $(".action-add-to-cart").on("click", function () {
        addToCart();
    });

    $(".action-color-change").on("click", function () {
        let val = $(this).val();
        $(".color-border").removeClass("border-add");
        $("#label-" + val.id).addClass("border-add");
    });

    cartQuantityInitialize();
    //getVariantPrice();
    $(".variant-change input , .cart-qty-field").on("change", function () {
       // getVariantPrice();
       //  $('.set-price').html($('.cart-qty-field').val)
    });
    $("#add-to-cart-form .in-cart-quantity-field").on("change", function () {
        //getVariantPrice("already_in_cart");
    });

    $(".cart-qty-field").focus(function () {
        $(this).closest(".product-quantity-group").addClass("border-primary");
    });

    $(".cart-qty-field").blur(function () {
        $(this)
            .closest(".product-quantity-group")
            .removeClass("border-primary");
    });

    $(".in-cart-quantity-field").focus(function () {
        $(this).closest(".product-quantity-group").addClass("border-primary");
    });

    $(".in-cart-quantity-field").blur(function () {
        $(this)
            .closest(".product-quantity-group")
            .removeClass("border-primary");
    });
}
function cartQuantityInitialize() {
    $(".btn-number").click(function (e) {
        e.preventDefault();
        let fieldName = $(this).attr("data-field");
        let type = $(this).attr("data-type");
        let input = $("input[name='" + fieldName + "']");
        let currentVal = parseInt(input.val());

        if (!isNaN(currentVal)) {
            if (type == "minus") {
                if (currentVal > input.attr("min")) {
                    input.val(currentVal - 1).change();
                }
                if (parseInt(input.val()) == input.attr("min")) {
                    $(this).attr("disabled", true);
                }
            } else if (type == "plus") {
                if (currentVal < input.attr("max")) {
                    input.val(currentVal + 1).change();
                }
                if (parseInt(input.val()) == input.attr("max")) {
                    $(this).attr("disabled", true);
                }
            }
        } else {
            input.val(0);
        }
    });

    $(".input-number").focusin(function () {
        $(this).data("oldValue", $(this).val());
    });

    $(".input-number").change(function () {
        let minValue = parseInt($(this).attr("min"));
        let maxValue = parseInt($(this).attr("max"));
        let valueCurrent = parseInt($(this).val());
        let name = $(this).attr("name");
        if (valueCurrent >= minValue) {
            $(".btn-number[data-type='minus'][data-field='" + name + "']").removeAttr("disabled");
        }else {
            $(this).val($(this).data("oldValue"))
        }
        if (valueCurrent <= maxValue) {
            $(".btn-number[data-type='plus'][data-field='" + name + "']").removeAttr("disabled");
        }else {
            $(this).val($(this).data("oldValue"))
        }
    });
    $(".input-number").keydown(function (e) {
        if (
            $.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
            (e.keyCode == 65 && e.ctrlKey === true) ||
            (e.keyCode >= 35 && e.keyCode <= 39)
        ) {
            return;
        }
        if (
            (e.shiftKey || e.keyCode < 48 || e.keyCode > 57) &&
            (e.keyCode < 96 || e.keyCode > 105)
        ) {
            e.preventDefault();
        }
    });
}
function renderQuickViewSearchFunctionality() {
    $(".action-select-search-product").on("click", function () {
        quickView($(this).data("id"));
    });
}
function quickView(product_id) {
    $.ajax({
        url: $("#route-admin-pos-stock-quick-view").data("url"),
        type: "GET",
        data: {
            product_id: product_id,
        },
        dataType: "json",
        beforeSend: function () {
            $("#loading").fadeIn();
        },
        success: function (data) {
            $("#quick-view-modal").empty().html(data.view);
            renderSelectProduct();
            //renderRippleEffect();
            //closeAlertMessage();
            $("#quick-view").modal("show");
        },
        complete: function () {
            $("#loading").fadeOut();
        },
    });
}
function getVariantPrice(type = null) {
    // if (
    //     $("#add-to-cart-form input[name=quantity]").val() > 0 &&
    //     checkAddToCartValidity()
    // ) {
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="_token"]').attr("content"),
            },
        });
        $.ajax({
            type: "POST",
            url:$("#route-admin-pos-get-variant-price").data("url") +
                (type ? "?type=" + type : ""),
            data: $("#add-to-cart-form").serializeArray(),
            success: function (data) {
                let price ;
                let tax ;
                let discount ;
                stockStatus(data.quantity,'cart-qty-field-plus','cart-qty-field')
                if (data.inCartStatus == 0) {
                    $(".default-quantity-system").removeClass("d-none");
                    $(".quick-view-modal-add-cart-button").text(
                        $("#message-add-to-cart").data("text")
                    );
                    $(".in-cart-quantity-system")
                        .addClass("d--none");
                    $(".default-quantity-system")
                        .removeClass("d--none");
                    price = data.price;
                    tax = data.tax;
                    discount = (data.discount*data.requestQuantity);
                } else {
                    $(".default-quantity-system")
                        .addClass("d--none");
                    $(".in-cart-quantity-system")
                        .removeClass("d--none");
                    $(".quick-view-modal-add-cart-button").text(
                        $("#message-update-to-cart").data("text")
                    );
                    if (type == null) {
                        $(".in-cart-quantity-field").val(data.inCartData.quantity);
                        data.inCartData.quantity == 1
                            ? buttonDisableOrEnableFunction('in-cart-quantity-minus',true )
                            : "";
                        price = data.inCartData.price;
                        tax = data.inCartData.tax;
                        discount = (data.inCartData.discount*data.inCartData.quantity);
                    }else{
                        price = data.price;
                        tax = data.tax;
                        discount = (data.discount*data.requestQuantity);
                    }
                    stockStatus(data.quantity,'in-cart-quantity-plus','in-cart-quantity-field')
                }
                setProductData('price-section',price,tax,discount);
            },
        });
    // }
}

// function addToCart(form_id = "add-to-cart-form") {
//     // if (checkAddToCartValidity()) {
//         $.ajaxSetup({
//             headers: {
//                 "X-CSRF-TOKEN": $('meta[name="_token"]').attr("content"),
//             },
//         });
//         $.post({
//             url: $("#route-admin-pos-add-to-cart").data("url"),
//             data: $("#" + form_id).serializeArray(),
//             beforeSend: function () {
//                 $("#loading").fadeIn();
//             },
//             success: function (data) {
//                 if (data.data == 1) {
//                     $("#cart-summary").empty().html(data.view);
//                     toastr.success($("#message-cart-updated").data("text"), {
//                         CloseButton: true,
//                         ProgressBar: true,
//                     });
//                     data.inCartData && data.inCartData == 1
//                         ? $(".in-cart-quantity-field").val(data.requestQuantity)
//                         : "";
//                     //removeFromCart();
//                     //basicFunctionalityForCartSummary();
//                     return false;
//                 }
//                 // else if (data.data == 0) {
//                 //     $('.product-stock-message').empty().html($('#get-product-stock-message').data('out-of-stock'))
//                 //     $('.pos-alert-message').removeClass('d-none');
//                 //     return false;
//                 // }
//                 else {
//                     $(".in-cart-quantity-field").val(data.quantity);
//                     //getVariantPrice();
//                     setTimeout(function () {
//                         $(".cart-qty-field").val(1);
//                     }, 500);
//                 }
//                 $(".call-when-done").click();
//
//                 toastr.success(
//                     $("#message-item-has-been-added-in-your-cart").data("text"),
//                     {
//                         CloseButton: true,
//                         ProgressBar: true,
//                     }
//                 );
//                 $("#cart").empty().html(data.view);
//                 //viewAllHoldOrders("keyup");
//                 $(".search-result-box").empty().hide();
//                 $("#search").val("");
//                 //basicFunctionalityForCartSummary();
//                 posUpdateQuantityFunctionality();
//                 removeFromCart();
//             },
//             complete: function () {
//                 $("#loading").fadeOut();
//             },
//         });
//     // } else {
//     //     Swal.fire({
//     //         type: "info",
//     //         title: $("#message-cart-word").data("text"),
//     //         text: $("#message-please-choose-all-the-options").data("text"),
//     //     });
//     // }
// }


function removeFromCart() {
    $(".remove-from-cart").on("click", function () {
        let id = $(this).data("id");
        let variant = $(this).data("variant");
        $.post(
            $("#route-admin-pos-remove-cart").data("url"),
            {
                _token: $('meta[name="_token"]').attr("content"),
                id: id,
                variant: variant,
            },
            function (data) {
                $("#cart").empty().html(data.view);
                if (data.errors) {
                    for (
                        let increment = 0;
                        increment < data.errors.length;
                        increment++
                    ) {
                        toastr.error(data.errors[increment].message, {
                            CloseButton: true,
                            ProgressBar: true,
                        });
                    }
                } else {
                    toastr.info(
                        $("#message-item-has-been-removed-from-cart").data(
                            "text"
                        ),
                        {
                            CloseButton: true,
                            ProgressBar: true,
                        }
                    );
                    //viewAllHoldOrders("keyup");
                }
                //posUpdateQuantityFunctionality();
                posUpdateQuantityFunctionality();
                removeFromCart();
            }
        );
    });
}
function posUpdateQuantityFunctionality() {
    $(".action-pos-update-quantity").on("change", function (event) {
        let getKey = $(this).data("product-key");
        let quantity = $(this).val();
        let variant = $(this).data("product-variant");
        getPOSUpdateQuantity(getKey, quantity, event, variant);
    });
}

    // $('#saveData').click(function(){
    //     var inputData = $('#inputData').val();
    //     if(inputData) {
    //         $('#dataTable tbody').append('<tr><td>' + inputData + '</td></tr>');
    //         $('#inputData').val(''); // Clear the input field
    //         $('#dataModal').modal('hide'); // Hide the modal
    //     }
    // });
let itemIndex = 0;
let grandTotal = 0;
function addToCart(form_id = "add-to-cart-form") {

    let product=[];
    product['productCode'] = $('#product-code').text().trim();
    product['productName'] = $('.product-title').text().trim();
    product['productVariation'] = $('#variations').val();
    if(product['productVariation'] === undefined){
        product['productVariation'] = 'N/A'
    }

    product['productQty'] = $('.cart-qty-field').val().trim();
    product['productUnitPrice'] = $('.discounted_unit_price').text().replace('৳','').trim();
    let productTotal = parseFloat((product['productQty']*product['productUnitPrice']).toString());
    product['productSubTotal'] = productTotal.toFixed(2);

    let duplicate = false;
    product['productName']= product['productName'].length > 40 ? product['productName'].slice(0,40)+"..." : product['productName']
    debugger;
    $('#dataTable tbody tr').each(function(){
        // console.log('lksdfjlskdjflk');
        // console.log($(this).find('td:first input').text().toLowerCase());

        // if($(this).find('td:first input').text().toLowerCase() === product['productCode'].toLowerCase()
        //     && $(this).find('td:nth-child(3) input').text().toLowerCase() === product['productVariation'].toLowerCase()
        //     ){
        //     console.log($(this).find('td:nth-child(3)').text().toLowerCase());
        //     console.log(product['productVariation']);
        //     duplicate = true;
        //     return false;
        // }
    })

    if(!duplicate && product['productName']) {
        // $('#dataTable tbody').append('<tr>' +
        // '<td  name="code">' + product['productCode']  + '</td>' +
        // '<td name="name" >' + product['productName'] + '</td>' +
        // '<td name="variation">' + product['productVariation'] + '</td>' +
        // '<td name="qty">' + product['productQty'] + '</td>' +
        // '<td name="unitPrice">' + product['productUnitPrice'] + '</td>' +
        //     '<td>'+ '<button class="btn btn-danger btn-sm delete-btn">Remove</button>'+'</td>'+
        // '</tr>'
        // );


        const itemHTML = `
            <tr>
            <td><input type="text" data-toggle="tooltip" data-placement="top" title="${product['productCode']}" name="items[${itemIndex}][productCode]" value="${product['productCode']}" readonly style="border: none; background: transparent"/></td>
            <td><input type="text" title="${product['productName']}" name="items[${itemIndex}][productName]" value="${product['productName']}" readonly style="border: none; background: transparent" /></td>
            <td><input type="text" title="${product['productVariation']}" name="items[${itemIndex}][productVariation]" value="${product['productVariation']}" readonly style="border: none; background: transparent" /></td>
            <td><input type="text" name="items[${itemIndex}][productQty]" value="${product['productQty']}" readonly style="border: none; background: transparent" /></td>
            <td><input type="text" name="items[${itemIndex}][productUnitPrice]" value="${product['productUnitPrice']}" readonly style="border: none; background: transparent" /></td>
            <td><input type="text" name="items[${itemIndex}][productSubTotal]" value="${product['productSubTotal']}" readonly style="border: none; background: transparent" /></td>
            <td><button class="btn btn-danger btn-sm delete-btn">Remove</button></td>
            </tr>
        `
        $('#dataTable tbody').append(itemHTML);
        $('#grandTotal').val((grandTotal += parseFloat(product['productSubTotal'])).toFixed(2));
        itemIndex++;

        $(".search-result-box").empty().hide();
        $("#search").val("");
        $(".modal-body").addClass('d-none');
    }
    else if(duplicate){
        alert('Data already exist in the list');
    }
}

$('#dataTable').on('click', '.delete-btn', function() {
    let row = $(this).closest('tr');
    row.remove();
});

$('.action-onclick-generate-number').on('click', function () {
    let getElement = $(this).data('input');
    $(getElement).val(generateRandomString(12));
    //generateSKUPlaceHolder();
})
function generateRandomString(length) {
    let result = '';
    let characters = '012345ABCDEFGHIJKLMNOPQRSTUVWXYZ3456789';
    let charactersLength = characters.length;
    for (let i = 0; i < length; i++) {
        result += characters.charAt(Math.floor(Math.random() * charactersLength));
    }
    return "REF-SI-"+result;
}
$('#generate_number').on('keyup', function() {
    generateRefNo();
    console.log('hello');
});
function generateRefNo(){
    let newPlaceholderValue = $('#get-example-text').data('example')+' : '+$('input[name=refNo]').val()+'-MCU-47-V593-M';
    $('.store-keeping-unit').attr('placeholder', newPlaceholderValue);
}

//Saving Stock Data
$(".action-form-submit").on("click", function () {
    ValidateStockInput();
});

function SaveStockData(){
    Swal.fire({
        title: messageAreYouSure,
        type: "warning",
        text: $(this).data("message"),
        showCancelButton: true,
        showConfirmButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: getNoWord,
        confirmButtonText: getYesWord,
        reverseButtons: true,
    }).then(function (result) {
        if (result.value) {
            let formData = new FormData(document.getElementById('data-stock'));
            // let tableData = [];
            // $('#data-table tbody tr').each(function () {
            //     let rowData = {};
            //     $(this).find('td').each(function (index) {
            //         rowData['column' + (index + 1)] = $(this).text();
            //     });
            //     tableData.push(rowData);
            // });

            $.ajaxSetup({
                headers: {
                    "X-XSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
            });
            $.post({
                url: $("#data-stock").attr("action"),
                data: formData,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    $("#loading").fadeIn();
                    // $('#submit-stock').prop('disabled', true);
                    $('#submit-stock').attr('disabled','disabled');
                },
                success: function (response) {
                    if (true){
                        $('#stockModal').modal('show');
                        $('.alert--message-3').removeClass('d-none');
                        $('.warning-message').empty().html(response.message);
                    }else {
                        location.reload();
                    }
                },
                complete: function () {
                    $("#loading").fadeOut();
                    //$('#submit-stock').removeAttr('disabled');
                    window.location.href= $("#route-admin-stock-list").data("url");
                },
            });
        }
    });
}
function ValidateStockInput(){
    let sellerId = $("#seller_id").val();
    let warehouseId = $("#warehouse_id").val();
    let dateAndTime = $("#date-time").val();
    let refNo = $(".ref-no").val();

    if (sellerId == 0) {
        toastr.warning(
            $("#message-stock-in-seller-id").data("text"),
            {
                CloseButton: true,
                ProgressBar: true,
            }
        );
    } else if (warehouseId == "") {
        toastr.warning(
            $("#message-stock-in-warehouse").data("text"),
            {
                CloseButton: true,
                ProgressBar: true,
            }
        );
    } else if (dateAndTime == "") {
        toastr.warning(
            $("#message-stock-in-date-time").data("text"),
            {
                CloseButton: true,
                ProgressBar: true,
            }
        );
    } else if (refNo =="") {
        toastr.warning(
            $("#message-stock-in-ref-no").data("text"),
            {
                CloseButton: true,
                ProgressBar: true,
            }
        );
    } else if (itemIndex === 0) {
        toastr.warning(
            $("#message-stock-in-product").data("text"),
            {
                CloseButton: true,
                ProgressBar: true,
            }
        );
    } else {
        SaveStockData();
    }
}

// function ExtractTableData(){
//     let tableData = [];
//     $('#data-table tbody tr').each(function () {
//         let rowData = {};
//         $(this).find('td').each(function (index) {
//             rowData['column' + (index + 1)] = $(this).text();
//         });
//         tableData.push(rowData);
//     });
// }


