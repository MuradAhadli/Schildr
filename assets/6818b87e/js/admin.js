$(function () {
    var body = $('body');
    body.on('click', '.confirm-delete', function () {
        var button = $(this).addClass('disabled');
        var title = button.attr('title');

        if (confirm(title ? title + '?' : 'Confirm the deletion')) {
            if (button.data('reload')) {
                return true;
            }
            $.getJSON(button.attr('href'), function (response) {
                button.removeClass('disabled');
                if (response.result === 'success') {
                    notify.success(response.message);
                    button.closest('tr').fadeOut(function () {
                        this.remove();
                    });
                } else {
                    alert(response.error);
                }
            });
        }
        return false;
    });

    body.on('click', '.move-up, .move-down', function () {
        var button = $(this).addClass('disabled');

        $.getJSON(button.attr('href'), function (response) {
            button.removeClass('disabled');
            if (response.result === 'success' && response.swap_id) {
                var current = button.closest('tr');
                var swap = $('tr[data-id=' + response.swap_id + ']', current.parent());

                if (swap.get(0)) {
                    if (button.hasClass('move-up')) {
                        swap.before(current);
                    } else {
                        swap.after(current);
                    }
                } else {
                    location.reload();
                }
            }
            else if (response.error) {
                alert(response.error);
            }
        });

        return false;
    });

    $('.switch').switcher({copy: {en: {yes: '', no: ''}}}).on('change', function () {
        var checkbox = $(this);
        checkbox.switcher('setDisabled', true);

        $.getJSON(checkbox.data('link') + '/' + (checkbox.is(':checked') ? 'on' : 'off') + '/' + checkbox.data('id'), function (response) {
            if (response.result === 'error') {
                alert(response.error);
            }
            if (checkbox.data('reload')) {
                location.reload();
            } else {
                checkbox.switcher('setDisabled', false);
            }
        });
    });

    $(document).bind('keydown', function (e) {
        if (e.ctrlKey && e.which === 83) { // Check for the Ctrl key being pressed, and if the key = [S] (83)
            $('.model-form').submit();
            e.preventDefault();
            return false;
        }
    });

    window.notify = new Notify();
});

var Notify = function () {
    var div = $('<div id="notify-alert"></div>').appendTo('body');
    var queue = [];
    var _this = this;

    this.success = function (text) {
        queue.push({type: 'success', text: text, icon: 'ok-sign'});
        _this.proceedQueue();
    }
    this.error = function (text) {
        queue.push({type: 'danger', text: text, icon: 'info-sign'});
        _this.proceedQueue();
    }

    this.proceedQueue = function () {
        if (queue.length > 0 && !div.is(":visible")) {
            div.removeClass().addClass('alert alert-' + queue[0].type).html('<span class="glyphicon glyphicon-' + queue[0].icon + '"></span> ' + queue[0].text);
            div.fadeToggle();

            setTimeout(function () {
                queue.splice(0, 1);
                div.fadeToggle(function () {
                    _this.proceedQueue();
                });
            }, 3000);
        }
    }
};


$(document).ready(function () {
    $(document).on('click', '.del_carousel_item', function () {
        var id = $(this).data('id');
        var this_elem = $(this);
        $.ajax({
            url: 'delete-carousel-item',
            data: {
                id: id
            },
            method: 'post',
            dataType: 'html',
            success: function (data) {
                this_elem.closest('div').remove();
            },
            error: function (err) {
                err.responseText();
            }

        });
    });
});

/** Delete Product File **/
$(document).ready(function () {
    $(document).on('click', '.delete_product_file', function () {
        var id = $(this).data('id');
        var this_elem = $(this);

        $.ajax({
            url: 'delete-product-files',
            data: {
                id: id
            },
            method: 'post',
            dataType: 'json',
            success: function (data) {
                this_elem.closest('div').remove();
            },
            error: function (err) {
                err.responseText();
            }
        });
    });
});


/** Add custom input file Product/_form.php**/
$(document).ready(function () {
    var child = ' <div class="form-group col-xs-12 item">' +
        '            <div class="row item-inner">' +
        '                <div class="col-xs-4">' +
        '                    <div class="form-group">' +
        '                        <label for="downloads">PDF</label>' +
        '                        <input id="downloads" type="file" class="form-control" name="downloads[]">' +
        '                    </div>' +
        '                </div>' +
        '                <div class="col-xs-4">' +
        '                    <div class="form-group">' +
        '                        <label for="pdf_title">PDF title</label>' +
        '                        <input type="text" class="form-control" required name="pdf_title[]">' +
        '                    </div>' +
        '                </div>' +
        '                <div class="col-xs-2">' +
        '                    <span class="item_del"><i class="fa fa-minus"></i></span>' +
        '                </div>' +
        '            </div>' +
        '        </div>'

    $(document).on('click', '.btn_add', function (e) {
        $(this).closest('#downloads_area').append(child);
    });


    $(document).on('click', '.item_del', function (e) {
        $(this).closest('.item').remove();
    });

});


