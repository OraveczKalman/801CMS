function loadPage(url, event) {
    $('#content-wrapper').load(url, { event:event });
}

function save(formName) {
    $('#event').val('save');
    $('#' + formName).submit();
}

function showErrors(data) {
    for (var i=0; i<=data.length-1; i++) {
        $('#' + data[i].controllId).tooltip('destroy');
        $('#' + data[i].controllId).parent().addClass('has-error');
        $('#' + data[i].controllId).tooltip({
            'title': data[i].message,
            'placement': 'right',
            'trigger': 'manual'
        }).tooltip('show');
    }    
}

function sendOneField(functionName, url, data, controllId) {
    //$('#' + controllId).parent().removeClass('has-error');
    //$('#' + controllId).tooltip('destroy');
    $('.alert').html('');
    $('.alert').css('display', 'none');
    $.post(url, { 'event':'validateField', 'function': functionName, 'data':data, 'controllId':controllId }, function(data) {
        if (data !== '') {
            data = JSON.parse(data);
            showErrors(data);
        }
    });
}

/**
 * @param {string} controllId
 * @param {string} event
 * @param {int} minLength
 * @param {int} wide
 * Select2 komponensek automatikus létrehozó függvénye
 */
function autocompleteWrapper(controllId, event, minLength, font, allNeeded, customer) {
    var dropdownCssString = "";
    if (typeof font !== 'undefined' && font !== "") {
        dropdownCssString += ' tinyFont';
    }
    if (typeof allNeeded === 'undefined' && allNeeded !== "") {
        allNeeded = 0;
    }
    if (typeof customer === 'undefined') {
        customer = "";
    }
    if (customer === "") {
        $(controllId).select2({
            ajax: {
                placeholder: 'All',
                allowClear: true,
                url: "ajax_pages/new_autocomplete_ajax.php?event=" + event + "&allNeeded=" + allNeeded,
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        term: params.term
                    };
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function(item) {
                            return {id: item.id, text: item.text };
                        })
                    };
                }
            },
            minimumInputLength: minLength,
            dropdownCssClass : 'wideDropDown' + dropdownCssString,
            placeholderOption: function() { return undefined; }
        }).focus(function () { $(controllId).select2('open'); });
    } else {
        $(controllId).select2({
            ajax: {
                placeholder: 'All',
                allowClear: true,
                url: "ajax_pages/new_autocomplete_ajax.php?event=" + event + "&allNeeded=" + allNeeded + "&customer=" + customer,
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        term: params.term
                    };
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function(item) {
                            return {id: item.id, text: item.text };
                        })
                    };
                }
            },
            minimumInputLength: minLength,
            dropdownCssClass : 'wideDropDown' + dropdownCssString,
            placeholderOption: function() { return undefined; }
        }).focus(function () { $(controllId).select2('open'); });
    }
}

/**
 * @param {string} controllId
 * @param {string} event
 * @param {int} minLength
 * Select2 komponensek automatikus létrehozó függvénye
 */
function autocompleteWrapperGrouped(controllId, event, minLength, dataJson) {
    $(controllId).select2({
        data: dataJson,
        minimumInputLength: minLength,
        dropdownCssClass : 'wideDropDown'
    }).focus(function () { $(controllId).select2('open'); });        
}

/**
 * 
 * @param {type} controllId
 * @param {type} acName
 * @param {type} dKey
 * @param {type} searchType
 * @param {type} minLength
 * @returns {undefined}
 */
function autocompleteWrapperTypeahead(controllId, acName, dKey, searchType, tableName, minLength) {
    var resultBh = new Bloodhound({
        datumTokenizer: function (d) {
            return Bloodhound.tokenizers.whitespace(d.value);
        },
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        remote: {
            url: "ajax_pages/new_autocomplete_bh_ajax.php?event=" + searchType + "&term=%QUERY"
        }
    });

    resultBh.initialize();

    $('#' + controllId).typeahead(null, {
        name: acName,
        displayKey: dKey,
        source: resultBh.ttAdapter()
    });

    $('#' + controllId).on('keydown', function (event) {
        if (event.which === 13 || event.which === 9) {
            $.post('ajax_pages/new_autocomplete_bh_ajax.php?event=addNew', { data:$('#' + controllId).val(), table:tableName }, function (data) {
            });
        }
    });
}

