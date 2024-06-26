$(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();
    var url = $('table').attr('url');

    $.extend($.fn.dataTable.defaults, {
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.3/i18n/pt-BR.json'
        },
        initComplete: function (settings, json) {
            $('[tooltip="tooltip"]').tooltip( );
        }
    });


    //TABELA USUÁRIOS
    $('#tabelaUsuarios').DataTable({
        order: [[0, 'desc']],
        columnDefs: [
            {
                className: 'dt-body-left',
                targets: []
            },
            {
                className: 'dt-center',
                targets: []
            },
            {
                orderable: false,
                targets: [-1]
            }

        ]
    });
    $('#tabelaItens').DataTable({
        order: [[0, 'desc']],
        columnDefs: [
            {
                className: 'dt-body-left',
                targets: []
            },
            {
                className: 'dt-center',
                targets: []
            },
            {
                orderable: false,
                targets: [-1, -5]
            }

        ]
    });

    $('#tabelaMovimentacoes').DataTable({
        order: [[0, 'desc']],
        columnDefs: [
            {
                orderable: false,
                targets: [0]
            }

        ]
    });
    $('#tabelaTodasMovimentacoes').DataTable({
        order: [[0, 'desc']],
        columnDefs: [
            {
                orderable: false,
                targets: [0]
            }

        ]
    });
    $('#tabelaAcabando').DataTable({
        order: [[0, 'desc']],
        columnDefs: [
            {
                orderable: false,
                targets: [0]
            }

        ]
    });


    

});







