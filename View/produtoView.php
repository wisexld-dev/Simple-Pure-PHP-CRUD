<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Produtos</title>
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
            <h1 class="text-center">Lista de Produtos</h1>
            <div class="d-flex">
                <input class="form-control me-2" type="search" placeholder="Pesquisar" aria-label="Search">
                <button class="btn btn-outline-primary me-2" type="button">Pesquisar</button>
                <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#modalNovoProduto">
                    <i class="fas fa-plus"></i>
                </button>
            </div>
        </div>

        <!-- Tabela de Produtos -->
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Codigo</th>
                    <th scope="col">Descricao</th>
                    <th scope="col">Status</th>
                    <th scope="col">Tempo de Garantia</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($produtos as $produto) { ?>

                    <tr data-bs-toggle="modal" data-bs-target="#modalEditarProduto" data-produto-id="<?php echo $produto['id'] ?>" data-produto-codigo="<?php echo $produto['codigo'] ?>" data-produto-descricao="<?php echo $produto['descricao'] ?>" data-produto-status="<?php echo $produto['status'] ?>" data-produto-tempo_garantia=" <?php echo $produto['tempo_garantia'] !== null ? date("d/m/Y", strtotime($produto['tempo_garantia'])) : null ?>">
                        <th scope="row"><?php echo $produto['id'] ?></th>
                        <th scope="row"><?php echo $produto['codigo'] ?></th>
                        <td><?php echo $produto['descricao'] ?></td>
                        <td><?php echo $produto['status'] == 1 ? 'Ativo' : 'Inativo' ?></td>
                        <td><?php echo $produto['tempo_garantia'] !== null ? date("d/m/Y", strtotime($produto['tempo_garantia'])) : null ?></td>
                    </tr>

                <?php } ?>
            </tbody>
        </table>

        <!-- Modal Novo Produto -->
        <div class="modal fade" id="modalNovoProduto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Novo Produto</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formNovoProduto">
                            <div class="mb-3">
                                <label for="descricao" class="form-label">Descricao</label>
                                <input type="text" class="form-control" name="descricao" id="descricao" placeholder="Nome do Produto" required>
                                <div class="invalid-feedback">Por favor, informe a descricao do Produto.</div>
                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" name="status" id="status" required>
                                    <option value="true">Ativo</option>
                                    <option value="false">Inativo</option>
                                </select>
                                <div class="invalid-feedback">Por favor, selecione o status do produto.</div>
                            </div>
                            <div class="mb-3">
                                <label for="tempo_garantia" class="form-label">Tempo de Garantia</label>
                                <input type="text" class="form-control" name="tempo_garantia" id="tempo_garantia" placeholder="Tempo de Garantia do Produto">
                                <div class="invalid-feedback">Por favor, informe o tempo de garantia do Produto.</div>
                            </div>
                            <button type="button" id="btnSalvarNovoProduto" class="btn btn-primary">Salvar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Edição de Produto -->
        <div class="modal fade" id="modalEditarProduto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Editar Produto</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <input type="text" class="form-control" name="edit_id" id="edit_id" placeholder="Nome do Produto" hidden>
                            <div class="mb-3">
                                <label for="descricao" class="form-label">Código</label>
                                <input type="text" class="form-control" name="edit_codigo" id="edit_codigo" placeholder="Código do Produto" disabled>
                            </div>
                            <div class="mb-3">
                                <label for="descricao" class="form-label">Descricao</label>
                                <input type="text" class="form-control" name="edit_descricao" id="edit_descricao" placeholder="Nome do Produto" required>
                                <div class="invalid-feedback">Por favor, informe a descricao do Produto.</div>
                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" name="edit_status" id="edit_status" required>
                                    <option value="true">Ativo</option>
                                    <option value="false">Inativo</option>
                                </select>
                                <div class="invalid-feedback">Por favor, selecione o status do produto.</div>
                            </div>
                            <div class="mb-3">
                                <label for="tempo_garantia" class="form-label">Tempo de Garantia</label>
                                <input type="text" class="form-control" name="edit_tempo_garantia" id="edit_tempo_garantia" placeholder="Tempo de Garantia do Produto">
                                <div class="invalid-feedback">Por favor, informe o tempo de garantia do Produto.</div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button id="btnExcluir" type="button" class="btn btn-danger me-auto"><i class="fas fa-trash-alt"></i> Excluir</button>
                        <button id="btnCancelar" type="button" class="btn btn-secondary">Cancelar</button>
                        <button id="btnSalvar" type="button" class="btn btn-primary">Salvar alterações</button>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#tempo_garantia').datepicker({
                    format: 'dd/mm/yyyy', // Formato da data
                    autoclose: true, // Fecha o datepicker ao selecionar uma data
                    todayHighlight: true // Destaca o dia atual
                }).on('show.bs.modal', function(event) {
                    event.stopPropagation();
                });;

                $('#edit_tempo_garantia').datepicker({
                    format: 'dd/mm/yyyy', // Formato da data
                    autoclose: true, // Fecha o datepicker ao selecionar uma data
                    todayHighlight: true // Destaca o dia atual
                }).on('show.bs.modal', function(event) {
                    event.stopPropagation();
                });;
            });

            $(document).ready(function() {
                $('#modalEditarProduto').on('show.bs.modal', function(event) {
                    var button = $(event.relatedTarget);
                    var produtoId = button.data('produto-id');
                    var produtoCodigo = button.data('produto-codigo');
                    var produtoDescricao = button.data('produto-descricao');
                    var produtoStatus = button.data('produto-status');
                    var produtoTempoGarantia = button.data('produto-tempo_garantia');

                    var modal = $(this);
                    modal.find('#edit_id').val(produtoId);
                    modal.find('#edit_codigo').val(produtoCodigo);
                    modal.find('#edit_descricao').val(produtoDescricao);
                    modal.find('#edit_tempo_garantia').val(produtoTempoGarantia);

                    if (produtoStatus) {
                        modal.find('#edit_status').val('true');
                    } else {
                        modal.find('#edit_status').val('false');
                    }
                });

                // Salvar alteração produto
                $('#btnSalvar').on('click', async function() {
                    // Capturar dados do formulário
                    var produtoId = $('#edit_id').val();
                    var produtoCodigo = $('#edit_codigo').val();
                    var descricao = $('#edit_descricao').val();
                    var status = $('#edit_status').val();
                    var tempo_garantia = $('#edit_tempo_garantia').val();

                    // Enviar dados via AJAX
                    await $.ajax({
                        url: '/Controller/produtoController.php',
                        method: 'PUT',
                        data: JSON.stringify({
                            id: produtoId,
                            codigo: produtoCodigo,
                            descricao: descricao,
                            status: status,
                            tempo_garantia: tempo_garantia
                        }),
                        success: async function(response) {
                            console.log(response);

                            await Swal.fire({
                                icon: 'success',
                                title: 'Produto alterado com sucesso!',
                                showConfirmButton: true,
                                confirmButtonText: "Ok"
                            }).then((result => {
                                if (result.isConfirmed) {
                                    $('#modalEditarProduto').modal('hide');
                                    window.location = window.location.href;
                                }
                            }));
                        },
                        error: function(xhr, status, error) {
                            console.error(error);
                            alert('Erro ao alterar informações produto. Por favor, tente novamente.');
                        }
                    });
                });


                $('#btnExcluir').on('click', function() {
                    Swal.fire({
                        title: 'Tem certeza?',
                        text: 'Uma vez excluído, você não poderá recuperar este produto!',
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
                                url: '/Controller/produtoController.php',
                                method: 'DELETE',
                                data: JSON.stringify({
                                    id: $('#edit_id').val(),
                                }),
                                success: async function(response) {
                                    console.log(response);

                                    await Swal.fire({
                                        icon: 'success',
                                        title: 'Produto alterado com sucesso!',
                                        showConfirmButton: true,
                                        confirmButtonText: "Ok"
                                    }).then((result => {
                                        if (result.isConfirmed) {
                                            $('#modalEditarProduto').modal('hide');
                                            // Redirecionar o usuário para a próxima página
                                            window.location = window.location.href;
                                        }
                                    }));
                                },
                                error: function(xhr, status, error) {
                                    alert('Erro ao alterar informações produto. Por favor, tente novamente.');
                                }
                            });
                            Swal.fire(
                                'Excluído!',
                                'O produto foi excluído com sucesso.',
                                'success'
                            ).then(() => {
                                $('#modalEditarProduto').modal('hide');
                                // Atualize a tabela ou a interface do usuário conforme necessário
                            });
                        }
                    });
                });

                // Salvar novo Produto
                $('#btnSalvarNovoProduto').on('click', async function() {
                    // Capturar dados do formulário
                    var descricao = $('#descricao').val();
                    var status = $('#status').val();
                    var tempo_garantia = $('#tempo_garantia').val();

                    // Enviar dados via AJAX

                    await $.ajax({
                        url: '/Controller/produtoController.php',
                        method: 'POST',
                        data: {
                            descricao: descricao,
                            status: status,
                            tempo_garantia: tempo_garantia
                        },
                        success: async function(response) {
                            console.log(response);

                            // Exibir mensagem de sucesso com SweetAlert2
                            await Swal.fire({
                                icon: 'success',
                                title: 'Produto cadastrado com sucesso!',
                                showConfirmButton: true,
                                confirmButtonText: "OK"
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = window.location
                                    // Redirecionar ou fazer outra ação após confirmação
                                    //window.location.href = window.location // Recarregar a página, por exemplo
                                }
                            });
                        },
                        error: function(xhr, status, error) {
                            // Lidar com erros de requisição
                            console.error(error);
                            // Exibir mensagem de erro ao usuário
                            Swal.fire({
                                icon: 'error',
                                title: 'Erro ao cadastrar produto',
                                text: 'Por favor, tente novamente mais tarde.'
                            });
                        }
                    });
                });
            });

            // Adicionar evento de cancelar
            $('#btnCancelar').on('click', function() {
                $('#modalEditarProduto').modal('hide');
            });
        </script>

</body>

</html>