/**
 * 
 * @param {type} tableId
 * @param {type} ajaxUrl
 * @param {type} columnNames
 * @param {type} functionObject
 * @param {type} domText
 * @param {type} coloredCell
 * @param {type} vertScroll
 * @param {type} plusButtons
 * @param {type} orderField
 * @param {type} orderDirection
 * @returns {undefined}
 * A menüs táblázatok létrehozó függvénye
 */
function tableSkeleton(tableId, ajaxUrl, columnNames, functionObject, userLineHeight, domText, coloredCell, vertScroll, plusButtons, orderField, orderDirection, fc) {
    var buttonCollection = [];
    var ran = 0;

    if (typeof domText === 'undefined' || domText === '') {
        var domText = 'TlfrtipB';
    }
    
    if (typeof vertScroll === 'undefined' || vertScroll === '') {
        var vertScroll = '300';
    }
	
    if (typeof orderField === 'undefined' || orderField === '') {
        var orderField = 0;
    }

    if (typeof orderDirection === 'undefined' || orderDirection === '') {
        var orderDirection = "desc";
    }
    
    if (typeof plusButtons !== 'undefined' && plusButtons !== '') {
        buttonCollection.push(plusButtons);
    }
    
    $('#' + tableId).DataTable({
        scrollY: vertScroll,
        paging: false,
        "processing": true,
        "scrollX": true,
        "sScrollXInner": "110%",
        "order": [[orderField, orderDirection]],
        "ajax": ajaxUrl,
        "columns": columnNames,
        colReorder: true,
        deferRender: true,
        rowCallback: function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
            var parts = aData.DT_RowId.split("¤");
            var Color = parts[parts.length-1];
            if (Color > "") {
                if (typeof coloredCell !== 'undefined' || coloredCell !== '') {
                    if (coloredCell !== 'all') {
                        $('td', nRow).eq(coloredCell).css('background-color', Color);
                    } else {
                        $(nRow).css('background-color', Color);
                    }
                }
            }
            $('td', nRow).css('border-right', '1px solid #dddddd');
            $(nRow).on('click', function () {
                if (functionObject !== '') {
                    ran = 1;
                    functionObject['mutat'](parts);
                }
            });
        },
        keys: { 
            keys: [ 38, 40 ]
        },
        buttons: buttonCollection,   
        dom: '<"wrapper"' + domText + '>',
        "bStateSave": false,
        "fnInitComplete": function (oSettings, json) {
            if (tableId !== "invoiceHead") {
                $(this).closest('#' + tableId + '_wrapper').find('.dt-buttons.btn-group').addClass('table_tools_group').children('a.btn').each(function () {
                    $(this).addClass('btn-small');
                });
            } else if (tableId === "invoiceHead") {
                $(this).closest('#' + tableId + '_wrapper').find('.dt-buttons.btn-group').children('a.btn').each(function () {
                    $(this).addClass('btn-small');
                });
                $('#' + tableId + '_wrapper .wrapper .dt-buttons').css("padding-top", "0.757em");
                $('#' + tableId + '_wrapper .wrapper .dt-buttons').css("float", "right");
            }
        }
    }).on('key-focus', function (e, datatable, cell) {
        if (ran === 0) {
            var row = datatable.row(cell.index().row);
            var rd = row.data();
            var parts = rd.DT_RowId.split("¤");
            datatable.$('tr.selected').removeClass('selected');
            $(row.node()).addClass( "selected" );
            if (functionObject !== '') {

                functionObject['mutat'](parts);
            }
        } else if (ran === 1) {
            ran = 0;
        }
    });
    SelectRow('#' + tableId);
}

