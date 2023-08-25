$(document).ready(function() {
    // Call datatable calss
    new DataTable('#sections');
    new DataTable('#categories');
    new DataTable('#brands');
    new DataTable('#values');
    new DataTable('#options');
    new DataTable('#products');

    $(".nav-item").removeClass("active");
    $(".nav-link").removeClass("active");

    // Check admin password is correct or not
    $("#current_password").keyup(function() {
        var current_password = $("#current_password").val();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'post',
            url: '/admin/check-admin-password',
            data: { current_password: current_password },
            success: function(resp) {
                if (resp == "false") {
                    $("#check_password").html("<font color='red'>Current Password is Incorrect!</font>");
                } else if (resp == "true") {
                    $("#check_password").html("<font color='green'>Current Password is Correct!</font>");
                }
            },
            error: function() {
                alert('Error');
            }
        });
    })

    // Update admin status
    $(document).on('click', '.update-admin-status', function() {
        var status = $(this).children("i").attr("status");
        var admin_id = $(this).attr("admin_id");
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'post',
            url: '/admin/update-admin-status',
            data: { status: status, admin_id: admin_id },
            success: function(resp) {
                if (resp['status'] == 0) {
                    $("#admin-" + admin_id).html("<i style='font-size: 25px;' class='mdi mdi-bookmark-outline' status='Inactive'></i>");
                } else if (resp['status'] == 1) {
                    $("#admin-" + admin_id).html("<i style='font-size: 25px;' class='mdi mdi-bookmark-check' status='Active'></i>")
                }
            },
            error: function() {
                alert("Error");
            }
        });
    });

    // Update Section status
    $(document).on('click', '.update-section-status', function() {
        var status = $(this).children("i").attr("status");
        var section_id = $(this).attr("section_id");
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'post',
            url: '/admin/update-section-status',
            data: { status: status, section_id: section_id },
            success: function(resp) {
                if (resp['status'] == 0) {
                    $("#section-" + section_id).html("<i style='font-size: 25px;' class='mdi mdi-bookmark-outline' status='Inactive'></i>");
                } else if (resp['status'] == 1) {
                    $("#section-" + section_id).html("<i style='font-size: 25px;' class='mdi mdi-bookmark-check' status='Active'></i>")
                }
            },
            error: function() {
                alert("Error");
            }
        });
    });

    // Confirm Deletion for section
    $(".confirmDelete").click(function() {

        var module = $(this).attr('module');
        var moduleid = $(this).attr('moduleid');
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire(
                    'Deleted!',
                    'Your file has been deleted.',
                    'success'
                )
            }
            window.location = "/admin/delete-" + module + "/" + moduleid;
        });
    });

    // Update Category status
    $(document).on('click', '.update-category-status', function() {
        var status = $(this).children("i").attr("status");
        var category_id = $(this).attr("category_id");
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'post',
            url: '/admin/update-category-status',
            data: { status: status, category_id: category_id },
            success: function(resp) {
                if (resp['status'] == 0) {
                    $("#category-" + category_id).html("<i style='font-size: 25px;' class='mdi mdi-bookmark-outline' status='Inactive'></i>");
                } else if (resp['status'] == 1) {
                    $("#category-" + category_id).html("<i style='font-size: 25px;' class='mdi mdi-bookmark-check' status='Active'></i>")
                }
            },
            error: function() {
                alert("Error");
            }
        });
    });

    // Update Brand status
    $(document).on('click', '.update-brand-status', function() {
        var status = $(this).children("i").attr("status");
        var brand_id = $(this).attr("brand_id");
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'post',
            url: '/admin/update-brand-status',
            data: { status: status, brand_id: brand_id },
            success: function(resp) {
                if (resp['status'] == 0) {
                    $("#brand-" + brand_id).html("<i style='font-size: 25px;' class='mdi mdi-bookmark-outline' status='Inactive'></i>");
                } else if (resp['status'] == 1) {
                    $("#brand-" + brand_id).html("<i style='font-size: 25px;' class='mdi mdi-bookmark-check' status='Active'></i>")
                }
            },
            error: function() {
                alert("Error");
            }
        });
    });

    // Update Product status
    $(document).on('click', '.update-product-status', function() {
        var status = $(this).children("i").attr("status");
        var product_id = $(this).attr("product_id");
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'post',
            url: '/admin/update-product-status',
            data: { status: status, product_id: product_id },
            success: function(resp) {
                if (resp['status'] == 0) {
                    $("#product-" + product_id).html("<i style='font-size: 25px;' class='mdi mdi-bookmark-outline' status='Inactive'></i>");
                } else if (resp['status'] == 1) {
                    $("#product-" + product_id).html("<i style='font-size: 25px;' class='mdi mdi-bookmark-check' status='Active'></i>")
                }
            },
            error: function() {
                alert("Error");
            }
        });
    });

    // Product attributes add/remove script
    var maxField = 10; //Input fields increment limitation
    var addButton = $('.add_button'); //Add button selector
    var wrapper = $('.field_wrapper'); //Input field wrapper
    var fieldHTML = '<div><div style="height:10px;"></div><input type="text" name="value_id[]" placeholder="Value" style="width:120px;" />&nbsp;<input type="text" name="sku[]" placeholder="SKU" style="width:120px;" /><input type="text" name="price[]" placeholder="Price" style="width:120px;" />&nbsp;<input type="text" name="stock[]" placeholder="Stock" style="width:120px;" />&nbsp;<a href="javascript:void(0);" class="remove_button">Remove</a></div>'; //New input field html 
    var x = 1; //Initial field counter is 1

    //Once add button is clicked
    $(addButton).click(function() {
        //Check maximum number of input fields
        if (x < maxField) {
            x++; //Increment field counter
            $(wrapper).append(fieldHTML); //Add field html
        }
    });

    //Once remove button is clicked
    $(wrapper).on('click', '.remove_button', function(e) {
        e.preventDefault();
        $(this).parent('div').remove(); //Remove field html
        x--; //Decrement field counter
    });
});