/**Delete Pdf (Product/form)**/
$(document).ready(function (e) {
    $('.del_pdf').click(function () {
        var key = $(this).data('key');
        var id = $(this).data('id');
        var this_elem = $(this);

        $.ajax({
            url: 'delete-pdf-files',
            method: 'post',
            data: {
                id: id,
                key: key,
            },
            dataType: 'html',
            success: function (data) {
                this_elem.closest('div').remove();
            },
            error: function (err) {
                err.message();
            }

        });


    });
});


/**Carousel For Product**/

$(document).ready(function () {
    $('.carousel__body').find('.form-group:first-child').addClass('show');
    $('.carousel__header').find('span').click(function (e) {
        e.preventDefault();
        var selectorId = $(this).attr('id');
        var btnOfSelector = $(this).closest('.carousel_tab').find('select[data-active = ' + selectorId + ']').closest('div');
        var selectOfSelector = $(this).closest('.carousel_tab').find('select[data-active = ' + selectorId + ']');
        //for buttons ...
        $(this).closest('div').find('span').filter(function (index, item) {
            if ($(item).hasClass('active')) {
                $(item).removeClass('active');
            }
        });
        // /for buttons ...
        // for form-group
        $(this).addClass('active');
        $(this).closest('.carousel_tab').find('.form-group').filter(function (index, item) {
            if ($(item).hasClass('show')) {
                $(item).removeClass('show').addClass('hidden');
            }
        });
        btnOfSelector.removeClass('hidden').addClass('show');
        //selectOfSelector.prop('selectedIndex', 0);
        // /for form-group ...
    });
});

/** /Carousel For Product**/

/**FILE UPLOADER PLUGIN**/
/**Bootstrap file uploader**/
function getInitialPreview() {
    var dataUploads = $('.recFile').data('newuploads');
    var initialPreview = [];

    for (item in dataUploads) {
        initialPreview.push(dataUploads[item]);
    }

    console.log(initialPreview);
    return initialPreview;
}

function getKeys() {
    var dataKeys = $('.recFile').data('key');
    var keyProp = [];

    for (index in dataKeys) {
        keyProp.push(dataKeys[index]);
    }
    return keyProp;
}

/*This function for isBaseImage*/
function getTypes() {
    var dataTypes = $('.recFile').data('types');
    var dataTypesArr = [];
    var tmpItem;

    for (index in dataTypes) {
        dataTypesArr.push(dataTypes[index]);
    }

    console.log(dataTypesArr);
    return dataTypesArr;
}

/*This function for isBaseImage*/


/*Adding types to Items*/
function addTypes(typesArr = []) {
    var items = $('.kv-preview-thumb');
    $.each(items, function (index, item) {
        $(item).attr('data-type', typesArr[index]);
    });
}

/* /Adding types to Items*/

/*Check isBase item*/
function isBase() {
    var items = $('.kv-preview-thumb');

    $.each(items, function (index, item) {
            if ($(item).data('type') == 1) {
                $(item).addClass('base-image');
            }
        }
    );
}

/* /Check isBase item*/
function makePreviewConfig() {
    var configArray = [];
    var initialPreview = getInitialPreview();
    var keys = getKeys();

    initialPreview.forEach(function (item, index) {
        var configObj = {};

        configObj.caption = 'caption-' + index;
        configObj.size = 329892;
        configObj.width = "120px";
        configObj.key = keys[index];
        configObj.url = './delete-uploads/' + keys[index];
        configArray.push(configObj);
    });

    return configArray;
}


/*Remove Element From Arr*/
function arrayRemove(arr, value) {

    return arr.filter(function (ele) {
        return ele != value;
    });

}

// var result = arrayRemove(array, 6);
/* /Remove Element From Arr*/


function __sortingKeys(obj = {}) {
    var reasonObj = {};
    var assignedArr = [];
    var unAssignedArr = [];
    $.each(obj, (index, item) => {
        unAssignedArr.push(item.key);
    assignedArr.push(item.key);
})
    ;

    assignedArr.sort(function (a, b) {
        return a - b;
    });

    $.each(assignedArr, (index, item) => {
        reasonObj[item] = unAssignedArr[index];
})
    ;

    return reasonObj;

}

