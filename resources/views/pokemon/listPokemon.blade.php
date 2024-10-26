<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=ola mundo, initial-scale=1.0">
    <title>Pokédex</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

  <!-- Cabeçalho -->
  <header class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Pokédex</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
    </div>
  </header>
  <!-- Container principal -->
  <div class="container mt-5 mb-5 pt-5">
    <h1 class="mt-4">Pokémon</h1>
    <form method="GET" action="/api/pokemon/filter">
        @csrf
        <div class="row mb-5">
            <div class="col-md-4">
                <label for="type" class="form-label">Tipo</label>
                <input type="text" name="type" class="form-control" id="type" placeholder="Tipo">
            </div>
            <div class="col-md-4">
                <label for="habitat" class="form-label">Habitat</label>
                <input type="text" name="habitat" class="form-control" id="habitat" placeholder="Habitat">
            </div>
            <div class="col-md-4 mb-3">
                <label for="name" class="form-label">Nome</label>
                <input type="text" name="name" class="form-control" id="name" placeholder="Nome">
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary">Filtrar</button>
            </div>
        </div>
    </form>
    <table class="table table-striped">
      <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Nome</th>
          <th scope="col">Tipo</th>
          <th scope="col">Habitat</th>
          <th scope="col">Imagem</th>
          <th scope="col">Altura</th>
          <th scope="col">Peso</th>
        </tr>
      </thead>
      <tbody>
        <!-- Exemplo de dados de Pokémon -->
        @foreach ($dadosPokemon as $key=>$pokemon)
            <tr>
                <th scope="row">{{$pokemon['id']}}</th>
                <td>{{ucfirst($pokemon['name'])}}</td>
                <td>{{ucfirst($pokemon['types'])}}</td>
                <td>{{ucfirst($pokemon['habitat'])}}</td>
                <td>
                    <img src="{{ $pokemon['img'] }}"
                        class="img-thumbnail"
                        alt="Imagem de {{ $pokemon['name'] }}"
                        data-bs-toggle="modal"
                        data-bs-target="#exampleModal"
                        data-id="{{ $pokemon['id'] }}"
                        style="cursor: pointer;">
                </td>

                <td>{{$pokemon['height']}}</td>
                <td>{{$pokemon['weight']}}</td>
            </tr>
        @endforeach
        </tr>
        <!-- Mais Pokémon podem ser adicionados aqui -->
      </tbody>
    </table>
    <div class="pagination">
            @if($previousPageUrl)
                <a href="{{ url()->current() }}?page={{ $currentPage - 1 }}" class="btn btn-primary btn-sm me-2">Anterior</a>
            @endif

            @if($nextPageUrl)
                <a href="{{ url()->current() }}?page={{ $currentPage + 1 }}" class="btn btn-primary btn-sm">Próxima</a>
            @endif
        </div>
  </div>



<!-- Modal -->
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Detalhes do Pokémon</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <!-- O ID e outros detalhes do Pokémon serão preenchidos aqui -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
        <button type="button" class="btn btn-primary">Salvar alterações</button>
      </div>
    </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#exampleModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Captura a imagem que disparou o modal
        var id = button.data('id'); // Extrai o ID do atributo data-id

        var modal = $(this);
        modal.find('.modal-body').text('O ID do Pokémon é: ' + id); // Exibe o ID no modal
    });
});
</script>

</body>
  <!-- Rodapé -->
  <footer class="bg-primary text-white text-center py-3">
    <p>&copy; 2024 Pokédex. Todos os direitos reservados.</p>
  </footer>

</html>

<script>
$(document).ready(function() {
    $('#exampleModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); // Captura a imagem que disparou o modal
        var id = button.data('id'); // Extrai o ID do atributo data-id
        var modal = $(this);

        // Limpa o conteúdo do modal antes de fazer a nova consulta
        modal.find('.modal-body').text('Carregando...');

        // Faz a chamada à API
        $.ajax({
            url: '/api/pokemon/findDetailsPokemon/' + id,
            method: 'GET',
            success: function(data) {

                var pokemonData = JSON.parse(data);

                console.log(pokemonData.abilities[0]);
                // Atualiza o conteúdo do modal com os dados recebidos
                modal.find('.modal-body').html(`
                    <h5>${data.name}</h5>
                    <img src="${data.img}" alt="${data.name}" class="img-thumbnail">
                    <p>Tipo: ${data.type}</p>
                    <p>Altura: ${data.height}</p>
                    <p>Peso: ${data.weight}</p>
                `);
            },
            error: function() {
                modal.find('.modal-body').text('Erro ao carregar os dados do Pokémon.');
            }
        });
    });
});
</script>


