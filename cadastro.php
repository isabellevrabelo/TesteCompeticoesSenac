<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta name="description" content="Página de cadastro do festival viva">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Cadastro - Teste</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <header class="text-center mt-5">
        <h1 class="display-bold">Formulário de Cadastro</h1>
    </header>

    <main>
        <form action="backend/cadastro.php" class="form d-flex justify-content-center my-5" method="post">

        <fieldset>

            <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Nome Completo:</label>
                    <input type="text" class="form-control" id="exampleInputEmail1" name="nome" required placeholder="Digite o nome completo aqui.">
                </div>

                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Email:</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" name="email" required placeholder="Digite o email aqui.">
                </div>

                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Telefone:</label>
                    <input type="tel" class="form-control" id="exampleInputEmail1" name="telefone" required placeholder="Digite o número de telefone aqui.">
                </div>

                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Senha:</label>
                    <input type="password" class="form-control" id="exampleInputPassword1" name="senha" required placeholder="Digite a senha aqui.">
                </div>

                <div class="text-center d-flex flex-column align-items-center">
                    <button type="submit" class="btn btn-success w-25 my-3">Enviar</button>
                    <a href="index.php">Voltar.</a>
                </div>
                
            </fieldset>
        </form>
    </main>

    <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>