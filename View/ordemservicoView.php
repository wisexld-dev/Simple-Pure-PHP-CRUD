<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Ordem de Serviço</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

    <?php require_once("../Components/navbar.php"); ?>

    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="text-center">Ordens de Serviço</h1>
            <div class="d-flex">
                <input class="form-control me-2" type="search" placeholder="Pesquisar" aria-label="Search">
                <button class="btn btn-outline-primary me-2" type="button">Pesquisar</button>
                <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#modalNovaOS">
                    <i class="fas fa-plus"></i>
                </button>
            </div>
        </div>

        <!-- Tabela de Ordens -->
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col">Número da Ordem</th>
                    <th scope="col">Data Abertura</th>
                    <th scope="col">Nome Consumidor</th>
                    <th scope="col">CPF Consumidor</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($ordens as $ordemservico) {
                    $cpf = substr($ordemservico['cpf_consumidor'], 0, 3) . '.' . substr($ordemservico['cpf_consumidor'], 3, 3) . '.' . substr($ordemservico['cpf_consumidor'], 6, 3) . '-' . substr($ordemservico['cpf_consumidor'], 9, 2);
                ?>


                    <tr data-bs-toggle="modal" data-bs-target="#modalEditarOS" data-ordemservico-numero="<?php echo $ordemservico['numero_ordem'] ?>" data-ordemservico-data_abertura="<?php echo $ordemservico['data_abertura'] ?>" data-ordemservico-nome_consumidor="<?php echo $ordemservico['nome_consumidor'] ?>" data-ordemservico-cpf_consumidor=" <?php echo $ordemservico['cpf_consumidor'] ?>">
                        <th scope="row"><?php echo $ordemservico['numero_ordem'] ?></th>
                        <td><?php echo $ordemservico['data_abertura'] ?></td>
                        <td><?php echo $ordemservico['nome_consumidor'] ?></td>
                        <td><?php echo $cpf ?> </td>
                    </tr>

                <?php } ?>
            </tbody>
        </table>

        <!-- Modal Nova Ordem de Serviço -->
        <div class="modal fade" id="modalNovaOS" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Nova Ordem de Serviço</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formNovaOS">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="numero_os" class="form-label">Número O.S</label>
                                    <input type="text" class="form-control" name="numero_os" id="numero_os" placeholder="000000" required>
                                    <div class="invalid-feedback">Por favor, informe o número da Ordem de Serviço.</div>
                                </div>
                                <div class="col-md-6">
                                    <label for="data_abertura" class="form-label">Data Abertura</label>
                                    <input type="text" class="form-control" name="data_abertura" id="data_abertura" placeholder="Data de Abertura" required>
                                    <div class="invalid-feedback">Por favor, informe a data de abertura da Ordem de Serviço.</div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="nome_consumidor" class="form-label">Nome Consumidor</label>
                                <input type="text" class="form-control" name="nome_consumidor" id="nome_consumidor" placeholder="Nome do Consumidor" required>
                                <div class="invalid-feedback">Por favor, informe o nome do consumidor.</div>
                            </div>
                            <div class="mb-3">
                                <label for="cpf_consumidor" class="form-label">CPF Consumidor</label>
                                <input type="text" class="form-control" name="cpf_consumidor" id="cpf_consumidor" placeholder="CPF do Consumidor" required>
                                <div class="invalid-feedback">Por favor, informe o CPF do consumidor.</div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="produtos_disponiveis" class="form-label">Produtos Disponíveis</label>
                                    <select class="form-select produtos-disponiveis" id="produtos_disponiveis" multiple>
                                        <?php foreach ($produtos as $produto) { ?>
                                            <option value="<?php echo $produto['id'] ?>" class="produto-disponivel"><?php echo $produto['descricao'] ?></option>
                                        <?php } ?>
                                    </select>

                                    <div class="invalid-feedback">Selecione ao menos um produto para abrir a Ordem de Serviço.</div>
                                </div>
                                <div class="col-md-6">
                                    <label for="produtos_selecionados" class="form-label">Produtos Selecionados</label>
                                    <ul class="list-group" id="produtos_selecionados" name="produtos_selecionados"></ul>
                                </div>
                            </div>

                            <button type="button" id="btnSalvarNovaOS" class="btn btn-primary">Salvar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Edição de Ordem de Serviço -->
        <div class="modal fade" id="modalEditarOS" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Editar Ordem de Serviço</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formEditarOS">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="numero_os" class="form-label">Número O.S</label>
                                    <input type="text" class="form-control" name="edit_numero_os" id="edit_numero_os" placeholder="000000" disabled>
                                    <div class="invalid-feedback">Por favor, informe o número da Ordem de Serviço.</div>
                                </div>
                                <div class="col-md-6">
                                    <label for="data_abertura" class="form-label">Data Abertura</label>
                                    <input type="text" class="form-control" name="edit_data_abertura" id="edit_data_abertura" placeholder="Data de Abertura" required>
                                    <div class="invalid-feedback">Por favor, informe a data de abertura da Ordem de Serviço.</div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="edit_nome_consumidor" class="form-label">Nome Consumidor</label>
                                <input type="text" class="form-control" name="edit_nome_consumidor" id="edit_nome_consumidor" placeholder="Nome do Consumidor" disabled>
                                <div class="invalid-feedback">Por favor, informe o nome do consumidor.</div>
                            </div>
                            <div class="mb-3">
                                <label for="edit_cpf_consumidor" class="form-label">CPF Consumidor</label>
                                <input type="text" class="form-control" name="edit_cpf_consumidor" id="edit_cpf_consumidor" placeholder="CPF do Consumidor" disabled>
                                <div class="invalid-feedback">Por favor, informe o CPF do consumidor.</div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="edit_produtos_disponiveis" class="form-label">Produtos Disponíveis</label>
                                    <select class="form-select produtos-disponiveis" id="edit_produtos_disponiveis" multiple>
                                        <?php foreach ($produtos as $produto) { ?>
                                            <option value="<?php echo $produto['id'] ?>" class="produto-disponivel"><?php echo $produto['descricao'] ?></option>
                                        <?php } ?>
                                    </select>
                                    <div class="invalid-feedback">Selecione ao menos um produto para abrir a Ordem de Serviço.</div>
                                </div>
                                <div class="col-md-6">
                                    <label for="edit_produtos_selecionados" class="form-label">Produtos Selecionados</label>
                                    <ul class="list-group" id="edit_produtos_selecionados" name="edit_produtos_selecionados"></ul>
                                </div>
                            </div>

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button id="btnExcluir" type="button" class="btn btn-danger me-auto"><i class="fas fa-trash-alt"></i> Excluir</button>
                        <button id="btnCancelar" type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button id="btnSalvar" type="button" class="btn btn-primary">Salvar alterações</button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            $(document).ready(function() {
                $('#data_abertura').datepicker({
                    format: 'dd/mm/yyyy', // Formato da data
                    autoclose: true, // Fecha o datepicker ao selecionar uma data
                    todayHighlight: true // Destaca o dia atual
                }).on('show.bs.modal', function(event) {
                    event.stopPropagation();
                });;

                $('#data_abertura').datepicker({
                    format: 'dd/mm/yyyy', // Formato da data
                    autoclose: true, // Fecha o datepicker ao selecionar uma data
                    todayHighlight: true // Destaca o dia atual
                }).on('show.bs.modal', function(event) {
                    event.stopPropagation();
                });;

                // Máscara para o campo Data de Abertura
                $('#data_abertura').mask('00/00/0000');

                // Máscara para o campo CPF
                $('#cpf_consumidor').mask('000.000.000-00', {
                    reverse: true
                });

                // Máscara para o campo Número O.S
                $('#numero_os').mask('000000');
            });

            $(document).ready(function() {
                $('#modalEditarOS').on('show.bs.modal', async function(event) {
                    var button = $(event.relatedTarget);
                    var numeroOS = button.data('ordemservico-numero');

                    // Fazer requisição AJAX para obter os dados da ordem de serviço
                    await $.ajax({
                        url: '/Controller/ordemservicoController.php',
                        method: 'POST',
                        data: {
                            action: 'getProdutosOS',
                            numero_ordem: numeroOS
                        },
                        success: function(response) {
                            // Preencher os campos do formulário com os dados da ordem de serviço
                            $('#edit_numero_os').val(button.data('ordemservico-numero'));
                            $('#edit_data_abertura').val(button.data('ordemservico-data_abertura'));
                            $('#edit_nome_consumidor').val(button.data('ordemservico-nome_consumidor'));
                            $('#edit_cpf_consumidor').val(button.data('ordemservico-cpf_consumidor'));

                            // Limpar e preencher a lista de produtos selecionados com os produtos da ordem de serviço
                            var produtosSelecionadosList = $('#edit_produtos_selecionados');
                            produtosSelecionadosList.empty();
                            response.forEach(function(produto) {
                                produtosSelecionadosList.append('<li class="list-group-item product-item" data-product-id="' + produto.id_produto + '">' + produto.descricao + '</li>');

                                // Remover o produto da lista de disponíveis se estiver na lista de selecionados
                                $('#edit_produtos_disponiveis option[value="' + produto.id_produto + '"]').hide();
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error(error);
                            alert('Erro ao carregar informações da ordem de serviço. Por favor, tente novamente.');
                        }
                    });
                });

                $('#modalNovaOS').on('show.bs.modal', function(event) {
                    // Limpar a lista de produtos selecionados
                    $('#produtos_selecionados').empty();

                    // Mostrar todos os produtos disponíveis
                    $('#produtos_disponiveis option').show();
                });

                // Salvar alteração da ordem de serviço
                $('#btnSalvar').on('click', async function() {
                    // Capturar dados do formulário de edição
                    var numeroOS = $('#edit_numero_os').val();
                    var dataAbertura = $('#edit_data_abertura').val();
                    var nomeConsumidor = $('#edit_nome_consumidor').val();
                    var cpfConsumidor = $('#edit_cpf_consumidor').val();
                    var produtosSelecionados = [];

                    // Capturar produtos selecionados
                    $('#edit_produtos_selecionados .product-item').each(function() {
                        produtosSelecionados.push($(this).data('product-id'));
                    });

                    // Enviar dados via AJAX
                    await $.ajax({
                        url: '/Controller/ordemservicoController.php',
                        method: 'PUT',
                        data: JSON.stringify({
                            numero_os: numeroOS,
                            data_abertura: dataAbertura,
                            nome_consumidor: nomeConsumidor,
                            cpf_consumidor: cpfConsumidor,
                            produtos_selecionados: produtosSelecionados
                        }),
                        success: async function(response) {
                            console.log(response);

                            await Swal.fire({
                                icon: 'success',
                                title: 'Ordem de Serviço alterada com sucesso!',
                                showConfirmButton: true,
                                confirmButtonText: "Ok"
                            }).then((result => {
                                if (result.isConfirmed) {
                                    $('#modalEditarOS').modal('hide');
                                    window.location.href = window.location;
                                }
                            }));
                        },
                        error: function(xhr, status, error) {
                            console.error(error);
                            alert('Erro ao alterar informações da ordem de serviço. Por favor, tente novamente.');
                        }
                    });
                });


                $('#btnExcluir').on('click', function() {
                    Swal.fire({
                        title: 'Tem certeza?',
                        text: 'Uma vez excluído, você não poderá recuperar esta Ordem de Serviço !',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Excluir',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Enviar dados via AJAX
                            $.ajax({
                                url: '/Controller/ordemservicoController.php',
                                method: 'DELETE',
                                data: JSON.stringify({
                                    numero_ordem: $('#edit_numero_os').val(),
                                }),
                                success: async function(response) {
                                    console.log(response);

                                    await Swal.fire({
                                        icon: 'success',
                                        title: 'Ordem de Serviço alterado com sucesso!',
                                        showConfirmButton: true,
                                        confirmButtonText: "Ok"
                                    }).then((result => {
                                        if (result.isConfirmed) {
                                            $('#modalEditarOS').modal('hide');
                                            window.location = window.location.href;
                                        }
                                    }));
                                },
                                error: function(xhr, status, error) {
                                    alert('Erro ao alterar informações ordemservico. Por favor, tente novamente.');
                                }
                            });
                            Swal.fire(
                                'Excluído!',
                                'O ordemservico foi excluído com sucesso.',
                                'success'
                            ).then(() => {
                                $('#modalEditarOS').modal('hide');
                                // Atualize a tabela ou a interface do usuário conforme necessário
                            });
                        }
                    });
                });

                // Salvar novo Ordem de Serviço
                $('#btnSalvarNovaOS').on('click', async function() {
                    // Capturar dados do formulário
                    var numero_os = $('#numero_os').val();
                    var data_abertura = $('#data_abertura').val();
                    var nome_consumidor = $('#nome_consumidor').val();
                    var cpf_consumidor = $('#cpf_consumidor').val();

                    // Array para armazenar os IDs dos produtos selecionados
                    var produtosSelecionadosIds = [];

                    // Obtém os IDs dos produtos selecionados
                    $('#produtos_selecionados').find('.product-item').each(function() {
                        var productId = $(this).data('product-id');
                        produtosSelecionadosIds.push(productId);
                    });

                    // Enviar dados via AJAX
                    await $.ajax({
                        url: '/Controller/ordemservicoController.php',
                        method: 'POST',
                        data: {
                            numero_os: numero_os,
                            data_abertura: data_abertura,
                            nome_consumidor: nome_consumidor,
                            cpf_consumidor: cpf_consumidor,
                            produtosId: produtosSelecionadosIds
                        },
                        success: async function(response) {
                            await Swal.fire({
                                icon: 'success',
                                title: 'Ordem de Serviço cadastrado com sucesso!',
                                showConfirmButton: true,
                                confirmButtonText: "OK"
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = window.location;
                                }
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error(error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Erro ao cadastrar ordemservico',
                                text: 'Por favor, tente novamente mais tarde.'
                            });
                        }
                    });
                });

                function ordenarSelect(select) {
                    var options = select.find('option');
                    options.detach().sort(function(a, b) {
                        var aValue = $(a).val();
                        var bValue = $(b).val();
                        return aValue.localeCompare(bValue);
                    });
                    select.append(options);
                }

                $('#produtos_selecionados').on('click', '.product-item', function() {
                    var productId = $(this).data('product-id');
                    var productName = $(this).text();

                    // Remover o produto da lista de selecionados
                    $(this).remove();

                    // Mostrar o produto na lista de disponíveis
                    $('#produtos_disponiveis option[value="' + productId + '"]').show();
                });

                $('#produtos_disponiveis').on('click', 'option:selected', function() {
                    var productId = $(this).val();
                    var productName = $(this).text();

                    // Remover o produto da lista de disponíveis
                    $(this).hide();

                    // Adicionar o produto à lista de selecionados
                    $('#produtos_selecionados').append('<li class="list-group-item product-item" data-product-id="' + productId + '">' + productName + '</li>');
                });

                $('#edit_produtos_selecionados').on('click', '.product-item', function() {
                    var productId = $(this).data('product-id');
                    var productName = $(this).text();

                    // Remover o produto da lista de selecionados
                    $(this).remove();

                    // Mostrar o produto na lista de disponíveis
                    $('#edit_produtos_disponiveis option[value="' + productId + '"]').show();
                });

                $('#edit_produtos_disponiveis').on('click', 'option:selected', function() {
                    var productId = $(this).val();
                    var productName = $(this).text();

                    // Remover o produto da lista de disponíveis
                    $(this).hide();

                    // Adicionar o produto à lista de selecionados
                    $('#edit_produtos_selecionados').append('<li class="list-group-item product-item" data-product-id="' + productId + '">' + productName + '</li>');
                });


            });

            // Adicionar evento de cancelar
            $('#btnCancelar').on('click', function() {
                $('#modalEditarOS').modal('hide');
            });
        </script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
</body>

</html>