/*Other action buttons for Plugin*/
var selectBaseImageBtn =
    '<button type="button" class="btn btn-sm kv-base-image-btn btn-kv btn-default btn-outline-secondary" title="Select Base Image"{dataKey}>' +
    '<i class="fas fa-home"></i>' +
    '</button>';
/* /Other action buttons for Plugin*/

$(".recFile").fileinput({
    theme: 'fas',
    uploadUrl: '#', // you must set a valid URL here else you will get an error
    // allowedFileExtensions: ['jpg', 'png', 'gif'],
    showCaption: true,
    maxFileSize: 500000,
    maxFilesNum: 10,
    allowedFileTypes: ['image', 'video', 'pdf'],
    showUpload: true,
    browseClass: "btn btn-primary btn-block btn-lg",
    fileType: "any",
    previewFileIcon: "<i class='glyphicon glyphicon-king'></i>",
    overwriteInitial: true,
    initialPreviewAsData: true,
    initialPreview: getInitialPreview(),
    initialPreviewConfig: makePreviewConfig(),
    otherActionButtons: selectBaseImageBtn,
}).on('filesorted', function (event, params) {
    // console.log('File sorted ', params.previewId, params.oldIndex, params.newIndex, params.stack);

    if (confirm('Are you really sorted these elements ?')) {
        var sortedObj = __sortingKeys(params.stack);

        $.ajax({
            url: './file-sorted',
            data: {
                sortedObj: sortedObj,
            },
            method: 'POST',
            dataType: 'json',
            success: function (data) {
                console.log(data);
            },
            error: function (err) {
                err.responseText;
            }

        });

    } else {
        return false;
    }

});

/*Select Base Image*/
(function ($) {
    $.fn.selectBaseImage = function () {
        var e = $(this);
        var key = e.data('key');
        var product_id = e.parents('.file-input-ajax-new').find('.classRequired').data('url');
        var previewItems = $('.kv-preview-thumb');

        function baseOnlyIsOne(items) {
            $.each(items, function (index, item) {
                if ($(item).hasClass('base-image')) {
                    $(item).removeClass('base-image');
                }
            });
        }

        /*Called basOnlyIsOne function*/
        baseOnlyIsOne(previewItems);
        /* /Called basOnlyIsOne function*/

        /*Send ajax request for selected base image ..*/
        $.ajax({
            url: './select-base-image',
            method: 'POST',
            data: {
                key: key,
                product_id: product_id
            },
            dataType: 'html',
            success: function (data) {
                e.parents('.kv-preview-thumb').addClass('base-image')
            },
            error: function (err) {
                err.responseText;
            }
        });
        /*Send ajax request for selected base image ..*/
    }
    /*Trigger Custom Plugin (selectBaseImage()) */
    $(document).on('click', '.kv-base-image-btn', function () {
        $(this).selectBaseImage();
    });
    /* /Trigger Custom Plugin (selectBaseImage()) */

    var typesArr = getTypes();

    /*Adding data-types attr to items*/
    addTypes(typesArr);
    /* /Adding data-types attr to items*/

    /*Called isBase() function*/
    isBase();
    /* /Called isBase() function*/

})(jQuery);
/* /Select Base Image*/

/** /Bootstrap file uploader**/

/** /FILE UPLOADER PLUGIN**/



$(document).ready(function () {

    /*Delete Project Item*/
    $(document).on('click', '#deleteProject', function () {
        var this_e = $(this);
        var key = this_e.closest('.file-item').data('key');

        $.ajax({
            url: 'delete-uploads',
            data: {
                key: key,
            },
            method: 'POST',
            dataType: 'html',
            success: function (data) {
                if (data == 1) {
                    this_e.closest('.file-item').fadeOut(300);
                } else {
                    alert('Problem when process deleted');
                }
            },
            error: function (err) {
                err.responseText;
            }
        });
    });


    /*Select Preview Image*/
    $(document).on('click', '#previewImage', function () {
        var this_e = $(this);
        var key = this_e.closest('.file-item').data('key');
        var parentId = this_e.closest('.project-files').data('parent');

        $.ajax({
            url: 'select-base-image',
            data: {
                key: key,
                parentId: parentId,
            },
            method: 'POST',
            dataType: 'html',
            success: function (data) {

                var elems = $('.file-item');

                $.each(elems, function (index, item) {
                    if ($(item).hasClass('base-image')) {
                        $(item).removeClass('base-image');
                    }
                });

                this_e.closest('.file-item').addClass('base-image');

            },
            error: function (err) {
                err.responseText;
            }
        });
    });

});