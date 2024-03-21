<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Clientes</title>
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
            <h1 class="text-center">Lista de Clientes</h1>
            <div class="d-flex">
                <input class="form-control me-2" type="search" placeholder="Pesquisar" aria-label="Search">
                <button class="btn btn-outline-primary me-2" type="button">Pesquisar</button>
                <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#modalNovoCliente">
                    <i class="fas fa-plus"></i>
                </button>
            </div>
        </div>

        <!-- Tabela de Clientes -->
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nome</th>
                    <th scope="col">CPF</th>
                    <th scope="col">Endereço</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($clientes as $cliente) { ?>

                    <tr data-bs-toggle="modal" data-bs-target="#modalEditarCliente" data-cliente-id="<?php echo $cliente['id'] ?>" data-cliente-nome="<?php echo $cliente['nome'] ?>" data-cliente-cpf="<?php echo $cliente['cpf'] ?>" data-cliente-endereco="<?php echo $cliente['endereco'] ?>">
                        <th scope="row"><?php echo $cliente['id'] ?></th>
                        <td><?php echo $cliente['nome'] ?></td>
                        <td><?php echo $cliente['cpf'] ?></td>
                        <td><?php echo $cliente['endereco'] ?></td>
                    </tr>

                <?php } ?>
            </tbody>
        </table>

        <!-- Modal Novo Cliente -->
        <div class="modal fade" id="modalNovoCliente" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Novo Cliente</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formNovoCliente">
                            <div class="mb-3">
                                <label for="nome" class="form-label">Nome</label>
                                <input type="text" class="form-control" name="nome" id="nome" placeholder="Nome do cliente" required>
                                <div class="invalid-feedback">Por favor, informe o nome do cliente.</div>
                            </div>
                            <div class="mb-3">
                                <label for="cpf" class="form-label">CPF</label>
                                <input type="text" class="form-control" name="cpf" id="cpf" placeholder="CPF do cliente" required>
                                <div class="invalid-feedback">Por favor, informe o CPF do cliente.</div>
                            </div>
                            <div class="mb-3">
                                <label for="endereco" class="form-label">Endereço</label>
                                <input type="text" class="form-control" name="endereco" id="endereco" placeholder="Endereço do cliente" required>
                                <div class="invalid-feedback">Por favor, informe o endereço do cliente.</div>
                            </div>
                            <button id="btnSalvarNovoCliente" class="btn btn-primary">Salvar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Edição de Cliente -->
        <div class="modal fade" id="modalEditarCliente" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Editar Cliente</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <input type="text" class="form-control" id="edit_id" hidden>
                            <div class="mb-3">
                                <label for="edit_nome" class="form-label">Nome</label>
                                <input type="text" class="form-control" id="edit_nome">
                            </div>
                            <div class="mb-3">
                                <label for="edit_cpf" class="form-label">CPF</label>
                                <input type="text" class="form-control" id="edit_cpf">
                            </div>
                            <div class="mb-3">
                                <label for="edit_endereco" class="form-label">Endereço</label>
                                <input type="text" class="form-control" id="edit_endereco">
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

        <script>
            $(document).ready(function() {
                $('#modalEditarCliente').on('show.bs.modal', function(event) {
                    var button = $(event.relatedTarget);
                    var clienteId = button.data('cliente-id');
                    var clienteNome = button.data('cliente-nome');
                    var clienteCPF = button.data('cliente-cpf');
                    var clienteEndereco = button.data('cliente-endereco');

                    var modal = $(this);
                    modal.find('#edit_id').val(clienteId);
                    modal.find('#edit_nome').val(clienteNome);
                    modal.find('#edit_cpf').val(clienteCPF);
                    modal.find('#edit_endereco').val(clienteEndereco);

                });

                // Salvar alteração cliente
                $('#btnSalvar').on('click', async function() {
                    // Capturar dados do formulário
                    var id = $('#edit_id').val();
                    var nome = $('#edit_nome').val();
                    var cpf = $('#edit_cpf').val();
                    var endereco = $('#edit_endereco').val();

                    // Enviar dados via AJAX
                    await $.ajax({
                        url: '/Controller/clienteController.php',
                        method: 'PUT',
                        data: JSON.stringify({
                            id: id,
                            nome: nome,
                            cpf: cpf,
                            endereco: endereco
                        }),
                        success: async function(response) {
                            console.log(response);

                            await Swal.fire({
                                icon: 'success',
                                title: 'Cliente alterado com sucesso!',
                                showConfirmButton: true,
                                confirmButtonText: "Ok"
                            }).then((result => {
                                if (result.isConfirmed) {
                                    $('#modalEditarCliente').modal('hide');
                                    // Redirecionar o usuário para a próxima página
                                    window.location = window.location.href;
                                }
                            }));
                        },
                        error: function(xhr, status, error) {
                            // Lidar com erros de requisição
                            console.error(error);
                            // Por exemplo, exibir uma mensagem de erro ao usuário
                            alert('Erro ao alterar informações cliente. Por favor, tente novamente.');
                        }
                    });
                });


                $('#btnExcluir').on('click', function() {
                    Swal.fire({
                        title: 'Tem certeza?',
                        text: 'Uma vez excluído, você não poderá recuperar este cliente!',
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
                                url: '/Controller/clienteController.php',
                                method: 'DELETE',
                                data: JSON.stringify({
                                    id: $('#edit_id').val(),
                                }),
                                success: async function(response) {
                                    console.log(response);

                                    await Swal.fire({
                                        icon: 'success',
                                        title: 'Cliente alterado com sucesso!',
                                        showConfirmButton: true,
                                        confirmButtonText: "Ok"
                                    }).then((result => {
                                        if (result.isConfirmed) {
                                            $('#modalEditarCliente').modal('hide');
                                            // Redirecionar o usuário para a próxima página
                                            window.location = window.location.href;
                                        }
                                    }));
                                },
                                error: function(xhr, status, error) {
                                    // Lidar com erros de requisição
                                    console.error(error);
                                    // Por exemplo, exibir uma mensagem de erro ao usuário
                                    alert('Erro ao alterar informações cliente. Por favor, tente novamente.');
                                }
                            });
                            Swal.fire(
                                'Excluído!',
                                'O cliente foi excluído com sucesso.',
                                'success'
                            ).then(() => {
                                $('#modalEditarCliente').modal('hide');
                                // Atualize a tabela ou a interface do usuário conforme necessário
                            });
                        }
                    });
                });
            });

            // Adicionar evento de cancelar
            $('#btnCancelar').on('click', function() {
                $('#modalEditarCliente').modal('hide');
            });


            // Salvar novo Cliente
            $('#btnSalvarNovoCliente').on('click', async function() {
                // Capturar dados do formulário
                var nome = $('#nome').val();
                var cpf = $('#cpf').val();
                var endereco = $('#endereco').val();

                // Enviar dados via AJAX
                await $.ajax({
                    url: '/Controller/clienteController.php',
                    method: 'POST',
                    data: {
                        nome: nome,
                        cpf: cpf,
                        endereco: endereco
                    },
                    success: async function(response) {
                        console.log(response);

                        await Swal.fire({
                            icon: 'success',
                            title: 'Cliente cadastrado com sucesso!',
                            showConfirmButton: true,
                            confirmButtonText: "Ok"
                        }).then((result => {
                            if (result.isConfirmed) {
                                // Redirecionar o usuário para a próxima página
                                window.location = window.location.href;
                            }
                        }));
                    },
                    error: function(xhr, status, error) {
                        // Lidar com erros de requisição
                        console.error(error);
                        // Por exemplo, exibir uma mensagem de erro ao usuário
                        alert('Erro ao salvar novo cliente. Por favor, tente novamente.');
                    }
                });
            });
        </script>

</body>

</html>