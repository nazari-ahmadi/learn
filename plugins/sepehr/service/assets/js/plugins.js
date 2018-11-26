
/* ==========================================================*/
/* PLUGINS                                                   */
/* ========================================================= */

/****  Tables Dynamic  ****/
function tableDynamic(){
    if ($('.table-dynamic').length && $.fn.dataTable) {
        $('.table-dynamic').each(function () {
            var opt = {};
            // Tools: export to Excel, CSV, PDF & Print
            if ($(this).hasClass('table-tools')) {
                opt.sDom = "<'row'<'col-md-6'f><'col-md-6'T>r>t<'row'<'col-md-6'i><'spcol-md-6an6'p>>",
                opt.oTableTools = {
                    "sSwfPath": "assets/plugins/datatables/swf/copy_csv_xls_pdf.swf",
                    "aButtons": ["print"]
                };
            }
            if ($(this).hasClass('no-header')) {
                opt.bFilter = false;
                opt.bLengthChange = false;
            }
            if ($(this).hasClass('no-footer')) {
                opt.bInfo = false;
                opt.bPaginate = false;
            }
            if ($(this).hasClass('filter-head')) {
                $('.filter-head thead th').each( function () {
                    var title = $('.filter-head thead th').eq($(this).index()).text();
                    $(this).append( '<input type="text" onclick="stopPropagation(event);" class="form-control" placeholder="Filter '+title+'" />' );
                });
                var table = $('.filter-head').DataTable();
                $(".filter-head thead input").on( 'keyup change', function () {
                    table.column( $(this).parent().index()+':visible').search( this.value ).draw();
                });
            } 
            if ($(this).hasClass('filter-footer')) {
                $('.filter-footer tfoot th').each( function () {
                    var title = $('.filter-footer thead th').eq($(this).index()).text();
                    $(this).html( '<input type="text" class="form-control" placeholder="Filter '+title+'" />' );
                });
                var table = $('.filter-footer').DataTable();
                $(".filter-footer tfoot input").on( 'keyup change', function () {
                    table.column( $(this).parent().index()+':visible').search( this.value ).draw();
                });
            } 
            if ($(this).hasClass('filter-select')) {
                $(this).DataTable( {
                    initComplete: function () {
                        var api = this.api();
             
                        api.columns().indexes().flatten().each( function ( i ) {
                            var column = api.column( i );
                            var select = $('<select class="form-control" data-placeholder="Select to filter"><option value=""></option></select>')
                                .appendTo( $(column.footer()).empty() )
                                .on( 'change', function () {
                                    var val = $(this).val();
             
                                    column
                                        .search( val ? '^'+val+'$' : '', true, false )
                                        .draw();
                                } );
             
                            column.data().unique().sort().each( function ( d, j ) {
                                select.append( '<option value="'+d+'">'+d+'</option>' )
                            } );
                        } );
                    }
                } );
            } 
            if (!$(this).hasClass('filter-head') && !$(this).hasClass('filter-footer') && !$(this).hasClass('filter-select'))  {
                var oTable = $(this).dataTable(opt);
                oTable.fnDraw();
            }
           
        });
    }
}

/* Popup Images */
function magnificPopup(){
    if ($('.magnific').length && $.fn.magnificPopup) {
        $('.magnific').magnificPopup({
            type:'image',
            gallery: {
                enabled: true
            },
            removalDelay: 300,
            mainClass: 'mfp-fade'
        });
    }
}

/****  Initiation of Main Functions  ****/
$(document).ready(function () {
    tableDynamic();
    magnificPopup();

        var oTable = $('#tableResult, #tableResult-1').dataTable({
            oLanguage: {
              sEmptyTable: "رکوردی یافت نشد",
              sInfo: "نمایش _START_ تا _END_ از _TOTAL_ رکورد",
              sInfoEmpty: "نمایش 0 - 0 از 0 رکورد",
              sInfoFiltered: "(فیلتر شده از _MAX_ رکورد)",
              sZeroRecords: "رکوردی یافت نشد",
            }
        });

        $('.dataTables_filter input').attr("placeholder", "جستجو...");          

});