/**
 * 
 * @param {type} tableId
 * @param {type} ajaxUrl
 * @param {type} columnNames
 * @param {type} functionObject
 * @param {type} domText
 * @param {type} coloredCell
 * @returns {undefined}
 * A nem menüs táblázatok létrehozó függvénye
 */
function tableSkeletonNoMenu(tableId, ajaxUrl, columnNames, functionObject, userLineHeight, domText, coloredCell, noButtons, fc) {
    if (typeof domText === 'undefined' || domText === '') {
        var domText = 'BTlfrtip';
    }
    
    if (typeof noButtons === 'undefined' || noButtons === '') {
        var buttonCollection = [
            {
                extend: 'colvis',
                text: 'Columns'
            },
            {
                text: 'Excel',
                extend: 'excelHtml5',
                exportOptions: {
                    columns: ':visible',
                    orthogonal: 'export'
                }
            }
        ];
    } else {
        var buttonCollection = [];       
    }
    
    $('#' + tableId).DataTable({
        scrollY: 300,
        paging: false,
        scrollX: true,
        "sScrollXInner": "110%",
        "ajax": ajaxUrl,
        "columns": columnNames,
        colReorder: true,
        dom: '<"wrapper"' + domText + '>',
        rowCallback: function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
            if (typeof functionObject !== 'undefined' || functionObject !== '') {
                var parts = aData.DT_RowId.split("¤");
                var Color = parts[parts.length-1];
                if (Color > "") {
                    if (typeof coloredCell !== 'undefined' || coloredCell !== '') {
                        $('td', nRow).eq(coloredCell).css('background-color', Color);
                    }
                }
                $('td', nRow).css('border-right', '1px solid #dddddd');
                $(nRow).on('click', function () {
                    functionObject['mutat'](parts);
                });
            }
        },        
        buttons: buttonCollection,
        "bStateSave": false,
        "fnInitComplete": function (oSettings, json) {
            $(this).closest('#' + tableId + '_wrapper').find('.dt-buttons.btn-group').addClass('table_tools_group').children('a.btn').each(function () {
                $(this).addClass('btn-small');
            });
        }
    }).on('column-visibility.dt', function(e, settings, column, state ) {
        var columnsString = "";
        console.log(settings);
        for (var i=0; i<=settings.aoColumns.length-1; i++) {
            columnsString += settings.aoColumns[i].data + "," + settings.aoColumns[i].sTitle + "," + settings.aoColumns[i].bVisible + "," + settings.aoColumns[i].sClass + "|";
        }
        columnsString = columnsString.slice(0, -1);
        $.post("./ajax_pages/setCookiePost_ajax.php", { kukinev: tableId, kukiertek: columnsString });
    }).on('column-reorder', function(e, settings, details) {
        var columnsString = "";
        for (var i=0; i<=settings.aoColumns.length-1; i++) {
            columnsString += settings.aoColumns[i].data + "," + settings.aoColumns[i].sTitle + "," + settings.aoColumns[i].bVisible + "," + settings.aoColumns[i].sClass + "|";
        }
        columnsString = columnsString.slice(0, -1);
        $.post("./ajax_pages/setCookiePost_ajax.php", { kukinev: tableId, kukiertek: columnsString });
    });
    switch (userLineHeight) {
        case 'small' :
            $("#" + tableId  + "_wrapper .wrapper .dataTables_scrollHead").css("line-height", "1px");
            $("#" + tableId  + "_wrapper .wrapper .dataTables_scrollHead").css("font-size", "12px");
            $("#" + tableId  + "_wrapper .wrapper .dataTables_scrollBody").css("line-height", "1px");
            $("#" + tableId  + "_wrapper .wrapper .dataTables_scrollBody").css("font-size", "12px");
            break;
        case 'normal' :
            $("#" + tableId  + "_wrapper .wrapper .dataTables_scrollHead").css("line-height", "10px");
            $("#" + tableId  + "_wrapper .wrapper .dataTables_scrollHead").css("font-size", "13px");
            $("#" + tableId  + "_wrapper .wrapper .dataTables_scrollBody").css("line-height", "10px");
            $("#" + tableId  + "_wrapper .wrapper .dataTables_scrollBody").css("font-size", "13px");
            break;
        case 'large' :
            $("#" + tableId  + "_wrapper .wrapper .dataTables_scrollHead").css("line-height", "15px");
            $("#" + tableId  + "_wrapper .wrapper .dataTables_scrollHead").css("font-size", "14px");
            $("#" + tableId  + "_wrapper .wrapper .dataTables_scrollBody").css("line-height", "15px");
            $("#" + tableId  + "_wrapper .wrapper .dataTables_scrollBody").css("font-size", "14px");
            break;           
    }
    if (typeof fc !== 'undefined') {
        $("#" + tableId  + "_wrapper .wrapper .dataTables_scroll .dataTables_scrollBody").css("height", "fit-content");
        $("#" + tableId  + "_wrapper .wrapper .dataTables_scroll .dataTables_scrollBody").css("min-height", "80px");
    }
}

