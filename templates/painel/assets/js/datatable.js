$(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();
    var url = $('table').attr('url');

    var penultimateItemName = $('.breadcrumb-item:nth-last-child(2)').text().trim();

    $.extend($.fn.dataTable.defaults, {
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.3/i18n/pt-BR.json'
        },
        initComplete: function (settings, json) {
            $('[tooltip="tooltip"]').tooltip( );
        }
    });


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
        ],
        dom: '<"row mb-3"<"col-md-6"l><"col-md-6"f>>' + // lengthMenu e filtro lado a lado
             '<"row"<"col-md-12"tr>>' + // tabela ocupando a linha inteira
             '<"row mt-3"<"col-md-12"B>>' + // botões ocupando a linha inteira, alinhados à direita
             '<"row"<"col-md-6"i><"col-md-6"p>>', // informações e paginação lado a lado
        buttons: [
            {
                extend: 'excelHtml5',
                text: 'Exportar para Excel',
                title: 'Usuários',
                exportOptions: {
                    columns: [1, 2, 3]
                }
            }
        ],
        lengthMenu: [ [10, 25, 50, 100], [10, 25, 50, 100] ], // Opções de tamanho de página
        pageLength: 10 // Tamanho de página padrão
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

        ],
        dom: '<"row mb-3"<"col-md-6"l><"col-md-6"f>>' + // lengthMenu e filtro lado a lado
             '<"row"<"col-md-12"tr>>' + // tabela ocupando a linha inteira
             '<"row mt-3"<"col-md-12"B>>' + // botões ocupando a linha inteira, alinhados à direita
             '<"row"<"col-md-6"i><"col-md-6"p>>', // informações e paginação lado a lado
        buttons: [
            {
                extend: 'excelHtml5',
                text: 'Exportar para Excel',
                title: 'Estoque', // Título específico para a exportação
                exportOptions: {
                    columns: [1, 2, 3],// Índices das colunas que serão exportadas (0 = primeira coluna, 1 = segunda coluna, etc.)            
                }
            },
            
        ],
        lengthMenu: [ [10, 25, 50, 100], [10, 25, 50, 100] ], // Opções de tamanho de página
        pageLength: 10 // Tamanho de página padrão
    });

    $('#tabelaMovimentacoes').DataTable({
        order: [[0, 'desc']],
        columnDefs: [
            {
                orderable: false,
                targets: [0]
            }

        ],
        dom: '<"row mb-3"<"col-md-6"l><"col-md-6"f>>' + // lengthMenu e filtro lado a lado
             '<"row"<"col-md-12"tr>>' + // tabela ocupando a linha inteira
             '<"row mt-3"<"col-md-12"B>>' + // botões ocupando a linha inteira, alinhados à direita
             '<"row"<"col-md-6"i><"col-md-6"p>>', // informações e paginação lado a lado
        buttons: [
            {
                extend: 'excelHtml5',
                text: 'Exportar para Excel',
                title: 'Movimentações de ' + penultimateItemName, // Título específico para a exportação
                exportOptions: {
                    columns: [1, 2, 3] // Índices das colunas que serão exportadas (0 = primeira coluna, 1 = segunda coluna, etc.)
                }
            },
            
        ],
        lengthMenu: [ [10, 25, 50, 100], [10, 25, 50, 100] ], // Opções de tamanho de página
        pageLength: 10 // Tamanho de página padrão
    });


    $('#tabelaTodasMovimentacoes').DataTable({
        order: [[0, 'desc']],
        columnDefs: [
            {
                orderable: false,
                targets: [0]
            }

        ],
        dom: '<"row mb-3"<"col-md-6"l><"col-md-6"f>>' + // lengthMenu e filtro lado a lado
             '<"row"<"col-md-12"tr>>' + // tabela ocupando a linha inteira
             '<"row mt-3"<"col-md-12"B>>' + // botões ocupando a linha inteira, alinhados à direita
             '<"row"<"col-md-6"i><"col-md-6"p>>', // informações e paginação lado a lado
        buttons: [
            {
                extend: 'excelHtml5',
                text: 'Exportar para Excel',
                title: 'Movimentações', // Título específico para a exportação
                exportOptions: {
                    columns: [1, 2, 3, 4] // Índices das colunas que serão exportadas (0 = primeira coluna, 1 = segunda coluna, etc.)
                }
            },
            
        ],
        lengthMenu: [ [10, 25, 50, 100], [10, 25, 50, 100] ], // Opções de tamanho de página
        pageLength: 10 // Tamanho de página padrão
    });



    $('#tabelaAcabando').DataTable({
        order: [[0, 'desc']],
        columnDefs: [
            {
                orderable: false,
                targets: [0]
            }
        ],
        dom: '<"row mb-3"<"col-md-6"l><"col-md-6"f>>' + // lengthMenu e filtro lado a lado
             '<"row"<"col-md-12"tr>>' + // tabela ocupando a linha inteira
             '<"row mt-3"<"col-md-12"B>>' + // botões ocupando a linha inteira, alinhados à direita
             '<"row"<"col-md-6"i><"col-md-6"p>>', // informações e paginação lado a lado
        buttons: [
            {
                extend: 'excelHtml5',
                text: 'Exportar para Excel',
                title: 'Itens Acabando', // Título específico para a exportação
                exportOptions: {
                    columns: [2, 3] // Índices das colunas que serão exportadas (0 = primeira coluna, 1 = segunda coluna, etc.)
                }
            },
            
        ],
        lengthMenu: [ [10, 25, 50, 100], [10, 25, 50, 100] ], // Opções de tamanho de página
        pageLength: 10 // Tamanho de página padrão
    });

    $('#tabelaEsgotados').DataTable({
        order: [[0, 'desc']],
        columnDefs: [
            {
                orderable: false,
                targets: [0]
            }
        ],
        dom: '<"row mb-3"<"col-md-6"l><"col-md-6"f>>' + // lengthMenu e filtro lado a lado
             '<"row"<"col-md-12"tr>>' + // tabela ocupando a linha inteira
             '<"row mt-3"<"col-md-12"B>>' + // botões ocupando a linha inteira, alinhados à direita
             '<"row"<"col-md-6"i><"col-md-6"p>>', // informações e paginação lado a lado
        buttons: [
            {
                extend: 'excelHtml5',
                text: 'Exportar para Excel',
                title: 'Itens Esgotados', // Título específico para a exportação
                exportOptions: {
                    columns: [2, 3] // Índices das colunas que serão exportadas (0 = primeira coluna, 1 = segunda coluna, etc.)
                }
            },
            
        ],
        lengthMenu: [ [10, 25, 50, 100], [10, 25, 50, 100] ], // Opções de tamanho de página
        pageLength: 10 // Tamanho de página padrão
    });


    

});