/**
 * 
 * @param {type} tableId
 * @param {type} ajaxUrl
 * @param {type} columnNames
 * @param {type} functionObject
 * @param {type} domText
 * @param {type} coloredCell
 * @returns {undefined}
 * A nem menüs táblázatok létrehozó függvénye
 */
function tableSkeletonDetailsTable(tableId, ajaxUrl, columnNames, functionObject, userLineHeight, domText, coloredCell, noButtons, fc) {
    //var parts = new Array();
    if (typeof domText === 'undefined' || domText === '') {
        var domText = 'BTlfrtip';
    }
    
    if (typeof noButtons === 'undefined' || noButtons === '') {
        var buttonCollection = [
            {
                extend: 'colvis',
                text: 'Columns'
            },
            {
                text: 'Excel',
                extend: 'excelHtml5',
                exportOptions: {
                    columns: ':visible',
                    orthogonal: 'export'
                }
            }
        ];
    } else {
        var buttonCollection = [];       
    }
    
    var table = $('#' + tableId).DataTable({
        scrollY: 300,
        paging: false,
        scrollX: true,
        "sScrollXInner": "110%",
        "ajax": ajaxUrl,
        "columns": columnNames,
        colReorder: true,
        "bFilter": false,
        dom: '<"wrapper"' + domText + '>',
        rowCallback: function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
            //console.log(nRow);
            if (typeof functionObject !== 'undefined' || functionObject !== '') {
                var parts = aData.DT_RowId.split("¤");
                var Color = parts[parts.length-1];
                if (Color > "") {
                    if (typeof coloredCell !== 'undefined' || coloredCell !== '') {
                        $('td', nRow).eq(coloredCell).css('background-color', Color);
                    }
                }
                parts[1] = tableId;
                //alert(parts[1]);
                $(nRow).on('click', function () {
                    functionObject['mutat'](parts);
                });
            }
        },        
        buttons: buttonCollection,
        "bStateSave": false,
        "fnInitComplete": function (oSettings, json) {
            $(this).closest('#' + tableId + '_wrapper').find('.dt-buttons.btn-group').addClass('table_tools_group').children('a.btn').each(function () {
                $(this).addClass('btn-small');
            });
        }
    }).on('column-visibility.dt', function(e, settings, column, state ) {
        var columnsString = "";
        console.log(settings);
        for (var i=0; i<=settings.aoColumns.length-1; i++) {
            columnsString += settings.aoColumns[i].data + "," + settings.aoColumns[i].sTitle + "," + settings.aoColumns[i].bVisible + "," + settings.aoColumns[i].sClass + "|";
        }
        columnsString = columnsString.slice(0, -1);
        $.post("./ajax_pages/setCookiePost_ajax.php", { kukinev: tableId, kukiertek: columnsString });
    }).on('column-reorder', function(e, settings, details) {
        var columnsString = "";
        for (var i=0; i<=settings.aoColumns.length-1; i++) {
            columnsString += settings.aoColumns[i].data + "," + settings.aoColumns[i].sTitle + "," + settings.aoColumns[i].bVisible + "," + settings.aoColumns[i].sClass + "|";
        }
        columnsString = columnsString.slice(0, -1);
        $.post("./ajax_pages/setCookiePost_ajax.php", { kukinev: tableId, kukiertek: columnsString });
    });
    switch (userLineHeight) {
        case 'small' :
            $("#" + tableId  + "_wrapper .wrapper .dataTables_scrollHead").css("line-height", "1px");
            $("#" + tableId  + "_wrapper .wrapper .dataTables_scrollHead").css("font-size", "12px");
            $("#" + tableId  + "_wrapper .wrapper .dataTables_scrollBody").css("line-height", "1px");
            $("#" + tableId  + "_wrapper .wrapper .dataTables_scrollBody").css("font-size", "12px");
            break;
        case 'normal' :
            $("#" + tableId  + "_wrapper .wrapper .dataTables_scrollHead").css("line-height", "10px");
            $("#" + tableId  + "_wrapper .wrapper .dataTables_scrollHead").css("font-size", "13px");
            $("#" + tableId  + "_wrapper .wrapper .dataTables_scrollBody").css("line-height", "10px");
            $("#" + tableId  + "_wrapper .wrapper .dataTables_scrollBody").css("font-size", "13px");
            break;
        case 'large' :
            $("#" + tableId  + "_wrapper .wrapper .dataTables_scrollHead").css("line-height", "15px");
            $("#" + tableId  + "_wrapper .wrapper .dataTables_scrollHead").css("font-size", "14px");
            $("#" + tableId  + "_wrapper .wrapper .dataTables_scrollBody").css("line-height", "15px");
            $("#" + tableId  + "_wrapper .wrapper .dataTables_scrollBody").css("font-size", "14px");
            break;           
    }
    if (typeof fc !== 'undefined') {
        $("#" + tableId  + "_wrapper .wrapper .dataTables_scroll .dataTables_scrollBody").css("height", "fit-content");
        $("#" + tableId  + "_wrapper .wrapper .dataTables_scroll .dataTables_scrollBody").css("min-height", "80px");
    }
    $('#' + tableId + ' tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row( tr );
 
        if ( row.child.isShown() ) {
            row.child.hide();
            tr.removeClass('shown');
        } else {
            row.child( formatDashboardTask(row.data()) ).show();
            tr.addClass('shown');
        }
    } );
}

/**
 * 
 * @param {type} d
 * @returns {undefined}
 * Formatting function for datatables detail tables
 */
function formatDashboardTask(rowData) {
    console.log(rowData);
    var parts = rowData.DT_RowId.split("¤");
    var taskId = parts[0];
    var div = $('<div/>')
        .addClass('loading')
        .text('Loading...');
    $.ajax({
        url: './ajax_pages/dashboard/new_dashboardTaskListDetails_ajax.php',
        data: {
            taskId: taskId
        },
        dataType:'json',
        success: function (json) {
            console.log(json.html);
            div.html(json.html)
            .removeClass('loading');
        }
    });
    return div;
}

function SelectRow(BeTable) {
    var table = $(BeTable).DataTable();
    $(BeTable + ' tbody').on('click', 'tr', function () {
        if ($(this).hasClass('selected')) {
            //$(this).removeClass('selected');
        } else {
            table.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    });
}

function GetSelectRow(BeTable) {
    table = $(BeTable).DataTable();
    var x = table.row('.selected').index();
    return x;
}

function SetSelectRow2(BeTable, BeRow) {
    var sor = $('#' + BeTable + ' tbody tr')[BeRow];
    sor.className = "selected";
    var table = $('#' + BeTable).DataTable();
    var valami = table.row().index();
    table.row().index(BeRow);
    selected_row = BeRow;
    selected_table = BeTable;
}

function SetSelectRow(BeTable, BeRow) {
    var sor = $('#PenztarIdoszakok tbody tr')[0];
    sor.className = "selected";
    var table = $('#PenztarIdoszakok').DataTable();
    var valami = table.row().index();
    // Select the first row in the table

    table.row().index(0);
    var valami = table.row().index();

    selected_row = BeRow;
    selected_table = BeTable;
}
